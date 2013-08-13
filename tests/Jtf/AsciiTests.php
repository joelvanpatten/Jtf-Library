<?php
/**
 * @category    Jtf
 *
 * @package     Jtf_AsciiTests
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
class Jtf_AsciiTests extends KissUnitTest
{
    public function test_normalizeSpecialCharacters_does_not_alter_ascii()
    {
        $input  = "abcxyz12390!@#$%^&*()-=_+[]{}|;':,./<>?~`";
        $output = Jtf_Ascii::normalizeSpecialCharacters($input);
        
        $this->assertEqual($input, $output);
    }

    public function test_removeNonAscii_removes_smart_quotes()
    {
        $input    = "abc“”";
        $actual   = Jtf_Ascii::removeNonAsciiPrintable($input);
        $expected = "abc\"\"";
        
        $this->assertEqual($actual, $expected);
    }
    
    public function test_convertArrayToAscii_cleans_array()
    {
        $arr = array("abc" . "“" . "”", 'abcxyz12390!@#$%^&*()');
        $arr = Jtf_Ascii::convertArrayToAscii($arr);
        
        $this->assertEqual('abc""', $arr[0]);
        $this->assertEqual('abcxyz12390!@#$%^&*()', $arr[1]);
    }
}
