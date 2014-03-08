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
require_once("data.php");
//My Addition Shamim Ahmed Chowdhury
require_once ("common.inc.php");
require_once ("server_common.inc.php");

/**
* Contains all the functions specific to synchronization 
*/
require 'server_synchronize.lib.php';

/**
 * Increases the time limit up to the configured maximum 
 */
@set_time_limit($cfg['ExecTimeLimit']);
  
/**
 * Displays the links
 */
require 'server_links.inc.php';

$print_form=1;
$output_messages=array();
//test mysql connection
ini_set('memory_limit','9000M');
//ini_set('post_max_size','9000M');
//ini_set('upload_max_filesize','9000M');
ini_set('max_execution_time','50000');
ini_set('max_input_time','50000');
if($_REQUEST['modfunc']=='cancel')
echo " ";

else if(User('PROFILE')=='admin'&& isset($_REQUEST['action']) )
{
	$mysql_host=$DatabaseServer;
	$mysql_database=$DatabaseName;
	$mysql_username=$DatabaseUsername;
	$mysql_password=$_REQUEST['mysql_password'];
	if( 'Test Connection' == $_REQUEST['action'])
	{
		_mysql_test($mysql_host,$mysql_database, $mysql_username, $mysql_password);
	}
	else if( 'Synchronize' === $_REQUEST['action'])
	{
		_mysql_test($mysql_host,$mysql_database, $mysql_username, $mysql_password);
		
			$print_form=0;
			//ob_start("ob_gzhandler");\
                        $date_time=date("m-d-Y");
                    ;
                        $Export_FileName=$mysql_database.'_'.$date_time ;

			header('Content-type: text/plain');
			header('Content-Disposition: attachment; filename="'.$Export_FileName.'.sql"');
			//echo "/*mysqldump.php version $mysqldump_version \n";
                        echo "-- Server version:". mysql_get_server_info()."\n";
                        echo "-- PHP Version: ".phpversion()."\n\n";
                        echo 'SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";';

                        echo "\n\n/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;\n";
                        echo "/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;\n";
                        echo "/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;\n";
                        echo "/*!40101 SET NAMES utf8 */;\n\n";

                        echo "--\n";
                        echo "-- Database: `$mysql_database`\n";
                        echo "--\n\n";
                        echo "-- --------------------------------------------------------\n\n";



			_mysqldump($mysql_database);
			//header("Content-Length: ".ob_get_length());
			//ob_end_flush();
		}
}


/**
* Save the value of token generated for this page
*/
if (isset($_REQUEST['token'])) { 
    $_SESSION['token'] = $_REQUEST['token'];
}                         

// variable for code saving
$cons = array ("src", "trg");

/**
 * Displays the page when 'Go' is pressed
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


/**
* Displays the page when 'Synchronize Databases' is pressed.
*/

