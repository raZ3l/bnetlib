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

use bnetlib\Resource\Entity\EntityInterface;
use bnetlib\ServiceLocator\ServiceLocatorInterface;

/**
 * @category   bnetlib
 * @package    Resource
 * @subpackage WorldOfWarcraft
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */
class DataAchievements implements EntityInterface, \Iterator
{
    /**
     * @var integer
     */
    protected $position = 0;

    /**
     * @var array
     */
    protected $data = array();

    /**
     * @var integer
     */
    protected $categoryId;

    /**
     * @var string
     */
    protected $categoryName;

    /**
     * @var integer|null
     */
    protected $topCategoryId = null;

    /**
     * @var string|null
     */
    protected $topCategoryName = null;

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
        $this->categoryId   = $data['id'];
        $this->categoryName = $data['name'];

        if (isset($data['categories'])) {
            foreach ($data['categories'] as $i => $value) {
                $value['top'] = array($data['id'], $data['name']);
                $class = $this->serviceLocator->get('wow.entity.achievements.dataachievements');
                if (isset($this->headers)) {
                    $class->setResponseHeaders($this->headers);
                }
                $class->populate($value);
                $this->data[] = $class;
            }
        } elseif (isset($data['achievements'])) {
            if (isset($data['top'])) {
                $this->topCategoryId   = $data['top'][0];
                $this->topCategoryName = $data['top'][1];
            }

            foreach ($data['achievements'] as $i => $value) {
                $class = $this->serviceLocator->get('wow.entity.achievements.dataachievement');
                if (isset($this->headers)) {
                    $class->setResponseHeaders($this->headers);
                }
                $class->populate($value);
                $this->data[] = $class;
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
     * @return array
     */
    public function toArray()
    {
        return $this->data;
    }

    /**
     * @return boolean
     */
    public function isSubCategory()
    {
        return isset($this->topCategoryId);
    }

    /**
     * @return string|null
     */
    public function getCategory()
    {
        return $this->categoryName;
    }

    /**
     * @return integer|null
     */
    public function getCategoryId()
    {
        return $this->categoryId;
    }

    /**
     * @return string|null
     */
    public function getTopCategory()
    {
        return $this->topCategoryName;
    }

    /**
     * @return integer|null
     */
    public function getTopCategoryId()
    {
        return $this->topCategoryId;
    }

    /**
     * @return boolean
     */
    public function isAchievement()
    {
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
     * @return self|Achievement
     */
    public function current()
    {
        return $this->data[$this->position];
    }

    /**
     * @see    \Iterator
     * @return integer
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