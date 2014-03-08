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
###########################################
#print_r($_REQUEST);
if(isset($_REQUEST['staff_id']) && $_REQUEST['staff_id']!='new')
{
	//if(UserStudentID())
	//	echo '<IMG SRC=assets/pixel_trans.gif height=2>';
            $RET = DBGet(DBQuery('SELECT FIRST_NAME,LAST_NAME FROM staff WHERE STAFF_ID=\''.$_REQUEST['staff_id'].'\''));
            $count_staff_RET=DBGet(DBQuery('SELECT COUNT(*) AS NUM FROM staff'));
            if($count_staff_RET[1]['NUM']>1){
                DrawHeaderHome( 'Selected User: '.$RET[1]['FIRST_NAME'].'&nbsp;'.$RET[1]['LAST_NAME'].' (<A HREF=Side.php?staff_id=new&modcat='.$_REQUEST['modcat'].'><font color=red>Deselect</font></A>) | <A HREF=Modules.php?modname='.$_REQUEST['modname'].'&search_modfunc=list&next_modname=Users/User.php&ajax=true&bottom_back=true&return_session=true target=body>Back to User List</A>');
            }else{
                DrawHeaderHome( 'Selected User: '.$RET[1]['FIRST_NAME'].'&nbsp;'.$RET[1]['LAST_NAME'].' (<A HREF=Side.php?staff_id=new&modcat='.$_REQUEST['modcat'].'><font color=red>Deselect</font></A>)');
            }
}
#############################################
if(User('PROFILE')!='admin' && User('PROFILE')!='teacher' && $_REQUEST['staff_id'] && $_REQUEST['staff_id']!='new')
{
	if(User('USERNAME'))
	{
		HackingLog();

    }
	exit;
}

if(!$_REQUEST['include'])
{
	$_REQUEST['include'] = 'General_Info';
	$_REQUEST['category_id'] = '1';
}
elseif(!$_REQUEST['category_id'])
	if($_REQUEST['include']=='General_Info')
		$_REQUEST['category_id'] = '1';
	elseif($_REQUEST['include']=='Schedule')
		$_REQUEST['category_id'] = '2';
        
	elseif($_REQUEST['include']!='Other_Info')
	{
		$include = DBGet(DBQuery('SELECT ID FROM staff_field_categories WHERE INCLUDE=\''.$_REQUEST['include'].'\''));
		$_REQUEST['category_id'] = $include[1]['ID'];
	}

if(User('PROFILE')!='admin')
{
	if(User('PROFILE_ID'))
		$can_edit_RET = DBGet(DBQuery('SELECT MODNAME FROM profile_exceptions WHERE PROFILE_ID=\''.User('PROFILE_ID').'\' AND MODNAME=\''.'Users/User.php&category_id='.$_REQUEST[category_id].'\' AND CAN_EDIT=\''.'Y'.'\''));
	else
		$can_edit_RET = DBGet(DBQuery('SELECT MODNAME FROM staff_exceptions WHERE USER_ID=\''.User('STAFF_ID').'\' AND MODNAME=\''.'Users/User.php&category_id='.$_REQUEST[category_id].'\' AND CAN_EDIT=\''.'Y'.'\''),array(),array('MODNAME'));
	if($can_edit_RET)
		$_openSIS['allow_edit'] = true;
}

