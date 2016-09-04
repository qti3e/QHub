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

namespace application\controllers;


use application\third_party\db;

/**
 * Class user
 * @package application\controllers
 */
class user {
	/**
	 * @param $data
	 * Parameters:
	 *      * username req
	 *      * password req
	 *
	 * @return array
	 *  status:nok
	 *      Failed
	 *  status:ok
	 *      Data will be generated token for user
	 */
	public function login($data){
		//get username,password => access token
		//Return values:
		//1.Username and passwords are correct  => token key
		//2.Other wise                          => false
		$username   = isset($data['username']) ? $data['username']  : false;
		$password   = isset($data['password']) ? $data['password']  : false;
		if(!$username || !$password){
			http_response_code(403);
			return ['code'=>403,'status'=>'err','message'=>'Incorrect parameters for login endpoint.'];
		}
		$username   = strtolower($username);
		$id         = db::u2i($username);
		if($id){
			if(db::getUserPropertyById($id,'password') == db::hashPassword($password)){
				return ['code'=>200,'status'=>'ok','data'=>db::createToken($id)];
			}else{
				return ['code'=>200,'status'=>'nok','data'=>false];
			}
		}
		return ['code'=>200,'status'=>'nok','data'=>false];
	}

	/**
	 * @param $data
	 * This endpoint does not request any parameters
	 * @param $user_id
	 *
	 * @return array
	 *  Repositories that user can read or write
	 */
	public function repositories($data,$user_id){
		$repositories_list  = db::getRepositoriesByUser($user_id);
		$count  = count($repositories_list);
		$return = [];
		for($i  = 0;$i < $count;$i++){
			$repoId = $repositories_list[$i];
			$repo   = db::getRepositoryById($repoId);
			if($repo){
				$repo['id']     = $repoId;
				$access         = db::canWrite($user_id,$repoId) ? 'w' : 'r';
				$repo['access'] = $access;
				$return[]       = $repo;
			}
		}
		return ['code'=>200,'status'=>'ok','data'=>$return];
	}

	/**
	 * @param $data
	 * Parameters:
	 *  id  opt     def: Current user id
	 * @param $userId
	 *
	 * @return array
	 *  404:
	 *      When user does not exist
	 * Otherwise:
	 *      All information about a user (Only password will not send)
	 */
	public function profile($data,$userId){
		$userId = isset($data['id']) ? $data['id'] : $userId;
		$user   = db::getUserById($userId);
		if($user){
			$user['password']   = false;
			unset($user['password']);
			return ['code'=>200,'status'=>'ok','data'=>$user];
		}
		return ['code'=>404,'status'=>'nok','message'=>'User does not exists.'];
	}
}