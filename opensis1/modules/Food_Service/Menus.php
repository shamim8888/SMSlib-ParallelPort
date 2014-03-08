<?php
require_once('modules/Food_Service/includes/DeletePromptX.fnc.php');

DrawHeader(ProgramTitle());

if($_REQUEST['modfunc']=='update')
{
	if($_REQUEST['values'] && $_POST['values'])
	{
		if($_REQUEST['tab_id'])
		{
			foreach($_REQUEST['values'] as $id=>$columns)
			{
				if($id!='new')
				{
					if($_REQUEST['tab_id']!='new')
						$sql = "UPDATE FOOD_SERVICE_CATEGORIES SET ";
					else
						$sql = "UPDATE FOOD_SERVICE_MENUS SET ";

					foreach($columns as $column=>$value)
						$sql .= $column."='".str_replace("\'","''",$value)."',";

					if($_REQUEST['tab_id']!='new')
						$sql = substr($sql,0,-1) . " WHERE CATEGORY_ID='$id'";
					else
						$sql = substr($sql,0,-1) . " WHERE MENU_ID='$id'";
					DBQuery($sql);
				}
				else
				{
					if($_REQUEST['tab_id']!='new')
					{
						$sql = 'INSERT INTO FOOD_SERVICE_CATEGORIES ';
						$fields = 'CATEGORY_ID,MENU_ID,SCHOOL_ID,';
						$values = db_seq_nextval('FOOD_SERVICE_CATEGORIES_SEQ').',\''.$_REQUEST['tab_id'].'\',\''.UserSchool().'\',';
					}
					else
					{
						$sql = 'INSERT INTO FOOD_SERVICE_MENUS ';
						$fields = 'MENU_ID,SCHOOL_ID,';
						$values = db_seq_nextval('FOOD_SERVICE_MENUS_SEQ').',\''.UserSchool().'\',';
					}

					$go = false;
					foreach($columns as $column=>$value)
						if($value)
						{
							$fields .= $column.',';
							$values .= '\''.str_replace("\'","''",$value).'\',';
							$go = true;
						}
					$sql .= '(' . substr($fields,0,-1) . ') values(' . substr($values,0,-1) . ')';

					if($go)
						DBQuery($sql);
				}
			}
		}
	}
	unset($_REQUEST['modfunc']);
}

if($_REQUEST['modfunc']=='remove')
{
	if($_REQUEST['tab_id']!='new')
	{
		if(DeletePromptX('Category'))
		{
			DBQuery("UPDATE FOOD_SERVICE_MENU_ITEMS SET CATEGORY_ID=NULL WHERE CATEGORY_ID='$_REQUEST[category_id]'");
			DBQuery("DELETE FROM FOOD_SERVICE_CATEGORIES WHERE CATEGORY_ID='$_REQUEST[category_id]'");
		}
	}
	else
		if(DeletePromptX('Meal'))
		{
			DBQuery("DELETE FROM FOOD_SERVICE_MENU_ITEMS WHERE MENU_ID='$_REQUEST[menu_id]'");
			DBQuery("DELETE FROM FOOD_SERVICE_CATEGORIES WHERE MENU_ID='$_REQUEST[menu_id]'");
			DBQuery("DELETE FROM FOOD_SERVICE_MENUS WHERE MENU_ID='$_REQUEST[menu_id]'");
		}
}

