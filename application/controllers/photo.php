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
use \core\controller\YU_Controller;
use application\third_party\db;

/**
 * Class photo
 * Manage photo uploading more safely
 */
class photo extends YU_Controller{
	/**
	 * @param string $data
	 *      * data  req     photo data (binary)
	 * @param string $userId
	 *
	 * @return array
	 *  ERR:
	 *      The required parameter is missing.
	 *  Otherwise:
	 *      Returns generated image id as data
	 *  Note:   image id is only valid for 5 minutes not more and you have to call @see stable function
	 *  Note:   image id is sha1('photo_'.$data), so you can
	 */
	public function upload($data,$userId){
		$data   = isset($data['data']) ? $data['data']  : false;
		if($data    === false){
			return ['code'=>403,'status'=>'err','message'=>'The required parameter is missing.'];
		}
		$id = sha1('photo_'.$data['data']);
		$address    = 'images/'.$id.'.png';
		if(file_exists($address)){
			return ['code'=>200,'status'=>'ok','data'=>$id];
		}
		db::$redis->hMSet($id,[
			'data'  => $data['data'],
			'user'  => $userId
		]);
		//remove photo from database after 5 minutes
		db::$redis->expire($id,60*5);
		return ['code'=>200,'status'=>'ok','data'=>$id];
	}

	/**
	 * @param string $imageId
	 * @param string $userId
	 *
	 * @return int
	 * err:
	 *  image id does not exist             -1
	 *  image is not for this user id       0
	 *  this is not a correct image         1
	 * ok:
	 *  full path of uploaded photo         file address
	 */
	public static function stable($imageId,$userId){
		$address= 'images/'.$imageId.'.png';
		if(file_exists($address)){
			return $address;
		}
		$user   = db::$redis->hGet($imageId,'user');
		if($user === false){
			//Image does not exist
			return -1;
		}
		if($user !== $userId){
			return 0;
		}
		$image  = db::$redis->hGet($imageId,'data');
		db::$redis->del($imageId);
		$fp     = fopen($address,'w');
		fwrite($fp,$image);
		fclose($fp);
		$info   = getimagesize($address);
		if(!$info){
			//Remove file because it's not a photo
			unlink($address);
			return 1;
		}
		return $address;
	}

	/**
	 * This function is for check that user need to upload a photo or not
	 * @param string $data
	 * Parameters:
	 *      * sha1  req     sha1('photo_'.imageData)
	 *
	 * @return array
	 * ERR:
	 *  The required parameter is missing.
	 * Data:
	 *  false   : Means user don't need to re upload photo and this file exist on server already
	 *  true    : This file does not exists on server and user have to upload it
	 */
	public function start($data){
		$sha1       = isset($data['sha1']) ? $data['sha1']  : false;
		if($sha1    === false){
			return ['code'=>403,'status'=>'err','message'=>'The required parameter is missing.'];
		}
		$address    = 'images/'.$data['sha1'].'.png';
		if(file_exists($address)){
			return ['code'=>200,'status'=>'ok','data'=>false];
		}
		return ['code'=>200,'status'=>'ok','data'=>true];
	}
}