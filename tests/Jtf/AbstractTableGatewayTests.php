<?php
/**
 * @category    Jtf
 *
 * @package     Jtf_AbstractTableGatewayTests
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
class Jtf_AbstractTableGatewayTests extends KissUnitTest
{
    /**
     * getGatewayWithRealLogger
     * 
     * @return \Jtf_ConcreteTableGateway
     */
    private function getGatewayWithRealLogger()
    {
        $db        = Jtf_PdoSingleton::getInstance();
        $path      = realpath(TESTS_PATH.'/logs').'/'.date('Y-m-d').'.log';
        $logger    = new Jtf_Log($path, Jtf_Log::DEBUG);
        $timer     = new Jtf_Chronograph();
        $tableName = 'gtwy_tests';
        $gtwy      = new Jtf_ConcreteTableGateway($db, $tableName, $timer, $logger);
        
        return $gtwy;
    }
    
    /**************************************************************************
     * baseCreate Tests
     **************************************************************************/

    public function test_baseCreate_updates_timestamps()
    {
        $entity = new Jtf_GtwyTestEntity();
        $entity->_name = 'John Doe';
        $entity->_nullable_val = 100;
        
        $gtwy = $this->getGatewayWithRealLogger();
        $id = $gtwy->create($entity);
        
        $createdLen = strlen($entity->getCreated());
        $updatedLen = strlen($entity->getUpdated());
        
        $this->assertFirstGreaterThanSecond($createdLen, 0);
        $this->assertFirstGreaterThanSecond($updatedLen, 0);
        
        // Perform clean-up.
        $gtwy->delete($id);
    }
    
    public function test_baseCreate_returns_zero_on_invalid_entity()
    {
        $entity = new Jtf_GtwyTestEntity();
        $entity->_name = null;
        $entity->_nullable_val = 100;
        
        $gtwy = $this->getGatewayWithRealLogger();
        $id = $gtwy->create($entity);
        
        $this->assertEqual($id, 0);
    }
    
    public function test_baseCreate_returns_last_insert_id_on_insertion()
    {
        $entity = new Jtf_GtwyTestEntity();
        $entity->_name = 'John Doe';
        $entity->_nullable_val = 100;
        
        $gtwy = $this->getGatewayWithRealLogger();
        $id = $gtwy->create($entity);
        
        $this->assertFirstGreaterThanSecond($id, 0);
        
        // Perform clean-up.
        $gtwy->delete($id);
    }
    
    public function test_baseCreate_returns_updates_entity_on_insertion()
    {
        $entity = new Jtf_GtwyTestEntity();
        $entity->_name = 'John Doe';
        $entity->_nullable_val = 100;
        
        $gtwy = $this->getGatewayWithRealLogger();
        $id = $gtwy->create($entity);
        
        $this->assertEqual($id, $entity->getId());
        
        // Perform clean-up.
        $gtwy->delete($id);
    }
    
//    public function test_baseCreate_properly_logs_insertion()
//    {
//        $this->notImplementedFail();
//    }
    
    public function test_baseCreate_properly_inserts_row()
    {
        $in = new Jtf_GtwyTestEntity();
        $in->_name = 'John Doe';
        $in->_nullable_val = 100;
        
        $gtwy = $this->getGatewayWithRealLogger();
        $id = $gtwy->create($in);
        
        $out = $gtwy->retrieve($in->getId());
        
        $this->assertEqual($in->getId(),       $out->getId());
        $this->assertEqual($in->getCreated(),  $out->getCreated());
        $this->assertEqual($in->getUpdated(),  $out->getUpdated());
        $this->assertEqual($in->_name,         $out->_name);
        $this->assertEqual($in->_nullable_val, intval($out->_nullable_val));
        
        // Perform clean-up.
        $gtwy->delete($id);
    }
    
    /**************************************************************************
     * baseDelete Tests
     **************************************************************************/
    
    public function test_baseDelete_returns_zero_if_id_not_found()
    {
        $gtwy = $this->getGatewayWithRealLogger();
        $rowsAffected = $gtwy->delete(100000000);
        
        $this->assertEqual($rowsAffected, 0);
    }
    
//    public function test_baseDelete_properly_logs_deletion()
//    {
//        $this->notImplementedFail();
//    }
    
    public function test_baseDelete_properly_deletes_row()
    {
        $in = new Jtf_GtwyTestEntity();
        $in->_name = 'John Doe';
        $in->_nullable_val = 100;
        
        $gtwy = $this->getGatewayWithRealLogger();
        $id = $gtwy->create($in);
        
        // Perform clean-up.
        $gtwy->delete($id);
        
        $out = $gtwy->retrieve($in->getId());
        $this->assertEqual($out, null);
    }
    
    /**************************************************************************
     * baseDeleteBy Tests
     **************************************************************************/
    
    public function test_baseDeleteBy_deletes_correct_rows()
    {
        $gtwy = $this->getGatewayWithRealLogger();
        
        $in1 = new Jtf_GtwyTestEntity();
        $in1->_name = 'John Doe1';
        $in1->_nullable_val = 100;
        $gtwy->create($in1);
        
        $in2 = new Jtf_GtwyTestEntity();
        $in2->_name = 'John Doe2';
        $in2->_nullable_val = 100;
        $gtwy->create($in2);
        
        $gtwy->deleteByNullableVal(100);
        
        $id1 = $gtwy->retrieve($in1->getId());
        $id2 = $gtwy->retrieve($in2->getId());
        
        $this->assertEqual($id1, null);
        $this->assertEqual($id2, null);
    }
    
