<?php
/**
 * @category    KissTest
 *
 * @package     KissUnitTest
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
require_once('KT/MilliTimespan.php');
/** @see KT_Result_TestCase */
require_once('KT/Result/TestCase.php');
/** @see KT_Result_UnitTest */
require_once('KT/Result/UnitTest.php');
/** @see KT_Result_Summary */
require_once('KT/Result/Summary.php');
/** @see KT_Report */
require_once('KT/Report.php');


class KissUnitTest
{
    /** @var string */
    private $_unitTestName;
    /**  @var KT_Result_Summary */
    private static $_summary;
    /** @var KT_Result_UnitTest */
    private $_unitTestResult;
    /** @var KT_Result_TestCase*/
    private $_currentTestCase;


    /**
     * Class Constructor
     */
    public function __construct()
    {
        if(self::$_summary == null)
        {
            self::$_summary = new KT_Result_Summary();
        }

        // Determine the class name.
        $this->_unitTestName   = get_class($this);
        $this->_unitTestResult = new KT_Result_UnitTest();
        $this->performAllUnitTests();
    }

    
    /**
     * Start Timer
     */
    public static function startTimer()
    {
        if(self::$_summary == null)
        {
            self::$_summary = new KT_Result_Summary();
        }
    }


    /**
     * This method is executed before each test method is called.
     */
    protected function setUp(){}

    
    /**
     * This method is executed after each test method is called.
     */
    protected function tearDown(){}


    /**
     * Get All Unit Tests Summary
     * 
     * @return string
     */
    public static function getAllUnitTestsSummary()
    {
        if(self::$_summary == null)
        {
            die('No unit tests exist.');
        }

        $report = new KT_Report(self::$_summary);
        $report->generateReport();
    }


    /**
     * Assert Equal
     *
     * @param mixed $first
     * @param mixed $second
     * @return bool
     */
    protected function assertEqual($first, $second, $failMessage = 'null')
    {
        $currTestStatus = $this->_currentTestCase->getTestStatus();

        if($currTestStatus == false)
        {
            return false;
        }

        if($first === $second)
        {
            $this->_currentTestCase->setMessage('');
            $this->_currentTestCase->setTestPassed();

            return true;
        }

        $message = '$first = '          . strval($first) 
                 . ', $second = '       . strval($second)
                 . ', failMessage = '   . $failMessage;
        $this->_currentTestCase->setMessage($message);
        $this->_currentTestCase->setTestFailed();

        return false;
    }


    /**
     * Assert Float Equal
     *
     * @param float $first
     * @param float $second
     * @param float $maxDelta
     * @return bool
     */
    protected function assertFloatEqual($first, $second, $maxDelta, $failMessage = 'null')
    {
        $currTestStatus = $this->_currentTestCase->getTestStatus();

        if($currTestStatus == false)
        {
            return false;
        }

        $delta = abs($first -  $second);
        
        if(floatval($delta) < floatval($maxDelta))
        {
            $this->_currentTestCase->setMessage('');
            $this->_currentTestCase->setTestPassed();

            return true;
        }

        $message = '$first = '          . strval($first)
                 . ', $second = '       . strval($second)
                 . ', $maxDelta = '     . strval($maxDelta)
                 . ', failMessage = '   . $failMessage;
        
        $this->_currentTestCase->setMessage($message);
        $this->_currentTestCase->setTestFailed();

        return false;
    }


    /**
     * Assert Not Equal
     *
     * @param mixed $first
     * @param mixed $second
     * @return bool
     */
    protected function assertNotEqual($first, $second, $failMessage = 'null')
    {
        $currTestStatus = $this->_currentTestCase->getTestStatus();

        if($currTestStatus == false)
        {
            return false;
        }


        if($first !=  $second)
        {
            $this->_currentTestCase->setMessage('');
            $this->_currentTestCase->setTestPassed();

            return true;
        }

        $message = '$first = '        . strval($first) 
                 . ', $second = '     . strval($second)
                 . ', failMessage = ' . $failMessage;
        $this->_currentTestCase->setMessage($message);
        $this->_currentTestCase->setTestFailed();

        return false;
    }


    /**
     * Assert First Greater Than Second
     *
     * @param mixed $first
     * @param mixed $second
     * @return bool
     */
    protected function assertFirstGreaterThanSecond($first, $second, $failMessage = 'null')
    {
        $currTestStatus = $this->_currentTestCase->getTestStatus();

        if($currTestStatus == false)
        {
            return false;
        }

        if($first >  $second)
        {
            $this->_currentTestCase->setMessage('');
            $this->_currentTestCase->setTestPassed();

            return true;
        }

        $message = '$first = '        . strval($first) 
                 . ', $second = '     . strval($second)
                 . ', failMessage = ' . $failMessage;
        $this->_currentTestCase->setMessage($message);
        $this->_currentTestCase->setTestFailed();

        return false;
    }

    
    /**
     * Assert First Greater Than Or Equal Second
     *
     * @param mixed $first
     * @param mixed $second
     * @return bool
     */
    protected function assertFirstGreaterThanOrEqualSecond($first, $second, $failMessage = 'null')
    {
        $currTestStatus = $this->_currentTestCase->getTestStatus();

        if($currTestStatus == false)
        {
            return false;
        }

        if($first >=  $second)
        {
            $this->_currentTestCase->setMessage('');
            $this->_currentTestCase->setTestPassed();

            return true;
        }

        $message = '$first = '        . strval($first) 
                 . ', $second = '     . strval($second)
                 . ', failMessage = ' . $failMessage;
        $this->_currentTestCase->setMessage($message);
        $this->_currentTestCase->setTestFailed();

        return false;
    }


