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

namespace core\controller;

use application\controllers\errors;

/**
 * Class YU_Controller
 * @package core\controller
 */
abstract class YU_Controller {
	/**
	 * @var bool
	 */
	public static $needLogin    = true;

	/**
	 * @param string $page
	 * @param string $param1
	 *
	 * @return array
	 */
	public function __loader($page,$param1 = ''){
		return $this->__show404();
	}

	/**
	 * @return array
	 */
	protected function __show404(){
		$error  = new errors();
		return $error->_404();
	}

	/**
	 * @return bool
	 */
	public static function getNeedLogin(){
		return static::$needLogin;
	}
}