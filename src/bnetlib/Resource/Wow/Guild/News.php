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

namespace bnetlib\Resource\Wow\Guild;

use bnetlib\Resource\ResourceInterface;

/**
 * @category   bnetlib
 * @package    Resource
 * @subpackage WorldOfWarcraft
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */
class News implements ResourceInterface, \Iterator, \Countable
{
    /**#@+
     * @const string
     */
    const TYPE_GUILD_CREATED      = 'guildCreated';
    const TYPE_GUILD_LEVEL        = 'guildLevel';
    const TYPE_GUILD_ACHIEVEMENT  = 'guildAchievement';
    const TYPE_PLAYER_ACHIEVEMENT = 'playerAchievement';
    const TYPE_ITEM_LOOT          = 'itemLoot';
    const TYPE_ITEM_PURCHASE      = 'itemPurchase';
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
        foreach ($data as $i => $entry) {
            $class = new NewsEntry();
            if (isset($this->headers)) {
                $class->setResponseHeaders($this->headers);
            }
            $class->populate($entry);

            $this->data[]                  = $class;
            $this->index[$entry['type']][] = $class;
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
     * @param  string $type
     * @return array|null
     */
    public function getByType($type)
    {
        if (isset($this->index[$type])) {
            return $this->index[$type];
        }

        return null;
    }

    /**
     * @see    \Countable
     * @return int
     */
    public function count()
    {
        return count($this->data);
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
     * @return bnetlib\Resource\Wow\Guild\NewsEntry
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