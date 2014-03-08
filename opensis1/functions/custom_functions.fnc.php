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
function TextAreaInputOrg($value,$name,$title='',$options='',$div=true, $divwidth='500px')
{
	if(Preferences('HIDDEN')!='Y')
		$div = false;

	if(AllowEdit() && !$_REQUEST['_openSIS_PDF'])
	{
		$value = str_replace("'",'&#39;',str_replace('"','&rdquo;',$value));

		if(strpos($options,'cols')===false)
			$options .= ' cols=30';
		if(strpos($options,'rows')===false)
			$options .= ' rows=4';
		$rows = substr($options,strpos($options,'rows')+5,2)*1;
		$cols = substr($options,strpos($options,'cols')+5,2)*1;

		if($value=='' || $div==false)
			return "<TEXTAREA name=$name $options>$value</TEXTAREA>".($title!=''?'<BR><small>'.(strpos(strtolower($title),'<font ')===false?'<FONT color='.Preferences('TITLES').'>':'').$title.(strpos(strtolower($title),'<font ')===false?'</FONT>':'').'</small>':'');
		else
			return "<DIV id='div$name'><div style='width:500px;' onclick='javascript:addHTML(\"<TEXTAREA id=textarea$name name=$name $options>".ereg_replace("[\n\r]",'\u000D\u000A',str_replace("\r\n",'\u000D\u000A',str_replace("'","&#39;",$value)))."</TEXTAREA>".($title!=''?"<BR><small>".str_replace("'",'&#39;',(strpos(strtolower($title),'<font ')===false?'<FONT color='.Preferences('TITLES').'>':'').$title.(strpos(strtolower($title),'<font ')===false?'</FONT>':''))."</small>":'')."\",\"div$name\",true); document.getElementById(\"textarea$name\").value=unescape(document.getElementById(\"textarea$name\").value);'><TABLE class=LO_field height=100%><TR><TD>".((substr_count($value,"\r\n")>$rows)?'<DIV style="overflow:auto; height:'.(15*$rows).'px; width:'.($cols*10).'; padding-right: 16px;">'.nl2br($value).'</DIV>':'<DIV style="overflow:auto; width:'.$divwidth.'; padding-right: 16px;">'.nl2br($value).'</DIV>').'</TD></TR></TABLE>'.($title!=''?'<BR><small>'.str_replace("'",'&#39;',(strpos(strtolower($title),'<font ')===false?'<FONT color='.Preferences('TITLES').'>':'').$title.(strpos(strtolower($title),'<font ')===false?'</FONT>':'')).'</small>':'').'</div></DIV>';
	}
	else
		return (($value!='')?nl2br($value):'-').($title!=''?'<BR><small>'.(strpos(strtolower($title),'<font ')===false?'<FONT color='.Preferences('TITLES').'>':'').$title.(strpos(strtolower($title),'<font ')===false?'</FONT>':'').'</small>':'');
}

function ShowErr($msg)
{
	echo "<script type='text/javascript'>
	document.getElementById('divErr').innerHTML='<font color=red>".$msg."</font>';</script>";
}
function ShowErrPhp($msg)
{
	echo '<font color=red>'.$msg.'<br /></font>';
}
function for_error()
{
 		$css=getCSS(); 		
		echo "<br><br><form action=Modules.php?modname=$_REQUEST[modname] method=post>";
		echo '<BR><CENTER>'.SubmitButton('Try Again','','class=btn_medium').'</CENTER>';
		echo "</form>";	
		echo "</div>";

	echo "</td>
                                        </tr>
                                      </table></td>
                                  </tr>
                                </table></td>
                            </tr>
                          </table></td>
                      </tr>
                    </table></td>
                </tr>
              </table></td>
          </tr>

			<tr>
            <td class=\"footer\">
			<table width=\"100%\" border=\"0\">
  <tr>
    <td align='center' class='copyright'>
       <center>openSIS is a product of Open Solutions for Education, Inc. (<a href='http://www.os4ed.com' target='_blank'>OS4Ed</a>).
                and is licensed under the <a href='http://www.gnu.org/licenses/gpl.html' target='_blank'>GPL License</a>.
                </center></td>
  </tr>
</table>
			</td>
          	</tr>
        </table></td>
    </tr>
  </table>
</center>
</body>
</html>";

		exit();
}



function ExportLink($modname,$title='',$options='')
{
	if(AllowUse($modname))
		$link = '<A HREF=for_export.php?modname='.$modname.$options.'>';
	if($title)
		$link .= $title;
	if(AllowUse($modname))
		$link .= '</A>';

	return $link;
}

function getCSS()
{
		$css='Blue';
		if(User('STAFF_ID'))
		{
		$sql = 'select value from program_user_config where title=\'THEME\' and user_id='.User('STAFF_ID');
		$data = DBGet(DBQuery($sql));
		if(count($data[1]))
		$css=$data[1]['VALUE']; 
		}
		return $css;		
}


function Prompt_Calender($title='Confirm',$question='',$message='',$pdf='')
{	
	$tmp_REQUEST = $_REQUEST;
	unset($tmp_REQUEST['delete_ok']);
	if($pdf==true)
		$tmp_REQUEST['_openSIS_PDF'] = true;
		
	$PHP_tmp_SELF = PreparePHP_SELF($tmp_REQUEST);

	if(!$_REQUEST['delete_ok'] &&!$_REQUEST['delete_cancel'])
	{
		echo '<BR>';
		PopTable('header',$title);
		echo "<CENTER><h4>$question</h4><FORM name=prompt_form id=prompt_form action=$PHP_tmp_SELF&delete_ok=1 METHOD=POST>$message<BR><BR><INPUT type=submit class=btn_medium value=OK onclick='formcheck_school_setup_calender();'>&nbsp;<INPUT type=button class=btn_medium name=delete_cancel value=Cancel onclick='load_link(\"Modules.php?modname=$_REQUEST[modname]\");'></FORM></CENTER>";
		PopTable('footer');
		return false;
	}
	else
		return true;	
}


function Prompt_Copy_School($title='Confirm',$question='',$message='',$pdf='')
{	
	$tmp_REQUEST = $_REQUEST;
	unset($tmp_REQUEST['delete_ok']);
	if($pdf==true)
		$tmp_REQUEST['_openSIS_PDF'] = true;
		
	$PHP_tmp_SELF = PreparePHP_SELF($tmp_REQUEST);

	if(!$_REQUEST['delete_ok'] &&!$_REQUEST['delete_cancel'])
	{
		echo '<BR>';
		PopTable('header',$title);
		echo "<CENTER><h4>$question</h4><FORM name=prompt_form id=prompt_form action=$PHP_tmp_SELF&delete_ok=1 METHOD=POST>$message<BR><BR><INPUT type=submit class=btn_medium value=OK onclick='formcheck_school_setup_copyschool();'>&nbsp;<INPUT type=button class=btn_medium name=delete_cancel value=Cancel onclick='load_link(\"Modules.php?modname=School_Setup/Calendar.php\");'></FORM></CENTER>";
		PopTable('footer');
		return false;
	}
	else
		return true;	
}


function Prompt_rollover($title='Confirm',$question='',$message='',$pdf='')
{	
	$tmp_REQUEST = $_REQUEST;
	unset($tmp_REQUEST['delete_ok']);
	if($pdf==true)
		$tmp_REQUEST['_openSIS_PDF'] = true;
		
	$PHP_tmp_SELF = PreparePHP_SELF($tmp_REQUEST);

	if(!$_REQUEST['delete_ok'] &&!$_REQUEST['delete_cancel'])
	{
		
		PopTable('header',$title);
	//	echo "<CENTER><h4>$question</h4><FORM name=roll_over id=roll_over action=$PHP_tmp_SELF&delete_ok=1 METHOD=POST>$message<BR><BR><INPUT type=submit class=btn_medium value=OK onclick=\"document.roll_over.submit();\">&nbsp;<INPUT type=button class=btn_medium name=delete_cancel value=Cancel onclick='javascript:history.go(-1);'></FORM></CENTER>";
        echo "<CENTER><h4>$question</h4><FORM name=roll_over id=roll_over action=$PHP_tmp_SELF&delete_ok=1 METHOD=POST>";
		echo '<BR><font color=red>Caution : </font>Rollover is an irreversible process.  If you are sure you want to proceed, type in the <BR>effective  roll over date below. You can use the next school year’s attendance start date.<BR><BR>';
		echo DateInput('','roll_start_date','');
		echo '<BR>The following items will be rolled over to the next school year.  Uncheck the item(s) <br/>you do not want to be rolled over. Some items are mandatory and cannot be <br/>unchecked.<BR>';
		echo $message.'<BR>';
		//echo 'hi';
                echo "<BR><BR><INPUT type=submit class=btn_medium value=Rollover onclick=\"return formcheck_rollover();\">&nbsp;<INPUT type=button class=btn_medium name=delete_cancel value=Cancel onclick='load_link(\"Modules.php?modname=Tools/LogDetails.php\");'></FORM></CENTER>";
		PopTable('footer');
		return false;
	}
	else
		return true;	
}

//Added By Shamim AHmed Chowdhury for Synchronize

function Prompt_synchronize($title='Confirm',$question='',$message='',$pdf='')
{	
	$tmp_REQUEST = $_REQUEST;
	unset($tmp_REQUEST['delete_ok']);
	if($pdf==true)
		$tmp_REQUEST['_openSIS_PDF'] = true;
		
	$PHP_tmp_SELF = PreparePHP_SELF($tmp_REQUEST);

	if(!$_REQUEST['delete_ok'] &&!$_REQUEST['delete_cancel'])
	{
		
		PopTable('header',$title);
	//	echo "<CENTER><h4>$question</h4><FORM name=roll_over id=roll_over action=$PHP_tmp_SELF&delete_ok=1 METHOD=POST>$message<BR><BR><INPUT type=submit class=btn_medium value=OK onclick=\"document.roll_over.submit();\">&nbsp;<INPUT type=button class=btn_medium name=delete_cancel value=Cancel onclick='javascript:history.go(-1);'></FORM></CENTER>";
        echo "<CENTER><h4>$question</h4><FORM name=roll_over id=roll_over action=$PHP_tmp_SELF&delete_ok=1 METHOD=POST>";
		echo '<BR><font color=red>Caution : </font>Synchronize is an irreversible process.  If you are sure you want to proceed, type in the <BR>effective  roll over date below. You can use the next school year’s attendance start date.<BR><BR>';
		echo DateInput('','roll_start_date','');
		echo '<BR>The following items will be rolled over to the next school year.  Uncheck the item(s) <br/>you do not want to be rolled over. Some items are mandatory and cannot be <br/>unchecked.<BR>';
		echo $message.'<BR>';
		//echo 'hi';
                echo "<BR><BR><INPUT type=submit class=btn_large value=Synchronize onclick=\"return formcheck_synchronize();\">&nbsp;<INPUT type=button class=btn_medium name=delete_cancel value=Cancel onclick='load_link(\"Modules.php?modname=Tools/LogDetails.php\");'></FORM></CENTER>";
		PopTable('footer');
		return false;
	}
	else
		return true;	
}

function Prompt_synchronize_test($title='Confirm',$question='',$message='',$pdf='')
{	
	$tmp_REQUEST = $_REQUEST;
	unset($tmp_REQUEST['delete_ok']);
	if($pdf==true)
		$tmp_REQUEST['_openSIS_PDF'] = true;
		
	$PHP_tmp_SELF = PreparePHP_SELF($tmp_REQUEST);

	if(!$_REQUEST['delete_ok'] &&!$_REQUEST['delete_cancel'])
	{
		
		PopTable('header',$title);
	//	echo "<CENTER><h4>$question</h4><FORM name=roll_over id=roll_over action=$PHP_tmp_SELF&delete_ok=1 METHOD=POST>$message<BR><BR><INPUT type=submit class=btn_medium value=OK onclick=\"document.roll_over.submit();\">&nbsp;<INPUT type=button class=btn_medium name=delete_cancel value=Cancel onclick='javascript:history.go(-1);'></FORM></CENTER>";
        echo "<CENTER><h4>$question</h4><FORM name=roll_over id=roll_over action=$PHP_tmp_SELF&delete_ok=1 METHOD=POST>";
		echo '<BR><font color=red>Caution : </font>Synchronize is an irreversible process.  If you are sure you want to proceed, type in the <BR>effective  roll over date below. You can use the next school year’s attendance start date.<BR><BR>';
		echo DateInput('','roll_start_date','');
		echo '<BR>The following items will be rolled over to the next school year.  Uncheck the item(s) <br/>you do not want to be rolled over. Some items are mandatory and cannot be <br/>unchecked.<BR>';
		echo $message.'<BR>';
		//echo 'hi';
                echo "<BR><BR><INPUT type=submit class=btn_large value=Apply Changes onclick=\"return formcheck_synchronize();\">&nbsp;<INPUT type=button class=btn_medium name=delete_cancel value=Cancel onclick='load_link(\"Modules.php?modname=Tools/LogDetails.php\");'></FORM></CENTER>";
		PopTable('footer');
		return false;
	}
	else
		return true;	
}

















