<?php
require_once('modules/Food_Service/includes/DeletePromptX.fnc.php');

DrawBC("Food Service >> ".ProgramTitle());
//DrawHeader(ProgramTitle());

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
						$sql = "UPDATE FOOD_SERVICE_MENU_ITEMS SET ";
					else
						$sql = "UPDATE FOOD_SERVICE_ITEMS SET ";

					foreach($columns as $column=>$value)
						$sql .= $column."='".str_replace("\'","''",$value)."',";

					if($_REQUEST['tab_id']!='new')
						$sql = substr($sql,0,-1) . " WHERE MENU_ITEM_ID='$id'";
					else
						$sql = substr($sql,0,-1) . " WHERE ITEM_ID='$id'";
					DBQuery($sql);
				}
				else
				{
					if($_REQUEST['tab_id']!='new')
					{
						$sql = 'INSERT INTO FOOD_SERVICE_MENU_ITEMS ';
						$fields = 'MENU_ITEM_ID,MENU_ID,SCHOOL_ID,';
						$values = db_seq_nextval('FOOD_SERVICE_MENU_ITEMS_SEQ').',\''.$_REQUEST['tab_id'].'\',\''.UserSchool().'\',';
					}
					else
					{
						$sql = 'INSERT INTO FOOD_SERVICE_ITEMS ';
						$fields = 'ITEM_ID,SCHOOL_ID,';
						$values = db_seq_nextval('FOOD_SERVICE_ITEMS_SEQ').',\''.UserSchool().'\',';
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
		if(DeletePromptX('Meal Item'))
			DBQuery("DELETE FROM FOOD_SERVICE_MENU_ITEMS WHERE MENU_ID='$_REQUEST[tab_id]' AND MENU_ITEM_ID='$_REQUEST[menu_item_id]'");
	}
	else
		if(DeletePromptX('Item'))
		{
			DBQuery("DELETE FROM FOOD_SERVICE_MENU_ITEMS WHERE ITEM_ID='$_REQUEST[item_id]'");
			DBQuery("DELETE FROM FOOD_SERVICE_ITEMS WHERE ITEM_ID='$_REQUEST[item_id]'");
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
		$items_RET = DBGet(DBQuery('SELECT ITEM_ID,DESCRIPTION FROM FOOD_SERVICE_ITEMS WHERE SCHOOL_ID=\''.UserSchool().'\' ORDER BY SORT_ORDER'));
		$items_select = array();
		foreach($items_RET as $item)
			$items_select += array($item['ITEM_ID']=>$item['DESCRIPTION']);

		$categories_RET = DBGet(DBQuery('SELECT CATEGORY_ID,TITLE FROM FOOD_SERVICE_CATEGORIES WHERE MENU_ID=\''.$_REQUEST['tab_id'].'\' ORDER BY SORT_ORDER'));
		$categories_select = array();
		foreach($categories_RET as $category)
			$categories_select += array($category['CATEGORY_ID']=>$category['TITLE']);

		//$sql = 'SELECT *,(SELECT \'<IMG src='.$FS_IconsPath.'/\'||ICON||\' height=30>\' FROM FOOD_SERVICE_ITEMS WHERE ITEM_ID=fsmi.ITEM_ID) AS SHORT_NAME FROM FOOD_SERVICE_MENU_ITEMS fsmi WHERE MENU_ID=\''.$_REQUEST['tab_id'].'\' ORDER BY (SELECT SORT_ORDER FROM FOOD_SERVICE_CATEGORIES WHERE CATEGORY_ID=fsmi.CATEGORY_ID),SORT_ORDER';
		$sql = 'SELECT *,(SELECT ICON FROM FOOD_SERVICE_ITEMS WHERE ITEM_ID=fsmi.ITEM_ID) AS ICON FROM FOOD_SERVICE_MENU_ITEMS fsmi WHERE MENU_ID=\''.$_REQUEST['tab_id'].'\' ORDER BY (SELECT SORT_ORDER FROM FOOD_SERVICE_CATEGORIES WHERE CATEGORY_ID=fsmi.CATEGORY_ID),SORT_ORDER';
		$functions = array('ITEM_ID'=>'makeSelectInput','ICON'=>'makeIcon','CATEGORY_ID'=>'makeSelectInput','DOES_COUNT'=>'makeCheckboxInput','SORT_ORDER'=>'makeTextInput');

		$LO_columns = array('ITEM_ID'=>'Menu Item','ICON'=>'Icon','CATEGORY_ID'=>'Category','DOES_COUNT'=>'Include<br>in Counts','SORT_ORDER'=>'Sort Order');

		$link['add']['html'] = array('ITEM_ID'=>makeSelectInput('','ITEM_ID'),'CATEGORY_ID'=>makeSelectInput('','CATEGORY_ID'),'DOES_COUNT'=>makeCheckboxInput('','DOES_COUNT'),'SORT_ORDER'=>makeTextInput('','SORT_ORDER'));
		$link['remove']['link'] = "Modules.php?modname=$_REQUEST[modname]&modfunc=remove&tab_id=$_REQUEST[tab_id]";
		$link['remove']['variables'] = array('menu_item_id'=>'MENU_ITEM_ID');
		$link['add']['html']['remove'] = button('add');

		$tabs[] = array('title'=>button('add'),'link'=>"Modules.php?modname=$_REQUEST[modname]&tab_id=new");
		$singular = $menus_RET[$_REQUEST['tab_id']][1]['TITLE'].' Item';
		$plural = $singular.'s';
	}
	else
	{
		$icons_select = get_icons_select($FS_IconsPath);

		$sql = 'SELECT * FROM FOOD_SERVICE_ITEMS fsmi WHERE SCHOOL_ID=\''.UserSchool().'\' ORDER BY SORT_ORDER';
		$functions = array('DESCRIPTION'=>'makeTextInput','SHORT_NAME'=>'makeTextInput','ICON'=>'makeSelectInput','SORT_ORDER'=>'makeTextInput','PRICE'=>'makeTextInput','PRICE_REDUCED'=>'makeTextInput','PRICE_FREE'=>'makeTextInput','PRICE_STAFF'=>'makeTextInput');

		if(User('PROFILE')=='admin' || User('PROFILE')=='teacher')
			$LO_columns = array('DESCRIPTION'=>'Item Description','SHORT_NAME'=>'Short Name','ICON'=>'Icon','SORT_ORDER'=>'Sort Order','PRICE'=>'Student<BR>Price','PRICE_REDUCED'=>'Reduced<BR>Price','PRICE_FREE'=>'Free<BR>Price','PRICE_STAFF'=>'Users<BR>Price');
		else
		{
			$LO_columns = array('DESCRIPTION'=>'Item Description','SHORT_NAME'=>'Short Name','ICON'=>'Icon','PRICE'=>'Student<BR>Price');
			if(UserStudentID())
			{
				$discount = DBGet(DBQuery('SELECT DISCOUNT FROM FOOD_SERVICE_STUDENT_ACCOUNTS WHERE STUDENT_ID='.UserStudentID()));
				$discount = $discount[1]['DISCOUNT'];

				if($discount=='Reduced')
					$LO_columns += array('PRICE_REDUCED'=>'Reduced<BR>Price');
				elseif($discount=='Free')
					$LO_columns += array('PRICE_FREE'=>'Free<BR>Price');
			}
			$LO_columns += array('PRICE_STAFF'=>'Users<BR>Price');
		}

		$link['add']['html'] = array('DESCRIPTION'=>makeTextInput('','DESCRIPTION'),'SHORT_NAME'=>makeTextInput('','SHORT_NAME'),'ICON'=>makeSelectInput('','ICON'),'SORT_ORDER'=>makeTextInput('','SORT_ORDER'),'PRICE'=>makeTextInput('','PRICE'),'PRICE_REDUCED'=>makeTextInput('','PRICE_REDUCED'),'PRICE_FREE'=>makeTextInput('','PRICE_FREE'),'PRICE_STAFF'=>makeTextInput('','PRICE_STAFF'));
		$link['remove']['link'] = "Modules.php?modname=$_REQUEST[modname]&modfunc=remove&tab_id=$_REQUEST[tab_id]";
		$link['remove']['variables'] = array('item_id'=>'ITEM_ID');
		$link['add']['html']['remove'] = button('add');

		$tabs[] = array('title'=>button('white_add'),'link'=>"Modules.php?modname=$_REQUEST[modname]&tab_id=new");
		$singular = 'Meal Item';
		$plural = 'Meal Items';
	}

	$LO_ret = DBGet(DBQuery($sql),$functions);
	//echo '<pre>'; var_dump($LO_ret); echo '</pre>';

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

	if($THIS_RET['MENU_ITEM_ID'])
		$id = $THIS_RET['MENU_ITEM_ID'];
	elseif($THIS_RET['ITEM_ID'])
		$id = $THIS_RET['ITEM_ID'];
	else
		$id = 'new';

	if($name=='DESCRIPTION')
		$extra = 'size=20 maxlength=25';
	elseif($name=='SORT_ORDER')
		$extra = 'size=6 maxlength=8';
	else
		$extra = 'size=8 maxlength=8';

	return TextInput($value,'values['.$id.']['.$name.']','',$extra);
}

