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
class Achievements implements EntityInterface, \Iterator, \Countable
{
    /**
     * @var array
     */
    protected $index = array();

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
        $tz = new \DateTimeZone('UTC');

        foreach ($data['achievementsCompleted'] as $i => $av) {
            $this->index[$av] = $i;
            $achievement      = $this->serviceLocator->get('wow.entity.achievements.achievement');
            if (isset($this->headers)) {
                $achievement->setResponseHeaders($this->headers);
            }
            $achievement->populate(array(
                'a'   => $av,
                'ts'  => $data['achievementsCompletedTimestamp'][$i],
                'td'  => new \DateTime('@' . round(($data['achievementsCompletedTimestamp'][$i] / 1000), 0), $tz),
                'c'   => $data['criteria'][$i],
                'cq'  => $data['criteriaQuantity'][$i],
                'cts' => $data['criteriaTimestamp'][$i],
                'ctd' => new \DateTime('@' . round(($data['criteriaTimestamp'][$i] / 1000), 0), $tz),
                'cc'  => $data['criteriaCreated'][$i]
            ));

            $this->data[$i] = $achievement;
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
     * @param  int $id
     * @return Achievement|null
     */
    public function getById($id)
    {
        if (isset($this->index[$id])) {
            return $this->data[$this->index[$id]];
        }

        return null;
    }

    /**
     * @param  int $id
     * @return boolean
     */
    public function has($id)
    {
        return isset($this->index[$id]);
    }

    /**
     * @see    \Countable
     * @return int
     */
    public function count()
    {
        return count($this->index);
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
     * @return Achievement
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