<?php
/**
 * @category    KissTest
 *
 * @package     KissMock
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
class KissMock
{
    /** @var array */
    private $_methodCalls;
    /** @var array */
    private $_methodReturnValues;
    
    /**
     * __construct
     */
    public function __construct()
    {
        $this->_methodCalls        = array();
        $this->_methodReturnValues = array();
    }
    
    
    /**
     * methodCalled - This function should be called whenever a method in the
     *                class under test is called. It returns the previously
     *                specified return value for that method call.
     * 
     * @param  string $methodName
     * @param  array  $args
     * @return mixed
     */
    public function methodCalled($methodName, $args = null)
    {
        $this->_methodCalls[] = array(
                                        'name' => $methodName, 
                                        'args' => $args
                                     );
        
        $callCount = $this->getMethodCallCount($methodName);
        $returnVal = $this->getMethodReturnValue($methodName, $callCount);
        
        return $returnVal;
    }
    
    
    /**
     * getMethodCallCount - This function returns the number of times a method
     * has been called.
     * 
     * @param string $methodName
     * @return int
     */
    public function getMethodCallCount($methodName)
    {
        $methodName = strval($methodName);
        
        if(strlen($methodName) == 0)
        { 
            $msg = 'Method name cannot be empty.';
            throw new Exception($msg);
        }
        
        $count = 0;
        $calls = $this->_methodCalls;
        
        foreach($calls as $key => $value)
        {
            if($value['name'] == $methodName)
            {
                $count++;
            }
        }
        
        return $count;
    }
    
    
    /**
     * getMethodArgs
     * 
     * @param string $methodName - name of the method
     * @param int $callCount - This is the call count of of the arguments to
     * return.
     * @return array
     */
    public function getMethodArgs($methodName, $callCount = 1)
    {
        $methodName = strval($methodName);
        $callCount  = intval($callCount);
        
        if(strlen($methodName) == 0)
        { 
            $msg = 'Method name cannot be empty.';
            throw new Exception($msg);
        }
        
        if($callCount < 1)
        {
            $msg = 'Call count must be greater than or equal to one (1).';
            throw new Exception($msg);
        }
        
        $count = 0;
        $calls = $this->_methodCalls;
        
        foreach($calls as $key => $value)
        {
            if($value['name'] == $methodName)
            {
                $count++;
            }
            
            if($count == $callCount)
            {
                return $value['args'];
            }
        }
        
        $msg = 'Call count greater than actual number of times method was called.';
        $msg .= ' method name = ' . $methodName . ', ';
        $msg .= ' call count = ' . $callCount . ', ';
        $msg .= ' actual count = ' . $count;
        
        throw new Exception($msg);
    }
    
    
    /**
     * setMethodReturnValue
     * 
     * @param string $methodName
     * @param int $callCount
     */
    public function setMethodReturnValue( $methodName, 
                                          $returnValue = null, 
                                          $callCount   = null)
    {
        $methodName = strval($methodName);
        $callCount  = intval($callCount);
        
        if(strlen($methodName) == 0)
        { 
            $msg = 'Method name cannot be empty.';
            throw new Exception($msg);
        }
        
        $r = &$this->_methodReturnValues;
        $count = count($r);
        
        for($i = 0; $i < $count; $i++)
        {
            if($r[$i]['name'] == $methodName && $r[$i]['callCount'] == $callCount)
            {
                $r[$i]['return'] = $returnValue;
                return;
            }
        }
        
        
        $r[] = array(
            'name'      => $methodName, 
            'return'    => $returnValue, 
            'callCount' => $callCount
                    );
    }
    
    
    /**
     * getMethodReturnValue
     * 
     * @param string $methodName
     * @param int $callCount
     */
    public function getMethodReturnValue($methodName, $callCount = null)
    {
        $methodName = strval($methodName);
        $callCount  = intval($callCount);
        
        if(strlen($methodName) == 0)
        { 
            $msg = 'Method name cannot be empty.';
            throw new Exception($msg);
        }
        
        $calls = $this->_methodReturnValues;
        
        // Return the return value specified by the name and callCount if possible.
        foreach($calls as $key => $value)
        {
            if($value['name'] == $methodName && $value['callCount'] == $callCount)
            {
                return $value['return'];
            }
        }
        
        // Since the return value specified by the name and callCount was not
        // found, return the all call count return value, if exists.
        foreach($calls as $key => $value)
        {
            if($value['name'] == $methodName && $value['callCount'] == null)
            {
                return $value['return'];
            }
        }
        
        
        return null;
    }
}