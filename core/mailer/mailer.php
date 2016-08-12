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

namespace core\mailer;


use core\validate\validator;
use core\validate\validators\email;

/**
 * Class mailer
 * @package core\mailer
 */
class mailer {
	/**
	 * @var
	 */
	protected $template;
	/**
	 * @var
	 */
	protected $values;
	/**
	 * @var
	 */
	protected $subject;
	/**
	 * @var array
	 */
	protected $to   = [];
	/**
	 * @var null|string
	 */
	protected $from;
	/**
	 * @var null|string
	 */
	protected $from_name;
	/**
	 * @var
	 */
	protected $cc;
	/**
	 * @var
	 */
	protected $bcc;

	/**
	 * mailer constructor.
	 *
	 * @param      $subject
	 * @param null $from
	 * @param null $from_name
	 * @throws mailerException
	 */
	public function __construct($subject,$from = null,$from_name = null) {
		if($from === null){
			$from   = mail_from;
		}
		if($from_name === null){
			$from_name  = mail_from_name;
		}
		if(validator::validate($from,new email())){
			$this->from     = $from;
			$this->subject  = $subject;
			$this->from_name= $from_name;
		}else{
			throw new mailerException('unValidMailAddress',$from);
		}
	}

	/**
	 * @param        $mail
	 * @param string $name
	 *
	 * @return bool
	 */
	public function to($mail,$name = ''){
		if(validator::validate($mail,new email())){
			$this->to[$mail]    = $name;
			return true;
		}
		return false;
	}

	/**
	 * @param $mail
	 *
	 * @return void
	 */
	public function unto($mail){
		unset($this->to[$mail]);
	}

	/**
	 * @param $mail
	 *
	 * @return bool
	 */
	public function getName($mail){
		if(isset($this->to[$mail])){
			return $this->to[$mail];
		}
		return false;
	}

	/**
	 * @param $list
	 *
	 * @return array
	 */
	public function toList($list){
		$keys   = array_keys($list);
		$count  = count($list);
		$re     = [];
		for($i  = 0;$i < $count;$i++){
			$re[$keys[$i]]  = $this->to($keys[$i],$list[$keys[$i]]);
		}
		return $re;
	}

	/**
	 * @return mixed
	 */
	public function getBcc() {
		return $this->bcc;
	}

	/**
	 * @return mixed
	 */
	public function getCc() {
		return $this->cc;
	}

	/**
	 * @return null|string
	 */
	public function getFrom() {
		return $this->from;
	}

	/**
	 * @return mixed
	 */
	public function getSubject() {
		return $this->subject;
	}

	/**
	 * @return mixed
	 */
	public function getTemplate() {
		return $this->template;
	}

	/**
	 * @return array
	 */
	public function getTo() {
		return $this->to;
	}

	/**
	 * @param $bcc
	 *
	 * @return void
	 */
	public function setBcc($bcc) {
		$this->bcc = $bcc;
	}

	/**
	 * @param $cc
	 *
	 * @return void
	 */
	public function setCc($cc) {
		$this->cc = $cc;
	}

	/**
	 * @param $from
	 *
	 * @return bool
	 * @throws mailerException
	 */
	public function setFrom($from) {
		if(validator::validate($from,new email())){
			$this->from = $from;
			return true;
		}
		throw new mailerException('unValidMailAddress',$from);
	}

	/**
	 * @param $subject
	 *
	 * @return void
	 */
	public function setSubject($subject) {
		$this->subject = $subject;
	}

	/**
	 * @param $template
	 *
	 * @return void
	 */
	public function setTemplate($template) {
		$this->template = $template;
	}

	/**
	 * @param $file
	 *
	 * @return void
	 */
	public function setTemplateFromFile($file){
		$this->template = file_get_contents($file);
	}

	/**
	 * @param $name
	 * @param $value
	 *
	 * @return void
	 */
	public function set($name,$value){
		$this->values[$name]    = $value;
	}

	/**
	 * @param $name
	 *
	 * @return bool
	 */
	public function get($name){
		if(isset($this->values[$name])){
			return $this->values[$name];
		}
		return false;
	}

	/**
	 * @param $name
	 * @param $value
	 *
	 * @return void
	 */
	public function __set($name, $value) {
		$this->set($name,$value);
	}

	/**
	 * @param $name
	 *
	 * @return bool
	 */
	public function __get($name) {
		return $this->get($name);
	}

	/**
	 * @param $name
	 *
	 * @return void
	 */
	public function __unset($name) {
		unset($this->values[$name]);
	}

	/**
	 * @param $name
	 *
	 * @return bool
	 */
	public function __isset($name) {
		return isset($this->values[$name]);
	}

	/**
	 * @return string
	 */
	protected function _to(){
		$mails  = array_keys($this->to);
		$count  = count($this->to);
		$re     = '';
		for($i  = 0;$i < $count;$i++){
			$name   = $this->to[$mails[$i]];
			$mail   = $mails[$i];
			if(empty($name)){
				$name   = ucwords(substr($mail,0,strpos($mails,'@')));
			}
			$re    .= $name.' <'.$mail.'>, ';
		}
		return trim($re,', ');
	}

	/**
	 * @return string
	 */
	protected function _header(){
		$headers    = 'MIME-Version: 1.0' . "\r\n";
		$headers   .= 'Content-type: text/html; charset=utf-8' . "\r\n";
		$headers   .= 'To: '.$this->_to(). "\r\n";
		$headers   .= 'From: '.$this->from_name.' <'.$this->from.'>'. "\r\n";
		if(!empty($this->cc)){
			$headers   .= 'Cc: '.$this->cc. "\r\n";
		}
		if(!empty($this->bcc)){
			$headers   .= 'Bcc: '.$this->bcc. "\r\n";
		}
		return $headers;
	}

	/**
	 * @return mixed
	 */
	protected function _compileTemplate(){
		return preg_replace_callback('/\{\{(\w+?)\}\}/',function($matches){
			if(isset($this->values[$matches[1]])){
				return $this->values[$matches[1]];
			}
			return '';
		},$this->template);
	}

	/**
	 * @return bool
	 */
	public function send(){
		$to = implode(', ',array_keys($this->to));
		return mail($to,$this->subject,$this->_compileTemplate(),$this->_header());
	}
}
//TODO add mime supports