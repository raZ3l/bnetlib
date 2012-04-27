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

namespace bnetlib\Resource\Wow\Character;

use bnetlib\Resource\ResourceInterface;

/**
 * @category   bnetlib
 * @package    Resource
 * @subpackage WorldOfWarcraft
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */
class Stats implements ResourceInterface
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
     * @return int
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
     * @return int
     */
    public function getPower()
    {
        return $this->data['power'];
    }

    /**
     * @return int
     */
    public function getStrength()
    {
        return $this->data['str'];
    }

    /**
     * @return int
     */
    public function getAgility()
    {
        return $this->data['agi'];
    }

    /**
     * @return int
     */
    public function getStamina()
    {
        return $this->data['sta'];
    }

    /**
     * @return int
     */
    public function getIntellect()
    {
        return $this->data['int'];
    }

    /**
     * @return int
     */
    public function getSpirit()
    {
        return $this->data['spr'];
    }

    /**
     * @return int
     */
    public function getAttackPower()
    {
        return $this->data['attackPower'];
    }

    /**
     * @return int
     */
    public function getRangedAttackPower()
    {
        return $this->data['rangedAttackPower'];
    }

    /**
     * @return int|float
     */
    public function getMastery()
    {
        return $this->data['mastery'];
    }

    /**
     * @return int
     */
    public function getMasteryRating()
    {
        return $this->data['masteryRating'];
    }

    /**
     * @return int|float
     */
    public function getCrit()
    {
        return $this->data['crit'];
    }

    /**
     * @return int
     */
    public function getCritRating()
    {
        return $this->data['critRating'];
    }

    /**
     * @return int|float
     */
    public function getHit()
    {
        return $this->data['hitPercent'];
    }

    /**
     * @return int
     */
    public function getHitRating()
    {
        return $this->data['hitRating'];
    }

    /**
     * @return int
     */
    public function getHasteRating()
    {
        return $this->data['hasteRating'];
    }

    /**
     * @return int
     */
    public function getExpertiseRating()
    {
        return $this->data['expertiseRating'];
    }

    /**
     * @return int
     */
    public function getSpellPower()
    {
        return $this->data['spellPower'];
    }

    /**
     * @return int
     */
    public function getSpellPenetration()
    {
        return $this->data['spellPen'];
    }

    /**
     * @return int|float
     */
    public function getSpellCrit()
    {
        return $this->data['spellCrit'];
    }

    /**
     * @return int
     */
    public function getSpellCritRating()
    {
        return $this->data['spellCritRating'];
    }

    /**
     * @return int|float
     */
    public function getSpellHit()
    {
        return $this->data['spellHitPercent'];
    }

    /**
     * @return int
     */
    public function getSpellHitRating()
    {
        return $this->data['spellHitRating'];
    }

    /**
     * @return int
     */
    public function getMpFive()
    {
        return $this->data['mana5'];
    }

    /**
     * @return int
     */
    public function getMpFiveInCombat()
    {
        return $this->data['mana5Combat'];
    }

    /**
     * @return int
     */
    public function getArmor()
    {
        return $this->data['armor'];
    }

    /**
     * @return int|float
     */
    public function getDodge()
    {
        return $this->data['dodge'];
    }

    /**
     * @return int
     */
    public function getDodgeRating()
    {
        return $this->data['dodgeRating'];
    }

    /**
     * @return int|float
     */
    public function getParry()
    {
        return $this->data['parry'];
    }

    /**
     * @return int
     */
    public function getParryRating()
    {
        return $this->data['parryRating'];
    }

    /**
     * @return int
     */
    public function getBlock()
    {
        return $this->data['block'];
    }

    /**
     * @return int
     */
    public function getBlockRating()
    {
        return $this->data['blockRating'];
    }

    /**
     * @return int
     */
    public function getResilience()
    {
        return $this->data['resil'];
    }

    /**
     * @return int
     */
    public function getMainHandDmgMin()
    {
        return $this->data['mainHandDmgMin'];
    }

    /**
     * @return int
     */
    public function getMainHandDmgMax()
    {
        return $this->data['mainHandDmgMax'];
    }

    /**
     * @return int|float
     */
    public function getMainHandSpeed()
    {
        return $this->data['mainHandSpeed'];
    }

    /**
     * @return int|float
     */
    public function getMainHandDps()
    {
        return $this->data['mainHandDps'];
    }

    /**
     * @return int
     */
    public function getMainHandExpertise()
    {
        return $this->data['mainHandExpertise'];
    }

    /**
     * @return int
     */
    public function getOffHandDmgMin()
    {
        return $this->data['offHandDmgMin'];
    }

    /**
     * @return int
     */
    public function getOffHandDmgMax()
    {
        return $this->data['offHandDmgMax'];
    }

    /**
     * @return int|float
     */
    public function getOffHandSpeed()
    {
        return $this->data['offHandSpeed'];
    }

    /**
     * @return int
     */
    public function getOffHandDps()
    {
        return $this->data['offHandDps'];
    }

    /**
     * @return int
     */
    public function getOffHandExpertise()
    {
        return $this->data['offHandExpertise'];
    }

    /**
     * @return int
     */
    public function getRangedDmgMin()
    {
        return $this->data['rangedDmgMin'];
    }

    /**
     * @return int
     */
    public function getRangedDmgMax()
    {
        return $this->data['rangedDmgMax'];
    }

    /**
     * @return int|float
     */
    public function getRangedSpeed()
    {
        return $this->data['rangedSpeed'];
    }

    /**
     * @return int|float
     */
    public function getRangedDps()
    {
        return $this->data['rangedDps'];
    }

    /**
     * @return int|float
     */
    public function getRangedCrit()
    {
        return $this->data['rangedCrit'];
    }

    /**
     * @return int
     */
    public function getRangedCritRating()
    {
        return $this->data['rangedCritRating'];
    }

    /**
     * @return int|float
     */
    public function getRangedHit()
    {
        return $this->data['rangedHitPercent'];
    }

    /**
     * @return int
     */
    public function getRangedHitRating()
    {
        return $this->data['rangedHitRating'];
    }
}