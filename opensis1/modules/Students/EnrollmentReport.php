<?php
#**************************************************************************
#  openSIS is a free student information system for public and non-public 
#  schools from Open Solutions for Education, Inc. web: www.os4ed.com
#
#  openSIS is  web-based, open source, and comes packed with features that 
#  include student demographic info, scheduling, grade book, attendance, 
#  report cards, eligibility, transcripts, parent portal, 
#  student portal and more.   
#
#  Visit the openSIS web site at http://www.opensis.com to learn more.
#  If you have question regarding this system or the license, please send 
#  an email to info@os4ed.com.
#
#  This program is released under the terms of the GNU General Public License as  
#  published by the Free Software Foundation, version 2 of the License. 
#  See license.txt.
#
#  This program is distributed in the hope that it will be useful,
#  but WITHOUT ANY WARRANTY; without even the implied warranty of
#  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
#  GNU General Public License for more details.
#
#  You should have received a copy of the GNU General Public License
#  along with this program.  If not, see <http://www.gnu.org/licenses/>.
#
#***************************************************************************************
include('../../Redirect_modules.php');
include 'modules/Grades/config.inc.php';

if($_REQUEST['modfunc']=='save')
{
 $cur_session_RET=DBGet(DBQuery('SELECT YEAR(start_date) AS PRE,YEAR(end_date) AS POST FROM school_years WHERE SCHOOL_ID=\''.UserSchool().'\' AND SYEAR=\''.UserSyear().'\''));
 if($cur_session_RET[1]['PRE']==$cur_session_RET[1]['POST'])
 {
    $cur_session=$cur_session_RET[1]['PRE'];
 }
 else
 {
    $cur_session=$cur_session_RET[1]['PRE'].'-'.$cur_session_RET[1]['POST'];
 }

	if(count($_REQUEST['st_arr']))
	{
	
	$st_list = '\''.implode('\',\'',$_REQUEST['st_arr']).'\'';
        $RET=DBGet(DBQuery('SELECT CONCAT(s.LAST_NAME,\''.',' .'\',coalesce(s.COMMON_NAME,s.FIRST_NAME)) AS FULL_NAME,s.LAST_NAME,s.FIRST_NAME,s.MIDDLE_NAME,s.STUDENT_ID,s.PHONE,ssm.SCHOOL_ID,s.ALT_ID,ssm.SCHOOL_ID AS LIST_SCHOOL_ID,ssm.GRADE_ID,ssm.START_DATE,ssm.END_DATE,
                (SELECT sec.title FROM  student_enrollment_codes sec where ssm.enrollment_code=sec.id)AS ENROLLMENT_CODE,
                (SELECT sec.title FROM  student_enrollment_codes sec where ssm.drop_code=sec.id) AS DROP_CODE,ssm.SCHOOL_ID 
                FROM  students s , student_enrollment ssm
                WHERE ssm.STUDENT_ID=s.STUDENT_ID AND s.STUDENT_ID IN ('.$st_list.')  
                ORDER BY FULL_NAME ASC,START_DATE DESC'),array('START_DATE'=>'ProperDate','END_DATE'=>'ProperDate','SCHOOL_ID'=>'GetSchool','GRADE_ID'=>'GetGrade'),array('STUDENT_ID'));
        if(count($RET))
	{
            $columns = array('START_DATE'=>'Start Date','ENROLLMENT_CODE'=>'Enrollment Code','END_DATE'=>'Drop Date','DROP_CODE'=>'Drop Code','SCHOOL_ID'=>'Last School');
		$handle = PDFStart();
		foreach($RET as $student_id=>$value)
		{
			echo "<table width=100%  style=\" font-family:Arial; font-size:12px;\" >";
			echo "<tr><td width=105>".DrawLogo()."</td><td  style=\"font-size:15px; font-weight:bold; padding-top:20px;\">". GetSchool(UserSchool()).' ('.$cur_session.')'."<div style=\"font-size:12px;\">Student Enroll Report</div></td><td align=right style=\"padding-top:20px\">". ProperDate(DBDate()) ."<br \>Powered by openSIS</td></tr><tr><td colspan=3 style=\"border-top:1px solid #333;\">&nbsp;</td></tr></table>";
			echo '<!-- MEDIA SIZE 8.5x11in -->';
			
				unset($_openSIS['DrawHeader']);
                            unset($enroll_RET);
                            $i = 0;
                            foreach($value as $key=>$enrollment)
                            {
				
                                $i++;
                                $enroll_RET[$i]['START_DATE'] = ($enrollment['START_DATE']?$enrollment['START_DATE']:'--');
                                $enroll_RET[$i]['ENROLLMENT_CODE'] = ($enrollment['ENROLLMENT_CODE']?$enrollment['ENROLLMENT_CODE']:'--');
                                $enroll_RET[$i]['END_DATE'] = ($enrollment['END_DATE']?$enrollment['END_DATE']:'--');
                                $enroll_RET[$i]['DROP_CODE'] = ($enrollment['DROP_CODE']?$enrollment['DROP_CODE']:'--');
                                $enroll_RET[$i]['SCHOOL_ID'] = ($enrollment['SCHOOL_ID']?$enrollment['SCHOOL_ID']:'--');
                            }
				echo '<table border=0>';
				echo '<tr><td>Student Name :</td>';
				echo '<td>'.$enrollment['FULL_NAME'].'</td></tr>';
				echo '<tr><td>Student ID :</td>';
				echo '<td>'.$student_id.'</td></tr>';
                                echo '<tr><td>Alternate ID :</td>';
				echo '<td>'.$enrollment['ALT_ID'].'</td></tr>';
				echo '<tr><td>Student Grade :</td>';
				echo '<td>'.$enrollment['GRADE_ID'].'</td></tr>';
				echo '</table>';
                            
                            ListOutputPrint($enroll_RET,$columns,'','',array(),array(),array('print'=>false));
                echo '<span style="font-size:13px; font-weight:bold;"></span>';
				echo '<!-- NEW PAGE -->';
				echo "<div style=\"page-break-before: always;\"></div>";
		}
		PDFStop($handle);
            }
        }
	else
		BackPrompt('You must choose at least one student.');
}

if(!$_REQUEST['modfunc'])
{
	DrawBC("Student >> ".ProgramTitle());

	if($_REQUEST['search_modfunc']=='list')
	{
		echo "<FORM action=for_export.php?modname=$_REQUEST[modname]&modfunc=save&include_inactive=$_REQUEST[include_inactive]&_openSIS_PDF=true&head_html=Student+Report+Card method=POST target=_blank>";
	}

	$extra['link'] = array('FULL_NAME'=>false);
	$extra['SELECT'] = ",s.STUDENT_ID AS CHECKBOX";
	$extra['functions'] = array('CHECKBOX'=>'_makeChooseCheckbox');
	$extra['columns_before'] = array('CHECKBOX'=>'</A><INPUT type=checkbox value=Y name=controller checked onclick="checkAll(this.form,this.form.controller.checked,\'st_arr\');"><A>');
	$extra['options']['search'] = false;
	$extra['new'] = true;
	//$extra['force_search'] = true;

	Search('student_id',$extra,'true');
	if($_REQUEST['search_modfunc']=='list')
	{
		if($_SESSION['count_stu']!=0)
		echo '<BR><CENTER><INPUT type=submit class=btn_xxlarge value=\'Create Enrollment Report for Selected Students\'></CENTER>';
		echo "</FORM>";
	}
}

function _makeChooseCheckbox($value,$title)
{
	return '<INPUT type=checkbox name=st_arr[] value='.$value.' checked>';
}

function _makeTeacher($teacher,$column)
{
	return substr($teacher,strrpos(str_replace(' - ',' ^ ',$teacher),'^')+2);
}
?>