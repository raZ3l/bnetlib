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

error_reporting(E_ALL | E_STRICT);

if (!is_readable(__DIR__ . DIRECTORY_SEPARATOR . 'LocaleConfig.php')) {
    die('Unable to load config file.');
}

if (!is_readable(dirname(__DIR__) . DIRECTORY_SEPARATOR . 'tests' . DIRECTORY_SEPARATOR . '_autoload.php')) {
    die('Unable to load autoloader.');
}

function requestResource($game, $method, $locale, $region) {
    try {
        $response = call_user_func_array(
            array($game, 'get' . $method),
            array(array(
                'locale' => $locale,
                'region' => $region
            ))
        );
    } catch (bnetlib\Exception\ResponseException $e) {
        echo $e->getMessage() . PHP_EOL;
        $code = ($e->getCode() === 0) ? 2 : $e->getCode();
        exit($code);
    }

    return $response['content'];
}

function createKeyValueList($config, $response) {
    $error = false;
    $return = array();

    if (!isset($response[$config['sub']])) {
        printf('Error: Wrong sub key %s.%s', $config['sub'], PHP_EOL);
        exit(3);
    }

    foreach ($response[$config['sub']] as $entry) {
        if (!isset($entry[$config['key']])) {
            $error = true;
            printf('Error: Missing key %s.%s', $config['key'], PHP_EOL);
        }
        if (!isset($entry[$config['value']])) {
            $error = true;
            printf('Error: Missing value key %s.%s', $config['value'], PHP_EOL);
        }
        if ($error === true) {
            exit(3);
        }

        $return[$entry[$config['key']]] = $entry[$config['value']];

    }

    return $return;
}

$config = include __DIR__ . DIRECTORY_SEPARATOR . 'LocaleConfig.php';
include dirname(__DIR__) . DIRECTORY_SEPARATOR . 'tests' . DIRECTORY_SEPARATOR . '_autoload.php';

$games      = array();
$output     = array();
$internal   = array();
$connection = new bnetlib\Connection();
$reflection = new ReflectionClass($connection);
$consts     = $reflection->getConstants();

echo 'Gather locales...' . PHP_EOL;
foreach ($config['games'] as $game => $class) {
    $games[$game] = new $class($connection);
    $games[$game]->setReturnType(bnetlib\AbstractGame::RETURN_PLAIN);
    $internal[$game]['locale']['_all']  = array();

    foreach ($consts as $const => $string) {
        if (substr($const, 0, 6) === 'REGION') {
            $internal[$game]['locale'][$string] = $games[$game]->getSupportedLocale($string);
            foreach ($internal[$game]['locale'][$string] as $locale) {
                $internal[$game]['locale']['_all'][$locale] = $string;
            }
        }
    }
}

echo 'Populate defaults...' . PHP_EOL;
foreach ($config['locale'] as $game => $locales) {
    if (isset($games[$game])) {
        if (isset($config['locale'][$game][$config['default_locale']])) {
            foreach ($config['locale'][$game][$config['default_locale']] as $key => $value) {
                echo '> ' . $game . ':' . $key . PHP_EOL;
                $internal[$game]['keys'][] = $key;
                if (is_string($value)) {
                    list($method, $keyvalue)   = explode('|', $value);
                    list($sub, $sKey, $sValue) = explode(':', $keyvalue);

                    $internal[$game]['dynamic'][$key] = array(
                        'sub'    => $sub,
                        'key'    => $sKey,
                        'value'  => $sValue,
                        'method' => $method,
                    );

                    $internal[$game]['default'][$key] = createKeyValueList(
                        $internal[$game]['dynamic'][$key],
                        requestResource(
                            $games[$game],
                            $method,
                            $config['default_locale'],
                            $internal[$game]['locale']['_all'][$config['default_locale']]
                        )
                    );
                } else {
                    $internal[$game]['default'][$key] = $value;
                }

                $output[$game][$config['default_locale']][$key] = $internal[$game]['default'][$key];
            }
        } else {
            printf('Error: Missing key (%s) in %s.%s', $config['default_locale'], $game, PHP_EOL);
            exit(1);
        }
    }
}

echo 'Populate locales...' . PHP_EOL;
foreach ($config['locale'] as $game => $locales) {
    if (isset($games[$game])) {
        echo '> ' . $game . PHP_EOL;
        foreach ($locales as $locale => $content) {
            if ($locale === '_all'
                || $locale === $config['default_locale']
                || !isset($internal[$game]['locale']['_all'][$locale])) {
                continue;
            }
            echo '   :' . $locale . PHP_EOL;
            foreach ($internal[$game]['keys'] as $rKey) {
                if (!isset($content[$rKey])) {
                    if (isset($internal[$game]['dynamic'][$rKey])) {
                        $output[$game][$locale][$rKey] = createKeyValueList(
                            $internal[$game]['dynamic'][$rKey],
                            requestResource(
                                $games[$game],
                                $internal[$game]['dynamic'][$rKey]['method'],
                                $locale,
                                $internal[$game]['locale']['_all'][$locale]
                            )
                        );
                    } else {
                         $output[$game][$locale][$rKey] = $internal[$game]['default'][$rKey];
                    }
                } else {
                    $output[$game][$locale][$rKey] = $content[$rKey];
                }
            }
        }
    }
}

$header = <<<'EOD'
<?php
/**
 * This file is part of the bnetlib Library.
 * Copyright (c) 2012 Eric Boh <cossish@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code. You can also view the
 * LICENSE file online at https://gitbub.com/coss/bnetlib/LISENCE
 *
 * @see        tools\LocaleGenerator.php
 *
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */

return
EOD;

echo 'Write to file...' . PHP_EOL;
foreach ($output as $game => $locales) {
    $path = sprintf($config['filepath'], DIRECTORY_SEPARATOR, $game, 'locale');
    $dirs = explode(DIRECTORY_SEPARATOR, $path);
    array_pop($dirs);
    $dir  = implode(DIRECTORY_SEPARATOR, $dirs);
    if (!is_dir($dir)) {
        mkdir($dir, 0777, true);
    }
    echo '> ' . $game . PHP_EOL;
    foreach ($locales as $locale => $content) {
        echo '   :' . $locale . PHP_EOL;
        $file = sprintf($config['filepath'], DIRECTORY_SEPARATOR, $game, $locale);
        file_put_contents($file, sprintf('%s %s;', $header, var_export($content, true)));
    }
}
