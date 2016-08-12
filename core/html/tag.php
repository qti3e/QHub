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


class tag {

	/**
	 * @param string $text
	 *
	 * @return attribute
	 */
	public static function a($text = ''){
		return new attribute('a',true,$text);
	}

	/**
	 * @param string $text
	 *
	 * @return attribute
	 */
	public static function abbr($text = ''){
		return new attribute('abbr',true,$text);
	}

	/**
	 * @param string $text
	 *
	 * @return attribute
	 */
	public static function address($text = ''){
		return new attribute('address',true,$text);
	}

	/**
	 * @return attribute
	 */
	public static function area(){
		return new attribute('area',false);
	}

	/**
	 * @param string $text
	 *
	 * @return attribute
	 */
	public static function b($text = ''){
		return new attribute('b',true,$text);
	}

	/**
	 * @param string $href
	 *
	 * @return attribute
	 */
	public static function base($href = ''){
		return (new attribute('base',false))->href($href);
	}

	/**
	 * @param string $text
	 *
	 * @return attribute
	 */
	public static function bdo($text = ''){
		return new attribute('bdo',true,$text);
	}

	/**
	 * @param string $text
	 *
	 * @return attribute
	 */
	public static function blockquote($text = ''){
		return new attribute('blockquote',true,$text);
	}

	/**
	 * @param string $text
	 *
	 * @return attribute
	 */
	public static function body($text = ''){
		return new attribute('body',true,$text);
	}

	/**
	 * @return attribute
	 */
	public static function br(){
		return new attribute('br',false);
	}

	/**
	 * @param string $text
	 *
	 * @return attribute
	 */
	public static function button($text = ''){
		return new attribute('button',true,$text);
	}

	/**
	 * @param string $text
	 *
	 * @return attribute
	 */
	public static function caption($text = ''){
		return new attribute('caption',true,$text);
	}

	/**
	 * @param string $text
	 *
	 * @return attribute
	 */
	public static function cite($text = ''){
		return new attribute('cite',true,$text);
	}

	/**
	 * @param string $text
	 *
	 * @return attribute
	 */
	public static function code($text = ''){
		return new attribute('code',true,$text);
	}

	/**
	 * @return attribute
	 */
	public static function col(){
		return new attribute('col',false);
	}

	/**
	 * @param string $text
	 *
	 * @return attribute
	 */
	public static function colgroup($text = ''){
		return new attribute('colgroup',true,$text);
	}

	/**
	 * @param string $text
	 *
	 * @return attribute
	 */
	public static function dd($text = ''){
		return new attribute('dd',true,$text);
	}

	/**
	 * @param string $text
	 *
	 * @return attribute
	 */
	public static function del($text = ''){
		return new attribute('del',true,$text);
	}

	/**
	 * @param string $text
	 *
	 * @return attribute
	 */
	public static function dfn($text = ''){
		return new attribute('dfn',true,$text);
	}

	/**
	 * @param string $text
	 *
	 * @return attribute
	 */
	public static function div($text = ''){
		return new attribute('div',true,$text);
	}

	/**
	 * @param string $text
	 *
	 * @return attribute
	 */
	public static function dl($text = ''){
		return new attribute('dl',true,$text);
	}

	/**
	 * @param string $text
	 *
	 * @return attribute
	 */
	public static function dt($text = ''){
		return new attribute('dt',true,$text);
	}

	/**
	 * @param string $text
	 *
	 * @return attribute
	 */
	public static function em($text = ''){
		return new attribute('em',true,$text);
	}

	/**
	 * @param string $text
	 *
	 * @return attribute
	 */
	public static function fieldset($text = ''){
		return new attribute('fieldset',true,$text);
	}

	/**
	 * @param string $text
	 *
	 * @return attribute
	 */
	public static function form($text = ''){
		return new attribute('form',true,$text);
	}

	/**
	 * @param string $text
	 *
	 * @return attribute
	 */
	public static function h1($text = ''){
		return new attribute('h1',true,$text);
	}

	/**
	 * @param string $text
	 *
	 * @return attribute
	 */
	public static function h2($text = ''){
		return new attribute('h2',true,$text);
	}

