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
use core\view\template;

/**
 * Class errors
 * @package application\controllers
 */
class errors extends YU_Controller{
	/**
	 * @var null
	 */
	public static $needLogin    = null;

	/**
	 * @param $code
	 * @param $message
	 *
	 * @return array
	 */
	private function httpError($code,$message){
		http_response_code($code);
		template::setTemplate('error');
		return ['code'=>$code,'status'=>'err','message'=>$message,'data' => []];
	}

	/**
	 * @return array
	 */
	public function _403(){
		return $this->httpError(403,'Access Forbidden.');
	}

	/**
	 * @return array
	 */
	public function _404(){
		return $this->httpError(404,'Not found.');
	}

	/**
	 * @return array
	 */
	public function badRequest(){
		return $this->httpError(403,'The request must contains key and data post fields.');
	}

	/**
	 * @return array
	 */
	public function badKey(){
		return $this->httpError(403,'The key is not in the correct format, checkout you are using a right RSA public key.');
	}

	/**
	 * @return array
	 */
	public function wrongSign(){
		return $this->httpError(403,'The digital signature is wrong.');
	}

	/**
	 * @return array
	 */
	public function invalidToken(){
		return $this->httpError(403,'The user token is invalid.');
	}

	/**
	 * @return array
	 */
	public function needToken(){
		return $this->httpError(403,'This page requires user token id.');
	}
}