function Prompt_synchronize_go($title='Confirm',$question='',$pdf='')
{	
	$tmp_REQUEST = $_REQUEST;
	unset($tmp_REQUEST['delete_ok']);
	if($pdf==true)
		$tmp_REQUEST['_openSIS_PDF'] = true;
		
	$PHP_tmp_SELF = PreparePHP_SELF($tmp_REQUEST);

	if(!$_REQUEST['delete_ok'] &&!$_REQUEST['delete_cancel'])
	{
		
		PopTable('header',$title);
	//	echo "<CENTER><h4>$question</h4><FORM name=roll_over id=roll_over action=$PHP_tmp_SELF&delete_ok=1 METHOD=POST>$message<BR><BR><INPUT type=submit class=btn_medium value=OK onclick=\"document.roll_over.submit();\">&nbsp;<INPUT type=button class=btn_medium name=delete_cancel value=Cancel onclick='javascript:history.go(-1);'></FORM></CENTER>";
        echo "<CENTER><h4>$question</h4><FORM name=roll_over id=roll_over action=$PHP_tmp_SELF&delete_ok=1 METHOD=POST>";
		echo '<BR><font color=red>Caution : </font>Synchronize is an irreversible process.  If you are sure you want to proceed, type in the <BR>effective  roll over date below. You can use the next school year’s attendance start date.<BR><BR>';
		//echo DateInput('','roll_start_date','');
		echo '<BR>The following items will be rolled over to the next school year.  Uncheck the item(s) <br/>you do not want to be rolled over. Some items are mandatory and cannot be <br/>unchecked.<BR>';
		//echo $message.'<BR>';
		//echo 'hi';
                // Added By Shamim Ahmed Chowdhury
                
 /**
 * Displays the page when 'Synchronize - Go' is pressed
 */

if ((isset($_REQUEST['submit_connect']))) {
    foreach ($cons as $con) {
        ${"{$con}_host"}     = $_REQUEST[$con . '_host'];
        ${"{$con}_username"} = $_REQUEST[$con . '_username'];
        ${"{$con}_password"} = $_REQUEST[$con . '_pass'];
        ${"{$con}_port"}     = $_REQUEST[$con . '_port'];
        ${"{$con}_socket"}   = $_REQUEST[$con . '_socket'];
        ${"{$con}_db"}       = $_REQUEST[$con . '_db'];
        ${"{$con}_type"}	 = $_REQUEST[$con . '_type'];
      
        if (${"{$con}_type"} == 'cur') {
	        ${"{$con}_connection"} = null;
	        ${"{$con}_server"} = null;
	        ${"{$con}_db"}       = $_REQUEST[$con . '_db_sel'];
	        continue;
        }
      
        if (isset(${"{$con}_socket"}) && ! empty(${"{$con}_socket"})) {
	        ${"{$con}_server"}['socket'] = ${"{$con}_socket"};
        } else {
	        ${"{$con}_server"}['host'] = ${"{$con}_host"};
	        if (isset(${"{$con}_port"}) && ! empty(${"{$con}_port"}) && ((int)${"{$con}_port"} * 1) > 0) {
	            ${"{$con}_server"}['port'] = ${"{$con}_port"};
	        }
        }
            
        ${"{$con}_connection"} = PMA_DBI_connect(${"{$con}_username"}, ${"{$con}_password"}, $is_controluser = false, ${"{$con}_server"}, $auxiliary_connection = true);
    } // end foreach ($cons as $con)

    if ((! $src_connection && $src_type == 'rmt') || (! $trg_connection && $trg_type == 'rmt')) {
        /**
        * Displays the connection error string if
        * connections are not established
        */

        echo '<div class="error">';  
        if(! $src_connection && $src_type == 'rmt') {
            echo $GLOBALS['strCouldNotConnectSource'] . '<br />';
        }
        if(! $trg_connection && $trg_type == 'rmt'){
            echo $GLOBALS['strCouldNotConnectTarget'];
        }
        echo '</div>';
        unset($_REQUEST['submit_connect']);
    
    } else {
        /**
        * Creating the link object for both source and target databases and
        * selecting the source and target databases using these links
        */
	    foreach ($cons as $con) {
	        if (${"{$con}_connection"} != null) {
	            ${"{$con}_link"} = PMA_DBI_connect(${"{$con}_username"}, ${"{$con}_password"}, $is_controluser = false, ${"{$con}_server"});
	        } else {
                ${"{$con}_link"} = null;
            }
	        ${"{$con}_db_selected"} = PMA_DBI_select_db(${"{$con}_db"}, ${"{$con}_link"});
	    } // end foreach ($cons as $con)
	
        if (($src_db_selected != 1) || ($trg_db_selected != 1)) {
            /**
            * Displays error string if the database(s) did not exist
            */
            echo '<div class="error">';     
            if ($src_db_selected != 1) {
                echo sprintf($GLOBALS['strDatabaseNotExisting'], htmlspecialchars($src_db));
            }
            if ($trg_db_selected != 1) {
                echo sprintf($GLOBALS['strDatabaseNotExisting'], htmlspecialchars($trg_db));
            }
            echo '</div>';    
            unset($_REQUEST['submit_connect']);
            
        } else if (($src_db_selected == 1) && ($trg_db_selected == 1)) {

            /**
            * Using PMA_DBI_get_tables() to get all the tables 
            * from target and source databases. 
            */
            $src_tables = PMA_DBI_get_tables($src_db, $src_link);
            $source_tables_num = sizeof($src_tables);
    
            $trg_tables = PMA_DBI_get_tables($trg_db, $trg_link);
            $target_tables_num = sizeof($trg_tables);
           
            /**
            * initializing arrays to save matching and non-matching 
            * table names from target and source databases.  
            */                                      
            $unmatched_num_src = 0;
            $source_tables_uncommon = array();
            $unmatched_num_trg = 0;
            $target_tables_uncommon = array();
            $matching_tables = array();
            $matching_tables_num = 0;
         
            /**
            * Using PMA_getMatchingTables to find which of the tables' names match
            * in target and source database. 
            */                                                                           
            PMA_getMatchingTables($trg_tables, $src_tables, $matching_tables, $source_tables_uncommon);
            /**
            * Finding the uncommon tables for the target database  
            * using function PMA_getNonMatchingTargetTables()
            */
            PMA_getNonMatchingTargetTables($trg_tables, $matching_tables, $target_tables_uncommon);
       
            /**
            * Initializing several arrays to save the data and structure 
            * difference between the source and target databases.
            */
            $row_count = array();   //number of rows in source table that needs to be created in target database
            $fields_num = array();  //number of fields in each matching table 
            $delete_array = array(); //stores the primary key values for target tables that have excessive rows than corresponding source tables.
            $insert_array = array(array(array()));// stores the primary key values for the rows in each source table that are not present in target tables.
            $update_array = array(array(array())); //stores the primary key values, name of field to be updated, value of the field to be updated for
                                                    // each row of matching table. 
            $matching_tables_fields = array(); //contains the fields' names for each matching table 
            $matching_tables_keys   = array(); //contains the primary keys' names for each matching table 
            $uncommon_tables_fields = array(); //coantains the fields for all the source tables that are not present in target 
            $matching_tables_num = sizeof($matching_tables);
          
            $source_columns = array();  //contains the full columns' information for all the source tables' columns
            $target_columns = array();  //contains the full columns' information for all the target tables' columns
            $uncommon_columns = array(); //contains names of columns present in source table but absent from the corresponding target table
            $source_indexes = array();   //contains indexes on all the source tables
            $target_indexes = array();   //contains indexes on all the target tables
            $add_indexes_array = array(); //contains the indexes name present in source but absent from target tables
            $target_tables_keys = array(); //contains the keys of all the target tables 
            $alter_indexes_array = array();  //contains the names of all the indexes for each table that need to be altered in target database
            $remove_indexes_array = array();  //contains the names of indexes that are excessive in target tables
            $alter_str_array = array(array());  //contains the criteria for each column that needs to be altered in target tables
            $add_column_array = array(array()); //contains the name of columns that need to be added in target tables
            /**
            * The criteria array contains all the criteria against which columns are compared for differences.
            */
            $criteria = array('Field', 'Type', 'Null', 'Collation', 'Key', 'Default', 'Comment');
                
            for($i = 0; $i < sizeof($matching_tables); $i++) {
                /**
                * Finding out all the differences structure, data and index diff for all the matching tables only 
                */
                PMA_dataDiffInTables($src_db, $trg_db, $src_link, $trg_link, $matching_tables, $matching_tables_fields, $update_array, $insert_array,
                $delete_array, $fields_num, $i, $matching_tables_keys);
               
                PMA_structureDiffInTables($src_db, $trg_db, $src_link, $trg_link, $matching_tables, $source_columns,
                $target_columns, $alter_str_array, $add_column_array, $uncommon_columns, $criteria, $target_tables_keys, $i);    
                
                PMA_indexesDiffInTables($src_db, $trg_db, $src_link, $trg_link, $matching_tables, $source_indexes, $target_indexes,
                $add_indexes_array, $alter_indexes_array, $remove_indexes_array, $i);      
            }
            
            for($j = 0; $j < sizeof($source_tables_uncommon); $j++) {
                /**
                * Finding out the number of rows to be added in tables that need to be added in target database
                */
                PMA_dataDiffInUncommonTables($source_tables_uncommon, $src_db, $src_link, $j, $row_count);
            }  
            /**
            * Storing all arrays in session for use when page is reloaded for each button press 
            */
            $_SESSION['matching_tables'] = $matching_tables;  
            $_SESSION['update_array'] = $update_array;
            $_SESSION['insert_array'] = $insert_array; 
            $_SESSION['src_db'] = $src_db; 
            $_SESSION['trg_db'] =  $trg_db; 
            $_SESSION['matching_fields'] = $matching_tables_fields; 
            $_SESSION['src_uncommon_tables'] = $source_tables_uncommon; 
            $_SESSION['src_username'] = $src_username ; 
            $_SESSION['trg_username'] = $trg_username; 
            $_SESSION['src_password'] = $src_password; 
            $_SESSION['trg_password'] = $trg_password; 
            $_SESSION['trg_password'] = $trg_password;
    	    $_SESSION['src_server']   = $src_server; 
	        $_SESSION['trg_server']   = $trg_server; 
	        $_SESSION['src_type']     = $src_type;
    	    $_SESSION['trg_type']     = $trg_type;
            $_SESSION['matching_tables_keys'] = $matching_tables_keys;
            $_SESSION['uncommon_tables_fields'] = $uncommon_tables_fields;
            $_SESSION['uncommon_tables_row_count'] = $row_count; 
            $_SESSION['target_tables_uncommon'] = $target_tables_uncommon;
            $_SESSION['uncommon_tables'] = $source_tables_uncommon;
            $_SESSION['delete_array'] = $delete_array;
            $_SESSION['uncommon_columns'] = $uncommon_columns;
            $_SESSION['source_columns'] = $source_columns;
            $_SESSION['alter_str_array'] = $alter_str_array;
            $_SESSION['target_tables_keys'] = $target_tables_keys;
            $_SESSION['add_column_array'] = $add_column_array;
            $_SESSION['criteria'] = $criteria;
            $_SESSION['target_tables'] = $trg_tables;
            $_SESSION['add_indexes_array'] = $add_indexes_array;
            $_SESSION['alter_indexes_array'] = $alter_indexes_array;
            $_SESSION['remove_indexes_array'] = $remove_indexes_array;
            $_SESSION['source_indexes'] = $source_indexes;
            $_SESSION['target_indexes'] = $target_indexes; 
          
            /**
            * Displays the sub-heading and icons showing Structure Synchronization and Data Synchronization
            */
            echo '<form name="synchronize_form" id="synchronize_form" method="post" action="server_synchronize.php">'
            . PMA_generate_common_hidden_inputs('', '');
            echo '<table id="serverstatustraffic" class="data" width = "60%">
            <tr>
            <td> <h2>' 
            . ($GLOBALS['cfg']['MainPageIconic']
            ? '<img class="icon" src="' . $pmaThemeImage . 'new_struct.jpg" width="32"'
            . ' height="32" alt="" />'
            : '')
            . $strStructureSyn
            .'</h2>' .'</td>';
            echo '<td> <h2>'
            . ($GLOBALS['cfg']['MainPageIconic']
            ? '<img class="icon" src="' . $pmaThemeImage . 'new_data.jpg" width="32"'
            . ' height="32" alt="" />'
            : '')
            . $strDataSyn
            . '</h2>' .'</td>';
            echo '</tr>
            </table>';
       
            /**
            * Displays the tables containing the source tables names, their difference with the target tables and target tables names 
            */
            PMA_syncDisplayHeaderSource($src_db);
            $odd_row = false;
            /**
            * Display the matching tables' names and difference, first
            */
            for($i = 0; $i < count($matching_tables); $i++) {
                $num_of_updates = 0;
                $num_of_insertions = 0;
                /**
                * Calculating the number of updates for each matching table
                */
                if (isset($update_array[$i])) {
                    if (isset($update_array[$i][0][$matching_tables_keys[$i][0]])) {
                        if (isset($update_array[$i])) {
                            $num_of_updates = sizeof($update_array[$i]);
                        } else {
                             $num_of_updates = 0;
                        } 
                    } else {
                            $num_of_updates = 0;
                    }    
                }
                /**
                * Calculating the number of insertions for each matching table
                */
                if (isset($insert_array[$i])) {
                    if (isset($insert_array[$i][0][$matching_tables_keys[$i][0]])) {
                        if (isset($insert_array[$i])) {
                            $num_of_insertions = sizeof($insert_array[$i]);
                        } else {
                            $num_of_insertions = 0;
                        } 
                    } else {
                        $num_of_insertions = 0;
                    }    
                } 
                /**
                * Displays the name of the matching table 
                */
                $odd_row = PMA_syncDisplayBeginTableRow($odd_row);
                echo '<td>' . htmlspecialchars($matching_tables[$i]) . '</td>
                <td align="center">';
                /**
                * Calculating the number of alter columns, number of columns to be added, number of columns to be removed,
                * number of index to be added and removed.
                */
                $num_alter_cols  = 0;
                $num_insert_cols = 0;
                $num_remove_cols = 0;  
                $num_add_index   = 0;
                $num_remove_index = 0; 

                if (isset($alter_str_array[$i])) {
                    $num_alter_cols = sizeof($alter_str_array[$i]);    
                }
                if (isset($add_column_array[$i])) {
                    $num_insert_cols = sizeof($add_column_array[$i]);
                }
                if (isset($uncommon_columns[$i])) {
                    $num_remove_cols = sizeof($uncommon_columns[$i]);  
                }
                if (isset($add_indexes_array[$i])) {
                    $num_add_index = sizeof($add_indexes_array[$i]);
                }
                if (isset($remove_indexes_array[$i])) {
                    $num_remove_index = sizeof($remove_indexes_array[$i]);  
                }  
                if (isset($alter_indexes_array[$i])) {
                    $num_add_index += sizeof($alter_indexes_array[$i]);
                    $num_remove_index += sizeof($alter_indexes_array[$i]);  
                }  
                /**
                * Display the red button of structure synchronization if there exists any structure difference or index difference.                   
                */
                if (($num_alter_cols > 0) || ($num_insert_cols > 0) || ($num_remove_cols > 0) || ($num_add_index > 0) || ($num_remove_index > 0)) {
                    
                   echo '<img class="icon" src="' . $pmaThemeImage . 'new_struct.jpg" width="29"  height="29" 
                   alt="' . $GLOBALS['strClickToSelect'] . '" onmouseover="change_Image(this);" onmouseout="change_Image(this);"
                   onclick="showDetails(' . "'MS" . $i . "','" . $num_alter_cols . "','" .$num_insert_cols .
                   "','" . $num_remove_cols . "','" . $num_add_index . "','" . $num_remove_index . "'"
                   . ', this ,' . "'" . htmlspecialchars($matching_tables[$i]) . "'" . ')"/>';
                }
                /**
                * Display the green button of data synchronization if there exists any data difference.                   
                */ 
                if (isset($update_array[$i]) || isset($insert_array[$i])) {
                    if (isset($update_array[$i][0][$matching_tables_keys[$i][0]]) || isset($insert_array[$i][0][$matching_tables_keys[$i][0]])) {

                        echo '<img class="icon" src="' . $pmaThemeImage . 'new_data.jpg" width="29" height="29" 
                        alt="' . $GLOBALS['strClickToSelect'] . '" onmouseover="change_Image(this);" onmouseout="change_Image(this);"
                         onclick="showDetails('. "'MD" . $i . "','" . $num_of_updates . "','" . $num_of_insertions .
                         "','" . null . "','" . null . "','" . null . "'" . ', this ,' . "'" . htmlspecialchars($matching_tables[$i]) . "'" . ')" />';    
                    }    
                }
                echo '</td>
                </tr>';
            } 
            /**
            * Displays the tables' names present in source but missing from target
            */
            for ($j = 0; $j < count($source_tables_uncommon); $j++) {
                $odd_row = PMA_syncDisplayBeginTableRow($odd_row);
                echo '<td> + ' . htmlspecialchars($source_tables_uncommon[$j]) . '</td> ';
                
                echo '<td align="center"><img class="icon" src="' . $pmaThemeImage .  'new_struct.jpg" width="29"  height="29"
                alt="' . $GLOBALS['strClickToSelect'] . '" onmouseover="change_Image(this);" onmouseout="change_Image(this);"
                onclick="showDetails(' . "'US" . $j . "','" . null . "','" . null . "','" . null . "','" . null . "','" . null . "'" . ', this ,'
                . "'" . htmlspecialchars($source_tables_uncommon[$j]) . "'" . ')"/>';
                
                if ($row_count[$j] > 0)
                {
                    echo '<img class="icon" src="' . $pmaThemeImage . 'new_data.jpg" width="29" height="29" 
                    alt="' . $GLOBALS['strClickToSelect'] . '" onmouseover="change_Image(this);" onmouseout="change_Image(this);"
                    onclick="showDetails(' . "'UD" . $j . "','" . null . "','" . $row_count[$j] . "','" . null .
                    "','" . null . "','" . null . "'" . ', this ,' . "'" . htmlspecialchars($source_tables_uncommon[$j]) . "'" . ')" />';
                } 
                echo '</td>
                </tr>';
            }
            foreach ($target_tables_uncommon as $tbl_nc_name) {
                $odd_row = PMA_syncDisplayBeginTableRow($odd_row);
                echo '<td height="32">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td><td></td>';
                echo '</tr>';
            }
            /**
            * Displays the target tables names 
            */
            echo '</table>';

            $odd_row = PMA_syncDisplayHeaderTargetAndMatchingTables($trg_db, $matching_tables);
            foreach ($source_tables_uncommon as $tbl_nc_name) {
                $odd_row = PMA_syncDisplayBeginTableRow($odd_row);
                echo '<td height="32">' . htmlspecialchars($tbl_nc_name) . ' (' . $GLOBALS['strNotPresent'] . ')</td>
                </tr>';
            }
            foreach ($target_tables_uncommon as $tbl_nc_name) {
                $odd_row = PMA_syncDisplayBeginTableRow($odd_row);
                echo '<td> - ' . htmlspecialchars($tbl_nc_name) . '</td>';
                echo '</tr>';
            }
            echo '</table>';
            echo '</div>';
            
            /**
            * This "list" div will contain a table and each row will depict information about structure/data diffrence in tables.
            * Rows will be generated dynamically as soon as the colored  buttons "D" or "S"  are clicked.
            */
            
            echo '<div id="list" style = "overflow: auto; width: 1020px; height: 140px; 
            border-left: 1px gray solid; border-bottom: 1px gray solid; 
            padding:0px; margin: 0px">
        
            <table>
                <thead>
                <tr style="width: 100%;">
                    <th id="table_name" style="width: 10%;" colspan="1">' . $strTable . ' </th>
                    <th id="str_diff"   style="width: 65%;" colspan="6">' . $strStructureDiff . ' </th>
                    <th id="data_diff"  style="width: 20%;" colspan="2">' . $strDataDiff . '</th>
                </tr>
                <tr style="width: 100%;">
                    <th style="width: 10%;">' . $strTableName . '</th>   
                    <th style="width: 10%;">' . $strCreateTable . '</th>
                    <th style="width: 11%;">' . $strTableAddColumn . '</th>
                    <th style="width: 13%;">' . $strTableRemoveColumn . '</th>
                    <th style="width: 11%;">' . $strTableAlterColumn . '</th>
                    <th style="width: 12%;">' . $strTableRemoveIndex . '</th>
                    <th style="width: 11%;">' . $strTableApplyIndex . '</th>
                    <th style="width: 10%;">'.  $strTableUpdateRow . '</th>
                    <th style="width: 10%;">' . $strTableInsertRow . '</th>
                </tr> 
                </thead>
                <tbody></tbody>
            </table>
            </div>';
            /**
            *  This fieldset displays the checkbox to confirm deletion of previous rows from target tables 
            */
            echo '<fieldset>
            <p><input type= "checkbox" name="delete_rows" id ="delete_rows" /><label for="delete_rows">' . $strTableDeleteRows . '</label> </p>
            </fieldset> 
            <fieldset class="tblFooters">';
            echo '<input type="button" name="apply_changes" value="' . $GLOBALS['strApplyChanges']
             . '" onclick ="ApplySelectedChanges(' . "'" . htmlspecialchars($_SESSION['token']) . "'" . ')" />';
            echo '<input type="submit" name="synchronize_db" value="' . $GLOBALS['strSynchronizeDb'] . '" />' . '</fieldset>';
            echo '</form>';      
        }    
    }
} // end if ((isset($_REQUEST['submit_connect'])))
                
                
                
                
                
                
                
                // End Of My Writing Shamim Ahmed Chowdhury
                
                
                
                echo "<BR><BR><INPUT type=submit class=btn_large value=Apply Selected Changes onclick=\"return formcheck_rollover();\">&nbsp;<INPUT type=button class=btn_medium name=delete_cancel value=Cancel onclick='load_link(\"Modules.php?modname=Tools/LogDetails.php\");'></FORM></CENTER>";
		PopTable('footer');
		return false;
	}
	else
		return true;	
}