unset($schools);
if(clean_param($_REQUEST['modfunc'],PARAM_ALPHAMOD)=='update')
{
//if($_REQUEST['values']['SCHOOLS'])
//{
//     if($_SESSION[staff_school_chkbox_id]!=count($_REQUEST['values']['SCHOOLS']))
//     {  
//         foreach($_REQUEST['values']['SCHOOLS'] as $index=>$values)
//        {
//         $school_id=DBGet(DBQuery("SELECT SCHOOL_ID FROM staff_school_relationship WHERE staff_id='".$_REQUEST['staff_id']."' AND school_id!='".$index."'"));
//        print_r($school_id[1]);
//        }
//     }
//}
  if(count($_REQUEST['month_staff']))
    {
        foreach($_REQUEST['month_staff'] as $column=>$value)
        {
            $_REQUEST['staff'][$column] = $_REQUEST['day_staff'][$column].'-'.$_REQUEST['month_staff'][$column].'-'.$_REQUEST['year_staff'][$column];
            if($_REQUEST['staff'][$column]=='--')
            $_REQUEST['staff'][$column] = '';
            elseif(!VerifyDate($_REQUEST['staff'][$column]))
            {
                unset($_REQUEST['staff'][$column]);
                $note = "The invalid date could not be saved.";
            }
        }
    }
    unset($_REQUEST['day_staff']); unset($_REQUEST['month_staff']); unset($_REQUEST['year_staff']);
   
    if($_REQUEST['values']['SCHOOLS'])
	{
        $school_array=$_REQUEST['values']['SCHOOLS'];
        $cur_school=array_keys($school_array);
        $_REQUEST['staff']['CURRENT_SCHOOL_ID'] = $cur_school[0];
	}
                        $password = md5($_REQUEST[staff][PASSWORD]);
		        $ins_profile=$_REQUEST[staff][PROFILE];
                        $res_pass_chk = DBQuery('SELECT * FROM staff WHERE PASSWORD = \''.$password.'\'');
                        $num_pass = mysql_num_rows($res_pass_chk);
	if(count($_POST['staff']) && (User('PROFILE')=='admin' || basename($_SERVER['PHP_SELF'])!='index.php') || $_REQUEST['ajax'])
	{
                $day_valid=true;
		if($_REQUEST['staff_id'] && $_REQUEST['staff_id']!='new')
		{ 
            $sql=DBQuery('select password from staff where password=\''.$password.'\'');
                    $number=mysql_num_rows($sql);
                    
                    
//                    if($_REQUEST['staff']['PROFILE']!= '')
//                    {
//                       
//                      if($_REQUEST['staff']['PROFILE'] != '1')
//                       {
//                          
//                          
//                            $sql=DBQuery("select password from staff where password='".$password."' and profile='admin' AND SYEAR='".UserSyear()."'");
//                            $number=mysql_num_rows($sql);
//                            
//            
//                        }
//                       else
//                       {
//                            $sql=DBQuery("select password from staff where password='".$password."'  AND SYEAR='".UserSyear()."'");
//                            $number=mysql_num_rows($sql); 
//                            
//                       }
//                    }
//                    if($_REQUEST['staff']['PROFILE']== '')
//                    {
//                      $profile=DBGet(DBQuery("SELECT profile FROM staff WHERE STAFF_ID='$_REQUEST[staff_id]' "));
//                        if($profile[1]['PROFILE']!='admin')
//                        {
//                          $res_pass_chk = DBQuery("SELECT * FROM staff WHERE PASSWORD = '".$password."' AND PROFILE='admin'");
//                          $number = mysql_num_rows($res_pass_chk);
//                        }
//                        if($profile[1]['PROFILE']=='admin')
//                        {
//                          $res_pass_chk = DBQuery("SELECT * FROM staff WHERE PASSWORD = '".$password."'");
//                          $number = mysql_num_rows($res_pass_chk);
//                        }
//                        
//                    }
                    
                        if($number!=0)
                        {
                            echo '<font color = red><b>Invalid password</b></font>';
                        }
		       if($number==0)
		        {
			$profile_RET = DBGet(DBQuery('SELECT PROFILE,PROFILE_ID,USERNAME FROM staff WHERE STAFF_ID=\''.$_REQUEST[staff_id].'\''));
    
			if(isset($_REQUEST['staff']['PROFILE']) && $_REQUEST['staff']['PROFILE']!=$profile_RET[1]['PROFILE_ID'])
			{
				if($_REQUEST['staff']['PROFILE']=='admin')
					$_REQUEST['staff']['PROFILE_ID'] = '1';
				elseif($_REQUEST['staff']['PROFILE']=='teacher')
					$_REQUEST['staff']['PROFILE_ID'] = '2';
				elseif($_REQUEST['staff']['PROFILE']=='parent')
					$_REQUEST['staff']['PROFILE_ID'] = '3';
			}
			if($_REQUEST['staff']['PROFILE_ID'])
				DBQuery('DELETE FROM staff_exceptions WHERE USER_ID=\''.$_REQUEST[staff_id].'\'');
			elseif(isset($_REQUEST['staff']['PROFILE_ID']) && $profile_RET[1]['PROFILE_ID'])
			{ 
				DBQuery('DELETE FROM staff_exceptions WHERE USER_ID=\''.$_REQUEST[staff_id].'\'');
				DBQuery('INSERT INTO staff_exceptions (USER_ID,MODNAME,CAN_USE,CAN_EDIT) SELECT s.STAFF_ID,e.MODNAME,e.CAN_USE,e.CAN_EDIT FROM staff s,profile_exceptions e WHERE s.STAFF_ID=\''.$_REQUEST[staff_id].'\' AND s.PROFILE_ID=e.PROFILE_ID');
			}

                        elseif(!$profile_RET[1]['PROFILE_ID'])
                        {
                            DBQuery('DELETE FROM staff_exceptions WHERE USER_ID=\''.$_REQUEST[staff_id].'\'');
                            DBQuery('INSERT INTO staff_exceptions (USER_ID,MODNAME,CAN_USE,CAN_EDIT) SELECT s.STAFF_ID,e.MODNAME,e.CAN_USE,e.CAN_EDIT FROM staff s,profile_exceptions e WHERE s.STAFF_ID=\''.$_REQUEST[staff_id].'\' AND e.PROFILE_ID='.$_REQUEST['staff']['PROFILE']);
                        }

			if($_REQUEST['staff']['USERNAME'] && $_REQUEST['staff']['USERNAME']!=$profile_RET[1]['USERNAME'])
			{
				$existing_staff = DBGet(DBQuery('SELECT ssr.SYEAR FROM staff s,staff_school_relationship ssr WHERE s.STAFF_ID=ssr.STAFF_ID AND s.USERNAME=\''.$_REQUEST['staff']['USERNAME'].'\' AND ssr.SYEAR=(SELECT SYEAR FROM staff_school_relationship WHERE STAFF_ID=\''.$_REQUEST[staff_id].'\')'));
				if(count($existing_staff))
					BackPrompt('A user with that username already exists for the '.$existing_staff[1]['SYEAR'].' school year. Choose a different username and try again.');
			}
                                                      $go=false;
			$sql = 'UPDATE staff SET ';
			foreach($_REQUEST['staff'] as $column_name=>$value)
                                                      {
                                                            if((User('PROFILE')!='admin' || $_REQUEST['category_id']!=1) && $column_name=='SCHOOLS')
                                                                continue;
                                                        if (get_magic_quotes_gpc()) {
                                                         $value=stripcslashes( $value);
                                                        }
                                                            $value=paramlib_validation($column_name,trim($value));
                    if(strpos($column_name,"CUSTOM")==0)
                    {
                                                                $go=true;
                                                                $custom=DBGet(DBQuery('SHOW COLUMNS FROM staff WHERE FIELD=\''.$column_name.'\''));
                                                                 $custom=$custom[1];
                                                                if($custom['NULL']=='NO' && trim($value)=='' && $custom['DEFAULT']){
                                                                    $value=$custom['DEFAULT'];
                                                                }elseif($custom['NULL']=='NO' && (is_array($value)? count($value)==0 : trim($value)=='')){
				$custom_id=str_replace("CUSTOM_","",$column_name);
				$custom_TITLE=DBGet(DBQuery('SELECT TITLE FROM staff_fields WHERE ID='.$custom_id));
				$custom_TITLE=$custom_TITLE[1]['TITLE'];
				echo "<font color=red><b>Unable to save data, because ".$custom_TITLE.' is required.</b></font><br/>';
				$error=true;
				}else{
				
                                        $custom_id=str_replace("CUSTOM_","",$column_name);
                                        $m_custom_RET=DBGet(DBQuery('SELECT ID,TITLE,TYPE from staff_fields WHERE ID=\''.$custom_id.'\' AND TYPE=\''.'multiple'.'\''));
                                        if($m_custom_RET)
                                        {
                                                $str="";

                                                foreach($value as $m_custom_val)
                                                {
                                                    if($m_custom_val)
                                                        $str.="||".$m_custom_val;
                                                    }
                                                    if($str)
                                                $value=$str."||";
                                                    else
                                                        $value='';
                                          }
                                                            
                                        }
                                }

                                        if($column_name=='PASSWORD' && $value!='')
                                        {
                                            $go=true;
                                            $sql .= $column_name.'=\''.str_replace("\'","''",str_replace("`","''",md5(trim($value)))).'\',';
                                          }
                                       elseif($column_name=='FIRST_NAME' && $value!='')
                                       {
                                           $go=true;
                                            $sql .= $column_name.'=\''.str_replace("\'","''",str_replace("`","''",trim($value))).'\',';
                                       }
                                        elseif($column_name=='LAST_NAME' && $value!='')
                                       {
                                            $go=true;
                                            $sql .= $column_name.'=\''.str_replace("\'","''",str_replace("`","''",trim($value))).'\',';
                                       }

                                        elseif(strtoupper($column_name)=='PROFILE')
                                        {
                                            $go=true;
                                            $profile_TYPE=DBGet(DBQuery('SELECT PROFILE FROM user_profiles WHERE ID=\''.$value.'\''));
                                            $p_ID=$value;
                                            $value=$profile_TYPE[1]['PROFILE'];

                                            $sql .= $column_name.'=\''.str_replace("\'","''",str_replace("`","''",trim($value))).'\',';
                                            $sql .= 'PROFILE_ID=\''.str_replace("\'","''",str_replace("`","''",$p_ID)).'\',';
                                        }
                                        elseif($column_name=='Permissions')
                                        {
                                            if(!$value)
                                            {
                                                $go=true;
                                                DBQuery('DELETE FROM staff_exceptions WHERE USER_ID=\''.$_REQUEST[staff_id].'\'');
                                                DBQuery('INSERT INTO staff_exceptions (USER_ID,MODNAME,CAN_USE,CAN_EDIT) SELECT s.STAFF_ID,e.MODNAME,e.CAN_USE,e.CAN_EDIT FROM staff s,profile_exceptions e WHERE s.STAFF_ID=\''.$_REQUEST[staff_id].'\' AND s.PROFILE_ID=e.PROFILE_ID');
                                                $sql .= 'PROFILE_ID=\''.str_replace("\'","''",str_replace("`","''",$value)).'\',';
                                            }
                                        }
                                        else
                                        {
                                            $go=true;
                                            $sql .= $column_name.'=\''.str_replace("\'","''",str_replace("'","''",$value)).'\',';
                                        }
                                        }
			$sql = substr($sql,0,-1) . ' WHERE STAFF_ID=\''.$_REQUEST[staff_id].'\'';
                if($error!=true && $go==true)
                                        {
                                          DBQuery($sql);      
                                               
//                    $disabled='NULL';
//                    $other_RET=  DBGet(DBQuery("SELECT SCHOOL_ID,IS_DISABLE FROM  staff_school_relationship WHERE syear=".  UserSyear()." AND staff_id=".$_REQUEST[staff_id]),array(),array('SCHOOL_ID'));
                    if(isset($_REQUEST['staff']['IS_DISABLE']) && $_REQUEST['staff']['IS_DISABLE']!='Y'){
                        DBQuery('UPDATE staff SET FAILED_LOGIN=0,LAST_LOGIN=NOW() WHERE STAFF_ID=\''.$_REQUEST[staff_id].'\'');
                    }
                    if($_REQUEST['category_id']==1)
                    {  
                        $sql_school_admin='SELECT ssr.SCHOOL_ID FROM schools s,staff st INNER JOIN staff_school_relationship ssr USING(staff_id) WHERE s.id=ssr.school_id AND ssr.syear='.UserSyear().' AND st.staff_id='.User('STAFF_ID');
                        $school_admin=DBGet(DBQuery($sql_school_admin)); 
                       foreach($school_admin as $index=>$school)
                       {
                           if($_REQUEST['day_values']['START_DATE'][$school['SCHOOL_ID']])
                            {
                                //$start_date=$_REQUEST['year_values']['START_DATE'][$school['SCHOOL_ID']]."-".$_REQUEST['month_values']['START_DATE'][$school['SCHOOL_ID']]."-".$_REQUEST['day_values']['START_DATE'][$school['SCHOOL_ID']];
                                $start_date=$_REQUEST['day_values']['START_DATE'][$school['SCHOOL_ID']]."-".$_REQUEST['month_values']['START_DATE'][$school['SCHOOL_ID']]."-".$_REQUEST['year_values']['START_DATE'][$school['SCHOOL_ID']];
                            }
                            else
                            {
                                $start_date='';
                            }
                            if($_REQUEST['day_values']['END_DATE'][$school['SCHOOL_ID']])
                            {
                                //$end_date=$_REQUEST['year_values']['END_DATE'][$school['SCHOOL_ID']]."-".$_REQUEST['month_values']['END_DATE'][$school['SCHOOL_ID']]."-".$_REQUEST['day_values']['END_DATE'][$school['SCHOOL_ID']];
                                $end_date=$_REQUEST['day_values']['END_DATE'][$school['SCHOOL_ID']]."-".$_REQUEST['month_values']['END_DATE'][$school['SCHOOL_ID']]."-".$_REQUEST['year_values']['END_DATE'][$school['SCHOOL_ID']];
                            }
                            else
                            {
                                $end_date='';
                            } 
                            if(($start_date!='' && VerifyDate($start_date)) || ($end_date!='' && VerifyDate($end_date)) || ($start_date=='' && $end_date==''))
                            {
                           if(in_array($school['SCHOOL_ID'], $cur_school))
                           {
                               $schools_each_staff= DBGet(DBQuery('SELECT SCHOOL_ID,START_DATE,END_DATE FROM staff_school_relationship WHERE staff_id=\''.$_REQUEST[staff_id].'\' AND syear=\''.UserSyear().'\' AND SCHOOL_ID='.$school['SCHOOL_ID']));
                               //print_r($schools_each_staff);
                               if($schools_each_staff[1]['START_DATE']>$end_date && $end_date!='')
                               {
                                   $error='end_date';
                               }
//                               if($start_date=='')
//                               {
////                                  
//                                   $error='start_date';
//                               }
                               if(!empty($schools_each_staff))
                               {
                                
                                if($start_date!='' && $end_date!='')
                                {
        
                                    $sql_up='UPDATE staff_school_relationship SET START_DATE=\''.date('Y-m-d',  strtotime($start_date)).'\', END_DATE=\''.date('Y-m-d',  strtotime($end_date)).'\' where staff_id=\''.$_REQUEST[staff_id].'\' AND syear=\''.UserSyear().'\' AND SCHOOL_ID=\''.$school['SCHOOL_ID'].'\'';
                                }
                                elseif($start_date=='' && $end_date!='')
                                {
                                    $sql_up='UPDATE staff_school_relationship SET END_DATE=\''.date('Y-m-d',  strtotime($end_date)).'\' where staff_id=\''.$_REQUEST[staff_id].'\' AND syear=\''.UserSyear().'\' AND SCHOOL_ID=\''.$school['SCHOOL_ID'].'\'';
                                }
                                elseif($start_date!='' && $end_date=='')
                                {
                                    $sql_up='UPDATE staff_school_relationship SET START_DATE=\''.date('Y-m-d',  strtotime($start_date)).'\' where staff_id=\''.$_REQUEST[staff_id].'\' AND syear=\''.UserSyear().'\' AND SCHOOL_ID=\''.$school['SCHOOL_ID'].'\'';
                                }
                                if(!$error && $sql_up!='')
                                {
                                    DBQuery($sql_up);
                                }
                               }
                               else
                               {
                                   //echo "insert need";
                                   $sql_up='INSERT INTO staff_school_relationship(staff_id,syear,school_id,start_date';
                                   if($end_date!='')
                                   {
                                       $sql_up.=',end_date';
                                   }
                                   $sql_up.=')VALUES(\''.$_REQUEST[staff_id].'\',\''.UserSyear().'\',\''.$school['SCHOOL_ID'].'\',\''.date('Y-m-d',strtotime($start_date)).'\'';
                                   if($end_date!='')
                                   {
                                       $sql_up.=',\''.date('Y-m-d',strtotime($end_date)).'\'';
                                   }
                                   $sql_up.=')';
//                                   if($start_date=='')
//                               {
//                                       
//                                   $error='start_date';
//                               }
//                               else
//                               {
                                   DBQuery($sql_up);
//                               }
                               # DBQuery('INSERT INTO staff_school_relationship(staff_id,syear,school_id,start_date)VALUES(\''.$_REQUEST[staff_id].'\',\''.UserSyear().'\',\''.$school['SCHOOL_ID'].'\',\''.date('Y-m-d').'\')');
                               }
                           }
                           else
                           {
                              $schools_each_staff= DBGet(DBQuery('SELECT SCHOOL_ID,START_DATE,END_DATE FROM staff_school_relationship WHERE staff_id=\''.$_REQUEST[staff_id].'\' AND syear=\''.UserSyear().'\' AND SCHOOL_ID='.$school['SCHOOL_ID']));
                               //print_r($schools_each_staff);
                               if(!empty($schools_each_staff))
                               {
                                   if($schools_each_staff[1]['START_DATE']>$end_date && $end_date!='')
                               {
                                   $error='end_date';
                               }
//                               if($start_date=='')
//                               {
//                                     
//                                   $error='start_date';
//                               }
                                   
                                   if($end_date!='')
                                    {
                                        $sql_up='UPDATE staff_school_relationship SET END_DATE=\''.date('Y-m-d',  strtotime($end_date)).'\' where staff_id=\''.$_REQUEST[staff_id].'\' AND syear=\''.UserSyear().'\' AND SCHOOL_ID=\''.$school['SCHOOL_ID'].'\'';
                                    }
                                    elseif($start_date=='' && $end_date!='')
                                    {
                                        $sql_up='UPDATE staff_school_relationship SET END_DATE=\''.date('Y-m-d',  strtotime($end_date)).'\' where staff_id=\''.$_REQUEST[staff_id].'\' AND syear=\''.UserSyear().'\' AND SCHOOL_ID=\''.$school['SCHOOL_ID'].'\'';
                                    }
                                    elseif($end_date=='')
                                    {
                                        if($schools_each_staff[1]['END_DATE']=='0000-00-00')
                                        {
                                            $sql_up='UPDATE staff_school_relationship SET END_DATE=\''.date('Y-m-d').'\' where staff_id=\''.$_REQUEST[staff_id].'\' AND syear=\''.UserSyear().'\' AND SCHOOL_ID=\''.$school['SCHOOL_ID'].'\''; 
                                        }
                                    }
                                    if(!$error && $sql_up!='')
                                    {
                                        DBQuery($sql_up);
                                    }
                               } 
                           }
                         
                      
                       }
                        else
                        {
                            $err= "<center><font color=red><b>The invalid date could not be saved.</b><font></center>";
                        }
                      
                       
                       }
//                    $rel_value=substr($rel_value,0,-1);
//                   # DBQuery('INSERT INTO staff_school_relationship(staff_id,school_id,syear)VALUES{\''.$rel_value.'\'}');
//                    #echo $sql="INSERT INTO staff_school_relationship(staff_id,school_id,syear)VALUES{$rel_value}";
//                    DBQuery("INSERT INTO staff_school_relationship(staff_id,school_id,syear)VALUES{$rel_value}");
                        
                }
               echo $err;
                                        }
		}
		}
                                    elseif($num_pass != 0){
                                        echo '<font color = red><b>Invalid password</b></font>';
                                        $_REQUEST['staff_id'] = 'new';
                                    }
		else
		{
			if($_REQUEST['staff']['PROFILE']=='admin')
				$_REQUEST['staff']['PROFILE_ID'] = '1';
			elseif($_REQUEST['staff']['PROFILE']=='teacher')
				$_REQUEST['staff']['PROFILE_ID'] = '2';
			elseif($_REQUEST['staff']['PROFILE']=='parent')
				$_REQUEST['staff']['PROFILE_ID'] = '3';
            $existing_staff = DBGet(DBQuery('SELECT \''.'exists'.'\' FROM staff WHERE USERNAME=\''.$_REQUEST['staff']['USERNAME'].'\''));
			$sql = 'INSERT INTO staff ';
            $fields = '';
            $values = '';
			if(basename($_SERVER['PHP_SELF'])=='index.php')
			{
				$fields .= 'PROFILE,';
							$values = "'".Config('SYEAR')."'".substr($values,strpos($values,','))."'none',";
			}

			foreach($_REQUEST['staff'] as $column=>$value)
			{
                            $value=trim($value);
                if(strpos($column,"CUSTOM")==0)
                {
                                    $custom=DBGet(DBQuery('SHOW COLUMNS FROM staff WHERE FIELD=\''.$column.'\''));
                                    $custom=$custom[1];
                    if($custom['NULL']=='NO' && trim($value)=='' && !$custom['DEFAULT'])
                    {
                                           $custom_id=str_replace("CUSTOM_","",$column);
                                           $custom_TITLE=DBGet(DBQuery('SELECT TITLE FROM staff_fields WHERE ID='.$custom_id));
                                           $custom_TITLE=$custom_TITLE[1]['TITLE'];
                                           $required_faild_error=true;
                                           $error=true;
                    }
                    else
                    {
                                           $custom_id=str_replace("CUSTOM_","",$column);
                                           $m_custom_RET=DBGet(DBQuery('SELECT ID,TITLE,TYPE from staff_fields WHERE ID=\''.$custom_id.'\' AND TYPE=\''.'multiple'.'\''));
                                           if($m_custom_RET)
                                             {
                                               $str="";
                                               foreach($value as $m_custom_val)
                                                {
                                                   if($m_custom_val)
                                                    $str.="||".$m_custom_val;
                                                }
                                                if($str)
                                               $value=$str."||";
                                                else
                                                    $value='';
                                              }

                                         }
                                     }
                                     if(trim($value))
				{
                                    $value=paramlib_validation($column,$value);
					$fields .= $column.',';
					if(strtoupper($column)=='PASSWORD')
						$values .= "'".str_replace("\'","''",md5($value))."',";
					elseif(strtoupper($column)=='PROFILE')
					 {
					  
					  $profile_TYPE=DBGet(DBQuery('SELECT PROFILE FROM user_profiles WHERE ID=\''.$value.'\''));
					   $P_id=$value;
					   $value=$profile_TYPE[1]['PROFILE'];
					   $values .= '\''.str_replace("\'","''",$value).'\',';
					   $fields .= 'PROFILE_ID'.',';
					   $values .= '\''.str_replace("\'","''",$P_id).'\',';
					 }
					else
					$values .= '\''.str_replace("\'","''",str_replace("'","''",$value)).'\',';
				}
			}
			$sql .= '(' . substr($fields,0,-1) . ') values(' . substr($values,0,-1) . ')';
			
			$uname = $_REQUEST[staff][USERNAME];
			$flag1 = 0;
            $res_user_chk = DBQuery('SELECT staff_id FROM staff WHERE username = \''.$uname.'\'');
			$num_user = mysql_num_rows($res_user_chk);
			
			if($num_user != 0){
				$flag1 = 1;
			}
            $res_user_chk_stu = DBQuery('SELECT student_id FROM students WHERE username = \''.$uname.'\'');
			$num_user_stu = mysql_num_rows($res_user_chk_stu);
			
			if($num_user_stu != 0){
				$flag1 = 2;
			}

					
			if($flag1 == 0 && $error!=true)
			{
				DBQuery($sql);
				
				
				$staff_id = DBGet(DBQuery('SELECT MAX(staff_id) AS ID FROM staff'));
                                $staff_id = $staff_id[1]['ID'];
                if($school_array)
                {
                    $rel_value='';
                    foreach($school_array as $school_id=>$yes)
                    {
                            if($_REQUEST['day_values']['START_DATE'][$school_id])
                            {
                                $start_date=$_REQUEST['day_values']['START_DATE'][$school_id]."-".$_REQUEST['month_values']['START_DATE'][$school_id]."-".$_REQUEST['year_values']['START_DATE'][$school_id];
                            }
                            else
                            {
                                $start_date='';
                            }
                            if($_REQUEST['day_values']['END_DATE'][$school_id])
                            {
                                $end_date=$_REQUEST['day_values']['END_DATE'][$school_id]."-".$_REQUEST['month_values']['END_DATE'][$school_id]."-".$_REQUEST['year_values']['END_DATE'][$school_id];
                            }
                            else
                            {
                                $end_date='';
                            }
                            if($end_date!='')
                            {
                                $end_date=date('Y-m-d',strtotime($end_date));
                            }
                            else
                            {
                                $end_date='0000-00-00';
                            }
                            		
                if(($start_date!='' && VerifyDate($start_date)) || ($end_date!='' && VerifyDate($end_date)) || ($start_date=='' && $end_date==''))
                    {
                        $day_valid=true; 
                        
                        $user_syear_RET=  DBGet(DBQuery('SELECT MAX(syear) AS USERSYEAR FROM school_years WHERE school_id=\''.$school_id.'\''));
                        $usersyear = $user_syear_RET[1]['USERSYEAR'];
                        $rel_value .="($staff_id,$school_id,$usersyear,'".date('Y-m-d',strtotime($start_date))."','".$end_date."'),";
                    }
                    else
                    {
                        $day_valid=true;
                        $user_syear_RET=  DBGet(DBQuery('SELECT MAX(syear) AS USERSYEAR FROM school_years WHERE school_id=\''.$school_id.'\''));
                        $usersyear = $user_syear_RET[1]['USERSYEAR'];
                        $rel_value .="($staff_id,$school_id,$usersyear,'0000-00-00','".$end_date."'),";
                    }
                    }
                    $rel_value=substr($rel_value,0,-1);
                }
           
                #DBQuery('INSERT INTO staff_school_relationship(staff_id,school_id,syear)VALUES{\''.$rel_value.'\'}');
                #echo $sql="INSERT INTO staff_school_relationship(staff_id,school_id,syear,start_date)VALUES{$rel_value}";
                //echo $error."as;
                
                 DBQuery("INSERT INTO staff_school_relationship(staff_id,school_id,syear,start_date,end_date)VALUES{$rel_value}");
				$_SESSION['staff_id'] = $_REQUEST['staff_id'] = $staff_id;
               
               
                             }
			
			else
			{
				if($required_faild_error==true)
                                                                            echo "<font color=red><b>Unable to save data, because ".$custom_TITLE.' is required.</b></font><br/>';
                                                                        else
                                                                            echo '<font color = red><b>Specified username is already taken! Please try again with a different user name.</b></font>';
				$_REQUEST['staff_id'] = 'new';
			}

		}
	}
        if($day_valid==false)
        {
            echo "<center><font color=red><b>Invalid date could not be saved.</b><font></center>";
        }
        if($error=='end_date')
        {
            echo "<font color=red><b>Start date can not be greater than End date</b></font><br/>";
            unset($error);
            if($_REQUEST['staff_id']=='new')
            {
                header("location:modules/Users/User.php&staff_id=new");
            }
        }
        if($error=='start_date')
        {
            echo "<font color=red><b>Start date can not be blank</b></font><br/>";
            unset($error);
//            if($_REQUEST['staff_id']=='new')
//            {
                #header("location:/modules/Users/User.php&staff_id=new");
//            }
           # echo "<script>window.location.href='\modules\Users\User.php&staff_id=new'</scrpipt>";
        }
	unset($_REQUEST['staff']);
	unset($_REQUEST['modfunc']);
	unset($_SESSION['_REQUEST_vars']['staff']);
	unset($_SESSION['_REQUEST_vars']['modfunc']);
        unset($_REQUEST['values']);
        unset($_REQUEST['month_values']);
        unset($_REQUEST['day_values']);
        unset($_REQUEST['year_values']);
	if(User('STAFF_ID')==$_REQUEST['staff_id'])
	{
		unset($_openSIS['User']);
		echo '<script language=JavaScript>parent.side.location="'.$_SESSION['Side_PHP_SELF'].'?modcat="+parent.side.document.forms[0].modcat.value;</script>';
	}
}

