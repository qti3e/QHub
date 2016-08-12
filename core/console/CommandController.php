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

namespace core\console;

/**
 * Class CommandController
 * @package core\console
 */
class CommandController {
	/**
	 * CommandController constructor.
	 * Print welcome message and ask commands form user
	 */
	public function __construct() {
		print "Welcome to youn cli mode\n>";
		while(strtolower($input = trim(fgets(STDIN)).' ') !== 'exit '){
			if(!empty(trim($input))){
				$command    = strtolower(substr($input,0,strpos($input,' ')));
				$class      = 'core\\console\\commands\\'.$command.'Command';
				if(class_exists($class)){
					new $class(new getopt(substr($input,strpos($input,' '))));
				}else{
					echo 'Sorry but <'.$command.'> command was not found.';
				}
			}
			echo "\n>";
		}
	}

	/**
	 * Print good bye message
	 */
	public function __destruct() {
		print "Good bye!\n";
	}

	/**
	 * @param $string
	 *
	 * @return array
	 */
	protected function getOpt($string){
		return getopt::parse($string);
	}
}