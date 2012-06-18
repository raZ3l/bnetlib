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
class RatedBattlegrounds implements EntityInterface, \Iterator
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
        $this->data          = $data;
        $this->data['total'] = array(
            'played' => 0,
            'won'    => 0
        );

        foreach ($data['battlegrounds'] as $i => $bg) {
            $this->data['total']['won']    += $bg['won'];
            $this->data['total']['played'] += $bg['played'];
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
     * @return int
     */
    public function getPersonalRating()
    {
        return $this->data['personalRating'];
    }

    /**
     * @return array
     */
    public function getBattlegrounds()
    {
        return $this->data['battlegrounds'];
    }

    /**
     * @return int
     */
    public function getWins()
    {
        return $this->data['total']['won'];
    }

    /**
     * @return int
     */
    public function getLosses()
    {
        return $this->data['total']['played'] - $this->data['total']['won'];
    }

    /**
     * @return int
     */
    public function getPlayed()
    {
        return $this->data['total']['played'];
    }

    /**
     * @return boolean
     */
    public function hasPlayed()
    {
        return $this->data['total']['played'] > 0;
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
     * @return array
     */
    public function current()
    {
        return $this->data['battlegrounds'][$this->position];
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
        return isset($this->data['battlegrounds'][$this->position]);
    }
}