//End Of Synchronize Go Shamim Ahmed Chowdhury

//Start Of Synchronize Apply Changes Shamim Ahmed Chowdhury

function Prompt_synchronize_apply_changes($title='Confirm',$question='',$message='',$pdf='')
{	
	$tmp_REQUEST = $_REQUEST;
	unset($tmp_REQUEST['delete_ok']);
	if($pdf==true)
		$tmp_REQUEST['_openSIS_PDF'] = true;
		
	$PHP_tmp_SELF = PreparePHP_SELF($tmp_REQUEST);

	if(!$_REQUEST['delete_ok'] &&!$_REQUEST['delete_cancel'])
	{
		
		PopTable('header',$title);
	//	echo "<CENTER><h4>$question</h4><FORM name=roll_over id=roll_over action=$PHP_tmp_SELF&delete_ok=1 METHOD=POST>$message<BR><BR><INPUT type=submit class=btn_medium value=OK onclick=\"document.roll_over.submit();\">&nbsp;<INPUT type=button class=btn_medium name=delete_cancel value=Cancel onclick='javascript:history.go(-1);'></FORM></CENTER>";
        echo "<CENTER><h4>$question</h4><FORM name=roll_over id=roll_over action=$PHP_tmp_SELF&delete_ok=1 METHOD=POST>";
		echo '<BR><font color=red>Caution : </font>Synchronize is an irreversible process.  If you are sure you want to proceed, type in the <BR>effective  roll over date below. You can use the next school year’s attendance start date.<BR><BR>';
		echo DateInput('','roll_start_date','');
		echo '<BR>The following items will be rolled over to the next school year.  Uncheck the item(s) <br/>you do not want to be rolled over. Some items are mandatory and cannot be <br/>unchecked.<BR>';
		echo $message.'<BR>';
		//echo 'hi';
                
                 /**
 * Display the page when 'Apply Selected Changes' is pressed                                        
 */
if (isset($_REQUEST['Table_ids'])) {
    /**
    * Displays success message
    */
    echo '<div class="success">' . $GLOBALS['strHaveBeenSynchronized'] . '</div>';
    
    $src_db = $_SESSION['src_db']; 
    $trg_db = $_SESSION['trg_db'];
    $update_array = $_SESSION['update_array']; 
    $insert_array = $_SESSION['insert_array']; 
    $src_username = $_SESSION['src_username']; 
    $trg_username = $_SESSION['trg_username']; 
    $src_password = $_SESSION['src_password']; 
    $trg_password = $_SESSION['trg_password'];
    $src_server   = $_SESSION['src_server'];
    $trg_server   = $_SESSION['trg_server'];
    $src_type     = $_SESSION['src_type'];
    $trg_type     = $_SESSION['trg_type'];
    $uncommon_tables = $_SESSION['uncommon_tables']; 
    $matching_tables = $_SESSION['matching_tables']; 
    $matching_tables_keys = $_SESSION['matching_tables_keys'];
    $matching_tables_fields = $_SESSION['matching_fields']; 
    $source_tables_uncommon = $_SESSION['src_uncommon_tables']; 
    $uncommon_tables_fields = $_SESSION['uncommon_tables_fields'];
    $target_tables_uncommon = $_SESSION['target_tables_uncommon'];
    $row_count = $_SESSION['uncommon_tables_row_count'];
    $target_tables = $_SESSION['target_tables'];
      
    $delete_array = $_SESSION['delete_array'];
    $uncommon_columns = $_SESSION['uncommon_columns'];
    $source_columns = $_SESSION['source_columns'];
    $alter_str_array = $_SESSION['alter_str_array'];
    $criteria = $_SESSION['criteria'];
    $target_tables_keys = $_SESSION['target_tables_keys'];
    $add_column_array = $_SESSION['add_column_array'];
    $add_indexes_array = $_SESSION['add_indexes_array'];
    $alter_indexes_array = $_SESSION['alter_indexes_array'];
    $remove_indexes_array = $_SESSION['remove_indexes_array'];
    $source_indexes = $_SESSION['source_indexes'];
    $target_indexes = $_SESSION['target_indexes'];  
    $uncommon_cols = $uncommon_columns;
  
    /**
    * Creating link object for source and target databases
    */
    foreach ($cons as $con) {
        if (${"{$con}_type"} == "rmt") {
            ${"{$con}_link"} = PMA_DBI_connect(${"{$con}_username"}, ${"{$con}_password"}, $is_controluser = false, ${"{$con}_server"});
        } else {
            ${"{$con}_link"} = null;
            // working on current server, so initialize this for tracking
            // (does not work if user defined current server as a remote one)
            $GLOBALS['db'] = ${"{$con}_db"};
        }
    } // end foreach ($cons as $con)
   
    /**
    * Initializing arrays to save the table ids whose data and structure difference is to be applied 
    */
    $matching_table_data_diff = array();  //stores id of matching table having data difference
    $matching_table_structure_diff = array(); //stores id of matching tables having structure difference
    $uncommon_table_structure_diff = array(); //stores id of uncommon tables having structure difference
    $uncommon_table_data_diff = array();     //stores id of uncommon tables having data difference
      
    for ($i = 0; isset($_REQUEST[$i]); $i++ ) {
        if (isset($_REQUEST[$i])) { 
            $table_id = explode("US", $_REQUEST[$i]);
            if (isset($table_id[1])) {
                $uncommon_table_structure_diff[] = $table_id[1];
            }
            $table_id = explode("UD", $_REQUEST[$i]);
            if (isset($table_id[1])) {
                $uncommon_table_data_diff[] = $table_id[1];
            }
            $table_id = explode("MS", $_REQUEST[$i]);
            if (isset($table_id[1])) {
                $matching_table_structure_diff[] = $table_id[1];
            }
            
            $table_id = explode("MD", $_REQUEST[$i]);
            if (isset($table_id[1])) {
                 $matching_table_data_diff[] = $table_id[1];
            }
        }
    } // end for
    /**
    * Applying the structure difference on selected matching tables
    */
    for($q = 0; $q < sizeof($matching_table_structure_diff); $q++)
    {
        if (isset($alter_str_array[$matching_table_structure_diff[$q]])) {
           
            PMA_alterTargetTableStructure($trg_db, $trg_link, $matching_tables, $source_columns, $alter_str_array, $matching_tables_fields,
            $criteria, $matching_tables_keys, $target_tables_keys, $matching_table_structure_diff[$q], false);
            
            unset($alter_str_array[$matching_table_structure_diff[$q]]);        
        }                                                           
        if (isset($add_column_array[$matching_table_structure_diff[$q]])) {
            
            PMA_findDeleteRowsFromTargetTables($delete_array, $matching_tables, $matching_table_structure_diff[$q], $target_tables_keys, 
            $matching_tables_keys, $trg_db, $trg_link, $src_db, $src_link);
        
            if (isset($delete_array[$matching_table_structure_diff[$q]])) {
           
                PMA_deleteFromTargetTable($trg_db, $trg_link, $matching_tables, $matching_table_structure_diff[$q], $target_tables_keys, $delete_array, false);
           
                unset($delete_array[$matching_table_structure_diff[$q]]); 
            }                                                                                                               
            PMA_addColumnsInTargetTable($src_db, $trg_db,$src_link, $trg_link, $matching_tables, $source_columns, $add_column_array, $matching_tables_fields,
            $criteria, $matching_tables_keys, $target_tables_keys, $uncommon_tables,$uncommon_tables_fields, $matching_table_structure_diff[$q], $uncommon_cols, false);
            
            unset($add_column_array[$matching_table_structure_diff[$q]]);
        }
        if (isset($uncommon_columns[$matching_table_structure_diff[$q]])) {
            
            PMA_removeColumnsFromTargetTable($trg_db, $trg_link, $matching_tables, $uncommon_columns, $matching_table_structure_diff[$q], false);
            
            unset($uncommon_columns[$matching_table_structure_diff[$q]]); 
        }
        if (isset($add_indexes_array[$matching_table_structure_diff[$q]]) || isset($remove_indexes_array[$matching_table_structure_diff[$q]]) 
            || isset($alter_indexes_array[$matching_table_structure_diff[$q]])) {
           
            PMA_applyIndexesDiff ($trg_db, $trg_link, $matching_tables, $source_indexes, $target_indexes, $add_indexes_array, $alter_indexes_array, 
            $remove_indexes_array, $matching_table_structure_diff[$q], false); 
           
            unset($add_indexes_array[$matching_table_structure_diff[$q]]);
            unset($alter_indexes_array[$matching_table_structure_diff[$q]]);
            unset($remove_indexes_array[$matching_table_structure_diff[$q]]);
        }      
    }
    /**
    * Applying the data difference. First checks if structure diff is applied or not. 
    * If not, then apply structure difference first then apply data difference.
    */
    for($p = 0; $p < sizeof($matching_table_data_diff); $p++)
    {   
        if ($_REQUEST['checked'] == 'true') {
            
            PMA_findDeleteRowsFromTargetTables($delete_array, $matching_tables, $matching_table_data_diff[$p], $target_tables_keys, 
            $matching_tables_keys, $trg_db, $trg_link, $src_db, $src_link);
            
            if (isset($delete_array[$matching_table_data_diff[$p]])) {
            
                PMA_deleteFromTargetTable($trg_db, $trg_link, $matching_tables, $matching_table_data_diff[$p], $target_tables_keys, $delete_array, false);
                
                unset($delete_array[$matching_table_data_diff[$p]]); 
            }                                                                                                                   
        }         
        if (isset($alter_str_array[$matching_table_data_diff[$p]])) {
            
            PMA_alterTargetTableStructure($trg_db, $trg_link, $matching_tables, $source_columns, $alter_str_array, $matching_tables_fields,
            $criteria, $matching_tables_keys, $target_tables_keys, $matching_table_data_diff[$p], false);
            
            unset($alter_str_array[$matching_table_data_diff[$p]]);        
        }
        if (isset($add_column_array[$matching_table_data_diff[$p]])) {
            
            PMA_findDeleteRowsFromTargetTables($delete_array, $matching_tables, $matching_table_data_diff[$p], $target_tables_keys, 
            $matching_tables_keys, $trg_db, $trg_link, $src_db, $src_link);
             
            if (isset($delete_array[$matching_table_data_diff[$p]])) {
           
                PMA_deleteFromTargetTable($trg_db, $trg_link, $matching_tables, $matching_table_data_diff[$p], $target_tables_keys, $delete_array, false);
           
                unset($delete_array[$matching_table_data_diff[$p]]); 
            }                                                                                                               
            PMA_addColumnsInTargetTable($src_db, $trg_db,$src_link, $trg_link, $matching_tables, $source_columns, $add_column_array, $matching_tables_fields,
            $criteria, $matching_tables_keys, $target_tables_keys, $uncommon_tables, $uncommon_tables_fields, $matching_table_data_diff[$p], $uncommon_cols, false);
             
            unset($add_column_array[$matching_table_data_diff[$p]]);
        }
        if (isset($uncommon_columns[$matching_table_data_diff[$p]])) {
            
            PMA_removeColumnsFromTargetTable($trg_db, $trg_link, $matching_tables, $uncommon_columns, $matching_table_data_diff[$p], false);
            
            unset($uncommon_columns[$matching_table_data_diff[$p]]); 
        }          
        if ((isset($matching_table_structure_diff[$q]) && isset($add_indexes_array[$matching_table_structure_diff[$q]])) 
            || (isset($matching_table_structure_diff[$q]) && isset($remove_indexes_array[$matching_table_structure_diff[$q]])) 
            || (isset($matching_table_structure_diff[$q]) && isset($alter_indexes_array[$matching_table_structure_diff[$q]]))) {
           
            PMA_applyIndexesDiff ($trg_db, $trg_link, $matching_tables, $source_indexes, $target_indexes, $add_indexes_array, $alter_indexes_array, 
            $remove_indexes_array, $matching_table_structure_diff[$q], false); 
           
            unset($add_indexes_array[$matching_table_structure_diff[$q]]);
            unset($alter_indexes_array[$matching_table_structure_diff[$q]]);
            unset($remove_indexes_array[$matching_table_structure_diff[$q]]);
        }
        /**
        * Applying the data difference.
        */
        PMA_updateTargetTables($matching_tables, $update_array, $src_db, $trg_db, $trg_link, $matching_table_data_diff[$p], $matching_tables_keys, false);
        
        PMA_insertIntoTargetTable($matching_tables, $src_db, $trg_db, $src_link, $trg_link , $matching_tables_fields, $insert_array,
        $matching_table_data_diff[$p], $matching_tables_keys, $source_columns, $add_column_array, $criteria, $target_tables_keys,
        $uncommon_tables, $uncommon_tables_fields, $uncommon_cols, $alter_str_array, $source_indexes, $target_indexes, $add_indexes_array, 
        $alter_indexes_array, $delete_array, $update_array, false);   
    }
    /**
    * Updating the session variables to the latest values of the arrays.
    */
    $_SESSION['delete_array'] = $delete_array;
    $_SESSION['uncommon_columns'] = $uncommon_columns;
    $_SESSION['alter_str_array']  = $alter_str_array;
    $_SESSION['add_column_array'] = $add_column_array;
    $_SESSION['add_indexes_array'] = $add_indexes_array;
    $_SESSION['remove_indexes_array'] = $remove_indexes_array;
    $_SESSION['insert_array'] = $insert_array;    
    $_SESSION['update_array'] = $update_array;
    
    /**
    * Applying structure difference to selected non-matching tables (present in Source but absent from Target).  
    */                                                              
    for($s = 0; $s < sizeof($uncommon_table_structure_diff); $s++)
    {   
        PMA_createTargetTables($src_db, $trg_db, $src_link, $trg_link, $uncommon_tables, $uncommon_table_structure_diff[$s], $uncommon_tables_fields, false);
        $_SESSION['uncommon_tables_fields'] = $uncommon_tables_fields;
        
        unset($uncommon_tables[$uncommon_table_structure_diff[$s]]);
    }
    /**
    * Applying data difference to selected non-matching tables (present in Source but absent from Target). 
    * Before data synchronization, structure synchronization is confirmed. 
    */
    for($r = 0; $r < sizeof($uncommon_table_data_diff); $r++)
    {   
        if (!(in_array($uncommon_table_data_diff[$r], $uncommon_table_structure_diff))) {
            if (isset($uncommon_tables[$uncommon_table_data_diff[$r]])) {
               
                PMA_createTargetTables($src_db, $trg_db, $src_link, $trg_link, $uncommon_tables, $uncommon_table_data_diff[$r],
                    $uncommon_tables_fields, false);
                $_SESSION['uncommon_tables_fields'] = $uncommon_tables_fields;
                
                unset($uncommon_tables[$uncommon_table_data_diff[$r]]);  
            }
        }     
        PMA_populateTargetTables($src_db, $trg_db, $src_link, $trg_link, $source_tables_uncommon, $uncommon_table_data_diff[$r], 
            $_SESSION['uncommon_tables_fields'], false);
        
        unset($row_count[$uncommon_table_data_diff[$r]]);              
    }
    /**
    * Again all the tables from source and target database are displayed with their differences. 
    * The differences have been removed from tables that have been synchronized
    */
    echo '<form name="applied_difference" id="synchronize_form" method="post" action="server_synchronize.php">'
        . PMA_generate_common_hidden_inputs('', '');
    
    PMA_syncDisplayHeaderSource($src_db);
    $odd_row = false;
    for($i = 0; $i < count($matching_tables); $i++) {   
        $odd_row = PMA_syncDisplayBeginTableRow($odd_row);
        echo '<td align="center">' . htmlspecialchars($matching_tables[$i]) . '</td>
        <td align="center">';
            
        $num_alter_cols  = 0;
        $num_insert_cols = 0;
        $num_remove_cols = 0;  
        $num_add_index = 0;
        $num_remove_index = 0; 
            
        if (isset($alter_str_array[$i])) {
            $num_alter_cols = sizeof($alter_str_array[$i]);    
        }
        if (isset($add_column_array[$i])) {
            $num_insert_cols = sizeof($add_column_array[$i]);
        }
        if (isset($uncommon_columns[$i])) {
            $num_remove_cols = sizeof($uncommon_columns[$i]);  
        }
        if (isset($add_indexes_array[$i])) {
            $num_add_index = sizeof($add_indexes_array[$i]);
        }
        if (isset($remove_indexes_array[$i])) {
            $num_remove_index = sizeof($remove_indexes_array[$i]);  
        }                    
            
        if (($num_alter_cols > 0) || ($num_insert_cols > 0) || ($num_remove_cols > 0) || ($num_add_index > 0) || ($num_remove_index > 0)) {
            echo '<img class="icon" src="' . $pmaThemeImage .  'new_struct.jpg" width="29"  height="29" 
            alt="' . $GLOBALS['strClickToSelect'] . '" onmouseover="change_Image(this);" onmouseout="change_Image(this);"
            onclick="showDetails(' . "'MS" . $i . "','" . $num_alter_cols . "','" . $num_insert_cols . "','" . $num_remove_cols . "','" . $num_add_index . "','" . $num_remove_index . "'" .',
            this ,' . "'" . htmlspecialchars($matching_tables[$i]) . "'" . ')"/>';
        }  
        if (!(in_array($i, $matching_table_data_diff))) {
            
            if (isset($matching_tables_keys[$i][0]) && isset($update_array[$i][0][$matching_tables_keys[$i][0]])) {
                if (isset($update_array[$i])) {
                    $num_of_updates = sizeof($update_array[$i]);
                } else {
                    $num_of_updates = 0;
                }
            } else {
                $num_of_updates = 0;
            } 
            if (isset($matching_tables_keys[$i][0]) && isset($insert_array[$i][0][$matching_tables_keys[$i][0]])) {
                if (isset($insert_array[$i])) {
                    $num_of_insertions = sizeof($insert_array[$i]);
                } else {
                    $num_of_insertions = 0;
                }
            } else {
                $num_of_insertions = 0;
            }
            
            if ((isset($matching_tables_keys[$i][0]) && isset($update_array[$i][0][$matching_tables_keys[$i][0]]))
                || (isset($matching_tables_keys[$i][0]) && isset($insert_array[$i][0][$matching_tables_keys[$i][0]]))) {
                echo '<img class="icon" src="' . $pmaThemeImage . 'new_data.jpg" width="29" height="29" 
                alt="' . $GLOBALS['strClickToSelect'] . '" onmouseover="change_Image(this);" onmouseout="change_Image(this);"
                onclick="showDetails(' . "'MD" . $i . "','" . $num_of_updates . "','" . $num_of_insertions .
                "','" . null . "','" . null . "','" . null . "'" .', this ,' . "'" . htmlspecialchars($matching_tables[$i]) . "'" . ')" />';    
            }
        } else {
            unset($update_array[$i]);
            unset($insert_array[$i]);    
        }
        echo '</td>
        </tr>';
    }
    /**
    * placing updated value of arrays in session
    *                                           
    */
    $_SESSION['update_array'] = $update_array; 
    $_SESSION['insert_array'] = $insert_array; 
    
    for ($j = 0; $j < count($source_tables_uncommon); $j++) {
        $odd_row = PMA_syncDisplayBeginTableRow($odd_row);
        echo '<td align="center"> + ' . htmlspecialchars($source_tables_uncommon[$j]) . '</td>
        <td align="center">';
        /**
        * Display the difference only when it has not been applied        
        */
        if (!(in_array($j, $uncommon_table_structure_diff))) {
            if (isset($uncommon_tables[$j])) {
                echo '<img class="icon" src="' . $pmaThemeImage  . 'new_struct.jpg" width="29"  height="29" 
                alt="' . $GLOBALS['strClickToSelect'] . '" onmouseover="change_Image(this);" onmouseout="change_Image(this);"
                onclick="showDetails(' . "'US" . $j . "','" . null . "','" . null . "','" . null . "','" . null . "','" . null . "'" . ', this ,' . "'" . htmlspecialchars($source_tables_uncommon[$j]) . "'" . ')"/>' .' ';    
            }            
        } else {
            unset($uncommon_tables[$j]);
        } 
        /**
        * Display the difference only when it has not been applied        
        */
        if (!(in_array($j, $uncommon_table_data_diff))) {
            if (isset($row_count[$j]) && ($row_count > 0)) {
                echo '<img class="icon" src="' . $pmaThemeImage . 'new_data.jpg" width="29" height="29" 
                alt="' . $GLOBALS['strClickToSelect'] . '" onmouseover="change_Image(this);" onmouseout="change_Image(this);"
                onclick="showDetails(' . "'UD" . $j . "','" . null ."','" . $row_count[$j] ."','"
                . null . "','" . null . "','" . null . "'" . ', this ,' . "'". htmlspecialchars($source_tables_uncommon[$j]) . "'" . ')" />';
            }    
        } else {
            unset($row_count[$j]);
        }
          
        echo '</td>
        </tr>';
    }
    /**
    * placing the latest values of arrays in session
    */
                                                   
    $_SESSION['uncommon_tables'] = $uncommon_tables;
    $_SESSION['uncommon_tables_row_count'] = $row_count;
    
    
    /**
    * Displaying the target database tables
    */
    foreach ($target_tables_uncommon as $tbl_nc_name) {
        $odd_row = PMA_syncDisplayBeginTableRow($odd_row);
        echo '<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td><td></td>';
        echo '</tr>';
    }
    echo '</table>';
    $odd_row = PMA_syncDisplayHeaderTargetAndMatchingTables($trg_db, $matching_tables);
    foreach ($source_tables_uncommon as $tbl_nc_name) {
        $odd_row = PMA_syncDisplayBeginTableRow($odd_row);
        if (in_array($tbl_nc_name, $uncommon_tables)) {
            echo '<td>' . htmlspecialchars($tbl_nc_name) . ' (' .  $GLOBALS['strNotPresent'] . ')</td>';
        } else {
            echo '<td>' . htmlspecialchars($tbl_nc_name) . '</td>';    
        }
        echo '
        </tr>';
    }
    foreach ($target_tables_uncommon as $tbl_nc_name) {
        $odd_row = PMA_syncDisplayBeginTableRow($odd_row);
        echo '<td> - ' . htmlspecialchars($tbl_nc_name) . '</td>';
        echo '</tr>';
    }
    echo '</table>
    </div>';
       
    /**
    * This "list" div will contain a table and each row will depict information about structure/data diffrence in tables.
    * Rows will be generated dynamically as soon as the colored  buttons "D" or "S"  are clicked.
    */
    
    echo '<div id="list" style = "overflow: auto; width: 1020px; height: 140px; 
          border-left: 1px gray solid; border-bottom: 1px gray solid; 
          padding:0px; margin: 0px">';
        
    echo '<table>
          <thead>
            <tr style="width: 100%;">
                <th id="table_name" style="width: 10%;" colspan="1">' . $strTable . ' </th>
                <th id="str_diff"   style="width: 65%;" colspan="6">' . $strStructureDiff . ' </th>
                <th id="data_diff"  style="width: 20%;" colspan="2">' . $strDataDiff . '</th>
            </tr>
            <tr style="width: 100%;">
                <th style="width: 10%;">' . $strTableName . '</th>   
                <th style="width: 10%;">' . $strCreateTable . '</th>
                <th style="width: 11%;">' . $strTableAddColumn . '</th>
                <th style="width: 13%;">' . $strTableRemoveColumn . '</th>
                <th style="width: 11%;">' . $strTableAlterColumn . '</th>
                <th style="width: 12%;">' . $strTableRemoveIndex . '</th>
                <th style="width: 11%;">' . $strTableApplyIndex . '</th>
                <th style="width: 10%;">' . $strTableUpdateRow . '</th>
                <th style="width: 10%;">' . $strTableInsertRow . '</th>
            </tr> 
            </thead>
            <tbody></tbody>
         </table>
        </div>';
        
    /**
    *  This fieldset displays the checkbox to confirm deletion of previous rows from target tables 
    */
    echo '<fieldset>
    <p><input type="checkbox" name="delete_rows" id ="delete_rows" /><label for="delete_rows">' . $strTableDeleteRows . '</label> </p>
    </fieldset>'; 
    
    echo '<fieldset class="tblFooters">';
    echo '<input type="button" name="apply_changes" value="' . $GLOBALS['strApplyChanges'] . '" 
          onclick ="ApplySelectedChanges(' . "'" . htmlspecialchars($_SESSION['token']) . "'" .')" />';
    echo '<input type="submit" name="synchronize_db" value="' . $GLOBALS['strSynchronizeDb'] . '" />'
          . '</fieldset>';
    echo '</form>';                 
}
                
                
                
    //End Of Synchronize Apply Changes Shamim Ahmed Chowdhury            
                
                
                
                
                
                echo "<BR><BR><INPUT type=submit class=btn_large value=Synchronize onclick=\"return Prompt_synchronize_go($title='Confirm',$question='',$pdf='');\">&nbsp;<INPUT type=button class=btn_medium name=delete_cancel value=Cancel onclick='load_link(\"Modules.php?modname=Tools/LogDetails.php\");'></FORM></CENTER>";
		PopTable('footer');
		return false;
	}
	else
		return true;	
}



