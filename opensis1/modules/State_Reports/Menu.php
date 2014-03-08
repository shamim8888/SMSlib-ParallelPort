<?php
/**
* @file $Id: Menu.php 252 2006-10-19 18:46:09Z focus-sis $
* @package Focus/SIS
* @copyright Copyright (C) 2006 Andrew Schmadeke. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.txt
* Focus/SIS is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.txt for copyright notices and details.
*/

if(User('PROFILE')=='admin')
{
	$menu_reports = DBGet(DBQuery("SELECT ID,TITLE FROM SAVED_REPORTS ORDER BY TITLE"));
	foreach($menu_reports as $report)
		$menu['State_Reports']['admin']['State_Reports/RunReport.php?id='.$report['ID']] = $report['TITLE'];

$menu['State_Reports']['admin']['State_Reports/Calculations.php'] = _('Calculations');
	$menu['State_Reports']['admin'][1] = _('Setup');
	$menu['State_Reports']['admin']['State_Reports/SavedReports.php'] = _('Saved Reports');
}
?>