<?php
/**
 * @category    Jtf
 *
 * @package     Jtf_Http_CodesTests
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
class Jtf_HttpCodesTests extends KissUnitTest
{
    /** var Jtf_Http_Codes */
    private $_httpCodes;
    
    public function setUp()
    {
        parent::setUp();
        
        $this->_httpCodes = new Jtf_HttpCodes();
    }
    
    public function tearDown()
    {
        parent::tearDown();
        
        $this->_httpCodes = null;
    }
    
    public function test_200_returns_correct_message()
    {
        $expected = '200 OK';
        $actual   = $this->_httpCodes->getCodeMessage(200);
        
        $this->assertEqual($expected, $actual);
    }
    
    public function test_301_returns_correct_message()
    {
        $expected = '301 Moved Permanently';
        $actual   = $this->_httpCodes->getCodeMessage(301);
        
        $this->assertEqual($expected, $actual);
    }
    
    public function test_404_returns_correct_message()
    {
        $expected = '404 Not Found';
        $actual   = $this->_httpCodes->getCodeMessage(404);
        
        $this->assertEqual($expected, $actual);
    }
}