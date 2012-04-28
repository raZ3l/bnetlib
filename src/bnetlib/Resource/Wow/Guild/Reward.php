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
 * @subpackage WorldOfWarcraft
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */

namespace bnetlib\Resource\Wow\Guild;

use bnetlib\Resource\ResourceInterface;
use bnetlib\Resource\Wow\Shared\ListData;
use bnetlib\Resource\Wow\Achievements\Achievement;
use bnetlib\Resource\Wow\Item\Reward as ItemReward;

/**
 * @category   bnetlib
 * @package    Resource
 * @subpackage WorldOfWarcraft
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */
class Reward implements ResourceInterface
{
    /**
     * @var array
     */
    protected $data = array();

    /**
     * @var \stdClass|null
     */
    protected $headers;

    /**
     * @inheritdoc
     */
    public function populate(array $data)
    {
        foreach ($data as $key => $value) {
            switch ($key) {
                case 'races':
                    $this->data['races'] = new ListData();
                    if (isset($this->headers)) {
                        $this->data['races']->setResponseHeaders($this->headers);
                    }
                    $this->data['races']->populate($value);
                    break;
                case 'achievement':
                    $this->data['achievement'] = new Achievement();
                    if (isset($this->headers)) {
                        $this->data['achievement']->setResponseHeaders($this->headers);
                    }
                    $this->data['achievement']->populate($value);
                    break;
                case 'item':
                    $this->data['item'] = new ItemReward();
                    if (isset($this->headers)) {
                        $this->data['item']->setResponseHeaders($this->headers);
                    }
                    $this->data['item']->populate($value);
                    break;
                default:
                    $this->data[$key] = $value;
                    break;
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function getResponseHeaders()
    {
        return $this->headers;
    }

    /**
     * @inheritdoc
     */
    public function setResponseHeaders(\stdClass $headers)
    {
        $this->headers = $headers;
    }

    /**
     * @return int
     */
    public function getMinGuildLevel()
    {
        return $this->data['minGuildLevel'];
    }

    /**
     * @return int
     */
    public function getMinGuildStanding()
    {
        return $this->data['minGuildRepLevel'];
    }

    /**
     * @return bnetlib\Resource\Wow\Shared\ListData
     */
    public function getRaces()
    {
        return $this->data['races'];
    }

    /**
     * @return bnetlib\Resource\Wow\Item\Reward
     */
    public function getItem()
    {
        return $this->data['item'];
    }

    /**
     * @return bnetlib\Resource\Wow\Achievements\Achievement
     */
    public function geAchievement()
    {
        return $this->data['achievement'];
    }
}