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

include 'core/controller/URLController.php';
$controller = new \core\controller\URLController();
$controller->config('yu_config.php');
$keys   = array_keys($_GET);
$params = '';
if(isset($keys[0])){
	$params = $keys[0];
}
$count = count($keys);
if(isset($keys[$count - 1])){
	if($keys[$count - 1] == 'json'){
		if($count <= 1){
			$params = '';
		}
		$controller->setReturnJSON(true);
	}
}
$controller->run($params,true);
if(ob_get_contents()){
	ob_end_clean();
}
$redis  = \application\third_party\db::$redis;
$redis->hMSet('asd',[
	'name'  =>'Alireza',
	'lname' =>'Ghadimi',
	'age'   =>'15'
]);
var_dump($redis->sAdd('dsdfg',1),$redis->sAdd('dsdfg',1));
var_dump($redis->hGetAll(false));