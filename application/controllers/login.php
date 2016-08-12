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

namespace application\controllers;


use application\controller;
use core\auth\AuthManager;
use core\controller\URLController;
use core\controller\YU_Controller;
use core\forms\data;
use core\validate\validators\username;
use core\view\template;

/**
 * Class login
 * @package application\controllers
 */
class login extends YU_Controller{
	/**
	 * @param string $page
	 * @param string $param1
	 *
	 * @return void
	 */
	public function __loader($page, $param1 = '') {
		parent::__loader($page, $param1);
	}

	/**
	 * @return array
	 */
	public function main(){
		template::setTemplate('login');
		return [];
	}

	/**
	 * @return array
	 */
	public function login(){
		template::setTemplate('json');
		if(($username = data::post('username',new username())) === false){
			return ['status'=>100];
		}
		if(($password = data::post('password')) === false){
			return ['status'=>100];
		}
		$username   = strtolower($username);
		if(URLController::$redis->hGet('users_'.$username,'password') == sha1($password)){
			AuthManager::valid($username);
			return ['status'=>200];
		}else{
			return ['status'=>100];
		}
	}
}