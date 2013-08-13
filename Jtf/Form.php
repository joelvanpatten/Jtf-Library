<?php
/**
 * @category    Jtf
 *
 * @package     Jtf_Form
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
class Jtf_Form
{
    /**
     * dropdown
     * 
     * @param string $name
     * @param array $options
     * @param string $selected
     * @param string $params
     */
    public static function dropdown($name, $options, $defaultOpt = '', $selected = '', $params = '')
    {
        if($params != '') { $params = ' ' . $params; }
        
        $form = '<select name="' . $name . '" ' . $params . ">\n";
        
        if(strlen($defaultOpt) > 0)
        {
            $form .= '<option>' . $defaultOpt . "</option>\n";
        }
        
        foreach($options as $key => $val)
		{
			$key    = strval($key);
            $val    = strval($val);
            $select = '';
            
            if($key == $selected)
            {
                $select = ' selected="selected"';
            }
            
            $form .= '<option value="' . $key . '"'. $select . '>';
            $form .= $val;
            $form .= "</option>\n";
		}
        
        $form .= "</select>\n";
        
        return $form;
    }
}