$extra['SELECT'] = ',LAST_LOGIN';
#$extra['columns_after'] = array('LAST_LOGIN'=>'Last Login');
$extra['functions'] = array('LAST_LOGIN'=>'makeLogin');

if(basename($_SERVER['PHP_SELF'])!='index.php')
{
	if($_REQUEST['staff_id']=='new')
		DrawBC("Users > Add a User");
	else
		DrawBC("Users > ".ProgramTitle());
	Search('staff_id',$extra);
}
else
	DrawHeader('Create Account');

if(clean_param($_REQUEST['modfunc'],PARAM_ALPHAMOD)=='delete' && basename($_SERVER['PHP_SELF'])!='index.php' && AllowEdit())
{
	if(DeletePrompt('user'))
	{
		DBQuery('DELETE FROM program_user_config WHERE USER_ID=\''.UserStaffID().'\'');
		DBQuery('DELETE FROM staff_exceptions WHERE USER_ID=\''.UserStaffID().'\'');
		DBQuery('DELETE FROM students_join_users WHERE STAFF_ID=\''.UserStaffID().'\'');
		DBQuery('DELETE FROM staff WHERE STAFF_ID=\''.UserStaffID().'\'');
		unset($_SESSION['staff_id']);
		unset($_REQUEST['staff_id']);
		unset($_REQUEST['modfunc']);
		echo '<script language=JavaScript>parent.side.location="'.$_SESSION['Side_PHP_SELF'].'?modcat="+parent.side.document.forms[0].modcat.value;</script>';
		Search('staff_id',$extra);
	}
}