	/**
	 * @param string $text
	 *
	 * @return attribute
	 */
	public static function h3($text = ''){
		return new attribute('h3',true,$text);
	}

	/**
	 * @param string $text
	 *
	 * @return attribute
	 */
	public static function h4($text = ''){
		return new attribute('h4',true,$text);
	}

	/**
	 * @param string $text
	 *
	 * @return attribute
	 */
	public static function h5($text = ''){
		return new attribute('h5',true,$text);
	}

	/**
	 * @param string $text
	 *
	 * @return attribute
	 */
	public static function h6($text = ''){
		return new attribute('h6',true,$text);
	}

	/**
	 * @param string $text
	 *
	 * @return attribute
	 */
	public static function head($text = ''){
		return new attribute('head',true,$text);
	}

	/**
	 * @return attribute
	 */
	public static function hr(){
		return new attribute('hr',false);
	}

	/**
	 * @param string $text
	 *
	 * @return attribute
	 */
	public static function html($text = ''){
		return new attribute('html',true,$text);
	}

	/**
	 * @param string $text
	 *
	 * @return attribute
	 */
	public static function i($text = ''){
		return new attribute('i',true,$text);
	}

	/**
	 * @param string $text
	 *
	 * @return attribute
	 */
	public static function iframe($text = ''){
		return new attribute('iframe',true,$text);
	}

	/**
	 * @param string $src
	 *
	 * @return attribute
	 */
	public static function img($src = ''){
		return (new attribute('img',false))->src($src);
	}

	/**
	 * @param string $type
	 *
	 * @return attribute
	 */
	public static function input($type = 'text'){
		return (new attribute('input',false))->type($type);
	}

	/**
	 * @param string $text
	 *
	 * @return attribute
	 */
	public static function ins($text = ''){
		return new attribute('ins',true,$text);
	}

	/**
	 * @param string $text
	 *
	 * @return attribute
	 */
	public static function kbd($text = ''){
		return new attribute('kbd',true,$text);
	}

	/**
	 * @param string $text
	 *
	 * @return attribute
	 */
	public static function label($text = ''){
		return new attribute('label',true,$text);
	}

	/**
	 * @param string $text
	 *
	 * @return attribute
	 */
	public static function legend($text = ''){
		return new attribute('legend',true,$text);
	}

	/**
	 * @param string $text
	 *
	 * @return attribute
	 */
	public static function li($text = ''){
		return new attribute('li',true,$text);
	}

	/**
	 * @param string $href
	 *
	 * @return attribute
	 */
	public static function link($href = ''){
		return (new attribute('link',false))->href($href);
	}

	/**
	 * @param string $text
	 *
	 * @return attribute
	 */
	public static function map($text = ''){
		return new attribute('map',true,$text);
	}

	/**
	 * @return attribute
	 */
	public static function meta(){
		return new attribute('meta',false);
	}

	/**
	 * @param string $text
	 *
	 * @return attribute
	 */
	public static function noscript($text = ''){
		return new attribute('noscript',true,$text);
	}

	/**
	 * @param string $text
	 *
	 * @return attribute
	 */
	public static function object($text = ''){
		return new attribute('object',true,$text);
	}

	/**
	 * @param string $text
	 *
	 * @return attribute
	 */
	public static function ol($text = ''){
		return new attribute('ol',true,$text);
	}

	/**
	 * @param string $text
	 *
	 * @return attribute
	 */
	public static function optgroup($text = ''){
		return new attribute('optgroup',true,$text);
	}

	/**
	 * @param string $text
	 *
	 * @return attribute
	 */
	public static function option($text = ''){
		return new attribute('option',true,$text);
	}

	/**
	 * @param string $text
	 *
	 * @return attribute
	 */
	public static function p($text = ''){
		return new attribute('p',true,$text);
	}

	/**
	 * @param $name
	 * @param $value
	 *
	 * @return attribute
	 */
	public static function param($name,$value){
		return (new attribute('param',false))->name($name)->value($value);
	}

	/**
	 * @param string $text
	 *
	 * @return attribute
	 */
	public static function pre($text = ''){
		return new attribute('pre',true,$text);
	}

	/**
	 * @param string $text
	 *
	 * @return attribute
	 */
	public static function q($text = ''){
		return new attribute('q',true,$text);
	}

