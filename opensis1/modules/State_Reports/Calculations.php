<?php
/**
* @file $Id: Calculations.php 161 2006-09-07 06:21:17Z doritojones $
* @package Focus/SIS
* @copyright Copyright (C) 2006 Andrew Schmadeke. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.txt
* Focus/SIS is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.txt for copyright notices and details.
*/

if($_REQUEST['modname']!='misc/Export.php' && $_REQUEST['modname']!='State_Reports/CalculationsReports.php')
	include_once('ProgramFunctions/ReportsCalculations.fnc.php');
if($_REQUEST['modfunc']=='XMLHttpRequest')
{
	$query = strtolower(stripslashes($_REQUEST['query']));
	$query = ereg_replace('<span id="?','<',$query);
	$query = str_replace('</span>','',$query);
	$query = ereg_replace('<img src=".*assets/blinking_cursor.gif">','',$query);
	$query = ereg_replace('"?>','>',$query);
	$query = str_replace('<b>(</b>','(',$query);
	$query = str_replace('<b>)</b>',')',$query);

	// REPLACE FUNCTION NAMES
	$query = str_replace('stdev','stats_standard_deviation',$query);
	$query = str_replace('average-min','_avg0',$query);
	$query = str_replace('average-max','_avg1',$query);
	$query = str_replace('sum-min','_sum0',$query);
	$query = str_replace('sum-max','_sum1',$query);
	$query = str_replace('average','_average',$query);
	$query = str_replace('sum','_sum',$query);
	$query = str_replace('min','_min',$query);
	$query = str_replace('max','_max',$query);

	$query = ereg_replace("([a-z_]+)\([ ]*<[a-z]+([0-9]+)>([a-z: ]+)<[a-z0-9]+>[ ]*\)","\\1(_getResults('\\3','\\2'))",$query);
	$query = ereg_replace("([a-z01_]+)\([ ]*<[a-z]+([0-9]+)>([a-z: ]+)<[a-z0-9]+>[ ]*\)","\\1(_getResults('\\3','\\2','STUDENTID'))",$query);

	$query = ereg_replace('<start[0-9]+>','',$query);
	$query = ereg_replace('<end[0-9]+> *','',$query);
	
	$query = '$result = '.$query.';if(!$result) return 0; else return $result;';
	//print_r($_REQUEST);
	/*echo '<BR>EVAL QUERY: '.
	echo '<BR>RESULTS: '.$result;
	echo '<BR>AVG PRES: '._average(_getResults('present','2'));
	echo '<PRE>'.str_replace('<','&lt;',str_replace('>','&gt;',$query)).'</PRE>';*/
	
	if($_REQUEST['breakdown'])
	{
		if($_REQUEST['breakdown']=='school')
		{
			$var = 'school';
			$group = DBGet(DBQuery("SELECT ID,TITLE FROM SCHOOLS ORDER BY TITLE"));
		}
		elseif($_REQUEST['breakdown']=='grade')
		{
			$var = 'grades';
			$schools = substr(str_replace(",","','",User('SCHOOLS')),2,-2);
			if($_REQUEST['screen'][1]['_search_all_schools']!='Y')
				$extra_schools = "WHERE SCHOOL_ID='".UserSchool()."' ";
			elseif($schools)
				$extra_schools = "WHERE SCHOOL_ID IN (".$schools.") ";
			$group_RET = DBGet(DBQuery("SELECT ID AS ID,TITLE,SHORT_NAME FROM SCHOOL_GRADELEVELS ".$extra_schools." ORDER BY SORT_ORDER"),array(),array('SHORT_NAME'));
			foreach($group_RET as $short_name=>$grades)
			{
				$i++;
				foreach($grades as $grade)
					$group[$i]['ID'] .= $grade['ID'].',';
				$group[$i]['ID'] = substr($group[$i]['ID'],0,-1);
				$group[$i]['TITLE'] = $grades[1]['TITLE'];
			}
		}
		elseif($_REQUEST['breakdown']=='stuid')
		{
			$var = 'stuid';
			$start_REQUEST = $_REQUEST;
			$_REQUEST = $_REQUEST['screen'][1];
			foreach($_REQUEST as $key=>$value)
			{
				if(substr($key,0,5)=='cust[')
				{
					$_REQUEST['cust'][substr($key,5)] = $value;
					unset($_REQUEST[$key]);
				}
				elseif(substr($key,0,8)=='test_no[')
				{
					$_REQUEST['test_no'][substr($key,8)] = $value;
					unset($_REQUEST[$key]);
				}
			}

			if($_REQUEST['stuid'])
				$extra .= " AND s.STUDENT_ID = '$_REQUEST[stuid]' ";
			if($_REQUEST['last'])
				$extra .= " AND UPPER(s.LAST_NAME) LIKE '".strtoupper($_REQUEST['last'])."%' ";
			if($_REQUEST['first'])
				$extra .= " AND UPPER(s.FIRST_NAME) LIKE '".strtoupper($_REQUEST['first'])."%' ";
			if($_REQUEST['grade'])
				$extra .= " AND ssm.GRADE_ID = '".$_REQUEST['grade']."' ";
			if($_REQUEST['school'])
				$extra .= " AND ssm.SCHOOL_ID = '".$_REQUEST['school']."' ";
			
			$extra .= CustomFields('where');
			$_REQUEST = $start_REQUEST;
			$group = DBGet(DBQuery("SELECT s.STUDENT_ID AS ID,s.LAST_NAME||', '||s.FIRST_NAME AS TITLE FROM STUDENTS s,STUDENT_ENROLLMENT ssm WHERE s.STUDENT_ID=ssm.STUDENT_ID AND ".str_replace('SCHOOL_ID','ssm.SCHOOL_ID',$extra_schools)." ssm.SYEAR='".UserSyear()."' ".$extra.' ORDER BY LAST_NAME,FIRST_NAME'));
		}
		elseif(substr($_REQUEST['breakdown'],0,6)=='CUSTOM')
		{
			if($_REQUEST['breakdown']=='CUSTOM_44')
			{
				for($i=1;$i<=15;$i++)
				{
					$_REQUEST['screen'][$i]['_search_all_schools'] = 'Y';
				}
			}
			$var = $_REQUEST['breakdown'];
			$field_id = substr($_REQUEST['breakdown'],7);
			$select_options_RET = DBGet(DBQuery("SELECT SELECT_OPTIONS FROM CUSTOM_FIELDS WHERE ID='".$field_id."'"));
			$options = str_replace("\n","\r",str_replace("\r\n","\r",$select_options_RET[1]['SELECT_OPTIONS']));
			$options = explode("\r",$options);
			$group[0] = array();
			foreach($options as $option)
				$group[] = array('ID'=>$option,'TITLE'=>$option);
			unset($group[0]);
		}
	}

	header("Content-Type: text/xml\n\n");
	echo '<?xml version="1.0" standalone="yes"?>';
	echo '<results>';
	if($_REQUEST['breakdown'])
	{
		$start_num = $num;
		foreach($group as $value)
		{
			if($_REQUEST['screen'])
			{
				for($i=1;$i<=15;$i++)
				{
					if(substr($var,0,6)=='CUSTOM')
						$_REQUEST['screen'][$i]['cust'][$var] = $value['ID'];
					else
						$_REQUEST['screen'][$i][$var] = $value['ID'];
				}
			}
/*			foreach($_REQUEST['screen'] as $key_num=>$values)
			{
				if(substr($var,0,6)=='CUSTOM')
					$_REQUEST['screen'][$key_num]['cust'][$var] = $value['ID'];
				else
					$_REQUEST['screen'][$key_num][$var] = $value['ID'];
			}
*/
			$num = $start_num;
			$val = eval($query);
			if(strpos($val,'.')!==false)
				$val = ltrim(round($val,3),'0');
			echo '<result><id>'.$value['TITLE'].'</id><title>'.$val.'</title></result>';	
		}
	}
	else
	{
		$val = eval($query);
		if(strpos($val,'.')!==false)
			$val = ltrim(round($val,3),'0');
		echo '<result><id>~</id><title>'.$val.'</title></result>';
	}
	echo '</results>';
	exit;
}
elseif($_REQUEST['modfunc']=='saveXMLHttpRequest')
{
	$location = PreparePHP_SELF();
	DBQuery("INSERT INTO SAVED_CALCULATIONS (ID,TITLE,URL) values(".db_seq_nextval('SAVED_CALCULATIONS_SEQ').",'".str_replace("'","''",$_REQUEST['calc_title'])."','".$location."')");

	header("Content-Type: text/xml\n\n");
	echo '<?xml version="1.0" standalone="yes"?>';
	echo '<results>';
	echo '<result><id>~</id><title>'._('Saved').'</title></result>';
	echo '</results>';
	exit;
}
elseif($_REQUEST['modfunc']=='echoXMLHttpRequest')
{
	$query = strtolower(stripslashes($_REQUEST['query']));
	$query = ereg_replace('<span id="?','<',$query);
	$query = str_replace('</span>','',$query);
	$query = ereg_replace('<img src=".*assets/blinking_cursor.gif">','',$query);
	$query = ereg_replace('"?>','>',$query);
	$query = str_replace('<b>(</b>','(',$query);
	$query = str_replace('<b>)</b>',')',$query);

	// REPLACE FUNCTION NAMES
	$query = str_replace('stdev','stats_standard_deviation',$query);
	$query = str_replace('average-min','_avg0',$query);
	$query = str_replace('average-max','_avg1',$query);
	$query = str_replace('sum-min','_sum0',$query);
	$query = str_replace('sum-max','_sum1',$query);
	$query = str_replace('average','_average',$query);
	$query = str_replace('sum','_sum',$query);
	$query = str_replace('min','_min',$query);
	$query = str_replace('max','_max',$query);
	
	$query = ereg_replace("([a-z_]+)\([ ]*<[a-z]+([0-9]+)>([a-z: ]+)<[a-z0-9]+>[ ]*\)","\\1(_getResults('\\3','\\2'))",$query);
	$query = ereg_replace("([a-z01_]+)\([ ]*<[a-z]+([0-9]+)>([a-z: ]+)<[a-z0-9]+>[ ]*\)","\\1(_getResults('\\3','\\2','STUDENTID'))",$query);

	$query = ereg_replace('<start[0-9]+>','',$query);
	$query = ereg_replace('<end[0-9]+> *','',$query);
	
	$query = '$result = '.$query.';if(!$result) return 0; else return $result;';
	//print_r($_REQUEST);
	/*echo '<BR>EVAL QUERY: '.
	echo '<BR>RESULTS: '.$result;
	echo '<BR>AVG PRES: '._average(_getResults('present','2'));
	echo '<PRE>'.str_replace('<','&lt;',str_replace('>','&gt;',$query)).'</PRE>';*/
	
	if($_REQUEST['breakdown'])
	{
		if($_REQUEST['breakdown']=='school')
		{
			$var_title = 'School';
			$var = 'school';
			$group = DBGet(DBQuery("SELECT ID,TITLE FROM SCHOOLS ORDER BY TITLE"));
		}
		elseif($_REQUEST['breakdown']=='grade')
		{
			$var_title = 'Grade';
			$var = 'grades';
			$schools = substr(str_replace(",","','",User('SCHOOLS')),2,-2);
			if($_REQUEST['screen'][1]['_search_all_schools']!='Y')
				$extra_schools = "WHERE SCHOOL_ID='".UserSchool()."' ";
			elseif($schools)
				$extra_schools = "WHERE SCHOOL_ID IN (".$schools.") ";
			$group_RET = DBGet(DBQuery("SELECT ID AS ID,TITLE,SHORT_NAME FROM SCHOOL_GRADELEVELS ".$extra_schools." ORDER BY SORT_ORDER"),array(),array('SHORT_NAME'));
			foreach($group_RET as $short_name=>$grades)
			{
				$i++;
				foreach($grades as $grade)
					$group[$i]['ID'] .= $grade['ID'].',';
				$group[$i]['ID'] = substr($group[$i]['ID'],0,-1);
				$group[$i]['TITLE'] = $grades[1]['TITLE'];
			}
		}
		elseif($_REQUEST['breakdown']=='stuid')
		{
			$var_title = 'Student';
			$var = 'stuid';
			$start_REQUEST = $_REQUEST;
			$_REQUEST = $_REQUEST['screen'][1];
			foreach($_REQUEST as $key=>$value)
			{
				if(substr($key,0,5)=='cust[')
				{
					$_REQUEST['cust'][substr($key,5)] = $value;
					unset($_REQUEST[$key]);
				}
				elseif(substr($key,0,8)=='test_no[')
				{
					$_REQUEST['test_no'][substr($key,8)] = $value;
					unset($_REQUEST[$key]);
				}
			}

			if($_REQUEST['stuid'])
				$extra .= " AND s.STUDENT_ID = '$_REQUEST[stuid]' ";
			if($_REQUEST['last'])
				$extra .= " AND UPPER(s.LAST_NAME) LIKE '".strtoupper($_REQUEST['last'])."%' ";
			if($_REQUEST['first'])
				$extra .= " AND UPPER(s.FIRST_NAME) LIKE '".strtoupper($_REQUEST['first'])."%' ";
			if($_REQUEST['grade'])
				$extra .= " AND ssm.GRADE_ID = '".$_REQUEST['grade']."' ";
			if($_REQUEST['school'])
				$extra .= " AND ssm.SCHOOL_ID = '".$_REQUEST['school']."' ";
			
			$extra .= CustomFields('where');
			$_REQUEST = $start_REQUEST;
			$group = DBGet(DBQuery("SELECT s.STUDENT_ID AS ID,s.LAST_NAME||', '||s.FIRST_NAME AS TITLE FROM STUDENTS s,STUDENT_ENROLLMENT ssm WHERE s.STUDENT_ID=ssm.STUDENT_ID AND ".str_replace('SCHOOL_ID','ssm.SCHOOL_ID',$extra_schools)." ssm.SYEAR='".UserSyear()."' ".$extra.' ORDER BY LAST_NAME,FIRST_NAME'));
		}
		elseif(substr($_REQUEST['breakdown'],0,6)=='CUSTOM')
		{
			$var = $_REQUEST['breakdown'];
			$field_id = substr($_REQUEST['breakdown'],7);
			$select_options_RET = DBGet(DBQuery("SELECT SELECT_OPTIONS,TITLE FROM CUSTOM_FIELDS WHERE ID='".$field_id."'"));
			$var_title = $select_options_RET[1]['TITLE'];
			$options = str_replace("\n","\r",str_replace("\r\n","\r",$select_options_RET[1]['SELECT_OPTIONS']));
			$options = explode("\r",$options);
			$group[0] = array();
			foreach($options as $option)
				$group[] = array('ID'=>$option,'TITLE'=>$option);
			unset($group[0]);
		}
	}

	if($_REQUEST['breakdown'])
	{
		$RET = array();
		$start_num = $num;
		foreach($group as $value)
		{
			$row++;
			if($_REQUEST['screen'])
			{
				for($i=1;$i<=15;$i++)
				{
					if(substr($var,0,6)=='CUSTOM')
						$_REQUEST['screen'][$i]['cust'][$var] = $value['ID'];
					else
						$_REQUEST['screen'][$i][$var] = $value['ID'];
				}
			}
			$num = $start_num;
			$val = eval($query);
			if(strpos($val,'.')!==false)
				$val = ltrim(round($val,3),'0');
			$RET[$row] = array('CATEGORY'=>$value['TITLE'],'VALUE'=>$val);
			if($_REQUEST['graph'] && (!isset($_CENTRE['_createRCGraphs_max']) || $_CENTRE['_createRCGraphs_max']<$val))
				$_CENTRE['_createRCGraphs_max'] = $val;
		}
		$columns = array('CATEGORY'=>$var_title,'VALUE'=>$_REQUEST['equation_title']);
		if($_REQUEST['graph'])
		{
			_createRCGraphs($RET);
		}
		$_REQUEST = $_runCalc_start_REQUEST;
		return ListOutputBuffered($RET,$columns,' ',' ','','',array('search'=>false));
	}
	else
	{
		$val = eval($query);
		if(strpos($val,'.')!==false)
			$val = ltrim(round($val,3),'0');
		return $val;
	}
}
elseif($_REQUEST['modfunc']=='remove')
{
	if(!$_REQUEST['delete_ok'] && !$_REQUEST['delete_cancel'])
		DrawHeader(ProgramTitle());

	if(DeletePrompt('saved equation'))
	{
		DBQuery("DELETE FROM SAVED_CALCULATIONS WHERE ID='".$_REQUEST['id']."'");
		unset($_REQUEST['modfunc']);
		unset($_SESSION['_REQUEST_vars']['modfunc']);
		unset($_SESSION['_REQUEST_vars']['id']);
	}
}

