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
 * @license    https://gitbub.com/coss/bnetlib/LISENCE     MIT License
 */

namespace bnetlib\Resource\Wow\Character;

use bnetlib\Resource\ResourceInterface;

/**
 * @category   bnetlib
 * @package    Resource
 * @subpackage WorldOfWarcraft
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    https://gitbub.com/coss/bnetlib/LISENCE     MIT License
 */
class Instance implements ResourceInterface, \Iterator
{
    /**
     * @var int
     */
    protected $position = 0;

    /**
     * @var array
     */
    protected $clear = array(
        'nm' => true,
        'hm' => true
    );

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
    public function populate(array $data)
    {
        $this->data = $data;
        $this->data['progress'] = array(
            'nm' => array(0, 0),
            'hm' => array(0, 0)
        );

        /**
         * 45213 = Sinestra (The Bastion of Twilight)
         * 65184 = Algalon the Observer (Ulduar)
         */
        $ignoreOnNoraml = array(45213, 65184);


        foreach ($data['bosses'] as $boss) {
            if (!in_array($boss['id'], $ignoreOnNoraml)) {
                $this->data['progress']['nm'][0]++;
            }
            $this->data['progress']['nm'][0]++;

            if ($boss['normalKills'] > 0 && !in_array($boss['id'], $ignoreOnNoraml)) {
                $this->data['progress']['nm'][1]++;
            }
            if ($boss['heroicKills'] > 0) {
                $this->data['progress']['nm'][1]++;
            }

            if ($boss['normalKills'] === 0 && !in_array($boss['id'], $ignoreOnNoraml)) {
                $this->clear['nm'] = false;
            }

            if ($boss['heroicKills'] === 0) {
                $this->clear['nm'] = false;
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
    public function hasHeroicMode()
    {
        /**
         * 2717 = Molten Core
         * 2677 = Blackwing Lair
         * 3429 = Ruins of Ahn'Qiraj
         * 3428 = Ahn'Qiraj Temple
         * 3457 = Karazhan
         * 3836 = Magtheridon's Lair
         *
         * 3923 = Gruul's Lair
         * 3607 = Serpentshrine Cavern
         * 3845 = Tempest Keep
         * 3606 = The Battle for Mount Hyjal
         * 3959 = Black Temple
         * 4075 = The Sunwell
         *
         * 4603 = Vault of Archavon
         * 3456 = Naxxramas
         * 4493 = The Obsidian Sanctum
         * 4500 = The Eye of Eternity
         * 4273 = Ulduar
         * 2159 = Onyxia's Lair
         */
         return !in_array($this->data['id'], array(
            2717, 2677, 3429, 3428, 3457, 3836,
            3923, 3607, 3845, 3606, 3959, 4075,
            4603, 3456, 4493, 4500, 4273, 2159
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
         return $this->data['name'];
    }

    /**
     * @return int
     */
    public function getNormal()
    {
         return $this->data['normal'];
    }

    /**
     * @return int
     */
    public function getHeroic()
    {
         return $this->data['heroic'];
    }

    /**
     * @return int
     */
    public function getId()
    {
         return $this->data['id'];
    }

    /**
     * @return array
     */
    public function getBosses()
    {
         return $this->data['bosses'];
    }

    /**
     * @return boolean
     */
    public function isClearOnNormal()
    {
         return $this->clear['nm'];
    }

    /**
     * @return boolean
     */
    public function isClearOnHeroic()
    {
         return $this->clear['nm'];
    }

    /**
     * @return string
     */
    public function getNormalProgress()
    {
         return sprintf('%i/%i', $this->data['progress']['nm'][0], $this->data['progress']['nm'][1]);
    }

    /**
     * @return string
     */
    public function getHeroicProgress()
    {
         return sprintf('%i/%i', $this->data['progress']['hm'][0], $this->data['progress']['hm'][1]);
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
        return $this->data['bosses'][$this->position];
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
        return isset($this->data['bosses'][$this->position]);
    }
}