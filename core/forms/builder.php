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

namespace core\forms;


use core\html\attribute;
use core\html\tag;

/**
 * Class builder
 * @package core\forms
 * @method attribute accept($value = null)
 * @method attribute accept_charset($value = null)
 * @method attribute accesskey($value = null)
 * @method attribute action($value = null)
 * @method attribute align($value = null)
 * @method attribute alt($value = null)
 * @method attribute async($value = null)
 * @method attribute autocomplete($value = null)
 * @method attribute autofocus($value = null)
 * @method attribute autoplay($value = null)
 * @method attribute autosave($value = null)
 * @method attribute bgcolor($value = null)
 * @method attribute border($value = null)
 * @method attribute buffered($value = null)
 * @method attribute challenge($value = null)
 * @method attribute charset($value = null)
 * @method attribute checked($value = null)
 * @method attribute cite($value = null)
 * @method attribute class($value = null)
 * @method attribute code($value = null)
 * @method attribute codebase($value = null)
 * @method attribute cols($value = null)
 * @method attribute colspan($value = null)
 * @method attribute content($value = null)
 * @method attribute contenteditable($value = null)
 * @method attribute contextmenu($value = null)
 * @method attribute controls($value = null)
 * @method attribute coords($value = null)
 * @method attribute data($value = null)
 * @method attribute data_*($value = null)
 * @method attribute default($value = null)
 * @method attribute defer($value = null)
 * @method attribute dir($value = null)
 * @method attribute dirname($value = null)
 * @method attribute disabled($value = null)
 * @method attribute download($value = null)
 * @method attribute draggable($value = null)
 * @method attribute dropzone($value = null)
 * @method attribute enctype($value = null)
 * @method attribute for($value = null)
 * @method attribute form($value = null)
 * @method attribute formaction($value = null)
 * @method attribute Global($value = null)
 * @method attribute headers($value = null)
 * @method attribute height($value = null)
 * @method attribute high($value = null)
 * @method attribute href($value = null)
 * @method attribute hreflang($value = null)
 * @method attribute http_equiv($value = null)
 * @method attribute icon($value = null)
 * @method attribute id($value = null)
 * @method attribute ismap($value = null)
 * @method attribute itemid($value = null)
 * @method attribute itemprop($value = null)
 * @method attribute itemref($value = null)
 * @method attribute itemscope($value = null)
 * @method attribute itemtype($value = null)
 * @method attribute keytype($value = null)
 * @method attribute kind($value = null)
 * @method attribute label($value = null)
 * @method attribute lang($value = null)
 * @method attribute language($value = null)
 * @method attribute list($value = null)
 * @method attribute loop($value = null)
 * @method attribute low($value = null)
 * @method attribute manifest($value = null)
 * @method attribute max($value = null)
 * @method attribute maxlength($value = null)
 * @method attribute media($value = null)
 * @method attribute method($value = null)
 * @method attribute min($value = null)
 * @method attribute multiple($value = null)
 * @method attribute muted($value = null)
 * @method attribute name($value = null)
 * @method attribute novalidate($value = null)
 * @method attribute open($value = null)
 * @method attribute optimum($value = null)
 * @method attribute pattern($value = null)
 * @method attribute ping($value = null)
 * @method attribute placeholder($value = null)
 * @method attribute poster($value = null)
 * @method attribute preload($value = null)
 * @method attribute radiogroup($value = null)
 * @method attribute readonly($value = null)
 * @method attribute rel($value = null)
 * @method attribute required($value = null)
 * @method attribute reversed($value = null)
 * @method attribute rows($value = null)
 * @method attribute rowspan($value = null)
 * @method attribute sandbox($value = null)
 * @method attribute scope($value = null)
 * @method attribute scoped($value = null)
 * @method attribute seamless($value = null)
 * @method attribute selected($value = null)
 * @method attribute shape($value = null)
 * @method attribute size($value = null)
 * @method attribute sizes($value = null)
 * @method attribute span($value = null)
 * @method attribute spellcheck($value = null)
 * @method attribute src($value = null)
 * @method attribute srcdoc($value = null)
 * @method attribute srclang($value = null)
 * @method attribute srcset($value = null)
 * @method attribute start($value = null)
 * @method attribute step($value = null)
 * @method attribute style($value = null)
 * @method attribute summary($value = null)
 * @method attribute tabindex($value = null)
 * @method attribute target($value = null)
 * @method attribute title($value = null)
 * @method attribute translate($value = null)
 * @method attribute type($value = null)
 * @method attribute usemap($value = null)
 * @method attribute value($value = null)
 * @method attribute width($value = null)
 * @method attribute wrap($value = null)
 */
