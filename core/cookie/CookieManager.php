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

namespace core\cookie;

/**
 * Class CookieManager
 * Session manager
 * @package core\cookie
 */
class CookieManager{
	/**
	 * @var null
	 */
	protected static $path      = null;
	/**
	 * @var null
	 */
	protected static $domain    = null;
	/**
	 * @var null
	 */
	protected static $secure    = null;
	/**
	 * @var null
	 */
	protected static $httponly  = null;
	/**
	 * @var null
	 */
	protected static $expire    = null;

	/**
	 * @param      $name
	 * @param      $value
	 * @param null $expire
	 * @param null $path
	 * @param null $domain
	 * @param null $secure
	 * @param null $httponly
	 *
	 * @return bool
	 */
	public static function set($name,$value,$expire = null,$path = null,$domain = null,$secure = null,$httponly = null){
		$name   = cryptography::encrypt($name);
		$value  = cryptography::encrypt($value);
		if($expire === null){
			if(static::$expire === null){
				//Set default value to one month
				static::$expire   = time() + (30 * 24 * 60 * 60);
			}
			$expire = static::$expire;
		}
		if($path    === null){
			$path   = static::$path;
		}
		if($domain  === null){
			$domain = static::$domain;
		}
		if($secure  === null){
			$secure = static::$secure;
		}
		if($httponly    === null){
			$httponly   = static::$httponly;
		}
		return setcookie($name,$value,$expire,$path,$domain,$secure,$httponly);
	}

	/**
	 * @param $name
	 *
	 * @return bool
	 */
	public static function get($name){
		$name   = cryptography::encrypt($name);
		if(isset($_COOKIE[$name])){
			return cryptography::decrypt($_COOKIE[$name]);
		}
		return false;
	}

	/**
	 * @return null
	 */
	public static function neverDie(){
		//Set cookie for 20 years!, so it'll never die
		return static::setExpire(time() + (20 * 365 * 24 * 60 * 60));
	}

	/**
	 * Return timestamp for 20 years later.
	 * @return int
	 */
	public static function createNeverDieTime(){
		return time() + (20 * 365 * 24 * 60 * 60);
	}

	/**
	 * @param      $name
	 * @param      $value
	 * @param null $expire
	 * @param null $path
	 * @param null $domain
	 * @param null $secure
	 * @param null $httponly
	 *
	 * @return bool
	 */
	public static function SetIfNotExists($name,$value,$expire = null,$path = null,$domain = null,$secure = null,$httponly = null){
		if(static::isDefined($name)){
			return false;
		}
		return static::set($name,$value,$expire,$path,$domain,$secure,$httponly);
	}

	/**
	 * @param $name
	 *
	 * @return bool
	 */
	public static function isDefined($name){
		$name   = cryptography::encrypt($name);
		return isset($_COOKIE[$name]);
	}

	/**
	 * @return null
	 */
	public static function getDomain() {
		return static::$domain;
	}

	/**
	 * @return null
	 */
	public static function getExpire() {
		return static::$expire;
	}

	/**
	 * @return null
	 */
	public static function getHttponly() {
		return static::$httponly;
	}

	/**
	 * @return null
	 */
	public static function getPath() {
		return static::$path;
	}

	/**
	 * @return null
	 */
	public static function getSecure() {
		return static::$secure;
	}

	/**
	 * @param $domain
	 *
	 * @return null
	 */
	public static function setDomain($domain) {
		$re = static::$domain;
		static::$domain = $domain;
		return $re;
	}

	/**
	 * @param $expire
	 *
	 * @return null
	 */
	public static function setExpire($expire) {
		$re = static::$expire;
		static::$expire = $expire;
		return $re;
	}

	/**
	 * @param $httponly
	 *
	 * @return null
	 */
	public static function setHttponly($httponly) {
		$re = static::$httponly;
		static::$httponly = $httponly;
		return $re;
	}

	/**
	 * @param $path
	 *
	 * @return null
	 */
	public static function setPath($path) {
		$re = static::$path;
		static::$path = $path;
		return $re;
	}

	/**
	 * @param $secure
	 *
	 * @return mixed
	 */
	public static function setSecure($secure) {
		$re = $secure;
		static::$secure = $secure;
		return $re;
	}
}