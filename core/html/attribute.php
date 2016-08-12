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
 * Class attribute
 * @package core\html
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
 * @method attribute color($value = null)
 * @method attribute cols($value = null)
 * @method attribute colspan($value = null)
 * @method attribute content($value = null)
 * @method attribute contenteditable($value = null)
 * @method attribute contextmenu($value = null)
 * @method attribute controls($value = null)
 * @method attribute coords($value = null)
 * @method attribute data($value = null)
 * @method attribute data_*($value = null)
 * @method attribute datetime($value = null)
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
 * @method attribute hidden($value = null)
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
class attribute{
	/**
	 * @var string
	 */
	protected $tag      = '';
	/**
	 * @var bool
	 */
	protected $close    = false;
	/**
	 * @var array
	 */
	protected $attributes   = [];
	/**
	 * @var string
	 */
	protected $text         = '';

	/**
	 * attribute constructor.
	 *
	 * @param            $tag
	 * @param bool|false $close
	 * @param string     $text
	 */
	public function __construct($tag,$close = false,$text = '') {
		$this->close    = $close;
		$this->tag      = $tag;
		$this->text     = (string)$text;
	}

	/**
	 * @param $input
	 *
	 * @return string
	 */
	protected function __css($input){
		$keys   = array_keys($input);
		$count  = count($input);
		$return = '';
		for($i  = 0;$i < $count;$i++){
		    $key= $keys[$i];
		    $val= $input[$key];
		    $return .= $key.':'.$val.';';
		}
		return $return;
	}

	/**
	 * @param $name
	 * @param $arguments
	 *
	 * @return $this
	 */
	public function __call($name, $arguments) {
		$name   = strtolower(str_replace('_','-',$name));
		if(!isset($arguments[0])){
			$arguments[0]   = '';
		}
		if(is_array($arguments[0])){
			$arguments[0]   = $this->__css($arguments[0]);
		}elseif(is_bool($arguments[0])){
			$arguments[0]   = ($arguments[0] ? 'true' : 'false');
		}
		$this->attributes[$name]    = $arguments[0];
		return $this;
	}

	/**
	 * @return string
	 */
	protected function attr2string(){
		$keys   = array_keys($this->attributes);
		$count  = count($this->attributes);
		$return = '';
		for($i  = 0;$i < $count;$i++){
		    $key= $keys[$i];
		    $val= $this->attributes[$key];
		    $return .= ' '.$key.'="'.$val.'"';
		}
		return $return;
	}

	/**
	 * @return string
	 */
	public function __toString() {
		$re = '<'.$this->tag.($this->attr2string()).($this->close ? '>' : '/>');
		if($this->close){
			$re .= $this->text;
			$re .= '</'.$this->tag.'>';
		}
		return $re;
	}

	/**
	 * @param $name
	 * @param $value
	 *
	 * @return $this
	 */
	public function _set($name,$value){
		return $this->__call($name,[$value]);
	}

	/**
	 * @param $name
	 *
	 * @return $this
	 */
	public function _unset($name){
		$name   = str_replace(' ','-',$name);
		if(isset($this->attributes[$name])){
			unset($this->attributes[$name]);
		}
		return $this;
	}

	/**
	 * @return $this
	 */
	public function _clear(){
		$this->attributes   = [];
		return $this;
	}

	/**
	 * @param $newText
	 *
	 * @return string
	 */
	public function _changeText($newText){
		$re         = $this->text;
		$this->text = (string)$newText;
		return $re;
	}

	/**
	 * @param $class
	 *
	 * @return attribute
	 */
	public function _addClass($class){
		if(isset($this->attributes['class'])){
			$class  .= ' '.$class;
		}
		return $this->__call('class',[$class]);
	}

	/**
	 * @param $class
	 *
	 * @return $this
	 */
	public function _unsetClass($class){
		if(isset($this->attributes['class'])){
			$classes    = explode(' ',$this->attributes['class']);
			$keys   = array_keys($classes);
			$count  = count($classes);
			for($i  = 0;$i < $count;$i++){
			    $key= $keys[$i];
			    if($classes[$key] == $class){
				    unset($classes[$key]);
			    }
			}
			$this->attributes['class']  = implode(' ',$classes);
		}
		return $this;
	}
}