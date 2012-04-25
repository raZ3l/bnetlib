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

namespace bnetlib\Resource\Wow\Shared;

use bnetlib\Resource\ResourceInterface;

/**
 * @category   bnetlib
 * @package    Resource
 * @subpackage WorldOfWarcraft
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    https://gitbub.com/coss/bnetlib/LISENCE     MIT License
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
     * @inheritdoc
     */
    public function populate(array $data)
    {
        foreach ($data['achievementsCompleted'] as $i => $av) {
            $this->index[$av] = $i;
            $achievement      = new Achievement();
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
     * @param  int $id
     * @return bnetlib\Resource\Wow\Shared\Achievement|null
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