//    public function test_baseDeleteBy_properly_logs_deletion()
//    {
//        $this->notImplementedFail();
//    }
    
    public function test_baseDeleteBy_returns_zero_if_not_found()
    {
        $gtwy = $this->getGatewayWithRealLogger();
        
        $in1 = new Jtf_GtwyTestEntity();
        $in1->_name = 'John Doe1';
        $in1->_nullable_val = 100;
        $gtwy->create($in1);
        
        $in2 = new Jtf_GtwyTestEntity();
        $in2->_name = 'John Doe2';
        $in2->_nullable_val = 100;
        $gtwy->create($in2);
        
        $rowsAffected = $gtwy->deleteByNullableVal(200);
        $this->assertEqual($rowsAffected, 0);
        
        $gtwy->deleteByNullableVal(100);
    }
    
    /**************************************************************************
     * baseRetrieve Tests
     **************************************************************************/
    
    public function test_baseRetrieve_returns_correct_row_if_found()
    {
        $in = new Jtf_GtwyTestEntity();
        $in->_name = 'John Doe';
        $in->_nullable_val = 100;
        
        $gtwy = $this->getGatewayWithRealLogger();
        $id = $gtwy->create($in);
        
        $out = $gtwy->retrieve($in->getId());
        
        $this->assertEqual($in->getId(),       $out->getId());
        $this->assertEqual($in->getCreated(),  $out->getCreated());
        $this->assertEqual($in->getUpdated(),  $out->getUpdated());
        $this->assertEqual($in->_name,         $out->_name);
        $this->assertEqual($in->_nullable_val, intval($out->_nullable_val));
        
        // Perform clean-up.
        $gtwy->delete($id);
    }
    
//    public function test_baseRetrieve_properly_logs_retrieval()
//    {
//        $this->notImplementedFail();
//    }
    
    public function test_baseRetrieve_returns_null_if_not_found()
    {
        $in = new Jtf_GtwyTestEntity();
        $in->_name = 'John Doe';
        $in->_nullable_val = 100;
        
        $gtwy = $this->getGatewayWithRealLogger();
        $id = $gtwy->create($in);
        
        $out = $gtwy->retrieve(100000000);
        
        $this->assertEqual($out, null);
        
        // Perform clean-up.
        $gtwy->delete($id);
    }
    
    /**************************************************************************
     * baseRetrieveBy Tests
     **************************************************************************/
    
    public function test_baseRetrieveBy_retrieves_correct_rows()
    {
        $gtwy = $this->getGatewayWithRealLogger();
        
        $in1 = new Jtf_GtwyTestEntity();
        $in1->_name = 'John Doe1';
        $in1->_nullable_val = 100;
        $gtwy->create($in1);
        
        $in2 = new Jtf_GtwyTestEntity();
        $in2->_name = 'John Doe2';
        $in2->_nullable_val = 100;
        $gtwy->create($in2);
        
        $rows = $gtwy->retrieveByNullableValue(100);
        
        $this->assertEqual(count($rows), 2);
        $this->assertEqual(intval($rows[0]->_nullable_val), 100);
        $this->assertEqual(intval($rows[1]->_nullable_val), 100);
        
        $gtwy->deleteByNullableVal(100);
    }
    
    public function test_baseRetrieveBy_returns_empty_array_if_not_found()
    {
        $gtwy = $this->getGatewayWithRealLogger();
        
        $in1 = new Jtf_GtwyTestEntity();
        $in1->_name = 'John Doe1';
        $in1->_nullable_val = 100;
        $gtwy->create($in1);
        
        $in2 = new Jtf_GtwyTestEntity();
        $in2->_name = 'John Doe2';
        $in2->_nullable_val = 100;
        $gtwy->create($in2);
        
        $rows = $gtwy->retrieveByNullableValue(200);
        
        $this->assertEqual(count($rows), 0);
        
        $gtwy->deleteByNullableVal(100);
    }
    
//    public function test_baseRetrieveBy_properly_logs_retrieval()
//    {
//        $this->notImplementedFail();
//    }
    
    /**************************************************************************
     * baseRetrieveBy Tests
     **************************************************************************/
    
