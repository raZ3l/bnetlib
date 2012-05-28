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

namespace bnetlib\Resource\Wow\Achievements;

use bnetlib\Resource\ResourceInterface;
use bnetlib\ServiceLocator\ServiceLocatorInterface;

/**
 * @category   bnetlib
 * @package    Resource
 * @subpackage WorldOfWarcraft
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */
class Achievements implements ResourceInterface
{
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
     * @var bnetlib\ServiceLocator\ServiceLocatorInterface
     */
    protected $serviceLocator;

    /**
     * @inheritdoc
     */
    public function populate($data)
    {
        foreach ($data['achievementsCompleted'] as $i => $av) {
            $this->index[$av] = $i;
            $achievement      = $this->serviceLocator->get('wow.achievements.achievement');
            if (isset($this->headers)) {
                $achievement->setResponseHeaders($this->headers);
            }
            $achievement->populate(array(
                'a'   => $av,
                'ts'  => $data['achievementsCompletedTimestamp'][$i],
                'c'   => $data['criteria'][$i],
                'cq'  => $data['criteriaQuantity'][$i],
                'cts' => $data['criteriaTimestamp'][$i],
                'cc'  => $data['criteriaCreated'][$i]
            ));

            $this->data[$i] = $achievement;
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
     * @param  int $id
     * @return bnetlib\Resource\Wow\Achievements\Achievement|null
     */
    public function getById($id)
    {
        if (isset($this->index[$id])) {
            return $this->data[$this->index[$id]];
        }

        return null;
    }

    /**
     * @param  int $id
     * @return boolean
     */
    public function has($id)
    {
        return isset($this->index[$id]);
    }
}