if($_REQUEST['modfunc']=='update_equations' && $_REQUEST['values'] && $_POST['values'] && AllowEdit())
{
	foreach($_REQUEST['values'] as $id=>$columns)
	{
		$sql = "UPDATE SAVED_CALCULATIONS SET ";

		foreach($columns as $column=>$value)
		{
			$sql .= $column."='".str_replace("\'","''",$value)."',";
		}
		$sql = substr($sql,0,-1) . " WHERE ID='$id'";
		DBQuery($sql);
	}
}

if($_REQUEST['modfunc']!='remove')
{
	echo '<script language=javascript src="modules/State_Reports/functions.js"></script>';
	echo '<script language=javascript src="assets/ajax.js"></script>';
	DrawHeader(ProgramTitle());
	DrawHeader('<span id=status_div></span>');
	
	$field_categories = array('',_('Time Values'),'Focus '._('Fields'),'Orchard '._('Fields'),_('Constants'));
	$items = array(
		'function' => array('sum','average','count','max','min','average-max','average-min','sum-max','sum-min','stdev'),
		'operator' => array('+','-','*','/','(',')'),
		'field' => array('~',_('Present'),_('Absent'),_('Enrolled'),'~',_('Student ID'))
	);
	$numeric_RET = DBGet(DBQuery("SELECT ID,CATEGORY_ID,TITLE FROM CUSTOM_FIELDS WHERE TYPE='numeric'"),array(),array('CATEGORY_ID'));
	foreach($numeric_RET as $category_id=>$fields)
	{
		if(AllowUse('Modules.php?modname=Students/Student.php&category_id='.$category_id))
		{
			foreach($fields as $field)
				$items['field'][] = 'Focus: '.$field['TITLE'];
		}
	}
	$items['field'][] = '~';
	$items['field'][] = _('Time on Task');
	$subjects = array(
		_('Math'),
		_('Language Arts'),
		_('Social Studies'),
		_('Science'),
		_('Biology')
	);
	
	foreach($subjects as $test)
		$items['field'][] = 'Orchard: '.$test.' '._('Score');
	
	$items['field'][] = '~';
	for($i=0;$i<=9;$i++)
		$items['field'][] = $i;
	$items['field'][] = '0';
	$items['field'][] = '.';
	
	//$items['field'] += array('~','IL Time','~','0','1','2','3','4','5','6','7','8','9')
	echo '<BR>';
	echo '<TABLE width=100%><TR>';
	echo '<TD valign=top>';
	
	$content = '<TABLE class=BoxContents border=0 width=100%><TR><TD valign=top align=center><b>'._('Functions').'</b><BR>';
	$type = 'function';
	foreach($items['function'] as $item)
		$content .= DrawTab($item,'# onclick="insertItem(\''.$item.'\',\''.$type.'\');"','CCBBCC','000000','_circle',array('tabcolor'=>Preferences('HIGHLIGHT'),'textcolor'=>'FFFFFF'),'width=100%').'<IMG SRC=assets/pixel_trans.gif height=5>';
	$content .= '</TD>';
	$content .= '<TD width=1 bgcolor=#000000></TD>';
	$content .= '<TD valign=top align=center><b>'._('Operators').'</b><BR>';
	$type = 'operator';
	$content .= '<TABLE><TR>';
	$j = 0;
	foreach($items['operator'] as $item)
	{
		$content .= '<TD>'.DrawTab($item,'# onclick="insertItem(\''.$item.'\',\''.$type.'\');"','CCBBCC','000000','_circle',array('tabcolor'=>Preferences('HIGHLIGHT'),'textcolor'=>'FFFFFF')).'</TD>';
		$j++;
		if($j%2==0 && $j!=count($items['operator']))
			$content .= '</TR><TR>';
	}
	$content .= '</TR></TABLE>';
	$content .= '</TD>';
	$content .= '</TR></TABLE>';
	
	echo DrawBlock(_('Functions').'. &amp; '._('Operators'),$content);
	echo '</TD>';
	
	echo '<TD valign=top>';
	$content = '<TABLE class=BoxContents border=0 width=100%><TR><TD>';
	$type = 'field';
	foreach($items['field'] as $item)
	{
		if($item=='~')
		{
			if($cat_count!=0)
				$content .= '</TD><TD width=1 bgcolor=#000000></TD>';
			$cat_count++;
			$content .= '<TD valign=top align=center><B>'.$field_categories[$cat_count].'</B><BR>';
			if($field_categories[$cat_count]=='Constants')
			{
				$content .= '<TABLE class=BoxContents><TR>';
				for($i=7;$i<=9;$i++)
					$content .= '<TD width=15 align=center>'.DrawTab($i,'# onclick="insertItem(\''.$i.'\',\''.$type.'\');"','CCBBCC','000000','_circle',array('tabcolor'=>Preferences('HIGHLIGHT'),'textcolor'=>'FFFFFF')).'</TD>';
				$content .= '</TR><TR>';
				for($i=4;$i<=6;$i++)
					$content .= '<TD width=15 align=center>'.DrawTab($i,'# onclick="insertItem(\''.$i.'\',\''.$type.'\');"','CCBBCC','000000','_circle',array('tabcolor'=>Preferences('HIGHLIGHT'),'textcolor'=>'FFFFFF')).'</TD>';
				$content .= '</TR><TR>';
				for($i=1;$i<=3;$i++)
					$content .= '<TD width=15 align=center>'.DrawTab($i,'# onclick="insertItem(\''.$i.'\',\''.$type.'\');"','CCBBCC','000000','_circle',array('tabcolor'=>Preferences('HIGHLIGHT'),'textcolor'=>'FFFFFF')).'</TD>';
				$content .= '</TR><TR><TD align=center>'.DrawTab('.','# onclick="insertItem(\'.\',\''.$type.'\');"','CCBBCC','000000','_circle',array('tabcolor'=>Preferences('HIGHLIGHT'),'textcolor'=>'FFFFFF')).'</TD><TD align=center>'.DrawTab('0','# onclick="insertItem(\'0\',\''.$type.'\');"','CCBBCC','000000','_circle',array('tabcolor'=>Preferences('HIGHLIGHT'),'textcolor'=>'FFFFFF')).'</TD><TD></TD></TR>';
				$content .= '</TABLE>';
				break;
			}
			else
				continue;
		}
		$content .= DrawTab($item,'# onclick="insertItem(\''.$item.'\',\''.$type.'\');"','CCBBCC','000000','_circle',array('tabcolor'=>Preferences('HIGHLIGHT'),'textcolor'=>'FFFFFF'),'width=100%').'<IMG SRC=assets/pixel_trans.gif height=5>';
	}
	$content .= '</TD>';
	$content .= '</TR></TABLE>';
	echo DrawBlock(_('Fields'),$content);
	echo '</TD>';
	
	echo '</TR></TABLE>';
	echo '<BR>';
	$fields_RET = DBGet(DBQuery("SELECT ID,TITLE FROM CUSTOM_FIELDS WHERE TYPE='select' ORDER BY TITLE"));
	$select = '<SELECT name=breakdown id=breakdown_select><OPTION value="">'._('Breakdown').'</OPTION><OPTION value=school>'._('School').'</OPTION><OPTION value=grade>'._('Grade').'</OPTION><OPTION value=stuid>'._('Student ID').'</OPTION>';
	foreach($fields_RET as $field)
		$select .= "<OPTION value=CUSTOM_".$field['ID'].">".$field['TITLE'].'</OPTION>';
	$select .= '</SELECT>';
	echo DrawBlock(_('Equation'),'<TABLE width=100%><TR><TD align=right valign=middle>'.$select.'<A HREF=# onclick="backspace();"><IMG SRC=assets/backspace.gif border=0 align=middle></A><A HREF=# onclick="runQuery();"><IMG SRC=assets/run_key.gif border=0 align=middle></A><A HREF=# onclick="document.getElementById(\'save_screen\').style.display=\'block\';document.getElementById(\'save_screen\').style.left=getXPos(\'saveimage\')-175;document.getElementById(\'save_screen\').style.top=getYPos(\'saveimage\')+40;"><IMG SRC=assets/save_key.gif id=saveimage border=0 align=middle></A></TD></TR><TR><TD width=100%><DIV id=equation_div><img src="assets/blinking_cursor.gif"></DIV></TD></TR></TABLE><DIV id=XMLHttpRequestResult></DIV>');
	
	$equations_RET = DBGet(DBQuery("SELECT ID,TITLE,URL FROM SAVED_CALCULATIONS ORDER BY TITLE"),array('TITLE'=>'_makeText','URL'=>'_makeURL'));
	if(count($equations_RET))
	{
		$table = '<FORM action=Modules.php?modname='.$_REQUEST['modname'].'&modfunc=update_equations method=POST>';
		$columns = array('TITLE'=>_('Title'),'URL'=>_('Equation'));
		$link['remove']['link'] = "Modules.php?modname=".$_REQUEST['modname']."&modfunc=remove";
		$link['remove']['variables'] = array('id'=>'ID');
		

		$table .= ListOutputBuffered($equations_RET,$columns,_('saved equation'),_('saved equations'),$link);
		$table .= '<CENTER><INPUT type=submit value='._('Save').'></CENTER>';
		$table .= '</FORM>';
		echo '<BR>';
		echo DrawBlock(_('Saved Equations'),$table);
	}
	
	echo "<DIV id=search_screen style='position:absolute;visibility:hidden;'><IMG SRC=assets/arrow_up.gif><DIV class=BoxContents style='border-style:solid;border-width:1;border-color:#CCBBCC;' id=search_contents></DIV></DIV>";
	echo "<DIV id=hidden_search_contents>";
	echo '<FORM action=# name=_searchform_>';
	
	for($i=1;$i<=10;$i++)
		echo '<DIV div_id=search_contents'.$i.'></DIV>';
	echo '</FORM>';
	echo '</DIV>';
	
	echo '<FORM action=# name=main_form>';
	echo '<INPUT type=hidden name=query>';
	echo '<INPUT type=hidden name=breakdown>';
	echo '<DIV style="visibility:hidden;" id=hidden_permanent_search_contents>';
	echo '</DIV>';
	echo "<DIV id=save_screen style=\"display:none;position:absolute;\" align=right><IMG SRC=assets/arrow_up.gif><DIV class=BoxContents style='border-style:solid;border-width:1;border-color:#CCBBCC;' id=save_content>";
	echo '<TABLE cellpadding=6><TR><TD><font color=gray><small>Title</small></font><INPUT type=text name=calc_title size=15 onkeypress="if(event.keyCode==13){saveQuery();return false;}"><INPUT type=button onclick="saveQuery();" value='._('Save').'></TD></TR></TABLE></DIV></DIV>';
	echo '</FORM>';
	
	$search_fields_RET = DBGet(DBQuery("SELECT 'CUSTOM_'||cf.ID AS COLUMN_NAME,cf.TYPE,cf.TITLE,cf.SELECT_OPTIONS FROM PROGRAM_USER_CONFIG puc,CUSTOM_FIELDS cf WHERE puc.TITLE=cf.ID AND puc.PROGRAM='StudentFieldsSearch' AND puc.USERNAME='".User('USERNAME')."' AND puc.VALUE='Y'"));
	if(!$search_fields_RET)
		$search_fields_RET = DBGet(DBQuery("SELECT 'CUSTOM_'||cf.ID AS COLUMN_NAME,cf.TYPE,cf.TITLE,cf.SELECT_OPTIONS FROM CUSTOM_FIELDS cf WHERE cf.ID IN ('200000000','200000001')"));
	$search_fields_RET[] = array('COLUMN_NAME'=>'first','TYPE'=>'other','TITLE'=>_('First Name'));
	$search_fields_RET[] = array('COLUMN_NAME'=>'last','TYPE'=>'other','TITLE'=>_('Last Name'));
	$search_fields_RET[] = array('COLUMN_NAME'=>'stuid','TYPE'=>'other','TITLE'=>_('Student ID'));
	$search_fields_RET[] = array('COLUMN_NAME'=>'schools','TYPE'=>'schools','TITLE'=>_('Schools'));
	
	$fields_select = "<SELECT div_id=\"_id_\" name=itemname onchange='switchSearchInput(this);'>";
	foreach($search_fields_RET as $field)
		$fields_select .= '<OPTION value='.$field['COLUMN_NAME'].'>'.$field['TITLE'].'</OPTION>';
	$fields_select .= '<OPTION value="grade" SELECTED>Grade</OPTION>';
	$fields_select .= '</SELECT>';
	
	$search_fields_RET[] = array('COLUMN_NAME'=>'grade','TYPE'=>'grade','TITLE'=>_('Grade'));
	echo '<DIV id="hidden_search_inputtimespan" style="visibility:hidden;"><TABLE><TR><TD colspan=4>'._makeSearchInput(array('COLUMN_NAME'=>'timespan','TYPE'=>'timespan','TITLE'=>_('Between'))).'</TD></TR></TABLE></DIV>';
	echo '<DIV id="hidden_search_inputtestno" style="visibility:hidden;"><TABLE><TR><TD>'.button('add','','# onclick="newNoItem();"').'</TD><TD>'.button('remove','','# onclick="removeSearchItem(\'_id_\')"').'</TD><TD colspan=2>'._makeSearchInput(array('COLUMN_NAME'=>'test_no','TYPE'=>'test_no','TITLE'=>_('Test Number'))).'</TD></TR></TABLE></DIV>';
	
	foreach($search_fields_RET as $field)
		echo '<DIV id="hidden_search_input'.$field['COLUMN_NAME'].'" style="visibility:hidden;"><TABLE><TR><TD>'.button('add','','# onclick="newSearchItem();"').'</TD><TD>'.button('remove','','# onclick="removeSearchItem(\'_id_\')"').'</TD><TD>'.$fields_select.'</TD><TD>'._makeSearchInput($field).'</TD></TR></TABLE></DIV>';
}
?>