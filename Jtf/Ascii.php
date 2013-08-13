<?php
/**
 * @category    Jtf
 *
 * @package     Jtf_Ascii
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
class Jtf_Ascii
{
    /**
     * normalizeSpecialCharacters
     *
     * @param string $str
     * @return string
     */
    public static function normalizeSpecialCharacters($str)
    {
        $unwantedUTF8 = array(  "\xe2\x80\x98", 
                                "\xe2\x80\x99", 
                                "\xe2\x80\x9c", 
                                "\xe2\x80\x9d", 
                                "\xe2\x80\x93", 
                                "\xe2\x80\x94", 
                                "\xe2\x80\xa6"
                                );
                             
        $replace = array("'", "'", '"', '"', '-', '--', '...');
    
        // First, replace UTF-8 characters.
        $str = str_replace($unwantedUTF8, $replace, $str);
        
        $unwanted1252 = array(  chr(145), 
                                chr(146), 
                                chr(147), 
                                chr(148), 
                                chr(150), 
                                chr(151), 
                                chr(133)
                                );
        
        // Next, replace their Windows-1252 equivalents.
        $str = str_replace($unwanted1252, $replace, $str);
         
        //Further normalize odd characters down to their asscii equivalents.
        $str = str_replace('\xe2\x80\xba', '>',    $str);    // right single guillemet
        $str = str_replace('\xc5\x92',     'oe',   $str);    // oe ligature
        $str = str_replace('\xc5\xb8',     'Y',    $str);    // Y Dieresis
        $str = str_replace('\xe2\x82\xac',  'EUR', $str);    // EURO SIGN 
        $str = str_replace('\xe2\x80\x9a',  ',',   $str);    // SINGLE LOW-9 QUOTATION MARK
        $str = str_replace('\xc6\x92',      'f',   $str);    // LATIN SMALL LETTER F WITH HOOK
        $str = str_replace('\xe2\x80\x9e',  ',,', $str);     // DOUBLE LOW-9 QUOTATION MARK 
        $str = str_replace('\xe2\x80\x90',  '-', $str);      // HYPHEN
        $str = str_replace('\xe2\x80\x91',  '-', $str);      // NON-BREAKING HYPHEN
        $str = str_replace('\xe2\x80\x92',  '--', $str);     // FIGURE DASH
        $str = str_replace('\xe2\x80\x93',  '--', $str);     // EN DASH
        $str = str_replace('\xe2\x80\x94',  '---', $str);    // EM DASH
        $str = str_replace('\xe2\x80\x95',  '---', $str);    // EM DASH
        $str = str_replace('\xe2\x80\x96',  '||', $str);     // DOUBLE VERTICAL LINE
        $str = str_replace('\xe2\x80\x97',  '_', $str);      // DOUBLE LOW LINE
        $str = str_replace('\xe2\x80\xa0',  '+', $str);      // DAGGER
        $str = str_replace('\xe2\x80\xa1',  '++', $str);     // DOUBLE DAGGER
        $str = str_replace('\xe2\x80\xa2',  '*', $str);      // BULLET
        $str = str_replace('\xe2\x80\xa3',  '>', $str);      // TRIANGULAR BULLET
        $str = str_replace('\xe2\x80\xa4',  '-', $str);      // ONE DOT LEADER
        $str = str_replace('\xe2\x80\xa4',  '--', $str);     // TWO DOT LEADER
        $str = str_replace('\xe2\x80\xb0',  '(0/00)', $str); // PER MILLE SIGN
        $str = str_replace('\xe2\x80\xb1',  '(0/000)', $str);// PER TEN THOUSAND SIGN
        $str = str_replace('\xe2\x80\xb2',  "'", $str);      // PRIME
        $str = str_replace('\xe2\x80\xb3',  "''", $str);     // DOUBLE PRIME
        $str = str_replace('\xe2\x80\xb4',  "'''", $str);    // TRIPLE PRIME
        $str = str_replace('\xc2\xa1',      "!", $str);      // INVERTED EXCLAMATION MARK
        $str = str_replace('\xc2\xa2',      "c", $str);      // CENT SIGN
        $str = str_replace('\xc2\xa5',      "YEN", $str);    // YEN SIGN
        $str = str_replace('\xc2\xa9',      "(c)", $str);    // COPYRIGHT SIGN
        $str = str_replace('\xc2\xae',      "(R)", $str);    // REGISTERED SIGN
        $str = str_replace('\xc2\xb0',      "deg", $str);    // DEGREE SIGN
        $str = str_replace('\xc2\xb1',      "+/-", $str);    // PLUS-MINUS SIGN
        $str = str_replace('\xe2\x84\xa2',  "(TM)", $str);   // TRADEMARK 
        $str = str_replace('•',  "*", $str);                 // BULLET
        
        $unwanted_array = array(    'Š'=>'S',  'š'=>'s',  'Ž'=>'Z',  'ž'=>'z',
                                    'À'=>'A',  'Á'=>'A',  'Â'=>'A',  'Ã'=>'A',
                                    'Ä'=>'A',  'Å'=>'A',  'Æ'=>'AE', 'Ç'=>'C',
                                    'È'=>'E',  'É'=>'E',  'Ê'=>'E',  'Ë'=>'E',
                                    'Ì'=>'I',  'Í'=>'I',  'Î'=>'I',  'Ï'=>'I',
                                    'Ñ'=>'N',  'Ò'=>'O',  'Ó'=>'O',  'Ô'=>'O',
                                    'Õ'=>'O',  'Ö'=>'O',  'Ø'=>'O',  'Ù'=>'U',
                                    'Ú'=>'U',  'Û'=>'U',  'Ü'=>'U',  'Ý'=>'Y',
                                    'Þ'=>'B',  'ß'=>'Ss', 'à'=>'a',  'á'=>'a',
                                    'â'=>'a',  'ã'=>'a',  'ä'=>'a',  'å'=>'a',
                                    'æ'=>'ae', 'ç'=>'c',  'è'=>'e',  'é'=>'e',
                                    'ê'=>'e',  'ë'=>'e',  'ì'=>'i',  'í'=>'i',
                                    'î'=>'i',  'ï'=>'i',  'ð'=>'o',  'ñ'=>'n',
                                    'ò'=>'o',  'ó'=>'o',  'ô'=>'o',  'õ'=>'o',
                                    'ö'=>'o',  'ø'=>'o',  'ù'=>'u',  'ú'=>'u',
                                    'û'=>'u',  'ý'=>'y',  'ý'=>'y',  'þ'=>'b',
                                    'ÿ'=>'y' );

        //Normalize accented and foreign characters.
        $str = strtr( $str, $unwanted_array );

        $str = mb_convert_encoding($str, "UTF-8");

        return $str;
    }


    /**
     * removeNonAscii - This function strips all non-ascii characters from the
     *      string.
     *
     * @param string $str
     * @return string
     */
    public static function removeNonAsciiPrintable($str)
    {
        $str = iconv('UTF-8', "ASCII//TRANSLIT", $str);
        $str = preg_replace('/[^\x09^\x0A^\x0C^\x0D^\x20-\x7E]/','', $str);
        return $str;
    }


    /**
     * convertToAscii - This function attempts to convert as many non-ascii
     *      characters to the ascii equivalent. Then non-ascii characters are
     *      stripped out.
     *
     * @param string $str
     * @return string
     */
    public static function convertToAscii($str)
    {
        $str = self::normalizeSpecialCharacters($str);
        $str = self::removeNonAsciiPrintable($str);
        return $str;
    }

    
    /**
     * convertArrayToAscii - This function attempts to convert as many non-ascii
     *      characters to the ascii equivalent within the array. Then, non-ascii 
     *      characters are stripped out.
     *
     * @param string[] $array
     * @return string[]
     */
    public static function convertArrayToAscii($array)
    {
        $temp = array();

        foreach($array as $key => $value)
        {
            $temp[$key] = Jtf_Ascii::convertToAscii(strval($value));
        }

        return $temp;
    }
}