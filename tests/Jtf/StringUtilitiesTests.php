<?php
/**
 * @category    Jtf
 *
 * @package     Jtf_StringUtilitiesTests
 *
 * @copyright   Copyright (C) 2011 Joseph Fallon <joseph.t.fallon@gmail.com>
 *              All rights reserved.
 *
 * @license     REDISTRIBUTION AND USE IN SOURCE AND BINARY FORMS, WITH OR
 *              WITHOUT MODIFICATION, IS NOT PERMITTED WITHOUT EXPRESS
 *              WRITTEN APPROVAL OF THE AUTHOR.
 *
 *              THIS SOFTWARE IS PROVIDED BY THE AUTHOR "AS IS" AND ANY
 *              EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO,
 *              THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A
 *              PARTICULAR PURPOSE ARE DISCLAIMED.  IN NO EVENT SHALL THE
 *              AUTHOR BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 *              SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT
 *              NOT LIMITED TO, PROCUREMENT OF  SUBSTITUTE GOODS OR SERVICES;
 *              LOSS OF USE, DATA, OR PROFITS;  OR BUSINESS INTERRUPTION)
 *              HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN
 *              CONTRACT, STRICT LIABILITY, OR TORT INCLUDING NEGLIGENCE OR
 *              OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
 *              SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 */
class Jtf_StringUtilitiesTests extends KissUnitTest
{
    public function test_stripFwdSlashes_removes_slashes_from_front_and_back()
    {
        $input    = '/this/that/theother/';
        $actual   = Jtf_StringUtilities::striptFwdSlashes($input);
        $expected = 'this/that/theother';

        $this->assertEqual($actual, $expected);
    }
    
    public function test_stripBackSlashes_removes_slashes_from_string()
    {
        $input    = '\this\that\theother\\';
        $actual   = Jtf_StringUtilities::stripBackSlashes($input);
        $expected = 'thisthattheother';

        $this->assertEqual($actual, $expected);
    }
    
    public function test_stripBackSlashes_removes_slashes_from_array()
    {
        $input = array();
        $input[] = '\1\2\3\\';
        $input[] = '\4\5\6\\';
        
        $actual  = Jtf_StringUtilities::stripBackSlashes($input);
        
        $this->assertEqual($actual[0], '123', 'index 0');
        $this->assertEqual($actual[1], '456', 'index 1');
    }
    
    public function test_stripQuotes_removes_double_quotes()
    {
        $input    = '"this"that"theother"';
        $actual   = Jtf_StringUtilities::stripQuotes($input);
        $expected = 'thisthattheother';

        $this->assertEqual($actual, $expected);
    }
    
    public function test_stripQuotes_removes_single_quotes()
    {
        $input    = '\'this\'that\'theother\'';
        $actual   = Jtf_StringUtilities::stripQuotes($input);
        $expected = 'thisthattheother';

        $this->assertEqual($actual, $expected);
    }
    
    public function test_convertQuotesToEntities_properly_converts_quotes()
    {
        $input    = '\'this"that"theother\'';
        $actual   = Jtf_StringUtilities::convertQuotesToEntities($input);
        $expected = '\'this&quot;that&quot;theother\'';

        $this->assertEqual($actual, $expected);
    }
    
    public function test_reduceCharacterMultiples_properly_removes_doubles_and_surrounding()
    {
        $input    = ',Fred, Bill,, Joe, Jimmy,';
        $actual   = Jtf_StringUtilities::reduceCharacterMultiples($input, ',', true);
        $expected = 'Fred, Bill, Joe, Jimmy';

        $this->assertEqual($actual, $expected);
    }
    
    public function test_randomString_alpha_is_correct_length()
    {
        $randomString   = Jtf_StringUtilities::randomString('alpha');
        $expectedLength = 8;
        $actualLength   = strlen($randomString);
        
        //Debug::dump('$randomString', $randomString);
        
        $this->assertEqual($expectedLength, $actualLength);
    }
    
    public function test_randomString_unique_is_correct_length()
    {
        $randomString   = Jtf_StringUtilities::randomString('unique');
        $expectedLength = 32;
        $actualLength   = strlen($randomString);
        
        //Debug::dump('$randomString', $randomString);
        
        $this->assertEqual($expectedLength, $actualLength);
    }
    
    public function test_randomString_encrypt_is_correct_length()
    {
        $randomString   = Jtf_StringUtilities::randomString('encrypt');
        $expectedLength = 40;
        $actualLength   = strlen($randomString);
        
        //Debug::dump('$randomString', $randomString);
        
        $this->assertEqual($expectedLength, $actualLength);
    }
    
    public function test_randomString_sha256_is_correct_length()
    {
        $randomString   = Jtf_StringUtilities::randomString('sha256');
        $expectedLength = 64;
        $actualLength   = strlen($randomString);
        
        //Debug::dump('$randomString', $randomString);
        
        $this->assertEqual($expectedLength, $actualLength);
    }
    
    public function test_randomString_sha512_is_correct_length()
    {
        $randomString   = Jtf_StringUtilities::randomString('sha512');
        $expectedLength = 128;
        $actualLength   = strlen($randomString);
        
        //Debug::dump('$randomString', $randomString);
        
        $this->assertEqual($expectedLength, $actualLength);
    }
    
    public function test_wordLimiter_limits_words()
    {
        $input    = 'Mary had a little lamb.';
        $actual   = Jtf_StringUtilities::wordLimiter($input, 3);
        $expected = 'Mary had a&#8230;';

        $this->assertEqual($actual, $expected);
    }
    
    public function test_characterLimiter_limits_characters()
    {
        $input    = 'Mary had a little lamb.';
        $actual   = Jtf_StringUtilities::characterLimiter($input, 4);
        $expected = 'Mary&#8230;';

        $this->assertEqual($actual, $expected);
    }
    
    public function test_wordCensor_removes_bad_words()
    {
        $input    = 'Mary had a little lamb.';
        $censored = array('little');
        $actual   = Jtf_StringUtilities::wordCensor($input, $censored);
        $expected = 'Mary had a ###### lamb.';

        //Debug::dump('$expected', $expected);
        
        $this->assertEqual($actual, $expected);
    }
    
    public function test_highlightPhrase_properly_highlights_phrase()
    {
        $input    = 'Mary had a little lamb.';
        $phrase   = 'had a little';
        $actual   = Jtf_StringUtilities::highlightPhrase($input, $phrase);
        $expected = 'Mary <strong>had a little</strong> lamb.';
        
        //Debug::dump('$expected', $expected);
        
        $this->assertEqual($actual, $expected);
    }
    
}

