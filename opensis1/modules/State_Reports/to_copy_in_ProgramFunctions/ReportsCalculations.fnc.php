<?php
/**
* @file $Id: ReportsCalculations.fnc.php 437 2007-04-23 00:57:51Z focus-sis $
* @package Focus/SIS
* @copyright Copyright (C) 2006 Andrew Schmadeke. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.txt
* Focus/SIS is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.txt for copyright notices and details.
*/

function _makeSearchInput($field)
{
	switch($field['TYPE'])
	{
		case 'text':
			return "<INPUT type=text name=cust[{$field[COLUMN_NAME]}] size=30".(($_REQUEST['bottom_back']=='true' && $_SESSION['Search_vars']['cust'][$field['COLUMN_NAME']])?' value="'.$_SESSION['Search_vars']['cust'][$field['COLUMN_NAME']].'"':'').">";
		break;
		
		case 'numeric':
			return "<small>Between</small> <INPUT type=text name=cust_begin[{$field[COLUMN_NAME]}] size=3 maxlength=11".(($_REQUEST['bottom_back']=='true' && $_SESSION['Search_vars']['cust'][$field['COLUMN_NAME']])?' value="'.$_SESSION['Search_vars']['cust_begin'][$field['COLUMN_NAME']].'"':'')."> <small>&amp;</small> <INPUT type=text name=cust_end[{$field[COLUMN_NAME]}] size=3 maxlength=11".(($_REQUEST['bottom_back']=='true' && $_SESSION['Search_vars']['cust'][$field['COLUMN_NAME']])?' value="'.$_SESSION['Search_vars']['cust_end'][$field['COLUMN_NAME']].'"':'').">";
		break;

		case 'select':
			$field['SELECT_OPTIONS'] = str_replace("\n","\r",str_replace("\r\n","\r",$field['SELECT_OPTIONS']));
			$options = explode("\r",$field['SELECT_OPTIONS']);
			
			if($_REQUEST['bottom_back']=='true' && $_SESSION['Search_vars']['cust'][$field['COLUMN_NAME']])
				$bb_option = $_SESSION['Search_vars']['cust'][$field['COLUMN_NAME']];
			else
				$bb_option = '';
			$return = "<SELECT name=cust[{$field[COLUMN_NAME]}] style='max-width:250;'><OPTION value=''>N/A</OPTION><OPTION value='!'".($bb_option=='!'?' SELECTED':'').">No Value</OPTION>";
			foreach($options as $option)
				$return .= "<OPTION value=\"$option\"".(($field['COLUMN_NAME']=='CUSTOM_44' && $field['TITLE']=='District' && $option==$_SESSION['district'])?' SELECTED':'').($bb_option==$option?' SELECTED':'').">$option</OPTION>";
			$return .= '</SELECT>';		
			return $return;
		break;

		case 'date':
			return "<small>Between</small> ".PrepareDate($bb_option,'_cust_begin['.$field['COLUMN_NAME'].']',true,array('short'=>true,'C'=>false)).' <small>&</small> '.PrepareDate('','_cust_end['.$field['COLUMN_NAME'].']',true,array('short'=>true,'C'=>false));
		break;

		case 'radio':
			return "<table border=0 cellpadding=0 cellspacing=0><tr><td width=30 align=center>
				<input name='cust[{$field[COLUMN_NAME]}]' type='radio' value='Y'".(($_REQUEST['bottom_back']=='true' && $_SESSION['Search_vars']['cust'][$field['COLUMN_NAME']]=='Y')?' CHECKED':'')." /> Yes
				</td><td width=25 align=center>
				<input name='cust[{$field[COLUMN_NAME]}]' type='radio' value='N'".(($_REQUEST['bottom_back']=='true' && $_SESSION['Search_vars']['cust'][$field['COLUMN_NAME']])?' CHECKED':'')." /> No
				</td></tr></table>";
		break;
		
		case 'grade':
			$grades_RET = DBGet(DBQuery("SELECT DISTINCT TITLE,ID,SORT_ORDER FROM SCHOOL_GRADELEVELS WHERE SCHOOL_ID='".UserSchool()."' ORDER BY SORT_ORDER"));
			$return = '<SELECT name=grade><OPTION value=""></OPTION>';
			foreach($grades_RET as $grade)
				$return .= "<OPTION value=$grade[ID]>".$grade['TITLE'].'</OPTION>';
			$return .= '</SELECT>';
			return $return;
		break;

		case 'schools':
			$return = "<small>Search All</small><INPUT type=checkbox name=_search_all_schools value=Y>";
			return $return;
		break;

		case 'timespan':
			$start_date = '01-'.strtoupper(date('M-y'));
			$end_date = DBDate();
			return "<small>Between</small> ".PrepareDate($start_date,'_start',true,array('short'=>true,'C'=>false)).' <small>&</small> '.PrepareDate($end_date,'_end',true,array('short'=>true,'C'=>false));
		break;

		case 'test_no':
			$select = "<SELECT name='test_no[]'>";
			$vals = array('1'=>1,'2'=>2,'3'=>3,'4'=>4,'5'=>5,'6'=>6,'7'=>7,'8'=>8,'9'=>9,'10'=>10,'0'=>'Final');
			$select .= '<OPTION value="">N/A</OPTION>';
			foreach($vals as $i=>$val)
				$select .= "<OPTION value=$i>".$val.'</OPTION>';
			$select .= '</SELECT>';
			return "<small>Test Number</small> ".$select;
		break;
		
		case 'other':
			return "<INPUT type=text name={$field[COLUMN_NAME]} size=30>";
		break;
	}

}

