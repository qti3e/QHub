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

namespace core\exception;

use core\log\writer;

/**
 * Class youn_exception
 * @package core\exception
 */
class youn_exception extends \Exception{
	/**
	 * youn_exception constructor.
	 *
	 * @param string         $function
	 * @param string         $message
	 * @param int            $code
	 * @param \Exception|null $previous
	 */
	public function __construct($function,$message = "", $code = 0, \Exception $previous = null) {
		parent::__construct($message, $code, $previous);
		if(method_exists($this,$function)){
			$this->$function($message,$code);
		}
		$this->log();
	}

	/**
	 * @return void
	 */
	public function log(){
		writer::log($this->code."\t".$this->message."\t".$this->getFile().':'.$this->getLine());
		writer::writeToFile();
	}
}