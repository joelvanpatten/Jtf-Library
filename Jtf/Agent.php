<?php
/**
 * @category    Jtf
 *
 * @package     Jtf_Agent
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
class Jtf_Agent
{
    /************************************************************************
     * Instance Variables
     ***********************************************************************/
    
    /* @var array */
    private $_platforms;
    /* @var array */
    private $_browsers;
    /* @var array */
    private $_mobiles;
    /* @var array */
    private $_robots;
    
    /* @var string */
    private $_agent;

    /* @var bool */
	private $_isBrowser;
    /* @var bool */
	private $_isRobot;
    /* @var bool */
	private $_isMobile;

    /* @var array */
	private $_languages;
    /* @var array */
	private $_charsets;

    /* @var string */
	private $_platform;
    /* @var string */
	private $_browser;
    /* @var string */
	private $_version;
    /* @var string */
	private $_mobile;
    /* @var string */
	private $_robot;
    
    /************************************************************************
     * Public Methods
     ***********************************************************************/
    
    /**
     * __construct
     */
    public function __construct()
    {
        $this->_platforms = array (
                    'windows nt 6.1'    => 'Windows 7, Server 2008 R2',
					'windows nt 6.0'	=> 'Windows Vista, Server 2008',
					'windows nt 5.2'	=> 'Windows 2003',
					'windows nt 5.0'	=> 'Windows 2000',
					'windows nt 5.1'	=> 'Windows XP',
					'windows nt 4.0'	=> 'Windows NT 4.0',
					'winnt4.0'			=> 'Windows NT 4.0',
					'winnt 4.0'			=> 'Windows NT',
					'winnt'				=> 'Windows NT',
					'windows 98'		=> 'Windows 98',
					'win98'				=> 'Windows 98',
					'windows 95'		=> 'Windows 95',
					'win95'				=> 'Windows 95',
					'windows'			=> 'Unknown Windows OS',
					'os x'				=> 'Mac OS X',
					'ppc mac'			=> 'Power PC Mac',
					'freebsd'			=> 'FreeBSD',
					'ppc'				=> 'Macintosh',
					'linux'				=> 'Linux',
					'debian'			=> 'Debian',
					'sunos'				=> 'Sun Solaris',
					'beos'				=> 'BeOS',
					'apachebench'		=> 'ApacheBench',
					'aix'				=> 'AIX',
					'irix'				=> 'Irix',
					'osf'				=> 'DEC OSF',
					'hp-ux'				=> 'HP-UX',
					'netbsd'			=> 'NetBSD',
					'bsdi'				=> 'BSDi',
					'openbsd'			=> 'OpenBSD',
					'gnu'				=> 'GNU/Linux',
					'unix'				=> 'Unknown Unix OS'
				);
        
        // The order of this array should NOT be changed. Many browsers return
        // multiple browser types so we want to identify the sub-type first.
        $this->_browsers = array(
					'Flock'				=> 'Flock',
					'Chrome'			=> 'Chrome',
					'Opera'				=> 'Opera',
					'MSIE'				=> 'Internet Explorer',
					'Internet Explorer'	=> 'Internet Explorer',
					'Shiira'			=> 'Shiira',
					'Firefox'			=> 'Firefox',
					'Chimera'			=> 'Chimera',
					'Phoenix'			=> 'Phoenix',
					'Firebird'			=> 'Firebird',
					'Camino'			=> 'Camino',
					'Netscape'			=> 'Netscape',
					'OmniWeb'			=> 'OmniWeb',
					'Safari'			=> 'Safari',
					'Mozilla'			=> 'Mozilla',
					'Konqueror'			=> 'Konqueror',
					'icab'				=> 'iCab',
					'Lynx'				=> 'Lynx',
					'Links'				=> 'Links',
					'hotjava'			=> 'HotJava',
					'amaya'				=> 'Amaya',
					'IBrowse'			=> 'IBrowse'
				);
        
        
        $this->_mobiles = array(
					// legacy array, old values commented out
					'mobileexplorer'	=> 'Mobile Explorer',
//					'openwave'			=> 'Open Wave',
//					'opera mini'		=> 'Opera Mini',
//					'operamini'			=> 'Opera Mini',
//					'elaine'			=> 'Palm',
					'palmsource'		=> 'Palm',
//					'digital paths'		=> 'Palm',
//					'avantgo'			=> 'Avantgo',
//					'xiino'				=> 'Xiino',
					'palmscape'			=> 'Palmscape',
//					'nokia'				=> 'Nokia',
//					'ericsson'			=> 'Ericsson',
//					'blackberry'		=> 'BlackBerry',
//					'motorola'			=> 'Motorola'

					// Phones and Manufacturers
					'motorola'			=> "Motorola",
					'nokia'				=> "Nokia",
					'palm'				=> "Palm",
					'iphone'			=> "Apple iPhone",
					'ipad'				=> "iPad",
					'ipod'				=> "Apple iPod Touch",
					'sony'				=> "Sony Ericsson",
					'ericsson'			=> "Sony Ericsson",
					'blackberry'		=> "BlackBerry",
					'cocoon'			=> "O2 Cocoon",
					'blazer'			=> "Treo",
					'lg'				=> "LG",
					'amoi'				=> "Amoi",
					'xda'				=> "XDA",
					'mda'				=> "MDA",
					'vario'				=> "Vario",
					'htc'				=> "HTC",
					'samsung'			=> "Samsung",
					'sharp'				=> "Sharp",
					'sie-'				=> "Siemens",
					'alcatel'			=> "Alcatel",
					'benq'				=> "BenQ",
					'ipaq'				=> "HP iPaq",
					'mot-'				=> "Motorola",
					'playstation portable'	=> "PlayStation Portable",
					'hiptop'			=> "Danger Hiptop",
					'nec-'				=> "NEC",
					'panasonic'			=> "Panasonic",
					'philips'			=> "Philips",
					'sagem'				=> "Sagem",
					'sanyo'				=> "Sanyo",
					'spv'				=> "SPV",
					'zte'				=> "ZTE",
					'sendo'				=> "Sendo",

					// Operating Systems
					'symbian'				=> "Symbian",
					'SymbianOS'				=> "SymbianOS",
					'elaine'				=> "Palm",
					'palm'					=> "Palm",
					'series60'				=> "Symbian S60",
					'windows ce'			=> "Windows CE",

					// Browsers
					'obigo'					=> "Obigo",
					'netfront'				=> "Netfront Browser",
					'openwave'				=> "Openwave Browser",
					'mobilexplorer'			=> "Mobile Explorer",
					'operamini'				=> "Opera Mini",
					'opera mini'			=> "Opera Mini",

					// Other
					'digital paths'			=> "Digital Paths",
					'avantgo'				=> "AvantGo",
					'xiino'					=> "Xiino",
					'novarra'				=> "Novarra Transcoder",
					'vodafone'				=> "Vodafone",
					'docomo'				=> "NTT DoCoMo",
					'o2'					=> "O2",

					// Fallback
					'mobile'				=> "Generic Mobile",
					'wireless'				=> "Generic Mobile",
					'j2me'					=> "Generic Mobile",
					'midp'					=> "Generic Mobile",
					'cldc'					=> "Generic Mobile",
					'up.link'				=> "Generic Mobile",
					'up.browser'			=> "Generic Mobile",
					'smartphone'			=> "Generic Mobile",
					'cellphone'				=> "Generic Mobile"
				);
        
        // There are hundreds of bots but these are the most common.
        $this->_robots = array(
					'googlebot'			=> 'Googlebot',
					'msnbot'			=> 'MSNBot',
					'slurp'				=> 'Inktomi Slurp',
					'yahoo'				=> 'Yahoo',
					'askjeeves'			=> 'AskJeeves',
					'fastcrawler'		=> 'FastCrawler',
					'infoseek'			=> 'InfoSeek Robot 1.0',
					'lycos'				=> 'Lycos'
				);
        
        
        $this->_agent       = '';

        $this->_isBrowser   = false;
        $this->_isRobot     = false;
        $this->_isMobile    = false;

        $this->_languages   = array();
        $this->_charsets    = array();

        $this->_platform    = '';
        $this->_browser     = '';
        $this->_version     = '';
        $this->_mobile      = '';
        $this->_robot       = '';   
        
        if(isset($_SERVER['HTTP_USER_AGENT']))
		{
			$this->_agent = trim($_SERVER['HTTP_USER_AGENT']);
            
		}

        //Debug::dump('$this->_agent', $this->_agent);
        
		if(!is_null($this->_agent))
		{
            $this->compileData();
		}
    }
    
    
    /**
     * isBrowser
     *
     * @return boolean 
     */
    public function isBrowser()
    {
        return $this->_isBrowser;
    }
    
    
    /**
     * isMobile
     *
     * @return boolean 
     */
    public function isMobile()
    {
        return $this->_isMobile;
    }
    
    
    /**
     * isRobot
     *
     * @return boolean 
     */
    public function isRobot()
    {
        return $this->_isRobot;
    }
    
    
    /**
     * isRefferal
     *
     * @return boolean 
     */
    public function isRefferal()
    {
        if(!isset($_SERVER['HTTP_REFERER']) || $_SERVER['HTTP_REFERER'] == '')
		{
			return false;
		}
        
        //Debug::dump('$_SERVER', $_SERVER);
		return true;
    }
    
    
    /**
     * getBrowserName
     *
     * @return string 
     */
    public function getBrowserName()
    {
        return $this->_browser;
    }
    
    
    /**
     * getBrowserVersion
     *
     * @return string 
     */
    public function getBrowserVersion()
    {
        return $this->_version;
    }
    
    
    /**
     * getMobileDeviceName
     *
     * @return string 
     */
    public function getMobileDeviceName()
    {
        return $this->_mobile;
    }
    
    
    /**
     * getRobotName
     *
     * @return string 
     */
    public function getRobotName()
    {
        return $this->_robot;
    }
    
    
    /**
     * getPlatformName
     *
     * @return string 
     */
    public function getPlatformName()
    {
        return $this->_platform;
    }
    
    
    /**
     * getReferrer
     *
     * @return string 
     */
    public function getReferrer()
    {
        return (!isset($_SERVER['HTTP_REFERER']) 
                || $_SERVER['HTTP_REFERER'] == '') ? '' 
                : trim($_SERVER['HTTP_REFERER']);
    }
    
    
    /**
     * getAgentString
     *
     * @return string 
     */
    public function getAgentString()
    {
        return $this->_agent;
    }
    
    
    /**
     * getLanguages
     *
     * @return array 
     */
    public function getLanguages()
    {
        if(count($this->_languages) == 0)
		{
			$this->setLanguages();
		}

		return $this->_languages;
    }
    
    
    /**
     * getCharsets
     *
     * @return array 
     */
    public function getCharsets()
    {
        if(count($this->_charsets) == 0)
		{
			$this->setCharsets();
		}

		return $this->_charsets;
    }
    
    
    /**
     * acceptsLang
     *
     * @param string $lang
     * @return boolean 
     */
    public function acceptsLang($lang = 'en')
    {
        return (in_array(strtolower($lang), $this->_languages(), true));
    }
    
    
    /**
     * acceptsCharset
     *
     * @param string $charset
     * @return boolean 
     */
    public function acceptsCharset($charset = 'utf-8')
    {
        return (in_array(strtolower($charset), $this->_charsets(), true));
    }
    
    
    /************************************************************************
     * Protected Methods
     ***********************************************************************/
    
    /**
     * compileData
     */
    protected function compileData()
    {
        $this->setPlatform();
        $this->setRobot();
        $this->setBrowser();
        $this->setMobile();
    }
    
    
    /**
     * setPlatform
     */
    protected function setPlatform()
    {
        foreach($this->_platforms as $key => $val)
        {
            if(preg_match("/".preg_quote($key)."/i", $this->_agent))
            {
                $this->_platform = $val;
                
                return true;
            }
        }
        
		$this->_platform = 'Unknown Platform';
        //Debug::dump('$this->_platform', $this->_platform);
    }
    
    
    /**
     * setRobot
     */
    protected function setRobot()
    {
        foreach($this->_robots as $key => $val)
        {
            if(preg_match("|".preg_quote($key)."|i", $this->_agent))
            {
                $this->_isRobot = true;
                $this->_robot   = $val;
                return true;
            }
        }
    }
    
    
    /**
     * setBrowser
     */
    protected function setBrowser()
    {
        foreach($this->_browsers as $key => $val)
        {
            if( preg_match("|".preg_quote($key).".*?([0-9\.]+)|i", 
                $this->_agent, 
                $match))
            {
                $this->_isBrowser = true;
                $this->_version   = $match[1];
                $this->_browser   = $val;
                $this->setMobile();
                return true;
            }
        }
    }
    
    
    /**
     * setMobile
     */
    protected function setMobile()
    {
        foreach($this->_mobiles as $key => $val)
        {
            if(FALSE !== (strpos(strtolower($this->_agent), $key)))
            {
                $this->_isMobile = true;
                $this->_mobile   = $val;
                return true;
            }
        }
    }
    
    
    /**
     * setLanguages 
     */
    protected function setLanguages()
    {
        if((count($this->_languages) == 0) && 
            isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) && 
            $_SERVER['HTTP_ACCEPT_LANGUAGE'] != '')
		{
			$languages = preg_replace('/(;q=[0-9\.]+)/i', '', 
                        strtolower(trim($_SERVER['HTTP_ACCEPT_LANGUAGE'])));

			$this->_languages = explode(',', $languages);
		}

		if(count($this->_languages) == 0)
		{
			$this->_languages = array('Undefined');
		}
    }
    
    
    /**
     * setCharsets
     */
    protected function setCharsets()
	{
		if((count($this->_charsets) == 0) 
            && isset($_SERVER['HTTP_ACCEPT_CHARSET']) 
            && $_SERVER['HTTP_ACCEPT_CHARSET'] != '')
		{
			$charsets = preg_replace('/(;q=.+)/i', '', 
                strtolower(trim($_SERVER['HTTP_ACCEPT_CHARSET'])));

			$this->_charsets = explode(',', $charsets);
		}

		if(count($this->_charsets) == 0)
		{
			$this->_charsets = array('Undefined');
		}
	}
}