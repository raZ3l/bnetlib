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
class Appearance implements EntityInterface
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
        $this->data[0] = $data['faceVariation'];
        $this->data[1] = $data['skinColor'];
        $this->data[2] = $data['hairVariation'];
        $this->data[3] = $data['hairColor'];
        $this->data[4] = $data['featureVariation'];
        $this->data[5] = $data['showHelm'];
        $this->data[6] = $data['showCloak'];
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
    public function getFaceVariation()
    {
        return $this->data[0];
    }

    /**
     * @return integer
     */
    public function getSkinColor()
    {
        return $this->data[1];
    }

    /**
     * @return integer
     */
    public function getHairVariation()
    {
        return $this->data[2];
    }

    /**
     * @return integer
     */
    public function getHairColor()
    {
        return $this->data[3];
    }

    /**
     * @return integer
     */
    public function getFeatureVariation()
    {
        return $this->data[4];
    }

    /**
     * @return integer
     */
    public function isShowingHelm()
    {
        return $this->data[5];
    }

    /**
     * @return integer
     */
    public function isShowingCloak()
    {
        return $this->data[6];
    }
}