if (isset($_REQUEST['synchronize_db'])) {
 
    $src_db = $_SESSION['src_db']; 
    $trg_db = $_SESSION['trg_db'];
    $update_array = $_SESSION['update_array']; 
    $insert_array = $_SESSION['insert_array']; 
    $src_username = $_SESSION['src_username']; 
    $trg_username = $_SESSION['trg_username']; 
    $src_password = $_SESSION['src_password']; 
    $trg_password = $_SESSION['trg_password'];
    $matching_tables = $_SESSION['matching_tables']; 
    $matching_tables_keys = $_SESSION['matching_tables_keys'];
    $matching_tables_fields = $_SESSION['matching_fields']; 
    $source_tables_uncommon = $_SESSION['src_uncommon_tables']; 
    $uncommon_tables_fields = $_SESSION['uncommon_tables_fields'];
    $target_tables_uncommon = $_SESSION['target_tables_uncommon'];
    $row_count = $_SESSION['uncommon_tables_row_count'];
    $uncommon_tables = $_SESSION['uncommon_tables']; 
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
   * Display success message.
   */
    echo '<div class="success">' . $GLOBALS['strTargetDatabaseHasBeenSynchronized'] . '</div>';
    /**
    * Displaying all the tables of source and target database and now no difference is there.
    */
    PMA_syncDisplayHeaderSource($src_db);

        $odd_row = false;
        for($i = 0; $i < count($matching_tables); $i++)
        {
            $odd_row = PMA_syncDisplayBeginTableRow($odd_row);
            echo '<td>' . htmlspecialchars($matching_tables[$i]) . '</td>
            <td></td>
            </tr>';
        }
        for ($j = 0; $j < count($source_tables_uncommon); $j++) {
            $odd_row = PMA_syncDisplayBeginTableRow($odd_row);
            echo '<td> + ' . htmlspecialchars($source_tables_uncommon[$j]) . '</td> ';
            echo '<td></td>
            </tr>';
        }
        foreach ($target_tables_uncommon as $tbl_nc_name) {
            $odd_row = PMA_syncDisplayBeginTableRow($odd_row);
            echo '<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td><td></td>';
            echo '</tr>';
        }
        echo '</table>';
        $odd_row = PMA_syncDisplayHeaderTargetAndMatchingTables($trg_db, $matching_tables);
        foreach ($source_tables_uncommon as $tbl_nc_name) {
            $odd_row = PMA_syncDisplayBeginTableRow($odd_row);
            echo '<td>' . htmlspecialchars($tbl_nc_name) . ' </td>
            </tr>';
        }
        foreach ($target_tables_uncommon as $tbl_nc_name) {
            $odd_row = PMA_syncDisplayBeginTableRow($odd_row);
            echo '<td>  ' . htmlspecialchars($tbl_nc_name) . '</td>';
            echo '</tr>';
        }
    echo '</table> </div>';
  
    /**
    * connecting the source and target servers
    */
    if ('rmt' == $_SESSION['src_type']) {
        $src_link = PMA_DBI_connect($src_username, $src_password, $is_controluser = false, $_SESSION['src_server']);
    } else {
        $src_link = $GLOBALS['userlink'];
        // working on current server, so initialize this for tracking
        // (does not work if user defined current server as a remote one)
        $GLOBALS['db'] = $_SESSION['src_db'];
    }
    if ('rmt' == $_SESSION['trg_type']) {
        $trg_link = PMA_DBI_connect($trg_username, $trg_password, $is_controluser = false, $_SESSION['trg_server']);
    } else {
        $trg_link = $GLOBALS['userlink'];
        // working on current server, so initialize this for tracking
        $GLOBALS['db'] = $_SESSION['trg_db'];
    }
    
    /**
    * Displaying the queries.
    */
    echo '<h5>' . $GLOBALS['strQueriesExecuted'] . '</h5>';                                                                          
    echo '<div id="serverstatus" style = "overflow: auto; width: 1050px; height: 180px; 
         border-left: 1px gray solid; border-bottom: 1px gray solid; padding: 0px; margin: 0px"> ';            
    /**
    * Applying all sorts of differences for each matching table       
    */
    for($p = 0; $p < sizeof($matching_tables); $p++) {   
        /**
        *  If the check box is checked for deleting previous rows from the target database tables then 
        *  first find out rows to be deleted and then delete the rows.
        */
        if (isset($_REQUEST['delete_rows'])) {
            PMA_findDeleteRowsFromTargetTables($delete_array, $matching_tables, $p, $target_tables_keys, $matching_tables_keys,
                $trg_db, $trg_link, $src_db, $src_link);
             
            if (isset($delete_array[$p])) {
                PMA_deleteFromTargetTable($trg_db, $trg_link, $matching_tables, $p, $target_tables_keys, $delete_array, true);          
                unset($delete_array[$p]); 
            }        
        }
        if (isset($alter_str_array[$p])) {
            PMA_alterTargetTableStructure($trg_db, $trg_link, $matching_tables, $source_columns, $alter_str_array, $matching_tables_fields,
            $criteria, $matching_tables_keys, $target_tables_keys, $p, true);
            unset($alter_str_array[$p]);        
        }                                                           
        if (! empty($add_column_array[$p])) {
            PMA_findDeleteRowsFromTargetTables($delete_array, $matching_tables, $p, $target_tables_keys, $matching_tables_keys,
            $trg_db, $trg_link, $src_db, $src_link);
             
            if (isset($delete_array[$p])) {
                PMA_deleteFromTargetTable($trg_db, $trg_link, $matching_tables, $p, $target_tables_keys, $delete_array, true);
                unset($delete_array[$p]); 
            }        
            PMA_addColumnsInTargetTable($src_db, $trg_db, $src_link, $trg_link, $matching_tables, $source_columns, $add_column_array,
                $matching_tables_fields, $criteria, $matching_tables_keys, $target_tables_keys, $uncommon_tables, $uncommon_tables_fields, 
                $p, $uncommon_cols, true);
            unset($add_column_array[$p]);
        }
        if (isset($uncommon_columns[$p])) {
            PMA_removeColumnsFromTargetTable($trg_db, $trg_link, $matching_tables, $uncommon_columns, $p, true);
            unset($uncommon_columns[$p]); 
        }           
        if (isset($matching_table_structure_diff) && 
            (isset($add_indexes_array[$matching_table_structure_diff[$p]]) 
            || isset($remove_indexes_array[$matching_table_structure_diff[$p]]) 
            || isset($alter_indexes_array[$matching_table_structure_diff[$p]]))) {
            PMA_applyIndexesDiff ($trg_db, $trg_link, $matching_tables, $source_indexes, $target_indexes, $add_indexes_array, $alter_indexes_array, 
            $remove_indexes_array, $matching_table_structure_diff[$p], true); 
           
            unset($add_indexes_array[$matching_table_structure_diff[$p]]);
            unset($alter_indexes_array[$matching_table_structure_diff[$p]]);
            unset($remove_indexes_array[$matching_table_structure_diff[$p]]);
        }     
        
        PMA_updateTargetTables($matching_tables, $update_array, $src_db, $trg_db, $trg_link, $p, $matching_tables_keys, true);
        
        PMA_insertIntoTargetTable($matching_tables, $src_db, $trg_db, $src_link, $trg_link , $matching_tables_fields, $insert_array, $p, 
            $matching_tables_keys, $matching_tables_keys, $source_columns, $add_column_array, $criteria, $target_tables_keys, $uncommon_tables, 
            $uncommon_tables_fields,$uncommon_cols, $alter_str_array,$source_indexes, $target_indexes, $add_indexes_array, 
            $alter_indexes_array, $delete_array, $update_array, true);   
    }              
                                                                                                                    
    /**
    *  Creating and populating tables present in source but absent from target database.  
    */   
    for($q = 0; $q < sizeof($source_tables_uncommon); $q++) { 
        if (isset($uncommon_tables[$q])) {
            PMA_createTargetTables($src_db, $trg_db, $src_link, $trg_link, $source_tables_uncommon, $q, $uncommon_tables_fields, true);
        }
        if (isset($row_count[$q])) {
            PMA_populateTargetTables($src_db, $trg_db, $src_link, $trg_link, $source_tables_uncommon, $q, $uncommon_tables_fields, true);    
        }
    }
    echo "</div>";          
}

/**
 * Displays the main page when none of the following buttons is pressed
 */

 if (! isset($_REQUEST['submit_connect']) && ! isset($_REQUEST['synchronize_db']) && ! isset($_REQUEST['Table_ids']) )
{ 
/**                      
* Displays the sub-page heading
*/
    echo '<h2>' . ($GLOBALS['cfg']['MainPageIconic']
    ? '<img class="icon" src="' . $pmaThemeImage . 's_sync.png" width="18"'
        . ' height="18" alt="" />'
    : '')
    . $strSynchronize
    .'</h2>';
    
    echo  '<div id="serverstatus">                 
    <form name="connection_form" id="connection_form" method="post" action="server_synchronize.php"
   >' // TODO: add check if all var. are filled in
    . PMA_generate_common_hidden_inputs('', ''); 
    echo '<fieldset>';
    echo '<legend>' . $GLOBALS['strSynchronize'] . '</legend>';
 /**
  * Displays the forms
  */
    
    $databases = PMA_DBI_get_databases_full(null, false, null, 'SCHEMA_NAME',
        'ASC', 0, true);
	
    foreach ($cons as $type) {
      echo '<table id="serverconnection_' . $type . '_remote" class="data">
      <tr>
	  <th colspan="2">' . $GLOBALS['strDatabase_'.$type] . '</th>
      </tr>
      <tr class="odd">
	  <td colspan="2" style="text-align: center">
	     <select name="' . $type . '_type" id="' . $type . '_type">
	      <option value="rmt">' . $GLOBALS['strRemoteServer'] . '</option>
	      <option value="cur">' . $GLOBALS['strCurrentServer'] . '</option>
	     </select>
	  </td>
      </tr>
	<tr class="even" id="' . $type . 'tr1">
	    <td>' . $GLOBALS['strHost'] . '</td>
	    <td><input type="text" name="' . $type . '_host" /></td> 
	</tr>
	<tr class="odd" id="' . $type . 'tr2">
	    <td>' . $GLOBALS['strPort'] . '</td>
	    <td><input type="text" name="' . $type . '_port" value="3306" maxlength="5" size="5" /></td>
	</tr>
	<tr class="even" id="' . $type . 'tr3">
	    <td>' . $GLOBALS['strSocket'] . '</td>
	    <td><input type="text" name="' . $type . '_socket" /></td>
	</tr>
	<tr class="odd" id="'.$type.'tr4">
	    <td>' . $GLOBALS['strUserName']. '</td>
	    <td><input type="text" name="'. $type . '_username" /></td>
	</tr>
	<tr class="even" id="' . $type . 'tr5">
	    <td>' . $GLOBALS['strPassword'] . '</td>
	    <td><input type="password" name="' . $type . '_pass" /> </td>   
	</tr>
	<tr class="odd" id="' . $type . 'tr6">
	    <td>' . $GLOBALS['strDatabase'] . '</td>
	    <td><input type="text" name="' . $type . '_db" /></td>
	</tr>
	<tr class="even" id="' . $type . 'tr7" style="display: none;">
	    <td>' . $GLOBALS['strDatabase'] . '</td>
	    <td>';
      // these unset() do not complain if the elements do not exist
    unset($databases['mysql']);
    unset($databases['information_schema']);

	if (count($databases) == 0) {
		echo $GLOBALS['strNoDatabases'];
	} else {
		echo '
	      	<select name="' . $type . '_db_sel">
		';
		foreach ($databases as $db) {
            echo '		<option>' . htmlspecialchars($db['SCHEMA_NAME']) . '</option>';
		}  
        echo '</select>';
	}
	echo '</td> </tr>
      </table>';

    // Add JS to show/hide rows based on the selection      
      PMA_js(''.
	'$(\'' . $type . '_type\').addEvent(\'change\',function() {' . 
	'    if ($(\'' . $type . 'tr1\').getStyle(\'display\')=="none") {' .
	'	for (var i=1; i<7; i++)' .
	'		$(\'' . $type . 'tr\'+i).tween(\'display\', \'table-row\');' .
	'	$(\'' . $type . 'tr7\').tween(\'display\', \'none\');' .
	'    }' .
	'   else {' .
	'	for (var i=1; i<7; i++)'.
	'		$(\'' . $type . 'tr\'+i).tween(\'display\', \'none\');' .
	'	$(\'' . $type . 'tr7\').tween(\'display\', \'table-row\');'.
	'    }' .
	'});'
	);
   }
   unset ($types, $type);
   
    echo '
    </fieldset>
    <fieldset class="tblFooters">
        <input type="submit" name="submit_connect" value="' . $GLOBALS['strGo'] .'" id="buttonGo" />
    </fieldset>
    </form>
    </div>
    <div class="notice">' . $strSynchronizationNote . '</div>';
}

