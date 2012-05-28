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

namespace bnetlibTest\TestAssets;

use bnetlib\AbstractGame;

class FakeGame extends AbstractGame
{
    const SHORT_NAME = 'test';

    protected $locale = array(
        'foo' => 'bar'
    );

    protected $resources = array(
        'StaticUrl'   => 'test.assets.fakeresource',
        'StaticPath'  => 'test.assets.fakeresource',
        'DynamicUrl'  => 'test.assets.fakeresource',
        'DynamicPath' => 'test.assets.fakeresource',
    );
}