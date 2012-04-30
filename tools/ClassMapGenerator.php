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

$map = array();
$dir = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'bnetlib';

foreach (new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir)) as $item) {
    $fullname = $item->getRealPath();
    $relative = str_replace($dir, '', $fullname);

    if (!$item->isFile() || $item->getExtension() !== 'php') {
        continue;
    }

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
    $map[$fullclass] = str_replace(DIRECTORY_SEPARATOR, 'DIRECTORY_SEPARATOR', $relative);
}

$classmap = var_export($map, true);
$classmap = str_replace('array (', 'array(', $classmap);
$classmap = str_replace('=>', '=> __DIR__ .', $classmap);
$classmap = str_replace('DIRECTORY_SEPARATOR', '\' . DIRECTORY_SEPARATOR . \'', $classmap);
$classmap = str_replace(' . \'\'', '', $classmap);

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

file_put_contents($dir . DIRECTORY_SEPARATOR . '_classmap.php', sprintf('%s %s;', $header, $classmap));