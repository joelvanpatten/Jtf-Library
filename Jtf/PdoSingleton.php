<?php
/**
 * @category    Jtf
 *
 * @package     Jtf_PdoSingleton
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
class Jtf_PdoSingleton
{
    /** @var string */
    protected static $_dbName;
    /** @var string */
    protected static $_dbHost;
    /** @var string */
    protected static $_dbPort;
    /** @var string */
    protected static $_dbUser;
    /** @var string */
    protected static $_dbPass;
    /** @var PDO */
    protected static $_db;
    
    
    /**
     * __construct
     * 
     * @throws Exception
     */
    protected function __construct()
    {
        $dbName = self::$_dbName;
        $dbHost = self::$_dbHost;
        $dbPort = self::$_dbPort;
        $dbUser = self::$_dbUser;
        $dbPass = self::$_dbPass;
        
        if(strlen($dbName) == 0)
        {
            $msg = 'DB name is empty.';
            throw new Exception($msg);
        }
        else if(strlen($dbHost) == 0)
        {
            $msg = 'DB host is empty.';
            throw new Exception($msg);
        }
        else if(strlen($dbPort) == 0)
        {
            $msg = 'DB port is empty.';
            throw new Exception($msg);
        }
        else if(strlen($dbUser) == 0)
        {
            $msg = 'DB user is empty.';
            throw new Exception($msg);
        }
        else if(strlen($dbPass) == 0)
        {
            $msg = 'DB pass is empty.';
            throw new Exception($msg);
        }
        
        $dsn = "mysql:host=$dbHost;port=$dbPort;dbname=$dbName";
        $db  = new PDO($dsn, $dbUser, $dbPass);
        $db->setAttribute(PDO::ATTR_ERRMODE,             PDO::ERRMODE_EXCEPTION);
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,  PDO::FETCH_ASSOC);
        $db->setAttribute(PDO::ATTR_EMULATE_PREPARES,    false);
        
        self::$_db = $db;
    }
    
    
    /**
     * setDbName
     * 
     * @param string $dbName
     */
    public static function setDbName($dbName)
    {
        self::$_db = null;
        self::$_dbName = strval($dbName);
    }
    
    
    /**
     * setDbHost
     * 
     * @param string $dbHost
     */
    public static function setDbHost($dbHost = 'localhost')
    {
        self::$_db = null;
        self::$_dbHost = strval($dbHost);
    }
    
    
    /**
     * setDbPort
     * 
     * @param string|int $dbPort
     */
    public static function setDbPort($dbPort = 3306)
    {
        self::$_db = null;
        self::$_dbPort = strval($dbPort);
    }
    
    
    /**
     * setDbUser
     * 
     * @param string $dbUser
     */
    public static function setDbUser($dbUser)
    {
        self::$_db = null;
        self::$_dbUser = strval($dbUser);
    }
    
    
    /**
     * setDbPass
     * 
     * @param string $dbPass
     */
    public static function setDbPass($dbPass)
    {
        self::$_db = null;
        self::$_dbPass = strval($dbPass);
    }
    
    /**
     * getInstance
     * 
     * @return PDO
     */
    public static function getInstance()
    {
        if(self::$_db == null)
        {
            new Jtf_PdoSingleton();
        }
        
        return self::$_db;
    }
}
