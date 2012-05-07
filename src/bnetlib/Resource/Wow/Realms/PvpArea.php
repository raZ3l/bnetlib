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

namespace bnetlib\Resource\Wow\Realms;

use bnetlib\Resource\ResourceInterface;

/**
 * @category   bnetlib
 * @package    Resource
 * @subpackage WorldOfWarcraft
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */
class PvpArea implements ResourceInterface
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
     * @return int
     */
    public function getArea()
    {
        return $this->data['area'];
    }

    /**
     * @return int
     */
    public function getControllingFaction()
    {
        return $this->data['controlling-faction'];
    }

    /**
     * @return boolean
     */
    public function isAllianceControlled()
    {
        return $this->data['controlling-faction'] === 0;
    }

    /**
     * @return boolean
     */
    public function isHordeControlled()
    {
        return $this->data['controlling-faction'] === 1;
    }

    /**
     * @return int
     */
    public function getStatus()
    {
        return $this->data['status'];
    }

    /**
     * @return string
     */
    public function getStatusString()
    {
        switch ($this->data['status']) {
            case 0:
                return 'Idle';
            case 1:
                return 'Populating';
            case 2:
                return 'Active';
            case 3:
                return 'Concluded';
            default:
                return 'Unknown';
        }
    }

    /**
     * @return boolean
     */
    public function isIdle()
    {
        return $this->data['status'] === 0;
    }

    /**
     * @return boolean
     */
    public function isPopulating()
    {
        return $this->data['status'] === 1;
    }

    /**
     * @return boolean
     */
    public function isActive()
    {
        return $this->data['status'] === 2;
    }

    /**
     * @return boolean
     */
    public function isConcluded()
    {
        return $this->data['status'] === 3;
    }

    /**
     * @return int
     */
    public function getNext()
    {
        return $this->data['next'];
    }
}