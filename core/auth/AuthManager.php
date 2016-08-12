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

namespace core\auth;

use core\cryptography\crypto;
use core\database\query;
use core\helper\variable;
use core\session\SessionManager;

/**
 * Class AuthManager
 * @package core\auth
 */
class AuthManager {
	/**
	 * @var bool
	 */
	protected static $login     = null;
	/**
	 * @var null
	 */
	protected static $username  = null;

	/**
	 * @return bool
	 */
	public static function isLogin() {
		if(static::$login === null){
			static::$login  = (SessionManager::get('youn_auth_is_login') === 'true');
			if(static::$login){
				static::$username   = SessionManager::get('youn_auth_username');
			}
		}
		return static::$login;
	}

	/**
	 * @param $username
	 *
	 * @return void
	 */
	protected static function _valid($username){
		SessionManager::set('youn_auth_is_login','true');
		SessionManager::set('youn_auth_username',$username);
		static::$username   = $username;
		static::$login      = true;
	}

	protected static function _invalid(){

	}

	/**
	 * @param $validator
	 *
	 * @return mixed
	 * @throws authException
	 */
	protected static function _getUsername($validator){
		$keys   = array_keys($validator);
		$count  = count($keys);
		for($i  = 0;$i < $count;$i++){
			if(preg_match('/.*user.*/',$keys[$i])){
				return $validator[$keys[$i]];
			}
		}
		throw new authException('invalidUsername');
	}

	/**
	 * @param $data
	 * @param $validator
	 *
	 * @return bool
	 * @throws authException
	 */
	public static function login($data,$validator){
		$_keys  = array_keys($validator);
		$_count = count($validator);
		$keys   = array_keys($data);
		$count  = count($data);
		for($i  = 0;$i < $count;$i++){
			$re = true;
			for($j  = 0;$j < $_count;$i++){
				$re = $re && ($data[$keys[$i]] == $validator[$_keys[$j]]);
			}
			if($re  === true){
				static::_valid(static::_getUsername($validator));
				return true;
			}
		}
		static::_invalid();
		return false;
	}

	/**
	 * @param $table
	 * @param $validator
	 *
	 * @return bool
	 */
	public static function dbLogin($table,$validator){
		$result = query::SELECT($table)->WHERE($validator)->execute();
		if(count($result) > 0){
			static::_valid(static::_getUsername($validator));
			return true;
		}
		return false;
	}

	/**
	 * @return void
	 */
	public static function logout(){
		SessionManager::set('youn_auth_is_login','false');
		SessionManager::remove('youn_auth_is_login');
		SessionManager::remove('youn_auth_username');
		static::$username   = null;
		static::$login      = null;
	}

	/**
	 * @return bool|string
	 */
	public static function getUsername(){
		if(self::isLogin()){
			if(static::$username === null){
				static::$username   = SessionManager::get('youn_auth_username');
			}
			return static::$username;
		}
		return false;
	}

	/**
	 * @param     $username
	 * @param int $expire
	 *
	 * @return string
	 */
	public static function createResetPasswordToken($username,$expire = 24){
		$token  = variable::str_pad(';'.$username.';'.(time() + ($expire * 60 * 60)).';',64);
		return crypto::encrypt($token);
	}

	/**
	 * @param $token
	 *
	 * @return bool
	 */
	public static function isResetPasswordTokenValid($token){
		$token  = crypto::decrypt($token);
		preg_match_all('/.*;(.+?);(.+?);.*/',$token,$matches);
		if(count($matches) === 3){
			$username   = $matches[1][0];
			$expire     = $matches[2][0];
			if($expire <= time()){
				return $username;
			}
		}
		return false;
	}

	/**
	 * @param $username
	 *
	 * @return void
	 */
	public static function valid($username){
		static::_valid($username);
	}
}