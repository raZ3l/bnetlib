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
    static $classmap;

    if (!isset($classmap)) {
        $classmap = include __DIR__ . DIRECTORY_SEPARATOR . '_classmap.php';
    }

    if (isset($classmap[$class])) {
        return include $classmap[$class];
    }

    return false;
});
