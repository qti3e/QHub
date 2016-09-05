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
	 * @param $id
	 *
	 * @return int
	 */
	public static function removeUniqueKey($id){
		return static::$redis->sRem('!unique_keys',$id);
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
	 * @return bool|array
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
		//Link to list of team members
		$info['team']   = self::createUniqueKey('team_');
		//Save creation time
		$info['date']   = time();
		static::$redis->hMSet($key, $info);
		//Create redis repository to id function
		static::$redis->hSet('$r2i',$name,$key);
		return $info;
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
	 * @param $property
	 * @param $value
	 *
	 * @return bool|string
	 */
	public static function setRepositoryPropertyById($id,$property,$value){
		if(static::$redis->sIsMember('!repositories',$id)){
			return static::$redis->hSet($id,$property,$value);
		}
		return false;
	}

	/**
	 * @param $repository
	 * @param $property
	 * @param $value
	 *
	 * @return bool|string
	 */
	public static function setRepositoryPropertyByName($repository,$property,$value) {
		$id = self::r2i($repository);
		if($id){
			return static::$redis->hSet($id,$property,$value);
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
		//Create a unique key for admin accesses set
		$info['admin']      = self::createUniqueKey('admin_');
		//Create a unique key for counts per day hash
		//Counting commits per day (dmy)
		$info['count']      = self::createUniqueKey('counts_');
		//Creating a unique key for tokens list's name
		$info['token']      = self::createUniqueKey('token_');
		//Link for to do set
		$info['todo']       = self::createUniqueKey('todo_');
		//Hash and save password
		$info['password']   = self::hashPassword($password);
		//Save user registration time in unix timestamp
		$info['date']       = time();
		//Save username
		$info['username']   = $username;
		//Save email
		$info['email']      = $email;
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
	 * @param $property
	 * @param $value
	 *
	 * @return bool|string
	 */
	public static function setUserPropertyById($id,$property,$value){
		if(static::$redis->sIsMember('!users',$id)){
			return static::$redis->hSet($id,$property,$value);
		}
		return false;
	}

	/**
	 * @param $username
	 * @param $property
	 * @param $value
	 *
	 * @return bool|string
	 */
	public static function setUserPropertyByUsername($username,$property,$value){
		$id = self::u2i($username);
		if($id){
			return static::$redis->hSet($id,$property,$value);
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

		//Start of access functions
	/**
	 * Return list of repositories that user have read or write access to them
	 * @param $userId
	 *
	 * @return array
	 */
	public static function getRepositoriesByUser($userId){
		$writes = self::getUserPropertyById($userId,'writes');
		$reads  = self::getUserPropertyById($userId,'reads');
		$admin  = self::getUserPropertyById($userId,'admin');
		$list   = static::$redis->sUnion([$writes,$reads,$admin]);
		return $list;
	}

	/**
	 * @param $userId
	 * @param $repositoryId
	 *
	 * @return bool
	 */
	public static function canRead($userId,$repositoryId){
		$writes = self::getUserPropertyById($userId,'writes');
		$reads  = self::getUserPropertyById($userId,'reads');
		$admin  = self::getUserPropertyById($userId,'admin');
		return static::$redis->sIsMember($writes,$repositoryId) || static::$redis->sIsMember($reads,$repositoryId) || static::$redis->sIsMember($admin,$repositoryId);
	}

	/**
	 * @param $userId
	 * @param $repositoryId
	 *
	 * @return int
	 */
	public static function canWrite($userId,$repositoryId){
		$writes = self::getUserPropertyById($userId,'writes');
		$admin  = self::getUserPropertyById($userId,'admin');
		return static::$redis->sIsMember($writes,$repositoryId) || static::$redis->sIsMember($admin,$repositoryId);
	}

	/**
	 * @param $userId
	 * @param $repositoryId
	 *
	 * @return int
	 */
	public static function isAdmin($userId,$repositoryId){
		$admin  = self::getUserPropertyById($userId,'admin');
		return static::$redis->sIsMember($admin,$repositoryId);
	}

	/**
	 * @param $userId
	 * @param $repositoryId
	 *
	 * @return bool|string
	 */
	public static function getAccess($userId,$repositoryId){
		$admin  = self::getUserPropertyById($userId,'admin');
		if(static::$redis->sIsMember($admin,$repositoryId)){
			return 'a';
		}
		$writes = self::getUserPropertyById($userId,'writes');
		if(static::$redis->sIsMember($writes,$repositoryId)){
			return 'w';
		}
		$reads  = self::getUserPropertyById($userId,'reads');
		if(static::$redis->sIsMember($reads,$repositoryId)){
			return 'r';
		}
		return false;
	}

	/**
	 * @param $userId
	 * @param $repositoryId
	 *
	 * @return int
	 */
	public static function giveWriteAccess($userId,$repositoryId){
		$writes = self::getUserPropertyById($userId,'writes');
		return static::$redis->sAdd($writes,$repositoryId);
	}

	/**
	 * @param $userId
	 * @param $repositoryId
	 *
	 * @return int
	 */
	public static function giveReadAccess($userId,$repositoryId){
		$reads  = self::getUserPropertyById($userId,'reads');
		return static::$redis->sAdd($reads,$repositoryId);
	}

	/**
	 * @param $userId
	 * @param $repositoryId
	 *
	 * @return void
	 */
	public static function removeReadAccess($userId,$repositoryId){
		$writes = self::getUserPropertyById($userId,'writes');
		$reads  = self::getUserPropertyById($userId,'reads');
		static::$redis->sRem($writes,$repositoryId);
		static::$redis->sRem($reads,$repositoryId);
	}

	/**
	 * @param $userId
	 * @param $repositoryId
	 *
	 * @return void
	 */
	public static function removeWriteAccess($userId,$repositoryId){
		$writes = self::getUserPropertyById($userId,'writes');
		static::$redis->sRem($writes,$repositoryId);
	}
		//End of access functions

		//Start of todoList functions
	/**
	 * @param $userId
	 *
	 * @return array
	 */
	public static function getTodoListByUserId($userId){
		$link   = self::getUserPropertyById($userId,'todo');
		return static::$redis->sMembers($link);
	}

	/**
	 * @param $username
	 *
	 * @return array
	 */
	public static function getTodoListByUsername($username){
		$link   = self::getUserPropertyByUsername($username,'todo');
		return static::$redis->sMembers($link);
	}

	/**
	 * @param $userId
	 * @param $todo
	 *
	 * @return int
	 */
	public static function addTodoByUserId($userId,$todo){
		$link   = self::getUserPropertyById($userId,'todo');
		return static::$redis->sAdd($link,$todo);
	}

	/**
	 * @param $username
	 * @param $todo
	 *
	 * @return int
	 */
	public static function addTodoByUsername($username,$todo){
		$link   = self::getUserPropertyByUsername($username,'todo');
		return static::$redis->sAdd($link,$todo);
	}

	/**
	 * @param $userId
	 * @param $todo
	 *
	 * @return int
	 */
	public static function remTodoByUserId($userId,$todo){
		$link   = self::getUserPropertyById($userId,'todo');
		return static::$redis->sRem($link,$todo);
	}

	/**
	 * @param $username
	 * @param $todo
	 *
	 * @return int
	 */
	public static function remTodoByUsername($username,$todo){
		$link   = self::getUserPropertyByUsername($username,'todo');
		return static::$redis->sRem($link,$todo);
	}
		//End of todoList functions
	//End of users related function



	//Start of commits
	/**
	 * @param $user
	 * @param $repository
	 * @param $name
	 *
	 * @return string
	 */
	public static function createCommit($user,$repository,$name){
		$commits    = self::getRepositoryPropertyById($repository,'commits');
		$count      = self::getRepositoryPropertyById($repository,'counts');
		$userCount  = self::getUserPropertyById($user,'count');
		$date       = date('y/m/d');
		$id         = self::createUniqueKey('commits_');
		static::$redis->hIncrBy($count,'all',1);
		static::$redis->hIncrBy($count,$date,1);
		static::$redis->hIncrBy($userCount,'all',1);
		static::$redis->hIncrBy($userCount,$date,1);
		static::$redis->lPush($commits,$id);
		static::$redis->hSet($repository,'lastCommit',$id);
		static::$redis->hSet($repository,'lastUpdate',time());
		static::$redis->hSet($user,'lastActivity',time());
		static::$redis->hMSet($id,[
			'name'=>$name,
			'time'=>time(),
			'user'=>$user,
			'repo'=>$repository
		]);
		return $id;
	}

	//Remove functions
	/**
	 * Remove user and all of the related resources
	 * @param $userId
	 *
	 * @return void
	 */
	public static function removeUser($userId){
		$reads  = self::getUserPropertyById($userId,'reads');
		$writes = self::getUserPropertyById($userId,'writes');
		$count  = self::getUserPropertyById($userId,'count');
		$token  = self::getUserPropertyById($userId,'token');
		$tokens = static::$redis->sMembers($token);

		$username   = self::getUserPropertyById($userId,'username');
		$email      = self::getUserPropertyById($userId,'email');

		static::$redis->del([$userId,$reads,$writes,$count,$token]);
		static::removeUniqueKey([$reads,$writes,$count,$token]);
		static::$redis->del($tokens);
		static::$redis->hDel('$u2i',$username);
		static::$redis->hDel('$e2i',$email);
	}
}