	/**
	 * @param string $text
	 *
	 * @return attribute
	 */
	public static function s($text = ''){
		return new attribute('s',true,$text);
	}

	/**
	 * @param string $text
	 *
	 * @return attribute
	 */
	public static function samp($text = ''){
		return new attribute('samp',true,$text);
	}

	/**
	 * @param string $text
	 *
	 * @return attribute
	 */
	public static function script($text = ''){
		return new attribute('script',true,$text);
	}

	/**
	 * @param string $text
	 *
	 * @return attribute
	 */
	public static function select($text = ''){
		return new attribute('select',true,$text);
	}

	/**
	 * @param string $text
	 *
	 * @return attribute
	 */
	public static function small($text = ''){
		return new attribute('small',true,$text);
	}

	/**
	 * @param string $text
	 *
	 * @return attribute
	 */
	public static function span($text = ''){
		return new attribute('span',true,$text);
	}

	/**
	 * @param string $text
	 *
	 * @return attribute
	 */
	public static function strong($text = ''){
		return new attribute('strong',true,$text);
	}

	/**
	 * @param string $text
	 *
	 * @return attribute
	 */
	public static function style($text = ''){
		return new attribute('style',true,$text);
	}

	/**
	 * @param string $text
	 *
	 * @return attribute
	 */
	public static function sub($text = ''){
		return new attribute('sub',true,$text);
	}

	/**
	 * @param string $text
	 *
	 * @return attribute
	 */
	public static function sup($text = ''){
		return new attribute('sup',true,$text);
	}

	/**
	 * @param string $text
	 *
	 * @return attribute
	 */
	public static function table($text = ''){
		return new attribute('table',true,$text);
	}

	/**
	 * @param string $text
	 *
	 * @return attribute
	 */
	public static function tbody($text = ''){
		return new attribute('tbody',true,$text);
	}

	/**
	 * @param string $text
	 *
	 * @return attribute
	 */
	public static function td($text = ''){
		return new attribute('td',true,$text);
	}

	/**
	 * @param string $text
	 *
	 * @return attribute
	 */
	public static function textarea($text = ''){
		return new attribute('textarea',true,$text);
	}

	/**
	 * @param string $text
	 *
	 * @return attribute
	 */
	public static function tfoot($text = ''){
		return new attribute('tfoot',true,$text);
	}

	/**
	 * @param string $text
	 *
	 * @return attribute
	 */
	public static function th($text = ''){
		return new attribute('th',true,$text);
	}

	/**
	 * @param string $text
	 *
	 * @return attribute
	 */
	public static function thead($text = ''){
		return new attribute('thead',true,$text);
	}

	/**
	 * @param string $text
	 *
	 * @return attribute
	 */
	public static function title($text = ''){
		return new attribute('title',true,$text);
	}

	/**
	 * @param string $text
	 *
	 * @return attribute
	 */
	public static function tr($text = ''){
		return new attribute('tr',true,$text);
	}

	/**
	 * @param string $text
	 *
	 * @return attribute
	 */
	public static function u($text = ''){
		return new attribute('u',true,$text);
	}

	/**
	 * @param string $text
	 *
	 * @return attribute
	 */
	public static function ul($text = ''){
		return new attribute('ul',true,$text);
	}

	/**
	 * @param string $text
	 *
	 * @return attribute
	 */
	public static function article($text = ''){
		return new attribute('article',true,$text);
	}

	/**
	 * @param string $text
	 *
	 * @return attribute
	 */
	public static function aside($text = ''){
		return new attribute('aside',true,$text);
	}

	/**
	 * @param string $text
	 *
	 * @return attribute
	 */
	public static function audio($text = ''){
		return new attribute('audio',true,$text);
	}

	/**
	 * @param string $text
	 *
	 * @return attribute
	 */
	public static function bdi($text = ''){
		return new attribute('bdi',true,$text);
	}

	/**
	 * @param string $text
	 *
	 * @return attribute
	 */
	public static function canvas($text = ''){
		return new attribute('canvas',true,$text);
	}

	/**
	 * @param string $text
	 *
	 * @return attribute
	 */
	public static function CORS($text = ''){
		return new attribute('CORS',true,$text);
	}

