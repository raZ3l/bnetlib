<?php
/**
 * This file is part of the bnetlib Library.
 * Copyright (c) 2012 Eric Boh <cossish@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code. You can also view the
 * LICENSE file online at https://gitbub.com/coss/bnetlib/LISENCE
 *
 * @category   bnetlib
 * @package    Resource
 * @subpackage UnitTests
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */

namespace bnetlibTest\Resource\Config\Wow;

use bnetlibTest\Resource\Config\SharedConfigurationTest;
use bnetlib\Resource\Config\Wow\CharacterAchievements;

/**
 * @category   bnetlib
 * @package    Resource
 * @subpackage UnitTests
 * @group      Configuration
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */
class CharacterAchievementsTest extends SharedConfigurationTest
{
    /**
     * @var CharacterAchievements
     */
    protected $config;

    public function setUp()
    {
        $this->config = new CharacterAchievements();
    }

    public function tearDown()
    {
        unset($this->config);
    }
}