function Prompt_rollover_back($title='Rollover',$question='',$pdf='')
{
	$tmp_REQUEST = $_REQUEST;
	unset($tmp_REQUEST['delete_ok']);
	if($pdf==true)
		$tmp_REQUEST['_openSIS_PDF'] = true;

	$PHP_tmp_SELF = PreparePHP_SELF($tmp_REQUEST);

	if(!$_REQUEST['delete_ok'] &&!$_REQUEST['delete_cancel'])
	{
		echo '<BR>';
		PopTable('header',$title);
	//	echo "<CENTER><h4>$question</h4><FORM name=roll_over id=roll_over action=$PHP_tmp_SELF&delete_ok=1 METHOD=POST>$message<BR><BR><INPUT type=submit class=btn_medium value=OK onclick=\"document.roll_over.submit();\">&nbsp;<INPUT type=button class=btn_medium name=delete_cancel value=Cancel onclick='javascript:history.go(-1);'></FORM></CENTER>";
                echo "<CENTER><h4>$question</h4><FORM name=roll_over id=roll_over action=$PHP_tmp_SELF&delete_ok=1 METHOD=POST><BR>&nbsp;<INPUT type=submit class=btn_medium name=delete_cancel value=Ok onclick='load_link(\"Modules.php?modname=Tools/LogDetails.php\");'></FORM></CENTER>";
		PopTable('footer');
		return false;
	}
	else
		return true;
}

