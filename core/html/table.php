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

namespace core\html;

/**
 * Class table
 * @package core\html
 */
class table {
	/**
	 * @var array
	 */
	protected $columns  = [];
	/**
	 * @var array
	 */
	protected $rows     = [];
	/**
	 * @var attribute
	 */
	protected $table;
	/**
	 * @var attribute
	 */
	protected $thead;
	/**
	 * @var attribute
	 */
	protected $tbody;
	/**
	 * @var attribute
	 */
	protected $tr;
	/**
	 * @var attribute
	 */
	protected $td;

	/**
	 * table constructor.
	 */
	public function __construct() {
		$this->table    = tag::table();
		$this->thead    = tag::thead();
		$this->tbody    = tag::tbody();
		$this->tr       = tag::tr();
		$this->td       = tag::td();
	}

	/**
	 * @return attribute
	 */
	public function getTable() {
		return $this->table;
	}

	/**
	 * @return array
	 */
	public function getRows() {
		return $this->rows;
	}

	/**
	 * @return attribute
	 */
	public function getTr() {
		return $this->tr;
	}

	/**
	 * @return attribute
	 */
	public function getTd() {
		return $this->td;
	}

	/**
	 * @return array
	 */
	public function getColumns() {
		return $this->columns;
	}

	/**
	 * @return attribute
	 */
	public function getTbody() {
		return $this->tbody;
	}

	/**
	 * @return attribute
	 */
	public function getThead() {
		return $this->thead;
	}

	/**
	 * @param $name
	 *
	 * @return bool
	 */
	public function addCol($name){
		if(func_num_args() > 1){
			for($i  = 0;$i < func_num_args();$i++){
				$this->addCol(func_get_arg($i));
			}
			return true;
		}
		$this->columns[]    = $name;
		return true;
	}

	/**
	 * @param $information
	 *
	 * @return bool
	 */
	public function addRow($information) {
		if(func_num_args() > 1){
			for($i  = 0;$i < func_num_args();$i++){
				$this->addRow(func_get_arg($i));
			}
			return true;
		}
		$this->rows[]   = $information;
		return true;
	}

	public function __toString() {
		//Make thead
		$tr     = '';
		$count  = count($this->columns);
		for($i  = 0;$i < $count;$i++){
			$this->td->_changeText($this->columns[$i]);
			$tr.= (string)$this->td;
		}
		$this->tr->_changeText($tr);
		$this->thead->_changeText($this->tr);
		//</End of making thead

		$tbody      = '';
		$r_count    = count($this->rows);
		for($r  = 0;$r < $r_count;$r++){
			$vals   = $this->rows[$r];
			$td     = '';
			for($i  = 0;$i < $count;$i++){
				$col= $this->columns[$i];
				$val= 'Empty';
				if(isset($vals[$col])){
					$val    = $vals[$col];
				}
//				echo $val."\n";
				$this->td->_changeText($val);
				$td.= (string)$this->td;
			}
			$this->tr->_changeText($td);
			$tbody .= (string)$this->tr;
		}
		$this->tbody->_changeText($tbody);
		//Make return
		$this->table->_changeText((string)$this->thead.(string)$this->tbody);
		return (string)$this->table;
	}
}