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

$menu['Billing']['admin'] = array(
						'Billing/StudentFees.php'=>'Fees',
						'Billing/StudentPayments.php'=>'Payments',
						'Billing/MassAssignFees.php'=>'Mass Assign Fees',
						'Billing/MassAssignPayments.php'=>'Mass Assign Payments',
						1=>'Reports',
						'Billing/StudentBalances.php'=>'Student Balances',
						'Billing/DailyTransactions.php'=>'Daily Transactions',
						'Billing/Statements.php'=>'Print Statements'
					);

$menu['Billing']['parent'] = array(
						'Billing/StudentFees.php'=>'Fees',
						'Billing/StudentPayments.php'=>'Payments',
						1=>'Reports',
						'Billing/DailyTransactions.php'=>'Daily Transactions',
						'Billing/Statements.php'=>'Print Statements'
					);

$menu['Billing']['student'] = array(
						'Billing/StudentFees.php'=>'Fees',
						'Billing/StudentPayments.php'=>'Payments',
						1=>'Reports',
						'Billing/DailyTransactions.php'=>'Daily Transactions',
						'Billing/Statements.php'=>'Print Statements'
					);


$exceptions['Billing'] = array(
					);
?>