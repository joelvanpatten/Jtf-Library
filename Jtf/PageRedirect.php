<?php
/**
 * @category    Jtf
 *
 * @package     Jtf_PageRedirect
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
class Jtf_PageRedirect
{
    /** @var string */
    private $_redirectDestination;
    
    
    /**
     * __construct
     */
    public function __construct()
    {
        $this->_redirectDestination = '/';
    }
    
    
    /**
     * get Redirect Destination
     *
     * @return string 
     */
    public function getRedirectDestination()
    {
        return $this->_redirectDestination;
    }
    
    
    /**
     * set Redirect Destination
     *
     * @param set $destination 
     */
    public function setRedirectDestination($destination)
    {
        $destination = strval($destination);
        $this->_redirectDestination = $destination;
    }
    
    
    /**
     * redirect - This function performs the redirect.
     */
    public function redirect()
    {
        header('Location: ' . $this->_redirectDestination);
        exit;
    }
}
