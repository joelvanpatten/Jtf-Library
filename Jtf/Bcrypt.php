<?php
/**
 * @category    Jtf
 *
 * @package     Jtf_Bcrypt
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
class Jtf_Bcrypt
{
    /************************************************************************
     * Class Constants
     ***********************************************************************/
    
    const MIN_COST    = 4;
    const MAX_COST    = 31;
    const SALT_LENGTH = 22;
    const HASH_LENGTH = 39;
    
    /************************************************************************
     * Instance Variables
     ***********************************************************************/
    
    /** @var int */
    private $_cost;
    /** @var string */
    private $_randomState;

    
    /************************************************************************
     * Public Methods
     ***********************************************************************/
    
    /**
     * __construct
     *
     * @param  int $cost
     * @throws Exception
     * @throws InvalidArgumentException 
     */
    public function __construct($cost = 10)
    {
        if(CRYPT_BLOWFISH != 1) 
        {
            $msg = "bcrypt not supported in this "
                 . "installation. See http://php.net/crypt";
            throw new Exception($msg);
        }
        
        $cost = intval($cost);
        
        if($cost < self::MIN_COST || $cost > self::MAX_COST)
        {
            $msg = "An invalid cost was specified.";
            throw new InvalidArgumentException($msg);
        }
        
        $this->_cost        = $cost;
        $this->_randomState = null;
    }
    
    
    /**
     * calculateHash - The input is hashed using the salt and the cost parameter
     *      specified in the constructor.
     *
     * @param string $salt - The length of salt must be 22 characters in
     *      length and may only contain the characters "./0-9A-Za-z". 
     * @param string $input
     * @return string 
     */
    public function calculateHash($salt, $input) 
    {
        $salt = strval($salt);
        
        if(strlen($salt) < self::SALT_LENGTH)
        {
            // Pad the salt with zeros.
            $length = self::SALT_LENGTH - strlen($salt);
            
            for($i = 0; $i < $length; $i++)
            {
                $salt .= '0';
            }
        }
        
        if(strlen($salt) > self::SALT_LENGTH)
        {
            $salt = substr($salt, 0, self::SALT_LENGTH);
        }
        
        $input = strval($input);
        
        if(strlen($input) <= 0)
        {
            $msg = 'The length of the input must be great than zero.';
            throw new InvalidArgumentException($msg);
        }
        
        // Ensure that the cost is two characters.
        $cost = '';
        
        if($this->_cost < 10)
        {
            $cost = '0' . $this->_cost;
        }
        else
        {
            $cost = strval($this->_cost);
        }
        
        $salt = '$2a$' . $cost. '$' . $salt;
        
        $hash = crypt($input, $salt);
        $hash = strval($hash);
        $hash = substr($hash, self::SALT_LENGTH - 1);
        
        return $hash;
    }
    
    
    /**
     * verify - This function verifies the existing hash matches the
     *      value obtained by hashing the input using the salt and the
     *      cost parameter specifed in the constructor.
     *
     * @param type $input
     * @param string $salt - The length of salt must be 22 characters in
     *      length and may only contain the characters "./0-9A-Za-z". 
     * @param string $existingHash
     * @return boolean 
     */
    public function verify($input, $salt, $existingHash)
    {
        $input        = strval($input);
        $salt         = strval($salt);
        $existingHash = strval($existingHash);
        
        if(strlen($input) <= 0)
        {
            $msg = 'Input must be non-zero length.';
            throw new InvalidArgumentException($msg);
        }
        
        if(strlen($salt) <= 0)
        {
            $msg = 'Salt must be non-zero length.';
            throw new InvalidArgumentException($msg);
        }
        
        if(strlen($existingHash) <= 0)
        {
            $msg = 'Existing hash must be non-zero length.';
            throw new InvalidArgumentException($msg);
        }
        
        $hash = $this->calculateHash($salt, $input);
        
        if($hash === $existingHash)
        {
            return true;
        }
        
        return false;
    }
    
    
    public function generateSalt()
    {
        $bytes = $this->getRandomBytes();
        $salt  = $this->encodeBytes($bytes);
        return $salt;
    }

    /************************************************************************
     * Protected Methods
     ***********************************************************************/
   
    /************************************************************************
     * Private Methods
     ***********************************************************************/

    
    /**
     * getRandomBytes
     * 
     * @param int $count
     * @return bytes 
     */
    private function getRandomBytes($count = self::SALT_LENGTH) 
    {
        $bytes = '';

        if(function_exists('openssl_random_pseudo_bytes') &&
            (strtoupper(substr(PHP_OS, 0, 3)) !== 'WIN')) 
        { 
            // OpenSSL is slow on Win. Therefore, don't use it.
            $bytes = openssl_random_pseudo_bytes($count);
        }

        if($bytes === '' && is_readable('/dev/urandom') &&
            ($hRand = @fopen('/dev/urandom', 'rb')) !== FALSE) 
        {
            $bytes = fread($hRand, $count);
            fclose($hRand);
        }

        if(strlen($bytes) < $count) 
        {
            $bytes = '';

            if($this->randomState === null) 
            {
                $this->randomState = microtime();
                
                if(function_exists('getmypid')) 
                {
                    $this->randomState .= getmypid();
                }
            }

            for($i = 0; $i < $count; $i += 16) 
            {
                $newRandomState    = md5(microtime() . $this->randomState);
                $this->randomState = $newRandomState;

                if (PHP_VERSION >= '5') 
                {
                    $bytes .= md5($this->randomState, true);
                } 
                else 
                {
                    $bytes .= pack('H*', md5($this->randomState));
                }
            }

            $bytes = substr($bytes, 0, $count);
        }

        return $bytes;
    }
    
    
    /**
     * encodeBytes
     * 
     * @param bytes $input
     * @return string 
     */
    private function encodeBytes($input) 
    {
        // The following is code from the PHP Password Hashing Framework
        $itoa64 = './ABCDEFGHIJKLMNOPQRSTUVWXYZ'
                . 'abcdefghijklmnopqrstuvwxyz'
                . '0123456789';

        $output = '';
        $i      = 0;
        
        do 
        {
            $c1      = ord($input[$i++]);
            $output .= $itoa64[$c1 >> 2];
            $c1      = ($c1 & 0x03) << 4;
            
            if($i >= 16) 
            {
                $output .= $itoa64[$c1];
                break;
            }

            $c2      = ord($input[$i++]);
            $c1     |= $c2 >> 4;
            $output .= $itoa64[$c1];
            $c1      = ($c2 & 0x0f) << 2;

            $c2      = ord($input[$i++]);
            $c1     |= $c2 >> 6;
            $output .= $itoa64[$c1];
            $output .= $itoa64[$c2 & 0x3f];
        } while (1);

        return $output;
    }

}