class builder {
	/**
	 * @var attribute
	 */
	protected $object;
	/**
	 * @var int
	 */
	protected $id       = 0;
	/**
	 * @var array
	 */
	protected $elements = [];

	/**
	 * builder constructor.
	 */
	public function __construct() {
		$this->object   = tag::form();
	}

	/**
	 * @return attribute
	 */
	public function object(){
		return $this->object;
	}

	/**
	 * @return string
	 */
	public function __toString() {
		$text   = '';
		$keys   = array_keys($this->elements);
		$count  = count($this->elements);
		for($i  = 0;$i < $count;$i++){
		    $key= $keys[$i];
		    $val= $this->elements[$key];
		    $text   .= (string) $val;
		}
		$this->object->_changeText($text);
		return (string)$this->object;
	}

	/**
	 * @param attribute $obj
	 *
	 * @return int
	 */
	public function addObj(attribute &$obj){
		$this->elements[++$this->id]    = $obj;
		return $this->id;
	}

	/**
	 * @param $id
	 *
	 * @return bool
	 */
	public function delObj($id){
		if(isset($this->elements[$id])){
			unset($this->elements[$id]);
			return true;
		}
		return false;
	}

	/**
	 * @param           $id
	 * @param attribute $obj
	 *
	 * @return bool
	 */
	public function changeObj($id,attribute $obj){
		if(isset($this->elements[$id])){
			$this->elements[$id]    = (string)$obj;
			return true;
		}
		return false;
	}

	/**
	 * @param string $type
	 * @param null   $name
	 * @param null   $value
	 * @param null   $placeholder
	 *
	 * @return attribute
	 */
	public function input($type = 'text',$name = null,$value = null,$placeholder = null){
		$tag    = tag::input($type);
		if($name  !== null){
			$tag->name($name);
		}
		if($value !== null){
			$tag->value($value);
		}
		if($placeholder !== null){
			$tag->placeholder($placeholder);
		}
		$this->addObj($tag);
		return $tag;
	}


	/**
	 * @param null $name
	 * @param null $value
	 * @param null $placeholder
	 *
	 * @return attribute
	 */
	public function button($name = null, $value = null, $placeholder = null) {
		return $this->input('button',$name,$value,$placeholder);
	}

	/**
	 * @param null $name
	 * @param null $value
	 * @param null $placeholder
	 *
	 * @return attribute
	 */
	public function checkbox($name = null, $value = null, $placeholder = null) {
		return $this->input('checkbox',$name,$value,$placeholder);
	}

	/**
	 * @param null $name
	 * @param null $value
	 * @param null $placeholder
	 *
	 * @return attribute
	 */
	public function color($name = null, $value = null, $placeholder = null) {
		return $this->input('color',$name,$value,$placeholder);
	}

	/**
	 * @param null $name
	 * @param null $value
	 * @param null $placeholder
	 *
	 * @return attribute
	 */
	public function date($name = null, $value = null, $placeholder = null) {
		return $this->input('date',$name,$value,$placeholder);
	}

	/**
	 * @param null $name
	 * @param null $value
	 * @param null $placeholder
	 *
	 * @return attribute
	 */
	public function datetime($name = null, $value = null, $placeholder = null) {
		return $this->input('datetime',$name,$value,$placeholder);
	}

	/**
	 * @param null $name
	 * @param null $value
	 * @param null $placeholder
	 *
	 * @return attribute
	 */
	public function datetime_local($name = null, $value = null, $placeholder = null) {
		return $this->input('datetime_local',$name,$value,$placeholder);
	}

	/**
	 * @param null $name
	 * @param null $value
	 * @param null $placeholder
	 *
	 * @return attribute
	 */
	public function email($name = null, $value = null, $placeholder = null) {
		return $this->input('email',$name,$value,$placeholder);
	}

	/**
	 * @param null $name
	 * @param null $value
	 * @param null $placeholder
	 *
	 * @return attribute
	 */
	public function file($name = null, $value = null, $placeholder = null) {
		return $this->input('file',$name,$value,$placeholder);
	}