function _getResults($type,$number,$index='')
{	global $num,$remote_type;

	$num++;
	$start_REQUEST = $_REQUEST;
	if($_REQUEST['screen'])
		$_REQUEST = $_REQUEST['screen'][$num];
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
	$min_max_date = DBGet(DBQuery("SELECT to_char(min(SCHOOL_DATE),'dd-MON-yy') AS MIN_DATE,to_char(max(SCHOOL_DATE),'dd-MON-yy') AS MAX_DATE FROM ATTENDANCE_CALENDAR WHERE SYEAR='".UserSyear()."'"));

	if($_REQUEST['day_start'] && $_REQUEST['month_start'] && $_REQUEST['year_start'])
		$start_date = $_REQUEST['day_start'].'-'.$_REQUEST['month_start'].'-'.$_REQUEST['year_start'];
	else
		$start_date = $min_max_date[1]['MIN_DATE'];
	
	if($_REQUEST['day_end'] && $_REQUEST['month_end'] && $_REQUEST['year_end'])
		$end_date = $_REQUEST['day_end'].'-'.$_REQUEST['month_end'].'-'.$_REQUEST['year_end'];
	else
		$end_date = $min_max_date[1]['MAX_DATE'];

	if($_REQUEST['stuid'])
		$extra .= " AND s.STUDENT_ID = '$_REQUEST[stuid]' ";
	if($_REQUEST['last'])
		$extra .= " AND UPPER(s.LAST_NAME) LIKE '".strtoupper($_REQUEST['last'])."%' ";
	if($_REQUEST['first'])
		$extra .= " AND UPPER(s.FIRST_NAME) LIKE '".strtoupper($_REQUEST['first'])."%' ";
	if($_REQUEST['grade'])
		$extra .= " AND ssm.GRADE_ID = '".$_REQUEST['grade']."' ";
	if($_REQUEST['grades'])
		$extra .= " AND ssm.GRADE_ID IN (".$_REQUEST['grades'].") ";
	if($_REQUEST['school'])
		$extra .= " AND ssm.SCHOOL_ID = '".$_REQUEST['school']."' ";
	
	$extra .= CustomFields('where');

	$schools = substr(str_replace(",","','",User('SCHOOLS')),2,-2);
	$array = array();
	if(substr($type,0,7)=='orchard')
	{
		$test_title = substr($type,9,-6);
		$type = 'orchard_test';
	}

	switch($type)
	{
		case 'present':
			$schools = substr(str_replace(",","','",User('SCHOOLS')),2,-2);
			if(!strpos($extra,'GROUP'))
				$extra .= " GROUP BY ad.SCHOOL_DATE";
	
			if($_REQUEST['school'])
				$extra_schools = '';
			elseif($_REQUEST['_search_all_schools']!='Y')
				$extra_schools = "SCHOOL_ID='".UserSchool()."' AND ";
			elseif($schools)
				$extra_schools = "SCHOOL_ID IN (".$schools.") AND ";
			
			$RET = DBGet(DBQuery("SELECT ad.SCHOOL_DATE,COALESCE(sum(ad.STATE_VALUE),0) AS STATE_VALUE FROM ATTENDANCE_DAY ad,STUDENT_ENROLLMENT ssm,STUDENTS s WHERE s.STUDENT_ID=ssm.STUDENT_ID AND ".str_replace('SCHOOL_ID','ssm.SCHOOL_ID',$extra_schools)." ad.STUDENT_ID=ssm.STUDENT_ID AND ssm.SYEAR='".UserSyear()."' AND ad.SYEAR=ssm.SYEAR AND ad.SCHOOL_DATE BETWEEN '$start_date' AND '$end_date' AND (ad.SCHOOL_DATE BETWEEN ssm.START_DATE AND ssm.END_DATE OR (ssm.END_DATE IS NULL AND ssm.START_DATE <= ad.SCHOOL_DATE)) ".$extra));
			foreach($RET as $value)
			{
				if($index)
					$array[$value[$index]] = $value['STATE_VALUE'];
				else
					$array[] = $value['STATE_VALUE'];
			}
		break;
		
		case 'absent':
			$schools = substr(str_replace(",","','",User('SCHOOLS')),2,-2);
			if(!strpos($extra,'GROUP'))
				$extra .= " GROUP BY ad.SCHOOL_DATE";
	
			if($_REQUEST['school'])
				$extra_schools = '';
			elseif($_REQUEST['_search_all_schools']!='Y')
				$extra_schools = "SCHOOL_ID='".UserSchool()."' AND ";
			elseif($schools)
				$extra_schools = "SCHOOL_ID IN (".$schools.") AND ";
			
			$RET = DBGet(DBQuery("SELECT ad.SCHOOL_DATE,COALESCE(sum(ad.STATE_VALUE-1)*-1,0) AS STATE_VALUE FROM ATTENDANCE_DAY ad,STUDENT_ENROLLMENT ssm,STUDENTS s WHERE s.STUDENT_ID=ssm.STUDENT_ID AND ".str_replace('SCHOOL_ID','ssm.SCHOOL_ID',$extra_schools)." ad.STUDENT_ID=ssm.STUDENT_ID AND ssm.SYEAR='".UserSyear()."' AND ad.SYEAR=ssm.SYEAR AND ad.SCHOOL_DATE BETWEEN '$start_date' AND '$end_date' AND (ad.SCHOOL_DATE BETWEEN ssm.START_DATE AND ssm.END_DATE OR (ssm.END_DATE IS NULL AND ssm.START_DATE <= ad.SCHOOL_DATE)) ".$extra));
			foreach($RET as $value)
			{
				if($index)
					$array[$value[$index]] = $value['STATE_VALUE'];
				else
					$array[] = $value['STATE_VALUE'];
			}
		break;

		case 'enrolled':
			$schools = substr(str_replace(",","','",User('SCHOOLS')),2,-2);
	
			if($_REQUEST['school'])
				$extra_schools = '';
			elseif($_REQUEST['_search_all_schools']!='Y')
				$extra_schools = "SCHOOL_ID='".UserSchool()."' AND ";
			elseif($schools)
				$extra_schools = "SCHOOL_ID IN (".$schools.") AND ";

			if(!strpos($extra,'GROUP'))
				$extra .= " GROUP BY ac.SCHOOL_DATE";

			$RET = DBGet(DBQuery("SELECT ac.SCHOOL_DATE,count(*) AS STUDENTS FROM STUDENT_ENROLLMENT ssm,ATTENDANCE_CALENDAR ac,STUDENTS s WHERE s.STUDENT_ID=ssm.STUDENT_ID AND ssm.SYEAR='".UserSyear()."' AND ac.SYEAR=ssm.SYEAR AND ac.CALENDAR_ID=ssm.CALENDAR_ID AND ".str_replace('SCHOOL_ID','ssm.SCHOOL_ID',$extra_schools)." ssm.SCHOOL_ID=ac.SCHOOL_ID AND (ac.SCHOOL_DATE BETWEEN ssm.START_DATE AND ssm.END_DATE OR (ssm.END_DATE IS NULL AND ssm.START_DATE <= ac.SCHOOL_DATE)) AND ac.SCHOOL_DATE BETWEEN '$start_date' AND '$end_date' ".$extra));
			foreach($RET as $value)
			{
				if($index)
					$array[$value[$index]] = $value['STUDENTS'];
				else
					$array[] = $value['STUDENTS'];
			}
		break;

		case 'student id':
			$schools = substr(str_replace(",","','",User('SCHOOLS')),2,-2);
	
			if($_REQUEST['school'])
				$extra_schools = '';
			elseif($_REQUEST['_search_all_schools']!='Y')
				$extra_schools = "SCHOOL_ID='".UserSchool()."' AND ";
			elseif($schools)
				$extra_schools = "SCHOOL_ID IN (".$schools.") AND ";

			$RET = DBGet(DBQuery("SELECT ssm.STUDENT_ID FROM STUDENT_ENROLLMENT ssm,STUDENTS s WHERE s.STUDENT_ID=ssm.STUDENT_ID AND ".str_replace('SCHOOL_ID','ssm.SCHOOL_ID',$extra_schools)." ssm.SYEAR='".UserSyear()."'"." AND ('".DBDate()."' BETWEEN ssm.START_DATE AND ssm.END_DATE OR ssm.END_DATE IS NULL) ".$extra));
			foreach($RET as $value)
			{
				if($index)
					$array[$value[$index]] = $value['STUDENT_ID'];
				else
					$array[] = $value['STUDENT_ID'];
			}
		break;

		case 'orchard_test':
			$schools = substr(str_replace(",","','",User('SCHOOLS')),2,-2);
	
			if($_REQUEST['school'])
				$extra_schools = '';
			elseif($_REQUEST['_search_all_schools']!='Y')
				$extra_schools = " AND SCHOOL_ID='".UserSchool()."' ";
			elseif($schools)
				$extra_schools = " AND SCHOOL_ID IN (".$schools.") ";
			else
				$extra_schools = '';

			$RET = DBGet(DBQuery("SELECT ssm.STUDENT_ID FROM STUDENT_ENROLLMENT ssm,STUDENTS s WHERE s.STUDENT_ID=ssm.STUDENT_ID AND ssm.SYEAR='".UserSyear()."' ".str_replace('SCHOOL_ID','ssm.SCHOOL_ID',$extra_schools)." ".$extra));
			if(count($RET))
			{
				foreach($RET as $student)
				{
					$student_ids .= $student['STUDENT_ID'].',';
				}
				$student_ids = substr($student_ids,0,-1);
	
				$students_RET = DBGet(DBQuery("SELECT id,SCHOOL_ID FROM orchardstudent where externalid IN (".$student_ids.")",'mysql'),array(),array('SCHOOL_ID'));
				$remote_type = false;
			}
			else
				$students_RET = array();
			if(count($students_RET))
			{
				$student_ids = array();
				foreach($students_RET as $school_id=>$students)
				{
					foreach($students as $student)
						$student_ids[$student['SCHOOL_ID']] .= $student['ID'].',';
				}
				foreach($student_ids as $i=>$value)
					$student_ids[$i] = substr($value,0,-1);
				$tests_RET = DBGet(DBQuery("SELECT testid from orchardtest where name like '%$test_title%'",'mysql'));
				foreach($tests_RET as $test)
					$test_ids .= $test['TESTID'].',';
				$test_ids = substr($test_ids,0,-1);
				if(substr($start_date,7,2)<50)
					$start = '20'.substr($start_date,7,2).MonthNWSwitch(substr($start_date,3,3),'tonum').substr($start_date,0,2).'000000';
				else
					$start = '19'.substr($start_date,7,2).MonthNWSwitch(substr($start_date,3,3),'tonum').substr($start_date,0,2).'000000';
				$end = '20'.substr($end_date,7,2).MonthNWSwitch(substr($end_date,3,3),'tonum').substr($end_date,0,2).'999999';
				foreach($student_ids as $school_id=>$student_ids_list)
				{
					$RET = DBGet(DBQuery("SELECT correct,total,studentid from orchardtestrecord where slgtime BETWEEN '$start' AND '$end' AND productcode IN ($test_ids) and studentid IN ($student_ids_list) AND SCHOOL_ID='$school_id' ORDER BY STUDENTID,SLGTIME ASC",'mysql'));
					$remote_type = false;
					$student_test_count = array();

					foreach($RET as $i=>$value)
					{					
						if(isset($_REQUEST['test_no']))
							$student_test_count[$value['STUDENTID']]++;
						if(isset($_REQUEST['test_no']) && in_array('0',$_REQUEST['test_no']) && $value['STUDENTID']!=$RET[($i+1)]['STUDENTID'])
						{
							if($index!='')
								$array[$value[$index]][] = ($value['CORRECT']*100)/$value['TOTAL'];
							else
								$array[] = ($value['CORRECT']*100)/$value['TOTAL'];							
						}
						elseif(!isset($_REQUEST['test_no']) || in_array($student_test_count[$value['STUDENTID']],$_REQUEST['test_no']))
						{
							if($index!='')
								$array[$value[$index]][] = ($value['CORRECT']*100)/$value['TOTAL'];
							else
								$array[] = ($value['CORRECT']*100)/$value['TOTAL'];
						}
					}
				}
			}
			else
				$array = array();
		break;

		case 'time on task':
			$schools = substr(str_replace(",","','",User('SCHOOLS')),2,-2);
	
			if($_REQUEST['school'])
				$extra_schools = '';
			elseif($_REQUEST['_search_all_schools']!='Y')
				$extra_schools = " AND SCHOOL_ID='".UserSchool()."' ";
			elseif($schools)
				$extra_schools = " AND SCHOOL_ID IN (".$schools.") ";
			else
				$extra_schools = '';

			$RET = DBGet(DBQuery("SELECT ssm.STUDENT_ID FROM STUDENT_ENROLLMENT ssm,STUDENTS s WHERE s.STUDENT_ID=ssm.STUDENT_ID AND ssm.SYEAR='".UserSyear()."' ".str_replace('SCHOOL_ID','ssm.SCHOOL_ID',$extra_schools)." ".$extra));
			if(count($RET))
			{
				foreach($RET as $student)
				{
					$student_ids .= $student['STUDENT_ID'].',';
				}
				$student_ids = substr($student_ids,0,-1);
	
				$students_RET = DBGet(DBQuery("SELECT id,SCHOOL_ID FROM orchardstudent where externalid IN (".$student_ids.")",'mysql'),array(),array('SCHOOL_ID'));
				$remote_type = false;
			}
			else
				$students_RET = array();
			if(count($students_RET))
			{
				$student_ids = array();
				foreach($students_RET as $school_id=>$students)
				{
					foreach($students as $student)
						$student_ids[$student['SCHOOL_ID']] .= $student['ID'].',';
				}
				foreach($student_ids as $i=>$value)
					$student_ids[$i] = substr($value,0,-1);
				foreach($student_ids as $school_id=>$student_ids_list)
				{
					$RET = DBGet(DBQuery("SELECT studentid,sum(tot) as tot from orchardtimeontask where studentid IN ($student_ids_list) and SCHOOL_ID='$school_id' group by studentid",'mysql'));
					$remote_type = false;
	
					foreach($RET as $value)
						$array[] = $value['TOT'];
				}
			}
			else
				$array = array();
		break;

	}
	$_REQUEST = $start_REQUEST;
	return $array;
}

