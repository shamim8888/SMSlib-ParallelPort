<?php

if($_REQUEST['day_start'] && $_REQUEST['month_start'] && $_REQUEST['year_start'])
	while(!VerifyDate($start_date = $_REQUEST['day_start'].'-'.$_REQUEST['month_start'].'-'.$_REQUEST['year_start']))
		$_REQUEST['day_start']--;
else
{
	$_REQUEST['day_start'] = '01';
	$_REQUEST['month_start'] = strtoupper(date('M'));
	$_REQUEST['year_start'] = date('y');
	$start_date = $_REQUEST['day_start'].'-'.$_REQUEST['month_start'].'-'.$_REQUEST['year_start'];
}

if($_REQUEST['day_end'] && $_REQUEST['month_end'] && $_REQUEST['year_end'])
	while(!VerifyDate($end_date = $_REQUEST['day_end'].'-'.$_REQUEST['month_end'].'-'.$_REQUEST['year_end']))
		$_REQUEST['day_end']--;
else
{
	$_REQUEST['day_end'] = date('d');
	$_REQUEST['month_end'] = strtoupper(date('M'));
	$_REQUEST['year_end'] = date('y');
	$end_date = $_REQUEST['day_end'].'-'.$_REQUEST['month_end'].'-'.$_REQUEST['year_end'];
}
//DrawHeader(ProgramTitle());
DrawBC("Food Service >> ".ProgramTitle());

$types = array('Student'=>array('DEPOSIT'=>array('CASH'=>0,'CHECK'=>0,'CREDIT CARD'=>0,'DEBIT CARD'=>0,'TRANSFER'=>0,''=>0),
				'CREDIT'=>array('CASH'=>0,'CHECK'=>0,'CREDIT CARD'=>0,'DEBIT CARD'=>0,'TRANSFER'=>0,''=>0),
				'DEBIT'=>array('CASH'=>0,'CHECK'=>0,'CREDIT CARD'=>0,'DEBIT CARD'=>0,'TRANSFER'=>0,''=>0)
				),
	       'User'=>array('DEPOSIT'=>array('CASH'=>0,'CHECK'=>0,'CREDIT CARD'=>0,'DEBIT CARD'=>0,'TRANSFER'=>0,''=>0),
			     'CREDIT'=>array('CASH'=>0,'CHECK'=>0,'CREDIT CARD'=>0,'DEBIT CARD'=>0,'TRANSFER'=>0,''=>0),
			     'DEBIT'=>array('CASH'=>0,'CHECK'=>0,'CREDIT CARD'=>0,'DEBIT CARD'=>0,'TRANSFER'=>0,''=>0)
			     )
	       );

$types_totals = array('Student'=>array('CASH'=>0,'CHECK'=>0,'CREDIT CARD'=>0,'DEBIT CARD'=>0,'TRANSFER'=>0,''=>0),
		      'User'=>array('CASH'=>0,'CHECK'=>0,'CREDIT CARD'=>0,'DEBIT CARD'=>0,'TRANSFER'=>0,''=>0),
		      ''=>array('CASH'=>0,'CHECK'=>0,'CREDIT CARD'=>0,'DEBIT CARD'=>0,'TRANSFER'=>0,''=>0)
		      );

$types_rows = array('DEPOSIT'=>'Deposit','CREDIT'=>'Credit','DEBIT'=>'Debit');
$types_columns = array('CASH'=>'Cash','CHECK'=>'Check','CREDIT CARD'=>'Credit Card','DEBIT CARD'=>'Debit Card','TRANSFER'=>'Transfer',''=>'n/s');

