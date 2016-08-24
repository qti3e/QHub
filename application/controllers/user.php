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


use application\third_party\db;
use core\auth\AuthManager;
use core\controller\YU_Controller;
use core\database\query;
use core\forms\data;
use core\http\http;
use core\view\template;

/**
 * Class user
 * @package application\controllers
 */
class user extends YU_Controller{
	/**
	 * @param string $param1
	 *
	 * @return string
	 */
	public function main($param1 = ''){
		template::setTemplate('users/controller');
		template::assign('page','index');
		template::assign('title','Index');

		$user           = db::getUserById(AuthManager::getUsername());
		$repositories   = db::getRepositoriesByUser(AuthManager::getUsername());
		$todo           = db::getTodoListByUserId(AuthManager::getUsername());
		return [
			'fname'         =>$user['fname'],
			'lanme'         =>$user['lname'],
			'repositories'  =>$repositories,
			'todo'          =>$todo
		];
	}

	public function logout(){
		AuthManager::logout();
		http::header('location','?login');
	}

	public function new_todo(){
		if(($todo = data::post('text')) === false || !AuthManager::isLogin() || empty($todo)){
			return false;
		}
		$re = db::addTodoByUserId(AuthManager::getUsername(),$todo);
		if($re === 1){
			return $todo;
		}
		return false;
	}
}