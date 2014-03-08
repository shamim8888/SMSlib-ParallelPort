<?php
include('Redirect_root.php');
include('Warehouse.php');
include('ftp_sync.php');

//My Addition Shamim Ahmed Chowdhury

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

//End Of My Writing Shamim Ahmed Chowdhury



//$next_syear=$_SESSION['NY'];
//$table=$_REQUEST['table_name'];
//$next_start_date=$_SESSION['roll_start_date'];
//$tables = array('staff'=>'Users','school_periods'=>'School Periods','school_years'=>'Marking Periods','attendance_calendars'=>'Calendars','report_card_grade_scales'=>'Report Card Grade Codes','course_subjects'=>'Subjects','courses'=>'Courses','course_periods'=>'Course Periods','student_enrollment'=>'Students','honor_roll'=>'Honor Roll Setup','attendance_codes'=>'Attendance Codes','student_enrollment_codes'=>'Student Enrollment Codes','report_card_comments'=>'Report Card Comment Codes','NONE'=>'none');
//$no_school_tables = array('student_enrollment_codes'=>true,'staff'=>true);


//Added By Shamim Ahmed Chowdhury For Synchronization

/**
* Displays the page when 'Synchronize Databases' is pressed.
*/

if (isset($_REQUEST['synchronize_db'])) {
    
    
    //Added By Shamim Ahmed Chowdhury For File Synchronization
 
    if ((isset($_REQUEST['submit_connect']))) {
    
        $sync=new FTPSync($ftpServer,$ftpUsername,$ftpPassword,$maxConnections,$exclude_list);

        //This to display detailed information about the directories and files being uploaded - use for testing
        $sync->verbose=true;

        //start synchronization process
        if ((isset($_REQUEST['submit_connect']))) {
            $sync->syncRemoteDir('c:\assets','assets');

        }
        elseif ((isset($_REQUEST['submit_connect'])))
        {
            $sync->syncLocalDir('assets','c:\assets'); 
        }
        elseif ((isset($_REQUEST['submit_connect'])) && (isset($_REQUEST['submit_connect'])))
        {
            $sync->syncRemoteDir('c:\assets','assets');
            $sync->syncLocalDir('assets','c:\assets');
        }
    }
    //End Of File Synchronization
    

    //Start Database Synchronization
    if ((isset($_REQUEST['submit_connect']))) {
 
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
    if ((isset($_REQUEST['submit_connect']))) {
        PMA_syncDisplayHeaderSource($src_db);
    }
    elseif ((isset($_REQUEST['submit_connect']))) {
        PMA_syncDisplayHeaderSource($trg_db);
    }
    elseif ((isset($_REQUEST['submit_connect'])) && (isset($_REQUEST['submit_connect']))) {
        PMA_syncDisplayHeaderSource($src_db);
        PMA_syncDisplayHeaderSource($trg_db);
    }
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
        if ((isset($_REQUEST['submit_connect']))) {
            $odd_row = PMA_syncDisplayHeaderTargetAndMatchingTables($src_db, $matching_tables);
        }
        elseif ((isset($_REQUEST['submit_connect']))) {
            $odd_row = PMA_syncDisplayHeaderTargetAndMatchingTables($trg_db, $matching_tables);
        }
        elseif ((isset($_REQUEST['submit_connect'])) && (isset($_REQUEST['submit_connect']))) {
            $odd_row = PMA_syncDisplayHeaderTargetAndMatchingTables($src_db, $matching_tables);
            $odd_row = PMA_syncDisplayHeaderTargetAndMatchingTables($trg_db, $matching_tables);
        }
        
        
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
            
            if ((isset($_REQUEST['submit_connect']))) {
            PMA_findDeleteRowsFromTargetTables($delete_array, $matching_tables, $p, $target_tables_keys, $matching_tables_keys,
                $trg_db, $trg_link, $src_db, $src_link);
        }
        elseif ((isset($_REQUEST['submit_connect']))) {
            PMA_findDeleteRowsFromTargetTables($delete_array, $matching_tables, $p, $target_tables_keys, $matching_tables_keys,
                $trg_db, $trg_link, $src_db, $src_link);
        }
        elseif ((isset($_REQUEST['submit_connect'])) && (isset($_REQUEST['submit_connect']))) {
            PMA_findDeleteRowsFromTargetTables($delete_array, $matching_tables, $p, $target_tables_keys, $matching_tables_keys,
                $trg_db, $trg_link, $src_db, $src_link);
            PMA_findDeleteRowsFromTargetTables($delete_array, $matching_tables, $p, $target_tables_keys, $matching_tables_keys,
                $trg_db, $trg_link, $src_db, $src_link);
        }
            
            
             
            if (isset($delete_array[$p])) {
                
                if ((isset($_REQUEST['submit_connect']))) {
                    PMA_deleteFromTargetTable($trg_db, $trg_link, $matching_tables, $p, $target_tables_keys, $delete_array, true);          
                }
                elseif ((isset($_REQUEST['submit_connect']))) {
                    PMA_deleteFromTargetTable($trg_db, $trg_link, $matching_tables, $p, $target_tables_keys, $delete_array, true);          
                }
                elseif ((isset($_REQUEST['submit_connect'])) && (isset($_REQUEST['submit_connect']))) {
                    PMA_deleteFromTargetTable($trg_db, $trg_link, $matching_tables, $p, $target_tables_keys, $delete_array, true);          
                    PMA_deleteFromTargetTable($trg_db, $trg_link, $matching_tables, $p, $target_tables_keys, $delete_array, true);          
                }
                
                unset($delete_array[$p]); 
            }        
        }
        if (isset($alter_str_array[$p])) {
            
            if ((isset($_REQUEST['submit_connect']))) {
                    PMA_alterTargetTableStructure($trg_db, $trg_link, $matching_tables, $source_columns, $alter_str_array, $matching_tables_fields,
            $criteria, $matching_tables_keys, $target_tables_keys, $p, true);
                }
                elseif ((isset($_REQUEST['submit_connect']))) {
                    PMA_alterTargetTableStructure($trg_db, $trg_link, $matching_tables, $source_columns, $alter_str_array, $matching_tables_fields,
            $criteria, $matching_tables_keys, $target_tables_keys, $p, true);
                }
                elseif ((isset($_REQUEST['submit_connect'])) && (isset($_REQUEST['submit_connect']))) {
                    PMA_alterTargetTableStructure($trg_db, $trg_link, $matching_tables, $source_columns, $alter_str_array, $matching_tables_fields,
            $criteria, $matching_tables_keys, $target_tables_keys, $p, true);
                    PMA_alterTargetTableStructure($trg_db, $trg_link, $matching_tables, $source_columns, $alter_str_array, $matching_tables_fields,
            $criteria, $matching_tables_keys, $target_tables_keys, $p, true);
                }
            
            unset($alter_str_array[$p]);        
        }                                                           
        if (! empty($add_column_array[$p])) {
            
            if ((isset($_REQUEST['submit_connect']))) {
                    PMA_findDeleteRowsFromTargetTables($delete_array, $matching_tables, $p, $target_tables_keys, $matching_tables_keys,
            $trg_db, $trg_link, $src_db, $src_link);
                }
                elseif ((isset($_REQUEST['submit_connect']))) {
                    PMA_findDeleteRowsFromTargetTables($delete_array, $matching_tables, $p, $target_tables_keys, $matching_tables_keys,
            $trg_db, $trg_link, $src_db, $src_link);
                }
                elseif ((isset($_REQUEST['submit_connect'])) && (isset($_REQUEST['submit_connect']))) {
                    PMA_findDeleteRowsFromTargetTables($delete_array, $matching_tables, $p, $target_tables_keys, $matching_tables_keys,
            $trg_db, $trg_link, $src_db, $src_link);
                    PMA_findDeleteRowsFromTargetTables($delete_array, $matching_tables, $p, $target_tables_keys, $matching_tables_keys,
            $trg_db, $trg_link, $src_db, $src_link);
                }
            
             
            if (isset($delete_array[$p])) {
                if ((isset($_REQUEST['submit_connect']))) {
                    PMA_deleteFromTargetTable($trg_db, $trg_link, $matching_tables, $p, $target_tables_keys, $delete_array, true);
                unset($delete_array[$p]);
                }
                elseif ((isset($_REQUEST['submit_connect']))) {
                    PMA_deleteFromTargetTable($trg_db, $trg_link, $matching_tables, $p, $target_tables_keys, $delete_array, true);
                unset($delete_array[$p]);
                }
                elseif ((isset($_REQUEST['submit_connect'])) && (isset($_REQUEST['submit_connect']))) {
                    PMA_deleteFromTargetTable($trg_db, $trg_link, $matching_tables, $p, $target_tables_keys, $delete_array, true);
                unset($delete_array[$p]);
                    PMA_deleteFromTargetTable($trg_db, $trg_link, $matching_tables, $p, $target_tables_keys, $delete_array, true);
                unset($delete_array[$p]);
                }
                 
            }
            if ((isset($_REQUEST['submit_connect']))) {
                    PMA_addColumnsInTargetTable($src_db, $trg_db, $src_link, $trg_link, $matching_tables, $source_columns, $add_column_array,
                $matching_tables_fields, $criteria, $matching_tables_keys, $target_tables_keys, $uncommon_tables, $uncommon_tables_fields, 
                $p, $uncommon_cols, true);
                }
                elseif ((isset($_REQUEST['submit_connect']))) {
                    PMA_addColumnsInTargetTable($src_db, $trg_db, $src_link, $trg_link, $matching_tables, $source_columns, $add_column_array,
                $matching_tables_fields, $criteria, $matching_tables_keys, $target_tables_keys, $uncommon_tables, $uncommon_tables_fields, 
                $p, $uncommon_cols, true);
                }
                elseif ((isset($_REQUEST['submit_connect'])) && (isset($_REQUEST['submit_connect']))) {
                    PMA_addColumnsInTargetTable($src_db, $trg_db, $src_link, $trg_link, $matching_tables, $source_columns, $add_column_array,
                $matching_tables_fields, $criteria, $matching_tables_keys, $target_tables_keys, $uncommon_tables, $uncommon_tables_fields, 
                $p, $uncommon_cols, true);
                    PMA_addColumnsInTargetTable($src_db, $trg_db, $src_link, $trg_link, $matching_tables, $source_columns, $add_column_array,
                $matching_tables_fields, $criteria, $matching_tables_keys, $target_tables_keys, $uncommon_tables, $uncommon_tables_fields, 
                $p, $uncommon_cols, true);
                }
            
            unset($add_column_array[$p]);
        }
        if (isset($uncommon_columns[$p])) {
            if ((isset($_REQUEST['submit_connect']))) {
                    PMA_removeColumnsFromTargetTable($trg_db, $trg_link, $matching_tables, $uncommon_columns, $p, true);
                }
                elseif ((isset($_REQUEST['submit_connect']))) {
                    PMA_removeColumnsFromTargetTable($trg_db, $trg_link, $matching_tables, $uncommon_columns, $p, true);
                }
                elseif ((isset($_REQUEST['submit_connect'])) && (isset($_REQUEST['submit_connect']))) {
                    PMA_removeColumnsFromTargetTable($trg_db, $trg_link, $matching_tables, $uncommon_columns, $p, true);
                    PMA_removeColumnsFromTargetTable($trg_db, $trg_link, $matching_tables, $uncommon_columns, $p, true);
                }
            
            unset($uncommon_columns[$p]); 
        }           
        if (isset($matching_table_structure_diff) && 
            (isset($add_indexes_array[$matching_table_structure_diff[$p]]) 
            || isset($remove_indexes_array[$matching_table_structure_diff[$p]]) 
            || isset($alter_indexes_array[$matching_table_structure_diff[$p]]))) {
            if ((isset($_REQUEST['submit_connect']))) {
                    PMA_applyIndexesDiff ($trg_db, $trg_link, $matching_tables, $source_indexes, $target_indexes, $add_indexes_array, $alter_indexes_array, 
            $remove_indexes_array, $matching_table_structure_diff[$p], true);
                }
                elseif ((isset($_REQUEST['submit_connect']))) {
                    PMA_applyIndexesDiff ($trg_db, $trg_link, $matching_tables, $source_indexes, $target_indexes, $add_indexes_array, $alter_indexes_array, 
            $remove_indexes_array, $matching_table_structure_diff[$p], true);
                }
                elseif ((isset($_REQUEST['submit_connect'])) && (isset($_REQUEST['submit_connect']))) {
                    PMA_applyIndexesDiff ($trg_db, $trg_link, $matching_tables, $source_indexes, $target_indexes, $add_indexes_array, $alter_indexes_array, 
            $remove_indexes_array, $matching_table_structure_diff[$p], true);
                    PMA_removeColumnsFromTargetTable($trg_db, $trg_link, $matching_tables, $uncommon_columns, $p, true);
                }
             
           
            unset($add_indexes_array[$matching_table_structure_diff[$p]]);
            unset($alter_indexes_array[$matching_table_structure_diff[$p]]);
            unset($remove_indexes_array[$matching_table_structure_diff[$p]]);
        }     
        
        if ((isset($_REQUEST['submit_connect']))) {
                    PMA_updateTargetTables($matching_tables, $update_array, $src_db, $trg_db, $trg_link, $p, $matching_tables_keys, true);
                }
                elseif ((isset($_REQUEST['submit_connect']))) {
                    PMA_updateTargetTables($matching_tables, $update_array, $src_db, $trg_db, $trg_link, $p, $matching_tables_keys, true);
                }
                elseif ((isset($_REQUEST['submit_connect'])) && (isset($_REQUEST['submit_connect']))) {
                    PMA_updateTargetTables($matching_tables, $update_array, $src_db, $trg_db, $trg_link, $p, $matching_tables_keys, true);
                    PMA_updateTargetTables($matching_tables, $update_array, $src_db, $trg_db, $trg_link, $p, $matching_tables_keys, true);
                }
        
        if ((isset($_REQUEST['submit_connect']))) {
                    PMA_insertIntoTargetTable($matching_tables, $src_db, $trg_db, $src_link, $trg_link , $matching_tables_fields, $insert_array, $p, 
            $matching_tables_keys, $matching_tables_keys, $source_columns, $add_column_array, $criteria, $target_tables_keys, $uncommon_tables, 
            $uncommon_tables_fields,$uncommon_cols, $alter_str_array,$source_indexes, $target_indexes, $add_indexes_array, 
            $alter_indexes_array, $delete_array, $update_array, true); 
                }
                elseif ((isset($_REQUEST['submit_connect']))) {
                    PMA_insertIntoTargetTable($matching_tables, $src_db, $trg_db, $src_link, $trg_link , $matching_tables_fields, $insert_array, $p, 
            $matching_tables_keys, $matching_tables_keys, $source_columns, $add_column_array, $criteria, $target_tables_keys, $uncommon_tables, 
            $uncommon_tables_fields,$uncommon_cols, $alter_str_array,$source_indexes, $target_indexes, $add_indexes_array, 
            $alter_indexes_array, $delete_array, $update_array, true); 
                }
                elseif ((isset($_REQUEST['submit_connect'])) && (isset($_REQUEST['submit_connect']))) {
                    PMA_insertIntoTargetTable($matching_tables, $src_db, $trg_db, $src_link, $trg_link , $matching_tables_fields, $insert_array, $p, 
            $matching_tables_keys, $matching_tables_keys, $source_columns, $add_column_array, $criteria, $target_tables_keys, $uncommon_tables, 
            $uncommon_tables_fields,$uncommon_cols, $alter_str_array,$source_indexes, $target_indexes, $add_indexes_array, 
            $alter_indexes_array, $delete_array, $update_array, true); 
                    PMA_insertIntoTargetTable($matching_tables, $src_db, $trg_db, $src_link, $trg_link , $matching_tables_fields, $insert_array, $p, 
            $matching_tables_keys, $matching_tables_keys, $source_columns, $add_column_array, $criteria, $target_tables_keys, $uncommon_tables, 
            $uncommon_tables_fields,$uncommon_cols, $alter_str_array,$source_indexes, $target_indexes, $add_indexes_array, 
            $alter_indexes_array, $delete_array, $update_array, true); 
                }
          
    }              
                                                                                                                    
    /**
    *  Creating and populating tables present in source but absent from target database.  
    */   
    for($q = 0; $q < sizeof($source_tables_uncommon); $q++) { 
        if (isset($uncommon_tables[$q])) {
            
            if ((isset($_REQUEST['submit_connect']))) {
                    PMA_createTargetTables($src_db, $trg_db, $src_link, $trg_link, $source_tables_uncommon, $q, $uncommon_tables_fields, true);
                }
                elseif ((isset($_REQUEST['submit_connect']))) {
                    PMA_createTargetTables($src_db, $trg_db, $src_link, $trg_link, $source_tables_uncommon, $q, $uncommon_tables_fields, true);
                }
                elseif ((isset($_REQUEST['submit_connect'])) && (isset($_REQUEST['submit_connect']))) {
                    PMA_createTargetTables($src_db, $trg_db, $src_link, $trg_link, $source_tables_uncommon, $q, $uncommon_tables_fields, true);
                    PMA_createTargetTables($src_db, $trg_db, $src_link, $trg_link, $source_tables_uncommon, $q, $uncommon_tables_fields, true);
                }
            
        }
        if (isset($row_count[$q])) {
            if ((isset($_REQUEST['submit_connect']))) {
                    PMA_populateTargetTables($src_db, $trg_db, $src_link, $trg_link, $source_tables_uncommon, $q, $uncommon_tables_fields, true);    
                }
                elseif ((isset($_REQUEST['submit_connect']))) {
                    PMA_populateTargetTables($src_db, $trg_db, $src_link, $trg_link, $source_tables_uncommon, $q, $uncommon_tables_fields, true);    
                }
                elseif ((isset($_REQUEST['submit_connect'])) && (isset($_REQUEST['submit_connect']))) {
                    PMA_populateTargetTables($src_db, $trg_db, $src_link, $trg_link, $source_tables_uncommon, $q, $uncommon_tables_fields, true);    
                    PMA_populateTargetTables($src_db, $trg_db, $src_link, $trg_link, $source_tables_uncommon, $q, $uncommon_tables_fields, true);    
                }
            
            
        }
    }
    echo "</div>";          
}

}










?>