//Added By Shamim Ahmed Chowdhury For Synchronize

function Prompt_synchronize_back($title='Rollover',$question='',$pdf='')
{
	$tmp_REQUEST = $_REQUEST;
	unset($tmp_REQUEST['delete_ok']);
	if($pdf==true)
		$tmp_REQUEST['_openSIS_PDF'] = true;

	$PHP_tmp_SELF = PreparePHP_SELF($tmp_REQUEST);

	if(!$_REQUEST['delete_ok'] &&!$_REQUEST['delete_cancel'])
	{
		echo '<BR>';
		PopTable('header',$title);
	//	echo "<CENTER><h4>$question</h4><FORM name=roll_over id=roll_over action=$PHP_tmp_SELF&delete_ok=1 METHOD=POST>$message<BR><BR><INPUT type=submit class=btn_medium value=OK onclick=\"document.roll_over.submit();\">&nbsp;<INPUT type=button class=btn_medium name=delete_cancel value=Cancel onclick='javascript:history.go(-1);'></FORM></CENTER>";
                echo "<CENTER><h4>$question</h4><FORM name=roll_over id=roll_over action=$PHP_tmp_SELF&delete_ok=1 METHOD=POST><BR>&nbsp;<INPUT type=submit class=btn_medium name=delete_cancel value=Ok onclick='load_link(\"Modules.php?modname=Tools/LogDetails.php\");'></FORM></CENTER>";
		PopTable('footer');
		return false;
	}
	else
		return true;
}

