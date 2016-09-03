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

class user {
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
}