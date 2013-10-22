<?php
/**
 * @category    Jtf
 *
 * @package     Jtf_Enum_Months
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
class Jtf_Enum_Months extends Jtf_Enum_Abstract
{
    const JANUARY   = 1;
    const FEBRUARY  = 2;
    const MARCH     = 3;
    const APRIL     = 4;
    const MAY       = 5;
    const JUNE      = 6;
    const JULY      = 7;
    const AUGUST    = 8;
    const SEPTEMBER = 9;
    const OCTOBER   = 10;
    const NOVEMBER  = 11;
    const DECEMBER  = 12;

    /* @var int */
    private $_value;


    /**
     * Class Constructor
     *
     * @param int $month
     * @throws InvalidArgumentException
     */
    public function __construct($month)
    {
        switch($month)
        {
            case (self::JANUARY);
                $this->_value = self::JANUARY;
                break;
            case (self::FEBRUARY);
                $this->_value = self::FEBRUARY;
                break;
            case (self::MARCH);
                $this->_value = self::MARCH;
                break;
            case (self::APRIL);
                $this->_value = self::APRIL;
                break;
            case (self::MAY);
                $this->_value = self::MAY;
                break;
            case (self::JUNE);
                $this->_value = self::JUNE;
                break;
            case (self::JULY);
                $this->_value = self::JULY;
                break;
            case (self::AUGUST);
                $this->_value = self::AUGUST;
                break;
            case (self::SEPTEMBER);
                $this->_value = self::SEPTEMBER;
                break;
            case (self::OCTOBER);
                $this->_value = self::OCTOBER;
                break;
            case (self::NOVEMBER);
                $this->_value = self::NOVEMBER;
                break;
            case (self::DECEMBER);
                $this->_value = self::DECEMBER;
                break;
            default;
                $msg = 'Invalid or missing month';
                throw new InvalidArgumentException($msg);
        }
    }


    /**
     * This function returns the value of the current month.
     *
     * @return int
     */
    public function value()
    {
        return $this->_value;
    }
}