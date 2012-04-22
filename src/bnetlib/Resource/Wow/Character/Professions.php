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
 * @license    https://gitbub.com/coss/bnetlib/LISENCE     MIT License
 */

namespace bnetlib\Resource\Wow\Character;

use bnetlib\Resource\ResourceInterface;

/**
 * @category   bnetlib
 * @package    Resource
 * @subpackage WorldOfWarcraft
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    https://gitbub.com/coss/bnetlib/LISENCE     MIT License
 */
class Professions implements ResourceInterface, \Iterator
{
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
     * @inheritdoc
     */
    public function populate(array $data)
    {
        $i = 0;

        foreach (array('primary', 'secondary') as $type) {
            foreach ($data[$type] as $key => $value) {
                $this->index['id'][$value['id']] = $i;
                $this->index[$type][]            = $i;

                $this->data[$i] = new Profession();
                if (isset($this->headers)) {
                    $this->data[$i]->setResponseHeaders($this->headers);
                }
                $this->data[$i]->populate($value);

                $i++;
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
     * @param  int $id
     * @return bnetlib\Resource\Wow\Character\Profession|null
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
        return empty($this->index['primary']) ? false : true;
    }

    /**
     * @return boolean
     */
    public function hasSecondaryProfession()
    {
        return empty($this->index['secondary']) ? false : true;
    }

    /**
     * @return boolean
     */
    public function hasGatherProfession()
    {
        foreach (array(182, 186, 393) as $id) {
            if (isset($this->index['id'][$id])) {
                return true;
            }
        }

        return false;
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
     * @return bnetlib\Resource\Wow\Character\Profession
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