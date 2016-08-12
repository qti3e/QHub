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

namespace core\http;

/**
 * Class http
 *  Mange http protocol works
 * @package core\http
 */
class http {
	/**
	 * @var array
	 */
	protected static $headers   = [];

	/**
	 * @return mixed
	 */
	public static function getUserIP(){
		if(!empty($_SERVER['HTTP_CLIENT_IP'])){
			return $_SERVER['HTTP_CLIENT_IP'];
		}elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
			return $_SERVER['HTTP_X_FORWARDED_FOR'];
		}elseif(isset($_SERVER['REMOTE_ADDR'])){
			return $_SERVER['REMOTE_ADDR'];
		}
		return false;
	}

	/**
	 * @return void
	 */
	public static function sendHeaders(){
		$keys   = array_keys(static::$headers);
		$count  = count($keys);
		for($i  = 0;$i < $count;$i++){
			header($keys[$i].': '.static::$headers[$keys[$i]]);
		}
	}

	/**
	 * @param $key
	 * @param $value
	 *
	 * @return void
	 */
	public static function header($key,$value){
		static::$headers[trim($key)]    = trim($value);
	}

	/**
	 * @param string $key
	 *
	 * @return bool|string
	 */
	public static function removeHeader($key){
		$key    = trim($key);
		if(isset(static::$headers[$key])){
			$re = static::$headers[$key];
			unset(static::$headers[$key]);
			return $re;
		}
		return false;
	}

	/**
	 * @param $key
	 *
	 * @return bool
	 */
	public static function issetHeader($key){
		return isset(static::$headers[trim($key)]);
	}
}