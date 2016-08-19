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

namespace application\third_party;


use core\helper\variable;
use core\redis\Credis_Client;

/**
 * Class db
 * @package application\third_party
 */
class db {
	/**
	 * @var Credis_Client
	 */
	public static $redis;

	/**
	 * @param $name
	 *
	 * @return bool
	 */
	public static function keyExists($name){
		return !empty(static::$redis->keys($name));
	}

	/**
	 * Create a random and unique sha1 key
	 * @param  string $prefix
	 * @return string
	 */
	public static function createUniqueKey($prefix = 'key_'){
		$key    = md5($prefix.variable::randomString(50));
		$re     = static::$redis->sAdd('!unique_keys',$key);
		//Be sure key is unique
		if($re == 1){
			return $key;
		}
		//If key repeated before we don't return it and we'll create another one
		return self::createUniqueKey($prefix);
	}

	/**
	 * @param $repository
	 *
	 * @return bool|string
	 */
	public static function r2i($repository){
		return static::$redis->hGet('$r2i',$repository);
	}

	/**
	 * @param $repository
	 *
	 * @return bool
	 */
	public static function repoExists($repository){
		return (bool)self::r2i($repository);
	}

	/**
	 * @param       $name
	 * @param array $info
	 *
	 * @return bool
	 */
	public static function createRepository($name,$info = []){
		if(self::repoExists($name)){
			return false;
		}
		$key = self::createUniqueKey('repo_');
		static::$redis->sAdd('!repositories', $key);
		$info['name']   = $name;
		//Create link to counts per day hash
		$info['counts'] = self::createUniqueKey('counts_');
		//Create link to commits list
		$info['commits']= self::createUniqueKey('commits_');
		//Save creation time
		$info['date']   = time();
		static::$redis->hMSet($key, $info);
		//Create redis repository to id function
		static::$redis->hSet('$r2i',$name,$key);
		return true;
	}

	/**
	 * @param $id
	 * @param $property
	 *
	 * @return bool|string
	 *
	 */
	public static function getRepositoryPropertyById($id,$property){
		if(static::$redis->sIsMember('!repositories',$id)){
			return static::$redis->hget($id,$property);
		}
		return false;
	}

	/**
	 * @param $repository
	 * @param $property
	 *
	 * @return bool|string
	 */
	public static function getRepositoryPropertyByName($repository,$property){
		$id = self::r2i($repository);
		if($id){
			return static::$redis->hGet($id,$property);
		}
		return false;
	}

	/**
	 * @param $id
	 *
	 * @return array|bool
	 */
	public static function getRepositoryById($id){
		if(static::$redis->sIsMember('!repositories',$id)){
			return static::$redis->hGetAll($id);
		}
		return false;
	}

	/**
	 * @param $repository
	 *
	 * @return array
	 */
	public static function getRepositoryByName($repository){
		$id = self::r2i($repository);
		if($id){
			return static::$redis->hGetAll($id);
		}
		return false;
	}
	//End of repository related functions



	//Start of users related functions
	/**
	 * Convert username to id
	 * @param $username
	 *
	 * @return bool|string
	 * Returns false if user does not exists.
	 */
	public static function u2i($username){
		$username   = strtolower($username);
		return static::$redis->hGet('$u2i',$username);
	}

	/**
	 * Convert email to id
	 * @param $email
	 *
	 * @return bool|string
	 * Returns false if email does not exists.
	 */
	public static function e2i($email){
		$email      = strtolower($email);
		return static::$redis->hGet('$e2i',$email);
	}

	/**
	 * @param $id
	 *
	 * @return bool|string
	 */
	public static function i2r($id){
		return static::$redis->hGet($id,'reads');
	}

	/**
	 * @param $id
	 *
	 * @return bool|string
	 */
	public static function i2w($id){
		return static::$redis->hGet($id,'writes');
	}

	/**
	 * @param $username
	 *
	 * @return bool
	 */
	public static function usernameExists($username){
		return (bool)self::u2i($username);
	}

