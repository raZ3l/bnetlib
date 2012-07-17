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

namespace bnetlib\Resource\Entity\Shared;

use bnetlib\Resource\Entity\EntityInterface;
use bnetlib\ServiceLocator\ServiceLocatorInterface;

/**
 * @category   bnetlib
 * @package    Resource
 * @subpackage Shared
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */
class Image implements EntityInterface
{
    /**#@+
     * @var string
     */
    protected $fileExtension      = '.jpg';
    protected $fileExtensionRegex = '\.(jpeg|jpg)';
    /**#@-*/

    /**
     * @var string
     */
    protected $data;

    /**
     * @var array|null
     */
    protected $headers;

    /**
     * @var ServiceLocatorInterface
     */
    protected $serviceLocator;

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
     * Sets a new extension and RegEx pattern.
     *
     * @param string $ext
     * @param string $regex
     */
    public function setFileExtension($ext, $regex)
    {
        $this->fileExtension      = $ext;
        $this->fileExtensionRegex = $regex;
    }

    /**
     * Returns the image as binary string.
     *
     * @return string
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Saves the file as $name. If your file name does not end with $this->fileExtension
     * (jpeg or jpg), the file extension "jpg" will be used.
     *
     * The used file extension may vary. See setFileExtension();
     *
     * @param  string $name
     * @return boolean
     */
    public function saveAs($name)
    {
        if (!preg_match('/' . $this->fileExtensionRegex . '$/i', $name)) {
            $name .= $this->fileExtension;
        }

        if (@file_put_contents($name, $this->data) === false) {
            return false;
        }

        return true;
    }
}