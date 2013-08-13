<?php
/**
 * @category    JTF
 *
 * @package     Jtf_Download
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
class Jtf_Download
{
    /**
     * forceDownload
     *
     * @param string $filename
     * @param bytes  $data 
     */
    public static function forceDownload($filename, $data)
    {
        if($filename == '' || $data == '')
		{
			return false;
		}
        
        // Determine if the filename includes a file extension.
		// This is needed to set the MIME type
		if(strpos($filename, '.') === false)
		{
			return false;
		}
        
        $mime = Jtf_MimeType::getMimeTypeFromFileName($filename);
        
        // Generate the server headers
		if (strpos($_SERVER['HTTP_USER_AGENT'], "MSIE") !== false)
		{
			header('Content-Type: "'.$mime.'"');
			header('Content-Disposition: attachment; filename="'.$filename.'"');
			header('Expires: 0');
			header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
			header("Content-Transfer-Encoding: binary");
			header('Pragma: public');
			header("Content-Length: ".strlen($data));
		}
		else
		{
			header('Content-Type: "'.$mime.'"');
			header('Content-Disposition: attachment; filename="'.$filename.'"');
			header("Content-Transfer-Encoding: binary");
			header('Expires: 0');
			header('Pragma: no-cache');
			header("Content-Length: ".strlen($data));
		}

		exit($data);
    }
}