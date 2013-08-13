<?php
/**
 * This class allows a PHP script to determine the mime type of a file
 * based on the file name. Additionally, this class defaults to
 * the mimetype octet-stream if the file type is not recognized.
 *
 * Example:
 *
 * $mimetype = new Jtf_MimeType();
 * echo $mimetype->getType('acrobat.pdf');
 *
 * @category    JTF
 *
 * @package     Jtf_MimeType
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
class Jtf_MimeType
{
    const DEFAULT_MIMETYPE = 'application/octet-stream';

    private static $_mimetypes = array(
             "ai"       => "application/postscript",
             "aif"      => "audio/x-aiff",
             "aifc"     => "audio/x-aiff",
             "aiff"     => "audio/x-aiff",
             "asc"      => "text/plain",
             "au"       => "audio/basic",
             "avi"      => "video/x-msvideo",
             "bcpio"    => "application/x-bcpio",
             "bin"      => "application/octet-stream",
             "bmp"      => "image/bmp",
             "cdf"      => "application/x-netcdf",
             "class"    => "application/octet-stream",
             "cpio"     => "application/x-cpio",
             "cpt"      => "application/mac-compactpro",
             "csh"      => "application/x-csh",
             "css"      => "text/css",
             "dcr"      => "application/x-director",
             "dir"      => "application/x-director",
             "djv"      => "image/vnd.djvu",
             "djvu"     => "image/vnd.djvu",
             "dll"      => "application/octet-stream",
             "dms"      => "application/octet-stream",
             "doc"      => "application/msword",
             "dvi"      => "application/x-dvi",
             "dxr"      => "application/x-director",
             "eps"      => "application/postscript",
             "etx"      => "text/x-setext",
             "exe"      => "application/octet-stream",
             "ez"       => "application/andrew-inset",
             "gif"      => "image/gif",
             "gtar"     => "application/x-gtar",
             "hdf"      => "application/x-hdf",
             "hqx"      => "application/mac-binhex40",
             "htm"      => "text/html",
             "html"     => "text/html",
             "ice"      => "x-conference-xcooltalk",
             "ief"      => "image/ief",
             "iges"     => "model/iges",
             "igs"      => "model/iges",
             "jpe"      => "image/jpeg",
             "jpeg"     => "image/jpeg",
             "jpg"      => "image/jpeg",
             "js"       => "application/x-javascript",
             "kar"      => "audio/midi",
             "latex"    => "application/x-latex",
             "lha"      => "application/octet-stream",
             "lzh"      => "application/octet-stream",
             "m3u"      => "audio/x-mpegurl",
             "man"      => "application/x-troff-man",
             "me"       => "application/x-troff-me",
             "mesh"     => "model/mesh",
             "mid"      => "audio/midi",
             "midi"     => "audio/midi",
             "mov"      => "video/quicktime",
             "movie"    => "video/x-sgi-movie",
             "mp2"      => "audio/mpeg",
             "mp3"      => "audio/mpeg",
             "mpe"      => "video/mpeg",
             "mpeg"     => "video/mpeg",
             "mpg"      => "video/mpeg",
             "mpga"     => "audio/mpeg",
             "ms"       => "application/x-troff-ms",
             "msh"      => "model/mesh",
             "mxu"      => "video/vnd.mpegurl",
             "nc"       => "application/x-netcdf",
             "oda"      => "application/oda",
             "pbm"      => "image/x-portable-bitmap",
             "pdb"      => "chemical/x-pdb",
             "pdf"      => "application/pdf",
             "pgm"      => "image/x-portable-graymap",
             "pgn"      => "application/x-chess-pgn",
             "png"      => "image/png",
             "pnm"      => "image/x-portable-anymap",
             "ppm"      => "image/x-portable-pixmap",
             "ps"       => "application/postscript",
             "qt"       => "video/quicktime",
             "ra"       => "audio/x-realaudio",
             "ram"      => "audio/x-pn-realaudio",
             "ras"      => "image/x-cmu-raster",
             "rgb"      => "image/x-rgb",
             "rm"       => "audio/x-pn-realaudio",
             "roff"     => "application/x-troff",
             "rpm"      => "audio/x-pn-realaudio-plugin",
             "rtf"      => "text/rtf",
             "rtx"      => "text/richtext",
             "sgm"      => "text/sgml",
             "sgml"     => "text/sgml",
             "sh"       => "application/x-sh",
             "shar"     => "application/x-shar",
             "silo"     => "model/mesh",
             "sit"      => "application/x-stuffit",
             "skd"      => "application/x-koan",
             "skm"      => "application/x-koan",
             "skp"      => "application/x-koan",
             "skt"      => "application/x-koan",
             "smi"      => "application/smil",
             "smil"     => "application/smil",
             "snd"      => "audio/basic",
             "so"       => "application/octet-stream",
             "spl"      => "application/x-futuresplash",
             "src"      => "application/x-wais-source",
             "sv4cpio"  => "application/x-sv4cpio",
             "sv4crc"   => "application/x-sv4crc",
             "swf"      => "application/x-shockwave-flash",
             "t"        => "application/x-troff",
             "tar"      => "application/x-tar",
             "tcl"      => "application/x-tcl",
             "tex"      => "application/x-tex",
             "texi"     => "application/x-texinfo",
             "texinfo"  => "application/x-texinfo",
             "tif"      => "image/tif",
             "tiff"     => "image/tiff",
             "tr"       => "application/x-troff",
             "tsv"      => "text/tab-seperated-values",
             "txt"      => "text/plain",
             "ustar"    => "application/x-ustar",
             "vcd"      => "application/x-cdlink",
             "vrml"     => "model/vrml",
             "wav"      => "audio/x-wav",
             "wbmp"     => "image/vnd.wap.wbmp",
             "wbxml"    => "application/vnd.wap.wbxml",
             "wml"      => "text/vnd.wap.wml",
             "wmlc"     => "application/vnd.wap.wmlc",
             "wmls"     => "text/vnd.wap.wmlscript",
             "wmlsc"    => "application/vnd.wap.wmlscriptc",
             "wrl"      => "model/vrml",
             "xbm"      => "image/x-xbitmap",
             "xht"      => "application/xhtml+xml",
             "xhtml"    => "application/xhtml+xml",
             "xml"      => "text/xml",
             "xpm"      => "image/x-xpixmap",
             "xsl"      => "text/xml",
             "xwd"      => "image/x-windowdump",
             "xyz"      => "chemical/x-xyz",
             "zip"      => "application/zip"
      );


    /**
     * get Mime Type From File Name
     * 
     * @param string $filename
     * @return string
     */
    public static function getMimeTypeFromFileName($filename = '')
    {
        $extension = Jtf_MimeType::retrieveExtensionFromFilename($filename);
        return Jtf_MimeType::getMimeTypeFromFileExtension($extension);
    }

    
    /**
     * get Mime Type From File Extension
     *
     * @param string $extension
     * @return string
     */
    public static function getMimeTypeFromFileExtension($extension = '')
    {
        $extension = strval($extension);
        $extension = trim($extension);
        $extension = str_replace('.', '', $extension);

        if(isset(self::$_mimetypes[$extension]))
        {
            return self::$_mimetypes[$extension];
        }
        else 
        {
            return self::DEFAULT_MIMETYPE;
        }
    }


    /**
     * retrieve Extension From Filename
     *
     * @param string $filename
     * @return string
     */
    private static function retrieveExtensionFromFilename($filename = '')
    {
        $filename       = strval($filename);
        $filename       = trim($filename);
        $filename       = basename($filename);
        $filenameParts  = explode('.', $filename);
        $extension      = $filenameParts[count($filenameParts)-1];

        return $extension;
    }

}
