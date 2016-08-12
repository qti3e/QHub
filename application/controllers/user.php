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


use core\controller\YU_Controller;
use core\database\query;
use core\view\template;

/**
 * Class user
 * @package application\controllers
 */
class user extends YU_Controller{
	/**
	 * @param string $page
	 * @param string $param1
	 * @param string $param2
	 * @param string $param3
	 *
	 * @return string
	 */
	public function __loader($page,$param1 = '',$param2 = '',$param3 = '') {
		template::setTemplate('empty');
		return 'You are in page: '.$page;
	}

	/**
	 * @param string $param1
	 *
	 * @return string
	 */
	public function main($param1 = ''){
		template::setTemplate('users/controller');
		template::assign('page','index');
		template::assign('title','Index');
		return 'Home sweet home';
	}
}