function _makeText($value,$column)
{	global $THIS_RET;

	return TextInput($value,'values['.$THIS_RET['ID'].']['.$column.']');
}

function _makeURL($value,$column)
{	global $screen;

	$value = urldecode($value);
	$start = strpos($value,'query=')+6;
	$url = $value;
	$vars = substr($url,(strpos($url,'?')+1));
	
	$vars = str_replace('&amp;','&',$vars);
	$vars = explode('&',$vars);
	$screen = array();
	foreach($vars as $code)
	{
		if(strpos($code,'[')!==false)
		{
			$code = str_replace('cust[','cust][',$code);
			$code = str_replace('test_no[','test_no][',$code);
			$equals = strpos($code,'=');
			$code = '$'.substr($code,0,$equals)."='".substr($code,$equals+1)."';";
			eval($code);
		}
	}
	return _makeScreens(eregi_replace('</?SPAN id=[^>]+>','',substr($value,$start,(strpos(strtolower($value),'<img')-$start))));
}

function _createRCGraphs(& $RET)
{	global $_FOCUS;

	$last = count($RET);
	$scale = (100/$_FOCUS['_createRCGraphs_max']);
	for($i=1;$i<=$last;$i++)
		$RET[$i]['VALUE'] = '<!--' . ((int) ($RET[$i]['VALUE']*$scale)) . '--><IMG SRC=assets/pixel_grey.gif class=innerLO_field width=' . ((int) ($RET[$i]['VALUE']*$scale)) . ' height=10> '.$RET[$i]['VALUE'];
}

