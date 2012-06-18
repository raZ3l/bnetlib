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
class Professions implements EntityInterface, \Iterator
{
    /**#@+
     * @const int
     */
    const PROFESSION_ALCHEMY        = 171;
    const PROFESSION_BLACKSMITHING  = 164;
    const PROFESSION_ENCHANTING     = 333;
    const PROFESSION_ENGINEERING    = 202;
    const PROFESSION_HERBALISM      = 182;
    const PROFESSION_INSCRIPTION    = 773;
    const PROFESSION_JEWELCRAFTING  = 755;
    const PROFESSION_LEATHERWORKING = 165;
    const PROFESSION_MINING         = 186;
    const PROFESSION_SKINNING       = 393;
    const PROFESSION_TAILORING      = 197;
    const PROFESSION_FIRST_AID      = 129;
    const PROFESSION_ARCHAEOLOGY    = 794;
    const PROFESSION_FISHING        = 356;
    const PROFESSION_COOKING        = 185;
    /**#@-*/

    /**
     * @var int
     */
    protected $position = 0;

    /**
     * @var array
     */
    protected $index = array(
        'id'        => array(),
        'primary'   => array(),
        'secondary' => array()
    );

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

        foreach (array('primary', 'secondary') as $type) {
            foreach ($data[$type] as $key => $value) {
                $class = $this->serviceLocator->get('wow.entity.character.profession');
                if (isset($this->headers)) {
                    $class->setResponseHeaders($this->headers);
                }
                $class->populate($value);

                $this->data[]                    = $class;
                $this->index[$type][]            = $class;
                $this->index['id'][$value['id']] = $class;
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
     * @return array
     */
    public function toArray()
    {
        return $this->data;
    }

    /**
     * @param  int $id
     * @return Profession|null
     */
    public function getById($id)
    {
        if (isset($this->index['id'][$id])) {
            return $this->index['id'][$id];
        }

        return null;
    }

    /**
     * @return boolean
     */
    public function hasAlchemy()
    {
        return isset($this->index['id'][171]);
    }

    /**
     * @return boolean
     */
    public function hasBlacksmithing()
    {
        return isset($this->index['id'][164]);
    }

    /**
     * @return boolean
     */
    public function hasEnchanting()
    {
        return isset($this->index['id'][333]);
    }

    /**
     * @return boolean
     */
    public function hasEngineering()
    {
        return isset($this->index['id'][202]);
    }

    /**
     * @return boolean
     */
    public function hasHerbalism()
    {
        return isset($this->index['id'][182]);
    }

    /**
     * @return boolean
     */
    public function hasInscription()
    {
        return isset($this->index['id'][773]);
    }

    /**
     * @return boolean
     */
    public function hasJewelcrafting()
    {
        return isset($this->index['id'][755]);
    }

    /**
     * @return boolean
     */
    public function hasLeatherworking()
    {
        return isset($this->index['id'][165]);
    }

    /**
     * @return boolean
     */
    public function hasMining()
    {
        return isset($this->index['id'][186]);
    }

    /**
     * @return boolean
     */
    public function hasSkinning()
    {
        return isset($this->index['id'][393]);
    }

    /**
     * @return boolean
     */
    public function hasTailoring()
    {
        return isset($this->index['id'][197]);
    }

    /**
     * @return boolean
     */
    public function hasFirstAid()
    {
        return isset($this->index['id'][129]);
    }

    /**
     * @return boolean
     */
    public function hasArchaeology()
    {
        return isset($this->index['id'][794]);
    }

    /**
     * @return boolean
     */
    public function hasFishing()
    {
        return isset($this->index['id'][356]);
    }

    /**
     * @return boolean
     */
    public function hasCooking()
    {
        return isset($this->index['id'][185]);
    }

    /**
     * @return boolean
     */
    public function hasPrimaryProfession()
    {
        return !empty($this->index['primary']);
    }

    /**
     * @return array
     */
    public function getPrimaryProfessions()
    {
        return $this->index['primary'];
    }

    /**
     * @return boolean
     */
    public function hasSecondaryProfession()
    {
        return !empty($this->index['secondary']);
    }

    /**
     * @return array
     */
    public function getSecondaryProfessions()
    {
        return $this->index['secondary'];
    }

    /**
     * @return boolean
     */
    public function hasGatherProfession()
    {
        $has = array_keys($this->index['id'], array(182, 186, 393));

        return !empty($has);
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
     * @return Profession
     */
    public function current()
    {
        return $this->data[$this->position];
    }

    /**
     * @see    \Iterator
     * @return int
     */
    public function key()
    {
        return $this->position;
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
        return isset($this->data[$this->position]);
    }
}