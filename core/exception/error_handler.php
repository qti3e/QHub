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

namespace core\exception;


use core\controller\URLController;
use core\view\template;

/**
 * Class error_handler
 * @package core\exception
 */
class error_handler {
	/**
	 * Handle all of errors
	 * @param $no
	 * @param $str
	 * @param $file
	 * @param $line
	 *
	 * @return void
	 */
	public static function handler($no,$str,$file,$line){
		template::clean();
		$lines = file($file);
		template::flushData();
		template::assign('errorNo',$no);
		template::assign('errorStr',$str);
		template::assign('errorFile',$file);
		template::assign('errorLine',$line);
		template::assign('lines',$lines);
		template::assign('line',$lines[$line-1]);
		$template = new template();
		$template->display('template','core/exception/templates/');
		exit();
	}

	/**
	 * Handle Fatal errors
	 * @return void
	 */
	public static function shutDown(){
		$error  = error_get_last();
		if($error !== null){
			$no     = $error['type'];
			$str    = $error['message'];
			$file   = $error['file'];
			$line   = $error['line'];
			static::handler($no,$str,$file,$line);
		}
	}

	/**
	 * Handle some framework's error like 'Can't load config file.'
	 * @param $header
	 * @param $message
	 *
	 * @return void
	 */
	public static function DisplayError($header,$message){
		template::clean();
		template::flushData();
		template::assign('header',$header);
		template::assign('message',$message);
		$template = new template();
		$template->display('errors','core/exception/templates/');
		exit();
	}

	/**
	 * @param \Exception $exception
	 *
	 * @return void
	 */
	public static function exception($exception){
		$line       = $exception->getLine();
		$file       = $exception->getFile();
		$message    = $exception->getMessage();
		static::handler(E_CORE_ERROR,$message,$file,$line);
	}
}