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
class TalentSpecialization implements ResourceInterface
{
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
        foreach ($data as $key => $value) {
            if ($key === 'glyphs') {
                $this->data[$key] = new Glyphs();
                if (isset($this->headers)) {
                    $this->data[$key]->setResponseHeaders($this->headers);
                }
                $this->data[$key]->populate($value);

                continue;
            }

            $this->data[$key] = $value;
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
    public function isSelected()
    {
        return isset($this->data['selected']);
    }

    /**
     * @return boolean
     */
    public function isSpecialized()
    {
        return isset($this->data['name']);
    }

    /**
     * @return string|null
     */
    public function getName()
    {
        if (isset($this->data['name'])) {
            return $this->data['name'];
        }

        return null;
    }

    /**
     * @return string|null
     */
    public function getIcon()
    {
        if (isset($this->data['icon'])) {
            return $this->data['icon'];
        }

        return null;
    }

    /**
     * @return string
     */
    public function getBuild()
    {
        return $this->data['build'];
    }

    /**
     * @return string
     */
    public function getSimpleBuild()
    {
        return sprintf(
            '%i/%i/%i',
            $this->data['trees'][0]['total'],
            $this->data['trees'][1]['total'],
            $this->data['trees'][2]['total']
        );
    }

    /**
     * @return string
     */
    public function getTrees()
    {
        return $this->data['trees'];
    }

    /**
     * @return bnetlib\Resource\Wow\Character\Glyphs
     */
    public function getGlyphs()
    {
        return $this->data['glyphs'];
    }
}