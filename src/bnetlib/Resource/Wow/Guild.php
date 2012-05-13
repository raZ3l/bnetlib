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

namespace bnetlib\Resource\Wow;

use bnetlib\Resource\ConsumeInterface;
use bnetlib\Resource\Wow\Shared\GuildEmblem;

/**
 * @category   bnetlib
 * @package    Resource
 * @subpackage WorldOfWarcraft
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */
class Guild extends GuildEmblem implements ConsumeInterface
{
    /**
     * @var array
     */
    protected $fields = array(
        'news'         => 'bnetlib\Resource\Wow\Guild\News',
        'members'      => 'bnetlib\Resource\Wow\Guild\Members',
        'achievements' => 'bnetlib\Resource\Wow\Achievements\Achievements',
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
    public function populate($data)
    {
        $this->data =  $data;

        foreach ($this->fields as $field => $class) {
            if (isset($data[$field])) {
                $this->data[$field] = new $class();
                if (isset($this->headers)) {
                    $this->data[$field]->setResponseHeaders($this->headers);
                }
                $this->data[$field]->populate($data[$field]);
            }
        }

        foreach ($data['emblem'] as $key => $value) {
            $this->data[$key] = $value;
        }

        unset($this->fields, $this->data['emblem']);
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
    public function consume()
    {
        return array('realm' => $this->data['realm']);
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
    public function getName()
    {
        return $this->data['name'];
    }

    /**
     * @return string
     */
    public function getRealm()
    {
        return $this->data['realm'];
    }

    /**
     * @return int
     */
    public function getLevel()
    {
        return $this->data['level'];
    }

    /**
     * @return int
     */
    public function getFaction()
    {
        return $this->data['side'];
    }

    /**
     * @return int
     */
    public function getAchievementPoints()
    {
        return $this->data['achievementPoints'];
    }

    /**
     * @return bnetlib\Resource\Wow\Guild\Members|null
     */
    public function getMembers()
    {
        if (isset($this->data['members'])) {
            return $this->data['members'];
        }

        return null;
    }

    /**
     * @return bnetlib\Resource\Wow\Achievements\Achievements|nul
     */
    public function getAchievements()
    {
        if (isset($this->data['achievements'])) {
            return $this->data['achievements'];
        }

        return null;
    }

    /**
     * @return bnetlib\Resource\Wow\Achievements\News|nul
     */
    public function getNews()
    {
        if (isset($this->data['news'])) {
            return $this->data['news'];
        }

        return null;
    }
}