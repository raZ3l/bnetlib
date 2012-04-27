<?php
/**
 * This file is part of the bnetlib Library.
 * Copyright (c) 2012 Eric Boh <cossish@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code. You can also view the
 * LICENSE file online at https://gitbub.com/coss/bnetlib/LISENCE
 *
 * @category  bnetlib
 * @package   Locale
 * @copyright 2012 Eric Boh <cossish@gmail.com>
 * @license   http://coss.gitbub.com/bnetlib/license.html    MIT License
 */

namespace bnetlib\Locale;

/**
 * @category  bnetlib
 * @package   Locale
 * @copyright 2012 Eric Boh <cossish@gmail.com>
 * @license   http://coss.gitbub.com/bnetlib/license.html    MIT License
 */
class Locale implements LocaleInterface
{
    /**
     * @var array
     */
    protected $memory = array();

    /**
     * @var string
     */
    protected $locale;

    /**
     * @var string
     */
    protected $game;

    /**
     * @var string
     */
    protected $file;


    /**
     * @param string $game
     * @param string $locale
     */
    public function __construct($game, $locale)
    {
        $this->game   = $game;
        $this->locale = $locale;
        $this->file   = dirname(__DIR__) . '%1$sData%1$sLocale%1$s%2$s%1$s%3$s.php';
    }

    /**
     * @inheritdoc
     */
    public function get($key)
    {
        list($type, $key) = explode('.', $key);

        if (!isset($this->memory[$this->locale][$this->game])) {
            $this->memory[$this->locale][$this->game] = include sprintf(
                $this->file, DIRECTORY_SEPARATOR, $this->game, $this->locale
            );
        }
        if (isset($this->memory[$this->locale][$this->game][$type][$key])) {
            return $this->memory[$this->locale][$this->game][$type][$key];
        }

        return null;
    }

    /**
     * @param  string $value
     * @return self
     */
    public function setLocale($value)
    {
        $this->locale = $value;

        return $this;
    }

    /**
     * @param  string $value
     * @return self
     */
    public function setFile($value)
    {
        $this->file = $value;

        return $this;
    }

    /**
     * @param  string $value
     * @return self
     */
    public function setGame($value)
    {
        $this->game = $value;

        return $this;
    }
}