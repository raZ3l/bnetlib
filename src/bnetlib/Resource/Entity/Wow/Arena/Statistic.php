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

namespace bnetlib\Resource\Entity\Wow\Arena;

use bnetlib\Resource\Entity\EntityInterface;
use bnetlib\ServiceLocator\ServiceLocatorInterface;

/**
 * @category   bnetlib
 * @package    Resource
 * @subpackage WorldOfWarcraft
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */
class Statistic implements EntityInterface
{
    /**
     * @inheritdoc
     */
    protected $data = array();

    /**
     * @inheritdoc
     */
    public function populate($data)
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
     * @return integer
     */
    public function getRank()
    {
        return $this->data['rank'];
    }

    /**
     * @return integer
     */
    public function gePlayed()
    {
        return $this->data['gamesPlayed'];
    }

    /**
     * @return integer
     */
    public function getWon()
    {
        return $this->data['gamesWon'];
    }

    /**
     * @return integer
     */
    public function getLost()
    {
        return $this->data['gamesLost'];
    }

    /**
     * @return integer
     */
    public function getSessionPlayed()
    {
        return $this->data['sessionGamesPlayed'];
    }

    /**
     * @return integer
     */
    public function getSessionWon()
    {
        return $this->data['sessionGamesWon'];
    }

    /**
     * @return integer
     */
    public function getSessionLost()
    {
        return $this->data['sessionGamesLost'];
    }

    /**
     * @return integer
     */
    public function getRating()
    {
        return $this->data['personalRating'];
    }
}