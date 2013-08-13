<?php
/**
 * @category    Jtf
 *
 * @package     Jtf_BcryptTests
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
class Jtf_BcryptTests extends KissUnitTest
{
    public function test_verify_works()
    {
        $bcrypt = new Jtf_Bcrypt(4);
        $salt   = $bcrypt->generateSalt();
        $input  = 'somix65';
        $hash   = $bcrypt->calculateHash($salt, $input);
        
        $verifyMatch = $bcrypt->verify($input, $salt, $hash);
        $verifyNomatch = $bcrypt->verify('badpassword', $salt, $hash);
        
        $this->assertFalse($verifyNomatch);
        $this->assertTrue($verifyMatch);
    }
    
    public function test_hash_length()
    {
        $bcrypt = new Jtf_Bcrypt(4);
        $salt   = $bcrypt->generateSalt();
        $input  = 'somix65';
        $hash   = $bcrypt->calculateHash($salt, $input);
        
        $expected = 39;
        $actual   = strlen($hash);
        
        $this->assertEqual($actual, $expected);
    }
    
    public function test_salt_length_is_22()
    {
        $bcrypt = new Jtf_Bcrypt();
        $salt   = $bcrypt->generateSalt();
        
        $expected = 22;
        $actual   = strlen($salt);

        $this->assertEqual($actual, $expected, $salt);
    }
    
    public function test_cost_too_low_throws_exception()
    {
        try
        {
            new Jtf_Bcrypt(3);
        }
        catch (Exception $e)
        {
            $this->testPass();
            return;
        }
        
        $this->testFail();
    }
    
    public function test_cost_too_high_throws_exception()
    {
        try
        {
            new Jtf_Bcrypt(32);
        }
        catch (Exception $e)
        {
            $this->testPass();
            return;
        }
        
        $this->testFail();
    }
    
    public function test_cost_just_right_does_not_throw_exception()
    {
        try
        {
            new Jtf_Bcrypt(4);
        }
        catch (Exception $e)
        {
            $this->testFail();
            return;
        }
        
        $this->testPass();
    }
}