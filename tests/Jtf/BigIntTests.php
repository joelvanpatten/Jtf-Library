<?php
/**
 * @category    Jtf
 *
 * @package     Jtf_BigIntTests
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
class Jtf_BigIntTests extends KissUnitTest
{
    public function test_add()
    {
        $i1 = new Jtf_BigInt(2);
        $i2 = new Jtf_BigInt(3);
        $i3 = $i1->add($i2);
        
        $expected = '5';
        $actual   = $i3->toString();
        
        $this->assertEqual($actual, $expected);
    }
    
    public function test_sutract()
    {
        $i1 = new Jtf_BigInt(5);
        $i2 = new Jtf_BigInt(3);
        $i3 = $i1->subtract($i2);
        
        $expected = '2';
        $actual   = $i3->toString();
        
        $this->assertEqual($actual, $expected);
    }
    
    public function test_multiply()
    {
        $i1 = new Jtf_BigInt(2);
        $i2 = new Jtf_BigInt(3);
        $i3 = $i1->multiply($i2);
        
        $expected = '6';
        $actual   = $i3->toString();
        
        $this->assertEqual($actual, $expected);
    }
    
    public function test_divide()
    {
        $i1 = new Jtf_BigInt(6);
        $i2 = new Jtf_BigInt(2);
        $i3 = $i1->divide($i2);
        
        $expected = '3';
        $actual   = $i3->toString();
        
        $this->assertEqual($actual, $expected);
    }
    
    public function test_modulus()
    {
        $i1 = new Jtf_BigInt(10);
        $i2 = new Jtf_BigInt(3);
        $i3 = $i1->modulus($i2);
        
        $expected = '1';
        $actual   = $i3->toString();
        
        $this->assertEqual($actual, $expected);
    }
    
    public function test_compare()
    {
        $i1 = new Jtf_BigInt(6);
        $i2 = new Jtf_BigInt(3);

        $expected = 1;
        $actual   = $i1->compare($i2);
        
        $this->assertEqual($actual, $expected);
        
        
        $i1 = new Jtf_BigInt(3);
        $i2 = new Jtf_BigInt(3);

        $expected = 0;
        $actual   = $i1->compare($i2);
        
        $this->assertEqual($actual, $expected);
        
        
        $i1 = new Jtf_BigInt(3);
        $i2 = new Jtf_BigInt(6);

        $expected = -1;
        $actual   = $i1->compare($i2);
        
        $this->assertEqual($actual, $expected);
    }
    
    public function test_toString()
    {
        $i = new Jtf_BigInt(6);

        $expected = '6';
        $actual   = $i->toString();
        
        $this->assertEqual($actual, $expected);
        
        $i = new Jtf_BigInt(0);

        $expected = '0';
        $actual   = $i->toString();
        
        $this->assertEqual($actual, $expected);
        
        $i = new Jtf_BigInt(-6);

        $expected = '-6';
        $actual   = $i->toString();
        
        $this->assertEqual($actual, $expected);
    }
    
    public function test_sprintf()
    {
        $i1 = new Jtf_BigInt(2);
        $format = '%02s';
        
        $expected = '02';
        $actual   = $i1->sprintf($format);
        
        $this->assertEqual($actual, $expected);
    }
}