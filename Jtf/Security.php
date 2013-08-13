<?php
/**
 * @category    Jtf
 *
 * @package     Jtf_Security
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
 *
 */
class Jtf_Security
{
    /**
     * removeInvisibleCharacters
     * 
     * This prevents sandwiching null characters
     * between ascii characters, like Java\0script.
     * 
     * @param string $str
     * @param bool   $urlEncoded 
     */
    public static function removeInvisibleCharacters($str, $urlEncoded = true)
    {
        $non_displayables = array();
		
		// every control character except newline (dec 10)
		// carriage return (dec 13), and horizontal tab (dec 09)
		
		if ($urlEncoded)
		{
            // url encoded 00-08, 11, 12, 14, 15
			$non_displayables[] = '/%0[0-8bcef]/';
            // url encoded 16-31
			$non_displayables[] = '/%1[0-9a-f]/';
		}
		
        // 00-08, 11, 12, 14-31, 127
		$non_displayables[] = '/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]+/S';	

        $count = 0;
        
		do
		{
			$str = preg_replace($non_displayables, '', $str, -1, $count);
		} while($count > 0);

		return $str;
    }
    
    
    /**
     * sanitizeFilename
     * 
     * When accepting filenames from user input, it is best to 
     * sanitize them to prevent directory traversal and other 
     * security related issues. This function performs filename
     * sanitization. If it is acceptable for the user input to 
     * include relative paths, 
     * e.g. file/in/some/approved/folder.txt, you can set the 
     * second optional parameter, $isRelativePath to true.
     *
     * @param string $filename
     * @param bool $isRelativePath
     * @return string 
     */
    public static function sanitizeFilename($filename, $isRelativePath = false)
    {
        $bad = array(
			"../",
			"<!--",
			"-->",
			"<",
			">",
			"'",
			'"',
			'&',
			'$',
			'#',
			'{',
			'}',
			'[',
			']',
			'=',
			';',
			'?',
			"%20",
			"%22",
			"%3c",		// <
			"%253c",	// <
			"%3e",		// >
			"%0e",		// >
			"%28",		// (
			"%29",		// )
			"%2528",	// (
			"%26",		// &
			"%24",		// $
			"%3f",		// ?
			"%3b",		// ;
			"%3d"		// =
		);

		if($isRelativePath == false)
		{
			$bad[] = './';
			$bad[] = '/';
		}

		$filename = Jtf_Security::removeInvisibleCharacters($filename, false);
		return stripslashes(str_replace($bad, '', $filename));
    }
    
    
    /**
     * stripImageTags
     * 
     * This is a security function that will strip image tags from 
     * a string. It leaves the image URL as plain text.
     *
     * @param string $str
     * @return string 
     */
    public static function stripImageTags($str)
    {
        $str = preg_replace("#<img\s+.*?src\s*=\s*[\"'](.+?)[\"'].*?\>#", 
                            "\\1", $str);
		$str = preg_replace("#<img\s+.*?src\s*=\s*(.+?).*?\>#", 
                            "\\1", $str);

		return $str;
    }
    
    
    /**
     * encodePhpTags
     * 
     * This is a security function that converts PHP tags to entities.
     *
     * @param string $str
     * @return string 
     */
    function encodePhpTags($str)
	{
		return str_replace( array('<?php', '<?PHP', '<?', '?>'),  
                            array('&lt;?php', '&lt;?PHP', '&lt;?', '?&gt;'), 
                            $str );
	}
}