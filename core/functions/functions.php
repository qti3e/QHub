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
/**
 * Include header file (use in template files)
 * @return void
 */
function header(){
	include "header.php";
}

/**
 * Include footer file (user in template files)
 * @return void
 */
function footer(){
	include "footer.php";
}

/**
 * Return link of special page with token id included
 * @param $page_name
 *  Page name
 * @param $token_key
 *  Token id key for get
 * @return string
 *
 */
function token($page_name,$token_key = 'token'){
	return base_url.'/'.$page_name.'?'.$token_key.'='.\core\token\token::create($page_name);
}

/**
 * @param $name
 *
 * @return string
 */
function lang($name){
	return \core\i18n\lang::get($name);
}

/**
 * @param $name
 *
 * @return string
 */
function i18n($name){
	return \core\i18n\lang::get($name);
}

/**
 * @return string
 */
function templateURL(){
	return base_url.'/application/templates/';
}

//TODO:
function form_open($attributes){

}
function form_close(){
	echo '</form>';
}
function captcha_image($name){

}
function captcha_input($name){

}
function captcha_name($name){

}
function md(){

}
function markdown(){

}