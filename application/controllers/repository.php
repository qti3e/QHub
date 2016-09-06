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
use core\controller\YU_Controller;

/**
 * Class repository
 * @package application\controllers
 */
class repository extends YU_Controller{
	/**
	 * @param $data
	 *  Parameters
	 *      * id req.
	 * @param $userId
	 *
	 * @return array
	 *  Return a array contains ['date (in y/m/d format)'=>integer (number of commits on that day)]
	 */
	public function getCounts($data,$userId){
		//Repository id
		$repositoryId   = isset($data['id']) ? $data['id'] : false;
		if($repositoryId === false){
			return ['code'=>403,'status'=>'err','message'=>'The required parameter is missing.'];
		}
		if(db::canRead($userId,$repositoryId)){
			return ['code'=>403,'status'=>'err','message'=>'You do not have permission to get details of following repository.'];
		}
		return db::$redis->hGetAll(db::getRepositoryPropertyById($repositoryId,'counts'));
	}

	/**
	 * @param $data
	 *      * id        req     Repository id
	 *      * length    opt     Number of commits that will return in each page
	 *      * page      opt     Page number
	 *      * last      opt     Number of all commits in the first request
	 * @param $userId
	 *
	 * @return array
	 *  data:
	 *      count   : number of all commits at the time
	 *      commits : array of commits
	 *          id      -> commit id
	 *          name    -> commit title and details
	 *          time    -> unix timestamp
	 *          user    -> user id
	 *          repo    -> repository id
	 * pagination:
	 *  prev:       -> you have to send this data for request previous page of results
	 *      last
	 *      page
	 *      length
	 * next:        -> send it to server for request next page of results
	 *      last
	 *      page
	 *      length
	 * When prev is false it means current page is the first page,
	 * and when next is false it means you are in the last page.
	 */
	public function getCommits($data,$userId){
		$repositoryId   = isset($data['id'])    ? $data['id']       : false;
		if($repositoryId === false){
			return ['code'=>403,'status'=>'err','message'=>'The required parameter is missing.'];
		}
		if(db::canRead($userId,$repositoryId)){
			return ['code'=>403,'status'=>'err','message'=>'You do not have permission to get details of following repository.'];
		}
		$commitsListId  = db::getRepositoryPropertyById($repositoryId,'commits');
		$len        = db::$redis->lLen($commitsListId);
		$return     = [];
		$length     = isset($data['length'])    ? $data['length']   : 16;
		$page       = isset($data['page'])      ? $data['page']     : 0;
		$lastLen    = isset($data['last'])      ? $data['last']     : $len;
		$delta      = $len - $lastLen;
		$start      = $page * $length + $delta;
		$end        = ($page + 1) * $length + $data;
		$commits    = db::$redis->lRange($commitsListId,$start,$end);
		$count      = count($commits);
		for($i  = 0;$i < $count;$i++){
			$commit = db::$redis->hGetAll($commits[$i]);
			if($commit){
				$commit['id']   = $commits[$i];
				$return[]       = $commit;
			}
		}
		$isFirstPage    = $start == 0;
		$isLastPage     = $end  >= $len;
		$pagination     = [
			'next'=>[
				'last'      => $lastLen,
				'page'      => $page+1,
				'length'    => $length
			],
			'prev'=>[
				'last'      => $lastLen,
				'page'      => $page+1,
				'length'    => $length
			]
		];
		if($isFirstPage){
			$pagination['prev'] = false;
		}
		if($isLastPage){
			$pagination['next'] = false;
		}
		return ['code'=>200,'status'=>'ok',
			'data'=>[
				'count'     => $len,        //count of all commits
				'commits'   => $commits
			],
			'pagination'=>$pagination
		];
	}

