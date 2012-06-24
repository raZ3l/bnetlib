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

namespace bnetlibTest\TestAssets;

use bnetlib\ServiceLocator\ServiceLocator;

class FakeServiceLocator extends ServiceLocator
{
    protected $services = array(
        'test.assets.fakeresource' => 'bnetlibTest\TestAssets\FakeResource',
        'test.config.staticpath'   => 'bnetlibTest\TestAssets\StaticPath',
        'test.config.staticurl'    => 'bnetlibTest\TestAssets\StaticUrl',
        'test.config.dynamicpath'  => 'bnetlibTest\TestAssets\DynamicPath',
        'test.config.dynamicurl'   => 'bnetlibTest\TestAssets\DynamicUrl',
    );
}