/**
 * Displays the footer
 */
require_once 'footer.inc.php';


// End Of My Writing Shamim Ahmed Chowdhury

    
    

function _mysqldump($mysql_database)
{


        $sql='show tables where tables_in_'.$mysql_database.' not like \'course_details%\' and tables_in_'.$mysql_database.' not like \'enroll_grade%\'
               and tables_in_'.$mysql_database.' not like \'marking_periods%\' and tables_in_'.$mysql_database.' not like \'student_contacts%\' and tables_in_'.$mysql_database.' not like \'transcript_grades%\' ;';
	$result= mysql_query($sql);
	if( $result)
	{
		while( $row= mysql_fetch_row($result))
		{
			_mysqldump_table_structure($row[0]);
			_mysqldump_table_data($row[0]);

		}
	echo "--
              --
              --

            CREATE VIEW marking_periods AS
            SELECT q.marking_period_id, 'openSIS' AS mp_source, q.syear,
            q.school_id, 'quarter' AS mp_type, q.title, q.short_name,
            q.sort_order, q.semester_id AS parent_id,
            s.year_id AS grandparent_id, q.start_date,
            q.end_date, q.post_start_date,
            q.post_end_date, q.does_grades,
            q.does_exam, q.does_comments
           FROM school_quarters q
           JOIN school_semesters s ON q.semester_id = s.marking_period_id
           UNION
            SELECT marking_period_id, 'openSIS' AS mp_source, syear,
            school_id, 'semester' AS mp_type, title, short_name,
            sort_order, year_id AS parent_id,
            -1 AS grandparent_id, start_date,
            end_date, post_start_date,
            post_end_date, does_grades,
            does_exam, does_comments
           FROM school_semesters
           UNION
            SELECT marking_period_id, 'openSIS' AS mp_source, syear,
            school_id, 'year' AS mp_type, title, short_name,
            sort_order, -1 AS parent_id,
            -1 AS grandparent_id, start_date,
            end_date, post_start_date,
            post_end_date, does_grades,
            does_exam, does_comments
            FROM school_years
           UNION
           SELECT marking_period_id, 'History' AS mp_source, syear,
	   school_id, mp_type, name AS title, NULL AS short_name,
	   NULL AS sort_order, parent_id,
	   -1 AS grandparent_id, NULL AS start_date,
	   post_end_date AS end_date, NULL AS post_start_date,
	   post_end_date, 'Y' AS does_grades,
	   NULL AS does_exam, NULL AS does_comments
           FROM history_marking_periods;\n

          

             CREATE VIEW course_details AS
             SELECT cp.school_id, cp.syear, cp.marking_period_id, cp.period_id, c.subject_id,
	     cp.course_id, cp.course_period_id, cp.teacher_id, cp.secondary_teacher_id, c.title AS course_title,
	     cp.title AS cp_title, cp.grade_scale_id, cp.mp, cp.credits
             FROM course_periods cp, courses c WHERE (cp.course_id = c.course_id);\n\n

            CREATE VIEW enroll_grade AS
            SELECT e.id, e.syear, e.school_id, e.student_id, e.start_date, e.end_date, sg.short_name, sg.title
            FROM student_enrollment e, school_gradelevels sg WHERE (e.grade_id = sg.id);\n\n

            CREATE VIEW student_contacts AS
            SELECT DISTINCT sta.student_id AS student_id,st.alt_id,CONCAT( st.first_name, ' ', st.last_name )AS student_name,'Primary' AS contact_type,
                    prim_student_relation AS relation, 
                    pri_first_name AS relation_first_name,  pri_last_name AS relation_last_name,prim_address AS address1, prim_street AS address2,city AS city,state AS state,zipcode AS zip,work_phone AS work_phone,home_phone AS home_phone,mobile_phone AS cell_phone,
                    address.email AS email_id,'1' AS sort
            FROM students_join_address sta,address,students st WHERE   address.address_id=sta.address_id AND   st.student_id=sta.student_id 
            UNION
            SELECT DISTINCT sta.student_id AS student_id,st.alt_id,CONCAT( st.first_name, ' ', st.last_name )AS student_name,'Secondary' AS contact_type,
                    sec_student_relation AS relation,
                    sec_first_name AS relation_first_name, sec_last_name AS relation_last_name,sec_address AS address1, sec_street AS address2,city AS city,state AS state,zipcode AS zip, sec_work_phone AS work_phone,sec_home_phone AS home_phone,sec_mobile_phone AS cell_phone,
                    address.email AS email_id,'2' AS sort
            FROM students_join_address sta,address,students st WHERE   address.address_id=sta.address_id AND   st.student_id=sta.student_id 
            UNION
            SELECT DISTINCT  stp.student_id AS student_id,st.alt_id, CONCAT( st.first_name, ' ', st.last_name )AS student_name,'Other' AS contact_type,
                    stp.student_relation AS relation,
                    people.first_name AS relation_first_name,  people.last_name AS relation_last_name,stp.addn_address AS address1, stp.addn_street AS address2,addn_city AS city,addn_state AS state,addn_zipcode AS zip,addn_work_phone AS work_phone,addn_home_phone AS home_phone,addn_mobile_phone AS cell_phone,
                    stp.addn_email AS email_id,'3' AS sort
            FROM people,students_join_people stp ,students st  WHERE   people.person_id=stp.person_id  AND   st.student_id=stp.student_id;\n\n


    CREATE VIEW transcript_grades AS
    SELECT s.id AS school_id, IF(mp.mp_source='history',(SELECT school_name FROM history_school WHERE student_id=rcg.student_id and marking_period_id=mp.marking_period_id),s.title) AS school_name,mp_source, mp.marking_period_id AS mp_id,
	mp.title AS mp_name, mp.syear, mp.end_date AS posted, rcg.student_id,
	sgc.grade_level_short AS gradelevel, rcg.grade_letter, rcg.unweighted_gp AS gp_value,
	rcg.weighted_gp AS weighting, rcg.gp_scale, rcg.credit_attempted, rcg.credit_earned,
	rcg.credit_category, rcg.course_title AS course_name,
	sgc.weighted_gpa,
	sgc.unweighted_gpa,
                  sgc.gpa,
	sgc.class_rank,mp.sort_order
    FROM student_report_card_grades rcg
    INNER JOIN marking_periods mp ON mp.marking_period_id = rcg.marking_period_id AND mp.mp_type IN ('year','semester','quarter')
    INNER JOIN student_gpa_calculated sgc ON sgc.student_id = rcg.student_id AND sgc.marking_period_id = rcg.marking_period_id
    INNER JOIN schools s ON s.id = mp.school_id;\n
            ";
        echo "DELIMITER $$
--
-- Procedures
--
CREATE PROCEDURE `ATTENDANCE_CALC`(IN cp_id INT,IN year INT,IN school INT)
BEGIN
 DELETE FROM missing_attendance WHERE COURSE_PERIOD_ID=cp_id;
 INSERT INTO missing_attendance(SCHOOL_ID,SYEAR,SCHOOL_DATE,COURSE_PERIOD_ID,PERIOD_ID,TEACHER_ID,SECONDARY_TEACHER_ID) SELECT s.ID AS SCHOOL_ID,acc.SYEAR,acc.SCHOOL_DATE,cp.COURSE_PERIOD_ID,cp.PERIOD_ID, IF(tra.course_period_id=cp.course_period_id AND acc.school_date<tra.assign_date =true,tra.pre_teacher_id,cp.teacher_id) AS TEACHER_ID,cp.SECONDARY_TEACHER_ID FROM attendance_calendar acc INNER JOIN marking_periods mp ON mp.SYEAR=acc.SYEAR AND mp.SCHOOL_ID=acc.SCHOOL_ID AND acc.SCHOOL_DATE BETWEEN mp.START_DATE AND mp.END_DATE INNER JOIN course_periods cp ON cp.MARKING_PERIOD_ID=mp.MARKING_PERIOD_ID AND cp.DOES_ATTENDANCE='Y' AND cp.CALENDAR_ID=acc.CALENDAR_ID LEFT JOIN teacher_reassignment tra ON (cp.course_period_id=tra.course_period_id) INNER JOIN school_periods sp ON sp.SYEAR=acc.SYEAR AND sp.SCHOOL_ID=acc.SCHOOL_ID AND sp.PERIOD_ID=cp.PERIOD_ID AND (sp.BLOCK IS NULL AND position(substring('UMTWHFS' FROM DAYOFWEEK(acc.SCHOOL_DATE) FOR 1) IN cp.DAYS)>0 OR sp.BLOCK IS NOT NULL AND acc.BLOCK IS NOT NULL AND sp.BLOCK=acc.BLOCK) INNER JOIN schools s ON s.ID=acc.SCHOOL_ID INNER JOIN schedule sch ON sch.COURSE_PERIOD_ID=cp.COURSE_PERIOD_ID AND sch.START_DATE<=acc.SCHOOL_DATE AND (sch.END_DATE IS NULL OR sch.END_DATE>=acc.SCHOOL_DATE ) AND cp.COURSE_PERIOD_ID= cp_id LEFT JOIN attendance_completed ac ON ac.SCHOOL_DATE=acc.SCHOOL_DATE AND IF(tra.course_period_id=cp.course_period_id AND acc.school_date<=tra.assign_date =true,ac.staff_id=tra.pre_teacher_id,ac.staff_id=cp.teacher_id) AND ac.PERIOD_ID=sp.PERIOD_ID WHERE acc.SYEAR=year AND acc.SCHOOL_ID=school AND (acc.MINUTES IS NOT NULL AND acc.MINUTES>0) AND acc.SCHOOL_DATE<=CURDATE() AND ac.STAFF_ID IS NULL GROUP BY s.TITLE,acc.SCHOOL_DATE,cp.TITLE,cp.COURSE_PERIOD_ID,cp.TEACHER_ID;
 END$$

CREATE PROCEDURE `ATTENDANCE_CALC_BY_DATE`(IN sch_dt DATE,IN year INT,IN school INT)
BEGIN
  DELETE FROM missing_attendance WHERE SCHOOL_DATE=sch_dt AND SYEAR=year AND SCHOOL_ID=school;
  INSERT INTO missing_attendance(SCHOOL_ID,SYEAR,SCHOOL_DATE,COURSE_PERIOD_ID,PERIOD_ID,TEACHER_ID,SECONDARY_TEACHER_ID) SELECT s.ID AS SCHOOL_ID,acc.SYEAR,acc.SCHOOL_DATE,cp.COURSE_PERIOD_ID,cp.PERIOD_ID, IF(tra.course_period_id=cp.course_period_id AND acc.school_date<tra.assign_date =true,tra.pre_teacher_id,cp.teacher_id) AS TEACHER_ID,cp.SECONDARY_TEACHER_ID FROM attendance_calendar acc INNER JOIN marking_periods mp ON mp.SYEAR=acc.SYEAR AND mp.SCHOOL_ID=acc.SCHOOL_ID AND acc.SCHOOL_DATE BETWEEN mp.START_DATE AND mp.END_DATE INNER JOIN course_periods cp ON cp.MARKING_PERIOD_ID=mp.MARKING_PERIOD_ID AND cp.DOES_ATTENDANCE='Y' AND cp.CALENDAR_ID=acc.CALENDAR_ID LEFT JOIN teacher_reassignment tra ON (cp.course_period_id=tra.course_period_id) INNER JOIN school_periods sp ON sp.SYEAR=acc.SYEAR AND sp.SCHOOL_ID=acc.SCHOOL_ID AND sp.PERIOD_ID=cp.PERIOD_ID AND (sp.BLOCK IS NULL AND position(substring('UMTWHFS' FROM DAYOFWEEK(acc.SCHOOL_DATE) FOR 1) IN cp.DAYS)>0 OR sp.BLOCK IS NOT NULL AND acc.BLOCK IS NOT NULL AND sp.BLOCK=acc.BLOCK) INNER JOIN schools s ON s.ID=acc.SCHOOL_ID INNER JOIN schedule sch ON sch.COURSE_PERIOD_ID=cp.COURSE_PERIOD_ID AND sch.START_DATE<=acc.SCHOOL_DATE AND (sch.END_DATE IS NULL OR sch.END_DATE>=acc.SCHOOL_DATE )  LEFT JOIN attendance_completed ac ON ac.SCHOOL_DATE=acc.SCHOOL_DATE AND IF(tra.course_period_id=cp.course_period_id AND acc.school_date<tra.assign_date =true,ac.staff_id=tra.pre_teacher_id,ac.staff_id=cp.teacher_id) AND ac.PERIOD_ID=sp.PERIOD_ID WHERE acc.SYEAR=year AND acc.SCHOOL_ID=school AND (acc.MINUTES IS NOT NULL AND acc.MINUTES>0) AND acc.SCHOOL_DATE=sch_dt AND ac.STAFF_ID IS NULL GROUP BY s.TITLE,acc.SCHOOL_DATE,cp.TITLE,cp.COURSE_PERIOD_ID,cp.TEACHER_ID;
 END$$

CREATE PROCEDURE `SEAT_COUNT`()
BEGIN
 UPDATE course_periods SET filled_seats=filled_seats-1 WHERE COURSE_PERIOD_ID IN (SELECT COURSE_PERIOD_ID FROM schedule WHERE end_date IS NOT NULL AND end_date < CURDATE() AND dropped='N');
 UPDATE schedule SET dropped='Y' WHERE end_date IS NOT NULL AND end_date < CURDATE() AND dropped='N';
 END$$

CREATE PROCEDURE `SEAT_FILL`()
BEGIN
 UPDATE course_periods SET filled_seats=filled_seats+1 WHERE COURSE_PERIOD_ID IN (SELECT COURSE_PERIOD_ID FROM schedule WHERE dropped='Y' AND ( end_date IS NULL OR end_date >= CURDATE()));
 UPDATE schedule SET dropped='N' WHERE dropped='Y' AND ( end_date IS NULL OR end_date >= CURDATE()) ;
 END$$

CREATE PROCEDURE `TEACHER_REASSIGNMENT`()
BEGIN
  UPDATE course_periods cp,teacher_reassignment tr,school_periods sp,marking_periods mp,staff st SET cp.title=CONCAT(sp.title,IF(cp.mp<>'FY',CONCAT(' - ',mp.short_name),''),IF(CHAR_LENGTH(cp.days)<5,CONCAT(' - ',cp.days),''),' - ',cp.short_name,' - ',CONCAT_WS(' ',st.first_name,st.middle_name,st.last_name)), cp.teacher_id=tr.teacher_id WHERE cp.period_id=sp.period_id and cp.marking_period_id=mp.marking_period_id and st.staff_id=tr.teacher_id and cp.course_period_id=tr.course_period_id AND assign_date <= CURDATE() AND updated='N';
  UPDATE teacher_reassignment SET updated='Y' WHERE assign_date <=CURDATE() AND updated='N';
 END$$

--
-- Functions
--
CREATE FUNCTION `CALC_CUM_GPA_MP`(
mp_id int
) RETURNS int(11)
BEGIN

DECLARE req_mp INT DEFAULT 0;
DECLARE done INT DEFAULT 0;
DECLARE gp_points DECIMAL(10,2);
DECLARE student_id INT;
DECLARE gp_points_weighted DECIMAL(10,2);
DECLARE divisor DECIMAL(10,2);
DECLARE credit_earned DECIMAL(10,2);
DECLARE cgpa DECIMAL(10,2);

DECLARE cur1 CURSOR FOR
   SELECT srcg.student_id,
                  IF(ISNULL(sum(srcg.unweighted_gp)),  (SUM(srcg.weighted_gp*srcg.credit_earned)),
                      IF(ISNULL(sum(srcg.weighted_gp)), SUM(srcg.unweighted_gp*srcg.credit_earned),
                         ( SUM(srcg.unweighted_gp*srcg.credit_attempted)+ SUM(srcg.weighted_gp*srcg.credit_earned))
                        ))as gp_points,

                      SUM(srcg.weighted_gp*srcg.credit_earned) as gp_points_weighted,
                      SUM(srcg.credit_attempted) as divisor,
                      SUM(srcg.credit_earned) as credit_earned,
   		      IF(ISNULL(sum(srcg.unweighted_gp)),  (SUM(srcg.weighted_gp*srcg.credit_earned))/ sum(srcg.credit_attempted),
                          IF(ISNULL(sum(srcg.weighted_gp)), SUM(srcg.unweighted_gp*srcg.credit_earned)/sum(srcg.credit_attempted),
                             ( SUM(srcg.unweighted_gp*srcg.credit_attempted)+ SUM(srcg.weighted_gp*srcg.credit_earned))/sum(srcg.credit_attempted)
                            )
                         ) as cgpa

            FROM marking_periods mp,temp_cum_gpa srcg
            INNER JOIN schools sc ON sc.id=srcg.school_id
            WHERE srcg.marking_period_id= mp.marking_period_id AND srcg.gp_scale<>0 AND srcg.marking_period_id NOT LIKE 'E%'
            AND mp.marking_period_id IN (SELECT marking_period_id  FROM marking_periods WHERE mp_type=req_mp )
            GROUP BY srcg.student_id;
 DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = 1;


  CREATE TEMPORARY TABLE tmp(
    student_id int,
    sum_weighted_factors decimal(10,6),
    count_weighted_factors int,
    sum_unweighted_factors decimal(10,6),
    count_unweighted_factors int,
    grade_level_short varchar(10)
  );

  INSERT INTO tmp(student_id,sum_weighted_factors,count_weighted_factors,
    sum_unweighted_factors, count_unweighted_factors,grade_level_short)
  SELECT
    srcg.student_id,
    SUM(srcg.weighted_gp/s.reporting_gp_scale) AS sum_weighted_factors,
    COUNT(*) AS count_weighted_factors,
    SUM(srcg.unweighted_gp/srcg.gp_scale) AS sum_unweighted_factors,
    COUNT(*) AS count_unweighted_factors,
    eg.short_name
  FROM student_report_card_grades srcg
  INNER JOIN schools s ON s.id=srcg.school_id
  LEFT JOIN enroll_grade eg on eg.student_id=srcg.student_id AND eg.syear=srcg.syear AND eg.school_id=srcg.school_id
  WHERE srcg.marking_period_id=mp_id AND srcg.gp_scale<>0 AND srcg.marking_period_id NOT LIKE 'E%'
  GROUP BY srcg.student_id,eg.short_name;

  UPDATE student_mp_stats sms
    INNER JOIN tmp t on t.student_id=sms.student_id
  SET
    sms.sum_weighted_factors=t.sum_weighted_factors,
    sms.count_weighted_factors=t.count_weighted_factors,
    sms.sum_unweighted_factors=t.sum_unweighted_factors,
    sms.count_unweighted_factors=t.count_unweighted_factors
  WHERE sms.marking_period_id=mp_id;

  INSERT INTO student_mp_stats(student_id,marking_period_id,sum_weighted_factors,count_weighted_factors,
    sum_unweighted_factors,count_unweighted_factors,grade_level_short)
  SELECT
      t.student_id,
      mp_id,
      t.sum_weighted_factors,
      t.count_weighted_factors,
      t.sum_unweighted_factors,
      t.count_unweighted_factors,
      t.grade_level_short
    FROM tmp t
    LEFT JOIN student_mp_stats sms ON sms.student_id=t.student_id AND sms.marking_period_id=mp_id
    WHERE sms.student_id IS NULL;

  UPDATE student_mp_stats g
    INNER JOIN (
	SELECT s.student_id,
		SUM(s.weighted_gp/sc.reporting_gp_scale)/COUNT(*) AS cum_weighted_factor,
		SUM(s.unweighted_gp/s.gp_scale)/COUNT(*) AS cum_unweighted_factor
	FROM student_report_card_grades s
	INNER JOIN schools sc ON sc.id=s.school_id
	LEFT JOIN course_periods p ON p.course_period_id=s.course_period_id
	WHERE p.marking_period_id IS NULL OR p.marking_period_id=s.marking_period_id
	GROUP BY student_id) gg ON gg.student_id=g.student_id
    SET g.cum_unweighted_factor=gg.cum_unweighted_factor, g.cum_weighted_factor=gg.cum_weighted_factor;


    SELECT mp_type INTO @mp_type FROM marking_periods WHERE marking_period_id=mp_id;

 
    IF @mp_type = 'quarter'  THEN
           set req_mp = 'quarter';
    ELSEIF @mp_type = 'semester'  THEN
        IF EXISTS(SELECT student_id FROM student_report_card_grades srcg WHERE srcg.marking_period_id IN (SELECT marking_period_id  FROM marking_periods WHERE mp_type=@mp_type)) THEN
           set req_mp  = 'semester';
       ELSE
           set req_mp  = 'quarter';
        END IF;
   ELSEIF @mp_type = 'year'  THEN
           IF EXISTS(SELECT student_id FROM student_report_card_grades srcg WHERE srcg.MARKING_PERIOD_ID IN (SELECT marking_period_id  FROM marking_periods WHERE mp_type='semester')
                     UNION  SELECT student_id FROM student_report_card_grades srcg WHERE srcg.MARKING_PERIOD_ID IN (SELECT marking_period_id  FROM history_marking_periods WHERE mp_type='semester')
                     ) THEN
                 set req_mp  = 'semester';
         
          ELSE
                  set req_mp  = 'quarter ';
            END IF;
   END IF;



open cur1;
fetch cur1 into student_id, gp_points,gp_points_weighted,divisor,credit_earned,cgpa;

while not done DO
    IF EXISTS(SELECT student_id FROM student_gpa_running WHERE  student_gpa_running.student_id=student_id) THEN
    UPDATE student_gpa_running gc
               SET gpa_points=gp_points,gpa_points_weighted=gp_points_weighted,gc.divisor=divisor,credit_earned=credit_earned,gc.cgpa=cgpa where gc.student_id=student_id;
    ELSE
        INSERT INTO student_gpa_running(student_id,marking_period_id,gpa_points,gpa_points_weighted, divisor,credit_earned,cgpa)
          VALUES(student_id,mp_id,gp_points,gp_points_weighted,divisor,credit_earned,cgpa);
    END IF;
fetch cur1 into student_id, gp_points,gp_points_weighted,divisor,credit_earned,cgpa;
END WHILE;
CLOSE cur1;

RETURN 1;

END$$

CREATE FUNCTION `CALC_GPA_MP`(
 	s_id int,
 	mp_id int
 ) RETURNS int(11)
BEGIN
   SELECT
     SUM(srcg.weighted_gp/s.reporting_gp_scale) AS sum_weighted_factors, 
     COUNT(*) AS count_weighted_factors,                        
     SUM(srcg.unweighted_gp/srcg.gp_scale) AS sum_unweighted_factors, 
     COUNT(*) AS count_unweighted_factors,
    IF(ISNULL(sum(srcg.unweighted_gp)),  (SUM(srcg.weighted_gp*srcg.credit_earned))/ sum(srcg.credit_attempted),
                       IF(ISNULL(sum(srcg.weighted_gp)), SUM(srcg.unweighted_gp*srcg.credit_earned)/sum(srcg.credit_attempted),
                          ( SUM(srcg.unweighted_gp*srcg.credit_attempted)+ SUM(srcg.weighted_gp*srcg.credit_earned))/sum(srcg.credit_attempted)
                         )
       ),
     
     SUM(srcg.weighted_gp*srcg.credit_earned)/(select sum(sg.credit_attempted) from student_report_card_grades sg where sg.marking_period_id=mp_id AND sg.student_id=s_id
                                                   AND sg.weighted_gp  IS NOT NULL  AND sg.unweighted_gp IS NULL GROUP BY sg.student_id, sg.marking_period_id) ,
     SUM(srcg.unweighted_gp*srcg.credit_earned)/ (select sum(sg.credit_attempted) from student_report_card_grades sg where sg.marking_period_id=mp_id AND sg.student_id=s_id
                                                      AND sg.unweighted_gp  IS NOT NULL  AND sg.weighted_gp IS NULL GROUP BY sg.student_id, sg.marking_period_id) ,
     eg.short_name
   INTO
     @sum_weighted_factors,
     @count_weighted_factors,
     @sum_unweighted_factors,
     @count_unweighted_factors,
     @gpa,
     @weighted_gpa,
     @unweighted_gpa,
     @grade_level_short
   FROM student_report_card_grades srcg
   INNER JOIN schools s ON s.id=srcg.school_id
   LEFT JOIN enroll_grade eg on eg.student_id=srcg.student_id AND eg.syear=srcg.syear AND eg.school_id=srcg.school_id
   WHERE srcg.marking_period_id=mp_id AND srcg.student_id=s_id AND srcg.gp_scale<>0 AND srcg.marking_period_id NOT LIKE 'E%'
   GROUP BY srcg.student_id,eg.short_name;
 
   IF EXISTS(SELECT NULL FROM student_mp_stats WHERE marking_period_id=mp_id AND student_id=s_id) THEN
     UPDATE student_mp_stats
     SET
       sum_weighted_factors=@sum_weighted_factors,
       count_weighted_factors=@count_weighted_factors,
       sum_unweighted_factors=@sum_unweighted_factors,
       count_unweighted_factors=@count_unweighted_factors
     WHERE marking_period_id=mp_id AND student_id=s_id;
   ELSE
     INSERT INTO student_mp_stats(student_id,marking_period_id,sum_weighted_factors,count_weighted_factors,
         sum_unweighted_factors,count_unweighted_factors,grade_level_short)
       VALUES(s_id,mp_id,@sum_weighted_factors,@count_weighted_factors,@sum_unweighted_factors,
         @count_unweighted_factors,@grade_level_short);
   END IF;
 
   UPDATE student_mp_stats g
     INNER JOIN (
 	SELECT s.student_id,
 		SUM(s.weighted_gp/sc.reporting_gp_scale)/COUNT(*) AS cum_weighted_factor,
 		SUM(s.unweighted_gp/s.gp_scale)/COUNT(*) AS cum_unweighted_factor
 	FROM student_report_card_grades s
 	INNER JOIN schools sc ON sc.id=s.school_id
 	LEFT JOIN course_periods p ON p.course_period_id=s.course_period_id
 	WHERE p.marking_period_id IS NULL OR p.marking_period_id=s.marking_period_id
 	GROUP BY student_id) gg ON gg.student_id=g.student_id
     SET g.cum_unweighted_factor=gg.cum_unweighted_factor, g.cum_weighted_factor=gg.cum_weighted_factor
     WHERE g.student_id=s_id;
 
 
 IF EXISTS(SELECT student_id FROM student_gpa_calculated WHERE marking_period_id=mp_id AND student_id=s_id) THEN
     UPDATE student_gpa_calculated
     SET
       gpa            = @gpa,
       weighted_gpa   =@weighted_gpa,
       unweighted_gpa =@unweighted_gpa
 
     WHERE marking_period_id=mp_id AND student_id=s_id;
   ELSE
         INSERT INTO student_gpa_calculated(student_id,marking_period_id,mp,gpa,weighted_gpa,unweighted_gpa,grade_level_short)
             VALUES(s_id,mp_id,mp_id,@gpa,@weighted_gpa,@unweighted_gpa,@grade_level_short  );
                    
 
    END IF;
 
   RETURN 0;
 END$$

CREATE FUNCTION `CREDIT`(
  	cp_id int,
  	mp_id int
  ) RETURNS decimal(10,3)
BEGIN
   SELECT credits,marking_period_id,mp INTO @credits,@marking_period_id,@mp FROM course_periods WHERE course_period_id=cp_id;
   SELECT mp_type INTO @mp_type FROM marking_periods WHERE marking_period_id=mp_id;
  
   IF @marking_period_id=mp_id THEN
     RETURN @credits;
 ELSEIF @mp = 'QTR' AND @mp_type = 'semester' THEN
      RETURN @credits;
    ELSEIF @mp='FY' AND @mp_type='semester' THEN
      SELECT COUNT(*) INTO @val FROM marking_periods WHERE parent_id=@marking_period_id GROUP BY parent_id;
    ELSEIF @mp = 'FY' AND @mp_type = 'quarter' THEN
      SELECT count(*) into @val FROM marking_periods WHERE grandparent_id=@marking_period_id GROUP BY grandparent_id;
    ELSEIF @mp = 'SEM' AND @mp_type = 'quarter' THEN
      SELECT count(*) into @val FROM marking_periods WHERE parent_id=@marking_period_id GROUP BY parent_id;
    ELSE
      RETURN 0;
    END IF;
    IF @val > 0 THEN
      RETURN @credits/@val;
    END IF;
    RETURN 0;
 END$$

CREATE FUNCTION `fn_marking_period_seq`() RETURNS int(11)
BEGIN
   INSERT INTO marking_period_id_generator VALUES(NULL);
 RETURN LAST_INSERT_ID();
 END$$

CREATE FUNCTION `SET_CLASS_RANK_MP`(
	mp_id int
) RETURNS int(11)
BEGIN

DECLARE done INT DEFAULT 0;
DECLARE marking_period_id INT;
DECLARE student_id INT;
DECLARE rank NUMERIC;

declare cur1 cursor for
select
  mp.marking_period_id,
  sgc.student_id,
 (select count(*)+1 
   from student_gpa_calculated sgc3
   where sgc3.gpa > sgc.gpa
     and sgc3.marking_period_id = mp.marking_period_id 
     and sgc3.student_id in (select distinct sgc2.student_id 
                                                from student_gpa_calculated sgc2, student_enrollment se2
                                                where sgc2.student_id = se2.student_id 
                                                and sgc2.marking_period_id = mp.marking_period_id 
                                                and se2.grade_id = se.grade_id
                                                and se2.syear = se.syear
                                                group by gpa
                                )
  ) as rank
  from student_enrollment se, student_gpa_calculated sgc, marking_periods mp
  where se.student_id = sgc.student_id
    and sgc.marking_period_id = mp.marking_period_id
    and mp.marking_period_id = mp_id
    and se.syear = mp.syear
    and not sgc.gpa is null
  order by grade_id, rank;
DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = 1;

open cur1;
fetch cur1 into marking_period_id,student_id,rank;

while not done DO
	update student_gpa_calculated sgc
	  set
	    class_rank = rank
	where sgc.marking_period_id = marking_period_id
	  and sgc.student_id = student_id;
	fetch cur1 into marking_period_id,student_id,rank;
END WHILE;
CLOSE cur1;

RETURN 1;
END$$

CREATE FUNCTION `STUDENT_DISABLE`(
 stu_id int
 ) RETURNS int(1)
BEGIN
 UPDATE students set is_disable ='Y' where (select end_date from student_enrollment where  student_id=stu_id ORDER BY id DESC LIMIT 1) IS NOT NULL AND (select end_date from student_enrollment where  student_id=stu_id ORDER BY id DESC LIMIT 1)< CURDATE() AND  student_id=stu_id;
 RETURN 1;
 END$$
DELIMITER ;
-- --------------------------------------------------------\n
";
echo "--
-- Triggers `STUDENT_REPORT_CARD_GRADES`
--
DROP TRIGGER IF EXISTS `ti_student_report_card_grades`;
DELIMITER //
CREATE TRIGGER `ti_student_report_card_grades` AFTER INSERT ON `student_report_card_grades`
 FOR EACH ROW SELECT CALC_GPA_MP(NEW.student_id, NEW.marking_period_id) INTO @return$$
//
DELIMITER ;
DROP TRIGGER IF EXISTS `tu_student_report_card_grades`;
DELIMITER //
CREATE TRIGGER `tu_student_report_card_grades` AFTER UPDATE ON `student_report_card_grades`
 FOR EACH ROW SELECT CALC_GPA_MP(NEW.student_id, NEW.marking_period_id) INTO @return$$
//
DELIMITER ;
DROP TRIGGER IF EXISTS `td_student_report_card_grades`;
DELIMITER //
CREATE TRIGGER `td_student_report_card_grades` AFTER DELETE ON `student_report_card_grades`
 FOR EACH ROW SELECT CALC_GPA_MP(OLD.student_id, OLD.marking_period_id) INTO @return$$
//
DELIMITER ;

DROP TRIGGER IF EXISTS `tu_cp_missing_attendance`;
CREATE TRIGGER `tu_cp_missing_attendance`
    AFTER UPDATE ON course_periods
    FOR EACH ROW
	CALL ATTENDANCE_CALC(NEW.course_period_id, NEW.syear,NEW.school_id);

DROP TRIGGER IF EXISTS `td_cp_missing_attendance`;
CREATE TRIGGER `td_cp_missing_attendance`
    AFTER DELETE ON course_periods
    FOR EACH ROW
	CALL ATTENDANCE_CALC(OLD.course_period_id, OLD.syear,OLD.school_id);


DROP TRIGGER IF EXISTS `ti_sch_missing_attendance`;
DELIMITER $$
CREATE TRIGGER `ti_sch_missing_attendance`
    AFTER INSERT ON `schedule`
    FOR EACH ROW
    BEGIN
    DECLARE schedule_id INT;
    SET schedule_id = (SELECT COUNT(id) FROM `schedule` WHERE course_period_id=NEW.course_period_id AND start_date=NEW.start_date AND end_date IS NULL);
    IF schedule_id<2 THEN
	CALL ATTENDANCE_CALC(NEW.course_period_id, NEW.syear,NEW.school_id);
    END IF;
    END$$
DELIMITER ;

DROP TRIGGER IF EXISTS `tu_sch_missing_attendance`;
CREATE TRIGGER `tu_sch_missing_attendance`
    AFTER UPDATE ON schedule
    FOR EACH ROW
	CALL ATTENDANCE_CALC(NEW.course_period_id, NEW.syear,NEW.school_id);

DROP TRIGGER IF EXISTS `td_sch_missing_attendance`;
CREATE TRIGGER `td_sch_missing_attendance`
    AFTER DELETE ON schedule
    FOR EACH ROW
	CALL ATTENDANCE_CALC(OLD.course_period_id, OLD.syear,OLD.school_id);



DROP TRIGGER IF EXISTS `ti_cal_missing_attendance`;
CREATE TRIGGER `ti_cal_missing_attendance`
    AFTER INSERT ON attendance_calendar
    FOR EACH ROW
	CALL ATTENDANCE_CALC_BY_DATE(NEW.school_date, NEW.syear,NEW.school_id);

DROP TRIGGER IF EXISTS `td_cal_missing_attendance`;
CREATE TRIGGER `td_cal_missing_attendance`
    AFTER DELETE ON attendance_calendar
    FOR EACH ROW
	DELETE mi.* FROM missing_attendance mi,course_periods cp WHERE mi.course_period_id=cp.course_period_id and cp.calendar_id=OLD.calendar_id AND mi.SCHOOL_DATE=OLD.school_date;

-- --------------------------------------------------------";
        }
	else
	{
		echo "/* no tables in $mysql_database \n";
	}
	mysql_free_result($result);
}

