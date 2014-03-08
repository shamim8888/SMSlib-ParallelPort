<?php
/**
* @file $Id: Referrals.php 573 2007-06-05 08:11:06Z focus-sis $
* @package Focus/SIS
* @copyright Copyright (C) 2006 Andrew Schmadeke. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.txt
* Focus/SIS is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.txt for copyright notices and details.
*/

if($_REQUEST['month_values'] && $_POST['month_values'])
{
	foreach($_REQUEST['month_values'] as $column=>$value)
	{
		$_REQUEST['values'][$column] = $_REQUEST['day_values'][$column].'-'.$value.'-'.$_REQUEST['year_values'][$column];
		if($_REQUEST['values'][$column]=='--')
			$_REQUEST['values'][$column] = '';
	}
	$_POST['values'] = $_REQUEST['values'];
}

if($_REQUEST['values'] && $_POST['values'])
{
	$sql = "UPDATE DISCIPLINE_REFERRALS SET ";

	$go = 0;

	foreach($_REQUEST['values'] as $column_name=>$value)
	{
		if(!is_array($value))
			$sql .= "$column_name='".str_replace("\'","''",str_replace("&rsquo;","''",$value))."',";
		else
		{
			$sql .= $column_name."='||";
			foreach($value as $val)
			{
				if($val)
					$sql .= str_replace('&quot;','"',$val).'||';
			}
			$sql .= "',";
		}
	}
	$sql = substr($sql,0,-1) . " WHERE ID='$_REQUEST[referral_id]'";

	DBQuery($sql);
	unset($_REQUEST['values']);
	unset($_SESSION['_REQUEST_vars']['values']);
}

DrawHeader(ProgramTitle());

if($_REQUEST['modfunc']=='remove')
{
	if(DeletePrompt(_('referral')))
	{
		DBQuery("DELETE FROM DISCIPLINE_REFERRALS WHERE ID='$_REQUEST[id]'");
		unset($_REQUEST['modfunc']);
	}
}

$categories_RET = DBGet(DBQuery("SELECT df.ID,du.TITLE FROM DISCIPLINE_FIELDS df,DISCIPLINE_FIELD_USAGE du WHERE df.DATA_TYPE!='textarea' AND du.SYEAR='".UserSyear()."' AND du.SCHOOL_ID='".UserSchool()."' AND du.DISCIPLINE_FIELD_ID=df.ID ORDER BY du.SORT_ORDER"));

Widgets('all');

$extra['SELECT'] = ',dr.*';
if(strpos($extra['FROM'],'DISCIPLINE_REFERRALS')===false)
{
	$extra['FROM'] .= ',DISCIPLINE_REFERRALS dr ';
	$extra['WHERE'] .= ' AND dr.STUDENT_ID=ssm.STUDENT_ID AND dr.SYEAR=ssm.SYEAR AND dr.SCHOOL_ID=ssm.SCHOOL_ID ';
}

$extra['ORDER_BY'] = 'dr.ENTRY_DATE DESC,s.LAST_NAME,s.FIRST_NAME,s.MIDDLE_NAME';

$extra['columns_after'] = array('STAFF_ID'=>_('Reporter'),'ENTRY_DATE'=>_('Incident Date'));
$extra['functions'] = array('STAFF_ID'=>'GetTeacher','ENTRY_DATE'=>'ProperDate');
foreach($categories_RET as $category)
{
	$extra['columns_after']['CATEGORY_'.$category['ID']] = $category['TITLE'];
	$extra['functions']['CATEGORY_'.$category['ID']] = '_make';
}
$extra['new'] = true;
//$extra['force_search'] = true;
$extra['singular'] = _('Referral');
$extra['plural'] = _('Referrals');
$extra['link']['FULL_NAME']['link'] = "Modules.php?modname=$_REQUEST[modname]";
$extra['link']['FULL_NAME']['variables'] = array('referral_id'=>'ID');
$extra['link']['remove']['link'] = "Modules.php?modname=$_REQUEST[modname]&modfunc=remove";
$extra['link']['remove']['variables'] = array('id'=>'ID');

if($_REQUEST['search_modfunc']=='list' && $_REQUEST['student_header']=='true')
	DrawStudentHeader();

if($_REQUEST['student_header']=='true')
{
	$extra['NoSearchTerms'] = true;
	if(AllowUse('Discipline/MakeReferral.php'))
		$add_link = button('add',_('Add Referral'),"Modules.php?modname=Discipline/MakeReferral.php&search_modfunc=result&student_id=".UserStudentID());
	DrawHeader('',$add_link);
}

if(!$_REQUEST['referral_id'] && !$_REQUEST['modfunc'])
	Search('student_id',$extra);
