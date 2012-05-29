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

namespace bnetlib\Resource\Entity\Wow\Guild;

use bnetlib\Resource\Entity\ConsumeInterface;
use bnetlib\ServiceLocator\ServiceLocatorInterface;
/**
 * @category   bnetlib
 * @package    Resource
 * @subpackage WorldOfWarcraft
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */
class NewsEntry implements ConsumeInterface
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
     * @var bnetlib\ServiceLocator\ServiceLocatorInterface
     */
    protected $serviceLocator;

    /**
     * @inheritdoc
     */
    public function populate($data)
    {
        $this->data = $data;

        if (isset($data['achievement'])) {
            $this->data['achievement'] = $this->serviceLocator->get('wow.entity.achievements.dataachievement');
            if (isset($this->headers)) {
                $this->data['achievement']->setResponseHeaders($this->headers);
            }
            $this->data['achievement']->populate($data['achievement']);
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
     * @inheritdoc
     */
    public function setServiceLocator(ServiceLocatorInterface $locator)
    {
        $this->serviceLocator = $locator;
    }

    /**
     * @inheritdoc
     */
    public function consume()
    {
        $consume = array();

        if (isset($this->data['itemId'])) {
            $consume['itemid'] = $this->data['itemId'];
        }
        if (isset($this->data['character'])) {
            $consume['character'] = $this->data['character'];
        }

        return $consume;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->data['type'];
    }

    /**
     * @return int
     */
    public function getTimestamp()
    {
        return $this->data['timestamp'];
    }

    /**
     * @return bnetlib\Resource\Entity\Wow\Achievements\DataAchievement|null
     */
    public function getAchievement()
    {
        if (isset($this->data['achievement'])) {
            return $this->data['achievement'];
        }

        return null;
    }

    /**
     * @return string|null
     */
    public function getCharacter()
    {
        if (isset($this->data['character'])) {
            return $this->data['character'];
        }

        return null;
    }

    /**
     * @return int|null
     */
    public function getItemId()
    {
        if (isset($this->data['itemId'])) {
            return $this->data['itemId'];
        }

        return null;
    }

    /**
     * @return int|null
     */
    public function getLevelUp()
    {
        if (isset($this->data['levelUp'])) {
            return $this->data['levelUp'];
        }

        return null;
    }

    /**
     * @return boolean
     */
    public function isItemType()
    {
        return substr($this->data['type'], 0, 4) === 'item';
    }

    /**
     * @return boolean
     */
    public function isGuildType()
    {
        return substr($this->data['type'], 0, 5) === 'guild';
    }

    /**
     * @return boolean
     */
    public function isPlayerType()
    {
        return substr($this->data['type'], 0, 6) === 'player';
    }
}