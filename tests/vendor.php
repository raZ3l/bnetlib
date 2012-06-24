#!/usr/bin/env php
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

set_time_limit(0);

$return  = 0;
$dir     = __DIR__ . '/vendor/';
$vendors = array(
    array('Aura HTTP Component', 'Aura/Http', 'git://github.com/auraphp/Aura.Http.git'),
    array('Buzz Library', 'Buzz', 'git://github.com/kriswallsmith/Buzz.git'),
//  array('CheddarGetter Library', 'CheddarGetter', 'git://github.com/marcguyer/cheddargetter-client-php.git'),
    array('Zend Framework 2', 'ZendFramework', 'git://github.com/zendframework/zf2.git'),
);


foreach ($vendors as $vendor) {
    $fullDir = $dir . $vendor[1];

    if (!is_dir($fullDir)) {
        printf('Installing %s...' . PHP_EOL, $vendor[0]);
        system(sprintf('git clone -q %s %s', $vendor[2], escapeshellarg($fullDir)), $return);
    } else {
        printf('Updating %s...' . PHP_EOL, $vendor[0]);
        system(sprintf('cd %s && git fetch -q origin && git reset --hard origin/master', escapeshellarg($fullDir)), $return);
    }

    if ($return > 0) {
        exit($return);
    }
}