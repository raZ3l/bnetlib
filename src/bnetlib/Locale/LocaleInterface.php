<?php
/**
 * This file is part of the bnetlib Library.
 * Copyright (c) 2012 Eric Boh <cossish@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code. You can also view the
 * LICENSE file online at https://gitbub.com/coss/bnetlib/LISENCE
 *
 * @category  bnetlib
 * @package   Locale
 * @copyright 2012 Eric Boh <cossish@gmail.com>
 * @license   https://gitbub.com/coss/bnetlib/LISENCE     MIT License
 */

namespace bnetlib\Locale;

/**
 * @category  bnetlib
 * @package   Locale
 * @copyright 2012 Eric Boh <cossish@gmail.com>
 * @license   https://gitbub.com/coss/bnetlib/LISENCE     MIT License
 */
interface LocaleInterface
{
    /**
     * @param  string $key
     * @return string|null
     */
    public function get($key);
}