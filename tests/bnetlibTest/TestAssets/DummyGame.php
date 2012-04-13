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

namespace bnetlibTest\TestAssets;

use bnetlib\AbstractGame;

class DummyGame extends AbstractGame
{
    protected $locale = array(
        'foo' => 'bar'
    );

    protected $resources = array(
        'StaticUrl' => array(
            'class'  => 'bnetlibTest\TestAssets\DummyResource',
            'config' => 'bnetlibTest\TestAssets\StaticUrlCfg'
        ),
        'StaticPath' => array(
            'class'  => 'bnetlibTest\TestAssets\DummyResource',
            'config' => 'bnetlibTest\TestAssets\StaticPathCfg'
        ),
        'DynamicUrl' => array(
            'class'  => 'bnetlibTest\TestAssets\DummyResource',
            'config' => 'bnetlibTest\TestAssets\DynamicUrlCfg'
        ),
        'DynamicPath' => array(
            'class'  => 'bnetlibTest\TestAssets\DummyResource',
            'config' => 'bnetlibTest\TestAssets\DynamicPathCfg'
        )
    );

    public function __getResourceArray($name)
    {
        return $this->resources[$name];
    }
}