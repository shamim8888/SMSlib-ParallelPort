<?php

Widgets('fsa_status');
Widgets('fsa_barcode');

Search('student_id',$extra);

if ($_REQUEST['modfunc']=='submit')
{
	if ($_REQUEST['submit']['cancel'])
	{
		if (DeletePromptX('Sale','Cancel'))
			unset($_SESSION['FSA_sale']);
	}
	elseif ($_REQUEST['submit']['save'])
	{
		if(count($_SESSION['FSA_sale']))
		{
			$student = DBGet(DBQuery("SELECT ACCOUNT_ID,DISCOUNT FROM FOOD_SERVICE_STUDENT_ACCOUNTS WHERE STUDENT_ID='".UserStudentID()."'"));
			$student = $student[1];

			$items_RET = DBGet(DBQuery("SELECT DESCRIPTION,SHORT_NAME,PRICE,PRICE_REDUCED,PRICE_FREE FROM FOOD_SERVICE_ITEMS WHERE SCHOOL_ID='".UserSchool()."'"),array(),array('SHORT_NAME'));

			// get next transaction id
			$id = DBGet(DBQuery("SELECT ".db_seq_nextval('FOOD_SERVICE_TRANSACTIONS_SEQ')." AS SEQ_ID ".FROM_DUAL));
			$id = $id[1]['SEQ_ID'];

			$item_id = 0;
			foreach($_SESSION['FSA_sale'] as $item_sn)
			{
				// determine price based on discount
				$price = $items_RET[$item_sn][1]['PRICE'];
				$discount = $student['DISCOUNT'];
				if($student['DISCOUNT']=='Reduced')
					if($items_RET[$item_sn][1]['PRICE_REDUCED']!='')
						$price = $items_RET[$item_sn][1]['PRICE_REDUCED'];
					else
						$discount = '';
				elseif($student['DISCOUNT']=='Free')
					if($items_RET[$item_sn][1]['PRICE_FREE']!='')
						$price = $items_RET[$item_sn][1]['PRICE_FREE'];
					else
						$discount = '';

				$fields = 'ITEM_ID,TRANSACTION_ID,AMOUNT,DISCOUNT,SHORT_NAME,DESCRIPTION';
				$values = "'".$item_id++."','".$id."','-".$price."','".$discount."','".$items_RET[$item_sn][1]['SHORT_NAME']."','".$items_RET[$item_sn][1]['DESCRIPTION']."'";
				$sql = "INSERT INTO FOOD_SERVICE_TRANSACTION_ITEMS (".$fields.") values (".$values.")";
				DBQuery($sql);
			}

			$sql1 = "UPDATE FOOD_SERVICE_ACCOUNTS SET TRANSACTION_ID='".$id."',BALANCE=BALANCE+(SELECT sum(AMOUNT) FROM FOOD_SERVICE_TRANSACTION_ITEMS WHERE TRANSACTION_ID='".$id."') WHERE ACCOUNT_ID='".$student['ACCOUNT_ID']."'";
			$fields = 'TRANSACTION_ID,ACCOUNT_ID,STUDENT_ID,SYEAR,SCHOOL_ID,DISCOUNT,BALANCE,TIMESTAMP,SHORT_NAME,DESCRIPTION,SELLER_ID';
			$values = "'".$id."','".$student['ACCOUNT_ID']."','".UserStudentID()."','".UserSyear()."','".UserSchool()."','".$discount."',(SELECT BALANCE FROM FOOD_SERVICE_ACCOUNTS WHERE ACCOUNT_ID='".$student['ACCOUNT_ID']."'),CURRENT_TIMESTAMP,'".$menus_RET[$_REQUEST['menu_id']][1]['TITLE']."','".$menus_RET[$_REQUEST['menu_id']][1]['TITLE'].' - '.DBDate()."','".User('STAFF_ID')."'";
			$sql2 = "INSERT INTO FOOD_SERVICE_TRANSACTIONS (".$fields.") values (".$values.")";
			DBQuery('BEGIN; '.$sql1.'; '.$sql2.'; COMMIT');

			unset($_SESSION['FSA_sale']);
		}
		unset($_REQUEST['modfunc']);
	}
	else
		unset($_REQUEST['modfunc']);
	unset($_REQUEST['submit']);
}

