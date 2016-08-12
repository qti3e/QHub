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

namespace core\log;

/**
 * Class writer
 * @package core\log
 */
class writer {
	/**
	 * @var string
	 */
	protected static $log = 'Youn log:';

	/**
	 * @param $message
	 *
	 * @return void
	 */
	public static function log($message){
		static::$log    .= "\n".date('d/m/y H:i:s')."\t$message";
	}

	/**
	 * @return void
	 */
	public static function clear(){
		static::$log    = 'Youn log:';
	}

	/**
	 * @return string
	 */
	public static function get(){
		return static::$log;
	}

	/**
	 * @param null $file
	 *
	 * @return bool|int
	 */
	public static function writeToFile($file = null){
		if($file === null){
			$file   = 'youn_log.log';
		}
		$before = '';
		if(file_exists($file)){
			$before = file_get_contents($file)."\n_____________________________\n";
		}
		return file_put_contents($before.$file,static::$log);
	}
}