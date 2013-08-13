<?php
/**
 * @category    Jtf
 *
 * @package     Jtf_StringUtilities
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
class Jtf_StringUtilities
{
    /**
     * stript Fwd Slashes
     *
     * Removes any leading/trailing slashes from a string:
     *
     * /this/that/theother/
     *
     * becomes:
     *
     * this/that/theother
     *
     * @param	string
     * @return	string
     */
	public static function striptFwdSlashes($str)
	{
		return trim($str, '/');
	}

    
    /**
     * Strip Back Slashes
     *
     * Removes slashes contained in a string or in an array
     *
     * \this\that\theother\
     *
     * becomes:
     *
     * thisthattheother
     * 
     * @param	mixed	string or array
     * @return	mixed	string or array
     */
	public static function stripBackSlashes($mixed)
	{
		if(is_array($mixed))
		{
			foreach($mixed as $key => $val)
			{
				$mixed[$key] = self::stripBackSlashes($val);
			}
		}
		else
		{
			$mixed = stripslashes($mixed);
		}

		return $mixed;
	}
    

    /**
     * Strip Quotes
     *
     * Removes single and double quotes from a string
     *
     * @access	public
     * @param	string
     * @return	string
     */
	public static function stripQuotes($str)
	{
		return str_replace(array('"', "'"), '', $str);
	}
    

    /**
     * Convert Quotes to Entities
     *
     * Converts single and double quotes to entities
     *
     * @access	public
     * @param	string
     * @return	string
     */
	public static function convertQuotesToEntities($str)
	{
        $input  = array("\'","\"");
        $output = array("&#39;","&quot;");
        $result = str_replace($input, $output, $str);
        
		return $result;
	}

    
    /**
     * Reduce Multiples
     *
     * Reduces multiple instances of a particular character.  Example:
     *
     * Fred, Bill,, Joe, Jimmy
     *
     * becomes:
     *
     * Fred, Bill, Joe, Jimmy
     *
     * @access	public
     * @param	string
     * @param	string	the character you wish to reduce
     * @param	bool	TRUE/FALSE - whether to trim the character 
     *                               from the beginning/end
     * @return	string
     */
	public static function reduceCharacterMultiples( $str, 
	                                                 $character = ',', 
	                                                 $trim = FALSE )
	{
        $pattern = '#' . preg_quote($character, '#') . '{2,}#';
		$str     = preg_replace($pattern, $character, $str);

		if($trim === TRUE)
		{
			$str = trim($str, $character);
		}

		return $str;
	}
    

    /**
     * Create a Random String
     *
     * Useful for generating passwords or hashes.
     *
     * @access	public
     * @param	string	type of random string.  basic, alpha, alunum, numeric, 
     *          nozero, unique, md5, encrypt and sha1, sha256, sha512, 32char,
     *          40char, 64char, 128char
     * @param	integer	number of characters
     * @return	string
     */
    public static function randomString($type = 'alnum', $len = 8)
	{
		switch($type)
		{
			case 'basic'	: return mt_rand();
				break;
			
            case 'alnum'	:
			case 'numeric'	:
			case 'nozero'	:
			case 'alpha'	:
                switch ($type)
                {
                    case 'alpha'  : $pool = 'abcdefghijklmnopqrstuvwxyz'
                                          . 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                        break;
                    case 'alnum'  : $pool = '0123456789'
                                          . 'abcdefghijklmnopqrstuvwxyz'
                                          . 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                        break;
                    case 'numeric': $pool = '0123456789';
                        break;
                    case 'nozero' : $pool = '123456789';
                        break;
                }

                $str = '';
                for ($i=0; $i < $len; $i++)
                {
                    $str .= substr($pool, mt_rand(0, strlen($pool) -1), 1);
                }
                
                return $str;
				break;
                
            case '32char';
			case 'unique'	:
			case 'md5'		:
                return md5(uniqid(mt_rand()));
				break;
            
            case '40char':
			case 'encrypt'	:
			case 'sha1'	:
                return hash('sha1', uniqid(mt_rand(), TRUE));
				break;
            
            case '64char':
            case 'sha256':
                return hash('sha256', uniqid(mt_rand(), TRUE));
				break;
            
            case '128char':
            case 'sha512':
                return hash('sha512', uniqid(mt_rand(), TRUE));
				break;
		}
	}

    
    /**
     * Word Limiter
     *
     * Limits a string to X number of words.
     *
     * @access	public
     * @param	string
     * @param	integer
     * @param	string	the end character. Usually an ellipsis
     * @return	string
     */
	public static function wordLimiter($str, $limit = 100, $end_char = '&#8230;')
	{
		if (trim($str) == '')
		{
			return $str;
		}

        $pattern = '/^\s*+(?:\S++\s*+){1,'.(int) $limit.'}/';
        $matches = null;
		preg_match($pattern, $str, $matches);

		if (strlen($str) == strlen($matches[0]))
		{
			$end_char = '';
		}

		return rtrim($matches[0]).$end_char;
	}

    
    /**
     * Character Limiter
     *
     * Limits the string based on the character count.  Preserves complete words
     * so the character count may not be exactly as specified.
     *
     * @access	public
     * @param	string
     * @param	integer
     * @param	string	the end character. Usually an ellipsis
     * @return	string
     */
    public static function characterLimiter($str, $n = 500, $end_char = '&#8230;')
	{
		if (strlen($str) < $n)
		{
			return $str;
		}
        
        $str = str_replace(array("\r\n", "\r", "\n"), ' ', $str);
		$str = preg_replace("/\s+/", ' ', $str);

		if (strlen($str) <= $n)
		{
			return $str;
		}

		$out = "";
		foreach (explode(' ', trim($str)) as $val)
		{
			$out .= $val.' ';

			if (strlen($out) >= $n)
			{
				$out = trim($out);
				return (strlen($out) == strlen($str)) ? $out : $out.$end_char;
			}
		}
	}
    

    /**
     * Word Censoring Function
     *
     * Supply a string and an array of disallowed words and any
     * matched words will be converted to #### or to the replacement
     * word you've submitted.
     *
     * @param	string	the text string
     * @param	string	the array of censoered words
     * @param	string	the optional replacement value
     * @return	string
     */
	public static function wordCensor($str, $censored, $replacement = '')
	{
		if( ! is_array($censored))
		{
			return $str;
		}

		$str = ' '.$str.' ';

		// \w, \b and a few others do not match on a unicode character
		// set for performance reasons. As a result words like über
		// will not match on a word boundary. Instead, we'll assume that
		// a bad word will be bookeneded by any of these characters.
		$delim = '[-_\'\"`(){}<>\[\]|!?@#%&,.:;^~*+=\/ 0-9\n\r\t]';

		foreach ($censored as $badword)
		{
			if ($replacement != '')
			{
                $pattern     = "/({$delim})(" 
                             . str_replace('\*', '\w*?', preg_quote($badword, '/'))
                             . ")({$delim})/i";
                             
                $replacement = "\\1{$replacement}\\3";
				
                $str         = preg_replace($pattern, $replacement, $str);
			}
			else
			{
                $pattern     = "/({$delim})("
                             . str_replace('\*', '\w*?', preg_quote($badword, '/'))
                             . ")({$delim})/ie";
                             
                $replacement = "'\\1'.str_repeat('#', strlen('\\2')).'\\3'";
				
                $str = preg_replace($pattern, $replacement, $str);
			}
		}

		return trim($str);
	}


    /**
     * Phrase Highlighter
     *
     * Highlights a phrase within a text string
     *
     * @access	public
     * @param	string	the text string
     * @param	string	the phrase you'd like to highlight
     * @param	string	the openging tag to precede the phrase with
     * @param	string	the closing tag to end the phrase with
     * @return	string
     */
	public static function highlightPhrase($str, 
                                           $phrase, 
                                           $tag_open = '<strong>', 
                                           $tag_close = '</strong>')
	{
		if($str == '')
		{
			return '';
		}

		if($phrase != '')
		{
			return preg_replace('/('.preg_quote($phrase, '/').')/i', 
                                $tag_open."\\1".$tag_close, 
                                $str);
		}

		return $str;
	}


    /**
     * Word Wrap
     *
     * Wraps text at the specified character.  Maintains the integrity of words.
     * Anything placed between {unwrap}{/unwrap} will not be word wrapped, nor
     * will URLs.
     *
     * @access	public
     * @param	string	the text string
     * @param	integer	the number of characters to wrap at
     * @return	string
     */
	public static function wordWrap($str, $charlim = '76')
	{
		// Se the character limit
		if ( ! is_numeric($charlim))
			$charlim = 76;

		// Reduce multiple spaces
		$str = preg_replace("| +|", " ", $str);

		// Standardize newlines
		if (strpos($str, "\r") !== FALSE)
		{
			$str = str_replace(array("\r\n", "\r"), "\n", $str);
		}

		// If the current word is surrounded by {unwrap} tags we'll
		// strip the entire chunk and replace it with a marker.
		$unwrap = array();
        $matches = null;
		if (preg_match_all("|(\{unwrap\}.+?\{/unwrap\})|s", $str, $matches))
		{
			for ($i = 0; $i < count($matches['0']); $i++)
			{
				$unwrap[] = $matches['1'][$i];
				$str = str_replace($matches['1'][$i], "{{unwrapped".$i."}}", $str);
			}
		}

		// Use PHP's native function to do the initial wordwrap.
		// We set the cut flag to FALSE so that any individual words that are
		// too long get left alone.  In the next step we'll deal with them.
		$str = wordwrap($str, $charlim, "\n", FALSE);

		// Split the string into individual lines of text and cycle through them
		$output = "";
		foreach (explode("\n", $str) as $line)
		{
			// Is the line within the allowed character count?
			// If so we'll join it to the output and continue
			if (strlen($line) <= $charlim)
			{
				$output .= $line."\n";
				continue;
			}

			$temp = '';
			while ((strlen($line)) > $charlim)
			{
				// If the over-length word is a URL we won't wrap it
				if (preg_match("!\[url.+\]|://|wwww.!", $line))
				{
					break;
				}

				// Trim the word down
				$temp .= substr($line, 0, $charlim-1);
				$line = substr($line, $charlim-1);
			}

			// If $temp contains data it means we had to split up an over-length
			// word into smaller chunks so we'll add it back to our current line
			if ($temp != '')
			{
				$output .= $temp."\n".$line;
			}
			else
			{
				$output .= $line;
			}

			$output .= "\n";
		}

		// Put our markers back
		if (count($unwrap) > 0)
		{
			foreach ($unwrap as $key => $val)
			{
				$output = str_replace("{{unwrapped".$key."}}", $val, $output);
			}
		}

		// Remove the unwrap tags
		$output = str_replace(array('{unwrap}', '{/unwrap}'), '', $output);

		return $output;
	}

    
    /**
	 * Convert newlines to HTML line breaks except within PRE tags
	 *
	 * @access	public
	 * @param	string
	 * @return	string
	 */
	public static function nl2brExceptPre($str)
	{
		$ex = explode("pre>",$str);
		$ct = count($ex);

		$newstr = "";
		for ($i = 0; $i < $ct; $i++)
		{
			if (($i % 2) == 0)
			{
				$newstr .= nl2br($ex[$i]);
			}
			else
			{
				$newstr .= $ex[$i];
			}

			if ($ct - 1 != $i)
				$newstr .= "pre>";
		}

		return $newstr;
	}

}


