<?php
/**
 * @category    KissTest
 *
 * @package     KT_Result_Summary
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

/** @see KT_Result_UnitTest */
require_once(realpath(dirname(__FILE__) . '/UnitTest.php'));
/** @see KT_MilliTimespan */
require_once(realpath(dirname(__FILE__) . '/../MilliTimespan.php'));

class KT_Result_Summary
{
    /** @var KT_Result_UnitTest[] */
    private $_unitTestResults;
    /** @var timer */
    private static $_timer;

    /**
     * Class Constructor
     */
    public function __construct()
    {
        $this->_unitTestResults = array();
        self::$_timer = new KT_MilliTimespan();
        self::$_timer->startTimer();
    }


    /**
     * get Unit Test Count
     *
     * @return int
     */
    public function getUnitTestCount()
    {
        return count($this->_unitTestResults);
    }


    /**
     * add Unit Test Result
     *
     * @param KT_Result_UnitTest $unitTestResult
     */
    public function addUnitTestResult(KT_Result_UnitTest $unitTestResult)
    {
        $this->_unitTestResults[] = $unitTestResult;
    }


    /**
     * get Test Cases Count
     *
     * @return integer
     */
    public function getTestCasesCount()
    {
        $total = 0;

        foreach($this->_unitTestResults as $result)
        {
            /* @var $result KT_Result_UnitTest */
            $total += $result->getTestCaseCount();
        }

        return $total;
    }


    /**
     * get Test Cases Passed Count
     *
     * @return integer
     */
    public function getTestCasesPassedCount()
    {
        $totalPassed = 0;

        foreach($this->_unitTestResults as $result)
        {
            /* @var $result KT_Result_UnitTest */
            $totalPassed += $result->getNumberTestCasesPass();
        }

        return $totalPassed;
    }


    /**
     * get Test Cases Failed Count
     *
     * @return integer
     */
    public function getTestCasesFailedCount()
    {
        $total  = $this->getTestCasesCount();
        $passed = $this->getTestCasesPassedCount();

        return $total - $passed;
    }


    /**
     * get Execution Time In Millisecs
     *
     * @return float
     */
    public function getExecutionTimeInMillisecs()
    {
        self::$_timer->stopTimer();
        $totalTime = self::$_timer->getElapsedTimeInMilliSec();
        
        return $totalTime;
    }


    /**
     * get Percentage Passed
     *
     * @return float
     */
    public function getPercentagePassed()
    {
        $total = $this->getTestCasesCount();
        $total = floatval($total);
        
        if($total == 0)
        {
            return 100.0;
        }

        $passed        = $this->getTestCasesPassedCount();
        $passed        = floatval($passed);
        $percentPassed = ( $passed/$total ) * 100.0;

        return $percentPassed;
    }


    /**
     * get Percentage Failed
     *
     * @return float
     */
    public function getPercentageFailed()
    {
        return 100.0 - $this->getPercentagePassed();
    }


    public function getUnitTestsResults()
    {
        return $this->_unitTestResults;
    }
}
