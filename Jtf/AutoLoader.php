<?php
/**
 * The purpose of this class is to provide a high speed autoloader for PHP that
 * does not sacrifice too much flexibility. Specifically, this class allows
 * autoloading of class names directly and of namespaced class names.
 * 
 * Usage Example:
 * 
 * set_include_path(MY_LIB_LOCATION  . PATH_SEPARATOR . get_include_path());
 * require_once('Jtf/AutoLoader.php');
 * Jtf_AutoLoader::registerAutoLoad();
 * 
 * 
 * @category    Jtf
 *
 * @package     Jtf_AutoLoader
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
class Jtf_AutoLoader
{    
    const PHP_FILE_EXT = '.php';

    
    /** @var string */
    private $_classFilename;
    /** @var string[] */
    private $_includePaths;

    
    /**
     * registerAutoLoad - Call this method to start the autoloader.
     */
    public static function registerAutoLoad()
    {
        $autoLoader = new Jtf_AutoLoader();
        spl_autoload_register(array($autoLoader, 'load'));
    }
    

    /**
     * load
     *
     * @param string $className
     * @return bool
     */
    public function load($className)
    {
        $this->_classFilename = $className . self::PHP_FILE_EXT;
        $this->_includePaths  = explode(PATH_SEPARATOR, get_include_path());
        $classFound           = false;

        if(strpos($this->_classFilename, '_') !== false)
        {
            $classFound = $this->searchForUnderscoreNamespacedClass();
            if($classFound) { return true; }
        }
        elseif(strpos($this->_classFilename, '\\') !== false)
        {
            $classFound = $this->searchForBackslashNamespacedClass();
            if($classFound) { return true; }
        }
        else
        {
            $classFound = $this->searchForNonNamespacedClass();
            if($classFound) { return true; }
        }
        
        return false;
    }
    

    /**
     * searchForNonNamespacedClass
     *
     * @return bool
     */
    protected function searchForNonNamespacedClass()
    {
        $filename = $this->_classFilename;

        // Search through the include paths for the file.
        foreach($this->_includePaths as $includePath)
        {
            $filePath = $includePath . DIRECTORY_SEPARATOR . $filename;

            if(file_exists($filePath))
            {
                require($filename);
                return true;
            }
        }

        return false;
    }
    
    
    /**
     * searchForUnderscoreNamespacedClass
     * 
     * @return boolean
     */
    protected function searchForUnderscoreNamespacedClass()
    {
        $filename = $this->_classFilename;

        foreach($this->_includePaths as $includePath)
        {
            $className = str_replace('_', '/', $filename);
            $filePath  = $includePath . DIRECTORY_SEPARATOR . $className;

            if(file_exists($filePath))
            {
                require($filePath);
                return true;
            }
        }

        return false;
    }
    
    
    /**
     * searchForBackslashNamespacedClass
     * 
     * @return boolean
     */
    protected function searchForBackslashNamespacedClass()
    {
        $filename = $this->_classFilename;

        foreach($this->_includePaths as $includePath)
        {
            $className = str_replace('\\', '/', $filename);
            $filePath  = $includePath . DIRECTORY_SEPARATOR . $className;

            if(file_exists($filePath))
            {
                require($filePath);
                return true;
            }
        }

        return false;
    }
}