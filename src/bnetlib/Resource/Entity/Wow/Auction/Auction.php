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

namespace bnetlib\Resource\Entity\Wow\Auction;

use bnetlib\Locale\LocaleInterface;
use bnetlib\Locale\LocaleAwareInterface;
use bnetlib\Resource\Entity\EntityInterface;
use bnetlib\ServiceLocator\ServiceLocatorInterface;

/**
 * @category   bnetlib
 * @package    Resource
 * @subpackage WorldOfWarcraft
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */
class Auction implements EntityInterface, LocaleAwareInterface
{
    /**
     * @var array
     */
    protected $data = array();

    /**
     * @var LocaleInterface
     */
    protected $locale;

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
    public function setLocale(LocaleInterface $locale)
    {
        $this->locale = $locale;

        foreach ($this->data as $key => $value) {
            if (is_object($value) && $value instanceof LocaleAwareInterface) {
                $this->data[$key]->setLocale($locale);
            }
        }

        return $this;
    }

    /**
     * @return boolean
     */
    public function isShort()
    {
        return $this->data['time'] === 1;
    }

    /**
     * @return boolean
     */
    public function isMedium()
    {
        return $this->data['time'] === 2;
    }

    /**
     * @return boolean
     */
    public function isLong()
    {
        return $this->data['time'] === 3;
    }

    /**
     * @return boolean
     */
    public function isVeryLong()
    {
        return $this->data['time'] === 4;
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->data['auc'];
    }

    /**
     * @return integer
     */
    public function getItemId()
    {
        return $this->data['item'];
    }

    /**
     * @return string
     */
    public function getOwner()
    {
        return $this->data['owner'];
    }

    /**
     * @return integer
     */
    public function getBid()
    {
        return $this->data['bid'];
    }

    /**
     * @return integer
     */
    public function getBuyout()
    {
        return $this->data['buyout'];
    }

    /**
     * @return integer
     */
    public function getQuantity()
    {
        return $this->data['quantity'];
    }

    /**
     * @return integer 1 = Short, 2 = Medium, 3 = Long and 4 = Very Long
     */
    public function getTimeLeft()
    {
        return $this->data['time'];
    }

    /**
     * @return string|null
     */
    public function getTimeLeftLocale()
    {
        if (isset($this->locale)) {
            return $this->locale->get(sprintf('auction.%s', $this->data['time']), 'wow');
        }

        return null;
    }
}