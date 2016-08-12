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

namespace core\token;

use core\session\SessionManager;

/**
 * Class token
 * @package core\token
 */
class token {
	/**
	 * @param $pageName
	 *
	 * @return string
	 */
	public static function create($pageName){
		$token  = sha1(uniqid('token_').$pageName);
		SessionManager::set('youn_token_'.$token,strtolower(trim($pageName)));
		return $token;
	}

	/**
	 * @param $token
	 * @param $pageName
	 *
	 * @return bool
	 */
	public static function isValid($token,$pageName){
		return (SessionManager::get('youn_token_'.$token) === strtolower(trim($pageName)));
	}

	/**
	 * @param $token
	 *
	 * @return void
	 */
	public static function remove($token){
		SessionManager::remove($token);
	}

	/**
	 * @return void
	 */
	public static function clear(){
		SessionManager::removePattern('/^youn_token_.+$/');
	}
}