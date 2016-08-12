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
 * Class cryptography
 *  Encrypt and decrypt cookies.
 * @package core\cookie
 */
class cryptography {
	/**
	 * @var string
	 */
	protected static $key       = crypto_key;
	/**
	 * @var int
	 */
	protected static $len       = 0;
	/**
	 * @var bool
	 */
	protected static $on        = false;
	/**
	 * @return string
	 */
	public static function getKey() {
		return static::$key;
	}

	/**
	 * @param $key
	 *
	 * @return void
	 */
	public static function setKey($key) {
		static::$key  = $key;
		static::$len  = strlen($key);
	}

	/**
	 * @return bool
	 */
	public static function isOn() {
		return static::$on;
	}

	/**
	 * @return void
	 */
	public static function turnOn() {
		static::$on   = true;
	}

	/**
	 * @return void
	 */
	public static function turnOff(){
		static::$on   = false;
	}

	/**
	 * @param int $len
	 *
	 * @return string
	 */
	public static function generate_key($len = 256){
		$re         = '';
		$alphabets  = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_+-=';
		$aLen       = strlen($alphabets) - 1;
		for($i = 0;$i < $len;$i++){
			$re .= $alphabets[rand(0,$aLen * 3) % $aLen];
		}
		return $re;
	}

	/**
	 * @param $n
	 *
	 * @return int
	 */
	protected static function getJ($n){
		$j  = $n % static::$len;
		if($n == 0){
			return ord(static::$key[$j])+ord(static::$key[static::$len - $j - 1]);
		}
		$p  = ($n-1) % static::$len;
		return ord(static::$key[$j])+ord(static::$key[static::$len - $j - 1])+ord(static::$key[$p])+ord(static::$key[static::$len - $p - 1]);
	}
	/**
	 * @param string $string
	 *
	 * @return string
	 */
	public static function encrypt($string){
		if(!static::$on){
			return $string;
		}
		$StringLen  = strlen($string);
		for($i = 0;$i < $StringLen;$i++){
			$j  = static::getJ($i);
			$string[$i] = chr((ord($string[$i])+$j) % 256);
		}
		return $string;
	}

	/**
	 * @param string $string
	 *
	 * @return string
	 */
	public static function decrypt($string){
		if(!static::$on){
			return $string;
		}
		$StringLen  = strlen($string);
		for($i = 0;$i < $StringLen;$i++){
			$j  = static::getJ($i);
			$string[$i] = chr((ord($string[$i]) - $j) % 256);
		}
		return $string;
	}
}