	/**
	 * @param string $text
	 *
	 * @return attribute
	 */
	public static function data($text = ''){
		return new attribute('data',true,$text);
	}

	/**
	 * @param string $text
	 *
	 * @return attribute
	 */
	public static function datalist($text = ''){
		return new attribute('datalist',true,$text);
	}

	/**
	 * @param string $text
	 *
	 * @return attribute
	 */
	public static function details($text = ''){
		return new attribute('details',true,$text);
	}

	/**
	 * @param string $text
	 *
	 * @return attribute
	 */
	public static function dialog($text = ''){
		return new attribute('dialog',true,$text);
	}

	/**
	 * @param string $text
	 *
	 * @return attribute
	 */
	public static function element($text = ''){
		return new attribute('element',true,$text);
	}

	/**
	 * @param string $text
	 *
	 * @return attribute
	 */
	public static function embed($text = ''){
		return new attribute('embed',true,$text);
	}

	/**
	 * @param string $text
	 *
	 * @return attribute
	 */
	public static function figcaption($text = ''){
		return new attribute('figcaption',true,$text);
	}

	/**
	 * @param string $text
	 *
	 * @return attribute
	 */
	public static function figure($text = ''){
		return new attribute('figure',true,$text);
	}

	/**
	 * @param string $text
	 *
	 * @return attribute
	 */
	public static function footer($text = ''){
		return new attribute('footer',true,$text);
	}

	/**
	 * @param string $text
	 *
	 * @return attribute
	 */
	public static function header($text = ''){
		return new attribute('header',true,$text);
	}

	/**
	 * @param string $text
	 *
	 * @return attribute
	 */
	public static function main($text = ''){
		return new attribute('main',true,$text);
	}

	/**
	 * @param string $text
	 *
	 * @return attribute
	 */
	public static function mark($text = ''){
		return new attribute('mark',true,$text);
	}

	/**
	 * @param string $text
	 *
	 * @return attribute
	 */
	public static function menu($text = ''){
		return new attribute('menu',true,$text);
	}

	/**
	 * @param string $text
	 *
	 * @return attribute
	 */
	public static function menuitem($text = ''){
		return new attribute('menuitem',true,$text);
	}

	/**
	 * @param string $text
	 *
	 * @return attribute
	 */
	public static function meter($text = ''){
		return new attribute('meter',true,$text);
	}

	/**
	 * @param string $text
	 *
	 * @return attribute
	 */
	public static function nav($text = ''){
		return new attribute('nav',true,$text);
	}

	/**
	 * @param string $text
	 *
	 * @return attribute
	 */
	public static function output($text = ''){
		return new attribute('output',true,$text);
	}

	/**
	 * @param string $text
	 *
	 * @return attribute
	 */
	public static function picture($text = ''){
		return new attribute('picture',true,$text);
	}

	/**
	 * @param string $text
	 *
	 * @return attribute
	 */
	public static function progress($text = ''){
		return new attribute('progress',true,$text);
	}

	/**
	 * @param string $text
	 *
	 * @return attribute
	 */
	public static function rp($text = ''){
		return new attribute('rp',true,$text);
	}

	/**
	 * @param string $text
	 *
	 * @return attribute
	 */
	public static function rt($text = ''){
		return new attribute('rt',true,$text);
	}

	/**
	 * @param string $text
	 *
	 * @return attribute
	 */
	public static function rtc($text = ''){
		return new attribute('rtc',true,$text);
	}

	/**
	 * @param string $text
	 *
	 * @return attribute
	 */
	public static function ruby($text = ''){
		return new attribute('ruby',true,$text);
	}

	/**
	 * @param string $text
	 *
	 * @return attribute
	 */
	public static function section($text = ''){
		return new attribute('section',true,$text);
	}

	/**
	 * @param string $text
	 *
	 * @return attribute
	 */
	public static function source($text = ''){
		return new attribute('source',true,$text);
	}

	/**
	 * @param string $text
	 *
	 * @return attribute
	 */
	public static function summary($text = ''){
		return new attribute('summary',true,$text);
	}

	/**
	 * @param string $text
	 *
	 * @return attribute
	 */
	public static function template($text = ''){
		return new attribute('template',true,$text);
	}

