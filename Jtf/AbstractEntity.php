<?php
/**
 * @category    Jtf
 *
 * @package     Jtf_AbstractEntity
 *
 * @copyright   Copyright (C) 2013 Joseph Fallon <joseph.t.fallon@gmail.com>
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
abstract class Jtf_AbstractEntity
{
    /** @var integer */
    private $_id;
    /** @var string */
    private $_created;
    /** @var string */
    private $_updated;
    /** @var array */
    protected $_validationMessages;
    
    
    /**
     * __construct
     */
    public function __construct()
    {
        $this->_id      = 0;
        $this->_created = '';
        $this->_updated = '';
    }
    
    
    /**
     * setId
     * 
     * @param integer $id
     */
    public function setId($val)
    {
        $val = intval($val);
        $this->_id = $val;
    }
    
    
    /**
     * getId
     * 
     * @return integer
     */
    public function getId()
    {
        return $this->_id;
    }
    
    
    /**
     * setCreated
     * 
     * @param string $val
     */
    public function setCreated($val)
    {
        $val = strval($val);
        $this->_created = $val;
    }
    
    
    /**
     * getCreated
     * 
     * @return string
     */
    public function getCreated()
    {
        return $this->_created;
    }
    
    
    /**
     * setCreated
     * 
     * @param string $val
     */
    public function setUpdated($val)
    {
        $val = strval($val);
        $this->_updated = $val;
    }
    
    
    /**
     * getUpdated
     * 
     * @return string
     */
    public function getUpdated()
    {
        return $this->_updated;
    }
    
    
    /**
     * isValid
     * 
     * @return bool
     */
    public abstract function isValid();
    
    
    /**
     * getValidationMessages
     * 
     * @return array
     */
    public function getValidationMessages()
    {
        return $this->_validationMessages;
    }
    
    
    /**
     * addValidationMessage
     * 
     * @param string $msg
     */
    protected function addValidationMessage($msg)
    {
        $msg = strval($msg);
        
        if(strlen($msg) > 0)
        {
            $this->_validationMessages[] = $msg;
        }
    }
}
