#!/usr/bin/env php
<?php
/**
 * This file is part of the bnetlib Library.
 * Copyright (c) 2012 Eric Boh <cossish@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code. You can also view the
 * LICENSE file online at https://gitbub.com/coss/bnetlib/LISENCE
 *
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */

$useGzip = (isset($argv[1]) && in_array(ltrim($argv[1], '-'), array('gz', 'gzip', 'compress')));

if (!file_exists(__DIR__ . '/FixtureConfig.php')) {
    die('Unable to load config file.');
}

$config = include __DIR__ . '/FixtureConfig.php';

if ($useGzip === true) {
    if (!extension_loaded('zlib')) {
        echo 'Please enable zlib' . PHP_EOL;
        exit(1);
    }

    echo 'Compressing JSON files...' . PHP_EOL;

    foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($config['path'])) as $item) {
        if (!$item->isFile() || $item->getExtension() !== 'json') {
            continue;
        }

        printf('> gzip: %s' . PHP_EOL, $item->getFilename());

        $content  = json_decode(file_get_contents($item->getRealPath()), true);

        $gz = gzopen($item->getRealPath() . '.gz', 'w9');
        gzwrite($gz, json_encode($content));
        gzclose($gz);
    }

    exit();
}

if (!file_exists(dirname(__DIR__) . '/tests/_autoload.php')) {
    die('Unable to load autoloader.');
}

function requestResource($game, $method, $args) {
    return call_user_func_array(array($game, 'get' . $method), $args);
}

include dirname(__DIR__) . '/tests/_autoload.php';

$games       = array();
$output      = array();
$queue       = array();
$specialRes  = array();
$registry    = array();
$resourceMap = array();
$connection  = new bnetlib\Connection\ZendFramework();
$locator     = new bnetlib\ServiceLocator\ServiceLocator();
$defArgs     = (isset($config['config'])) ? $config['config'] : array();

$connection->setOptions($defArgs);

echo 'Create Game instances...' . PHP_EOL;
foreach ($config['games'] as $game => $class) {
    $output[$game] = array();
    $games[$game]  = new $class($connection, $locator);
    $games[$game]->setReturnType(bnetlib\AbstractGame::RETURN_PLAIN);

    $reflection         = new ReflectionClass($games[$game]);
    $resourceMap[$game] = $reflection->getProperty('resources');
    $resourceMap[$game]->setAccessible(true);
    $resourceMap[$game] = $resourceMap[$game]->getValue($games[$game]);
}

echo 'Create request queue...' . PHP_EOL . PHP_EOL;
foreach ($config['fixtures'] as $game => $requests) {
    if ($game === '_extend') {
        continue;
    }
    if (!isset($games[$game])) {
        continue;
    }

    $consumes          = array();
    $queue[$game]      = array();
    $specialRes[$game] = array();
    $registry[$game]   = array();

    foreach ($requests as $resource => $arguments) {
        if (is_string($arguments)) {
            $specialRes[$game][] = $arguments;
            $consumes[]          = array($resource, $arguments);
        } else {
            $queue[$game][] = array($resource, $arguments);
        }
    }

    foreach ($consumes as $value) {
        $queue[$game][] = $value;
    }
}


echo 'Request data...' . PHP_EOL;
foreach ($queue as $game => $requests) {
    if ($game === '_extend') {
        continue;
    }
    if (!isset($games[$game])) {
        echo $game . 'not found!' . PHP_EOL;
        continue;
    }
    foreach ($requests as $id => $job) {
        list($resource, $arguments) = $job;
        if ($arguments === null) {
            $arguments = array();
        }
        if (is_string($arguments)) {
            $arguments = $registry[$game][$arguments];
        }
        printf('> %s::get%s... ', get_class($games[$game]), $resource);
        try {
            $output[$game][$resource] = requestResource(
                $games[$game],
                $resource,
                array($arguments)
            );

            if (substr($output[$game][$resource]['headers']['Content-Type'], 0, 5) === 'image') {
                $output[$game][$resource]['content'] = 'base64,'
                                                       . base64_encode($output[$game][$resource]['content']);
            }

            if (in_array($resource, $specialRes[$game])) {
                $obj = $locator->get($resourceMap[$game][$resource]);
                $obj->populate($output[$game][$resource]['content']);

                $registry[$game][$resource] = $obj;
            }

            echo 'done!' . PHP_EOL;
        } catch (bnetlib\Exception\ExceptionInterface $e) {
            echo 'skipped!' . PHP_EOL;
            printf('>> %s' . PHP_EOL, $e->getMessage());
            continue;
        }
    }
}

if (isset($config['fixtures']['_extend'])) {
    echo PHP_EOL. 'Extend data...' . PHP_EOL;
    foreach ($config['fixtures']['_extend'] as $game => $list) {
        if (!isset($games[$game])) {
            echo $game . 'not found!' . PHP_EOL;
            continue;
        }

        foreach ($list as $i => $extend) {
            $error = false;
            if (!isset($extend['source'])) {
                $error = true;
                printf('> No source found in %s:%d' . PHP_EOL, $game, $i);
            } else {
                if (!isset($extend['source']['resource'])) {
                    $error = true;
                    printf('> No source resource found in %s:%d' . PHP_EOL, $game, $i);
                }
                if (!isset($extend['source']['arguments'])) {
                    $extend['source']['arguments'] = array();
                }
            }
            if (!isset($extend['target'])) {
                $error = true;
                printf('> No target found in %s:%d' . PHP_EOL, $game, $i);
            }
            if ($error) {
                continue;
            }

            printf('> %s::get%s... ', get_class($games[$game]), $extend['source']['resource']);
            try {
                $tmp = requestResource(
                    $games[$game],
                    $extend['source']['resource'],
                    array($extend['source']['arguments'])
                );

                if (!isset($tmp['content'][$extend['target']])) {
                    echo 'error, target not found!' . PHP_EOL;
                } else {
                    $output[$game][$extend['source']['resource']]['content'][$extend['target']] =
                        $tmp['content'][$extend['target']];
                    echo 'done!' . PHP_EOL;
                }
            } catch (bnetlib\Exception\ExceptionInterface $e) {
                echo 'skipped!' . PHP_EOL;
                printf('>> %s' . PHP_EOL, $e->getMessage());
                continue;
            }
        }
    }
}

echo PHP_EOL . 'Write to files...' . PHP_EOL;
foreach ($output as $game => $resources) {
    if (!is_dir($config['path'] . '/' . $game)) {
        mkdir($config['path'] . '/' . $game, 0777, true);
    }
    foreach ($resources as $resource => $content) {
        $file = sprintf('%s/%s/%s.json', $config['path'], $game, strtolower($resource));
        file_put_contents($file, json_encode($content, JSON_PRETTY_PRINT));
    }
}
