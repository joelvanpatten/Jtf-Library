<?php
/**
 * @category    Jtf
 *
 * @package     Jtf_AbstractEntityTests
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
class Jtf_AbstractEntityTests extends KissUnitTest
{
    public function test_ctor_properly_initializes_object()
    {
        $o = new Jtf_ConcreteEntity();
        
        $this->assertEqual($o->getId(), 0);
        $this->assertEqual($o->getCreated(), '');
        $this->assertEqual($o->getUpdated(), '');
    }
    
    public function test_id_getter_setter()
    {
        $v = new Jtf_ConcreteEntity();
        $v->setId(3);
        
        $expected = 3;
        $actual   = $v->getId();
        
        $this->assertEqual($actual, $expected);
    }
    
    public function test_created_getter_setter()
    {
        $v = new Jtf_ConcreteEntity();
        $v->setCreated('2013-10-01 12:55:10');
        
        $expected = '2013-10-01 12:55:10';
        $actual   = $v->getCreated();
        
        $this->assertEqual($actual, $expected);
    }
    
    public function test_updated_getter_setter()
    {
        $v = new Jtf_ConcreteEntity();
        $v->setUpdated('2013-10-01 12:55:11');
        
        $expected = '2013-10-01 12:55:11';
        $actual   = $v->getUpdated();
        
        $this->assertEqual($actual, $expected);
    }
    
    public function test_getValidationMessages_returns_validation_messages()
    {
        $v = new Jtf_ConcreteEntity();
        $v->isValid();
        $msgs = $v->getValidationMessages();
        
        $msg1 = $msgs[0];
        $msg2 = $msgs[1];
        
        $this->assertEqual($msg1, 'message 1');
        $this->assertEqual($msg2, 'message 2');
    }
}