    /**
     * Assert First Less Than Second
     *
     * @param mixed $first
     * @param mixed $second
     * @return bool
     */
    protected function assertFirstLessThanSecond($first, $second, $failMessage = 'null')
    {
        $currTestStatus = $this->_currentTestCase->getTestStatus();

        if($currTestStatus == false)
        {
            return false;
        }

        if($first <  $second)
        {
            $this->_currentTestCase->setMessage('');
            $this->_currentTestCase->setTestPassed();

            return true;
        }

        $message = '$first = '        . strval($first) 
                 . ', $second = '     . strval($second)
                 . ', failMessage = ' . $failMessage;
        $this->_currentTestCase->setMessage($message);
        $this->_currentTestCase->setTestFailed();

        return false;
    }


    /**
     * Assert First Less Than Or Equal Second
     *
     * @param mixed $first
     * @param mixed $second
     * @return bool
     */
    protected function assertFirstLessThanOrEqualSecond(
                            $first, $second, $failMessage = 'null')
    {
        $currTestStatus = $this->_currentTestCase->getTestStatus();

        if($currTestStatus == false)
        {
            return false;
        }

        if($first <=  $second)
        {
            $this->_currentTestCase->setMessage('');
            $this->_currentTestCase->setTestPassed();

            return true;
        }

        $message = '$first = '        . strval($first) 
                 . ', $second = '     . strval($second)
                 . ', failMessage = ' . $failMessage;
        $this->_currentTestCase->setMessage($message);
        $this->_currentTestCase->setTestFailed();

        return false;
    }


    /**
     * Assert False - This assert will fail if the $value provided is not
     * true.
     *
     * @param mixed $value
     * @return bool
     */
    protected function assertTrue($value, $failMessage = 'null')
    {
        $currTestStatus = $this->_currentTestCase->getTestStatus();

        if($currTestStatus == false)
        {
            return false;
        }

        if($value == false)
        {
            $message = 'The provided value is false.'
                     . ', failMessage = ' . $failMessage;
            $this->_currentTestCase->setMessage($message);
            $this->_currentTestCase->setTestFailed();

            return false;
        }

        $this->_currentTestCase->setMessage('');
        $this->_currentTestCase->setTestPassed();

        return true;
    }


    /**
     * Assert False - This assert will fail if the $value provided is not
     * false.
     *
     * @param mixed $value
     * @return bool
     */
    protected function assertFalse($value, $failMessage = 'null')
    {
        $currTestStatus = $this->_currentTestCase->getTestStatus();

        if($currTestStatus == false)
        {
            return false;
        }

        if($value == true)
        {
            $message = 'The provided value is true ($value = ' . $value
                     . ', failMessage = ' . $failMessage . ').';
            $this->_currentTestCase->setMessage($message);
            $this->_currentTestCase->setTestFailed();
            
            return false;
        }

        $this->_currentTestCase->setMessage('');
        $this->_currentTestCase->setTestPassed();

        return true;
    }


    /**
     * This method will always cause a test case to fail.
     *
     * @return bool
     */
    protected function notImplementedFail()
    {
        $currTestStatus = $this->_currentTestCase->getTestStatus();

        if($currTestStatus == false)
        {
            return false;
        }
        
        $message = 'This test is not implemented.';
        $this->_currentTestCase->setMessage($message);
        $this->_currentTestCase->setTestFailed();

        return false;
    }

    
    /**
     * This method will always cause a test case to fail.
     *
     * @return bool
     */
    protected function testFail($message = '')
    {
        $currTestStatus = $this->_currentTestCase->getTestStatus();

        if($currTestStatus == false)
        {
            return false;
        }

        $message = 'Test fail. ' . $message;
        $this->_currentTestCase->setMessage($message);
        $this->_currentTestCase->setTestFailed();

        return false;
    }
    

    /**
     * This method will always cause a test case to pass.
     *
     * @return bool
     */
    protected function testPass()
    {
        $currTestStatus = $this->_currentTestCase->getTestStatus();

        if($currTestStatus == false)
        {
            return false;
        }

        $this->_currentTestCase->setMessage('');
        $this->_currentTestCase->setTestPassed();

        return true;
    }

    
    /**
     * perform All Unit Tests
     */
    private function performAllUnitTests()
    {
        $this->_unitTestResult->setUnitTestName($this->_unitTestName);
        $testMethods = $this->getTestMethods();

        foreach($testMethods as $method)
        {
            $milliTimespan          = new KT_MilliTimespan();
            $testCase               = new KT_Result_TestCase($milliTimespan);
            $this->_currentTestCase = $testCase;

            $testName = str_replace('_', ' ', $method);
            $testCase->setTestCaseName($testName);

            $testCase->startTestCase();
            $this->setUp();
            $this->$method();
            $this->tearDown();
            $testCase->stopTestCase();

            $this->_unitTestResult->addTestCaseResult($testCase);
        }

        $unitTestResult = $this->_unitTestResult;
        self::$_summary->addUnitTestResult($unitTestResult);
    }

    
    /**
     * get Test Methods
     *
     * @return string[]
     */
    private function getTestMethods()
    {
        $classMethods = get_class_methods($this);
        $testPrefix   = 'test_';
        $testMethods  = array();

        foreach($classMethods as $method)
        {
            if(stripos($method, $testPrefix, 0) === 0)
            {
                $testMethods[] = $method;
            }
        }

        return $testMethods;
    }
}

