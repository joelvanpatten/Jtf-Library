<?php
/**
 * @category    Jtf
 *
 * @package     Jtf_ConcreteTableGateway
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
class Jtf_ConcreteTableGateway extends Jtf_AbstractTableGateway
{
    public function __construct(\PDO             $db, 
                                $tableName,
                                \Jtf_Chronograph $timer, 
                                \Jtf_Log         $logger)
    {
        parent::__construct($db, $tableName, $timer, $logger);
    }
    
    
    /**
     * create
     * 
     * @param Jtf_GtwyTestEntity $e
     * @return integer
     */
    public function create(Jtf_GtwyTestEntity $e)
    {
        return $this->baseCreate($e);
    }
    
    
    /**
     * baseDelete
     * 
     * @param int $id
     * @return int
     */
    public function delete($id)
    {
        return $this->baseDelete($id);
    }
    
    
    /**
     * retrieve
     * 
     * @param int $id
     * @return Jtf_GtwyTestEntity
     */
    public function retrieve($id)
    {
        return $this->baseRetrieve($id);
    }
    
    
    /**
     * deleteByNullableVal
     * 
     * @param integer $val
     * @return integer
     */
    public function deleteByNullableVal($val)
    {
        return $this->baseDeleteBy('nullable_val', $val);
    }
    
    
    /**
     * retrieveByNullableValue
     * 
     * @param int $val
     * @return array
     */
    public function retrieveByNullableValue($val)
    {
        return $this->baseRetrieveBy('nullable_val', $val);
    }
    
    
    /**
     * retrieveByIds
     * 
     * @param array $ids
     * @return array
     */
    public function retrieveByIds($ids)
    {
        return $this->baseRetrieveByIds($ids);
    }
    
    
    /**
     * setNullableValNull
     * 
     * @param int $val
     * @return int
     */
    public function setNullableValNull($val)
    {
        return $this->baseSetFieldNull('nullable_val', $val);
    }
    
    
    /**
     * update
     * 
     * @param Jtf_GtwyTestEntity $e
     * @return int
     */
    public function update(Jtf_GtwyTestEntity $e)
    {
        return $this->baseUpdate($e);
    }
    
    
    /**
     * convertArrayToObject
     * 
     * @param array $array
     * @return Jtf_GtwyTestEntity
     */
    protected function convertArrayToObject($array)
    {
        $entity = new Jtf_GtwyTestEntity();
        $entity->_name = $array['name'];
        $entity->_nullable_val = $array['nullable_val'];
        $entity->setCreated($array['created']);
        $entity->setUpdated($array['updated']);
        $entity->setId($array['id']);
        
        return $entity;
    }

    
    /**
     * convertObjectToArray
     * 
     * @param Jtf_GtwyTestEntity $object
     * @return type
     */
    protected function convertObjectToArray($object)
    {
        /* @var $object Jtf_GtwyTestEntity */
        $array = array();
        $array['id'] = $object->getId();
        $array['name'] = $object->_name;
        $array['nullable_val'] = $object->_nullable_val;
        $array['created'] = $object->getCreated();
        $array['updated'] = $object->getCreated();
        
        return $array;
    }    
}
