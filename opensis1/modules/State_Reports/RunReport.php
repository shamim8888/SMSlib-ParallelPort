<?php
/**
* @file $Id: RunReport.php 437 2007-04-23 00:57:51Z focus-sis $
* @package Focus/SIS
* @copyright Copyright (C) 2006 Andrew Schmadeke. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.txt
* Focus/SIS is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.txt for copyright notices and details.
*/

$RET = DBGet(DBQuery("SELECT ID,TITLE,PHP_SELF,SEARCH_PHP_SELF,SEARCH_VARS FROM SAVED_REPORTS WHERE ID='".$_REQUEST['id']."'"));
$RET = $RET[1];

$RET['PHP_SELF'] = str_replace('&amp;','?',substr($RET['PHP_SELF'],20));

if(strpos($RET['PHP_SELF'],'?search_modfunc=list')!==false)
	unset($_CENTRE['modules_search']);

if(strpos($RET['PHP_SELF'],'?')!==false)
{
	$vars = substr($RET['PHP_SELF'],(strpos($RET['PHP_SELF'],'?')+1));
	$modname = substr($RET['PHP_SELF'],0,strpos($RET['PHP_SELF'],'?'));
	
	$vars = explode('?',$vars);
	foreach($vars as $code)
	{
		$equals = strpos($code,'=');

		if(strpos($code,'[')!==false)
			$code = "\$_REQUEST[".ereg_replace('([^]])\[','\1][',substr($code,0,$equals))."='".urldecode(substr($code,$equals+1))."';";
		else
			$code = "\$_REQUEST['".substr($code,0,$equals)."']='".urldecode(substr($code,$equals+1))."';";
		eval($code);
	}
}
else
	$modname = $RET['PHP_SELF'];

$_SESSION['Search_PHP_SELF'] = $RET['SEARCH_PHP_SELF'];
$_SESSION['Search_vars'] = unserialize($RET['SEARCH_VARS']);

require('modules/'.$modname);
?>