function _makeScreens($equation)
{	global $screen,$fields_RET;

	$equation = strtolower(stripslashes($equation));
	while($pos = strpos($equation,'<b>)</b>'))
	{
		$screen_count++;
		if($screen[$screen_count]['month_start'] && $screen[$screen_count]['month_end'])
			$extra = '<i><font size=-1>between '.ShortDate($screen[$screen_count]['day_start'].'-'.$screen[$screen_count]['month_start'].'-'.$screen[$screen_count]['year_start']).' &amp; '.ShortDate($screen[$screen_count]['day_end'].'-'.$screen[$screen_count]['month_end'].'-'.$screen[$screen_count]['year_end']).'</font></i>; ';
		else
			$extra = '';

		if(in_array('0',$screen[$screen_count]['test_no']))
			$extra .= '<i><font size=-1>Final Test</i></font>; ';
		elseif(isset($screen[$screen_count]['test_no']))
		{
			foreach($screen[$screen_count]['test_no'] as $test_no)
				$extra .= '<i><font size=-1>Test No.</i>: '.$test_no.'</font>; ';
		}

		if(count($screen[$screen_count]['cust']))
		{
			//foreach($screen[$screen_count]['cust'] as $field=>$value)
			foreach($fields_RET as $field)
			{
				if($screen[$screen_count]['cust']['CUSTOM_'.$field['ID']])
					$extra .= $field['TITLE'].': '.$screen[$screen_count]['cust']['CUSTOM_'.$field['ID']].'; ';
			}
		}
		if($extra)
			$extra = substr($extra,0,-2);

		$equation = substr($equation,0,$pos).$extra.' <strong>)</strong>'.substr($equation,$pos+8);
	}
	return $equation;
}