$PHP_tmp_SELF = PreparePHP_SELF();
echo "<FORM action=$PHP_tmp_SELF method=POST>";
DrawHeader(PrepareDate($start_date,'_start').' - '.PrepareDate($end_date,'_end').' : <INPUT type=submit value=Go>');
echo '</FORM>';
$RET = DBGet(DBQuery("SELECT 'Student' AS TYPE,fst.SHORT_NAME,fsti.SHORT_NAME AS ITEM_SHORT_NAME,sum(fsti.AMOUNT) AS AMOUNT FROM       FOOD_SERVICE_TRANSACTION_ITEMS fsti,      FOOD_SERVICE_TRANSACTIONS fst WHERE fst.SHORT_NAME NOT IN (SELECT TITLE FROM FOOD_SERVICE_MENUS WHERE SCHOOL_ID='".UserSchool()."') AND fsti.TRANSACTION_ID=fst.TRANSACTION_ID AND fst.SYEAR='".UserSyear()."' AND fst.SCHOOL_ID='".UserSchool()."' AND fst.TIMESTAMP BETWEEN '".date('Y-m-d',strtotime($start_date))."' AND '".date('Y-m-d',strtotime($end_date))."' + INTERVAL 1 DAY GROUP BY fst.SHORT_NAME,fsti.SHORT_NAME"),array('ITEM_SHORT_NAME'=>'bump_amount'));
//echo '<pre>'; var_dump($RET); echo '</pre>';
$RET = DBGet(DBQuery("SELECT 'User' AS TYPE,fst.SHORT_NAME,fsti.SHORT_NAME AS ITEM_SHORT_NAME,sum(fsti.AMOUNT) AS AMOUNT FROM FOOD_SERVICE_STAFF_TRANSACTION_ITEMS fsti,FOOD_SERVICE_STAFF_TRANSACTIONS fst WHERE fst.SHORT_NAME NOT IN (SELECT TITLE FROM FOOD_SERVICE_MENUS WHERE SCHOOL_ID='".UserSchool()."') AND fsti.TRANSACTION_ID=fst.TRANSACTION_ID AND fst.SYEAR='".UserSyear()."' AND fst.SCHOOL_ID='".UserSchool()."' AND fst.TIMESTAMP BETWEEN '".date('Y-m-d',strtotime($start_date))."' AND '".date('Y-m-d',strtotime($end_date))."' + INTERVAL 1 DAY GROUP BY fst.SHORT_NAME,fsti.SHORT_NAME"),array('ITEM_SHORT_NAME'=>'bump_amount'));
//echo '<pre>'; var_dump($RET); echo '</pre>';

$LO_types = array(0=>array());
foreach($types as $user=>$trans)
{
	$TMP_types = array(0=>array());
	foreach($trans as $tran=>$value)
	{
		//echo '<pre>'; var_dump($value); echo '</pre>';
		$total = array_sum($value);
		if($total!=0)
		{
			$TMP_types[] = array('TYPE'=>$user,'TRANSACTION'=>$types_rows[$tran],'TOTAL'=>'<b>'.number_format($total,2).'</b>') + array_map('format',$value);
		}
	}
	$total = array_sum($types_totals[$user]);
	$TMP_types[] = array('TYPE'=>'<b>'.$user.'</b>','TRANSACTION'=>'<b>Totals</b>','TOTAL'=>'<b>'.number_format($total,2).'</b>') + array_map('bold_format',$types_totals[$user]);
	unset($TMP_types[0]);
	$LO_types[] = $TMP_types;
}
$total = array_sum($types_totals['']);
bold_format($total);
foreach($types_totals[''] as $key=>$value)
	if($value == 0)
		unset($types_columns[$key]);
$LO_types[] = array(array('TYPE'=>'<b>Totals</b>','TOTAL'=>'<b>'.number_format($total,2).'</b>') + array_map('bold_format',$types_totals['']));
unset($LO_types[0]);
$LO_columns = array('TYPE'=>'Type','TRANSACTION'=>'Transaction') + $types_columns + array('TOTAL'=>'Total');

ListOutput($LO_types,$LO_columns,'Type','Types',false,array(array()),array('save'=>false,'search'=>false,'print'=>false));

function format($item)
{
	return number_format($item,2);
}

function bold($item)
{
	return'<b>'.$item.'</b>';
}

function bold_format($item)
{
	return '<b>'.number_format($item,2).'</b>';
}

function bump_amount($value,$column)
{	global $THIS_RET,$types,$types_rows,$types_columns,$types_totals;

	if($types[$THIS_RET['TYPE']][$THIS_RET['SHORT_NAME']])
		$types[$THIS_RET['TYPE']][$THIS_RET['SHORT_NAME']][$value] +=  $THIS_RET['AMOUNT'];
	else
	{
		$types[$THIS_RET['TYPE']] += array($THIS_RET['SHORT_NAME']=>array($value=>$THIS_RET['AMOUNT']));
		$types_rows[$THIS_RET['SHORT_NAME']] = $THIS_RET['SHORT_NAME'];
	}
	if(!$types_columns[$value])
	{
		$types_columns += array($value=>$value);
		$types_totals['Student'][$value] = 0;
		$types_totals['User'][$value] = 0;
		$types_totals[$THIS_RET['TYPE']][$value] = 0;
		$types_totals[''][$value] = 0;
	}
	$types_totals[$THIS_RET['TYPE']][$value] += $THIS_RET['AMOUNT'];
	$types_totals[''][$value] += $THIS_RET['AMOUNT'];

	return $value;
}
?>