function _mysqldump_table_structure($table)
{
	echo "--\n";
        echo "-- Table structure for table `$table` \n";
        echo "--\n\n";

       // echo "/* Table structure for table `$table` \n";
	/*if( isset($_REQUEST['sql_drop_table']))
	{
		echo "DROP TABLE IF EXISTS `$table`;\n\n";
	}*/
	         $sql="show create table `$table`; ";
		$result=mysql_query($sql);
		if( $result)
		{
			if($row= mysql_fetch_assoc($result))
			{
				echo $row['Create Table'].";\n\n";
			}
		}
		mysql_free_result($result);

}

function _mysqldump_table_data($table)
{
	$sql='select * from `'.$table.'`;';
	$result=mysql_query($sql);
	if( $result)
	{
		$num_rows= mysql_num_rows($result);
		$num_fields= mysql_num_fields($result);
                $numfields = mysql_num_fields($result);

		if( $num_rows> 0)
		{
			//echo "/* dumping data for table `$table` \n";

                        echo "--\n";
                        echo "-- Dumping data for table  `$table` \n";
                        echo "--\n";

			$field_type=array();
			$i=0;
			while( $i <$num_fields)
			{
				$meta= mysql_fetch_field($result, $i);
				array_push($field_type, $meta->type);
                                $colfields[] = mysql_field_name($result,$i);
				$i++;
			}
			//print_r( $field_type);
			echo 'insert into `'.$table.'` (';
                        for($j=0; $j < $num_fields; $j++)
                        {
                            if($j==$num_fields-1)
                            echo $colfields[$j];
                        else
                        echo $colfields[$j].',';
                        }
                        echo ")values\n";
			$index=0;
			while( $row= mysql_fetch_row($result))
			{
				echo '(';
				for( $i=0; $i <$num_fields; $i++)
				{
					if( is_null( $row[$i]))
						echo 'null';
					else
					{
						switch( $field_type[$i])
						{
							case 'int':
								echo $row[$i];
								break;
							case 'string':
							case 'blob' :
							default:
								echo "'".mysql_real_escape_string($row[$i])."'";
						}
					}
					if( $i <$num_fields-1)
						echo ',';
				}
				echo ')';
				if( $index <$num_rows-1)
					echo ',';
				else
					echo ";";
				echo "\n";
				$index++;
			}
		}
	}
	mysql_free_result($result);
	echo "\n";
}
function _mysql_test($mysql_host,$mysql_database, $mysql_username, $mysql_password)
{
	global $output_messages;
	$link = mysql_connect($mysql_host, $mysql_username, $mysql_password);
	if (!$link)
	{
	   array_push($output_messages, 'Could not connect: ' . mysql_error());
	}
	else
	{
		array_push ($output_messages,"Connected with MySQL server:$mysql_username@$mysql_host successfully");
		$db_selected = mysql_select_db($mysql_database, $link);
		if (!$db_selected)
		{
			array_push ($output_messages,'Can\'t use $mysql_database : ' . mysql_error());
		}
		else
			array_push ($output_messages,"Connected with MySQL database:$mysql_database successfully");
	}
}
if( $print_form>0  && !$_REQUEST['modfunc']=='cancel')
{
?>
<br>
<?php
PopTable('header', 'Synchronize');
?>
<form id="dataForm" name="dataForm" method="post" action="for_export.php?modname=Tools/Synchronize.php&action=Synchronize&_openSIS_PDF=true" target=_blank>
<table border=0 width=450px><tr><td>

<?php echo "<font color=red><strong>Note:</strong></font> This Synchronize utility will synchronize the database  And Files between Local and Remote Host." ?>
            <br><br>       <center>
<input type="submit" name="action"  value="Synchronize" class=btn_large>&nbsp;&nbsp;
<?php
#<input type="submit" name="cancel"  value="Cancel" class=btn_medium></center>
    $modname = 'Tools/Synchronize.php';
echo '<a href=Modules.php?modname='.$modname.'&modfunc=cancel STYLE="TEXT-DECORATION: NONE"> <INPUT type=button class=btn_medium name=Cancel value=Cancel></a>';
?>
</td></tr></table>
</form>

<?php
PopTable('footer');

}
?>