//End Of Synchronize

function Prompt_Runschedule($title='Confirm',$question='',$message='',$pdf='')
{	
	$tmp_REQUEST = $_REQUEST;
	unset($tmp_REQUEST['delete_ok']);
	if($pdf==true)
		$tmp_REQUEST['_openSIS_PDF'] = true;
		
	$PHP_tmp_SELF = PreparePHP_SELF($tmp_REQUEST);

	if(!$_REQUEST['delete_ok'] &&!$_REQUEST['delete_cancel'])
	{
		echo '<BR>';
		PopTable('header',$title);
		echo "<CENTER><h4>$question</h4><FORM action=$PHP_tmp_SELF&delete_ok=1 METHOD=POST>$message<BR><BR><INPUT type=submit class=btn_medium value=OK>&nbsp;<INPUT type=button class=btn_medium name=delete_cancel value=Cancel onclick='load_link(\"Modules.php?modname=Scheduling/Schedule.php\");'></FORM></CENTER>";
		PopTable('footer');
		return false;
	}
	else
		return true;	
}



#############################################################################################
# This function is written for the date reset problem, so if any date  resets to Jan 1 20 use this 

// SEND PrepareDateSchedule a name prefix, and a date in oracle format 'd-M-y' as the selected date to have returned a date selection series
// of pull-down menus
// For the default to be Not Specified, send a date of 00-000-00 -- For today's date, send nothing
// The date pull-downs will create three variables, monthtitle, daytitle, yeartitle
// The third parameter (booleen) specifies whether Not Specified should be allowed as an option

function PrepareDateSchedule($date='',$title='',$allow_na=true,$options='')
{	global $_openSIS;

	if($options=='')
		$options = array();
	if(!$options['Y'] && !$options['M'] && !$options['D'] && !$options['C'])
		$options += array('Y'=>true,'M'=>true,'D'=>true,'C'=>true);
		
	if($options['short']==true)
		$extraM = "style='width:60;' ";
	if($options['submit']==true)
	{
		$tmp_REQUEST['M'] = $tmp_REQUEST['D'] = $tmp_REQUEST['Y'] = $_REQUEST;
		unset($tmp_REQUEST['M']['month'.$title]);
		unset($tmp_REQUEST['D']['day'.$title]);
		unset($tmp_REQUEST['Y']['year'.$title]);
		$extraM .= "onchange='document.location.href=\"".PreparePHP_SELF($tmp_REQUEST['M'])."&amp;month$title=\"+this.form.month$title.value;'";
		$extraD .= "onchange='document.location.href=\"".PreparePHP_SELF($tmp_REQUEST['D'])."&amp;day$title=\"+this.form.day$title.value;'";
		$extraY .= "onchange='document.location.href=\"".PreparePHP_SELF($tmp_REQUEST['Y'])."&amp;year$title=\"+this.form.year$title.value;'";
	}
	
	if($options['C'])
		$_openSIS['PrepareDate']++;

	if(strlen($date)==9) // ORACLE
	{
		$day = substr($date,0,2);
		$month = substr($date,3,3);
		$year = substr($date,7,2);

		$return .= '<!-- '.$year.MonthNWSwitch($month,'tonum').$day.' -->';
	}
	else // POSTGRES
	{
		$temp = split('-',$date);
		if(strlen($temp[0])==4)
		{
			$day = $temp[2];
			$year = substr($temp[0],2,2);
		}
		else
		{
			$day = $temp[0];
			$year = substr($temp[2],2,2);
		}
		$month = MonthNWSwitch($temp[1],'tochar');

		$return .= '<!-- '.$year.MonthNWSwitch($month,'tonum').$day.' -->';
	}

	// MONTH  ---------------
	if($options['M'])
	{
		$return .= "<div style='float:left; margin-right:2px;'><SELECT CLASS=cal_month NAME=month".$title." id=monthSelect".$_openSIS['PrepareDate']." SIZE=1 $extraM>";
		//  -------------------------------------------------------------------------- //
		
		if($month == 'JAN')
			$month = 1;
		elseif($month == 'FEB')
			$month = 2;
		elseif($month == 'MAR')
			$month = 3;
		elseif($month == 'APR')
			$month = 4;
		elseif($month == 'MAY')
			$month = 5;
		elseif($month == 'JUN')
			$month = 6;
		elseif($month == 'JUL')
			$month = 7;
		elseif($month == 'AUG')
			$month = 8;
		elseif($month == 'SEP')
			$month = 9;
		elseif($month == 'OCT')
			$month = 10;
		elseif($month == 'NOV')
			$month = 11;
		elseif($month == 'DEC')
			$month = 12;
		
		//  -------------------------------------------------------------------------- //
		if($allow_na)
		{
			if($month=='000')
				$return .= "<OPTION value=\"\" SELECTED>N/A";else $return .= "<OPTION value=\"\">N/A";
		}
		
		if($month=='1'){$return .= "<OPTION VALUE=JAN SELECTED>January";}else{$return .= "<OPTION VALUE=JAN>January";}
		if($month=='2'){$return .= "<OPTION VALUE=FEB SELECTED>February";}else{$return .= "<OPTION VALUE=FEB>February";}
		if($month=='3'){$return .= "<OPTION VALUE=MAR SELECTED>March";}else{$return .= "<OPTION VALUE=MAR>March";}
		if($month=='4'){$return .= "<OPTION VALUE=APR SELECTED>April";}else{$return .= "<OPTION VALUE=APR>April";}
		if($month=='5'){$return .= "<OPTION VALUE=MAY SELECTED>May";}else{$return .= "<OPTION VALUE=MAY>May";}
		if($month=='6'){$return .= "<OPTION VALUE=JUN SELECTED>June";}else{$return .= "<OPTION VALUE=JUN>June";}
		if($month=='7'){$return .= "<OPTION VALUE=JUL SELECTED>July";}else{$return .= "<OPTION VALUE=JUL>July";}
		if($month=='8'){$return .= "<OPTION VALUE=AUG SELECTED>August";}else{$return .= "<OPTION VALUE=AUG>August";}
		if($month=='9'){$return .= "<OPTION VALUE=SEP SELECTED>September";}else{$return .= "<OPTION VALUE=SEP>September";}
		if($month=='10'){$return .= "<OPTION VALUE=OCT SELECTED>October";}else{$return .= "<OPTION VALUE=OCT>October";}
		if($month=='11'){$return .= "<OPTION VALUE=NOV SELECTED>November";}else{$return .= "<OPTION VALUE=NOV>November";}
		if($month=='12'){$return .= "<OPTION VALUE=DEC SELECTED>December";}else{$return .= "<OPTION VALUE=DEC>December";}
		
		$return .= "</SELECT></div>";
	}

	// DAY  ---------------
	if($options['D'])
	{
		$return .="<div style='float:left; margin-right:2px;'><SELECT NAME=day".$title." id=daySelect".$_openSIS['PrepareDate']." SIZE=1 $extraD>";
		if($allow_na)
		{
			if($day=='00'){$return .= "<OPTION value=\"\" SELECTED>N/A";}else{$return .= "<OPTION value=\"\">N/A";}
		}
		
		for($i=1;$i<=31;$i++)
		{
			if(strlen($i)==1)
				$print='0'.$i;
			else
				$print = $i;
			
			$return .="<OPTION VALUE=".$print;
			if($day==$print)
				$return .=" SELECTED";
			$return .=">$i ";
		}
		$return .="</SELECT></div>";
	}
	
	// YEAR	 ---------------
	if($options['Y'])
	{
		if(!$year)
		{
			$begin = date('Y') - 20;
			$end = date('Y') + 5;
		}
		else
		{
			if($year<50)
				$year = '20'.$year;
			else
				$year = '19'.$year;
			$begin = $year - 5;
			$end = $year + 5;
		}
	
		$return .="<div style='float:left; margin-right:2px;'><SELECT NAME=year".$title." id=yearSelect".$_openSIS['PrepareDate']." SIZE=1 $extraY>";
		if($allow_na)
		{
			if($year=='00'){$return .= "<OPTION value=\"\" SELECTED>N/A";}else{$return .= "<OPTION value=\"\">N/A";}
		}
			
		for($i=$begin;$i<=$end;$i++)
		{
			$return .="<OPTION VALUE=".substr($i,0);
			if($year==$i){$return .=" SELECTED";}
			$return .=">".$i;
		}
		$return .="</SELECT></div>";
	}
	
	if($options['C'])
		$return .= '<div style="margin-top:-3px; float:left"><img src="assets/calendar.gif" id="trigger'.$_openSIS['PrepareDate'].'" style="cursor: hand;" onmouseover=this.style.background=""; onmouseout=this.style.background=""; onClick='."MakeDate('".$_openSIS['PrepareDate']."',this);".' /></div>';
	
	if($_REQUEST['_openSIS_PDF'])
		$return = ProperDate($date);
	return $return;
}
#############################################################################################
function PromptCourseWarning($title='Confirm',$question='',$message='',$pdf='')
{	
	$tmp_REQUEST = $_REQUEST;
	unset($tmp_REQUEST['delete_ok']);
	if($pdf==true)
		$tmp_REQUEST['_openSIS_PDF'] = true;
		
	$PHP_tmp_SELF = PreparePHP_SELF($tmp_REQUEST);

	if(!$_REQUEST['delete_ok'] &&!$_REQUEST['delete_cancel'])
	{
		echo '<BR>';
		PopTable('header',$title);
		echo "<CENTER><h4>$question</h4><FORM action=$PHP_tmp_SELF&delete_ok=1 METHOD=POST>$message<BR><BR><INPUT type=button class=btn_medium name=delete_cancel value=Cancel onclick='javascript:history.go(-1);'></FORM></CENTER>";
		PopTable('footer');
		return false;
	}
	else
		return true;	
}


# ---------------------- Solution for screen error in Group scheduling start ---------------------------------------- #

function for_error_sch()
{
 		$css=getCSS(); 		
		echo "<br><br><form action=Modules.php?modname=$_REQUEST[modname] method=post>";
		echo '<BR><CENTER>'.SubmitButton('Try Again','','class=btn_medium').'</CENTER>';
		echo "</form>";	
		echo "</div>";

	echo "</td>
                                        </tr>
                                      </table></td>
                                  </tr>
                                </table></td>
                            </tr>
                          </table></td>
                      </tr>
                    </table></td>
                </tr>
              </table></td>
          </tr>

        </table></td>
    </tr>
  </table>
</center>
</body>
</html>";

		exit();
}

