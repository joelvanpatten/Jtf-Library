<?php
/**
 * @category    Jtf
 *
 * @package     Jtf_DecimalTests
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
class Jtf_DecimalTests extends KissUnitTest
{
    public function test_add()
    {
        $d1 = new Jtf_Decimal('1.1');
        $d2 = new Jtf_Decimal('2.2');
        $d3 = $d1->add($d2);
        
        $expected = '3.3';
        $actual   = $d3->toString();
        
        $this->assertEqual($actual, $expected);
    }
    
    public function test_subtract()
    {
        $d1 = new Jtf_Decimal('3.3');
        $d2 = new Jtf_Decimal('2.2');
        $d3 = $d1->subtract($d2);
        
        $expected = '1.1';
        $actual   = $d3->toString();
        
        $this->assertEqual($actual, $expected);
    }
    
    public function test_multiply()
    {
        $d1 = new Jtf_Decimal('3.3');
        $d2 = new Jtf_Decimal('2.2');
        $d3 = $d1->multiply($d2);
        
        $expected = '7.26';
        $actual   = $d3->toString();
        
        $this->assertEqual($actual, $expected);
    }
    
    public function test_divide()
    {
        $d1 = new Jtf_Decimal('3.3');
        $d2 = new Jtf_Decimal('2.2');
        $d3 = $d1->divide($d2);
        
        $expected = '1.5';
        $actual   = $d3->toString();
        
        $this->assertEqual($actual, $expected);
    }
    
    public function test_pow()
    {
        $d1 = new Jtf_Decimal('3.3');
        $d2 = new Jtf_Decimal('2');
        $d3 = $d1->pow($d2);
        
        $expected = '10.89';
        $actual   = $d3->toString();
        
        $this->assertEqual($actual, $expected);
    }
    
    public function test_compare()
    {
        $d1 = new Jtf_Decimal(3.3);
        $d2 = new Jtf_Decimal(2.0);
        $d3 = new Jtf_Decimal(2.0);
        
        $expected = -1;
        $actual   = $d2->compare($d1);
        
        $this->assertEqual($actual, $expected);
        
        $expected = 1;
        $actual   = $d1->compare($d2);
        
        $this->assertEqual($actual, $expected);
        
        $expected = 0;
        $actual   = $d2->compare($d3);
        
        $this->assertEqual($actual, $expected);
    }
    
    public function test_toString()
    {
        $d1 = new Jtf_Decimal('3.3');
        
        $expected = '3.3';
        $actual   = $d1->toString();
        
        $this->assertEqual($actual, $expected);
    }
    
    public function test_sprintf()
    {
        $d = new Jtf_Decimal(2.1);
        $format = '%04s';
        
        $expected = '02.1';
        $actual   = $d->sprintf($format);
        
        $this->assertEqual($actual, $expected);
    }
}