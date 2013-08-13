<?php
/**
 * @category    Jtf
 *
 * @package     Jtf_BigInt
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
final class Jtf_BigInt
{ 
    /************************************************************************
     * Instance Variables
     ***********************************************************************/
    
    /* @var string */
    private $_value;
    
    /************************************************************************
     * Public Methods
     ***********************************************************************/
    
    /**
     * __construct
     *
     * @param string $value 
     */
    public function __construct($value)
    {
        $this->_value = $value;
    }
    
    
    /**
     * add
     *
     * @param  Jtf_BigInt  $value
     * @return Jtf_BigInt 
     */
    public function add(Jtf_BigInt $value)
    {
        $result = bcadd($this->_value, $value->_value, 0);
        return new Jtf_BigInt($result);
    }
    
    
    /**
     * subtract
     *
     * @param  Jtf_BigInt $value
     * @return Jtf_BigInt 
     */
    public function subtract(Jtf_BigInt $value)
    {
        $result = bcsub($this->_value, $value->_value, 0);
        return new Jtf_BigInt($result);
    }
    
    
    /**
     * multiply
     *
     * @param  Jtf_BigInt $value
     * @return Jtf_BigInt 
     */
    public function multiply(Jtf_BigInt $value)
    {
        $result = bcmul($this->_value, $value->_value, 0);
        return new Jtf_BigInt($result);
    }
    
    
    /**
     * divide
     * 
     * @param  Jtf_BigInt $value
     * @return Jtf_BigInt 
     */
    public function divide(Jtf_BigInt $value)
    {
        $result = bcdiv($this->_value, $value->_value, 0);
        return new Jtf_BigInt($result);
    }

    
    /**
     * modulus
     *
     * @param  Jtf_BigInt $value
     * @return Jtf_BigInt 
     */
    public function modulus(Jtf_BigInt $value)
    {
        $result = bcmod($this->_value, $value->_value);
        return new Jtf_BigInt($result);
    }
    
    
    /**
     * compare 
     * 
     * This function compares this Jtf_Integer with the provided value. If the 
     * provided value is greater than this value, then 1 is returned. If the 
     * provided value is less than this value, -1 is returned. If the provided 
     * value is equal to the current value, 0 is returned.
     *
     * Quick Reference:
     * 
     * -1 $this < $value  
     *  0 $this = $value
     *  1 $this > $value
     *
     * @param Jtf_BigInt $value
     * 
     * @param float $maxDelta - This parameter is the maximum difference
     * between the two values. This is because floats are very difficult 
     * to compare for exactness when equal. Reference the IEEE floating
     * point standard.
     */
    public function compare(Jtf_BigInt $value)
    {
        if($this->_value < $value->_value)
        {
            return -1;
        }
        else if($this->_value > $value->_value)
        {
            return 1;
        }

        return 0;
    }
    
    
    /**
     * toString
     *
     * @return string 
     */
    public function toString()
    {
        if($this->_value == 0)
        {
            return '0';
        }
        
        return rtrim($this->_value, '0.');
    }
    
    
    /**
     * sprintf
     *
     * @param string $format 
     */
    public function sprintf($format)
    {
        return sprintf($format, $this->toString());
    }
}