	/**
	 * @param null $name
	 * @param null $value
	 * @param null $placeholder
	 *
	 * @return attribute
	 */
	public function hidden($name = null, $value = null, $placeholder = null) {
		return $this->input('hidden',$name,$value,$placeholder);
	}

	/**
	 * @param null $name
	 * @param null $value
	 * @param null $placeholder
	 *
	 * @return attribute
	 */
	public function image($name = null, $value = null, $placeholder = null) {
		return $this->input('image',$name,$value,$placeholder);
	}

	/**
	 * @param null $name
	 * @param null $value
	 * @param null $placeholder
	 *
	 * @return attribute
	 */
	public function month($name = null, $value = null, $placeholder = null) {
		return $this->input('month',$name,$value,$placeholder);
	}

	/**
	 * @param null $name
	 * @param null $value
	 * @param null $placeholder
	 *
	 * @return attribute
	 */
	public function number($name = null, $value = null, $placeholder = null) {
		return $this->input('number',$name,$value,$placeholder);
	}

	/**
	 * @param null $name
	 * @param null $value
	 * @param null $placeholder
	 *
	 * @return attribute
	 */
	public function password($name = null, $value = null, $placeholder = null) {
		return $this->input('password',$name,$value,$placeholder);
	}

	/**
	 * @param null $name
	 * @param null $value
	 * @param null $placeholder
	 *
	 * @return attribute
	 */
	public function radio($name = null, $value = null, $placeholder = null) {
		return $this->input('radio',$name,$value,$placeholder);
	}

	/**
	 * @param null $name
	 * @param null $value
	 * @param null $placeholder
	 *
	 * @return attribute
	 */
	public function reset($name = null, $value = null, $placeholder = null) {
		return $this->input('reset',$name,$value,$placeholder);
	}

	/**
	 * @param null $name
	 * @param null $value
	 * @param null $placeholder
	 *
	 * @return attribute
	 */
	public function search($name = null, $value = null, $placeholder = null) {
		return $this->input('search',$name,$value,$placeholder);
	}

	/**
	 * @param null $name
	 * @param null $value
	 * @param null $placeholder
	 *
	 * @return attribute
	 */
	public function submit($name = null, $value = null, $placeholder = null) {
		return $this->input('submit',$name,$value,$placeholder);
	}

	/**
	 * @param null $name
	 * @param null $value
	 * @param null $placeholder
	 *
	 * @return attribute
	 */
	public function tel($name = null, $value = null, $placeholder = null) {
		return $this->input('tel',$name,$value,$placeholder);
	}

	/**
	 * @param null $name
	 * @param null $value
	 * @param null $placeholder
	 *
	 * @return attribute
	 */
	public function text($name = null, $value = null, $placeholder = null) {
		return $this->input('text',$name,$value,$placeholder);
	}

	/**
	 * @param null $name
	 * @param null $value
	 * @param null $placeholder
	 *
	 * @return attribute
	 */
	public function time($name = null, $value = null, $placeholder = null) {
		return $this->input('time',$name,$value,$placeholder);
	}

	/**
	 * @param null $name
	 * @param null $value
	 * @param null $placeholder
	 *
	 * @return attribute
	 */
	public function url($name = null, $value = null, $placeholder = null) {
		return $this->input('url',$name,$value,$placeholder);
	}

	/**
	 * @param null $name
	 * @param null $value
	 * @param null $placeholder
	 *
	 * @return attribute
	 */
	public function week($name = null, $value = null, $placeholder = null) {
		return $this->input('week',$name,$value,$placeholder);
	}

	/**
	 * @param null $name
	 * @param null $min
	 * @param null $max
	 * @param null $value
	 * @param null $step
	 *
	 * @return attribute
	 */
	public function range($name = null,$min = null,$max = null,$value = null,$step = null){
		$tag    = $this->input('range',$name,$value);
		if($min !== null){
			$tag->min($min);
		}
		if($max !== null){
			$tag->max($max);
		}
		if($step !== null){
			$tag->step($step);
		}
		return $tag;
	}

	/**
	 * @param $name
	 * @param $arguments
	 *
	 * @return $this
	 */
	public function __call($name, $arguments) {
		$this->object->__call($name,$arguments);
		return $this;
	}
}