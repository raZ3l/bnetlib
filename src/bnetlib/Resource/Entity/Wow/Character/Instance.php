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
class Instance implements EntityInterface, \Iterator
{
    /**
     * @var integer
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
                $this->data['progress']['nm'][1]++;
            }
            $this->data['progress']['hm'][1]++;

            if ($boss['normalKills'] > 0 && !in_array($boss['id'], $ignoreOnNoraml)) {
                $this->data['progress']['nm'][0]++;
            }
            if ($boss['heroicKills'] > 0) {
                $this->data['progress']['nm'][0]++;
            }

            if ($boss['normalKills'] === 0 && !in_array($boss['id'], $ignoreOnNoraml)) {
                $this->clear['nm'] = false;
            }

            if ($boss['heroicKills'] === 0) {
                $this->clear['hm'] = false;
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
     * @return integer
     */
    public function getNormal()
    {
         return $this->data['normal'];
    }

    /**
     * @return integer
     */
    public function getHeroic()
    {
         return $this->data['heroic'];
    }

    /**
     * @return integer
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
         return $this->clear['hm'];
    }

    /**
     * @return string
     */
    public function getNormalProgress()
    {
         return vsprintf('%s/%s', $this->data['progress']['nm']);
    }

    /**
     * @return string
     */
    public function getHeroicProgress()
    {
         return vsprintf('%s/%s', $this->data['progress']['hm']);
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
        return isset($this->data['bosses'][$this->position]);
    }
}