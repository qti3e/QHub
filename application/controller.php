<?php
/**
 * This file is api router and the only job of this file is to divert urls to right classes
 *
 * @license GPL
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 3
 * @author  QTIƎE <Qti3eQti3e@Gmail.com>
 */

namespace application;


use application\third_party\db;
use application\third_party\fastEnc;
use application\third_party\rsa;
use core\controller\MainControllerInterface;
use core\controller\URLController;

/**
 * Main router class
 * @package application
 */
class controller implements MainControllerInterface{
	/**
	 * Url routing map
	 * @var array
	 *  [
	 *      'Page Name(lowercase)'=>['class','function',('need token' | def:true)],
	 *      ...
	 *  ]
	 */
	public static $map  = [
//		'Page Name(lowercase)'=>['class','function',('need token' | def:true)]
		//User controllers
		'login'                 => ['user'      ,'login'        ,false],
		'repositories'          => ['user'      ,'repositories' ,true],
		'profile'               => ['user'      ,'profile'      ,true],
		'users'                 => ['user'      ,'users'        ,true],
		//Repository controller
		'repository/counts'     => ['repository','getCounts'    ,true],
		'repository/commits'    => ['repository','getCommits'   ,true],
		'repository/create'     => ['repository','create'       ,true],
		'repository/photo'      => ['repository','setPhoto'     ,true],
		//Photo uploading urls
		'photo/start'           => ['photo'     ,'start'        ,true],
		'photo/upload'          => ['photo'     ,'upload'       ,true]
	];

	/**
	 * Main router function
	 * @todo write a better code for this section because it too long for a router function
	 * @return void
	 */
	public static function index(){
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
		file_put_contents('debug',$data);
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
			URLController::divert($map[0],$map[1],[$data,$userId]);
		}else{
			URLController::divert('errors','_404');
			return;
		}
	}

	/**
	 * Give a 403 error to users because they don't have access to getting this page
	 * @param $params
	 *
	 * @return void
	 */
	public static function open($params){
		URLController::$enc = false;
		URLController::divert('errors','_403');
	}

	/**
	 * Nothing happens in this function yet
	 *
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