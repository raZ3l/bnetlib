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

use bnetlib\Resource\Entity\ConsumeInterface;
use bnetlib\ServiceLocator\ServiceLocatorInterface;

/**
 * @category   bnetlib
 * @package    Resource
 * @subpackage WorldOfWarcraft
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */
class Record implements ConsumeInterface
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
     * @var bnetlib\ServiceLocator\ServiceLocatorInterface
     */
    protected $serviceLocator;

    /**
     * @inheritdoc
     */
    public function populate($data)
    {
        $this->data = $data;

        $data['character']['lastModified'] = $data['lastModified'];

        $this->data['character'] = $this->serviceLocator->get('wow.entity.character');
        if (isset($this->headers)) {
            $this->data['character']->setResponseHeaders($this->headers);
        }
        $this->data['character']->populate($data['character']);
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
     * @inheritdoc
     */
    public function consume()
    {
        return array(
            'slug' => $this->data['realm']['slug'],
            'bgslug' => $this->data['battlegroup']['slug'],
            'character' => $this->data['character']->getName(),
        );
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
    public function getRating()
    {
        return $this->data['bgRating'];
    }

    /**
     * @return int
     */
    public function getWins()
    {
        return $this->data['wins'];
    }

    /**
     * @return int
     */
    public function getPlayed()
    {
        return $this->data['played'];
    }

    /**
     * @return int
     */
    public function getLosses()
    {
        return $this->data['losses'];
    }

    /**
     * @return int
     */
    public function getLastModified()
    {
        return $this->data['lastModified'];
    }

    /**
     * @return string
     */
    public function getRealm()
    {
        return $this->data['realm']['name'];
    }

    /**
     * @return string
     */
    public function getRealmSlug()
    {
        return $this->data['realm']['slug'];
    }

    /**
     * @return string
     */
    public function getBattlegroup()
    {
        return $this->data['battlegroup']['name'];
    }

    /**
     * @return string
     */
    public function getBattlegroupSlug()
    {
        return $this->data['battlegroup']['slug'];
    }

    /**
     * @return bnetlib\Resource\Entity\Wow\Character
     */
    public function getCharacter()
    {
        return $this->data['character'];
    }
}