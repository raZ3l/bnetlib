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
 * @subpackage Diablo3
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */

namespace bnetlib\Resource\Entity\D3\Shared;

use bnetlib\Resource\Entity\EntityInterface;
use bnetlib\Resource\Entity\ConsumeInterface;
use bnetlib\ServiceLocator\ServiceLocatorInterface;

/**
 * @category   bnetlib
 * @package    Resource
 * @subpackage Diablo3
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */
class Hero implements EntityInterface, ConsumeInterface
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
     * @return boolean
     */
    public function isHardcore()
    {
        return $this->data['hardcore'];
    }

    /**
     * @return string
     */
    public function getClass()
    {
        return $this->data['class'];
    }

    /**
     * @return string
     */
    public function getClassLocale()
    {
        // currently hardcoded, just a preview!
        return 'SomeClassLocale';
    }

    /**
     * @return integer
     */
    public function getLevel()
    {
        return $this->data['level'];
    }

    /**
     * @return integer
     */
    public function getGender()
    {
        return $this->data['gender'];
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
     * @return integer
     */
    public function getLastUpdated()
    {
        return $this->data['last-updated'];
    }

    /**
     * @inheritdoc
     */
    public function consume()
    {
        return array('id' => $this->data['id']);
    }
}