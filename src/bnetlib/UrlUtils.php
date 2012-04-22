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
 * @package   UrlUtils
 * @copyright 2012 Eric Boh <cossish@gmail.com>
 * @license   https://gitbub.com/coss/bnetlib/LISENCE     MIT License
 */

namespace bnetlib;

/**
 * @category  bnetlib
 * @package   UrlUtils
 * @copyright 2012 Eric Boh <cossish@gmail.com>
 * @license   https://gitbub.com/coss/bnetlib/LISENCE     MIT License
 */
class UrlUtils
{
    /**
     * @var array
     */
    static protected $replaceRuleSets = array(
        array(array('-', '\'', '(', ')', '/'), ''),
        array(' ', '-'),
        array('--', '-')
      );

    /**
     * @var array
     */
    static protected $normalizeCharacter = array(
       'À' => 'A',  'Á' => 'A',  'Â' => 'A',
       'Ã' => 'A',  'Ä' => 'A',  'Å' => 'A',
       'Æ' => 'A',  'Ç' => 'C',  'È' => 'E',
       'É' => 'E',  'Ê' => 'E',  'Ë' => 'E',
       'Ì' => 'I',  'Í' => 'I',  'Î' => 'I',
       'Ï' => 'I',  'Ð' => 'Dj', 'Ñ' => 'N',
       'Ò' => 'O',  'Ó' => 'O',  'Ô' => 'O',
       'Õ' => 'O',  'Ö' => 'O',  'Ø' => 'O',
       'Ù' => 'U',  'Ú' => 'U',  'Û' => 'U',
       'Ü' => 'U',  'Ý' => 'Y',  'Þ' => 'B',
       'ß' => 'Ss', 'à' => 'a',  'á' => 'a',
       'â' => 'a',  'ã' => 'a',  'ä' => 'a',
       'å' => 'a',  'æ' => 'a',  'ç' => 'c',
       'è' => 'e',  'é' => 'e',  'ê' => 'e',
       'ë' => 'e',  'ì' => 'i',  'í' => 'i',
       'î' => 'i',  'ï' => 'i',  'ð' => 'o',
       'ñ' => 'n',  'й' => 'и',  'ò' => 'o',
       'ó' => 'o',  'ô' => 'o',  'õ' => 'o',
       'ö' => 'o',  'ø' => 'o',  'ù' => 'u',
       'ú' => 'u',  'û' => 'u',  'ý' => 'y',
       'þ' => 'b',  'ÿ' => 'y',  'Š' => 'S',
       'š' => 's',  'Ž' => 'Z',  'ž' => 'z',
       'ƒ' => 'f'
    );

    /**
     * @param  string $realm
     * @return string
     */
    static public function slug($realm)
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
