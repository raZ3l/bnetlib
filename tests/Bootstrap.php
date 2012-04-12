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
 * @license    https://gitbub.com/coss/bnetlib/LISENCE     MIT License
 */

error_reporting(E_ALL | E_STRICT);

include __DIR__ . '/_autoload.php';

if (is_readable(__DIR__ . DIRECTORY_SEPARATOR . 'TestConfiguration.php')) {
    include __DIR__ . DIRECTORY_SEPARATOR . 'TestConfiguration.php';
} else {
    include __DIR__ . DIRECTORY_SEPARATOR . 'TestConfiguration.php.dist';
}