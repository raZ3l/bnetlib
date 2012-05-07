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

namespace bnetlib\Resource\Wow;

use bnetlib\Resource\Wow\Realms\Realm;
use bnetlib\Resource\ResourceInterface;

/**
 * @category   bnetlib
 * @package    Resource
 * @subpackage WorldOfWarcraft
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */
class Realms implements ResourceInterface, \Iterator
{
    /**#@+
     * @const string
     */
    const TYPE_PVE    = 'pve';
    const TYPE_PVP    = 'pvp';
    const TYPE_RP_PVE = 'rp';
    const TYPE_RP_PVP = 'rppvp';
    /**#@-*/

    /**#@+
     * @const string
     */
    const POPULATION_LOW    = 'low';
    const POPULATION_MEDIUM = 'medium';
    const POPULATION_HIGH   = 'high';
    /**#@-*/

    /**
     * @var int
     */
    protected $position = 0;

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
     * @inheritdoc
     */
    public function populate($data)
    {
        foreach ($data['realms'] as $i => $realm) {
            $this->data[$i] = new Realm();
            if (isset($this->headers)) {
                $this->data[$i]->setResponseHeaders($this->headers);
            }
            $this->data[$i]->populate($realm);

            $queue  = ($realm['queue'] === true) ? 1 : 0;
            $status = ($realm['status'] === true) ? 1 : 0;

            $this->index['queue'][$queue][]                    = $this->data[$i];
            $this->index['status'][$status][]                  = $this->data[$i];
            $this->index['type'][$realm['type']][]             = $this->data[$i];
            $this->index['population'][$realm['population']][] = $this->data[$i];
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
     * @param  boolean $status
     * @return array|null
     */
    public function getByStatus($status)
    {
        $status = ($status === true) ? 1 : 0;

        if (isset($this->index['status'][$status])) {
            return $this->index['status'][$status];
        }

        return null;
    }

    /**
     * @param  boolean $queue
     * @return array|null
     */
    public function getByQueueStatus($queue)
    {
        $queue = ($queue === true) ? 1 : 0;

        if (isset($this->index['queue'][$queue])) {
            return $this->index['queue'][$queue];
        }

        return null;
    }

    /**
     * @param  string $type
     * @return array|null
     */
    public function getByType($type)
    {
        if (isset($this->index['type'][$type])) {
            return $this->index['type'][$type];
        }

        return null;
    }

    /**
     * @param  string $population
     * @return array|null
     */
    public function getByPopulation($population)
    {
        if (isset($this->index['population'][$population])) {
            return $this->index['population'][$population];
        }

        return null;
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
     * @return bnetlib\Resource\Wow\Realms\Realm
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