//    public function test_baseRetrieveByArray_properly_logs_retrieval()
//    {
//        $this->notImplementedFail();
//    }
    
    public function test_baseRetrieveByArray_retrieves_correct_rows()
    {
        $gtwy = $this->getGatewayWithRealLogger();
        
        $in1 = new Jtf_GtwyTestEntity();
        $in1->_name = 'John Doe1';
        $in1->_nullable_val = 100;
        $gtwy->create($in1);
        
        $in2 = new Jtf_GtwyTestEntity();
        $in2->_name = 'John Doe2';
        $in2->_nullable_val = 100;
        $gtwy->create($in2);
        
        $ids = array($in1->getId(), $in2->getId());
        $results = $gtwy->retrieveByIds($ids);
        
        $this->assertEqual(count($results), 2);
        
        $gtwy->deleteByNullableVal(100);
    }
    
    public function test_baseRetrieveByArray_returns_empty_array_if_not_found()
    {
        $gtwy = $this->getGatewayWithRealLogger();
        
        $in1 = new Jtf_GtwyTestEntity();
        $in1->_name = 'John Doe1';
        $in1->_nullable_val = 100;
        $gtwy->create($in1);
        
        $in2 = new Jtf_GtwyTestEntity();
        $in2->_name = 'John Doe2';
        $in2->_nullable_val = 100;
        $gtwy->create($in2);
        
        $ids = array(1000000, 1000001);
        $results = $gtwy->retrieveByIds($ids);
        
        $this->assertEqual(count($results), 0);
        
        $gtwy->deleteByNullableVal(100);
    }
    
    /**************************************************************************
     * baseRetrieveBy Tests
     **************************************************************************/
    
    public function test_baseSetFieldNull_updates_correct_rows()
    {
        $gtwy = $this->getGatewayWithRealLogger();
        
        $in1 = new Jtf_GtwyTestEntity();
        $in1->_name = 'John Doe1';
        $in1->_nullable_val = 100;
        $gtwy->create($in1);
        
        $in2 = new Jtf_GtwyTestEntity();
        $in2->_name = 'John Doe2';
        $in2->_nullable_val = 100;
        $gtwy->create($in2);
        
        $gtwy->setNullableValNull(100);
        
        $out1 = $gtwy->retrieve($in1->getId());
        $out2 = $gtwy->retrieve($in2->getId());
        
        $this->assertEqual($out1->_nullable_val, null);
        $this->assertEqual($out2->_nullable_val, null);
        
        $gtwy->delete($in1->getId());
        $gtwy->delete($in2->getId());
    }
    
    public function test_baseSetFieldNull_returns_number_of_affected_rows()
    {
        $gtwy = $this->getGatewayWithRealLogger();
        
        $in1 = new Jtf_GtwyTestEntity();
        $in1->_name = 'John Doe1';
        $in1->_nullable_val = 100;
        $gtwy->create($in1);
        
        $in2 = new Jtf_GtwyTestEntity();
        $in2->_name = 'John Doe2';
        $in2->_nullable_val = 100;
        $gtwy->create($in2);
        
        $rowsAffected = $gtwy->setNullableValNull(100);
        
        $this->assertEqual($rowsAffected, 2);
        
        $gtwy->delete($in1->getId());
        $gtwy->delete($in2->getId());
    }
    
//    public function test_baseSetFieldNull_properly_logs_update()
//    {
//        $this->notImplementedFail();
//    }
    
    /**************************************************************************
     * baseUpdate Tests
     **************************************************************************/
    
//    public function test_baseUpdate_properly_logs_update()
//    {
//        $this->notImplementedFail();
//    }
    
    public function test_baseUpdate_returns_number_of_affected_rows()
    {
        $in = new Jtf_GtwyTestEntity();
        $in->_name = 'John Doe';
        $in->_nullable_val = 100;
        
        $gtwy = $this->getGatewayWithRealLogger();
        $id = $gtwy->create($in);
        
        $in->_name = 'different name';
        $in->_nullable_val = 5000;
        
        $rowsAffected = $gtwy->update($in);
        
        $this->assertEqual($rowsAffected, 1);
        
        // Perform clean-up.
        $gtwy->delete($id);
    }
    
    public function test_baseUpdate_properly_updates_record()
    {
        $in = new Jtf_GtwyTestEntity();
        $in->_name = 'John Doe';
        $in->_nullable_val = 100;
        
        $gtwy = $this->getGatewayWithRealLogger();
        $id = $gtwy->create($in);
        
        $in->_name = 'different name';
        $in->_nullable_val = 5000;
        
        $gtwy->update($in);
        
        $out = $gtwy->retrieve($id);
        
        $this->assertEqual($out->_name, $in->_name);
        $this->assertEqual(intval($out->_nullable_val), $in->_nullable_val);
        
        // Perform clean-up.
        $gtwy->delete($id);
    }
}
