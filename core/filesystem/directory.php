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

namespace core\filesystem;

/**
 * Class directory
 * @package core\filesystem
 */
class directory {
	/**
	 * @var \Exception
	 */
	protected static $error;

	/**
	 * @return mixed
	 */
	public static function getLastError(){
		return static::$error;
	}

	/**
	 * @param $dir
	 *
	 * @return bool
	 */
	public static function exists($dir){
		return (file_exists($dir) && is_dir($dir));
	}

	/**
	 * @param $dir
	 * @param $mode
	 *
	 * @return bool
	 */
	public static function mk($dir,$mode = '0777'){
		return mkdir($dir,$mode);
	}

	/**
	 * @param $dir
	 *
	 * @return bool
	 */
	public static function rm($dir){
		return rmdir($dir);
	}

	/**
	 * @param $dir
	 *
	 * @return bool
	 */
	public static function clear($dir){
		$files  = glob($dir.'/*');
		$keys   = array_keys($files);
		$count  = count($files);
		for($i  = 0;$i < $count;$i++){
		    $file   = $files[$keys[$i]];
			if(is_file($file) || is_link($file)){
				if(!unlink($file)){
					return false;
				};
			}else{
				if(!static::clear($file)){
					return false;
				};
				if(!rmdir($file)){
					return false;
				};
			}
		}
		return true;
	}

	/**
	 * @param $dir
	 *
	 * @return bool
	 */
	public static function clearDirs($dir){
		$files  = glob($dir.'/*');
		$keys   = array_keys($files);
		$count  = count($files);
		for($i  = 0;$i < $count;$i++){
			$dir= $files[$keys[$i]];
			if(is_dir($dir)){
				if(!static::clear($dir)){
					return false;
				};
				if(!rmdir($dir)){
					return false;
				};
			}
		}
		return true;
	}

	/**
	 * @param $dir
	 *
	 * @return bool
	 */
	public static function clearFiles($dir){
		$files  = glob($dir.'/*');
		$keys   = array_keys($files);
		$count  = count($files);
		for($i  = 0;$i < $count;$i++){
			$file   = $files[$keys[$i]];
			if(is_file($file) || is_link($file)){
				if(!unlink($dir)){
					return false;
				};
			}
		}
		return true;
	}

	/**
	 * @param $dir
	 *
	 * @return bool|array
	 */
	public static function getFilesList($dir){
		if(($list = static::getContentList($dir)) === false){
			return false;
		}
		return $list['files'];
	}

	/**
	 * @param $dir
	 *
	 * @return bool|array
	 */
	public static function getDirsList($dir){
		if(($list = static::getContentList($dir)) === false){
			return false;
		}
		return $list['dirs'];
	}

	/**
	 * @param $dir
	 * @return bool|array
	 */
	public static function getContentList($dir) {
		try{
			$dirs   = [];
			$files  = [];
			$d  = dir($dir);
			while(false !== ($entry = $d->read())){
				if(is_dir($entry)){
					$dirs[]     = $entry;
				}else{
					$files[]    = $entry;
				}
			}
			sort($dirs);
			sort($files);
			$d->close();
			return [
				'dirs'  => $dirs,
				'files' => $files
			];
		}catch (\Exception $e){
			static::$error  = $e;
			return false;
		}
	}

	/**
	 * @param $dir
	 * @return bool
	 */
	public static function ch($dir){
		return chdir($dir);
	}

//TODO:
//	public static function copy($dir,$path){}
//	public static function cut($dir,$path){}
//	public static function map($directory,$depth = null){}
}