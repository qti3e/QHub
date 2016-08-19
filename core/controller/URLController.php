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


use application\controller;
use application\third_party\db;
use core\console\CommandController;
use core\database\query;
use core\exception\error_handler;
use core\http\http;
use core\redis\Credis_Client;
use core\session\SessionManager;
use core\view\template;

/**
 * Class URLController
 * @package core\controller
 */
class URLController{
	/**
	 * @var bool
	 */
	private $configLoaded   = false;
	/**
	 * @var bool
	 */
	private static $json    = false;
	/**
	 * @var null
	 */
	private static $include_path    = null;

	/**
	 * @param $class
	 *
	 * @return void
	 */
	public function autoLoad($class){
		$file   = str_replace('\\','/',static::$include_path.$class).'.php';
		if(file_exists($file)){
			include_once($file);
		}
	}

	/**
	 * controller constructor.
	 */
	public function __construct() {
		//Display all of error
		error_reporting(E_ALL);
		//Set include path to the script's root directory
		set_include_path(__DIR__.'/../../');
		static::$include_path   = get_include_path();
		//Autoload is way to auto include files when a class called
		spl_autoload_register([$this,'autoLoad']);
		//Handle all of errors with our own error handler
		set_error_handler('core\\exception\\error_handler::handler');
		set_exception_handler('core\exception\error_handler::exception');
		register_shutdown_function(['core\exception\error_handler','shutDown']);
		//Start an output buffering, see __destruct() for more detail.
		ob_start();
	}

	/**
	 * @param $configFile
	 *
	 * @return void
	 */
	public function config($configFile){
		if(file_exists($configFile)){
			$this->configLoaded = true;
			include $configFile;
			return;
		}
		error_handler::DisplayError('Can\'t load config file.','Can\'t find "'.$configFile.'" <h3>How to fix it?</h3>Rename <b>yu_config_sample.php</b> to <b>yu_config.php</b> and put our own values in their right place.');
	}

	/**
	 * @param string     $params
	 * @param bool|false $forceWeb
	 *
	 * @return void
	 */
	public function run($params = '',$forceWeb = false){
		if(php_sapi_name() == 'cli' && !$forceWeb){
			//Disable output buffering
			ob_end_clean();
			new CommandController();
		}else{
			template::flushData();
			static::loader();
			if($this->configLoaded){
				//Read file url and run the specific page
				if(empty($params)){
					controller::index();
				}else{
					if(preg_match('/^[a-zA-Z0-9\/]*$/',$params)){
						$params = explode('/',$params);
						controller::open($params);
					}else{
						error_handler::DisplayError('Illegal Characters','Your request has some illegal characters');
					}
				}
			}else{
				//throw an error that says "Internal server error: you should set config file first"
				error_handler::DisplayError('Load config file','You should load config file.');
			}
		}
	}

	public function __destruct() {
		//Display all of output at the end, so we can send new header to the client in all of running time
		http::sendHeaders();
	}

	/**
	 * @param $class
	 * @param $function
	 * @param array $param
	 *
	 * @return void
	 */
	public static function divert($class,$function,array $param = []){
		$_class = '\\application\\controllers\\'.$class;
		if(class_exists($_class)){
			$page = new $_class($function,$param);
			if(method_exists($page,$function)){
				$re = call_user_func_array([$page,$function],$param);
			}else{
				$re = call_user_func_array([$page,'__loader'],['page'=>$function]+$param);
			}
		}else{
			$re = controller::__callClass($class,$function,$param);
		}
		if(static::$json){
			if(is_array($re)){
				print(json_encode($re));
			}else{
				print(json_encode($re));
			}
		}else{
			$template = new template();
			if(is_array($re)){
				template::setData($re);
			}
			$template->setReturn($re);
			$template->display();
		}
	}

	/**
	 * @param $value
	 *
	 * @return void
	 */
	public function setReturnJSON($value){
		static::$json = $value;
	}

	/**
	 * @return void
	 */
	protected static function loader(){
		//Load database
		db::$redis  = new Credis_Client(db_host,db_port,null,'',db_name,db_pass);
		new SessionManager();
	}
}