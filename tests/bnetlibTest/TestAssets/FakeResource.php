<?php
/**
 * This file is part of the bnetlib Library.
 * Copyright (c) 2012 Eric Boh <cossish@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code. You can also view the
 * LICENSE file online at http://coss.github.com/bnetlib/license.html
 *
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */

namespace bnetlibTest\TestAssets;

use bnetlib\Resource\Entity\EntityInterface;
use bnetlib\ServiceLocator\ServiceLocatorInterface;

class FakeResource implements EntityInterface
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

    public function setResponseHeaders($headers)
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