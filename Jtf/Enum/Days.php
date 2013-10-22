<?php
/**
 * @category    Jtf
 *
 * @package     Jtf_Enum_Days
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
class Jtf_Enum_Days extends Jtf_Enum_Abstract
{
    const SUNDAY     = 1;
    const MONDAY     = 2;
    const TUESDAY    = 3;
    const WEDNESDAY  = 4;
    const THURSDAY   = 5;
    const FRIDAY     = 6;
    const SATURDAY   = 7;

    /* @var int */
    private $_value;


    /**
     * Class Constructor
     *
     * @param int $dayOfWeek
     * @throws InvalidArgumentException
     */
    public function __construct($dayOfWeek)
    {
        switch($dayOfWeek)
        {
            case (self::SUNDAY);
                $this->_value = self::SUNDAY;
                break;
            case (self::MONDAY);
                $this->_value = self::MONDAY;
                break;
            case (self::TUESDAY);
                $this->_value = self::TUESDAY;
                break;
            case (self::WEDNESDAY);
                $this->_value = self::WEDNESDAY;
                break;
            case (self::THURSDAY);
                $this->_value = self::THURSDAY;
                break;
            case (self::FRIDAY);
                $this->_value = self::FRIDAY;
                break;
            case (self::SATURDAY);
                $this->_value = self::SATURDAY;
                break;
            default;
                $msg = 'Invalid or missing day of week';
                throw new InvalidArgumentException($msg);
        }
    }


    /**
     * This function returns the value of the current day of the week.
     *
     * @return int
     */
    public function value()
    {
        return $this->_value;
    }
}