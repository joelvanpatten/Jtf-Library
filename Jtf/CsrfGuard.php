<?php
/**
 * @category    Jtf
 *
 * @package     Jtf_CsrfGuard
 * 
 * To use this class perform the following:
 * 
 * 1.   Construct the class and pass in the name of the form and the 
 *      session object.
 * 
 * 2.   Call generateToken() and store the return value in a hidden form 
 *      field called csrf.
 * 
 * 3.   On post, pass the value of the csrf field into validateToken. If true
 *      is returned, then CSRF has not occurred. 
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
 *
 */
class Jtf_CsrfGuard
{
    /** @var string */
    protected $_formName;
    /** @var Jtf_Session */
    protected $_session;
    /** @var Jtf_CsrfGuard */
    protected $_salt;
    
    /**
     * 
     * @param type $formName
     * @param Jtf_Session $session
     */
    public function __construct($formName, Jtf_Session $session, $salt = null)
    {
        $formName = strval($formName);
        
        if(strlen($formName) == 0)
        {
            $msg = 'An empty form name is not allowed.';
            throw new InvalidArgumentException($msg);
        }
        
        $this->_formName = $formName;
        $this->_session  = $session;
        $this->_salt     = $salt;
    }
    
    
    /**
     * generateToken
     * 
     * @param string $salt
     * @return string
     */
    public function generateToken($salt = null)
    {
        if($salt != null)
        {
            $salt = $this->_salt;
        }
        
        $salt = strval($salt);
        $pool = '0123456789'
              . 'abcdefghijklmnopqrstuvwxyz'
              . 'ABCDEFGHIJKLMNOPQRSTUVWXYZ'
              . '~!@#$%^&*()-_+={}|[]:;<>,./?';
        
        $randomString = $salt;
        $max = strlen($pool) - 1;
        
        for ($i=0; $i < 64; $i++)
        {
            $randomString .= substr($pool, mt_rand(0, $max), 1);
        }
        
        $token  = hash('sha512', $randomString);
        $sess   = $this->_session;
        $key    = $this->_formName;
        
        $sess->write($key, $token);
        
        return $token;
    }
    
    
    /**
     * validateToken
     * 
     * @param string $formToken
     * @return boolean
     */
    public function validateToken($token)
    {
        $token = strval($token);
        
        if(strlen($token) == 0)
        {
            $msg = 'The token cannot be empty.';
            throw new Exception($msg);
        }
        
        $sess      = $this->_session;
        $key       = $this->_formName;
        $sessToken = $sess->read($key);
        $sess->unsetSessionValue($key);
        
        if($sessToken == false || strlen($sessToken) == 0)
        {
            return false;
        }
        
        if($sessToken === $token)
        {
            return true;
        }
        
        return false;
    }
}