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

namespace bnetlib\Resource\Entity\Wow\Arena;

use bnetlib\Resource\Entity\Wow\Shared\Character as BaseCharacter;

/**
 * @category   bnetlib
 * @package    Resource
 * @subpackage WorldOfWarcraft
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */
class Character extends BaseCharacter
{
    /**
     * @inheritdoc
     */
    public function populate($data)
    {
        parent::populate($data);

        $this->data['stats'] = $this->serviceLocator->get('wow.entity.arena.statistic');
        if (isset($this->headers)) {
            $this->data['stats']->setResponseHeaders($this->headers);
        }
        $this->data['stats']->populate($data['statistic']);
    }

    /**
     * @return \bnetlib\Resource\Entity\Wow\ArenaLadder\Statistic
     */
    public function getStatistic()
    {
        return $this->data['stats'];
    }
}