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

set_time_limit(0);

$return = 0;
$dir    = __DIR__ . DIRECTORY_SEPARATOR . 'zend';

if (!is_dir($dir)) {
    echo 'Installing Zend Framework 2...' . PHP_EOL;
    system(sprintf('git clone -q git://github.com/zendframework/zf2.git %s', escapeshellarg($dir)), $return);
} else {
    echo 'Updating Zend Framework 2...' . PHP_EOL;
    system(sprintf('cd %s && git fetch -q origin && git reset --hard origin/master', escapeshellarg($dir)), $return);
}

if ($return > 0) {
    exit($return);
}