if(!$_REQUEST['modfunc'])
{
	$menus_RET = DBGet(DBQuery('SELECT MENU_ID,TITLE FROM FOOD_SERVICE_MENUS WHERE SCHOOL_ID=\''.UserSchool().'\' ORDER BY SORT_ORDER'),array(),array('MENU_ID'));
	if($_REQUEST['tab_id'])
	{
		if($_REQUEST['tab_id']!='new')
			if($menus_RET[$_REQUEST['tab_id']])
				$_SESSION['FSA_menu_id'] = $_REQUEST['tab_id'];
			elseif(count($menus_RET))
				$_REQUEST['tab_id'] = $_SESSION['FSA_menu_id'] = key($menus_RET);
			else
				$_REQUEST['tab_id'] = 'new';
	}
	else
	{
		if($_SESSION['FSA_menu_id'])
			if($menus_RET[$_SESSION['FSA_menu_id']])
				$_REQUEST['tab_id'] = $_SESSION['FSA_menu_id'];
			elseif(count($menus_RET))
				$_REQUEST['tab_id'] = $_SESSION['FSA_menu_id'] = key($menus_RET);
			else
				$_REQUEST['tab_id'] = 'new';
		else
			if(count($menus_RET))
				$_REQUEST['tab_id'] = $_SESSION['FSA_menu_id'] = key($menus_RET);
			else
				$_REQUEST['tab_id'] = 'new';
	}

	$tabs = array();
	foreach($menus_RET as $id=>$menu)
		$tabs[] = array('title'=>$menu[1]['TITLE'],'link'=>"Modules.php?modname=$_REQUEST[modname]&tab_id=$id");

	if($_REQUEST['tab_id']!='new')
	{
		$sql = 'SELECT * FROM FOOD_SERVICE_CATEGORIES WHERE MENU_ID=\''.$_REQUEST['tab_id'].'\' AND SCHOOL_ID=\''.UserSchool().'\' ORDER BY SORT_ORDER';
		$functions = array('TITLE'=>'makeTextInput','SORT_ORDER'=>'makeTextInput');

		$LO_columns = array('TITLE'=>$menus_RET[$_REQUEST['tab_id']][1]['TITLE'].' Category','SORT_ORDER'=>'Sort Order');

		$link['add']['html'] = array('TITLE'=>makeTextInput('','TITLE'),'SORT_ORDER'=>makeTextInput('','SORT_ORDER'));
		$link['remove']['link'] = "Modules.php?modname=$_REQUEST[modname]&modfunc=remove&tab_id=$_REQUEST[tab_id]&category_id=$_REQUEST[category_id]";
		$link['remove']['variables'] = array('category_id'=>'CATEGORY_ID');
		$link['add']['html']['remove'] = button('add');

		$tabs[] = array('title'=>button('add'),'link'=>"Modules.php?modname=$_REQUEST[modname]&tab_id=new");
		$singular = $menus_RET[$_REQUEST['tab_id']][1]['TITLE'].' Category';
		$plural = substr($singular,0,-1).'ies';
	}
	else
	{
		$sql = 'SELECT * FROM FOOD_SERVICE_MENUS WHERE SCHOOL_ID=\''.UserSchool().'\' ORDER BY SORT_ORDER';
		$functions = array('TITLE'=>'makeTextInput','SORT_ORDER'=>'makeTextInput');
		$LO_columns = array('TITLE'=>'Meal','SORT_ORDER'=>'Sort Order');

		$link['add']['html'] = array('TITLE'=>makeTextInput('','TITLE'),'SORT_ORDER'=>makeTextInput('','SORT_ORDER'));
		$link['remove']['link'] = "Modules.php?modname=$_REQUEST[modname]&modfunc=remove&tab_id=new";
		$link['remove']['variables'] = array('menu_id'=>'MENU_ID');
		$link['add']['html']['remove'] = button('add');

		$tabs[] = array('title'=>button('white_add'),'link'=>"Modules.php?modname=$_REQUEST[modname]&tab_id=new");
		$singular = 'Meal';
		$plural = 'Meals';
	}
	$LO_ret = DBGet(DBQuery($sql),$functions);

	echo "<FORM action=Modules.php?modname=$_REQUEST[modname]&modfunc=update&tab_id=$_REQUEST[tab_id] method=POST>";
	DrawHeader('',SubmitButton('Save'));
	echo '<BR>';

	$extra = array('save'=>false,'search'=>false,
		'header'=>WrapTabs($tabs,"Modules.php?modname=$_REQUEST[modname]&tab_id=$_REQUEST[tab_id]"));
	ListOutput($LO_ret,$LO_columns,$singular,$plural,$link,array(),$extra);

	echo '<CENTER>'.SubmitButton('Save').'</CENTER>';
	echo '</FORM>';
}

function makeTextInput($value,$name)
{	global $THIS_RET;

	if($THIS_RET['CATEGORY_ID'])
		$id = $THIS_RET['CATEGORY_ID'];
	elseif($THIS_RET['MENU_ID'])
		$id = $THIS_RET['MENU_ID'];
	else
		$id = 'new';

	if($name=='TITLE')
		$extra = 'size=20 maxlength=25';
	elseif($name=='SORT_ORDER')
		$extra = 'size=6 maxlength=8';
	else
		$extra = 'size=8 maxlength=8';

	return TextInput($value,'values['.$id.']['.$name.']','',$extra);
}
?>
