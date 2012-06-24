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

return function ($class) {
    static $classmap;

    if (!isset($classmap)) {
        $classmap = include __DIR__ . '/autoload_classmap.php';
    }

    if (isset($classmap[$class])) {
        return include $classmap[$class];
    }

    return false;
}