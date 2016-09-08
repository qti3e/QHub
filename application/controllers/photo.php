<?php
/**
 * Manage photo uploading more safely
 *
 * @license GPL
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License, version 3
 * @author  QTIƎE <Qti3eQti3e@Gmail.com>
 */

namespace application\controllers;
use \core\controller\YU_Controller;
use application\third_party\db;

/**
 * Class photo
 * Manage photo uploading more safely
 */
class photo extends YU_Controller{
	/**
	 * Upload photo
	 * @api photo/upload
	 * @param string $data
	 *      * data  req     photo data (binary)
	 *
	 * @return array
	 *  ERR:
	 *      The required parameter is missing.
	 *  Otherwise:
	 *      Returns generated image id as data
	 *  Note:   image id is only valid for 5 minutes not more and you have to call @see stable function
	 *  Note:   image id is sha1('photo_'.base64_encode($data)), so you can
	 */
	public function upload($data){
		$data   = isset($data['data']) ? $data['data']  : false;
		if($data    === false){
			return ['code'=>403,'status'=>'err','message'=>'The required parameter is missing.'];
		}

		$id     = sha1('photo_'.$data);
		$data   = base64_decode($data);
		$address    = 'images/'.$id.'.png';
		if(file_exists($address)){
			return ['code'=>200,'status'=>'ok','data'=>$id];
		}
		db::$redis->hSet($id,'data',$data);
		//remove photo from database after 2 minutes
		db::$redis->expire($id,120);
		return ['code'=>200,'status'=>'ok','data'=>$id];
	}

	/**
	 * Copy file from redis to hard disk and create access url for it
	 * @param string $imageId
	 *  Image id
	 * @return int
	 * err:
	 *  image id does not exist             -1
	 *  this is not a correct image         1
	 * ok:
	 *  full path of uploaded photo         file address
	 */
	public static function stable($imageId){
		$address= 'images/'.$imageId.'.png';
		if(file_exists($address)){
			return $address;
		}
		$image  = db::$redis->hGet($imageId,'data');
		if($image === false){
			//Image does not exist
			return -1;
		}
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
	 * @api photo/start
	 * @param string $data
	 * Parameters:
	 *      * sha1  req     sha1('photo_'.imageData)
	 *
	 * @return array
	 * ERR:
	 *  The required parameter is missing.
	 * status:
	 *  false   : Means user don't need to re upload photo and this file exist on server already
	 *              and data will be file address
	 *  true    : This file does not exists on server and user have to upload it
	 */
	public function start($data){
		$sha1       = isset($data['sha1']) ? $data['sha1']  : false;
		if($sha1    === false){
			return ['code'=>403,'status'=>'err','message'=>'The required parameter is missing.'];
		}
		$address    = 'images/'.$data['sha1'].'.png';
		if(file_exists($address)){
			return ['code'=>200,'status'=>false,'data'=>$sha1];
		}
		return ['code'=>200,'status'=>true,'data'=>true];
	}
}