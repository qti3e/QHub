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

namespace core\cryptography;


/**
 * Class hash
 * @package core\cryptography
 */
class hash {
	/**
	 * @var string
	 */
	protected static $text      = null;
	/**
	 * @var string
	 */
	protected static $salt      = '';
	/**
	 * @var string
	 */
	protected static $sha1      = '';
	/**
	 * @return string
	 */
	public static function getText() {
		return static::$text;
	}

	/**
	 * @param $text
	 *
	 * @return hash
	 */
	public static function setText($text) {
		static::$text = $text;
		return new hash();
	}

	/**
	 * @return string
	 */
	public static function getSalt() {
		return static::$salt;
	}

	/**
	 * @param $salute
	 *
	 * @return hash
	 */
	public static function setSalt($salute) {
		static::$salt = $salute;
		static::$sha1   = sha1($salute);
		return new hash();
	}

	/**
	 * @return string
	 */
	protected static function _getText(){
		return static::$text.static::$sha1;
	}

	/**
	 * @param $algo
	 *
	 * @return bool
	 */
	public static function isSupport($algo){
		return in_array($algo,hash_algos());
	}

	/**
	 * @param $algo
	 *
	 * @return string
	 * @throws hashException
	 */
	public static function hash($algo){
		hashException::exception($algo);
		return hash($algo,static::_getText());
	}


	/**
	 * @return string
	 */
	public static function md2(){
		return hash::hash(__METHOD__);
	}

	/**
	 * @return string
	 */
	public static function md4(){
		return hash::hash(__METHOD__);
	}

	/**
	 * @return string
	 */
	public static function md5(){
		return hash::hash(__METHOD__);
	}

	/**
	 * @return string
	 */
	public static function sha1(){
		return hash::hash(__METHOD__);
	}

	/**
	 * @return string
	 */
	public static function sha224(){
		return hash::hash(__METHOD__);
	}

	/**
	 * @return string
	 */
	public static function sha256(){
		return hash::hash(__METHOD__);
	}

	/**
	 * @return string
	 */
	public static function sha384(){
		return hash::hash(__METHOD__);
	}

	/**
	 * @return string
	 */
	public static function sha512(){
		return hash::hash(__METHOD__);
	}

	/**
	 * @return string
	 */
	public static function ripemd128(){
		return hash::hash(__METHOD__);
	}

	/**
	 * @return string
	 */
	public static function ripemd160(){
		return hash::hash(__METHOD__);
	}

	/**
	 * @return string
	 */
	public static function ripemd256(){
		return hash::hash(__METHOD__);
	}

	/**
	 * @return string
	 */
	public static function ripemd320(){
		return hash::hash(__METHOD__);
	}

	/**
	 * @return string
	 */
	public static function whirlpool(){
		return hash::hash(__METHOD__);
	}

	/**
	 * @return string
	 */
	public static function tiger128_3(){
		return hash::hash(__METHOD__);
	}

	/**
	 * @return string
	 */
	public static function tiger160_3(){
		return hash::hash(__METHOD__);
	}

	/**
	 * @return string
	 */
	public static function tiger192_3(){
		return hash::hash(__METHOD__);
	}

	/**
	 * @return string
	 */
	public static function tiger128_4(){
		return hash::hash(__METHOD__);
	}

	/**
	 * @return string
	 */
	public static function tiger160_4(){
		return hash::hash(__METHOD__);
	}

	/**
	 * @return string
	 */
	public static function tiger192_4(){
		return hash::hash(__METHOD__);
	}

	/**
	 * @return string
	 */
	public static function snefru(){
		return hash::hash(__METHOD__);
	}

	/**
	 * @return string
	 */
	public static function snefru256(){
		return hash::hash(__METHOD__);
	}

	/**
	 * @return string
	 */
	public static function gost(){
		return hash::hash(__METHOD__);
	}

	/**
	 * @return string
	 */
	public static function adler32(){
		return hash::hash(__METHOD__);
	}

	/**
	 * @return string
	 */
	public static function crc32(){
		return hash::hash(__METHOD__);
	}

	/**
	 * @return string
	 */
	public static function crc32b(){
		return hash::hash(__METHOD__);
	}

	/**
	 * @return string
	 */
	public static function fnv132(){
		return hash::hash(__METHOD__);
	}

	/**
	 * @return string
	 */
	public static function fnv164(){
		return hash::hash(__METHOD__);
	}

	/**
	 * @return string
	 */
	public static function joaat(){
		return hash::hash(__METHOD__);
	}

	/**
	 * @return string
	 */
	public static function haval128_3(){
		return hash::hash(__METHOD__);
	}

	/**
	 * @return string
	 */
	public static function haval160_3(){
		return hash::hash(__METHOD__);
	}

	/**
	 * @return string
	 */
	public static function haval192_3(){
		return hash::hash(__METHOD__);
	}

	/**
	 * @return string
	 */
	public static function haval224_3(){
		return hash::hash(__METHOD__);
	}

	/**
	 * @return string
	 */
	public static function haval256_3(){
		return hash::hash(__METHOD__);
	}

	/**
	 * @return string
	 */
	public static function haval128_4(){
		return hash::hash(__METHOD__);
	}

	/**
	 * @return string
	 */
	public static function haval160_4(){
		return hash::hash(__METHOD__);
	}

	/**
	 * @return string
	 */
	public static function haval192_4(){
		return hash::hash(__METHOD__);
	}

	/**
	 * @return string
	 */
	public static function haval224_4(){
		return hash::hash(__METHOD__);
	}

	/**
	 * @return string
	 */
	public static function haval256_4(){
		return hash::hash(__METHOD__);
	}

	/**
	 * @return string
	 */
	public static function haval128_5(){
		return hash::hash(__METHOD__);
	}

	/**
	 * @return string
	 */
	public static function haval160_5(){
		return hash::hash(__METHOD__);
	}

	/**
	 * @return string
	 */
	public static function haval192_5(){
		return hash::hash(__METHOD__);
	}

	/**
	 * @return string
	 */
	public static function haval224_5(){
		return hash::hash(__METHOD__);
	}

	/**
	 * @return string
	 */
	public static function haval256_5(){
		return hash::hash(__METHOD__);
	}

	/**
	 * @return string
	 *
	 */
	public static function crypt(){
		return crypt(static::_getText());
	}

	/**
	 * @param $value1
	 * @param $value2
	 *
	 * @return bool
	 */
	public static function equal($value1,$value2){
		return hash_equals($value1,$value2);
	}
}