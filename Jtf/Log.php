<?php
/**
 * This class will create output only when the prioity of the log message
 * is greater than the priority that was passed to the constructor.
 * 
 * @category    JTF
 *
 * @package     Jtf_Log
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
class Jtf_Log
{
    const DEBUG = 1;    // Most Verbose
    const INFO 	= 2;    // ...
    const WARN 	= 3;    // ...
    const ERROR = 4;    // ...
    const FATAL = 5;    // Least Verbose
    const OFF 	= 6;    // Nothing at all.
    
    const LOG_OPEN    = 10;
    const OPEN_FAILED = 20;
    const LOG_CLOSED  = 30;
    
    /** @var int */
    protected $_status;
    /** @var string */
    protected $_dateForm;
    /** @var int */
    protected $_priority; 
    /** @var resource */
    protected $_fileHandle;
    
    
    /**
     * __construct
     * 
     * @param string $filePath
     * @param int $priority
     */
    public function __construct($filePath, $priority)
    {
        $this->_status     = self::LOG_CLOSED;
        $this->_dateForm   = 'Y-m-d H:i:s';
        $this->_priority   = $priority;
        $this->_fileHandle = null;
        
        if($priority == self::OFF) { return; }
        
        $this->_fileHandle = fopen($filePath, 'a');
        
        if($this->_fileHandle == true)
        {
            $this->_status = self::LOG_OPEN;
        }
        else
        {
            $this->_status = self::OPEN_FAILED;
            $msg = "The file could not be opened. Check permissions.";
            throw new Exception($msg);
        }
    }
    
    
    /**
     * __destruct
     */
    public function __destruct()
    {
        if($this->_fileHandle == true)
        {
            fclose($this->_fileHandle);
            
            $this->_status = self::LOG_CLOSED;
        }
    }
    
    
    /**
     * logInfo
     * 
     * @param string $line
     */
    public function logInfo($line)
    {
        $this->log($line, self::INFO);
    }
    
    
    /**
     * logDebug
     * 
     * @param string $line
     */
    public function logDebug($line)
    {
        $this->log($line, self::DEBUG);
    }
    
    
    /**
     * logWarn
     * 
     * @param string $line
     */
    public function logWarn($line)
    {
        $this->log($line, self::WARN);
    }
    
    
    /**
     * logError
     * 
     * @param string $line
     */
    public function logError($line)
    {
        $this->log($line, self::ERROR);
    }
    
    
    /**
     * logFatal
     * 
     * @param string $line
     */
    public function logFatal($line)
    {
        $this->log($line, self::FATAL);
    }
    
    
    /**
     * log
     * 
     * @param string $line
     * @param int $priority
     */
    public function log($line, $priority)
    {
        if($this->_priority <= $priority)
        {
            $linePrefix = $this->getLinePrefix($priority);
            $this->writeLine($linePrefix . $line . PHP_EOL);
        }
    }
    
    
    /**
     * writeLine
     * 
     * @param string $line
     * @throws Exception
     */
    private function writeLine($line)
    {
        if($this->_priority == self::OFF) { return; }
        
        if($this->_status != self::LOG_OPEN)
        {
            $msg = 'The log file is not open. '
                 . 'Please check that appropriate permissions have been set.';
            throw new Exception($msg);
        }
        
        if(fwrite($this->_fileHandle, $line) === false)
        {
            $msg = 'The log file could not be written to. '
                 . 'Please check that appropriate permissions have been set.';
            throw new Exception($msg);
        }
    }
    
    
    /**
     * getLinePrefix
     * 
     * @param int $level
     * @return string
     */
    private function getLinePrefix($level)
    {
        $time = date($this->_dateForm);
        
        switch($level)
        {
            case self::DEBUG:
                return $time.' [DEBUG] ';
                break;
            case self::INFO:
                return $time.' [INFO] ';
                break;
            case self::WARN:
                return $time.' [WARN] ';
                break;
            case self::ERROR:
                return $time.' [ERROR] ';
                break;
            case self::FATAL:
                return $time.' [FATAL] ';
                break;
            default:
                return $time.' [LOG] ';
                break;
        }
    }
}
