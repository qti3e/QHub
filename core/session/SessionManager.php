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

namespace core\session;


use core\cookie\CookieManager;
use core\http\http;
use core\database\KeyValueStore;

/**
 * Class SessionManager
 * @package core\session
 */
class SessionManager extends KeyValueStore{
	public function __construct() {
		$sessionId  = CookieManager::get('youn_session_id');
		if($sessionId === false){
			$sessionId  = sha1(time().http::getUserIP().uniqid('youn_session_id'));
			CookieManager::set('youn_session_id',$sessionId,CookieManager::createNeverDieTime());
		}
		session_id($sessionId);
		session_start();
	}

	/**
	 * @return mixed
	 */
	public static function getStore(){
		return $_SESSION;
	}

	/**
	 * @param $store
	 *
	 * @return mixed
	 */
	public static function setStore($store) {
		$re = $_SESSION;
		$_SESSION   = $store;
		return $re;
	}

	/**
	 * @param $name
	 * @param $value
	 *
	 * @return mixed
	 */
	protected static function _set($name, $value) {
		return $_SESSION[$name] = $value;
	}

	/**
	 * @param $name
	 *
	 * @return void
	 */
	protected static function _remove($name){
		unset($_SESSION[$name]);
	}
}