# ------------------------------ Solution for screen error in Group scheduling end------------------------------------- #

################################### Select input with Disable Onlcik edit feature ##############

function SelectInput_Disonclick($value,$name,$title='',$options,$allow_na='N/A',$extra='',$div=true)
{
	if(Preferences('HIDDEN')!='Y')
		$div = false;

	if ($value!='' && !$options[$value])
		$options[$value] = array($value,'<FONT color=red>'.$value.'</FONT>');
		
		$return = (((is_array($options[$value])?$options[$value][1]:$options[$value])!='')?(is_array($options[$value])?$options[$value][1]:$options[$value]):($allow_na!==false?($allow_na?$allow_na:'-'):'-')).($title!=''?'<BR><small>'.(strpos(strtolower($title),'<font ')===false?'<FONT color='.Preferences('TITLES').'>':'').$title.(strpos(strtolower($title),'<font ')===false?'</FONT>':'').'</small>':'');

	return $return;
}


###################################################################################################

###########################################################################
function GetStuListAttn(& $extra)
{	global $contacts_RET,$view_other_RET,$_openSIS;

	if((!$extra['SELECT_ONLY'] || strpos($extra['SELECT_ONLY'],'GRADE_ID')!==false) && !$extra['functions']['GRADE_ID'])
		$functions = array('GRADE_ID'=>'GetGrade');
	else
		$functions = array();

	if($extra['functions'])
		$functions += $extra['functions'];

	if(!$extra['DATE'])
	{
		$queryMP = UserMP();
		$extra['DATE'] = DBDate();
	}
	else{
	#	$queryMP = GetCurrentMP('QTR',$extra['DATE'],false);
                $queryMP = UserMP();
        }
	if($_REQUEST['expanded_view']=='true')
	{
		if(!$extra['columns_after'])
			$extra['columns_after'] = array();
#############################################################################################
//Commented as it crashing for Linux due to  Blank Database tables
		//$view_fields_RET = DBGet(DBQuery("SELECT cf.ID,cf.TYPE,cf.TITLE FROM program_user_config puc,custom_fields cf WHERE puc.TITLE=cf.ID AND puc.PROGRAM='StudentFieldsView' AND puc.USER_ID='".User('STAFF_ID')."' AND puc.VALUE='Y'"));
#############################################################################################
		$view_address_RET = DBGet(DBQuery('SELECT VALUE FROM program_user_config WHERE PROGRAM=\'StudentFieldsView\' AND TITLE=\'ADDRESS\' AND USER_ID=\''.User('STAFF_ID').'\''));
		$view_address_RET = $view_address_RET[1]['VALUE'];
		$view_other_RET = DBGet(DBQuery('SELECT TITLE,VALUE FROM program_user_config WHERE PROGRAM=\'StudentFieldsView\' AND TITLE IN (\'CONTACT_INFO\',\'HOME_PHONE\',\'GUARDIANS\',\'ALL_CONTACTS\') AND USER_ID=\''.User('STAFF_ID').'\''),array(),array('TITLE'));

		if(!count($view_fields_RET) && !isset($view_address_RET) && !isset($view_other_RET['CONTACT_INFO']))
		{
			$extra['columns_after'] = array('CONTACT_INFO'=>'<IMG SRC=assets/down_phone_button.gif border=0>','gender'=>'Gender','ethnicity'=>'Ethnicity','ADDRESS'=>'Mailing Address','CITY'=>'City','STATE'=>'State','ZIPCODE'=>'Zipcode') + $extra['columns_after'];
			$select = ',s.STUDENT_ID AS CONTACT_INFO,s.GENDER,s.ETHNICITY,COALESCE(a.MAIL_ADDRESS,a.ADDRESS) AS ADDRESS,COALESCE(a.MAIL_CITY,a.CITY) AS CITY,COALESCE(a.MAIL_STATE,a.STATE) AS STATE,COALESCE(a.MAIL_ZIPCODE,a.ZIPCODE) AS ZIPCODE ';
			$extra['FROM'] = ' LEFT OUTER JOIN students_join_address sam ON (ssm.STUDENT_ID=sam.STUDENT_ID AND sam.MAILING=\'Y\') LEFT OUTER JOIN address a ON (sam.ADDRESS_ID=a.ADDRESS_ID) '.$extra['FROM'];
			$functions['CONTACT_INFO'] = 'makeContactInfo';
			// if gender is converted to codeds type
			//$functions['CUSTOM_200000000'] = 'DeCodeds';
			$extra['singular'] = 'Student Address';
			$extra['plural'] = 'Student Addresses';

			$extra2['NoSearchTerms'] = true;
			$extra2['SELECT_ONLY'] = 'ssm.STUDENT_ID,p.PERSON_ID,p.FIRST_NAME,p.LAST_NAME,sjp.STUDENT_RELATION,pjc.TITLE,pjc.VALUE,a.PHONE,sjp.ADDRESS_ID ';
			$extra2['FROM'] .= ',address a,students_join_address sja LEFT OUTER JOIN students_join_people sjp ON (sja.STUDENT_ID=sjp.STUDENT_ID AND sja.ADDRESS_ID=sjp.ADDRESS_ID AND (sjp.CUSTODY=\'Y\' OR sjp.EMERGENCY=\'Y\')) LEFT OUTER JOIN people p ON (p.PERSON_ID=sjp.PERSON_ID) LEFT OUTER JOIN people_join_contacts pjc ON (pjc.PERSON_ID=p.PERSON_ID) ';
			$extra2['WHERE'] .= ' AND a.ADDRESS_ID=sja.ADDRESS_ID AND sja.STUDENT_ID=ssm.STUDENT_ID ';
			$extra2['ORDER_BY'] .= 'COALESCE(sjp.CUSTODY,\'N\') DESC';
			$extra2['group'] = array('STUDENT_ID','PERSON_ID');

			// EXPANDED VIEW AND ADDR BREAKS THIS QUERY ... SO, TURN 'EM OFF
			if(!$_REQUEST['_openSIS_PDF'])
			{
				$expanded_view = $_REQUEST['expanded_view'];
				$_REQUEST['expanded_view'] = false;
				$addr = $_REQUEST['addr'];
				unset($_REQUEST['addr']);
				$contacts_RET = GetStuList($extra2);
				$_REQUEST['expanded_view'] = $expanded_view;
				$_REQUEST['addr'] = $addr;
			}
			else
				unset($extra2['columns_after']['CONTACT_INFO']);
		}
		else
		{
			if($view_other_RET['CONTACT_INFO'][1]['VALUE']=='Y' && !$_REQUEST['_openSIS_PDF'])
			{
				$select .= ',NULL AS CONTACT_INFO ';
				$extra['columns_after']['CONTACT_INFO'] = '<IMG SRC=assets/down_phone_button.gif border=0>';
				$functions['CONTACT_INFO'] = 'makeContactInfo';

				$extra2 = $extra;
				$extra2['NoSearchTerms'] = true;
				$extra2['SELECT'] = '';
				$extra2['SELECT_ONLY'] = 'ssm.STUDENT_ID,p.PERSON_ID,p.FIRST_NAME,p.LAST_NAME,sjp.STUDENT_RELATION,pjc.TITLE,pjc.VALUE,a.PHONE,sjp.ADDRESS_ID,COALESCE(sjp.CUSTODY,\'N\') ';
				$extra2['FROM'] .= ',address a,students_join_address sja LEFT OUTER JOIN students_join_people sjp ON (sja.STUDENT_ID=sjp.STUDENT_ID AND sja.ADDRESS_ID=sjp.ADDRESS_ID AND (sjp.CUSTODY=\'Y\' OR sjp.EMERGENCY=\'Y\')) LEFT OUTER JOIN people p ON (p.PERSON_ID=sjp.PERSON_ID) LEFT OUTER JOIN people_join_contacts pjc ON (pjc.PERSON_ID=p.PERSON_ID) ';
				$extra2['WHERE'] .= ' AND a.ADDRESS_ID=sja.ADDRESS_ID AND sja.STUDENT_ID=ssm.STUDENT_ID ';
				$extra2['ORDER_BY'] .= 'COALESCE(sjp.CUSTODY,\'N\') DESC';
				$extra2['group'] = array('STUDENT_ID','PERSON_ID');
				$extra2['functions'] = array();
				$extra2['link'] = array();

				// EXPANDED VIEW AND ADDR BREAKS THIS QUERY ... SO, TURN 'EM OFF
				$expanded_view = $_REQUEST['expanded_view'];
				$_REQUEST['expanded_view'] = false;
				$addr = $_REQUEST['addr'];
				unset($_REQUEST['addr']);
				$contacts_RET = GetStuList($extra2);
				$_REQUEST['expanded_view'] = $expanded_view;
				$_REQUEST['addr'] = $addr;
			}
			foreach($view_fields_RET as $field)
			{
				$extra['columns_after']['CUSTOM_'.$field['ID']] = $field['TITLE'];
				if($field['TYPE']=='date')
					$functions['CUSTOM_'.$field['ID']] = 'ProperDate';
				elseif($field['TYPE']=='numeric')
					$functions['CUSTOM_'.$field['ID']] = 'removeDot00';
				elseif($field['TYPE']=='codeds')
					$functions['CUSTOM_'.$field['ID']] = 'DeCodeds';
				$select .= ',s.CUSTOM_'.$field['ID'];
			}
			if($view_address_RET)
			{
				$extra['FROM'] = " LEFT OUTER JOIN students_join_address sam ON (ssm.STUDENT_ID=sam.STUDENT_ID AND sam.".$view_address_RET."='Y') LEFT OUTER JOIN address a ON (sam.ADDRESS_ID=a.ADDRESS_ID) ".$extra['FROM'];
				$extra['columns_after'] += array('ADDRESS'=>ucwords(strtolower(str_replace('_',' ',$view_address_RET))).' Address','CITY'=>'City','STATE'=>'State','ZIPCODE'=>'Zipcode');
				if($view_address_RET!='MAILING')
					$select .= ',a.ADDRESS_ID,a.ADDRESS,a.CITY,a.STATE,a.ZIPCODE,a.PHONE,ssm.STUDENT_ID AS PARENTS';
				else
					$select .= ',a.ADDRESS_ID,COALESCE(a.MAIL_ADDRESS,a.ADDRESS) AS ADDRESS,COALESCE(a.MAIL_CITY,a.CITY) AS CITY,COALESCE(a.MAIL_STATE,a.STATE) AS STATE,COALESCE(a.MAIL_ZIPCODE,a.ZIPCODE) AS ZIPCODE,a.PHONE,ssm.STUDENT_ID AS PARENTS ';
				$extra['singular'] = 'Student Address';
				$extra['plural'] = 'Student Addresses';

				if($view_other_RET['HOME_PHONE'][1]['VALUE']=='Y')
				{
					$functions['PHONE'] = 'makePhone';
					$extra['columns_after']['PHONE'] = 'Home Phone';
				}
				if($view_other_RET['GUARDIANS'][1]['VALUE']=='Y' || $view_other_RET['ALL_CONTACTS'][1]['VALUE']=='Y')
				{
					$functions['PARENTS'] = 'makeParents';
					if($view_other_RET['ALL_CONTACTS'][1]['VALUE']=='Y')
						$extra['columns_after']['PARENTS'] = 'Contacts';
					else
						$extra['columns_after']['PARENTS'] = 'Guardians';
				}
			}
			elseif($_REQUEST['addr'] || $extra['addr'])
			{
				$extra['FROM'] = ' LEFT OUTER JOIN students_join_address sam ON (ssm.STUDENT_ID=sam.STUDENT_ID '.$extra['students_join_address'].') LEFT OUTER JOIN address a ON (sam.ADDRESS_ID=a.ADDRESS_ID) '.$extra['FROM'];
				$distinct = 'DISTINCT ';
			}
		}
		$extra['SELECT'] .= $select;
	}
	elseif($_REQUEST['addr'] || $extra['addr'])
	{
		$extra['FROM'] = ' LEFT OUTER JOIN students_join_address sam ON (ssm.STUDENT_ID=sam.STUDENT_ID '.$extra['students_join_address'].') LEFT OUTER JOIN address a ON (sam.ADDRESS_ID=a.ADDRESS_ID) '.$extra['FROM'];
		$distinct = 'DISTINCT ';
	}

	switch(User('PROFILE'))
	{
		case 'admin':
			$sql = 'SELECT ';
			if($extra['SELECT_ONLY'])
				$sql .= $extra['SELECT_ONLY'];
			else
			{
				if(Preferences('NAME')=='Common')
					$sql .= 'CONCAT(s.LAST_NAME,\', \',coalesce(s.COMMON_NAME,s.FIRST_NAME)) AS FULL_NAME,';
				else
					$sql .= 'CONCAT(s.LAST_NAME,\', \',s.FIRST_NAME,\' \',COALESCE(s.MIDDLE_NAME,\' \')) AS FULL_NAME,';
				$sql .='s.LAST_NAME,s.FIRST_NAME,s.MIDDLE_NAME,s.STUDENT_ID,ssm.SCHOOL_ID AS LIST_SCHOOL_ID,ssm.GRADE_ID '.$extra['SELECT'];
				if($_REQUEST['include_inactive']=='Y')
					$sql .= ','.db_case(array('(ssm.SYEAR=\''.UserSyear().'\' AND (ssm.START_DATE IS NOT NULL AND (\''.date('Y-m-d',strtotime($extra['DATE'])).'\'<=ssm.END_DATE OR ssm.END_DATE IS NULL)))','true',"'<FONT color=green>Active</FONT>'","'<FONT color=red>Inactive</FONT>'")).' AS ACTIVE ';
			}

			$sql .= ' FROM students s,student_enrollment ssm '.$extra['FROM'].' WHERE ssm.STUDENT_ID=s.STUDENT_ID ';
			if($_REQUEST['include_inactive']=='Y')
				$sql .= ' AND ssm.ID=(SELECT ID FROM student_enrollment WHERE STUDENT_ID=ssm.STUDENT_ID AND SYEAR<=\''.UserSyear().'\' ORDER BY START_DATE DESC LIMIT 1)';
			else
				$sql .= ' AND ssm.SYEAR=\''.UserSyear().'\' AND (ssm.START_DATE IS NOT NULL AND (\''.date('Y-m-d',strtotime($extra['DATE'])).'\'<=ssm.END_DATE OR ssm.END_DATE IS NULL)) ';

			if(UserSchool() && $_REQUEST['_search_all_schools']!='Y')
				$sql .= ' AND ssm.SCHOOL_ID=\''.UserSchool().'\'';
			else
			{
//				if(User('SCHOOLS'))
					$sql .= ' AND ssm.SCHOOL_ID IN ('.GetUserSchools(UserID(),true).') ';
				$extra['columns_after']['LIST_SCHOOL_ID'] = 'School';
				$functions['LIST_SCHOOL_ID'] = 'GetSchool';
			}

			if(!$extra['SELECT_ONLY'] && $_REQUEST['include_inactive']=='Y')
				$extra['columns_after']['ACTIVE'] = 'Status';
		break;

		case 'teacher':
			$sql = 'SELECT ';
			if($extra['SELECT_ONLY'])
				$sql .= $extra['SELECT_ONLY'];
			else
			{
				if(Preferences('NAME')=='Common')
					$sql .= 'CONCAT(s.LAST_NAME,\', \',coalesce(s.COMMON_NAME,s.FIRST_NAME)) AS FULL_NAME,';
				else
					$sql .= 'CONCAT(s.LAST_NAME,\', \',s.FIRST_NAME,\' \',COALESCE(s.MIDDLE_NAME,\' \')) AS FULL_NAME,';
				$sql .='s.LAST_NAME,s.FIRST_NAME,s.MIDDLE_NAME,s.STUDENT_ID,ssm.SCHOOL_ID,ssm.GRADE_ID '.$extra['SELECT'];
				if($_REQUEST['include_inactive']=='Y')
				{
					$sql .= ','.db_case(array('(ssm.START_DATE IS NOT NULL AND  (\''.$extra['DATE'].'\'<=ssm.END_DATE OR ssm.END_DATE IS NULL))','true',"'<FONT color=green>Active</FONT>'","'<FONT color=red>Inactive</FONT>'")).' AS ACTIVE';
					$sql .= ','.db_case(array('(\''.$extra['DATE'].'\'>=ss.START_DATE AND (\''.$extra['DATE'].'\'<=ss.END_DATE OR ss.END_DATE IS NULL))','true',"'<FONT color=green>Active</FONT>'","'<FONT color=red>Inactive</FONT>'")).' AS ACTIVE_SCHEDULE';
				}
			}

		#	$sql .= " FROM students s,course_periods cp,schedule ss,student_enrollment ssm ".$extra['FROM']." WHERE ssm.STUDENT_ID=s.STUDENT_ID AND ssm.STUDENT_ID=ss.STUDENT_ID AND ssm.SCHOOL_ID='".UserSchool()."' AND ssm.SYEAR='".UserSyear()."' AND ssm.SYEAR=cp.SYEAR AND ssm.SYEAR=ss.SYEAR AND ss.MARKING_PERIOD_ID IN (".GetAllMP('',$queryMP).") AND (cp.TEACHER_ID='".User('STAFF_ID')."' OR cp.SECONDARY_TEACHER_ID='".User('STAFF_ID')."') AND cp.COURSE_PERIOD_ID='".UserCoursePeriod()."' AND cp.COURSE_ID=ss.COURSE_ID AND cp.COURSE_PERIOD_ID=ss.COURSE_PERIOD_ID";
		
//			$sql .= " FROM students s,course_periods cp,schedule ss,student_enrollment ssm ".$extra['FROM']." WHERE ssm.STUDENT_ID=s.STUDENT_ID AND ssm.STUDENT_ID=ss.STUDENT_ID AND ssm.SCHOOL_ID='".UserSchool()."' AND ssm.SYEAR='".UserSyear()."' AND ssm.SYEAR=cp.SYEAR AND ssm.SYEAR=ss.SYEAR AND (cp.TEACHER_ID='".User('STAFF_ID')."' OR cp.SECONDARY_TEACHER_ID='".User('STAFF_ID')."') AND cp.COURSE_PERIOD_ID='".UserCoursePeriod()."' AND cp.COURSE_ID=ss.COURSE_ID AND cp.COURSE_PERIOD_ID=ss.COURSE_PERIOD_ID";
                        $sql .= ' FROM students s,course_periods cp,schedule ss,student_enrollment ssm '.$extra['FROM'].' WHERE ssm.STUDENT_ID=s.STUDENT_ID AND ssm.STUDENT_ID=ss.STUDENT_ID AND ssm.SCHOOL_ID=\''.UserSchool().'\' AND ssm.SYEAR=\''.UserSyear().'\' AND ssm.SYEAR=cp.SYEAR AND ssm.SYEAR=ss.SYEAR AND '.  db_case(array(User('STAFF_ID'),'cp.teacher_id',' cp.teacher_id='.  User('STAFF_ID'),'cp.secondary_teacher_id',' cp.secondary_teacher_id='.  User('STAFF_ID'),'cp.course_period_id IN(SELECT course_period_id from teacher_reassignment tra WHERE cp.course_period_id=tra.course_period_id AND tra.pre_teacher_id='.  User('STAFF_ID').')')).' AND cp.COURSE_PERIOD_ID=\''.UserCoursePeriod().'\' AND cp.COURSE_ID=ss.COURSE_ID AND cp.COURSE_PERIOD_ID=ss.COURSE_PERIOD_ID';
			if($_REQUEST['include_inactive']=='Y')
			{
				$sql .= ' AND ssm.ID=(SELECT ID FROM student_enrollment WHERE STUDENT_ID=ssm.STUDENT_ID AND SYEAR=ssm.SYEAR ORDER BY START_DATE DESC LIMIT 1)';
				$sql .= ' AND ss.START_DATE=(SELECT START_DATE FROM schedule WHERE STUDENT_ID=ssm.STUDENT_ID AND SYEAR=ssm.SYEAR AND MARKING_PERIOD_ID IN ('.GetAllMP('',$queryMP).') AND COURSE_ID=cp.COURSE_ID AND COURSE_PERIOD_ID=cp.COURSE_PERIOD_ID ORDER BY START_DATE DESC LIMIT 1)';
			}
			else
			{
				$sql .= ' AND (ssm.START_DATE IS NOT NULL  AND \''.$extra['DATE'].'\'>=ssm.START_DATE AND (\''.$extra['DATE'].'\'<=ssm.END_DATE OR ssm.END_DATE IS NULL))';
				$sql .= ' AND (\''.$extra['DATE'].'\'>=ss.START_DATE AND (\''.$extra['DATE'].'\'<=ss.END_DATE OR ss.END_DATE IS NULL))';
			}

			if(!$extra['SELECT_ONLY'] && $_REQUEST['include_inactive']=='Y')
			{
				$extra['columns_after']['ACTIVE'] = 'School Status';
				$extra['columns_after']['ACTIVE_SCHEDULE'] = 'Course Status';
			}
		break;

		case 'parent':
		case 'student':
			$sql = 'SELECT ';
			if($extra['SELECT_ONLY'])
				$sql .= $extra['SELECT_ONLY'];
			else
			{
				if(Preferences('NAME')=='Common')
					$sql .= 'CONCAT(s.LAST_NAME,\', \',coalesce(s.COMMON_NAME,s.FIRST_NAME)) AS FULL_NAME,';
				else
					$sql .= 'CONCAT(s.LAST_NAME,\', \',s.FIRST_NAME,\' \',COALESCE(s.MIDDLE_NAME,\' \')) AS FULL_NAME,';
				$sql .='s.LAST_NAME,s.FIRST_NAME,s.MIDDLE_NAME,s.STUDENT_ID,ssm.SCHOOL_ID,ssm.GRADE_ID '.$extra['SELECT'];
			}
			$sql .= ' FROM students s,student_enrollment ssm '.$extra['FROM'].'
					WHERE ssm.STUDENT_ID=s.STUDENT_ID AND ssm.SYEAR=\''.UserSyear().'\' AND ssm.SCHOOL_ID=\''.UserSchool().'\' AND (\''.DBDate().'\' BETWEEN ssm.START_DATE AND ssm.END_DATE OR (ssm.END_DATE IS NULL AND \''.DBDate().'\'>ssm.START_DATE)) AND ssm.STUDENT_ID'.($extra['ASSOCIATED']?' IN (SELECT STUDENT_ID FROM students_join_users WHERE STAFF_ID=\''.$extra['ASSOCIATED'].'\')':'=\''.UserStudentID().'\'');
		break;
		default:
			exit('Error');
	}

	$sql = appendSQL($sql,$extra);

	$sql .= $extra['WHERE'].' ';
	$sql .= CustomFields('where');

	if($extra['GROUP'])
		$sql .= ' GROUP BY '.$extra['GROUP'];

	if(!$extra['ORDER_BY'] && !$extra['SELECT_ONLY'])
	{
		if(Preferences('SORT')=='Grade')
			$sql .= ' ORDER BY (SELECT SORT_ORDER FROM school_gradelevels WHERE ID=ssm.GRADE_ID),FULL_NAME';
		else
			$sql .= ' ORDER BY FULL_NAME';
		$sql .= $extra['ORDER'];
	}
	elseif($extra['ORDER_BY'])
		$sql .= ' ORDER BY '.$extra['ORDER_BY'];

	if($extra['DEBUG']===true)
		echo '<!--'.$sql.'-->';
		
	return DBGet(DBQuery($sql),$functions,$extra['group']);
}

###########################################################################
########################validation functions#######################################
function scheduleAssociation($cp_id)
{
    $asso=DBGet(DBQuery('SELECT COURSE_PERIOD_ID FROM schedule WHERE COURSE_PERIOD_ID=\''.$cp_id.'\' LIMIT 0,1'));
    if($asso[1]['COURSE_PERIOD_ID']!='')
        return true;
}

function gradeAssociation($cp_id)
{
    $asso=DBGet(DBQuery('SELECT COURSE_PERIOD_ID FROM student_report_card_grades WHERE COURSE_PERIOD_ID=\''.$cp_id.'\' LIMIT 0,1'));
    if($asso[1]['COURSE_PERIOD_ID']!='')
        return true;
}
###########################################################################
?>
