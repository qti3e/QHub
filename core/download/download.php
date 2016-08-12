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

namespace core\download;

use core\exception\youn_exception;
use core\http\http;
use core\view\template;

/**
 * Class download
 * @package core\download
 */
class download {
	/**
	 * Use this function only for setting headers, for sending file your controller function should returns file content at the end :)
	 * @param $file
	 *  File url
	 * @return bool|string
	 *  Returns file contents
	 * @throws youn_exception
	 *  When file does not exists
	 */
	public static function forceDownload($file){
		if(!file_exists($file)){
			throw new youn_exception('','File does not exists.');
		}
		template::clean();
		http::header('Content-Description','File Transfer');
		http::header('Content-Type','application/octet-stream');
		http::header('Content-Disposition','attachment; filename="'.basename($file).'"');
		http::header('Expires',0);
		http::header('Cache-Control','must-revalidate');
		http::header('Pragma','public');
		http::header('Content-Length',filesize($file));
		print file_get_contents($file);
		exit();
	}
}