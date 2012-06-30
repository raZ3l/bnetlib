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

namespace bnetlib\Resource\Entity\Wow\Achievements;

use bnetlib\Resource\Entity\ConsumeInterface;
use bnetlib\ServiceLocator\ServiceLocatorInterface;

/**
 * @category   bnetlib
 * @package    Resource
 * @subpackage WorldOfWarcraft
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */
class Achievement implements ConsumeInterface
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
    public function consume()
    {
        return array('achievementid' => $this->data['a']);
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
        return $this->data['a'];
    }

    /**
     * @return integer
     */
    public function getTimestamp()
    {
        return $this->data['ts'];
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->data['td'];
    }

    /**
     * @return integer
     */
    public function getCriteria()
    {
        return $this->data['c'];
    }

    /**
     * @return integer
     */
    public function getCriteriaQuantity()
    {
        return $this->data['cq'];
    }

    /**
     * @return integer
     */
    public function getCriteriaTimestamp()
    {
        return $this->data['cts'];
    }

    /**
     * @return \DateTime
     */
    public function getCriteriaDate()
    {
        return $this->data['ctd'];
    }

    /**
     * @return integer
     */
    public function getCriteriaCreated()
    {
        return $this->data['cc'];
    }
}