	/**
	 * @param $email
	 *
	 * @return bool
	 */
	public static function emailExists($email){
		return (bool)self::e2i($email);
	}

	/**
	 * @param $id
	 *
	 * @return int
	 */
	public static function userIdExists($id){
		return static::$redis->sIsMember('!users',$id);
	}

	/**
	 * @param $password
	 *
	 * @return string
	 */
	public static function hashPassword($password){
		return sha1(strtolower(md5($password)));
	}

	/**
	 * @param       $username
	 * @param       $email
	 * @param       $password
	 * @param array $info
	 *
	 * @return bool
	 */
	public static function createUser($username,$email,$password,$info = []){
		$username   = strtolower($username);
		$email      = strtolower($email);
		if(self::usernameExists($username) || self::emailExists($email)){
			return false;
		}
		$key = self::createUniqueKey('user_');
		//Create a unique key for reads accesses set
		$info['reads']      = self::createUniqueKey('reads_');
		//Create a unique key for writes accesses set
		$info['writes']     = self::createUniqueKey('writes_');
		//Create a unique key for counts per day hash
		//Counting commits per day (dmy)
		$info['count']      = self::createUniqueKey('counts_');
		//Creating a unique key for tokens list's name
		$info['token']      = self::createUniqueKey('token_');
		//Hash and save password
		$info['password']   = self::hashPassword($password);
		//Save user registration time in unix timestamp
		$info['date']       = time();
		static::$redis->sAdd('!users', $key);
		static::$redis->hMSet($key, $info);
		static::$redis->hSet('$u2i',$username,$key);
		static::$redis->hSet('$e2i',$email,$key);
		return true;
	}

	/**
	 * @param $id
	 * @param $property
	 *
	 * @return bool|string
	 */
	public static function getUserPropertyById($id,$property){
		if(static::$redis->sIsMember('!users',$id)){
			return static::$redis->hGet($id,$property);
		}
		return false;
	}

	/**
	 * @param $username
	 * @param $property
	 *
	 * @return bool|string
	 */
	public static function getUserPropertyByUsername($username,$property){
		$id = self::u2i($username);
		if($id){
			return static::$redis->hGet($id,$property);
		}
		return false;
	}

	/**
	 * @param $id
	 *
	 * @return array|bool
	 */
	public static function getUserById($id){
		if(static::$redis->sIsMember('!users',$id)){
			return static::$redis->hGetAll($id);
		}
		return false;
	}

	/**
	 * @param $username
	 *
	 * @return array|bool
	 */
	public static function getUserByUsername($username){
		$id = self::u2i($username);
		if($id){
			return static::$redis->hGetAll($id);
		}
		return false;
	}
		//Start of token functions
	/**
	 * Create a unique token key for user and expire it after a week as default.
	 * @param     $userId
	 *
	 * @return bool
	 */
	public static function createToken($userId){
		//Check user exists or not
		if(self::userIdExists($userId)){
			//Create a unique key and hash it in sha1 cause of it's longer length
			$key    = sha1(self::createUniqueKey('token_'));
			//Save token in redis :)
			static::$redis->set($key,$userId);
			//86400 = 24h*60m*60s = 1 Day in seconds
			//Expire key after a week
			static::$redis->expire($key,7*86400);
			//Save token key in users token list
			static::$redis->sAdd(static::$redis->hGet($userId,'token'),$key);
			//Return token
			return $key;
		}
		//Return false means user does not exists and token not created
		return false;
	}

	/**
	 * @param $tokenKey
	 *
	 * @return bool|string
	 */
	public static function getToken($tokenKey){
		//Remove token if user don't use it for one week.
		static::$redis->expire($tokenKey,7*86400);
		return static::$redis->get($tokenKey);
	}

	/**
	 * Destroys token for ever
	 * @param $token
	 * @param $userId
	 *
	 * @return void
	 */
	public static function expireToken($token,$userId){
		static::$redis->sRem(static::$redis->hGet($userId,'token'),$token);
		static::$redis->del($token);
	}
		//End of token functions
	//End of users related function


}