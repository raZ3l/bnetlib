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

namespace bnetlib\Resource\Wow\Achievements;

use bnetlib\Resource\ResourceInterface;

/**
 * @category   bnetlib
 * @package    Resource
 * @subpackage WorldOfWarcraft
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */
class DataAchievements implements ResourceInterface, \Iterator
{
    /**
     * @var int
     */
    protected $position = 0;

    /**
     * @var array
     */
    protected $data = array();

    /**
     * @var int
     */
    protected $categoryId;

    /**
     * @var string
     */
    protected $categoryName;

    /**
     * @var int|null
     */
    protected $topCategoryId = null;

    /**
     * @var string|null
     */
    protected $topCategoryName = null;

    /**
     * @var \stdClass|null
     */
    protected $headers;

    /**
     * @inheritdoc
     */
    public function populate(array $data)
    {
        $this->categoryId   = $data['id'];
        $this->categoryName = $data['name'];

        if (isset($data['categories'])) {
            foreach ($data['categories'] as $i => $value) {
                $value['top'] = array($data['id'], $data['name']);
                $class = new self();
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
                $class = new DataAchievement();
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
    public function setResponseHeaders(\stdClass $headers)
    {
        $this->headers = $headers;
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
     * @return int|null
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
     * @return int|null
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
     * @return self|bnetlib\Resource\Wow\Achievements\Achievement
     */
    public function current()
    {
        return $this->data[$this->position];
    }

    /**
     * @see    \Iterator
     * @return string
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