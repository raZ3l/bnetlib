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

namespace bnetlib\Resource\Wow\Shared;

use bnetlib\Resource\ConsumeInterface;
use bnetlib\Resource\ResourceInterface;

/**
 * @category   bnetlib
 * @package    Resource
 * @subpackage WorldOfWarcraft
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */
class Item implements ResourceInterface, ConsumeInterface
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
     * @inheritdoc
     */
    public function consume()
    {
        return array('itemid' => $this->data['id']);
    }

    /**
     * @return int
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
     * @return int
     */
    public function getQuality()
    {
        return $this->data['quality'];
    }

    /**
     * @return boolean
     */
    public function isPoor()
    {
        return ($this->data['quality'] === 0);
    }

    /**
     * @return boolean
     */
    public function isCommon()
    {
        return ($this->data['quality'] === 1);
    }

    /**
     * @return boolean
     */
    public function isUncommon()
    {
        return ($this->data['quality'] === 2);
    }

    /**
     * @return boolean
     */
    public function isRare()
    {
        return ($this->data['quality'] === 3);
    }

    /**
     * @return boolean
     */
    public function isEpic()
    {
        return ($this->data['quality'] === 4);
    }

    /**
     * @return boolean
     */
    public function isHeirloom()
    {
        return ($this->data['quality'] === 5);
    }

    /**
     * @return boolean
     */
    public function isArtifact()
    {
        return ($this->data['quality'] === 6);
    }

    /**
     * @return boolean
     */
    public function isLegendary()
    {
        return ($this->data['quality'] === 7);
    }
}