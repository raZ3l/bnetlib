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
use bnetlib\ServiceLocator\ServiceLocatorInterface;

class FakeResource implements ResourceInterface
{
    protected $data;

    protected $header;

    protected $locator;

    public function populate($data)
    {
        $this->data = $data;
    }

    public function getResponseHeaders()
    {
        return $this->header;
    }

    public function setResponseHeaders(\stdClass $headers)
    {
        $this->header = $headers;
    }

    public function setServiceLocator(ServiceLocatorInterface $locator)
    {
        $this->locator = $locator;
    }

    public function getData()
    {
        return $this->data;
    }
}