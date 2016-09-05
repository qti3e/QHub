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
}