if(UserStudentID() && !$_REQUEST['modfunc'])
{
	$student = DBGet(DBQuery("SELECT s.STUDENT_ID,CONCAT(".(Preferences('NAME')=='Common'?'coalesce(s.CUSTOM_200000002,s.FIRST_NAME)':'s.FIRST_NAME').",' ',s.LAST_NAME) AS FULL_NAME,fsa.ACCOUNT_ID,fsa.STATUS,fsa.DISCOUNT,fsa.BARCODE,(SELECT BALANCE FROM FOOD_SERVICE_ACCOUNTS WHERE ACCOUNT_ID=fsa.ACCOUNT_ID) AS BALANCE FROM STUDENTS s,FOOD_SERVICE_STUDENT_ACCOUNTS fsa WHERE s.STUDENT_ID='".UserStudentID()."' AND fsa.STUDENT_ID=s.STUDENT_ID"));
	$student = $student[1];

	echo "<FORM action=Modules.php?modname=$_REQUEST[modname]&modfunc=submit&menu_id=$_REQUEST[menu_id] method=POST>";
	DrawHeader('',SubmitButton('Cancel Sale','submit[cancel]').SubmitButton('Complete Sale','submit[save]'));
	echo '</FORM>';

	echo '<TABLE width=100%><TR>';

	echo '<TD valign=top>'.NoInput($student['FULL_NAME'],$student['STUDENT_ID']).'</TD>';
	echo '<TD valign=top>'.NoInput(red($student['BALANCE']),'Balance').'</TD>';

	echo '</TR></TABLE>';
	echo '<HR>';

	if ($student['BALANCE'])
	{
		echo '<TABLE border=0 width=100%>';
		echo '<TR><TD width=100% valign=top>';

		$RET = DBGet(DBQuery('SELECT fsti.DESCRIPTION,fsti.AMOUNT FROM FOOD_SERVICE_TRANSACTIONS fst,FOOD_SERVICE_TRANSACTION_ITEMS fsti WHERE fst.ACCOUNT_ID='.$student['ACCOUNT_ID'].' AND fst.STUDENT_ID='.UserStudentID().' AND fst.SYEAR='.UserSyear().' AND fst.SHORT_NAME=\''.$menus_RET[$_REQUEST['menu_id']][1]['TITLE'].'\' AND fst.TIMESTAMP BETWEEN CURRENT_DATE AND \'tomorrow\' AND fsti.TRANSACTION_ID=fst.TRANSACTION_ID'));

		$columns = array('DESCRIPTION'=>'Item','AMOUNT'=>'Amount');
		ListOutput($RET,$columns,'Earlier '.$menus_RET[$_REQUEST['menu_id']][1]['TITLE'].' Sale','Earlier '.$menus_RET[$_REQUEST['menu_id']][1]['TITLE'].' Sales',$link,false,array('save'=>false,'search'=>false));

		// IMAGE
		if($file = @fopen($picture=$StudentPicturesPath.'/'.UserSyear().'/'.UserStudentID().'.jpg','r') || $file = @fopen($picture=$StudentPicturesPath.'/'.(UserSyear()-1).'/'.UserStudentID().'.jpg','r'))
		{
			fclose($file);
			echo '<TD rowspan=2 width=150 align=left><IMG SRC="'.$picture.'" width=150></TD>';
		}

		echo '</TD></TR>';
		echo '<TR><TD width=100% valign=top>';

		$items_RET = DBGet(DBQuery("SELECT fsi.SHORT_NAME,fsi.DESCRIPTION,fsi.PRICE,fsi.PRICE_REDUCED,fsi.PRICE_FREE,fsi.ICON FROM FOOD_SERVICE_ITEMS fsi,FOOD_SERVICE_MENU_ITEMS fsmi WHERE fsmi.MENU_ID='".$_REQUEST['menu_id']."' AND fsi.ITEM_ID=fsmi.ITEM_ID AND fsmi.CATEGORY_ID IS NOT NULL AND fsi.SCHOOL_ID='".UserSchool()."' ORDER BY fsi.SORT_ORDER"),array('ICON'=>'makeIcon'),array('SHORT_NAME'));
		$items = array();
		foreach($items_RET as $sn=>$item)
			$items += array($sn=>$item[1]['DESCRIPTION']);

		$LO_ret = array(array());
		foreach($_SESSION['FSA_sale'] as $id=>$item_sn)
		{
			// determine price based on discount
			$price = $items_RET[$item_sn][1]['PRICE'];
			if($student['DISCOUNT']=='Reduced')
			{
				if($items_RET[$item_sn][1]['PRICE_REDUCED']!='')
					$price = $items_RET[$item_sn][1]['PRICE_REDUCED'];
			}
			elseif($student['DISCOUNT']=='Free')
				if($items_RET[$item_sn][1]['PRICE_FREE']!='')
					$price = $items_RET[$item_sn][1]['PRICE_FREE'];
			$LO_ret[] = array('SALE_ID'=>$id,'PRICE'=>$price,'DESCRIPTION'=>$items_RET[$item_sn][1]['DESCRIPTION'],'ICON'=>$items_RET[$item_sn][1]['ICON']);
		}
		unset($LO_ret[0]);

		$link['remove'] = array('link'=>"Modules.php?modname=$_REQUEST[modname]&modfunc=remove&menu_id=$_REQUEST[menu_id]",
					'variables'=>array('id'=>'SALE_ID'));
		$link['add']['html'] = array('DESCRIPTION'=>'<TABLE border=0 cellpadding=0 cellspacing=0><TR><TD>'.SelectInput('','item_sn','',$items).'</TD></TR></TABLE>',
					     'ICON'=>'<TABLE border=0 cellpadding=0 cellspacing=0><TR><TD><INPUT type=submit value=Add></TD></TR></TABLE>',
					     'remove'=>button('add'));
		$columns = array('DESCRIPTION'=>'Item','ICON'=>'Icon','PRICE'=>'Price');

		$tabs = array();
		foreach($menus_RET as $id=>$menu)
			$tabs[] = array('title'=>$menu[1]['TITLE'],'link'=>"Modules.php?modname=$_REQUEST[modname]&menu_id=$id");

		$extra = array('save'=>false,'search'=>false,
			'header'=>WrapTabs($tabs,"Modules.php?modname=$_REQUEST[modname]&menu_id=$_REQUEST[menu_id]"));

		echo '<BR>';
		echo "\n";
		echo "<FORM action=Modules.php?modname=$_REQUEST[modname]&modfunc=add&menu_id=$_REQUEST[menu_id] method=POST>";
		ListOutput($LO_ret,$columns,'Item','Items',$link,array(),$extra);
		echo '</FORM>';

		echo '</TD></TR></TABLE>';
	}
	else
		ErrorMessage(array('This student does not have a valid Meal Account.'),'fatal');
}
?>
