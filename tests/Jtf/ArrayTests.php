<?php
/**
 * @category    Jtf
 *
 * @package     Jtf_ArrayTests
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
class Jtf_ArrayTests extends KissUnitTest
{
    public function test_getElement_with_null_key_throws_exception()
    {
        $arr = array('keyOne' => 'valOne', 'keyTwo' => 'valTwo');
        $key = null;
        
        try
        {
            Jtf_Array::getElement($key, $arr);
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
    
    public function test_getElement_with_nonexistent_element_returns_default()
    {
        $arr    = array('keyOne' => 'valOne', 'keyTwo' => 'valTwo');
        $key    = 'keyThree';
        $result = Jtf_Array::getElement($key, $arr);
        
        $this->assertFalse($result);
    }
    
    public function test_getElement_with_existing_key_returns_correct_value()
    {
        $arr    = array('keyOne' => 'valOne', 'keyTwo' => 'valTwo');
        $key    = 'keyTwo';
        
        $expected = 'valTwo';
        $actual   = Jtf_Array::getElement($key, $arr);
        
        $this->assertEqual($expected, $actual);
    }
    
    public function test_getElements_with_null_keys_throws_exception()
    {
        $arr  = array('keyOne' => 'valOne', 'keyTwo' => 'valTwo');
        $keys = null;
        
        try
        {
            Jtf_Array::getElements($keys, $arr);
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
    
    public function test_getElements_with_existing_keys_returns_values()
    {
        $arr    = array('keyOne' => 'valOne', 'keyTwo' => 'valTwo');
        $keys   = array('keyTwo');
        
        $expected = array('keyTwo' => 'valTwo');
        $actual   = Jtf_Array::getElements($keys, $arr);
        
        $this->assertEqual($expected, $actual);
        
        $expected = 1;
        $actual   = count($actual);
        
        $this->assertEqual($expected, $actual);
    }
    
    public function test_getElements_within_nonexisting_keys_returns_default()
    {
        $arr    = array('keyOne' => 'valOne', 'keyTwo' => 'valTwo');
        $keys   = array('keyThree');
        
        $expected = array('keyThree' => false);
        $actual   = Jtf_Array::getElements($keys, $arr);
        
        $this->assertEqual($expected, $actual);
        
        $expected = 1;
        $actual   = count($actual);
        
        $this->assertEqual($expected, $actual);
    }
    
    public function test_getRandomElement_throws_an_exception_on_nonarray()
    {
        try
        {
            Jtf_Array::getRandomElement(null);
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
    
    public function test_test_getRandomElement_returns_single_random_element()
    {
        $arr    = array('keyOne' => 'valOne', 'keyTwo' => 'valTwo');
        $result = Jtf_Array::getRandomElement($arr);
        
        if($result != 'valOne' && $result != 'valTwo')
        {
            $this->testFail('result mismatch');
            return;
        }
        
        if(strlen($result) == 0)
        {
            $this->testFail('empty result');
            return;
        }
        
        $this->testPass();
    }
}