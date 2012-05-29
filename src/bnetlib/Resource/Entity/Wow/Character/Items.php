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

namespace bnetlib\Resource\Entity\Wow\Character;

use bnetlib\Resource\Entity\EntityInterface;
use bnetlib\ServiceLocator\ServiceLocatorInterface;

/**
 * @category   bnetlib
 * @package    Resource
 * @subpackage WorldOfWarcraft
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */
class Items implements EntityInterface, \Iterator
{
    /**
     * @var int
     */
    protected $position = 0;

    /**
     * @var array
     */
    protected $index = array();

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
        foreach ($data as $name => $value) {
            switch ($name) {
                case 'averageItemLevel':
                    $this->data['avgilvl'] = $value;
                    break;
                case 'averageItemLevelEquipped':
                    $this->data['avgilvle'] = $value;
                    break;
                default:
                    $this->index[]     = $name;
                    $this->data[$name] = $this->serviceLocator->get('wow.entity.character.item');
                    if (isset($this->headers)) {
                        $this->data[$name]->setResponseHeaders($this->headers);
                    }
                    $this->data[$name]->populate($value);
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
     * @inheritdoc
     */
    public function setServiceLocator(ServiceLocatorInterface $locator)
    {
        $this->serviceLocator = $locator;
    }

    /**
     * @return int
     */
    public function getAverageItemLevel()
    {
        return $this->data['avgilvl'];
    }

    /**
     * @return int
     */
    public function getAverageItemLevelEquipped()
    {
        return $this->data['avgilvle'];
    }

    /**
     * @return boolean
     */
    public function hasBack()
    {
        return isset($this->data['back']);
    }

    /**
     * @return bnetlib\Resource\Entity\Wow\Character\Item|null
     */
    public function getBack()
    {
        if (isset($this->data['back'])) {
            return $this->data['back'];
        }

        return null;
    }

    /**
     * @return boolean
     */
    public function hasChest()
    {
        return isset($this->data['chest']);
    }

    /**
     * @return bnetlib\Resource\Entity\Wow\Character\Item|null
     */
    public function getChest()
    {
        if (isset($this->data['chest'])) {
            return $this->data['chest'];
        }

        return null;
    }

    /**
     * @return boolean
     */
    public function hasFeet()
    {
        return isset($this->data['feet']);
    }

    /**
     * @return bnetlib\Resource\Entity\Wow\Character\Item|null
     */
    public function getFeet()
    {
        if (isset($this->data['feet'])) {
            return $this->data['feet'];
        }

        return null;
    }

    /**
     * @return boolean
     */
    public function hasFirstFinger()
    {
        return isset($this->data['finger1']);
    }

    /**
     * @return bnetlib\Resource\Entity\Wow\Character\Item|null
     */
    public function getFirstFinger()
    {
        if (isset($this->data['finger1'])) {
            return $this->data['finger1'];
        }

        return null;
    }

    /**
     * @return boolean
     */
    public function hasSecondFinger()
    {
        return isset($this->data['finger2']);
    }

    /**
     * @return bnetlib\Resource\Entity\Wow\Character\Item|null
     */
    public function getSecondFinger()
    {
        if (isset($this->data['finger2'])) {
            return $this->data['finger2'];
        }

        return null;
    }

    /**
     * @return boolean
     */
    public function hasHands()
    {
        return isset($this->data['hands']);
    }

    /**
     * @return bnetlib\Resource\Entity\Wow\Character\Item|null
     */
    public function getHands()
    {
        if (isset($this->data['hands'])) {
            return $this->data['hands'];
        }

        return null;
    }

    /**
     * @return boolean
     */
    public function hasHead()
    {
        return isset($this->data['head']);
    }

    /**
     * @return bnetlib\Resource\Entity\Wow\Character\Item|null
     */
    public function getHead()
    {
        if (isset($this->data['head'])) {
            return $this->data['head'];
        }

        return null;
    }

    /**
     * @return boolean
     */
    public function hasLegs()
    {
        return isset($this->data['legs']);
    }

    /**
     * @return bnetlib\Resource\Entity\Wow\Character\Item|null
     */
    public function getLegs()
    {
        if (isset($this->data['legs'])) {
            return $this->data['legs'];
        }

        return null;
    }

    /**
     * @return boolean
     */
    public function hasMainHand()
    {
        return isset($this->data['mainHand']);
    }

    /**
     * @return bnetlib\Resource\Entity\Wow\Character\Item|null
     */
    public function getMainHand()
    {
        if (isset($this->data['mainHand'])) {
            return $this->data['mainHand'];
        }

        return null;
    }

    /**
     * @return boolean
     */
    public function hasOffHand()
    {
        return isset($this->data['offHand']);
    }

    /**
     * @return bnetlib\Resource\Entity\Wow\Character\Item|null
     */
    public function getOffHand()
    {
        if (isset($this->data['offHand'])) {
            return $this->data['offHand'];
        }

        return null;
    }

    /**
     * @return boolean
     */
    public function hasNeck()
    {
        return isset($this->data['neck']);
    }

    /**
     * @return bnetlib\Resource\Entity\Wow\Character\Item|null
     */
    public function getNeck()
    {
        if (isset($this->data['neck'])) {
            return $this->data['neck'];
        }

        return null;
    }

    /**
     * @return boolean
     */
    public function hasRanged()
    {
        return isset($this->data['ranged']);
    }

    /**
     * @return bnetlib\Resource\Entity\Wow\Character\Item|null
     */
    public function getRanged()
    {
        if (isset($this->data['ranged'])) {
            return $this->data['ranged'];
        }

        return null;
    }

    /**
     * @return boolean
     */
    public function hasShirt()
    {
        return isset($this->data['shirt']);
    }

    /**
     * @return bnetlib\Resource\Entity\Wow\Character\Item|null
     */
    public function getShirt()
    {
        if (isset($this->data['shirt'])) {
            return $this->data['shirt'];
        }

        return null;
    }

    /**
     * @return boolean
     */
    public function hasShoulder()
    {
        return isset($this->data['shoulder']);
    }

    /**
     * @return bnetlib\Resource\Entity\Wow\Character\Item|null
     */
    public function getShoulder()
    {
        if (isset($this->data['shoulder'])) {
            return $this->data['shoulder'];
        }

        return null;
    }

    /**
     * @return boolean
     */
    public function hasTabard()
    {
        return isset($this->data['tabard']);
    }

    /**
     * @return bnetlib\Resource\Entity\Wow\Character\Item|null
     */
    public function getTabard()
    {
        if (isset($this->data['tabard'])) {
            return $this->data['tabard'];
        }

        return null;
    }

    /**
     * @return boolean
     */
    public function hasFirstTrinket()
    {
        return isset($this->data['trinket1']);
    }

    /**
     * @return bnetlib\Resource\Entity\Wow\Character\Item|null
     */
    public function getFirstTrinket()
    {
        if (isset($this->data['trinket1'])) {
            return $this->data['trinket1'];
        }

        return null;
    }

    /**
     * @return boolean
     */
    public function hasSecondTrinket()
    {
        return isset($this->data['trinket2']);
    }

    /**
     * @return bnetlib\Resource\Entity\Wow\Character\Item|null
     */
    public function getSecondTrinket()
    {
        if (isset($this->data['trinket2'])) {
            return $this->data['trinket2'];
        }

        return null;
    }

    /**
     * @return boolean
     */
    public function hasWaist()
    {
        return isset($this->data['waist']);
    }

    /**
     * @return bnetlib\Resource\Entity\Wow\Character\Item|null
     */
    public function getWaist()
    {
        if (isset($this->data['waist'])) {
            return $this->data['waist'];
        }

        return null;
    }

    /**
     * @return boolean
     */
    public function hasWrist()
    {
        return isset($this->data['wrist']);
    }

    /**
     * @return bnetlib\Resource\Entity\Wow\Character\Item|null
     */
    public function getWrist()
    {
        if (isset($this->data['wrist'])) {
            return $this->data['wrist'];
        }

        return null;
    }

    /**
     * @see \Iterator
     */
    public function rewind()
    {
        $this->position = 0;
    }

    /**
     * @see    \Iterator
     * @return bnetlib\Resource\Entity\Wow\Character\Item
     */
    public function current()
    {
        return $this->data[$this->index[$this->position]];
    }

    /**
     * @see    \Iterator
     * @return string
     */
    public function key()
    {
        return $this->index[$this->position];
    }

    /**
     * @see \Iterator
     */
    public function next()
    {
        ++$this->position;
    }

    /**
     * @see    \Iterator
     * @return boolean
     */
    public function valid()
    {
        return isset($this->index[$this->position]);
    }
}