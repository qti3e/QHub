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

namespace core\forms;

use core\exception\youn_exception;
use core\validate\validatorInterface;

/**
 * Class data
 * @package core\forms
 */
class data {
	/**
	 * @var
	 */
	protected static $file;
	/**
	 * Save users data that sends from api system
	 * @var
	 */
	private static $data;

	/**
	 * @param                         $name
	 * @param validatorInterface|null $validator
	 *
	 * @return bool
	 */
	public static function get($name,validatorInterface $validator = null){
		if(isset($_GET[$name])){
			if($validator !== null){
				if(!$validator->is_valid($_GET[$name])){
					return false;
				}
			}
			return $_GET[$name];
		}
		return false;
	}

	/**
	 * @param                         $name
	 * @param validatorInterface|null $validator
	 *
	 * @return bool
	 */
	public static function post($name,validatorInterface $validator = null){
		if(isset($_POST[$name])){
			if($validator !== null){
				if(!$validator->is_valid($_POST[$name])){
					return false;
				}
			}
			return $_POST[$name];
		}
		return false;
	}

	/**
	 * @param $name
	 * @param $handler
	 *
	 * @return bool|int
	 * @throws formException
	 */
	public static function file($name,$handler){
		if(!isset($_FILES[$name])){
			return false;
		}
		if(!is_callable($handler)){
			throw new formException('','Second argument must be callable');
		}
		$file   = $_FILES[$name];
		$re     = 0;
		if(is_array($file['name'])){
			$keys   = array_keys($file['error']);
			$count  = count($file['error']);
			for($i  = 0;$i < $count;$i++){
			    $key= $keys[$i];
			    $val= $file['error'][$key];
			    if($val === 0){
				    $info   = [
					    'name'      => $file['name'][$key],
					    'type'      => $file['type'][$key],
					    'tmp_name'  => $file['tmp_name'][$key],
					    'error'     => $file['tmp_name'][$key],
					    'size'      => $file['size'][$key]
				    ];
				    static::$file   = $info;
				    if($handler($info)){
					    $re++;
				    }
				    static::$file   = null;
			    }
			}
		}else{
			if($file['error'] !== 0){
				static::$file   = $file;
				if($handler($file)){
					$re++;
				};
				static::$file   = null;
			}
		}
		return $re;
	}

	/**
	 * @param $file
	 *
	 * @return bool
	 * @throws formException
	 */
	public static function move_file($file){
		if(static::$file === null){
			throw new formException('','You can\'t call data::move_file out side of handler function for data::file');
		}
		return move_uploaded_file(static::$file['tmp_name'],$file);
	}

	/**
	 * @param array     $data
	 * @param callable  $function
	 *
	 * @return array
	 * @throws youn_exception
	 */
	protected static function _loop($data,$function){
		if(!is_callable($function)){
			throw new youn_exception('','Second parameter of loop function must be callable.');
		}
		$keys   = array_keys($data);
		$count  = count($data);
		for($i  = 0;$i < $count;$i++){
			$data[$keys[$i]]    = $function($keys[$i],$data[$keys[$i]]);
		}
		return $data;
	}

	/**
	 * @return array
	 */
	public static function getKeys(){
		return array_keys($_GET);
	}

	/**
	 * @param $function
	 *
	 * @return array
	 * @throws youn_exception
	 */
	public static function getLoop($function){
		return static::_loop($_GET,$function);
	}

	/**
	 * @return array
	 */
	public static function postKey(){
		return array_keys($_POST);
	}

	/**
	 * @param $function
	 *
	 * @return array
	 * @throws youn_exception
	 */
	public static function postLoop($function){
		return static::_loop($_POST,$function);
	}

	/**
	 * @param null       $name
	 *  Data field name
	 * @param bool|false $def
	 *  Default value return when data does not exists
	 *
	 * @return bool
	 */
	public static function data($name = null,$def = false){
		if($name === null){
			return static::$data;
		}
		if(isset(static::$data[$name])){
			return static::$data[$name];
		}
		return $def;
	}

	/**
	 * @param array $data
	 *
	 * @return array
	 */
	public static function setData(array $data){
		return static::$data    = $data;
	}
}