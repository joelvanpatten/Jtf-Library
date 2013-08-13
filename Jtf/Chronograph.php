<?php
/**
 * @category    Jtf
 *
 * @package     Jtf_Chronograph
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
class Jtf_Chronograph
{
    /** @var float */
    private $_timeStartInMicroSeconds;
    /** @var float */
    private $_timeStopInMicroSeconds;

    const MILLISEC_PER_SECOND    = 1000.0;


    /**
     * start
     */
    public function start()
    {
        $this->_timeStartInMicroSeconds = microtime(true);
    }


    /**
     * stop
     */
    public function stop()
    {
       $this->_timeStopInMicroSeconds = microtime(true);
    }


    /**
     * getElapsedTimeInMillisecs
     *
     * @return float
     */
    public function getElapsedTimeInMillisecs()
    {
        $seconds = $this->getElaspedTimeInSeconds();

        $milliSeconds = $seconds * self::MILLISEC_PER_SECOND;

        return round($milliSeconds, 1);
    }


    /**
     * getElaspedTimeInSeconds
     *
     * @return float
     */
    public function getElaspedTimeInSeconds()
    {
        if(!$this->_timeStartInMicroSeconds)
        {
            return 0;
        }

        $microSecsStart = $this->_timeStartInMicroSeconds;
        //echo '$microSecsStart = ' . $microSecsStart . '<br>';
        $microSecsStop  = $this->_timeStopInMicroSeconds;
        //echo '$microSecsStop = ' . $microSecsStop . '<br>';

        if($microSecsStop == 0)
        {
            // The function stopTimer was not called.
            $microSecsStop = microtime(true);
        }

        $seconds = $microSecsStop - $microSecsStart;
        //echo '$seconds = ' . $seconds . '<br>';

        return round($seconds, 4);
    }

}
