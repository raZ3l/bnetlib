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

spl_autoload_register(function ($class) {
    if (substr($class, 0, 7) !== 'bnetlib' && substr($class, 0, 4) !== 'Zend') {
        return false;
    }

    $sgm = explode('\\', $class);
    $ns  = array_shift($sgm);
    $nsl = array(
        'Zend'        => __DIR__ . DIRECTORY_SEPARATOR . 'Zend' . DIRECTORY_SEPARATOR,
        'bnetlibTest' => __DIR__ . DIRECTORY_SEPARATOR . 'bnetlibTest' . DIRECTORY_SEPARATOR,
        'bnetlib'     => dirname(__DIR__) . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR
                         . 'bnetlib' . DIRECTORY_SEPARATOR
    );


    $file = (isset($nsl[$ns])) ? $nsl[$ns] : null;

    if ($file !== null) {
        $file .= implode(DIRECTORY_SEPARATOR, $sgm) . '.php';
        if (is_readable($file)) {
            return include $file;
        }
    }

    return false;
}, true, true);
