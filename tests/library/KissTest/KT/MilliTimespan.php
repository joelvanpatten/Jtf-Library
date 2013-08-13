<?php
/**
 * @category    KissTest
 *
 * @package     KT_MilliTimespan
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

class KT_MilliTimespan
{
    /** @var float */
    private $_timeStartInMicroSeconds;
    /** @var float */
    private $_timeStopInMicroSeconds;

    const MICROSECS_PER_MILLISEC = 1000.0;


    /**
     * start Timer
     */
    public function startTimer()
    {
        $this->_timeStartInMicroSeconds = microtime(true);
    }


    /**
     * stop Timer
     */
    public function stopTimer()
    {
        $this->_timeStopInMicroSeconds = microtime(true);
    }


    /**
     * get Elapsed Time In MilliSec
     *
     * @return float
     */
    public function getElapsedTimeInMilliSec()
    {
        if(!$this->_timeStartInMicroSeconds)
        {
            return 0;
        }

        $microSecsStart = $this->_timeStartInMicroSeconds;
        $microSecsStop  = $this->_timeStopInMicroSeconds;

        if($microSecsStop == 0)
        {
            // The function stopTimer was not called.
            $microSecsStop = microtime(true);
        }

        $totalMicroSecs = $microSecsStop - $microSecsStart;
        $totalMilliSecs = $totalMicroSecs * self::MICROSECS_PER_MILLISEC;
        
        return $totalMilliSecs;
    }

}

