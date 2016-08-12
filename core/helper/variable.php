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

namespace core\helper;

/**
 * Class variable
 * @package core\helper
 */
class variable {
	/**
	 * @param     $input
	 * @param     $start
	 * @param int $len
	 *
	 * @return array|bool|string
	 */
	public static function substr($input,$start,$len = 0){
		if(is_string($input)){
			return substr($input,$start,$len);
		}elseif(is_array($input)){
			if($len == 0){
				return [];
			}
			$count  = count($input);
			if($start < 0){
				$start = $start + $count;
			}
			if($len < 0){
				$end = $count + $len;
			}else{
				$end    = $start + $len;
			}
			if($end > $count){
				$end = $count;
			}
			if($start >= $count){
				return [];
			}
			$ret    = [];
			$keys   = array_keys($input);
			for($i  = $start;$i < $end;$i++){
				$ret[$keys[$i]] = $input[$keys[$i]];
			}
			return $ret;
		}
		return false;
	}

	/**
	 * @param int $len
	 *
	 * @return string
	 */
	public static function randomString($len = 32){
		$re         = '';
		$alphabets  = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_+-=';
		$aLen       = strlen($alphabets) - 1;
		for($i = 0;$i < $len;$i++){
			$re .= $alphabets[rand(0,$aLen)];
		}
		return $re;
	}

	/**
	 * @param $input
	 * @param $pad_length
	 * @param $pad_type
	 *
	 * @return string
	 */
	public static function str_pad($input,$pad_length,$pad_type = null){
		$len            = strlen($input);
		if($pad_type === null){
			$pad_length = $pad_length - $len;
			$l          = rand() % ($pad_length - 20);
			return static::randomString($l).$input.static::randomString($pad_length - $l);
		}
		$rand           = ($pad_length - $len) / 2;
		$padString0     = static::randomString($rand);
		$padString1     = static::randomString($rand);
		if($pad_type === STR_PAD_LEFT){
			return $padString0.$padString1.$input;
		}
		if($pad_type === STR_PAD_RIGHT){
			return $input.$padString0.$padString1;
		}
		return $padString0.$input.$padString1;
	}
}