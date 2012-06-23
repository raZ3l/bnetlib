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

use bnetlib\Resource\Entity\Wow\Item\Reward;

/**
 * @category   bnetlib
 * @package    Resource
 * @subpackage WorldOfWarcraft
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */
class Item extends Reward
{
    /**
     * @inheritdoc
     */
    public function populate($data)
    {
        $this->data = $data;

        if (!empty($data['tooltipParams'])) {
            foreach ($data['tooltipParams'] as $key => $value) {
                if (preg_match('/gem(\d+)/', $key, $match)) {
                    $i = (integer) $match[1];
                    unset($this->data['tooltipParams'][$key]);

                    if (!isset($this->data['tooltipParams']['gems'])) {
                        $this->data['tooltipParams']['gems'] = array();
                    }

                    $this->data['tooltipParams']['gems'][$i] = $value;
                }
            }
        }
    }

    /**
     * @return boolean
     */
    public function isTransmogrified()
    {
        return isset($this->data['tooltipParams']['transmogItem']);
    }

    /**
     * @return integer|null
     */
    public function getTransmogrification()
    {
        if (isset($this->data['tooltipParams']['transmogItem'])) {
            return $this->data['tooltipParams']['transmogItem'];
        }

        return null;
    }

    /**
     * @return boolean
     */
    public function isSetItem()
    {
        return isset($this->data['tooltipParams']['set']);
    }

    /**
     * @return array|null
     */
    public function getSetItemIds()
    {
        if (isset($this->data['tooltipParams']['set'])) {
            return $this->data['tooltipParams']['set'];
        }

        return null;
    }

    /**
     * @return boolean
     */
    public function isReforged()
    {
        return isset($this->data['tooltipParams']['reforge']);
    }

    /**
     * @return integer|null
     */
    public function getReforge()
    {
        if (isset($this->data['tooltipParams']['reforge'])) {
            return $this->data['tooltipParams']['reforge'];
        }

        return null;
    }

    /**
     * @return boolean
     */
    public function isEnchanted()
    {
        return isset($this->data['tooltipParams']['enchant']);
    }

    /**
     * @return integer|null
     */
    public function getEnchant()
    {
        if (isset($this->data['tooltipParams']['enchant'])) {
            return $this->data['tooltipParams']['enchant'];
        }

        return null;
    }

    /**
     * @return boolean
     */
    public function hasExtraSocket()
    {
        return isset($this->data['tooltipParams']['extraSocket']);
    }
}