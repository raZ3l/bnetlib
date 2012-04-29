<?php
/**
 * This file is part of the bnetlib Library.
 * Copyright (c) 2012 Eric Boh <cossish@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code. You can also view the
 * LICENSE file online at https://gitbub.com/coss/bnetlib/LISENCE
 *
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */

namespace bnetlibTest\TestAssets;

use bnetlib\Resource\ResourceInterface;

class DummyResource implements ResourceInterface
{
    protected $data;

    protected $header;

    public function getResponseHeaders()
    {
        return $this->header;
    }

    public function populate($data)
    {
        $this->data = $data;
    }

    public function getData()
    {
        return $this->data;
    }

    public function setResponseHeaders(\stdClass $headers)
    {
        $this->header = $headers;
    }
}