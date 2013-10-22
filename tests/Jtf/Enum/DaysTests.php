<?php
/**
 * @category    Jtf
 *
 * @package     Jtf_Enum_DaysTests
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
class Jtf_Enum_DaysTests extends KissUnitTest
{
    public function test_value_returns_chosen_day_of_week()
    {
        $sunday    = new Jtf_Enum_Days(Jtf_Enum_Days::SUNDAY);
        $monday    = new Jtf_Enum_Days(Jtf_Enum_Days::MONDAY);
        $tuesday   = new Jtf_Enum_Days(Jtf_Enum_Days::TUESDAY);
        $wednesday = new Jtf_Enum_Days(Jtf_Enum_Days::WEDNESDAY);
        $thursday  = new Jtf_Enum_Days(Jtf_Enum_Days::THURSDAY);
        $friday    = new Jtf_Enum_Days(Jtf_Enum_Days::FRIDAY);
        $saturday  = new Jtf_Enum_Days(Jtf_Enum_Days::SATURDAY);

        $this->assertEqual($sunday->value(),    Jtf_Enum_Days::SUNDAY,    'Sun');
        $this->assertEqual($monday->value(),    Jtf_Enum_Days::MONDAY,    'Mon');
        $this->assertEqual($tuesday->value(),   Jtf_Enum_Days::TUESDAY,   'Tue');
        $this->assertEqual($wednesday->value(), Jtf_Enum_Days::WEDNESDAY, 'Wed');
        $this->assertEqual($thursday->value(),  Jtf_Enum_Days::THURSDAY,  'Thu');
        $this->assertEqual($friday->value(),    Jtf_Enum_Days::FRIDAY,    'Fri');
        $this->assertEqual($saturday->value(),  Jtf_Enum_Days::SATURDAY,  'Sat');
    }
}
