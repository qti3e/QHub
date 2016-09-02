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
//use application\third_party\fastEnc;
//$key    = '5vMzFPbMOBqE1CqFTr6fFANQ9twB19z63HzBKPh3wWq3T18eOEZDaZKWuQyUDzcP5Ca8iV3cUrqg=x=0tksOnCzbkvaP2CC11OpEbnfx4Okj2M7Ms';
//echo fastEnc::decrypt('gXF4KDdDevcrDruMGx1u',$key,'a9f21d05d9df52de3f4eba8e58c78e0a9b3b9ba7');
//echo "\n";
//$msg = "Alireza Ghadimi";
//echo ord($msg[5]);
//

use application\third_party\rsa;
rsa::set_private_key(file_get_contents('rsa/rsa_2048_priv.pem'));
//var_dump(rsa::get_public_key());
$start = microtime(true);
var_dump(rsa::decrypt('cc241b6d93b3541b2bad38f22f9d93030f879eee31b587cacb8a8faa72e166d98a14b5e9a078321fff6e02a9018279bd8af10ce7f9aa3171e178e9ec86e883fcefd2e06231e70febf89955825042359a8d4acef937c3de7df0fe2a8c879eb84f7d368c4ac2a3901075ca594a73e7b4d31305b8815f60470b515e3f7c5a0ff2659747cbc1c69438565573827e77bd3ce461ac72a775e4d1dd80524e792c3ede4c0899315f3d1396b5d5781507eb16bcbde0b0368430bb2ec850848fc4ab6a2cb16252ae9c007b58e347b945738564ac3de5b5d99ca1baa1b3b0f642a1953420ff6333e58dcce55791980b73d029a70729bb646a05d4a48642dbdcba1464e122c6'));
echo microtime(true)-$start;
echo "\n";
var_dump(\core\helper\variable::randomString(193));