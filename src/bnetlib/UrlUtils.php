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
 * @package   Utility
 * @copyright 2012 Eric Boh <cossish@gmail.com>
 * @license   http://coss.gitbub.com/bnetlib/license.html    MIT License
 */

namespace bnetlib;

/**
 * @category  bnetlib
 * @package   Utility
 * @copyright 2012 Eric Boh <cossish@gmail.com>
 * @license   http://coss.gitbub.com/bnetlib/license.html    MIT License
 */
class UrlUtils
{
    /**
     * @var array
     */
    protected static $replaceRuleSets = array(
        array(array('-', '\'', '(', ')', '/'), ''),
        array(' ', '-'),
        array('--', '-')
    );

    /**
     * @var array
     */
    protected static $normalizeCharacter = array(
        'Ă' => 'A',
        'Ǎ' => 'A',
        'Ą' => 'A',
        'Ā' => 'A',
        'Ǻ' => 'A',
        'À' => 'A',
        'Ã' => 'A',
        'Å' => 'A',
        'Ä' => 'A',
        'Á' => 'A',
        'Â' => 'A',
        'Ǽ' => 'AE',
        'Þ' => 'B',
        'Ċ' => 'C',
        'Ĉ' => 'C',
        'Č' => 'C',
        'Ć' => 'C',
        'Ç' => 'C',
        'Đ' => 'D',
        'Ð' => 'D',
        'Ď' => 'D',
        'Ĕ' => 'E',
        'Ě' => 'E',
        'Ę' => 'E',
        'Ë' => 'E',
        'Ē' => 'E',
        'É' => 'E',
        'Ė' => 'E',
        'Ê' => 'E',
        'È' => 'E',
        'Ğ' => 'G',
        'Ĝ' => 'G',
        'Ģ' => 'G',
        'Ġ' => 'G',
        'Ħ' => 'H',
        'Ĥ' => 'H',
        'Ĭ' => 'I',
        'Ǐ' => 'I',
        'Į' => 'I',
        'Ī' => 'I',
        'Ĩ' => 'I',
        'İ' => 'I',
        'Í' => 'I',
        'Î' => 'I',
        'Ì' => 'I',
        'Ï' => 'I',
        'Ĳ' => 'IJ',
        'Ĵ' => 'J',
        'Ķ' => 'K',
        'Ļ' => 'L',
        'Ĺ' => 'L',
        'Ľ' => 'L',
        'Ŀ' => 'L',
        'Ñ' => 'N',
        'Ň' => 'N',
        'Ņ' => 'N',
        'Ń' => 'N',
        'Ó' => 'O',
        'Ö' => 'O',
        'Ô' => 'O',
        'Ò' => 'O',
        'Ơ' => 'O',
        'Ŏ' => 'O',
        'Ő' => 'O',
        'Ø' => 'O',
        'Ō' => 'O',
        'Õ' => 'O',
        'Ǒ' => 'O',
        'Ǿ' => 'O',
        'Œ' => 'OE',
        'Ř' => 'R',
        'Ŕ' => 'R',
        'Ŗ' => 'R',
        'Ŝ' => 'S',
        'Ş' => 'S',
        'Ś' => 'S',
        'Š' => 'S',
        'Ť' => 'T',
        'Ŧ' => 'T',
        'Ţ' => 'T',
        'Û' => 'U',
        'Ŭ' => 'U',
        'Ũ' => 'U',
        'Ù' => 'U',
        'Ū' => 'U',
        'Ư' => 'U',
        'Ü' => 'U',
        'Ú' => 'U',
        'Ǘ' => 'U',
        'Ǜ' => 'U',
        'Ű' => 'U',
        'Ǔ' => 'U',
        'Ů' => 'U',
        'Ų' => 'U',
        'Ǖ' => 'U',
        'Ǚ' => 'U',
        'Ŵ' => 'W',
        'Ý' => 'Y',
        'Ÿ' => 'Y',
        'Ŷ' => 'Y',
        'Ź' => 'Z',
        'Ż' => 'Z',
        'Ž' => 'Z',
        'ǎ' => 'a',
        'ǻ' => 'a',
        'ă' => 'a',
        'ā' => 'a',
        'ą' => 'a',
        'ä' => 'a',
        'ã' => 'a',
        'á' => 'a',
        'à' => 'a',
        'å' => 'a',
        'â' => 'a',
        'æ' => 'ae',
        'þ' => 'b',
        'ć' => 'c',
        'č' => 'c',
        'ç' => 'c',
        'ĉ' => 'c',
        'ċ' => 'c',
        'đ' => 'd',
        'ď' => 'd',
        'è' => 'e',
        'ē' => 'e',
        'ě' => 'e',
        'ë' => 'e',
        'ę' => 'e',
        'é' => 'e',
        'ė' => 'e',
        'ĕ' => 'e',
        'ê' => 'e',
        'ƒ' => 'f',
        'ģ' => 'g',
        'ĝ' => 'g',
        'ġ' => 'g',
        'ğ' => 'g',
        'ĥ' => 'h',
        'ħ' => 'h',
        'î' => 'i',
        'ĭ' => 'i',
        'ì' => 'i',
        'į' => 'i',
        'ĩ' => 'i',
        'ī' => 'i',
        'ǐ' => 'i',
        'ï' => 'i',
        'í' => 'i',
        'ı' => 'i',
        'ĳ' => 'ij',
        'ĵ' => 'j',
        'ķ' => 'k',
        'ĺ' => 'l',
        'Ł' => 'l',
        'ł' => 'l',
        'ŀ' => 'l',
        'ľ' => 'l',
        'ļ' => 'l',
        'ņ' => 'n',
        'ń' => 'n',
        'ň' => 'n',
        'ñ' => 'n',
        'ŉ' => 'n',
        'ǒ' => 'o',
        'ơ' => 'o',
        'ŏ' => 'o',
        'ø' => 'o',
        'õ' => 'o',
        'ò' => 'o',
        'ð' => 'o',
        'ǿ' => 'o',
        'ó' => 'o',
        'ő' => 'o',
        'ô' => 'o',
        'ö' => 'o',
        'ō' => 'o',
        'œ' => 'oe',
        'ŗ' => 'r',
        'ŕ' => 'r',
        'ř' => 'r',
        'ŝ' => 's',
        'ß' => 's',
        'š' => 's',
        'ş' => 's',
        'ś' => 's',
        'ſ' => 's',
        'ţ' => 't',
        'ť' => 't',
        'ŧ' => 't',
        'ǜ' => 'u',
        'ù' => 'u',
        'ǚ' => 'u',
        'ú' => 'u',
        'ű' => 'u',
        'ů' => 'u',
        'ŭ' => 'u',
        'ū' => 'u',
        'ǘ' => 'u',
        'ǔ' => 'u',
        'ų' => 'u',
        'û' => 'u',
        'ũ' => 'u',
        'ư' => 'u',
        'ǖ' => 'u',
        'ü' => 'u',
        'ŵ' => 'w',
        'ŷ' => 'y',
        'ÿ' => 'y',
        'ý' => 'y',
        'ż' => 'z',
        'ž' => 'z',
        'ź' => 'z',
        'й' => 'и'
    );

    /**
     * @param  string $realm
     * @return string
     */
    public static function slug($realm)
    {
        foreach (self::$replaceRuleSets as $rule) {
            $realm = str_replace($rule[0], $rule[1], $realm);
        }

        if (!preg_match('/^[a-z-]+$/i', $realm)) {
            foreach (self::$normalizeCharacter as $old => $new) {
                $realm = str_replace($old, $new, $realm);
            }
        }

        return mb_strtolower($realm, 'UTF-8');
    }
}
