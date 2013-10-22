<?php
/**
 * @category    Jtf
 *
 * @package     Jtf_Enum_MonthsTests
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
class Jtf_Enum_MonthsTests extends KissUnitTest
{
    public function test_value_returns_chosen_month_of_year()
    {
        $jan = new Jtf_Enum_Months(Jtf_Enum_Months::JANUARY);
        $feb = new Jtf_Enum_Months(Jtf_Enum_Months::FEBRUARY);
        $mar = new Jtf_Enum_Months(Jtf_Enum_Months::MARCH);
        $apr = new Jtf_Enum_Months(Jtf_Enum_Months::APRIL);
        $may = new Jtf_Enum_Months(Jtf_Enum_Months::MAY);
        $jun = new Jtf_Enum_Months(Jtf_Enum_Months::JUNE);
        $jul = new Jtf_Enum_Months(Jtf_Enum_Months::JULY);
        $aug = new Jtf_Enum_Months(Jtf_Enum_Months::AUGUST);
        $sep = new Jtf_Enum_Months(Jtf_Enum_Months::SEPTEMBER);
        $oct = new Jtf_Enum_Months(Jtf_Enum_Months::OCTOBER);
        $nov = new Jtf_Enum_Months(Jtf_Enum_Months::NOVEMBER);
        $dec = new Jtf_Enum_Months(Jtf_Enum_Months::DECEMBER);

        $this->assertEqual($jan->value(), Jtf_Enum_Months::JANUARY,   'jan');
        $this->assertEqual($feb->value(), Jtf_Enum_Months::FEBRUARY,  'feb');
        $this->assertEqual($mar->value(), Jtf_Enum_Months::MARCH,     'mar');
        $this->assertEqual($apr->value(), Jtf_Enum_Months::APRIL,     'apr');
        $this->assertEqual($may->value(), Jtf_Enum_Months::MAY,       'may');
        $this->assertEqual($jun->value(), Jtf_Enum_Months::JUNE,      'jun');
        $this->assertEqual($jul->value(), Jtf_Enum_Months::JULY,      'jul');
        $this->assertEqual($aug->value(), Jtf_Enum_Months::AUGUST,    'aug');
        $this->assertEqual($sep->value(), Jtf_Enum_Months::SEPTEMBER, 'sep');
        $this->assertEqual($oct->value(), Jtf_Enum_Months::OCTOBER,   'oct');
        $this->assertEqual($nov->value(), Jtf_Enum_Months::NOVEMBER,  'nov');
        $this->assertEqual($dec->value(), Jtf_Enum_Months::DECEMBER,  'dec');
    }
}