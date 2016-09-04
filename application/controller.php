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


use application\third_party\db;
use application\third_party\fastEnc;
use application\third_party\rsa;
use core\controller\MainControllerInterface;
use core\controller\URLController;

/**
 * Class controller
 * @package application
 */
class controller implements MainControllerInterface{
	public static $map  = [
//		'Page Name(lowercase)'=>['class','function',('need token' | def:true)]
		'login'                 => ['user'      ,'login'        ,false],
		'repositories'          => ['user'      ,'repositories' ,true],
		'profile'               => ['user'      ,'profile'      ,true],
		'users'                 => ['user'      ,'users'        ,true],
		'repository/counts'     => ['repository','getCounts'    ,true],
		'repository/commits'    => ['repository','getCommits'   ,true],
	];
	/**
	 * @return void
	 */
	public static function index(){
		//todo: write a better code for this section because it too long for a router function
		if(!isset($_POST['key']) || !isset($_POST['data'])){
			URLController::$enc     = false;
			URLController::divert('errors','badRequest');
			return;

		}
		rsa::set_private_key(file_get_contents('rsa/rsa_2048_priv.pem'));
		$key    = explode(';',rsa::decrypt($_POST['key']));
		if(count($key) !== 2){
			URLController::$enc = false;
			URLController::divert('errors','badKey');
			return;
		}
		$sign   = $key[1];
		$key    = $key[0];
		fastEnc::setKeySign($key,$sign);
		$data   = fastEnc::decrypt($_POST['data']);
		if(sha1($data) !== $sign){
			URLController::$enc = false;
			URLController::divert('errors','wrongSign');
			return;
		}
		URLController::$enc = true;
		$data   = json_decode($data,true);
		if(!isset($data['page']) || !isset($data['data'])){
			URLController::divert('errors','badRequest');
			return;
		}
		$page   = strtolower($data['page']);
		$data   = $data['data'];
		if(isset(static::$map[$page])){
			$map        = static::$map[$page];
			$needToken  = isset($map[2]) ? $map[2] : true;
			if($needToken === true && !isset($data['token'])){
				URLController::divert('errors','needToken');
				return;
			}
			$userId = '';
			if($needToken === true){
				$userId = db::getToken($data['token']);
				if($userId === false){
					//It means token is invalid
					URLController::divert('errors','invalidToken');
					return;
				}
			}
			URLController::divert($map[0],'\\application\\controllers\\'.$map[1],[$data,$userId]);
		}else{
			URLController::divert('errors','_404');
			return;
		}
	}

	/**
	 * @param $params
	 *
	 * @return void
	 */
	public static function open($params){
		URLController::$enc = false;
		URLController::divert('errors','_403');
	}

	/**
	 * @param $class
	 * @param $page
	 * @param $params
	 *
	 * @return string
	 */
	public static function __callClass($class,$page,$params){
		return [];
	}
}