	/**
	 * @param $data
	 * Parameters:
	 *      * name  req repository name
	 *      * dec   opt repository description
	 *      * read  opt list of members who can read this repository (by user id)
	 *      * write opt list of members who can write on the repository (by user id)
	 *      * admin opt list of members with full-administration control on the repository (by user id)
	 *          @Note:you don't need need to insert your user id in this list because this function add your id
	 *          to the list automatically
	 * @param $userId
	 *
	 * @return array
	 * 403(code):
	 *      err (status):
	 *          The required parameter is missing. (message)
	 *      nok (status):
	 *          There is a repository with same name before. (message)
	 * 200 (code):
	 *      status  :   ok
	 *      data    :   All information of generated repository
	 */
	public function create($data,$userId){
		$name       = isset($data['name'])  ? $data['name'] : false;
		$dec        = isset($data['dec'])   ? $data['dec']  : false;
		$readOnly   = isset($data['read'])  ? array_values($data['read'])   : [];
		$write      = isset($data['write']) ? array_values($data['write'])  : [];
		$admins     = isset($data['admin']) ? array_values($data['admin'])  : [];
		$admins[]   = $userId;
		if(!$name){
			return ['code'=>403,'status'=>'err','message'=>'The required parameter is missing.'];
		}
		if(db::r2i($name)){
			return ['code'=>403,'status'=>'nok','message'=>'There is a repository with same name.'];
		}
		$info       = db::createRepository($name,[
			'dec'   => $dec
		]);
		$repeat = [];
		//Done work for admin access users
		$count      = count($admins);
		for($i      = 0;$i < $count;$i++){
			if(!in_array($admins[$i],$repeat)){
				db::giveReadAccess($admins[$i],$info['key']);
				db::$redis->sAdd($info['team'],$admins[$i]);
				$repeat[]   = $admins[$i];
			}
		}
		//Done work for write access users
		$count      = count($write);
		for($i      = 0;$i < $count;$i++){
			if(!in_array($write[$i],$repeat)){
				db::giveReadAccess($write[$i],$info['key']);
				db::$redis->sAdd($info['team'],$write[$i]);
				$repeat[]   = $write[$i];
			}
		}
		//Done work for read only users
		$count      = count($readOnly);
		for($i      = 0;$i < $count;$i++){
			if(!in_array($readOnly[$i],$repeat)){
				db::giveReadAccess($readOnly[$i],$info['key']);
				db::$redis->sAdd($info['team'],$readOnly[$i]);
				$repeat[]   = $readOnly[$i];
			}
		}
		return ['code'=>200,'status'=>'ok','data'=>$info];
	}

	/**
	 * @param $data
	 *      * id    req     repository id
	 *      * photo req     image id
	 * @param $userId
	 *
	 * @return array
	 *  Errors:
	 *      The required parameter is missing.
	 *      Repository does not exists.
	 *      Image does not exists.
	 *      You don't have access to this photo.
	 *      Invalid image.
	 * OK:
	 *      data will be an empty array
	 */
	public function setPhoto($data,$userId){
		$id     = isset($data['id'])    ? $data['id']   : false;
		$photo  = isset($data['photo']) ? $data['photo']: false;
		if($id === false || $photo == false){
			return ['code'=>403,'status'=>'err','message'=>'The required parameter is missing.'];
		}
		if(db::repoExistsById($id)){
			return ['code'=>403,'status'=>'nok','message'=>'Repository does not exists.'];
		}
		/**
		 * err:
		 *  image id does not exist             -1
		 *  image is not for this user id       0
		 *  this is not a correct image         1
		 * ok:
		 *  full path of uploaded photo         file address
		 */
		$status = photo::stable($photo,$userId);
		switch($status){
			case -1:
				return ['code'=>403,'status'=>'nok','message'=>'Image does not exists.'];
			case 0:
				return ['code'=>403,'status'=>'nok','message'=>'You don\'t have access to this photo.'];
			case 1:
				return ['code'=>403,'status'=>'nok','message'=>'Invalid image.'];
		}
		db::setRepositoryPropertyById($id,'photo',$status);
		return ['code'=>200,'status'=>'ok','data'=>[]];
	}
}