	/**
	 * @param string $text
	 *
	 * @return attribute
	 */
	public static function time($text = ''){
		return new attribute('time',true,$text);
	}

	/**
	 * @param string $text
	 *
	 * @return attribute
	 */
	public static function track($text = ''){
		return new attribute('track',true,$text);
	}

	/**
	 * @param string $text
	 *
	 * @return attribute
	 */
	public static function video($text = ''){
		return new attribute('video',true,$text);
	}

	/**
	 * @param string $text
	 *
	 * @return attribute
	 */
	public static function wbr($text = ''){
		return new attribute('wbr',true,$text);
	}

	/**
	 * @param string $text
	 *
	 * @return attribute
	 */
	public static function acronym($text = ''){
		return new attribute('acronym',true,$text);
	}

	/**
	 * @param string $text
	 *
	 * @return attribute
	 */
	public static function applet($text = ''){
		return new attribute('applet',true,$text);
	}

	/**
	 * @return attribute
	 */
	public static function basefont(){
		return new attribute('basefont',false);
	}

	/**
	 * @param string $text
	 *
	 * @return attribute
	 */
	public static function big($text = ''){
		return new attribute('big',true,$text);
	}

	/**
	 * @param string $text
	 *
	 * @return attribute
	 */
	public static function blink($text = ''){
		return new attribute('blink',true,$text);
	}

	/**
	 * @param string $text
	 *
	 * @return attribute
	 */
	public static function center($text = ''){
		return new attribute('center',true,$text);
	}

	/**
	 * @return attribute
	 */
	public static function command(){
		return new attribute('command',false);
	}

	/**
	 * @param string $text
	 *
	 * @return attribute
	 */
	public static function content($text = ''){
		return new attribute('content',true,$text);
	}

	/**
	 * @param string $text
	 *
	 * @return attribute
	 */
	public static function dir($text = ''){
		return new attribute('dir',true,$text);
	}

	/**
	 * @param string $text
	 *
	 * @return attribute
	 */
	public static function font($text = ''){
		return new attribute('font',true,$text);
	}

	/**
	 * @param string $src
	 *
	 * @return attribute
	 */
	public static function frame($src = ''){
		return (new attribute('frame',false))->src($src);
	}

	/**
	 * @param string $text
	 *
	 * @return attribute
	 */
	public static function frameset($text = ''){
		return new attribute('frameset',true,$text);
	}

	/**
	 * @param string $text
	 *
	 * @return attribute
	 */
	public static function hgroup($text = ''){
		return new attribute('hgroup',true,$text);
	}

	/**
	 * @return attribute
	 */
	public static function isindex(){
		return new attribute('isindex',false);
	}

	/**
	 * @param string $text
	 *
	 * @return attribute
	 */
	public static function keygen($text = ''){
		return new attribute('keygen',true,$text);
	}

	/**
	 * @param string $text
	 *
	 * @return attribute
	 */
	public static function listing($text = ''){
		return new attribute('listing',true,$text);
	}

	/**
	 * @param string $text
	 *
	 * @return attribute
	 */
	public static function marquee($text = ''){
		return new attribute('marquee',true,$text);
	}

	/**
	 * @return attribute
	 */
	public static function nextid(){
		return new attribute('nextid',false);
	}

	/**
	 * @param string $text
	 *
	 * @return attribute
	 */
	public static function noframes($text = ''){
		return new attribute('noframes',true,$text);
	}

	/**
	 * @param string $text
	 *
	 * @return attribute
	 */
	public static function plaintext($text = ''){
		return new attribute('plaintext',true,$text);
	}

	/**
	 * @param int $size
	 *
	 * @return attribute
	 */
	public static function spacer($size = 10){
		return (new attribute('spacer',false))->size($size);
	}

	/**
	 * @param string $text
	 *
	 * @return attribute
	 */
	public static function strike($text = ''){
		return new attribute('strike',true,$text);
	}

	/**
	 * @param string $text
	 *
	 * @return attribute
	 */
	public static function tt($text = ''){
		return new attribute('tt',true,$text);
	}

	/**
	 * @param string $text
	 *
	 * @return attribute
	 */
	public static function xmp($text = ''){
		return new attribute('xmp',true,$text);
	}
}