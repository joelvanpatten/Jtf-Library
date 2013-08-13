<?php
/**
 * @category    KissTest
 *
 * @package     KT_Result_TestCase
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

/** @see KT_MilliTimespan */
require_once(realpath(dirname(__FILE__) . '/../MilliTimespan.php'));


class KT_Result_TestCase
{
    /** @var float */
    private $_executionTimeInMillisecs;
    /** @var boolean */
    private $_testPassed;
    /** @var string */
    private $_message;
    /** @var KT_MilliTimespan */
    private $_milliTimespan;
    /** @var string */
    private $_testCaseName;


    /**
     * Class Constructor
     *
     * @param KT_MilliTimespan $milliTimespan
     */
    public function __construct(KT_MilliTimespan $milliTimespan)
    {
        $this->_milliTimespan = $milliTimespan;
        $this->_testPassed    = true;
    }


    /**
     * start Test Case
     */
    public function startTestCase()
    {
        $this->_milliTimespan->startTimer();
    }


    /**
     * stop Test Case
     */
    public function stopTestCase()
    {
        $this->_milliTimespan->stopTimer();
        $this->_executionTimeInMillisecs 
            = $this->_milliTimespan->getElapsedTimeInMilliSec();
    }


    /**
     * get Execution Time In Millisecs
     *
     * @return float
     */
    public function getExecutionTimeInMillisecs()
    {
        if($this->_executionTimeInMillisecs > 0)
        {
            return $this->_executionTimeInMillisecs;
        }
        else
        {
            return 0;
        }
    }


    /**
     * set Test Passed
     */
    public function setTestPassed()
    {
        $this->_testPassed = true;
    }

    
    /**
     * set Test Failed
     */
    public function setTestFailed()
    {
        $this->_testPassed = false;
    }

    /**
     * get Test Status
     *
     * @return boolean
     */
    public function getTestStatus()
    {
        return $this->_testPassed;
    }


    /**
     * Get Test Case Message
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->_message;
    }


    /**
     * Set the test case message. Typical values for this will be
     * reasons for failure, etc.
     *
     * @param string $message
     */
    public function setMessage($message)
    {
        if($message == null)
        {
            $this->_message = '';
        }
        else
        {
            $this->_message = strval($message);
        }
    }


    /**
     * set Test Case Name
     *
     * @param string $testCaseName
     */
    public function setTestCaseName($testCaseName)
    {
        $this->_testCaseName = strval($testCaseName);
    }


    /**
     * get Test Case Name
     *
     * @return string
     */
    public function getTestCaseName()
    {
        return $this->_testCaseName;
    }
}