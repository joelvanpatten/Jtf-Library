<?php
/**
 * @category    Jtf
 *
 * @package     Jtf_Url
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
 * Original URL: http://username:pw@localhost:8080/test?param1=1&param2=two
 *
 *
 * Deconstructed URL:

    Array
    (
        [scheme] => http
        [host]   => localhost
        [port]   => 8080
        [user]   => username
        [pass]   => pw
        [path]   => /test
        [query]  => param1=1&param2=two
        [query_params] => Array
            (
                [paramName1] => 1
                [paramName2] => two
            )

    )
 *
 */
class Jtf_Url
{
    /**
     * This function deconstructs a url into an associative array as
     * follows:
     *
     * [scheme]://[user]:[pass]@[host]:[port]/[path]?[query]#[fragment]
     *
     * Additionally, it adds a 'query_params' key which contains array of
     * url-decoded key-value pairs
     *
     * @param  string   $url Input URL
     * @return string[] Deconstructed URL
     */
    public static function deconstructUrl($url)
    {
        $urlArray                 = parse_url($url);
        $urlArray['query_params'] = array();
        $queryArguments           = array();

        // Parse the GET query parameters.
        if(key_exists('query', $urlArray))
        {
            $query          = $urlArray['query'];
            $queryArguments = explode('&', $query);
        }
        
        foreach($queryArguments as $queryArgument)
        {
            $queryArgument = trim($queryArgument);

            if(strlen($queryArgument) === 0)
            {
                continue;
            }

            $keyAndValue = explode('=', $queryArgument);
            $key         = $keyAndValue[0];
            $value       = $keyAndValue[1];
            
            $urlArray['query_params'][$key] = urldecode($value);
        }

        return $urlArray;
    }


    /**
     * This function constructs a URL string from an associative array
     * as follows:
     *
     * [scheme]://[user]:[pass]@[host]:[port]/[path]?[query]#[fragment]
     *
     * If the key 'query_params' is present, then the key 'query' is ignored.
     *
     * @param string[] $urlArray Associative Array of URL Components
     */
    public static function constructUrl($urlArray)
    {
        $query = '';

        // Compile The Query
        if(isset($urlArray['query_params']))
        {
            if(is_array($urlArray['query_params']))
            {
                $queryArguments = array();

                foreach($urlArray['query_params'] as $key => $value)
                {
                    $encodedValue = urlencode($value);
                    $queryArguments[] = $key . '=' . $encodedValue;
                }
            }

            $query = implode('&', $queryArguments);
        } 
        else
        {
            $query = $urlArray['query'];
        }

        if(!isset($urlArray['scheme']) || strlen($urlArray['scheme']) === 0)
        {
            // Assume the scheme is http.
            $urlArray['scheme'] = 'http';
        }

        // Compile The URL
        $url = $urlArray['scheme'] . '://';

        if(isset($urlArray['user']) && strlen($urlArray['user']) > 0)
        {
            if(isset($urlArray['pass']) && strlen($urlArray['pass']) > 0)
            {
                $url .= $urlArray['user'] . ':' . $urlArray['pass'] . '@';
            }

        }

        $url .= $urlArray['host'];

        if(isset($urlArray['port']) && strlen($urlArray['port']) > 0)
        {
            $url .= ':' . $urlArray['port'];
        }

        if(isset($urlArray['path']) && strlen($urlArray['path']) > 0)
        {
            $url .= $urlArray['path'];
        }

        if(strlen($query) > 0)
        {
            $url .= '?' . $query;
        }

        if(isset($urlArray['fragment']) && strlen($urlArray['fragment']) > 0)
        {
            $url .= '#' . $urlArray['fragment'];
        }

        return $url;
    }


    /**
     * This function parses the URL and returns an array of key-value
     * pairs that consists of the key-value pairs.
     *
     * @param  string   $url
     * @return string[]
     */
    public static function getQueryParameters($url)
    {
        $urlArray = self::deconstructUrl($url);
        return $urlArray['query_params'];
    }


    /**
     * Removes existing url params and sets them to those specified 
     * in $queryParameters
     *
     * @param String $url - Url
     * 
     * @param array $queryParameters - Array of Key-Value pairs to set 
     *      url params to
     * 
     * @return  string Newly compiled url
     */
    public static function setQueryParameters($url, $queryParameters)
    {
        $urlArray                 = self::deconstructUrl($url);
        $urlArray['query']        = '';
        $urlArray['query_params'] = $queryParameters;
        $url                      = self::constructUrl($urlArray);

        return $url;
    }



    /**
     * Updates values of existing url params and/or adds (if not set) 
     * those specified in $queryParameters
     *
     * @param string $url - Url
     * 
     * @param array  $queryParameters - Array of Key-Value pairs to 
     *      set url params to
     * 
     * @return string - newly compile url.
     */
    public static function updateQueryParameters($url, $queryParameters)
    {
        $urlArray                 = self::explode($url);
        $urlArray['query']        = '';
        $urlArray['query_params'] = array_merge($urlArray['query_params'], 
                                    $queryParameters);

        return self::implode($urlArray);
    }



    /**
     * This function creates a well-formed url given a url that
     * has minor issues (e.g. missing scheme).
     *
     * @param string $url
     * @return String
     */
    public static function cleanUrl($url)
    {
        $urlArray = self::deconstructUrl($url);
        $url      = self::constructUrl($urlArray);

        return $url;
    }
}
