<?php
/**
 * @category    Jtf
 *
 * @package     Jtf_AbstractTableGateway
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
abstract class Jtf_AbstractTableGateway
{
    /** @var PDO */
    protected $_db;
    /** @var string */
    protected $_tableName;
    /** @var Jtf_Chronograph */
    protected $_timer;
    /** @var Jtf_Log */
    protected $_logger;
    

    /**
     * __construct
     * 
     * @param PDO             $db         Use Jtf_PdoSingleton for this parameter.
     * @param string          $tableName  Name of the table.
     * @param Jtf_Chronograph $timer      This is used for metrics.
     * @param Jtf_Log         $logger     This is used for logging.
     */
    protected function __construct(PDO $db, $tableName, 
                                   Jtf_Chronograph $timer, Jtf_Log $logger)
    {
        $this->_db        = $db;
        $this->_tableName = $tableName;
        $this->_timer     = $timer;
        $this->_logger    = $logger;
    }


    /**
     * baseCreate - This function inserts the data, updates the id, created and
     * updated timestamps, and returns the inserted id on sucess zero on failure.
     * 
     * @param Jtf_AbstractEntity $entity
     * @return int
     */
    protected function baseCreate(Jtf_AbstractEntity $entity)
    {
        $tableName = $this->_tableName;
        $db        = $this->_db;
        $timer     = $this->_timer;
        $logger    = $this->_logger;
        
        $timer->start();
        
        if($entity->isValid() == false) { return 0; }
        
        $data = $this->convertObjectToArray($entity);
        
        $data['created'] = date('Y-m-d H:i:s');
        $data['updated'] = date('Y-m-d H:i:s');

        $colNames       = $this->getColumnNames($data);
        $bindParamNames = $this->getBindParameterNames($data);
        $bindParams     = $this->convertToBindParamArray($data);
        
        $sql = 'INSERT INTO ' . $tableName 
             . ' ( ' . implode(', ', $colNames) . ' ) '
             . 'VALUES'
             . " ( " . implode(", ", $bindParamNames) . " )";
        
        $stmt = $db->prepare($sql);
        $stmt->execute($bindParams);
        $insertedId = intval($db->lastInsertId());
        $data['id'] = $insertedId;
        
        if($insertedId == 0)
        {
            $timer->stop();
            $t = $timer->getElapsedTimeInMillisecs() . 'mS';
            
            // Log the failed insert.
            $logger->logWarn('----------');
            $logger->logWarn(get_class($this));
            $logger->logWarn('Database insert failed.');
            $logger->logWarn('sql = ' . $sql);
            $logger->logWarn('Execution time = ' . $t);
            $logger->logWarn('data = ' . print_r($data, true));
            
            return 0;
        }
        
        $entity->setId($insertedId);
        $entity->setCreated($data['created']);
        $entity->setUpdated($data['updated']);
        
        $timer->stop();
        $t = $timer->getElapsedTimeInMillisecs() . 'mS';
        
        // Log the successful insert.
        $logger->logInfo('----------');
        $logger->logInfo(get_class($this));
        $logger->logInfo('Database insert was successful.');
        $logger->logInfo('sql = ' . $sql);
        $logger->logInfo('inserted id = ' . $insertedId);
        $logger->logInfo('Execution time = ' . $t);
        $logger->logInfo('data = ' . print_r($data, true));

        return $insertedId;
    }


    /**
     * baseRetrieve - This function retrieves the object from the database
     * specified by the $id. This method assumes the primary key of the
     * table is named `id`.
     *
     * @param integer $id Id of the object to return.
     * @return mixed      The retrieved row, converted to an object.
     */
    protected function baseRetrieve($id)
    {
        $id         = intval($id);
        $tableName  = $this->_tableName;
        $db         = $this->_db;
        $timer      = $this->_timer;
        $logger     = $this->_logger;
        $result     = null;
        
        $timer->start();

        $sql = "SELECT * FROM " . $tableName . " WHERE id = :id LIMIT 1";
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if(count($row) > 0)
        {
            /* @var $result BaseTableRow */
            $result = $this->convertArrayToObject($row[0]);
            
            $timer->stop();
            $t = $timer->getElapsedTimeInMillisecs() . 'mS';
            
            // Log the successful retrieve.
            $logger->logInfo('----------');
            $logger->logInfo(get_class($this));
            $logger->logInfo('Database table row retrieve was successful.');
            $logger->logInfo('sql = ' . $sql);
            $logger->logInfo('id = ' . $id);
            $logger->logInfo('Execution time = ' . $t);
            $logger->logInfo('data = ' . print_r($result, true));
        }
        else
        {
            $timer->stop();
            $t = $timer->getElapsedTimeInMillisecs() . 'mS';
            
            // Log the failed retrieve.
            $logger->logWarn('----------');
            $logger->logWarn(get_class($this));
            $logger->logWarn('Database table row retrieve failed.');
            $logger->logWarn('sql = ' . $sql);
            $logger->logWarn('id = ' . $id);
            $logger->logWarn('Execution time = ' . $t);
        }
        
        return $result;
    }
    
    
    /**
     * baseRetrieveBy
     * 
     * @param string $fieldName
     * @param string $fieldValue
     * @return array
     */
    protected function baseRetrieveBy($fieldName, $fieldValue)
    {
        $fieldName = strval($fieldName);
        $fieldVal  = strval($fieldValue);
        $db        = $this->_db;
        $timer     = $this->_timer;
        $tableName = $this->_tableName;
        $logger    = $this->_logger;
        $results   = array();
        
        $timer->start();
        
        $sql  = "SELECT * FROM " . $tableName 
              . " WHERE " . $fieldName . " = :" . $fieldName;
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':' . $fieldName, $fieldVal);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        foreach($rows as $row)
        {
            /* @var $result BaseTable */
            $result = $this->convertArrayToObject($row);
            $results[] = $result;
        }
        
        $timer->stop();
        $t = $timer->getElapsedTimeInMillisecs() . 'mS';
            
        // Log the successful retrieve.
        $logger->logInfo('----------');
        $logger->logInfo(get_class($this));
        $logger->logInfo('sql = ' . $sql);
        $logger->logInfo('Execution time = ' . $t);
        
        return $results;
    }


    /**
     * baseRetrieveByIds
     * 
     * @param array $ids
     * @return array
     */
    protected function baseRetrieveByIds($ids)
    {
        $db        = $this->_db;
        $timer     = $this->_timer;
        $tableName = $this->_tableName;
        $logger    = $this->_logger;
        $results   = array();
        
        $timer->start();
        
        $sql  = "SELECT * FROM " . $tableName 
              . ' WHERE id IN ( ';
        
        foreach($ids as $k=>$v)
        {
            $sql .= intval($v);
            
            if($k != (count($ids) - 1))
            {
                $sql .= ', ';
            }
        }
        
        $sql .= ' )';
        
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        foreach($rows as $row)
        {
            /* @var $result BaseTable */
            $result = $this->convertArrayToObject($row);
            $results[] = $result;
        }
        
        $timer->stop();
        $t = $timer->getElapsedTimeInMillisecs() . 'mS';
            
        // Log the successful retrieve.
        $logger->logInfo('----------');
        $logger->logInfo(get_class($this));
        $logger->logInfo('sql = ' . $sql);
        $logger->logInfo('Execution time = ' . $t);
        
        return $results;
    }
    
    
    /**
     * baseUpdate
     *
     * @param array $data
     */
    protected function baseUpdate(Jtf_AbstractEntity $entity)
    {
        $db        = $this->_db;
        $tableName = $this->_tableName;
        $timer     = $this->_timer;
        $logger    = $this->_logger;
        
        $timer->start();
        
        $data = $this->convertObjectToArray($entity);
        $data['updated'] = date('Y-m-d H:i:s');

        $colNames = $this->getColumnNames($data);
        $bindParamNames = $this->getBindParameterNames($data);
        $bindParams = $this->convertToBindParamArray($data);
        $count = count($colNames);
        
        // Construct the SQL query.
        $sql = "UPDATE " . $tableName . " SET ";
        
        for($i = 0; $i < $count; $i++)
        {
            if($colNames[$i] == 'id' || $bindParamNames[$i] == ':id') { continue; }
            
            $sql .= $colNames[$i] . " = " . $bindParamNames[$i];
            
            if($i < $count - 1) 
            { 
                $sql .= ", ";    
            } else
            {
                $sql .= " ";
            }
        }
        
        $sql .= ' WHERE id = :id'; 
        
        $stmt = $db->prepare($sql);
        $stmt->execute($bindParams);
        $rowsAffected = intval($stmt->rowCount());
        
        if($rowsAffected > 0)
        {
            $timer->stop();
            $t = $timer->getElapsedTimeInMillisecs() . 'mS';
            
            // Log the update.
            $logger->logInfo('----------');
            $logger->logInfo(get_class($this));
            $logger->logInfo('The database table row update was successful.');
            $logger->logInfo('sql = ' . $sql);
            $logger->logInfo('Execution time = ' . $t);
            $logger->logInfo('data = '.print_r($data, true));
        }
        else
        {
            $timer->stop();
            $t = $timer->getElapsedTimeInMillisecs() . 'mS';
            
            // Log the update failure.
            $logger->logWarn('----------');
            $logger->logWarn(get_class($this));
            $logger->logWarn('The database table row update failed.');
            $logger->logWarn('sql = ' . $sql);
            $logger->logWarn('Execution time = ' . $t);
            $logger->logWarn('data = '.print_r($data, true));
        }
        
        return $rowsAffected;
    }

    
    /**
     * baseSetFieldNull
     * 
     * @param string $fieldName
     * @param mixed $fieldValue
     * @return int
     */
    protected function baseSetFieldNull($fieldName, $fieldValue)
    {
        $fieldName = strval($fieldName);
        $fieldVal  = strval($fieldValue);
        $timer     = $this->_timer;
        $logger    = $this->_logger;
        $tableName = $this->_tableName;
        $db        = $this->_db;
        
        $timer->start();
        
        
        $sql  = 'UPDATE ' . $tableName 
              . ' SET ' . $fieldName . ' = NULL, '
              . " updated = '". date('Y-m-d H:i:s') . "'"
              . ' WHERE ' . $fieldName . ' = :' . $fieldName;
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':' . $fieldName, $fieldVal);
        $stmt->execute();
        $rowsAffected = $stmt->rowCount();
        
        if($rowsAffected > 0)
        {
            $timer->stop();
            $t = $timer->getElapsedTimeInMillisecs() . 'mS';
            
            // Log the successful deletion.
            $logger->logInfo('----------');
            $logger->logInfo(get_class($this));
            $logger->logInfo('sql = ' . $sql);
            $logger->logInfo('Rows Affected = '.$rowsAffected);
            $logger->logInfo('Execution Time = ' . $t);
        }
        else
        {
            $timer->stop();
            $t = $timer->getElapsedTimeInMillisecs() . 'mS';
            
            // Log the deletion failure.
            $logger->logWarn('----------');
            $logger->logWarn(get_class($this));
            $logger->logWarn('Rows Affected = 0: No matching rows found.');
            $logger->logWarn('sql = ' . $sql);
            $logger->logWarn('Execution Time = ' . $t);
        }
        
        return $rowsAffected;
    }
    
    
    /**
     * baseDelete
     *
     * @param int $id
     * @return int Rows affected
     */
    protected function baseDelete($id)
    {
        $id        = intval($id);
        $db        = $this->_db;
        $tableName = $this->_tableName;
        $timer     = $this->_timer;
        $logger    = $this->_logger;
        
        $timer->start();

        $sql = "DELETE FROM " . $tableName . " WHERE id = :id";
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
        $rowsAffected = $stmt->rowCount();
        
        
        if($rowsAffected > 0)
        {
            $timer->stop();
            $t = $timer->getElapsedTimeInMillisecs() . 'mS';
            
            // Log the successful deletion.
            $logger->logInfo('----------');
            $logger->logInfo(get_class($this));
            $logger->logInfo('Database table row deletion was successful.');
            $logger->logInfo('sql = ' . $sql);
            $logger->logInfo('id = ' . $id);
            $logger->logInfo('Execution time = '.$t);
        }
        else
        {
            $timer->stop();
            $t = $timer->getElapsedTimeInMillisecs() . 'mS';
            
            // Log the deletion failure.
            $logger->logWarn('----------');
            $logger->logWarn(get_class($this));
            $logger->logWarn('Database table row deletion has failed.');
            $logger->logWarn('sql = ' . $sql);
            $logger->logInfo('id = ' . $id);
            $logger->logWarn('Execution time = '.$t);
        }
        
        return $rowsAffected;

    }
    
    /**
     * baseDeleteBy
     * 
     * @param string $fieldName
     * @param string $fieldValue
     * @return int
     */
    protected function baseDeleteBy($fieldName, $fieldValue)
    {
        $fieldName  = strval($fieldName);
        $fieldVal   = strval($fieldValue);
        $db         = $this->_db;
        $tableName  = $this->_tableName;
        $timer      = $this->_timer;
        $logger     = $this->_logger;
        
        $timer->start();

        $sql = "DELETE FROM ".$tableName
             . " WHERE " . $fieldName . " = :" . $fieldName;
        
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':' . $fieldName, $fieldVal);
        $stmt->execute();
        $rowsAffected = intval($stmt->rowCount());
        
        if($rowsAffected > 0)
        {
            $timer->stop();
            $t = $timer->getElapsedTimeInMillisecs() . 'mS';
            
            // Log the successful deletion.
            $logger->logInfo('----------');
            $logger->logInfo(get_class($this));
            $logger->logInfo('sql = ' . $sql);
            $logger->logInfo('Rows Affected = ' . $rowsAffected);
            $logger->logInfo('Execution Time = ' . $t);
        }
        else
        {
            $timer->stop();
            $t = $timer->getElapsedTimeInMillisecs() . 'mS';
            
            // Log the deletion failure.
            $logger->logWarn('----------');
            $logger->logWarn(get_class($this));
            $logger->logWarn('Rows Affected = 0: No matching rows found.');
            $logger->logWarn('sql = ' . $sql);
            $logger->logWarn('Execution Time = ' . $t);
        }
        
        return $rowsAffected;
    }

    
    
    /**
     * getColumnNames
     * 
     * @param array $data
     * @return array
     */
    protected function getColumnNames($data)
    {
        $colNames = array();
        
        foreach($data as $key => $value)
        {
            $colNames[] = $key;
        }
        
        return $colNames;
    }
    
    
    /**
     * 
     * @param array $data
     * @return array
     */
    protected function getBindParameterNames($data)
    {
        $bindParamNames = array();
        
        foreach($data as $key => $value)
        {
            $bindParamNames[] = ':'.$key;
        }
        
        return $bindParamNames;
    }
    
    
    /**
     * convertToBindParamArray
     * 
     * @param array $data
     * @return array
     */
    protected function convertToBindParamArray($data)
    {
        $bindParams = array();
        
        foreach($data as $key => $value)
        {
            $bindParams[':'.$key] = $value;
        }
        
        return $bindParams;
    }

    
    /**
     * convertObjectToArray
     *
     * @param stdClass $object
     */
    protected abstract function convertObjectToArray($object);


    /**
     * convertArrayToObject
     *
     * @param mixed $array
     */
    protected abstract function convertArrayToObject($array);
}
