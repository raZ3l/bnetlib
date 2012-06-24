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
 * @subpackage UnitTests
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */

namespace bnetlibTest;

use bnetlib\UrlUtils;

/**
 * @category   bnetlib
 * @package    Resource
 * @subpackage UnitTests
 * @group      Configuration
 * @copyright  2012 Eric Boh <cossish@gmail.com>
 * @license    http://coss.gitbub.com/bnetlib/license.html    MIT License
 */
class UrlUtilsTest extends \PHPUnit_Framework_TestCase
{
    public function testSlugStrippingCharacters()
    {
        $name = 'Simple (Te\'st / cool-hmm)';
        $slug = 'simple-test-coolhmm';

        $this->assertEquals(UrlUtils::slug($name), $slug);
    }

    public function testSlugNormalizingSpecialCharacters()
    {
        $name = 'La Croisade écarlate';
        $slug = 'la-croisade-ecarlate';
        $this->assertEquals(UrlUtils::slug($name), $slug);

        $name = 'Marécage de Zangar';
        $slug = 'marecage-de-zangar';
        $this->assertEquals(UrlUtils::slug($name), $slug);

        $name = 'Aggra (Português)';
        $slug = 'aggra-portugues';
        $this->assertEquals(UrlUtils::slug($name), $slug);
    }

    public function testSlugSlugUsLocale()
    {
        $name = 'Aegwynn';
        $slug = 'aegwynn';

        $this->assertEquals(UrlUtils::slug($name), $slug);
    }

    public function testSlugMxLocale()
    {
        /**
         * As for now, 2012-04-10, no Latin American realms uses special characters,
         * so this test is pretty much useless...
         * @see http://us.battle.net/support/en/article/latin-america-world-of-warcraft-faq#q-3
         */
        $name = 'Aegwynn';
        $slug = 'aegwynn';

        $this->assertEquals(UrlUtils::slug($name), $slug);
    }

    public function testSlugBrLocale()
    {
        /**
         * Same as in testSlugMxLocale()
         */
        $name = 'Tol Barad';
        $slug = 'tol-barad';

        $this->assertEquals(UrlUtils::slug($name), $slug);
    }

    public function testSlugGbLocale()
    {
        $name = 'Blade\'s Edge';
        $slug = 'blades-edge';

        $this->assertEquals(UrlUtils::slug($name), $slug);
    }

    public function testSlugEsLocale()
    {
        /**
         * Same as in testSlugMxLocale()
         */
        $name = 'Shen\'dralar';
        $slug = 'shendralar';

        $this->assertEquals(UrlUtils::slug($name), $slug);
    }

    public function testSlugFrLocale()
    {
        $name = 'Chants éternels';
        $slug = 'chants-eternels';

        $this->assertEquals(UrlUtils::slug($name), $slug);
    }

    public function testSlugRuLocale()
    {
        $name = 'Борейская тундра';
        $slug = 'бореиская-тундра';

        $this->assertEquals(UrlUtils::slug($name), $slug);
    }

    public function testSlugDeLocale()
    {
        $name = 'Die ewige Wacht';
        $slug = 'die-ewige-wacht';

        $this->assertEquals(UrlUtils::slug($name), $slug);
    }

    public function testSlugItLocale()
    {
        /**
         * As for now, 2012-04-10, there are no Italian realms
         */
        $name = 'Burning Legion';
        $slug = 'burning-legion';

        $this->assertEquals(UrlUtils::slug($name), $slug);
    }

    public function testSlugPtLocale()
    {
        $name = 'Aggra (Português)';
        $slug = 'aggra-portugues';

        $this->assertEquals(UrlUtils::slug($name), $slug);
    }

    public function testSlugKrLocale()
    {
        $name = '쿨 티라스';
        $slug = '쿨-티라스';

        $this->assertEquals(UrlUtils::slug($name), $slug);
    }

    public function testSlugTwLocale()
    {
        $name = '世界之樹';
        $slug = '世界之樹';

        $this->assertEquals(UrlUtils::slug($name), $slug);
    }

    public function testSlugCnLocale()
    {
        $name = '万色星辰';
        $slug = '万色星辰';

        $this->assertEquals(UrlUtils::slug($name), $slug);
    }
}