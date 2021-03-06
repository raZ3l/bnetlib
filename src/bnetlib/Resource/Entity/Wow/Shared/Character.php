<?php
/**
 * This file is part of the bnetlib Library.
 * Copyright (c) 2012 Eric Boh <cossish@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code. You can also view the
 * LICENSE file online at http://coss.github.com/bnetlib/license.html
 *
 * @category   bnetlib
 * @package    Resource
 * @subpackage WorldOfWarcraft
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */

namespace bnetlib\Resource\Entity\Wow\Shared;

use bnetlib\Locale\LocaleInterface;
use bnetlib\Locale\LocaleAwareInterface;
use bnetlib\Resource\Entity\ConsumeInterface;
use bnetlib\Resource\Entity\EntityInterface;
use bnetlib\ServiceLocator\ServiceLocatorInterface;

/**
 * @category   bnetlib
 * @package    Resource
 * @subpackage WorldOfWarcraft
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */
class Character implements EntityInterface, ConsumeInterface, LocaleAwareInterface
{
    /**
     * @var array
     */
    protected $data = array();

    /**
     * @var LocaleInterface
     */
    protected $locale;

    /**
     * @var array|null
     */
    protected $headers;

    /**
     * @var ServiceLocatorInterface
     */
    protected $serviceLocator;

    /**
     * @inheritdoc
     */
    public function populate($data)
    {
        $ally = array(1, 3, 4, 7, 11, 22); // horde (2, 5, 6, 8, 9, 10)

        $this->data['name']    = $data['name'];
        $this->data['realm']   = $data['realm'];
        $this->data['race']    = $data['race'];
        $this->data['level']   = $data['level'];
        $this->data['class']   = $data['class'];
        $this->data['gender']  = $data['gender'];
        $this->data['avp']     = $data['achievementPoints'];
        $this->data['faction'] = (in_array($data['race'], $ally)) ? 0 : 1;
        $this->data['thumb']   = $data['thumbnail'];
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
    public function setResponseHeaders($headers)
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
    public function setLocale(LocaleInterface $locale)
    {
        $this->locale = $locale;

        return $this;
    }

    /**
     * @return string Character name
     */
    public function getName()
    {
        return $this->data['name'];
    }

    /**
     * @return string Realm name
     */
    public function getRealm()
    {
        return $this->data['realm'];
    }

    /**
     * @return string Full Thumbnail URI
     */
    public function getThumbnail()
    {
        return $this->data['thumb'];
    }

    /**
     * @return integer Character level
     */
    public function getLevel()
    {
        return $this->data['level'];
    }

    /**
     * @return integer Character class
     */
    public function getClass()
    {
        return $this->data['class'];
    }

    /**
     * @return integer Character race
     */
    public function getRace()
    {
        return $this->data['race'];
    }

    /**
     * @return integer Character gender
     */
    public function getGender()
    {
        return $this->data['gender'];
    }

    /**
     * @return integer Character faction. 0 = Alliance, 1 = Horde
     */
    public function getFaction()
    {
        return $this->data['faction'];
    }

    /**
     * @return integer Achievement points
     */
    public function getAchievementPoints()
    {
        return $this->data['avp'];
    }

    /**
     * @return string|null
     */
    public function getClassLocale()
    {
        if (isset($this->locale)) {
            return $this->locale->get(sprintf('class.%s', $this->data['class']), 'wow');
        }

        return null;
    }

    /**
     * @return string|null
     */
    public function getRaceLocale()
    {
        if (isset($this->locale)) {
            return $this->locale->get(sprintf('race.%s', $this->data['race']), 'wow');
        }

        return null;
    }

    /**
     * @return string|null
     */
    public function getGenderLocale()
    {
        if (isset($this->locale)) {
            return $this->locale->get(sprintf('gender.%s', $this->data['gender']), 'wow');
        }

        return null;
    }

    /**
     * @return string|null
     */
    public function getFactionLocale()
    {
        if (isset($this->locale)) {
            return $this->locale->get(sprintf('faction.%s', $this->data['faction']), 'wow');
        }

        return null;
    }

    /**
     * @return boolean
     */
    public function isMale()
    {
        return $this->data['gender'] === 0;
    }

    /**
     * @return boolean
     */
    public function isFemale()
    {
        return $this->data['gender'] === 1;
    }

    /**
     * @return boolean
     */
    public function isAlliance()
    {
        return $this->data['faction'] === 0;
    }

    /**
     * @return boolean
     */
    public function isHorde()
    {
        return $this->data['faction'] === 1;
    }

    /**
     * @return boolean
     */
    public function isHuman()
    {
        return $this->data['race'] === 1;
    }

    /**
     * @return boolean
     */
    public function isOrc()
    {
        return $this->data['race'] === 2;
    }

    /**
     * @return boolean
     */
    public function isDwarf()
    {
        return $this->data['race'] === 3;
    }

    /**
     * @return boolean
     */
    public function isNightElf()
    {
        return $this->data['race'] === 4;
    }

    /**
     * @return boolean
     */
    public function isUndead()
    {
        return $this->data['race'] === 5;
    }

    /**
     * @return boolean
     */
    public function isTauren()
    {
        return $this->data['race'] === 6;
    }

    /**
     * @return boolean
     */
    public function isGnome()
    {
        return $this->data['race'] === 7;
    }

    /**
     * @return boolean
     */
    public function isTroll()
    {
        return $this->data['race'] === 8;
    }

    /**
     * @return boolean
     */
    public function isGoblin()
    {
        return $this->data['race'] === 9;
    }

    /**
     * @return boolean
     */
    public function isBloodElf()
    {
        return $this->data['race'] === 10;
    }

    /**
     * @return boolean
     */
    public function isDraenei()
    {
        return $this->data['race'] === 11;
    }

    /**
     * @return boolean
     */
    public function isWorgen()
    {
        return $this->data['race'] === 22;
    }

    /**
     * @return boolean
     */
    public function isWarrior()
    {
        return $this->data['class'] === 1;
    }

    /**
     * @return boolean
     */
    public function isPaladin()
    {
        return $this->data['class'] === 2;
    }

    /**
     * @return boolean
     */
    public function isHunter()
    {
        return $this->data['class'] === 3;
    }

    /**
     * @return boolean
     */
    public function isRogue()
    {
        return $this->data['class'] === 4;
    }

    /**
     * @return boolean
     */
    public function isPriest()
    {
        return $this->data['class'] === 5;
    }

    /**
     * @return boolean
     */
    public function isDeathKnight()
    {
        return $this->data['class'] === 6;
    }

    /**
     * @return boolean
     */
    public function isShaman()
    {
        return $this->data['class'] === 7;
    }

    /**
     * @return boolean
     */
    public function isMage()
    {
        return $this->data['class'] === 8;
    }

    /**
     * @return boolean
     */
    public function isWarlock()
    {
        return $this->data['class'] === 9;
    }

    /**
     * @return boolean
     */
    public function isDruid()
    {
        return $this->data['class'] === 11;
    }

    /**
     * @inheritdoc
     */
    public function consume()
    {
        return array(
            'character' => $this->data['name'],
            'realm'     => $this->data['realm'],
            'thumbnail' => $this->data['thumb']
        );
    }
}