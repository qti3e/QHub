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
?>
<html>
	<head>
		<title>Internal error</title>
		<style type="text/css">
			html{
				height: 100%;
				width: 100%;
				background-color: #fff;
			}
			body{
				width: 95%;
				height: 300px;
				background-color: #ffffff;
				box-shadow: #ccc 0px 10px 20px;
				display: block;
				margin-right: auto;
				margin-left: auto;
				padding: 5px;
			}
			.error{
				background-color: #cfcfcf;
				color: #ffffff;
			}
		</style>
	</head>
	<body>
		<h1>Internal Error!</h1>
		<hr>
		<p>
			<?php echo $errorStr; ?>
		</p>
		<address>File: <?php echo $errorFile; ?> & Line <?php echo $errorLine ?></address>
		<code>
			<?php if(isset($lines[$errorLine-2])){?>
			<?php echo ($errorLine-1).substr(str_replace('&lt;?php&nbsp;','',highlight_string('<?php '.$lines[$errorLine-2],true)),6,-7); ?>
				<?php } ?>
				<b class="error">
					<?php echo $errorLine.substr(str_replace('&lt;?php&nbsp;','',highlight_string('<?php '.$line,true)),6,-7); ?>
				</b>
			<?php if(isset($lines[$errorLine])){?>
				<?php echo ($errorLine+1).substr(str_replace('&lt;?php&nbsp;','',highlight_string('<?php '.$lines[$errorLine],true)),6,-7); ?>
			<?php } ?>
		</code>
	</body>
</html>
