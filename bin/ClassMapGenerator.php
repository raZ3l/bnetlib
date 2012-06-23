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

$max = 0;
$map = array();
$dir = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'bnetlib';

foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir)) as $item) {
    if (!$item->isFile() || $item->getExtension() !== 'php') {
        continue;
    }

    $fullname = $item->getRealPath();
    $relative = str_replace($dir, '', $fullname);

    $content   = file_get_contents($fullname);
    $tokens    = token_get_all($content);
    $namespace = '';
    $class     = '';

    foreach ($tokens as $i => $token) {
        if ($namespace !== '' && $class !== '') {
            break;
        }

        if (is_string($token)) {
            continue;
        }

        if ($token[0] === T_NAMESPACE) {
            while (($tkn = $tokens[++$i]) && is_array($tkn)) {
                if ($tkn[0] === T_STRING || $tkn[0] === T_NS_SEPARATOR) {
                    $namespace .= $tkn[1];
                }
            }
        } elseif ($token[0] === T_CLASS || $token[0] === T_INTERFACE) {
            while (($tkn = $tokens[++$i]) && is_array($tkn)) {
                if ($tkn[0] === T_STRING) {
                    $class = $tkn[1];
                } elseif ($class !== '' && $tkn[0] === T_WHITESPACE) {
                    break;
                }
            }
        }
    }

    if ($class === '') {
        continue;
    }

    if ($namespace === '') {
        echo sprintf('Error: No namespace declaration found in %s.', $relative);
        exit(2);
    }

    $fullclass       = sprintf('%s\\%s', ltrim($namespace, '\\'), ltrim($class, '\\'));
    $max             = max(strlen($fullclass) + 2, $max);
    $map[$fullclass] = str_replace(DIRECTORY_SEPARATOR, '/', $relative);
}

$classmap = var_export($map, true);
$classmap = str_replace('\\\\', '\\', $classmap);
$classmap = str_replace('array (', 'array(', $classmap);
$classmap = str_replace('=>', '=> __DIR__ .', $classmap);
$classmap = str_replace('  ', '    ', $classmap);
$classmap = preg_replace_callback(
    '/^(\s+)([^=]+)\s+=>/m',
    function ($match) use ($max) {
        return sprintf("%s%-{$max}s =>", $match[1], $match[2]);
    },
    $classmap
);

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
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */

return
EOD;

file_put_contents(dirname(__DIR__) . '/autoload_classmap.php', sprintf('%s %s;', $header, $classmap));
echo 'Wrote map to autoload_classmap.php' . PHP_EOL;

$max      = 0;
$services = array();
$file     = $dir . '/ServiceLocator/ServiceLocator.php';

foreach ($map as $class => $filename) {
    if (substr($class, 0, 17) !== 'bnetlib\Resource\\') {
        continue;
    }

    $service = $class;
    $service = str_replace('bnetlib\\resource\\', '', strtolower($service));
    $service = explode('\\', $service);

    if (in_array(end($service), array('configurationinterface', 'consumeinterface', 'entityinterface'))) {
        continue;
    }

    $reverse = array_reverse(array_slice($service, 0, 2));
    $slice   = array_slice($service, 2);
    $service = '';

    foreach (array($reverse, $slice) as $array) {
        $service .= ($service === '') ? '' : '.';
        $service .= implode('.', $array);
    }

    $max                = max(strlen($service) + 2, $max);
    $services[$service] = $class;
}

ksort($services);

$servicemap = var_export($services, true);
$servicemap = str_replace('array (', 'array(', $servicemap);
$servicemap = str_replace('  ', '        ', $servicemap);
$servicemap = str_replace('\\\\', '\\', $servicemap);
$servicemap = preg_replace_callback(
    '/^(\s+)([^=]+)\s+=>/m',
    function ($match) use ($max) {
        return sprintf("%s%-{$max}s =>", $match[1], $match[2]);
    },
    $servicemap
);
$servicemap = str_replace(')', '    )', $servicemap);

$content = file_get_contents($file);
$content = preg_replace(
    '/\$services\s=\sarray\(([^;]+)\)/m',
    sprintf('$services = %s', $servicemap),
    $content
);

file_put_contents($file, $content);
echo 'Wrote services to ServiceLocator/ServiceLocator.php' . PHP_EOL;