function makeSelectInput($value,$name)
{	global $THIS_RET,$items_select,$categories_select,$icons_select;

	if($THIS_RET['MENU_ITEM_ID'])
		$id = $THIS_RET['MENU_ITEM_ID'];
	elseif($THIS_RET['ITEM_ID'])
		$id = $THIS_RET['ITEM_ID'];
	else
		$id = 'new';

	if($name=='ITEM_ID')
		return SelectInput($value,"values[$id][$name]",'',$items_select,$id=='new'?'':false);
	elseif($name=='CATEGORY_ID')
		return SelectInput($value,"values[$id][$name]",'',$categories_select);
	else
		return SelectInput($value,"values[$id][$name]",'',$icons_select);
}

function makeCheckboxInput($value,$name)
{	global $THIS_RET;

	if($THIS_RET['MENU_ITEM_ID'])
		$id = $THIS_RET['MENU_ITEM_ID'];
	else
		$id = 'new';

	return CheckboxInput($value,"values[$id][$name]",'',$value,$id=='new','<IMG SRC=assets/check.gif height=15 vspace=0 hspace=0 border=0>','<IMG SRC=assets/x.gif height=15 vspace=0 hspace=0 border=0>');
}

function makeIcon($value,$name)
{	global $FS_IconsPath;

	if($value)
		return '<IMG src='.$FS_IconsPath.'/'.$value.' height=30>';
	else
		return '&nbsp;';
}

function get_icons_select($path)
{	global $CentrePath;

	$dir = $CentrePath.'/'.$path;

	//ini_set("max_execution_time",10);
	$files = array();
	if(is_dir($dir) && $root=@opendir($dir))
		while($file=readdir($root))
			if($file!='.' && $file!='..' && !is_dir($dir.'/'.$file))
				$files[$file] = array($file,"<IMG src=$path/$file height=30>");
	ksort($files);
	return $files;
}
?>
