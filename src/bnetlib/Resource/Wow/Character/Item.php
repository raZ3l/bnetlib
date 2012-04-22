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
use bnetlib\Resource\Wow\Shared\Item as BaseItem;

/**
 * @category   bnetlib
 * @package    Resource
 * @subpackage WorldOfWarcraft
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    https://gitbub.com/coss/bnetlib/LISENCE     MIT License
 */
class Item extends BaseItem implements ResourceInterface
{
    /**
     * @inheritdoc
     */
    public function populate(array $data)
    {
        $this->data = $data;

        if (empty($data['tooltipParams'])) {
            foreach ($data['tooltipParams'] as $key => $value) {
                if (preg_match('/gem(\d+)/', $key, $match)) {
                    $i = (int) $match[1];
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
     * @return string
     */
    public function getIcon()
    {
        return $this->data['icon'];
    }

    /**
     * @return boolean
     */
    public function hasTooltipParams()
    {
        return !empty($this->data['tooltipParams']);
    }

    /**
     * @return array
     */
    public function getTooltipParams()
    {
        return $this->data['tooltipParams'];
    }

    /**
     * @return boolean
     */
    public function isTransmogrified()
    {
        return isset($this->data['tooltipParams']['transmogItem']);
    }

    /**
     * @return id|null
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
     * @return id|null
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
     * @return id|null
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