function _average($array)
{
	foreach($array as $elem)
	{
		$i++;
		$sum += $elem;
	}
	return $sum / $i;
}

function _sum($array)
{
	foreach($array as $elem)
		$sum += $elem;
	return $sum;
}

function _min($array)
{
	$min = $array[0];
	foreach($array as $elem)
	{
		if($elem < $min)
			$min = $elem;
	}
	return $min;
}

function _max($array)
{
	$max = $array[0];
	foreach($array as $elem)
	{
		if($elem > $max)
			$max = $elem;
	}
	return $max;
}

function _sum0($arr)
{
	foreach($arr as $student_id=>$array)
	{
		$min = $array[key($array)];
		foreach($array as $elem)
		{
			if($elem < $min)
				$min = $elem;
		}
		$total_array[] = $min;
	}
	return _sum($total_array);
}

function _sum1($arr)
{
	foreach($arr as $student_id=>$array)
	{
		$max = $array[key($array)];
		foreach($array as $elem)
		{
			if($elem > $max)
				$max = $elem;
		}
		$total_array[] = $max;
	}
	return _sum($total_array);
}

function _avg0($arr)
{
	foreach($arr as $student_id=>$array)
	{
		$min = $array[key($array)];
		foreach($array as $elem)
		{
			if($elem < $min)
				$min = $elem;
		}
		$total_array[] = $min;
	}
	return _average($total_array);
}

function _avg1($arr)
{
	print_r($arr);
	echo "\n\n";
	foreach($arr as $student_id=>$array)
	{
		$max = $array[key($array)];
		foreach($array as $elem)
		{
			if($elem > $max)
				$max = $elem;
		}
		$total_array[] = $max;
	}
	return _average($total_array);
}

?>