<?php
/**
 * @category    Jtf
 *
 * @package     Jtf_Session
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
class Jtf_Session
{
    /** @var int */
    private $_maxAgeInSecs;
    /** @var int */
    private $_lastActivityTimeoutInSecs;
    
    
    /**
     * __construct
     * 
     * The value of $maxAgeInSecs must be greater than or equal to
     * $lastActivityTimeoutInSecs. To disable maximum session
     * age checks, set the $maxAgeInSecs value to zero. To disable the 
     * checks on last activity timeout, set the value of  
     * $lastActivityTimeoutInSecs to zero.
     * 
     * @param int $maxAgeInSecs
     * @param int $lastActivityTimeoutInSecs
     */
    public function __construct($maxAgeInSecs=1800, $lastActivityTimeoutInSecs=1800)
    {
        $maxAgeInSecs              = intval($maxAgeInSecs);
        $lastActivityTimeoutInSecs = intval($lastActivityTimeoutInSecs);
        
        if($maxAgeInSecs < 0)
        {
            $msg = 'The session max age is less than zero.';
            throw new InvalidArgumentException($msg);
        }
        
        if($lastActivityTimeoutInSecs < 0)
        {
            $msg = 'The session last activity timeout is less than zero.';
            throw new InvalidArgumentException($msg);
        }
        
        if($maxAgeInSecs < $lastActivityTimeoutInSecs)
        {
            $msg = 'The session max age must be longer than last activity timeout.';
            throw new InvalidArgumentException($msg);
        }
        
        $this->_maxAgeInSecs              = $maxAgeInSecs;
        $this->_lastActivityTimeoutInSecs = $lastActivityTimeoutInSecs;
    }
    
    
    /**
     * read - This function retrieves the value associated with the key.
     * 
     * @param string $key
     * @return null
     */
    public function read($key)
    {
        $key = strval($key);
        $val = null;
        
        if(strlen($key) == 0)
        {
            return $val;
        }
        
        $this->openSession();
        
        if(isset($_SESSION[$key]) == true)
        {
             $val = $_SESSION[$key];
        }
        
        $this->closeSession();
        
        return $val;
    }
    
    
    /**
     * write - This function writes a session value to the session.
     * 
     * @param string $key Key to store the session value in.
     * @param string $val Value to be stored.
     * @throws InvalidArgumentException
     */
    public function write($key, $val)
    {
        $key = strval($key);
        $val = strval($val);
        
        if(strlen($key) == 0)
        {
            $msg = 'The key cannot be empty.';
            throw new InvalidArgumentException($msg);
        }
        
        $this->openSession();
        $_SESSION[$key] = $val;
        $this->closeSession();
    }
    
    
    /**
     * unsetSessionValue - This function unsets a session variable.
     * 
     * @param string $key
     */
    public function unsetSessionValue($key)
    {
        $key = strval($key);
        
        $this->openSession();
        unset($_SESSION[$key]);
        $this->closeSession();
    }
    
    
    /**
     * maxAgeExpired
     * 
     * @return boolean This function returns true if the time limit between now
     *                 and the time that the session was started has been
     *                 exceeded.
     */
    public function maxAgeTimeoutExpired()
    {
        if($this->_maxAgeInSecs == 0)
        {
            return false;
        }
        
        $this->openSession();
        
        if(!isset($_SESSION['session_created_time']) )
        {
            $_SESSION['session_created_time'] = time();
            $this->closeSession();
            return false;
        }
        else
        {
            $now     = time();
            $created = intval($_SESSION['session_created_time']);
            $max     = $this->_maxAgeInSecs;
            $diff    = $now - $created;
            
            if($diff >= $max)
            {
                $this->closeSession();
                return true;
            }
            
            $this->closeSession();
            return false;
        }
        
        $this->closeSession();
        return false;
    }
    
    
    /**
     * lastActivityTimeoutExpired
     * 
     * @return boolean This function returns true if the time limit between now
     *                 and the last activity has been exceeded.
     */
    public function lastActivityTimeoutExpired()
    {
        if($this->_lastActivityTimeoutInSecs == 0)
        {
            return false;
        }
        
        $this->openSession();
        
        if(!isset($_SESSION['session_last_activity_time']) )
        {
            $_SESSION['session_last_activity_time'] = time();
            $this->closeSession();
            return false;
        }
        else
        {
            $now          = time();
            $lastActivity = intval($_SESSION['session_last_activity_time']);
            $max          = $this->_lastActivityTimeoutInSecs;
            $diff         = $now - $lastActivity;
            
            if($diff >= $max)
            {
                $this->closeSession();
                return true;
            }
            
            $this->closeSession();
            return false;
        }
        
        $this->closeSession();
        return false;
    }
    
    
    /**
     * destroy - This function is used to completely eliminate a session.
     */
    public function destroy()
    {
        session_start();
        
        if(ini_get("session.use_cookies")) 
        {
            $params = session_get_cookie_params();
            setcookie(  session_name(), 
                        '', 
                        time() - 42000,
                        $params["path"], 
                        $params["domain"],
                        $params["secure"], 
                        $params["httponly"]
            );
        }
        
        session_unset();
        session_destroy();
        session_regenerate_id(true);
        session_write_close();
    }
    
    
    /**
     * openSession
     */
    private function openSession()
    {
        session_start();
        session_regenerate_id();
    }
    
    
    /**
     * closeSession
     */
    private function closeSession()
    {
        session_write_close();
    }
}