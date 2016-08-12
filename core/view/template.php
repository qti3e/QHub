<?php
/*****************************************************************************
 *         In the name of God the Most Beneficent the Most Merciful          *
 *___________________________________________________________________________*
 *   This program is free software: you can redistribute it and/or modify    *
 *   it under the terms of the GNU General Public License as published by    *
 *   the Free Software Foundation, either version 3 of the License, or       *
 *   (at your option) any later version.                                     *
 *___________________________________________________________________________*
 *   This program is distributed in the hope that it will be useful,         *
 *   but WITHOUT ANY WARRANTY; without even the implied warranty of          *
 *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the           *
 *   GNU General Public License for more details.                            *
 *___________________________________________________________________________*
 *   You should have received a copy of the GNU General Public License       *
 *   along with this program.  If not, see <http://www.gnu.org/licenses/>.   *
 *___________________________________________________________________________*
 *                             Created by  Qti3e                             *
 *        <http://Qti3e.Github.io>    LO-VE    <Qti3eQti3e@Gmail.com>        *
 *****************************************************************************/

namespace core\view;

/**
 * Class template
 * @package core\template
 */
class template {
	/**
	 * Save and storage template's data
	 * @var array
	 */
	private static $data = [];
	/**
	 * @var array
	 */
	private static $template    = [];
	/**
	 * @var
	 */
	protected $return;
	/**
	 * Set a variable with name of $key
	 * @param $key
	 *  Name of variable
	 * @param $value
	 *  Value of variable
	 *
	 * @return mixed
	 *  Return $value
	 */
	public static function assign($key,$value){
		return static::$data[$key]   = $value;
	}

	/**
	 * Set variable with calling a function!
	 *  Look at this example
	 *      template::assign('foo','bar')
	 *      template::foo('bar')
	 * those two codes are equal and they do same.
	 * @param $name
	 *  Name of variable
	 * @param $arguments
	 *  Value of variable
	 * @return void
	 */
	public static function __callStatic($name, $arguments) {
		static::$data[$name]  = $arguments[0];
	}

	/**
	 * Unset a variable if exists
	 * @param $key
	 *  Name of variable
	 * @return mixed
	 *  Return false if key does not exist and return
	 *  old value of variable if it exists.
	 */
	public static function remove($key){
		$re = false;
		if(isset(static::$data[$key])){
			$re = static::$data[$key];
			unset(static::$data[$key]);
		}
		return $re;
	}

	/**
	 * Same as isset function but it works on static::$data
	 * @param $key
	 *  Name of variable
	 * @return bool
	 *  Return true if variable exists
	 */
	public static function isDefined($key){
		return isset(static::$data[$key]);
	}

	/**
	 * Clear and reset data with array input
	 * @param array $data
	 *  Value of ner data.
	 *  Keys ate name of variables and values are values :)
	 * @return array
	 *  Return the old value of data
	 */
	public static function setData($data) {
		$re = static::$data;
		static::$data = $data + $re;
		return $re;
	}

	/**
	 * @param $data
	 *
	 * @return void
	 */
	public function setReturn($data){
		$this->return = $data;
	}

	/**
	 * @return mixed
	 */
	public function getReturn() {
		return $this->return;
	}

	/**
	 * @return array
	 */
	public static function getTemplate() {
		return static::$template;
	}
	/**
	 *  Return all of data as array
	 * @return array
	 */
	public static function getData() {
		return static::$data;
	}

	/**
	 * Display template to the output
	 * @param $fileName
	 *  It can be a array to and it's path of files you want to load as template
	 * @param string $includePath
	 * @return void
	 */
	public function display($fileName = null,$includePath = 'application/templates/'){
		if($fileName == null){
			$fileName = static::$template;
			if(empty(static::$template)){
				return;
			}
		}
		set_include_path($includePath);
		$__keys   = array_keys(static::$data);
		$__count  = count(static::$data);
		for($__i  = 0;$__i < $__count;$__i++){
			$__key= $__keys[$__i];
			$$__key = static::$data[$__key];
		}
		unset($__keys,$__key,$__i,$__count);
		if(is_string($fileName)){
			if(file_exists($includePath.$fileName.'.php')){
				include $includePath.$fileName.'.php';
			}else{
				//error
			}
		}elseif(is_array($fileName)){
			$__keys = array_keys($fileName);
			$__count= count($fileName);
			for($__i = 0;$__i < $__count;$__i++){
				if(file_exists($includePath.$fileName[$__keys[$__i]].'.php')){
					include $includePath.$fileName[$__keys[$__i]].'.php';
				}else{
					//error
				}
			}
		}
	}

	/**
	 * Remove all of data
	 * @return array
	 *  Return last data's value
	 *
	 */
	public static function flushData(){
		$re = static::$data;
		static::$data = [];
		return $re;
	}

	/**
	 * Set templates name that you want to display
	 * @param $template
	 *
	 * @return void
	 */
	public static function setTemplate($template){
		static::$template[] = $template;
	}

	/**
	 * @return void
	 */
	public static function clean(){
		if (ob_get_contents()) ob_end_clean();
	}
}