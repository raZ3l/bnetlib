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
class Glyphs implements EntityInterface, \Iterator, \Countable
{
    /**
     * @var integer
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
     * @var ServiceLocatorInterface
     */
    protected $serviceLocator;

    /**
     * @inheritdoc
     */
    public function populate($data)
    {
        foreach ($data as $type => $glyphs) {
            $this->index[$type] = array();

            foreach ($glyphs as $glyph) {
                $glyph['type'] = $type;

                $class = $this->serviceLocator->get('wow.entity.character.glyph');
                if (isset($this->headers)) {
                    $class->setResponseHeaders($this->headers);
                }
                $class->populate($glyph);

                $this->data[]         = $class;
                $this->index[$type][] = $class;
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
     * @see    \Countable
     * @return integer
     */
    public function count()
    {
        return count($this->data);
    }

    /**
     * @return boolean
     */
    public function hasGlyphs()
    {
        return !empty($this->data);
    }

    /**
     * @return boolean
     */
    public function hasPrime()
    {
        return !empty($this->index['prime']);
    }

    /**
     * @return array
     */
    public function getPrime()
    {
        return $this->index['prime'];
    }

    /**
     * @return boolean
     */
    public function hasMajor()
    {
        return !empty($this->index['major']);
    }

    /**
     * @return array
     */
    public function getMajor()
    {
        return $this->index['major'];
    }

    /**
     * @return boolean
     */
    public function hasMinor()
    {
        return !empty($this->index['minor']);
    }

    /**
     * @return array
     */
    public function getMinor()
    {
        return $this->index['minor'];
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
     * @return Glyph
     */
    public function current()
    {
        return $this->data[$this->position];
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
        return isset($this->data[$this->position]);
    }
}