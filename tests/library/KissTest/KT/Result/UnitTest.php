<?php
/**
 * @category    KissTest
 *
 * @package     KT_Result_UnitTest
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

/** @see KT_Result_TestCase */
require_once(realpath(dirname(__FILE__) . '/TestCase.php'));


class KT_Result_UnitTest
{
    /**  @var string */
    private $_unitTestName;
    /** @var KT_Result_TestCase[] */
    private $_testCaseResults;

    
    /**
     * Class Constructor
     */
    public function __construct()
    {
        $this->_testCaseResults = array();
    }


    /**
     * get Unit Test Name
     *
     * @return string
     */
    public function getUnitTestName()
    {
        return $this->_unitTestName;
    }


    /**
     * set Unit Test Name
     *
     * @param string $name
     */
    public function setUnitTestName($name)
    {
        $this->_unitTestName = strval($name);
    }


    /**
     * add Test Case Result
     *
     * @param KT_Result_TestCase $testCaseResult
     */
    public function addTestCaseResult(KT_Result_TestCase $testCaseResult)
    {
        $this->_testCaseResults[] = $testCaseResult;
    }


    /**
     * get Test Case Count
     *
     * @return int
     */
    public function getTestCaseCount()
    {
        return count($this->_testCaseResults);
    }


    /**
     * get Execution Time In Millisecs
     *
     * @return float
     */
    public function getExecutionTimeInMillisecs()
    {
        $sum = 0;

        foreach($this->_testCaseResults as $result)
        {
            /* @var $result KT_Result_TestCase   */
            $sum += $result->getExecutionTimeInMillisecs();
        }

        return $sum;
    }


    /**
     * get Number Test Cases Pass
     *
     * @return int
     */
    public function getNumberTestCasesPass()
    {
        $sum = 0;

        foreach($this->_testCaseResults as $result)
        {
            /* @var $result KT_Result_TestCase   */
            if($result->getTestStatus())
            {
                $sum++;
            }
        }

        return $sum;
    }


    /**
     * get Number Test Cases Failed
     *
     * @return int
     */
    public function getNumberTestCasesFailed()
    {
        $fails = $this->getTestCaseCount() - $this->getNumberTestCasesPass();
        
        return $fails;
    }


    /**
     * get Percentage Passed
     *
     * @return float
     */
    public function getPercentagePassed()
    {
        $total  = $this->getTestCaseCount();
        $total  = floatval($total);

        $passed = $this->getNumberTestCasesPass();
        $passed = floatval($passed);

        $percentPassed = ( $passed / $total ) * 100;

        return $percentPassed;
    }


    /**
     * get Percentage Failed
     *
     * @return float
     */
    public function getPercentageFailed()
    {
        return (100.0 - $this->getPercentagePassed());
    }


    public function getTestCaseResults()
    {
        return $this->_testCaseResults;
    }

}