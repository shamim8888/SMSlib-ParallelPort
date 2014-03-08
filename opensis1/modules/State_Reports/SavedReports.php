<?php
/**
* @file $Id: SavedReports.php 405 2007-01-22 21:10:19Z focus-sis $
* @package Focus/SIS
* @copyright Copyright (C) 2006 Andrew Schmadeke. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.txt
* Focus/SIS is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.txt for copyright notices and details.
*/

if($_REQUEST['modfunc']=='new')
{
	DBQuery("INSERT INTO SAVED_REPORTS (ID,TITLE,STAFF_ID,PHP_SELF,SEARCH_PHP_SELF,SEARCH_VARS) values(".db_seq_nextval('SAVED_REPORTS_SEQ').",'Untitled','".User('STAFF_ID')."','".PreparePHP_SELF($_SESSION['_REQUEST_vars'])."','".$_SESSION['Search_PHP_SELF']."','".serialize($_SESSION['Search_vars'])."')");
	unset($_REQUEST['modfunc']);
	unset($_SESSION['_REQUEST_vars']['modfunc']);
	echo '<script language=JavaScript>parent.side.location="'.$_SESSION['Side_PHP_SELF'].'?modcat=Reports";</script>';			
}

if($_REQUEST['values'] && $_POST['values'] && AllowEdit())
{
	foreach($_REQUEST['values'] as $id=>$columns)
	{		
		$sql = "UPDATE SAVED_REPORTS SET ";
						
		foreach($columns as $column=>$value)
		{
			$sql .= $column."='".str_replace("\'","''",$value)."',";
		}
		$sql = substr($sql,0,-1) . " WHERE ID='$id'";
		DBQuery($sql);
	}
	echo '<script language=JavaScript>parent.side.location="'.$_SESSION['Side_PHP_SELF'].'?modcat=Reports";</script>';			
}

if($_REQUEST['profiles'] && $_POST['profiles'] && AllowEdit())
{
	$profiles_RET = DBGet(DBQuery("SELECT ID,TITLE FROM USER_PROFILES"));
	$reports_RET = DBGet(DBQuery("SELECT ID FROM SAVED_REPORTS"));

	foreach($reports_RET as $report_id)
	{
		$report_id = $report_id['ID'];

		if(!$exceptions_RET[$report_id])
			$exceptions_RET[$report_id] = DBGet(DBQuery("SELECT PROFILE_ID,CAN_USE,CAN_EDIT FROM PROFILE_EXCEPTIONS WHERE MODNAME='State_Reports/RunReport.php?report_id=$report_id'"),array(),array('PROFILE_ID'));
		$modname = "State_Reports/RunReport.php?id=$report_id";
		foreach($profiles_RET as $profile)
		{
			$profile_id = $profile['ID'];
			if(!count($exceptions_RET[$report_id][$profile_id]) && !$_REQUEST['profiles'][$report_id][$profile_id])
				DBQuery("INSERT INTO PROFILE_EXCEPTIONS (PROFILE_ID,MODNAME) values('".$profile_id."','$modname')");
			elseif(count($exceptions_RET[$report_id][$profile_id]) && !$exceptions_RET[$report_id][$profile_id][1]['CAN_EDIT'] && $_REQUEST['profiles'][$report_id][$profile_id])
				DBQuery("DELETE FROM PROFILE_EXCEPTIONS WHERE PROFILE_ID='".$profile_id."' AND MODNAME='$modname'");
			elseif(count($exceptions_RET[$report_id][$profile_id]) && $_REQUEST['profiles'][$report_id][$profile_id])
				DBQuery("UPDATE PROFILE_EXCEPTIONS SET CAN_USE=NULL WHERE PROFILE_ID='".$profile_id."' AND MODNAME='$modname'");
		
			if(!$_REQUEST['profiles'][str_replace('.','_',$modname)])
			{
				$update = "UPDATE PROFILE_EXCEPTIONS SET ";
				if(!$_REQUEST['can_use'][str_replace('.','_',$modname)])
					$update .= "CAN_USE='N'";
				$update .= " WHERE PROFILE_ID='$profile_id' AND MODNAME='State_Reports/RunReport.php?id=$report_id'";
				DBQuery($update);
			}
		}
	}
}

