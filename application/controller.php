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

namespace application;


use application\third_party\fastEnc;
use application\third_party\rsa;
use core\auth\AuthManager;
use core\controller\MainControllerInterface;
use core\controller\URLController;
use core\helper\variable;

/**
 * Class controller
 * @package application
 */
class controller implements MainControllerInterface{
	/**
	 * @return void
	 */
	public static function index(){
		if(!isset($_POST['key']) || !isset($_POST['data'])){
			URLController::divert('errors','_403');
			return;
		}
		rsa::set_private_key(file_get_contents('rsa/rsa_2048_priv.pem'));
		$key    = explode(';',rsa::decrypt($_POST['key']));
		if(count($key) !== 2){
			URLController::divert('errors','_403');
			return;
		}
		$sign   = $key[1];
		$key    = $key[0];
		fastEnc::setKeySign($key,$sign);
		$data   = fastEnc::decrypt($_POST['data']);
		if(sha1($data) !== $sign){
			URLController::divert('errors','_403');
			return;
		}

		file_put_contents('post',file_get_contents('post')."\n".str_repeat('_',100)."\n".$_POST['key']."\n".$key."\n".$sign."\n".$data."\n".sha1($data));

	}

	/**
	 * @param $params
	 *
	 * @return void
	 */
	public static function open($params){
		$_class     = '\\application\\controllers\\'.$params[0];
		$needLogin  = null;
		if(class_exists($_class)){
			$page   = new $_class();
			$needLogin  = $page::getNeedLogin();
		}
		if($needLogin !== AuthManager::isLogin() && $needLogin !== null){
			URLController::divert('errors','_403');
		}else{
			URLController::divert($params[0],isset($params[1]) ? $params[1] : 'main',variable::substr($params,0));
		}
	}

	/**
	 * @param $class
	 * @param $page
	 * @param $params
	 *
	 * @return string
	 */
	public static function __callClass($class,$page,$params){
		return func_get_args();
	}
}