<?php
/**
 * @category    Jtf
 *
 * @package     Jtf_ConcreteJoinTableGateway
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
class Jtf_ConcreteJoinTableGateway extends Jtf_AbstractJoinTableGateway
{
    public function __construct(\PDO             $db,
                                \Jtf_Chronograph $timer, 
                                \Jtf_Log         $logger)
    {
        parent::__construct($db, 'join_tests', 'id1', 'id2', $timer, $logger);
    }
    
    public function create($id1, $id2)
    {
        return $this->baseCreate($id1, $id2);
    }
    
    public function delete($id1, $id2)
    {
        return $this->baseDelete($id1, $id2);
    }
    
    public function retrieveById1($id1)
    {
        return $this->baseRetrieveById('id1', $id1);
    }
    
    public function deleteById1($id1)
    {
        return $this->baseDeleteById('id1', $id1);
    }
}