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

namespace bnetlib\Resource\Wow\Arena;

use bnetlib\Resource\ResourceInterface;

/**
 * @category   bnetlib
 * @package    Resource
 * @subpackage WorldOfWarcraft
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    https://gitbub.com/coss/bnetlib/LISENCE     MIT License
 */
class Statistic implements ResourceInterface
{
    /**
     * @inheritdoc
     */
    protected $data = array();

    /**
     * @inheritdoc
     */
    public function populate(array $data)
    {
        $this->data = $data;
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
     * @return int
     */
    public function getRank()
    {
        return $this->data['rank'];
    }

    /**
     * @return int
     */
    public function gePlayed()
    {
        return $this->data['gamesPlayed'];
    }

    /**
     * @return int
     */
    public function getWon()
    {
        return $this->data['gamesWon'];
    }

    /**
     * @return int
     */
    public function getLost()
    {
        return $this->data['gamesLost'];
    }

    /**
     * @return int
     */
    public function getSessionPlayed()
    {
        return $this->data['sessionGamesPlayed'];
    }

    /**
     * @return int
     */
    public function getSessionWon()
    {
        return $this->data['sessionGamesWon'];
    }

    /**
     * @return int
     */
    public function getSessionLost()
    {
        return $this->data['sessionGamesLost'];
    }

    /**
     * @return int
     */
    public function getRating()
    {
        return $this->data['personalRating'];
    }
}