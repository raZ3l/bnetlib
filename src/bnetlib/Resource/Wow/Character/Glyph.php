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

use bnetlib\Resource\ConsumeInterface;
use bnetlib\ServiceLocator\ServiceLocatorInterface;

/**
 * @category   bnetlib
 * @package    Resource
 * @subpackage WorldOfWarcraft
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */
class Glyph implements ConsumeInterface
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
     * @var bnetlib\ServiceLocator\ServiceLocatorInterface
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
     * @inheritdoc
     */
    public function consume()
    {
        return array('itemid' => $this->data['item']);
    }

    /**
     * @return int
     */
    public function getGlyphId()
    {
        return $this->data['glyph'];
    }

    /**
     * @return int
     */
    public function getItemId()
    {
        return $this->data['item'];
    }

    /**
     * @return int
     */
    public function getGlyphType()
    {
        return $this->data['type'];
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
     * @return boolean
     */
    public function isPrime()
    {
        return $this->data['type'] === 'prime';
    }

    /**
     * @return boolean
     */
    public function isMajor()
    {
        return $this->data['type'] === 'major';
    }

    /**
     * @return boolean
     */
    public function isMinor()
    {
        return $this->data['type'] === 'minor';
    }
}