<?php
/**
 * Array Helpers
 * 
 * This class provides various array helper methods and utlities.
 * 
 * @category    Jtf
 *
 * @package     Jtf_Array
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
class Jtf_Array
{
    /**
     * getElement
     *
     * This method is used to determine if an array element it set
     * and not empty (e.g. containing the empty string). If the array
     * element is set, it is returned. Otherwise, the default value
     * is returned. The default default value is false.
     * 
     *
     * @param string $key     - The $key parameter is the array key 
     *                          to search for.
     * 
     * @param array  $array   - The $array parameter is the array to 
     *                          search within.
     * 
     * @param mixed  $default - The $default parameter is the value that 
     *                          is returned in the event the index specified 
     *                          by $key is not found.
     * 
     * @return mixed 	
     * 
     * @throws InvalidArgumentException
     */
    public static function getElement($key, $array, $default = false)
	{
        if($key === null)
        {
            $msg = 'The key cannot be null.';
            throw new InvalidArgumentException($msg);
        }
        
		if(!isset($array[$key]) || $array[$key] == '')
		{
			return $default;
		}

		return $array[$key];
	}
   
    
    /**
     * getElements
     *
     * Given an array of keys, this method will return an array
     * containing only the elements within the keys array. If an
     * element does not exist for a given key, the default value
     * is assigned to that element within the returned array.
     *
     * @param array $keys    - The $keys parameter is an array of keys
     *                         to search for within the provided $array.
     * 
     * @param array $array   - The $array parameter is the array to
     *                         search within.
     * 
     * @param mixed $default - The $default parameter is the value that 
     *                         is placed within the returned array in 
     *                         the event the index specified by key is 
     *                         not found.
     * 
     * @return mixed 
     * 
     * @throws InvalidArgumentException 
     */
    public static function getElements($keys, $array, $default = false)
	{
		$result = array();
		
		if(is_array($keys) == false)
		{
			$msg = 'The provided keys parameter is not an array.';
            throw new InvalidArgumentException($msg);
		}
		
		foreach($keys as $val)
		{
			if(isset($array[$val]))
			{
				$result[$val] = $array[$val];
			}
			else
			{
				$result[$val] = $default;
			}
		}

		return $result;
	}
    
    
    /**
     * getRandomElement 
     * 
     * This method returns a random element within an array.
     * 
     * @param type $array - This parameter is the input array.
     * 
     * @return mixed 
     */
    public static function getRandomElement($array)
	{
		if(!is_array($array))
		{
			$msg = 'The provided array parameter is not an array.';
            throw new InvalidArgumentException($msg);
		}

		return $array[array_rand($array)];
	}
}