if((UserStaffID() || $_REQUEST['staff_id']=='new') && ((basename($_SERVER['PHP_SELF'])!='index.php') || !$_REQUEST['staff']['USERNAME']) && $_REQUEST['modfunc']!='delete')
{
    
	if($_REQUEST['staff_id']!='new')
	{
		
				$sql = 'SELECT s.TITLE,s.STAFF_ID,s.FIRST_NAME,s.LAST_NAME,s.MIDDLE_NAME,
                                s.USERNAME,s.PASSWORD,up.TITLE AS PROFILE,s.PROFILE_ID,s.PHONE,s.EMAIL,s.LAST_LOGIN,IS_DISABLE
				FROM staff s,user_profiles up WHERE s.STAFF_ID=\''.UserStaffID().'\' AND s.PROFILE_ID=up.ID';
		$QI = DBQuery($sql);
		$staff = DBGet($QI);
                if(!$staff)
                {
                    $staff = DBGet(DBQuery('SELECT s.TITLE,s.STAFF_ID,s.FIRST_NAME,s.LAST_NAME,s.MIDDLE_NAME,
                                                s.USERNAME,s.PASSWORD,s.CURRENT_SCHOOL_ID,up.TITLE AS PROFILE,s.PROFILE_ID,s.PHONE,s.EMAIL,s.LAST_LOGIN,IS_DISABLE
				FROM staff s,user_profiles up WHERE s.STAFF_ID=\''.UserStaffID().'\' AND s.PROFILE=up.PROFILE'));
                }
		$staff = $staff[1];
		echo "<FORM name=staff id=staff action=Modules.php?modname=$_REQUEST[modname]&include=$_REQUEST[include]&category_id=$_REQUEST[category_id]&staff_id=".UserStaffID()."&modfunc=update method=POST >";
	}
	elseif(basename($_SERVER['PHP_SELF'])!='index.php')
        {
            $staff=array();
            echo "<FORM name=staff id=staff action=Modules.php?modname=$_REQUEST[modname]&include=$_REQUEST[include]&category_id=$_REQUEST[category_id]&modfunc=update method=POST>";
        }
        else
		echo "<FORM name=F2 id=F2 action=index.php?modfunc=create_account METHOD=POST>";

	if(basename($_SERVER['PHP_SELF'])!='index.php')
	{
		if(UserStaffID() && UserStaffID()!=User('STAFF_ID') && UserStaffID()!=$_SESSION['STAFF_ID'] && User('PROFILE')=='admin')
			$delete_button = '<INPUT type=button class=btn_medium value=Delete onclick="window.location=\'Modules.php?modname='.$_REQUEST['modname'].'&modfunc=delete\'">';
	}
	
	if(User('PROFILE_ID'))
		$can_use_RET = DBGet(DBQuery('SELECT MODNAME FROM profile_exceptions WHERE PROFILE_ID=\''.User('PROFILE_ID').'\' AND CAN_USE=\''.'Y'.'\''),array(),array('MODNAME'));
	else
		$can_use_RET = DBGet(DBQuery('SELECT MODNAME FROM staff_exceptions WHERE USER_ID=\''.User('STAFF_ID').'\' AND CAN_USE=\''.'Y'.'\''),array(),array('MODNAME'));
	$profile = DBGet(DBQuery("SELECT PROFILE FROM staff WHERE STAFF_ID='".UserStaffID()."'"));
	
	$profile = $profile[1]['PROFILE'];
	$categories_RET = DBGet(DBQuery('SELECT ID,TITLE,INCLUDE FROM staff_field_categories WHERE '.($profile?strtoupper($profile).'=\'Y\'':'ID=\'1\'').' ORDER BY SORT_ORDER,TITLE'));

	foreach($categories_RET as $category)
	{
		if($can_use_RET['Users/User.php&category_id='.$category['ID']])
		{
				if($category['ID']=='1')
					$include = 'General_Info';
				elseif($category['ID']=='2')
					$include = 'Schedule';
				elseif($category['INCLUDE'])
					$include = $category['INCLUDE'];
				else
					$include = 'Other_Info';

			$tabs[] = array('title'=>$category['TITLE'],'link'=>"Modules.php?modname=$_REQUEST[modname]&include=$include&category_id=".$category['ID']);
		}
	}
         
        
        //print_r($school_admin);
//        echo $parameter;
	$_openSIS['selected_tab'] = "Modules.php?modname=$_REQUEST[modname]&include=$_REQUEST[include]";
	if($_REQUEST['category_id'])
		$_openSIS['selected_tab'] .= '&category_id='.$_REQUEST['category_id'];

	echo '<BR>';
	PopTable('header',$tabs,'width=96%');
        
        
	if(!strpos($_REQUEST['include'],'/'))
		include('modules/Users/includes/'.$_REQUEST['include'].'.inc.php');
	else
	{
		include('modules/'.$_REQUEST['include'].'.inc.php');
		$separator = '<HR>';
		include('modules/Users/includes/Other_Info.inc.php');
	}
        
	PopTable('footer');
        $sql='SELECT count(s.ID) as schools FROM schools s,staff st INNER JOIN staff_school_relationship ssr USING(staff_id) WHERE s.id=ssr.school_id AND ssr.syear='.UserSyear().' AND st.staff_id='.User('STAFF_ID');
        $school_admin=DBGet(DBQuery($sql));
	echo '<CENTER>'.SubmitButton('Save','','class=btn_medium onclick="return formcheck_user_user('.$_SESSION[staff_school_chkbox_id].');"').'</CENTER>';
        #echo '<CENTER>'.SubmitButton('Save','','class=btn_medium onclick="return formcheck_user_user('.$school_admin[1]['SCHOOLS'].');"').'</CENTER>';
        echo '</FORM>';
}
?>
