<?php
/*****************************************************************************
 *   This program is free software: you can redistribute it and/or modify    *
 *   it under the terms of the GNU General Public License as published by    *
 *   the Free Software Foundation, either version 3 of the License, or       *
 *   any later version.                                                      *
 *___________________________________________________________________________*
 *   This program is distributed in the hope that it will be useful,         *
 *   but WITHOUT ANY WARRANTY; without even the implied warranty of          *
 *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the           *
 *   GNU General Public License for more details.                            *
 *___________________________________________________________________________*
 *   You should have received a copy of the GNU General Public License       *
 *   along with this program.  If not, see <http://www.gnu.org/licenses/>.   *
 *___________________________________________________________________________*
 * @license GPL 3                                                            *
 * @author QTI3E                                                             *
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
//		$controller->setReturnJSON(true);
	}
}
$controller->run($params);
if(ob_get_contents()){
	ob_end_flush();
}