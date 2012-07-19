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

namespace bnetlib\Resource\Entity\Wow;

use bnetlib\Resource\Entity\Wow\Shared\Item as BaseItem;

/**
 * @category   bnetlib
 * @package    Resource
 * @subpackage WorldOfWarcraft
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */
class Item extends BaseItem
{
    /**
     * @var array
     */
    protected $keys = array(
        'itemSet'          => 'wow.entity.itemset',
        'itemSpells'       => 'wow.entity.item.spells',
        'allowableRaces'   => 'shared.entity.listdata',
        'allowableClasses' => 'shared.entity.listdata',
        'bonusStats'       => 'wow.entity.item.bonusstats',
        'weaponInfo'       => 'wow.entity.item.weaponinfo',
        'socketInfo'       => 'wow.entity.item.socketinfo',
    );

    /**
     * @inheritdoc
     */
    public function populate($data)
    {
        $this->data =  $data;

        foreach ($this->keys as $key => $service) {
            if (isset($data[$key])) {
                $this->data[$key] = $this->serviceLocator->get($service);
                if (isset($this->headers)) {
                    $this->data[$key]->setResponseHeaders($this->headers);
                }
                $this->data[$key]->populate($data[$key]);
            }
        }
    }

    /**
     * @return string
     */
    public function getDisenchantingSkillRank()
    {
        return $this->data['disenchantingSkillRank'];
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->data['description'];
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->data['name'];
    }

    /**
     * @return integer
     */
    public function getStacksize()
    {
        return $this->data['stackable'];
    }

    /**
     * @return boolean
     */
    public function isStackable()
    {
        return $this->data['stackable'] > 1;
    }

    /**
     * @return integer
     */
    public function getItemBind()
    {
        return $this->data['itemBind'];
    }

    /**
     * @return boolean
     */
    public function hasClassRestriction()
    {
        return isset($this->data['allowableClasses']);
    }

    /**
     * @return Shared\ListData|null
     */
    public function getAllowableClasses()
    {
        if (isset($this->data['allowableClasses'])) {
            return $this->data['allowableClasses'];
        }

        return null;
    }

    /**
     * @return boolean
     */
    public function hasRaceRestriction()
    {
        return isset($this->data['allowableRaces']);
    }

    /**
     * @return Shared\ListData|null
     */
    public function getAllowableRacees()
    {
        if (isset($this->data['allowableRaces'])) {
            return $this->data['allowableRaces'];
        }

        return null;
    }

    /**
     * @return boolean
     */
    public function isBindable()
    {
        return $this->data['itemBind'] > 0;
    }

    /**
     * Item "Binds when picked up" or "Binds to Battle.net account".
     *
     * @return boolean
     */
    public function isBoundOnPickUp()
    {
        return $this->data['itemBind'] === 1;
    }

    /**
     * @return boolean
     */
    public function isBoundOnEquip()
    {
        return $this->data['itemBind'] === 2;
    }

    /**
     * @return boolean
     */
    public function isBoundOnUse()
    {
        return $this->data['itemBind'] === 3;
    }

    /**
     * @return boolean
     */
    public function hasBonusStats()
    {
        return isset($this->data['bonusStats']);
    }

    /**
     * @return Item\BonusStats|null
     */
    public function getBonusStats()
    {
        if (isset($this->data['bonusStats'])) {
            return $this->data['bonusStats'];
        }

        return null;
    }

    /**
     * @return boolean
     */
    public function hasItemSpells()
    {
        return !empty($this->data['itemSpells']);
    }

    /**
     * @return Item\Spells|null
     */
    public function getItemSpells()
    {
        if (!empty($this->data['itemSpells'])) {
            return $this->data['itemSpells'];
        }

        return null;
    }

    /**
     * @return integer
     */
    public function getBuyPrice()
    {
        return $this->data['buyPrice'];
    }

    /**
     * @return integer
     */
    public function getItemClass()
    {
        return $this->data['itemClass'];
    }

    /**
     * @return integer
     */
    public function getItemSubClass()
    {
        return $this->data['itemSubClass'];
    }

    /**
     * @return integer
     */
    public function getContainerSlots()
    {
        return $this->data['containerSlots'];
    }

    /**
     * @return boolean
     */
    public function hasWeaponInfo()
    {
        return isset($this->data['weaponInfo']);
    }

    /**
     * @return Item\WeaponInfo|null
     */
    public function getWeaponInfo()
    {
        if (isset($this->data['weaponInfo'])) {
            return $this->data['weaponInfo'];
        }

        return null;
    }

    /**
     * @return integer
     */
    public function getInventoryType()
    {
        return $this->data['inventoryType'];
    }

    /**
     * @return boolean
     */
    public function isEquippable()
    {
        return $this->data['equippable'];
    }

    /**
     * @return integer
     */
    public function getItemLevel()
    {
        return $this->data['itemLevel'];
    }

    /**
     * @return ItemSet
     */
    public function getItemSet()
    {
        return $this->data['itemSet'];
    }

    /**
     * @return boolean
     */
    public function isUnique()
    {
        return $this->data['maxCount'] > 0;
    }

    /**
     * @return integer
     */
    public function getUniqueCount()
    {
        return $this->data['maxCount'];
    }

    /**
     * @return integer
     */
    public function getDurability()
    {
        return $this->data['maxDurability'];
    }

    /**
     * @return boolean
     */
    public function hasFactionRequirement()
    {
        return $this->data['minFactionId'] > 0;
    }

    /**
     * @return integer
     */
    public function getRequiredFactionId()
    {
        return $this->data['minFactionId'];
    }

    /**
     * @return boolean
     */
    public function hasReputationRequirement()
    {
        return $this->data['minReputation'] > 0;
    }

    /**
     * @return integer
     */
    public function getRequiredStanding()
    {
        return $this->data['minReputation'];
    }

    /**
     * @return integer
     */
    public function getSellPrice()
    {
        return $this->data['sellPrice'];
    }

    /**
     * @return boolean
     */
    public function hasLevelRequirement()
    {
        return $this->data['requiredLevel'] > 0;
    }

    /**
     * @return integer
     */
    public function getRequiredLevel()
    {
        return $this->data['requiredLevel'];
    }

    /**
     * @return boolean
     */
    public function hasProfessionRequirement()
    {
        return $this->data['requiredLevel'] > 0;
    }

    /**
     * @return integer
     */
    public function getRequiredProfession()
    {
        return $this->data['requiredSkill'];
    }

    /**
     * @return boolean
     */
    public function hasProfessionRankRequirement()
    {
        return $this->data['requiredSkillRank'] > 0;
    }

    /**
     * @return integer
     */
    public function getRequiredProfessionRank()
    {
        return $this->data['requiredSkillRank'];
    }

    /**
     * @return array
     */
    public function getItemSource()
    {
        return $this->data['itemSource'];
    }

    /**
     * @return boolean
     */
    public function hasSockets()
    {
        return $this->data['hasSockets'];
    }

    /**
     * @return Item\SocketInfo|null
     */
    public function getSocketInfo()
    {
        if ($this->data['hasSockets'] === true) {
             return $this->data['socketInfo'];
        }

        return null;
    }

    /**
     * @return boolean
     */
    public function isAuctionable()
    {
        return $this->data['isAuctionable'];
    }

    /**
     * @return integer
     */
    public function getBaseArmor()
    {
        return $this->data['baseArmor'];
    }

    /**
     * @return integer
     */
    public function getArmor()
    {
        return $this->data['armor'];
    }

    /**
     * @return integer
     */
    public function getDisplayInfoId()
    {
        return $this->data['displayInfoId'];
    }
}