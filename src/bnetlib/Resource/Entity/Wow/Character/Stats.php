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
class Stats implements EntityInterface
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
     * @var ServiceLocatorInterface
     */
    protected $serviceLocator;

    /**
     * @inheritdoc
     */
    public function populate($data)
    {
        $this->data = $data;
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
     * @return integer
     */
    public function getHealth()
    {
        return $this->data['health'];
    }

    /**
     * @return string
     */
    public function getPowerType()
    {
        return $this->data['powerType'];
    }

    /**
     * @return integer
     */
    public function getPower()
    {
        return $this->data['power'];
    }

    /**
     * @return integer
     */
    public function getStrength()
    {
        return $this->data['str'];
    }

    /**
     * @return integer
     */
    public function getAgility()
    {
        return $this->data['agi'];
    }

    /**
     * @return integer
     */
    public function getStamina()
    {
        return $this->data['sta'];
    }

    /**
     * @return integer
     */
    public function getIntellect()
    {
        return $this->data['integer'];
    }

    /**
     * @return integer
     */
    public function getSpirit()
    {
        return $this->data['spr'];
    }

    /**
     * @return integer
     */
    public function getAttackPower()
    {
        return $this->data['attackPower'];
    }

    /**
     * @return integer
     */
    public function getRangedAttackPower()
    {
        return $this->data['rangedAttackPower'];
    }

    /**
     * @return integer|float
     */
    public function getMastery()
    {
        return $this->data['mastery'];
    }

    /**
     * @return integer
     */
    public function getMasteryRating()
    {
        return $this->data['masteryRating'];
    }

    /**
     * @return integer|float
     */
    public function getCrit()
    {
        return $this->data['crit'];
    }

    /**
     * @return integer
     */
    public function getCritRating()
    {
        return $this->data['critRating'];
    }

    /**
     * @return integer|float
     */
    public function getHit()
    {
        return $this->data['hitPercent'];
    }

    /**
     * @return integer
     */
    public function getHitRating()
    {
        return $this->data['hitRating'];
    }

    /**
     * @return integer
     */
    public function getHasteRating()
    {
        return $this->data['hasteRating'];
    }

    /**
     * @return integer
     */
    public function getExpertiseRating()
    {
        return $this->data['expertiseRating'];
    }

    /**
     * @return integer
     */
    public function getSpellPower()
    {
        return $this->data['spellPower'];
    }

    /**
     * @return integer
     */
    public function getSpellPenetration()
    {
        return $this->data['spellPen'];
    }

    /**
     * @return integer|float
     */
    public function getSpellCrit()
    {
        return $this->data['spellCrit'];
    }

    /**
     * @return integer
     */
    public function getSpellCritRating()
    {
        return $this->data['spellCritRating'];
    }

    /**
     * @return integer|float
     */
    public function getSpellHit()
    {
        return $this->data['spellHitPercent'];
    }

    /**
     * @return integer
     */
    public function getSpellHitRating()
    {
        return $this->data['spellHitRating'];
    }

    /**
     * @return integer
     */
    public function getMpFive()
    {
        return $this->data['mana5'];
    }

    /**
     * @return integer
     */
    public function getMpFiveInCombat()
    {
        return $this->data['mana5Combat'];
    }

    /**
     * @return integer
     */
    public function getArmor()
    {
        return $this->data['armor'];
    }

    /**
     * @return integer|float
     */
    public function getDodge()
    {
        return $this->data['dodge'];
    }

    /**
     * @return integer
     */
    public function getDodgeRating()
    {
        return $this->data['dodgeRating'];
    }

    /**
     * @return integer|float
     */
    public function getParry()
    {
        return $this->data['parry'];
    }

    /**
     * @return integer
     */
    public function getParryRating()
    {
        return $this->data['parryRating'];
    }

    /**
     * @return integer
     */
    public function getBlock()
    {
        return $this->data['block'];
    }

    /**
     * @return integer
     */
    public function getBlockRating()
    {
        return $this->data['blockRating'];
    }

    /**
     * @return integer
     */
    public function getResilience()
    {
        return $this->data['resil'];
    }

    /**
     * @return integer
     */
    public function getMainHandDmgMin()
    {
        return $this->data['mainHandDmgMin'];
    }

    /**
     * @return integer
     */
    public function getMainHandDmgMax()
    {
        return $this->data['mainHandDmgMax'];
    }

    /**
     * @return integer|float
     */
    public function getMainHandSpeed()
    {
        return $this->data['mainHandSpeed'];
    }

    /**
     * @return integer|float
     */
    public function getMainHandDps()
    {
        return $this->data['mainHandDps'];
    }

    /**
     * @return integer
     */
    public function getMainHandExpertise()
    {
        return $this->data['mainHandExpertise'];
    }

    /**
     * @return integer
     */
    public function getOffHandDmgMin()
    {
        return $this->data['offHandDmgMin'];
    }

    /**
     * @return integer
     */
    public function getOffHandDmgMax()
    {
        return $this->data['offHandDmgMax'];
    }

    /**
     * @return integer|float
     */
    public function getOffHandSpeed()
    {
        return $this->data['offHandSpeed'];
    }

    /**
     * @return integer
     */
    public function getOffHandDps()
    {
        return $this->data['offHandDps'];
    }

    /**
     * @return integer
     */
    public function getOffHandExpertise()
    {
        return $this->data['offHandExpertise'];
    }

    /**
     * @return integer
     */
    public function getRangedDmgMin()
    {
        return $this->data['rangedDmgMin'];
    }

    /**
     * @return integer
     */
    public function getRangedDmgMax()
    {
        return $this->data['rangedDmgMax'];
    }

    /**
     * @return integer|float
     */
    public function getRangedSpeed()
    {
        return $this->data['rangedSpeed'];
    }

    /**
     * @return integer|float
     */
    public function getRangedDps()
    {
        return $this->data['rangedDps'];
    }

    /**
     * @return integer|float
     */
    public function getRangedCrit()
    {
        return $this->data['rangedCrit'];
    }

    /**
     * @return integer
     */
    public function getRangedCritRating()
    {
        return $this->data['rangedCritRating'];
    }

    /**
     * @return integer|float
     */
    public function getRangedHit()
    {
        return $this->data['rangedHitPercent'];
    }

    /**
     * @return integer
     */
    public function getRangedHitRating()
    {
        return $this->data['rangedHitRating'];
    }
}