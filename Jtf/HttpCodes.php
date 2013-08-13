<?php
/**
 * @category    Jtf
 *
 * @package     Jtf_HttpCodes
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
class Jtf_HttpCodes
{
    /** var array */
    private $_codes;
    
    
    /**
     * __construct
     */
    public function __construct()
    {
        $this->_codes = array();
        
        #-------------------------------------
        # Define 100 series http codes (informational)
        #-------------------------------------
        $this->_codes[100]  = "100 Continue";
        $this->_codes[101]  = "101 Switching Protocols";

        #-------------------------------------
        # Define 200 series http codes (successful)
        #-------------------------------------
        $this->_codes[200]  = "200 OK";
        $this->_codes[201]  = "201 Created";
        $this->_codes[202]  = "202 Accepted";
        $this->_codes[203]  = "203 Non-Authoritative Information";
        $this->_codes[204]  = "204 No Content";
        $this->_codes[205]  = "205 Reset Content";
        $this->_codes[206]  = "206 Partial Content";

        #-------------------------------------
        # Define 300 series http codes (redirection)
        #-------------------------------------
        $this->_codes[300]  = "300 Multiple Choices";
        $this->_codes[301]  = "301 Moved Permanently";
        $this->_codes[302]  = "302 Found";
        $this->_codes[303]  = "303 See Other";
        $this->_codes[304]  = "304 Not Modified";
        $this->_codes[305]  = "305 Use Proxy";
        $this->_codes[306]  = "306 (Unused)";
        $this->_codes[307]  = "307 Temporary Redirect";

        #-------------------------------------
        # Define 400 series http codes (client error)
        #-------------------------------------
        $this->_codes[400]  = "400 Bad Request";
        $this->_codes[401]  = "401 Unauthorized";
        $this->_codes[402]  = "402 Payment Required";
        $this->_codes[403]  = "403 Forbidden";
        $this->_codes[404]  = "404 Not Found";
        $this->_codes[405]  = "405 Method Not Allowed";
        $this->_codes[406]  = "406 Not Acceptable";
        $this->_codes[407]  = "407 Proxy Authentication Required";
        $this->_codes[408]  = "408 Request Timeout";
        $this->_codes[409]  = "409 Conflict";
        $this->_codes[410]  = "410 Gone";
        $this->_codes[411]  = "411 Length Required";
        $this->_codes[412]  = "412 Precondition Failed";
        $this->_codes[413]  = "413 Request Entity Too Large";
        $this->_codes[414]  = "414 Request-URI Too Long";
        $this->_codes[415]  = "415 Unsupported Media Type";
        $this->_codes[416]  = "416 Requested Range Not Satisfiable";
        $this->_codes[417]  = "417 Expectation Failed";

        #-------------------------------------
        # Define 500 series http codes (server error)
        #-------------------------------------
        $this->_codes[500]  = "500 Internal Server Error";
        $this->_codes[501]  = "501 Not Implemented";
        $this->_codes[502]  = "502 Bad Gateway";
        $this->_codes[503]  = "503 Service Unavailable";
        $this->_codes[504]  = "504 Gateway Timeout";
        $this->_codes[505]  = "505 HTTP Version Not Supported";
    }
    
    
    /**
     *
     * @param int $code
     * @return string 
     */
    public function getCodeMessage($code)
    {
        $code   = intval($code);
        $exists = array_key_exists($code, $this->_codes);
        
        if($exists == true)
        {
            return $this->_codes[$code];
        }
        
        return '';
    }
}