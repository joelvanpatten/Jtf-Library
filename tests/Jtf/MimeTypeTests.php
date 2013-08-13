<?php
/**
 * @category    Jtf
 *
 * @package     Jtf_MimeTypeTests
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
class Jtf_MimeTypeTests extends KissUnitTest
{

    public function test_retrieves_correct_mimetype_when_no_spaces_in_filename1()
    {
        $mimeType = new Jtf_MimeType();
        $expected = "application/pdf";
        $actual   = $mimeType->getMimeTypeFromFileName("myfile.pdf");


        return $this->assertEqual($expected, $actual);
    }

    public function test_retrieves_correct_mimetype_when_no_spaces_in_filename2()
    {
        $mimeType = new Jtf_MimeType();
        $expected = "image/jpeg";
        $actual   = $mimeType->getMimeTypeFromFileName("myfile.jpg");

        return $this->assertEqual($expected, $actual);
    }

    public function test_retrieves_correct_mimetype_when_no_spaces_in_filename3()
    {
        $mimeType = new Jtf_MimeType();
        $expected = "image/gif";
        $actual   = $mimeType->getMimeTypeFromFileName("myfile.gif");

        return $this->assertEqual($expected, $actual);
    }

    public function test_retrieves_correct_mimetype_when_no_spaces_in_filename4()
    {
        $mimeType = new Jtf_MimeType();
        $expected = "application/x-sh";
        $actual   = $mimeType->getMimeTypeFromFileName("myfile.sh");

        return $this->assertEqual($expected, $actual);
    }


    public function test_retrieves_correct_mimetype_when_spaces_exist_in_filename1()
    {
        $mimeType = new Jtf_MimeType();
        $expected = "application/pdf";
        $actual   = $mimeType->getMimeTypeFromFileName("my file.pdf");


        return $this->assertEqual($expected, $actual);
    }

    public function test_retrieves_correct_mimetype_when_spaces_exist_in_filename2()
    {
        $mimeType = new Jtf_MimeType();
        $expected = "image/jpeg";
        $actual   = $mimeType->getMimeTypeFromFileName(" myfile.jpg");

        return $this->assertEqual($expected, $actual);
    }

    public function test_retrieves_correct_mimetype_when_spaces_exist_in_filename3()
    {
        $mimeType = new Jtf_MimeType();
        $expected = "image/gif";
        $actual   = $mimeType->getMimeTypeFromFileName("myfile .gif");

        return $this->assertEqual($expected, $actual);
    }

    public function test_retrieves_correct_mimetype_when_spaces_exist_in_filename4()
    {
        $mimeType = new Jtf_MimeType();
        $expected = "application/x-sh";
        $actual   = $mimeType->getMimeTypeFromFileName(" my file.sh ");

        return $this->assertEqual($expected, $actual);
    }

    public function test_retrieves_correct_mimetype_when_path_seperators_exist_in_filename1()
    {
        $mimeType = new Jtf_MimeType();
        $expected = "application/pdf";
        $actual   = $mimeType->getMimeTypeFromFileName("C:\\my\file.pdf");


        return $this->assertEqual($expected, $actual);
    }

    public function test_retrieves_correct_mimetype_when_path_seperators_exist_in_filename2()
    {
        $mimeType = new Jtf_MimeType();
        $expected = "image/jpeg";
        $actual   = $mimeType->getMimeTypeFromFileName("/var/www/myfile.jpg");

        return $this->assertEqual($expected, $actual);
    }

    public function test_retrieves_correct_mimetype_when_path_seperators_exist_in_filename3()
    {
        $mimeType = new Jtf_MimeType();
        $expected = "image/gif";
        $actual   = $mimeType->getMimeTypeFromFileName("var/myfile .gif");

        return $this->assertEqual($expected, $actual);
    }

    public function test_retrieves_correct_mimetype_when_path_seperators_exist_in_filename4()
    {
        $mimeType = new Jtf_MimeType();
        $expected = "application/x-sh";
        $actual   = $mimeType->getMimeTypeFromFileName("c:\\var\my file.sh ");

        return $this->assertEqual($expected, $actual);
    }

    public function test_retrieves_correct_mimetype_from_extension_only()
    {
        $mimeType = new Jtf_MimeType();
        $expected = "application/x-sh";
        $actual   = $mimeType->getMimeTypeFromFileExtension("sh");

        return $this->assertEqual($expected, $actual);
    }

    public function test_retrieves_correct_mimetype_from_extension_only_with_spaces()
    {
        $mimeType = new Jtf_MimeType();
        $expected = "application/x-sh";
        $actual   = $mimeType->getMimeTypeFromFileExtension(" sh ");

        return $this->assertEqual($expected, $actual);
    }

    public function test_retrieves_correct_mimetype_from_extension_only_with_period()
    {
        $mimeType = new Jtf_MimeType();
        $expected = "application/x-sh";
        $actual   = $mimeType->getMimeTypeFromFileExtension(".sh");

        return $this->assertEqual($expected, $actual);
    }


    public function test_retrieves_correct_mimetype_from_extension_only_with_period_and_spaces()
    {
        $mimeType = new Jtf_MimeType();
        $expected = "application/x-sh";
        $actual   = $mimeType->getMimeTypeFromFileExtension(" .sh ");

        return $this->assertEqual($expected, $actual);
    }

    public function test_retrieves_correct_default_mimetype()
    {
        $mimeType = new Jtf_MimeType();
        $expected = "application/octet-stream";
        $actual   = $mimeType->getMimeTypeFromFileExtension("bad-mime-type");

        return $this->assertEqual($expected, $actual);
    }

}