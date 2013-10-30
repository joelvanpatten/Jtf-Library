<?php
/**
 * @category    Jtf
 *
 * @package     Jtf_OptionalTests
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
class Jtf_OptionalTests extends KissUnitTest
{
    public function test_fromNotNullable_throws_InvalidArgumentException_on_null()
    {
        try
        {
            $optional = Jtf_Optional::fromNotNullable(null);
        }
        catch(InvalidArgumentException $ex)
        {
            $this->testPass();
            return;
        }

        $this->testFail();
    }

    public function test_fromNotNullable_returns_instance_on_valid_reference()
    {
        $optional = Jtf_Optional::fromNotNullable('non-null');

        $this->assertNotEqual($optional, null);
    }

    public function test_fromNullable_accepts_null_values_and_returns_instance()
    {
        $optional = null;

        try
        {
            $optional = Jtf_Optional::fromNullable(null);
        }
        catch(Exception $ex)
        {
            $this->testFail();
            return;
        }

        $this->assertNotEqual($optional, null);
    }

    public function test_isPresent_returns_true_on_non_null_reference()
    {
        $optional = Jtf_Optional::fromNotNullable('non-null');
        $this->assertTrue($optional->isPresent());
    }

    public function test_isPresent_returns_false_on_null_reference()
    {
        $optional = Jtf_Optional::fromNullable(null);
        $this->assertFalse($optional->isPresent());
    }

    public function test_get_returns_reference_when_non_null()
    {
        $optional = Jtf_Optional::fromNotNullable('non-null');
        $value = $optional->get();

        $this->assertEqual($value, 'non-null');
    }

    public function test_get_throws_RuntimeException_when_null()
    {
        $optional = Jtf_Optional::fromNullable(null);

        try
        {
            $value = $optional->get();
        }
        catch(RuntimeException $ex)
        {
            $this->testPass();
            return;
        }

        $this->testFail();
    }

    public function test_getOrElse_returns_reference_when_present()
    {
        $optional = Jtf_Optional::fromNotNullable('non-null');
        $value = $optional->getOrElse('other value');

        $this->assertEqual($value, 'non-null');
    }

    public function test_getOrElse_returns_defaultValue_when_reference_is_null()
    {
        $optional = Jtf_Optional::fromNullable(null);
        $value = $optional->getOrElse('other value');

        $this->assertEqual($value, 'other value');
    }

    public function test_getOrElse_throws_InvalidArgumentException_on_null_default()
    {
        try
        {
            $optional = Jtf_Optional::fromNotNullable('non-null');
            $value = $optional->getOrElse(null);
        }
        catch(InvalidArgumentException $ex)
        {
            $this->testPass();
            return;
        }

        $this->testFail();
    }

    public function test_getOrNull_returns_reference_when_present()
    {
        $optional = Jtf_Optional::fromNotNullable('non-null');
        $value = $optional->getOrNull();

        $this->assertEqual($value, 'non-null');
    }

    public function test_getOrNull_returns_null_when_not_present()
    {
        $optional = Jtf_Optional::fromNullable(null);
        $value = $optional->getOrNull();

        $this->assertEqual($value, null);
    }

    public function test_equals_returns_true_when_references_are_equal()
    {
        $optional = Jtf_Optional::fromNotNullable('non-null');

        $this->assertTrue($optional->equals('non-null'));
    }

    public function test_equals_returns_false_when_references_are_not_equal()
    {
        $optional = Jtf_Optional::fromNotNullable('non-null');

        $this->assertFalse($optional->equals('other value'));
    }
}