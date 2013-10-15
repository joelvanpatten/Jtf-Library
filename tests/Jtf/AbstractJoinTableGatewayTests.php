<?php
/**
 * @category    Jtf
 *
 * @package     Jtf_AbstractJoinTableGatewayTests
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
class Jtf_AbstractJoinTableGatewayTests extends KissUnitTest
{
    /**
     * getGatewayWithRealLogger
     * 
     * @return Jtf_ConcreteJoinTableGateway
     */
    private function getGatewayWithRealLogger()
    {
        $db        = Jtf_PdoSingleton::getInstance();
        $path      = realpath(TESTS_PATH.'/logs').'/'.date('Y-m-d').'.log';
        $logger    = new Jtf_Log($path, Jtf_Log::DEBUG);
        $timer     = new Jtf_Chronograph();
        $gtwy      = new Jtf_ConcreteJoinTableGateway($db, $timer, $logger);
        
        return $gtwy;
    }
    
    public function test_creation_and_retrieval()
    {
        $id1 = 4;
        $id2 = 5;
        
        $gtwy = $this->getGatewayWithRealLogger();
        $rowsAffected = $gtwy->create($id1, $id2);
        
        $this->assertEqual($rowsAffected, 1);
        
        $rows = $gtwy->retrieveById1($id1);
        
        $this->assertEqual(count($rows), 1);
        
        $row1 = $rows[0];
        
        $this->assertEqual($row1['id1'], '4');
        $this->assertEqual($row1['id2'], '5');
        
        $rowsAffected = $gtwy->delete($id1, $id2);
        
        $this->assertEqual($rowsAffected, 1);
        
        $rows = $gtwy->retrieveById1($id1);
        $this->assertEqual(count($rows), 0);
        
        $rowsAffected = $gtwy->create($id1, $id2);
        $rowsAffected = $gtwy->deleteById1($id1);
        
        $this->assertEqual($rowsAffected, 1);
        
        $rows = $gtwy->retrieveById1($id1);
        $this->assertEqual(count($rows), 0);
    }
}