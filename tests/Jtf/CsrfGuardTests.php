<?php
/**
 * @category    Jtf
 *
 * @package     Jtf_CsrfGuardTests
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
class Jtf_CsrfGuardTests extends KissUnitTest
{
    public function setUp()
    {
        $sess = new Jtf_Session();
        $sess->destroy();
    }
    
    public function test_empty_formName_throws_exception()
    {
        try
        {
            $sess = new Jtf_Session();
            new Jtf_CsrfGuard('', $sess);
        }
        catch(Exception $e)
        {
            $e = null;
            $this->testPass();
            return;
        }
        
        $this->testFail();
    }
    
    public function test_correct_key_is_written_to_session()
    {
        $sess = new Jtf_Session();
        $name = 'test_name';
        $csrf = new Jtf_CsrfGuard($name, $sess);
        $csrf->generateToken();
        
        $token  = $sess->read($name);
        $length = strlen($token);
        
        $this->assertFirstGreaterThanSecond($length, 0);
    }
    
    public function test_correct_token_is_written_to_session()
    {
        $sess = new Jtf_Session();
        $name = 'test_name';
        $csrf = new Jtf_CsrfGuard($name, $sess);
        $token = $csrf->generateToken('some_salt');
        $out   = $sess->read($name);
        
        $this->assertEqual($out, $token);
    }
    
    public function test_token_length_is_correct()
    {
        $sess = new Jtf_Session();
        $name = 'test_name';
        $csrf = new Jtf_CsrfGuard($name, $sess);
        $token = $csrf->generateToken('some_salt');
        
        $length = strlen($token);
        
        $this->assertEqual($length, 128);
    }
    
    public function test_validateToken_returns_true_on_correct_token()
    {
        $sess = new Jtf_Session();
        $name = 'test_name';
        $csrf = new Jtf_CsrfGuard($name, $sess);
        $token = $csrf->generateToken('some_salt');
        
        $result = $csrf->validateToken($token);
        
        $this->assertTrue($result);
    }
    
    public function test_validateToken_returns_false_in_incorrect_token()
    {
        $sess = new Jtf_Session();
        $name = 'test_name';
        $csrf = new Jtf_CsrfGuard($name, $sess);
        $token = $csrf->generateToken('some_salt');
        
        $result = $csrf->validateToken('invalid token');
        
        $this->assertFalse($result);
    }
    
    public function test_validateToken_throws_exception_on_empty_token()
    {
        $sess = new Jtf_Session();
        $name = 'test_name';
        $csrf = new Jtf_CsrfGuard($name, $sess);
        $token = $csrf->generateToken('some_salt');
        
        try
        {
            $result = $csrf->validateToken('');
        }
        catch(Exception $e)
        {
            $e = null;
            $this->testPass();
            return;
        }
        
        $this->testFail();
    }
    
    public function test_validate_token_unset_session_after_validate()
    {
        $sess  = new Jtf_Session();
        $name  = 'test_name';
        $csrf  = new Jtf_CsrfGuard($name, $sess);
        $token = $csrf->generateToken('some_salt');
        
        $result = $csrf->validateToken('invalid token');
        $result = $sess->read($name);
        
        if($result != null)
        {
            $this->testFail();
            return;
        }
        
        $this->testPass();
    }
}