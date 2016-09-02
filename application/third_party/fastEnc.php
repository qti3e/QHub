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

namespace application\third_party;

/**
 * Class fastEnc
 * @package application\third_party
 */
class fastEnc {
	/**
	 * @var string
	 */
	private static $key;
	/**
	 * @var int
	 */
	private static $len;

	/**
	 * @param int $n
	 *
	 * @return int
	 */
	private static function getJ($n){
		$j  = $n % static::$len;
		if($n == 0){
			return ord(static::$key[$j])+ord(static::$key[static::$len - $j - 1]);
		}
		$p  = ($n - 1) % static::$len;
		return  ord(static::$key[$j])+ord(static::$key[static::$len - $j - 1])
			+   ord(static::$key[$p])+ord(static::$key[static::$len - $p - 1]);
	}

	/**
	 * @param $msg
	 * @param $key
	 *
	 * @return string
	 */
	public static function encrypt($msg,$key){
		static::$key    = $key;
		static::$len    = strlen($key);
		$len    = strlen($msg)-1;
		for(;$len > -1;$len--){
			$j  = self::getJ($len);
			$msg[$len]  = chr((ord($msg[$len])+$j) % 256);
		}
		return base64_encode($msg);
	}

	/**
	 * @param $msg
	 * @param $key
	 *
	 * @return string
	 */
	public static function decrypt($msg,$key){
		static::$key    = $key;
		static::$len    = strlen($key);
		$msg    = base64_decode($msg);
		$len    = strlen($msg)-1;
		for(;$len > -1;$len--){
			$j  = self::getJ($len);
			$msg[$len]  = chr((ord($msg[$len])-$j) % 256);
		}
		return $msg;
	}
}