DrawHeader(ProgramTitle());

if($_REQUEST['modfunc']=='remove' && AllowEdit())
{
	if(DeletePrompt(_('saved report')))
	{
		DBQuery("DELETE FROM SAVED_REPORTS WHERE ID='$_REQUEST[id]'");
		unset($_REQUEST['modfunc']);
		echo '<script language=JavaScript>parent.side.location="'.$_SESSION['Side_PHP_SELF'].'?modcat=Reports";</script>';			
	}
}

if($_REQUEST['modfunc']!='remove')
{
	$sql = "SELECT ID,TITLE,'' AS TITLE__2,PHP_SELF,'' AS PUBLISHING FROM SAVED_REPORTS ORDER BY TITLE";
	$QI = DBQuery($sql);
	$RET = DBGet($QI,array('TITLE'=>'_makeTextInput','PHP_SELF'=>'_makeProgram','PUBLISHING'=>'_makePublishing'));

	$columns = array('TITLE'=>_('Title'),'PHP_SELF'=>_('Program'),'PUBLISHING'=>_('Publishing Options'));
	$link['remove']['link'] = "Modules.php?modname=$_REQUEST[modname]&modfunc=remove";
	$link['remove']['variables'] = array('id'=>'ID');
	
	echo "<FORM action=Modules.php?modname=$_REQUEST[modname]&modfunc=update method=POST>";
	DrawHeader('',SubmitButton(_('Save')));
	ListOutput($RET,$columns,_('Saved Report'),_('Saved Reports'),$link);
	echo '<CENTER>'.SubmitButton(_('Save')).'</CENTER>';
	echo '</FORM>';
}

function _makeTextInput($value,$name)
{	global $THIS_RET;
	
	if($THIS_RET['ID'])
		$id = $THIS_RET['ID'];
	else
		$id = 'new';
	
	if($name=='TITLE' && $value=='Untitled')
		$div = false;
	else
		$div = true;
	$return = '<TABLE width=100% border=0 cellpadding=0 cellspacing=0 class=innerLO_field><TR><TD>';
	$return .= TextInput($value,'values['.$id.']['.$name.']','',$extra,$div);
	$return .= '</TD><TD align='.ALIGN_RIGHT.'><A HREF=Modules.php?modname=State_Reports/RunReport.php?id='.$id.'><IMG SRC=assets/next.gif width=10 border=0></TD></TR></TABLE>';
	return $return;
}

function _makeProgram($value,$name)
{
	if(strpos($value,'&'))
		$modname = substr($value,20,strpos($value,'&')-20);
	else
		$modname = substr($value,20);

	return ProgramTitle($modname);
}

function _makePublishing($value,$name)
{	global $THIS_RET,$profiles_RET,$schools_RET;
	
	if(!$profiles_RET)
		$profiles_RET = DBGet(DBQuery("SELECT ID,TITLE FROM USER_PROFILES"));

	$exceptions_RET = DBGet(DBQuery("SELECT CAN_EDIT,CAN_USE,PROFILE_ID FROM PROFILE_EXCEPTIONS WHERE MODNAME='State_Reports/RunReport.php?id=$THIS_RET[ID]'"),array(),array('PROFILE_ID'));

	$return = '<TABLE border=0 cellspacing=0 cellpadding=0 class=innerLO_field><TR><TD colspan=5><b>'._('Profiles').': </b></TD></TR>';
	foreach($profiles_RET as $profile)
	{
		$i++;
		$return .= '<TD><INPUT type=checkbox name=profiles['.$THIS_RET['ID'].']['.$profile['ID'].'] value=Y'.($exceptions_RET[$profile['ID']][1]['CAN_USE']=='N'?'':' CHECKED').'> '.$profile['TITLE'].'</TD>';
		if($i%5==0 && $i!=count($profile))
			$return .= '</TR><TR>';
	}
	for(;$i%5!=0;$i++)
		$return .= '<TD></TD>';
	$return .= '</TR><TR><TD colspan=5><B><A HREF=#>'._('Schools').': ...</A></B></TD></TR></TABLE>';
	return $return;
}

?>