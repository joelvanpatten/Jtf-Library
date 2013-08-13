<?php
/**
 * @category    Jtf
 *
 * @package     Jtf_SessionTests
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
class Jtf_SessionTests extends KissUnitTest
{
    public function test_negative_maxAgeInSecs_values_throws_exception()
    {
        try
        {
            $session = new Jtf_Session(-1, 1800);
        }
        catch(Exception $e)
        {
            $e = null;
            $this->testPass();
            return;
        }
        
        $this->testFail();
        return;
    }
    
    public function test_negative_lastActivityTimeoutInSecs_values_throws_exception()
    {
        try
        {
            $session = new Jtf_Session(1800, -1);
        }
        catch(Exception $e)
        {
            $e = null;
            $this->testPass();
            return;
        }
        
        $this->testFail();
        return;
    }
    
    public function test_smaller_maxAgeInSecs_values_throws_exception()
    {
        try
        {
            $session = new Jtf_Session(1800, 1801);
        }
        catch(Exception $e)
        {
            $e = null;
            $this->testPass();
            return;
        }
        
        $this->testFail();
        return;
    }
    
    public function test_write_throws_exception_if_key_empty()
    {
        try
        {
            $session = new Jtf_Session();
            $session->write(null, 'foo');
        }
        catch(Exception $e)
        {
            $e = null;
            $this->testPass();
            return;
        }
        
        $this->testFail();
        return;
    }
    
    public function test_read_returns_null_if_key_empty()
    {
        $session = new Jtf_Session();
        $actual = $session->read(null);
        $expected = null;
        
        $this->assertEqual($actual, $expected);
        
        $session->destroy();
    }
    
    public function test_read_write()
    {
        $foo     = 'bar';
        $session = new Jtf_Session();
        
        $expected = null;
        $actual   = $session->read($foo);
        
        $this->assertEqual($actual, $expected);
        
        $expected = 'random value';
        $session->write($foo, $expected);
        $actual = $session->read($foo);
        
        $this->assertEqual($actual, $expected);
        
        $session->destroy();
    }
    
    public function test_unset()
    {
        $foo     = 'bar';
        $session = new Jtf_Session();
        
        $session->write($foo, 'random value');
        $session->unsetSessionValue($foo);
        
        $expected = null;
        $actual   = $session->read($foo);
        
        $this->assertEqual($actual, $expected);
        
        $session->destroy();
    }
}