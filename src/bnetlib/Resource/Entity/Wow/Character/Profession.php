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
class Profession implements EntityInterface
{
    /**
     * @var array
     */
    protected $data = array();

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
        $this->data = $data;

        $list = $this->serviceLocator->get('shared.entity.listdata');
        if (isset($this->headers)) {
            $list->setResponseHeaders($this->headers);
        }
        $list->populate($this->data['recipes']);

        $this->data['recipes'] = $list;
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
     * @return integer
     */
    public function getId()
    {
        return $this->data['id'];
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->data['name'];
    }

    /**
     * @return string
     */
    public function getIcon()
    {
        return $this->data['icon'];
    }

    /**
     * @return integer
     */
    public function getRank()
    {
        return $this->data['rank'];
    }

    /**
     * @return integer
     */
    public function getMaxRank()
    {
        return $this->data['max'];
    }

    /**
     * @return array
     */
    public function getRecipes()
    {
        return $this->data['recipes'];
    }

    /**
     * @param  integer $id
     * @return boolean
     */
    public function knowsRecipe($id)
    {
        return $this->data['recipes']->has($id);
    }

    /**
     * @return boolean
     */
    public function isAlchimist()
    {
        return $this->data['id'] === 171;
    }

    /**
     * @return boolean
     */
    public function isBlacksmith()
    {
        return $this->data['id'] === 164;
    }

    /**
     * @return boolean
     */
    public function isEnchanter()
    {
        return $this->data['id'] === 333;
    }

    /**
     * @return boolean
     */
    public function isEngineer()
    {
        return $this->data['id'] === 202;
    }

    /**
     * @return boolean
     */
    public function isHerbalist()
    {
        return $this->data['id'] === 182;
    }

    /**
     * @return boolean
     */
    public function isScribe()
    {
        return $this->data['id'] === 773;
    }

    /**
     * @return boolean
     */
    public function isJewelcrafter()
    {
        return $this->data['id'] === 755;
    }

    /**
     * @return boolean
     */
    public function isLeatherworker()
    {
        return $this->data['id'] === 165;
    }

    /**
     * @return boolean
     */
    public function isMiner()
    {
        return $this->data['id'] === 186;
    }

    /**
     * @return boolean
     */
    public function isSkinner()
    {
        return $this->data['id'] === 393;
    }

    /**
     * @return boolean
     */
    public function isTailor()
    {
        return $this->data['id'] === 197;
    }

    /**
     * @return boolean
     */
    public function isFirstAider()
    {
        return $this->data['id'] === 129;
    }

    /**
     * @return boolean
     */
    public function isArchaeologist()
    {
        return $this->data['id'] === 794;
    }

    /**
     * @return boolean
     */
    public function isFisher()
    {
        return $this->data['id'] === 356;
    }

    /**
     * @return boolean
     */
    public function isCook()
    {
        return $this->data['id'] === 185;
    }

    /**
     * @return boolean
     */
    public function isPrimaryProfession()
    {
        return !in_array($this->data['id'], array(129, 794, 356, 185));
    }

    /**
     * @return boolean
     */
    public function isSecondaryProfession()
    {
        return in_array($this->data['id'], array(129, 794, 356, 185));
    }

    /**
     * @return boolean
     */
    public function isGatherProfession()
    {
        return in_array($this->data['id'], array(182, 186, 393));
    }
}