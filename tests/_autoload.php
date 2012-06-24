<?php
/**
 * This file is part of the bnetlib Library.
 * Copyright (c) 2012 Eric Boh <cossish@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code. You can also view the
 * LICENSE file online at http://coss.github.com/bnetlib/license.html
 *
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */

spl_autoload_register(function ($class) {
    if (substr($class, 0, 7) !== 'bnetlib'
        && substr($class, 0, 4) !== 'Zend'
        && substr($class, 0, 4) !== 'Buzz'
        && substr($class, 0, 4) !== 'Aura') {
        return false;
    }

    $sgm = explode('\\', $class);
    $ns  = array_shift($sgm);
    $nsl = array(
        'Aura'          => __DIR__ . '/vendor/Aura/Http/src/Aura/',
    //  'CheddarGetter' => __DIR__ . '/vendor/CheddarGetter/',
        'Buzz'          => __DIR__ . '/vendor/Buzz/lib/Buzz/',
        'Zend'          => __DIR__ . '/vendor/ZendFramework/library/Zend/',
        'bnetlibTest'   => __DIR__ . '/bnetlibTest/',
        'bnetlib'       => dirname(__DIR__) . '/src/bnetlib/',
    );


    $file = (isset($nsl[$ns])) ? $nsl[$ns] : null;

    if ($file !== null) {
        $file .= implode('/', $sgm) . '.php';
        if (is_readable($file)) {
            return include $file;
        }
    }

    return false;
}, true, true);
