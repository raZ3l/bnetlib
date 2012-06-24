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
     * @const string
     */
    const FILE_EXTENSION       = '.jpg';
    const FILE_EXTENSION_REGEX = '\.(jpeg|jpg)';
    /**#@-*/

    /**
     * @var string
     */
    protected $data;

    /**
     * @var \stdClass|null
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
     * @return string
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Saves the file as $name. If your file name does not end with self::FILE_EXTENSION_REGEX
     * (jpeg or jpg), the file extension "jpg" will be used.
     *
     * @param  string $name
     * @return boolean
     */
    public function saveAs($name)
    {
        if (!preg_match('/' . self::FILE_EXTENSION_REGEX . '$/i', $name)) {
            $name .= self::FILE_EXTENSION;
        }

        if (@file_put_contents($name, $this->data) === false) {
            return false;
        }

        return true;
    }
}