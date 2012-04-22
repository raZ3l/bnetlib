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
class Achievement implements ResourceInterface
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
    public function getId()
    {
        $this->data['a'];
    }

    /**
     * @return int
     */
    public function getTimestamp()
    {
        $this->data['ts'];
    }

    /**
     * @return int
     */
    public function getCriteria()
    {
        $this->data['c'];
    }

    /**
     * @return int
     */
    public function getCriteriaQuantity()
    {
        $this->data['cq'];
    }

    /**
     * @return int
     */
    public function getCriteriaTimestamp()
    {
        $this->data['cts'];
    }

    /**
     * @return int
     */
    public function getCriteriaCreated()
    {
        $this->data['cc'];
    }


}