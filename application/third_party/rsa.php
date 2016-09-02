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
 * Class rsa
 * Very simple rsa decrypt class
 * @package application\third_party
 */
class rsa {
	/**
	 * @var
	 */
	private static $privateKey;

	/**
	 * @param $privateKey
	 *
	 * @return void
	 */
	public static function set_private_key($privateKey){
		static::$privateKey = openssl_pkey_get_private($privateKey);
	}

	/**
	 * @param $data
	 *
	 * @return string
	 */
	private static function to_hex($data) {
		return strtoupper(bin2hex($data));
	}

	/**
	 * @return mixed
	 */
	public static function get_public_key(){
		$details    = openssl_pkey_get_details(static::$privateKey);
		return ['n'=>self::to_hex($details['rsa']['n']),'e'=>self::to_hex($details['rsa']['e'])];
	}

	/**
	 * @param $data
	 *
	 * @return bool
	 */
	public static function decrypt($data){
		$data = pack('H*', $data);
		if (openssl_private_decrypt($data, $r, static::$privateKey)) {
			return $r;
		}
		return false;
	}
}