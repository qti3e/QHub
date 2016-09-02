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
	private static $publicKey;
	/**
	 * @var
	 */
	private static $privateKey;

	/**
	 * @param $publicKey
	 *
	 * @return void
	 */
	public static function set_public_key($publicKey){
		static::$publicKey  = $publicKey;
	}

	/**
	 * @param $privateKey
	 *
	 * @return void
	 */
	public static function set_private_key($privateKey){
		static::$privateKey = $privateKey;
	}

	/**
	 * @return mixed
	 */
	public static function get_public_key(){
		return static::$publicKey;
	}

	/**
	 * @return mixed
	 */
	public static function get_private_key(){
		return static::$privateKey;
	}

	/**
	 * @param $data
	 *
	 * @return mixed
	 */
	public static function decrypt($data){
		openssl_private_decrypt($data,$return,static::$privateKey);
		return $return;
	}
}