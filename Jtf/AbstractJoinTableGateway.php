<?php
/**
 * @category    Jtf
 *
 * @package     Jtf_AbstractJoinTableGateway
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
abstract class Jtf_AbstractJoinTableGateway
{
    /** @var PDO */
    protected $_db;
    /** @var string */
    protected $_tableName;
    /** @var string */
    protected $_id1Name;
    /** @var string */
    protected $_id2Name;
    /** @var Jtf_Chronograph */
    protected $_timer;
    /** @var Jtf_Log */
    protected $_logger;
    

    /**
     * __construct
     * 
     * @param PDO             $db         Use Jtf_PdoSingleton for this parameter.
     * @param string          $tableName  Name of the table.
     * @param string          $id1Name    Name of first id column.
     * @param string          $id2Name    Name of second id column.
     * @param Jtf_Chronograph $timer      This is used for metrics.
     * @param Jtf_Log         $logger     This is used for logging.
     */
    protected function __construct(PDO $db, $tableName, $id1Name, $id2Name,
                                   Jtf_Chronograph $timer=null, Jtf_Log $logger=null)
    {
        if(!isset($tableName) || strlen($tableName) == 0)
        {
            throw new Exception('The table name is empty.');
        }

        if(!isset($id1Name) || strlen($id1Name) == 0)
        {
            throw new Exception('The ID1 name is empty.');
        }

        if(!isset($id2Name) || strlen($id2Name) == 0)
        {
            throw new Exception('The ID2 name is empty.');
        }

        $this->_db        = $db;
        $this->_tableName = $tableName;
        $this->_id1Name   = $id1Name;
        $this->_id2Name   = $id2Name;
        $this->_timer     = $timer;
        $this->_logger    = $logger;
    }
    
    
    /**
     * baseDelete
     * 
     * @param int $id1
     * @param int $id2
     * @return int
     */
    protected function baseDelete($id1, $id2)
    {
        $id1       = intval($id1);
        $id2       = intval($id2);
        $tableName = $this->_tableName;
        $id1Name   = $this->_id1Name;
        $id2Name   = $this->_id2Name;
        $db        = $this->_db;
        $timer     = $this->_timer;
        $logger    = $this->_logger;
        
        $this->startTimer();
        
        $sql = "DELETE FROM $tableName WHERE $id1Name = $id1 AND $id2Name = $id2";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $rowsAffectedCount = $stmt->rowCount();
        
        $this->stopTimer();
        $this->logDatabaseAction($sql, $rowsAffectedCount);
        
        return $rowsAffectedCount;
    }
    
    
    /**
     * baseCreate
     * 
     * @param int $id1
     * @param int $id2
     * @return int
     */
    protected function baseCreate($id1, $id2)
    {
        $id1       = intval($id1);
        $id2       = intval($id2);
        $tableName = $this->_tableName;
        $id1Name   = $this->_id1Name;
        $id2Name   = $this->_id2Name;
        $db        = $this->_db;
        $timer     = $this->_timer;
        $logger    = $this->_logger;
        $created   = Jtf_MySqlDateTime::getNowDateTimeStamp();
        $this->startTimer();
        
        $sql = "INSERT INTO $tableName ( $id1Name, $id2Name, created ) "
             . "VALUES ( $id1, $id2, '$created' )";     
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $rowsAffectedCount = $stmt->rowCount();

        $this->stopTimer();
        $this->logDatabaseAction($sql, $rowsAffectedCount);

        return $rowsAffectedCount;
    }
    
    
    /**
     * baseRetrieveById
     * 
     * @param string $colName
     * @param int $id
     * @return array
     */
    protected function baseRetrieveById($colName, $id)
    {
        $id        = intval($id);
        $tableName = $this->_tableName;
        $db        = $this->_db;
        $timer     = $this->_timer;
        $logger    = $this->_logger;
        $this->startTimer();
        
        $sql  = "SELECT * FROM $tableName WHERE $colName = $id";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $this->stopTimer();
        $this->logDatabaseAction($sql, count($rows));
        
        return $rows;
    }
    
    
    /**
     * baseDeleteById
     * 
     * @param string $colName
     * @param int $id
     * @return int
     */
    protected function baseDeleteById($colName, $id)
    {
        $id        = intval($id);
        $tableName = $this->_tableName;
        $db        = $this->_db;
        $timer     = $this->_timer;
        $logger    = $this->_logger;
        $this->startTimer();
        
        $sql = "DELETE FROM $tableName WHERE $colName = $id";
        
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $affectedRowsCount = intval($stmt->rowCount());
        
        $this->stopTimer();
        $this->logDatabaseAction($sql, $affectedRowsCount); 
    
        return $affectedRowsCount;
    }


    /**
     * logDatabaseAction - Logs the database action.
     * 
     * @param string $sql 
     * @param integer $affectedRowsCount 
     */
    protected function logDatabaseAction($sql, $affectedRowsCount)
    {
        $logger = $this->_logger; 
        if($logger == null) { return; }

        $t = $this->_timer->getElapsedTimeInMillisecs() . 'mS';
        
        $logger->logInfo('----------');
        $logger->logInfo(get_class($this));
        $logger->logInfo('sql = ' . $sql);
        $logger->logInfo('Rows Affected = ' . $affectedRowsCount);
        $logger->logInfo('Execution Time = ' . $t);
    }


    /**
     * Start the timer.
     */
    protected function startTimer()
    {
        if($this->_timer != null)
        {
            $this->_timer->start();
        }
    }


    /**
     * Sop the timer.
     */
    protected function stopTimer()
    {
        if($this->_timer != null)
        {
            $this->_timer->stop();
        }
    }
}