elseif(!$_REQUEST['modfunc'])
{
	$RET = DBGet(DBQuery("SELECT * FROM DISCIPLINE_REFERRALS WHERE ID='".$_REQUEST['referral_id']."'"));
	$RET = $RET[1];

	echo "<FORM action=Modules.php?modname=$_REQUEST[modname]&referral_id=$_REQUEST[referral_id] method=POST>";
	DrawHeader('',SubmitButton(_('Save')));
	echo '<BR>';
	PopTable('header',_('Referral'));
	$categories_RET = DBGet(DBQuery("SELECT df.ID,df.DATA_TYPE,du.TITLE,du.SELECT_OPTIONS FROM DISCIPLINE_FIELDS df,DISCIPLINE_FIELD_USAGE du WHERE du.SYEAR='".UserSyear()."' AND du.SCHOOL_ID='".UserSchool()."' AND du.DISCIPLINE_FIELD_ID=df.ID ORDER BY du.SORT_ORDER"));

	echo '<TABLE width=100%>';
	echo '<TR><TD align='.ALIGN_RIGHT.' valign=top width=30><font color=gray>'._('Student').'</font></TD><TD style="border:1; border-style:none none solid none;">';
	$name = DBGet(DBQuery("SELECT FIRST_NAME,LAST_NAME,MIDDLE_NAME,NAME_SUFFIX FROM STUDENTS WHERE STUDENT_ID='".$RET['STUDENT_ID']."'"));
	echo $name[1]['FIRST_NAME'].'&nbsp;'.($name[1]['MIDDLE_NAME']?$name[1]['MIDDLE_NAME'].' ':'').$name[1]['LAST_NAME'].'&nbsp;'.$name[1]['NAME_SUFFIX'];
	echo '</TD></TR>';

	echo '<TR><TD align='.ALIGN_RIGHT.' valign=top width=30><font color=gray>Reporter</font></TD><TD style="border:1; border-style:none none solid none;">';
	$users_RET = DBGet(DBQuery("SELECT STAFF_ID,FIRST_NAME,LAST_NAME,MIDDLE_NAME FROM USERS WHERE SYEAR='".UserSyear()."' AND SCHOOLS LIKE '%,".UserSchool().",%' AND PROFILE IN ('admin','teacher') ORDER BY LAST_NAME,FIRST_NAME,MIDDLE_NAME"));
	foreach($users_RET as $user)
		$options[$user['STAFF_ID']] = $user['LAST_NAME'].', '.$user['FIRST_NAME'].' '.$user['MIDDLE_NAME'];
	echo SelectInput($RET['STAFF_ID'],'values[STAFF_ID]','',$options);
	echo '</TD></TR>';
	echo '<TR><TD align='.ALIGN_RIGHT.' valign=top width=30><font color=gray>'._('Incident Date').'</font></TD><TD style="border:1; border-style:none none solid none;">';
	echo DateInput($RET['ENTRY_DATE'],'values[ENTRY_DATE]');
	echo '</TD></TR>';
	foreach($categories_RET as $category)
	{
		echo '<TR><TD align='.ALIGN_RIGHT.' valign=top width=30><font color=gray>'.$category['TITLE'].'</font></TD><TD style="border:1; border-style:none none solid none;">';
		switch($category['DATA_TYPE'])
		{
			case 'text':
				echo TextInput($RET['CATEGORY_'.$category['ID']],'values[CATEGORY_'.$category['ID'].']');
				//echo '<INPUT type=TEXT name=values[CATEGORY_'.$category['ID'].'] value="'.$RET['CATEGORY_'.$category['ID']].'" maxlength=255>';
			break;

			case 'numeric':
				echo TextInput($RET['CATEGORY_'.$category['ID']],'values[CATEGORY_'.$category['ID'].']','','size=4 maxlength=10');
				//echo '<INPUT type=TEXT name=values[CATEGORY_'.$category['ID'].'] value="'.$RET['CATEGORY_'.$category['ID']].'" size=4 maxlength=10>';
			break;

			case 'textarea':
				echo TextAreaInput($RET['CATEGORY_'.$category['ID']],'values[CATEGORY_'.$category['ID'].']','',(!$_REQUEST['_FOCUS_PDF']?'rows=4 cols=30':'rows=4 cols=100'));
				//echo '<TEXTAREA name=values[CATEGORY_'.$category['ID'].'] rows=4 cols=30>'.$RET['CATEGORY_'.$category['ID']].'</TEXTAREA>';
			break;

			case 'checkbox':
				echo CheckboxInput($RET['CATEGORY_'.$category['ID']],'values[CATEGORY_'.$category['ID'].']');
				//echo '<INPUT type=CHECKBOX name=values[CATEGORY_'.$category['ID'].'] value=Y'.($RET['CATEGORY_'.$category['ID']]=='Y'?' CHECKED':'').'>';
			break;

			case 'date':
				echo DateInput($RET['CATEGORY_'.$category['ID']],'values[CATEGORY_'.$category['ID'].']');
				//echo PrepareDate($RET['CATEGORY_'.$category['ID']],'_values[CATEGORY_'.$category['ID'].']');
			break;

			case 'multiple_checkbox':
				if(AllowEdit() && !$_REQUEST['_FOCUS_PDF'])
				{
					echo "<DIV id='divvalues[CATEGORY_".$category['ID'].']'."'><div onclick='javascript:addHTML(\"";
					$category['SELECT_OPTIONS'] = str_replace("\n","\r",str_replace("\r\n","\r",$category['SELECT_OPTIONS']));
					$options = explode("\r",$category['SELECT_OPTIONS']);

					echo '<TABLE border=0 cellpadding=3><TR>';
					$i = 0;
					foreach($options as $option)
					{
						if($i%3==0)
							echo '</TR><TR>';
						echo '<TD><INPUT type=checkbox name=values[CATEGORY_'.$category['ID'].'][] value=\"'.str_replace('"','&quot;',str_replace("'",'&rsquo;',$option)).'\"'.(strpos($RET['CATEGORY_'.$category['ID']],str_replace('"','&quot;',str_replace("'",'&rsquo;',$option)))!==false?' CHECKED':'').'><small>'.str_replace("'",'&rsquo;',$option).'</small></TD>';
						$i++;
					}
					echo '</TR></TABLE>';
					echo "\",\"divvalues[CATEGORY_".$category['ID'].']'."\",true);' >".(($RET['CATEGORY_'.$category['ID']]!='')?str_replace('"','&rdquo;',str_replace('||',', ',substr($RET['CATEGORY_'.$category['ID']],2,-2))):'-')."</div></DIV>";
				}
				else
					echo (($RET['CATEGORY_'.$category['ID']]!='')?str_replace('"','&rdquo;',str_replace('||',', ',substr($RET['CATEGORY_'.$category['ID']],2,-2))):'-');
			break;

			case 'multiple_radio':
				if(AllowEdit() && !$_REQUEST['_FOCUS_PDF'])
				{
					echo "<DIV id='divvalues[CATEGORY_".$category['ID'].']'."'><div onclick='javascript:addHTML(\"";
					$category['SELECT_OPTIONS'] = str_replace("\n","\r",str_replace("\r\n","\r",$category['SELECT_OPTIONS']));
					$options = explode("\r",$category['SELECT_OPTIONS']);

					echo '<TABLE border=0 cellpadding=3><TR>';
					$i = 0;
					foreach($options as $option)
					{
						if($i%3==0)
							echo '</TR><TR>';
						echo '<TD><INPUT type=radio name=values[CATEGORY_'.$category['ID'].'] value=\"'.str_replace('"','&quot;',str_replace("'",'&rsquo;',$option)).'\"'.($RET['CATEGORY_'.$category['ID']]==str_replace('"','&quot;',str_replace("'",'&rsquo;',$option))?' CHECKED':'').'><small>'.str_replace("'",'&rsquo;',$option).'</small></TD>';
						$i++;
					}
					echo '</TR></TABLE>';
					echo "\",\"divvalues[CATEGORY_".$category['ID'].']'."\",true);' >".(($RET['CATEGORY_'.$category['ID']]!='')?str_replace('"','&rdquo;',$RET['CATEGORY_'.$category['ID']]):'-')."</div></DIV>";
				}
				else
					echo (($RET['CATEGORY_'.$category['ID']]!='')?str_replace('"','&rdquo;',$RET['CATEGORY_'.$category['ID']]):'-');
			break;

			case 'select':
				$options = array();
				$category['SELECT_OPTIONS'] = str_replace("\n","\r",str_replace("\r\n","\r",$category['SELECT_OPTIONS']));
				$select_options = explode("\r",$category['SELECT_OPTIONS']);
				foreach($select_options as $option)
					$options[$option] = $option;
				echo SelectInput($RET['CATEGORY_'.$category['ID']],'values[CATEGORY_'.$category['ID'].']','',$options);
				/*
				echo '<SELECT name=values[CATEGORY_'.$category['ID'].']><OPTION value="">N/A';
				foreach($options as $option)
				{
					echo '<OPTION value="'.str_replace('"','&quot;',$option).'"'.($RET['CATEGORY_'.$category['ID']]==str_replace('"','&quot;',$option)?' SELECTED':'').'>'.$option.'</OPTION>';
				}
				*/
			break;
		}
		echo '</TD></TR>';
	}
	echo '</TABLE>';
	if(AllowEdit())
		echo '<CENTER><INPUT type=submit value='._('Save').'></CENTER>';
	PopTable('footer');
	echo '</FORM>';
}

function _make($value,$column)
{
	if(substr_count($value,'-')==2 && VerifyDate($value))
		$value = ProperDate($value);
	elseif(is_numeric($value))
		$value = ((strpos($value,'.')===false)?$value:rtrim(rtrim($value,'0'),'.'));
	return str_replace('||',',<BR>',trim($value,'|'));
}
?>