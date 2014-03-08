<?php
/**
* @file $Id: CalculationsReports.php 161 2006-09-07 06:21:17Z doritojones $
* @package Focus/SIS
* @copyright Copyright (C) 2006 Andrew Schmadeke. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.txt
* Focus/SIS is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.txt for copyright notices and details.
*/

DrawHeader(ProgramTitle());
if($_REQUEST['modfunc']=='run')
{
	DrawHeader('',"<INPUT type=button value="._('Go')." onclick='document.location.href=\"".PreparePHP_SELF()."\"'>");

	$max_col = $max_row = 0;
	foreach($_REQUEST['text'] as $row=>$cells)
	{
		if($row>$max_row)
			$max_row = $row;
		foreach($cells as $col=>$value)
		{
			if($col>$max_col)
				$max_col = $col;
		}
	}
	foreach($_REQUEST['calculation'] as $row=>$cells)
	{
		if($row>$max_row)
			$max_row = $row;
		foreach($cells as $col=>$value)
		{
			if($col>$max_col)
				$max_col = $col;
		}
	}
	echo '<BR>';
	echo '<CENTER><TABLE border=1 bgcolor=#FFFFFF width=90%>';
	for($row=1;$row<=$max_row;$row++)
	{
		echo '<TR>';
		for($col=1;$col<=$max_col;$col++)
		{
			if($_REQUEST['text'][$row][$col]=='Title')
				unset($_REQUEST['text'][$row][$col]);
			if($_REQUEST['text'][$row][$col] || $_REQUEST['calculation'][$row][$col])
			{
				// CHECK FOR EMPTY CELLS BENEATH THIS ONE -- THIS CELL SHOULD EXPAND INTO THESE EMPTY CELLS WITH ROWSPAN
				$rowspan = 1;
				for($i=($row+1);$i<=$max_row;$i++)
				{
					if((!$_REQUEST['text'][$i][$col] || $_REQUEST['text'][$i][$col]=='Title')&& !$_REQUEST['calculation'][$i][$col])
						$rowspan++;
				}
				echo '<TD rowspan='.$rowspan.' valign=top align=center>';
				if($_REQUEST['text'][$row][$col])
				{
					echo '<b>'.$_REQUEST['text'][$row][$col].'</b>';
					if($_REQUEST['calculation'][$row][$col])
						echo '<BR>';
				}
				if($_REQUEST['calculation'][$row][$col])
					echo _runCalc($_REQUEST['calculation'][$row][$col],$_REQUEST['breakdown'][$row][$col],$_REQUEST['graph'][$row][$col]);
				echo '</TD>';
			}
			else
			{
				// CHECK TO SEE IF THERE IS A FULL CELL ABOVE THIS ONE -- IF SO, DON'T INCLUDE CELL -- ABOVE CELL HAS A ROWSPAN
				$before = false;
				for($i=$row;$i>=1;$i--)
				{
					if($_REQUEST['text'][$i][$col] || $_REQUEST['calculation'][$i][$col])
						$before = true;
				}
				if($before==false)
					echo '<TD></TD>';
			}
		}
		echo '</TR>';
	}
	echo '</TABLE></CENTER>';
}

if(!$_REQUEST['modfunc'])
{
	$height = 95;
	$width = 200;
	if(Preferences('MENU')=='Top')
		$top_offset = 125;
	else
		$top_offset = 50;
	$left_offset = 30;
?>
<SCRIPT language=javascript>
var cols = 1;var rows = 1;
function addCol()
{
	cols++;
	for(row=1;row<=rows;row++)
	{
		addCell(cols,row);
	}
	button_left = parseInt(document.getElementById('add_col').style.left);
	document.getElementById('add_col').style.left = (button_left + <?php echo $width; ?>) + 'px';
}
function addRow()
{
	rows++;
	for(col=1;col<=cols;col++)
	{
		addCell(col,rows);
	}
	button_top = parseInt(document.getElementById('add_row').style.top);
	document.getElementById('add_row').style.top = (button_top + <?php echo $height; ?>) + 'px';
}
function addCell(col,row)
{
	width = <?php echo $width; ?>;
	height = <?php echo $height; ?>;
	x = <?php echo $left_offset; ?> + width * (col-1);
	y = <?php echo $top_offset; ?> + height * (row-1);
	if(row%2!=0)
		color = "<?php echo Preferences('COLOR'); ?>";
	else
		color = 'FFFFFF';

	document.getElementById('main_div').innerHTML = document.getElementById('main_div').innerHTML + replaceAll(document.getElementById('new_cell').innerHTML.replace('9876',y).replace('6789',x).replace('FFFFFF',color).replace('ffffff',color).replace('rgb(255, 255, 255)','#'+color).replace('div_id','id'),'cell_id','['+row+']['+col+']');
}
function replaceAll(haystack,needle,replacement)
{
	haystack = haystack.replace(needle,replacement);
	if(haystack.match(needle))
		haystack = replaceAll(haystack,needle,replacement);
	return haystack;
}
</SCRIPT>

<?php
	$calculations_RET = DBGet(DBQuery("SELECT ID,TITLE FROM SAVED_CALCULATIONS ORDER BY TITLE"));
	$select = '<SELECT name=calculationcell_id style="width:'.($width-7).';"><OPTION value="">'._('Calculation').'</OPTION>';
	foreach($calculations_RET as $calculation)
	{
		$select .= '<OPTION value='.$calculation['ID'].'>'.$calculation['TITLE'].'</OPTION>';
	}
	$select .= '</SELECT>';
	$text = "<INPUT type=text name=textcell_id size=20 value='".'Title\' style=\'color:BBBBBB\''." onfocus='if(this.value==\"Title\") {this.value=\"\"; this.style.color=\"000000\";}' onblur='if(this.value==\"\") {this.value=\"Title\"; this.style.color=\"BBBBBB\";}'>";

	$fields_RET = DBGet(DBQuery("SELECT ID,TITLE FROM CUSTOM_FIELDS WHERE TYPE='select' ORDER BY TITLE"));
	$breakdown = '<SELECT name=breakdowncell_id style="max-width:150;"><OPTION value="">Breakdown</OPTION><OPTION value=school>School</OPTION><OPTION value=grade>Grade</OPTION><OPTION value=stuid>Student ID</OPTION>';
	foreach($fields_RET as $field)
		$breakdown .= "<OPTION value=CUSTOM_".$field['ID'].">".$field['TITLE'].'</OPTION>';
	$breakdown .= '</SELECT>';
	$graph = "<INPUT type=checkbox name=graphcell_id value='Y'>Graph Results";

	echo '<DIV id=add_col style="position:absolute;top:'.($top_offset+5).'px;left:'.($left_offset+5+$width).'px;">'.button('add','Add Col','# onclick="addCol();"').'</DIV>';
	echo '<DIV id=add_row style="position:absolute;top:'.($top_offset+5+$height).'px;left:'.($left_offset+5).'px;">'.button('add','Add Row','# onclick="addRow();"').'</DIV>';
	echo '<FORM action=Modules.php?modname='.$_REQUEST['modname'].'&modfunc=run method=POST style="display:inline;">';
	DrawHeader('',SubmitButton());
	echo '<DIV id=main_div></DIV>';

	echo '</FORM>';

	echo '<DIV id=new_cell style="position:absolute;display:none;"><DIV div_id=cellcell_id style="position:absolute;width:'.$width.';height:'.$height.';top:9876px;left:6789px;border-style:solid solid solid solid;border-width:1;background-color:#FFFFFF;">'.$text.'<BR>'.$select.'<BR>'.$breakdown.'<BR>'.$graph.'</DIV>';
	echo '<SCRIPT>addCell(1,1);</SCRIPT>';
}

function _runCalc($calculation_id,$breakdown,$graph)
{	global $_CENTRE,$num,$_runCalc_num;

	if(!isset($num))
		$num = 0;
	if(!isset($_runCalc_num))
		$_runCalc_num = $num;

	$_runCalc_start_REQUEST = $_REQUEST;
	if(!$_CENTRE['Calc'.substr($column,12)])
	{
		$url_RET = DBGet(DBQuery("SELECT URL,TITLE FROM SAVED_CALCULATIONS WHERE ID='".$calculation_id."'"));
		$_CENTRE['CalcTitle'.substr($column,12)] = $url_RET[1]['TITLE'];
		$url = $url_RET[1]['URL'];
		$url = urldecode($url);
		$vars = substr($url,(strpos($url,'?')+1));
		$modname = substr($url,0,strpos($url,'?'));
		
		$vars = str_replace('&amp;','&',$vars);
		$vars = explode('&',$vars);
		$_REQUEST = array();
		foreach($vars as $code)
		{
			$equals = strpos($code,'=');
	
			if(strpos($code,'[')!==false)
				$code = "\$_REQUEST[".ereg_replace('([^]])\[','\1][',substr($code,0,$equals))."='".substr($code,$equals+1)."';";
			else
				$code = "\$_REQUEST['".substr($code,0,$equals)."']='".substr($code,$equals+1)."';";
			eval($code);
		}
		$_CENTRE['Calc'.$calculation_id] = $_REQUEST;
	}
	else
		$_REQUEST = $_CENTRE['Calc'.$calculation_id];

	$_REQUEST['breakdown'] = $breakdown;
	if($_REQUEST['breakdown']=='CUSTOM_44')
	{
		for($i=1;$i<=15;$i++)
		{
			$_REQUEST['screen'][$i]['_search_all_schools'] = 'Y';
		}
	}
	$_REQUEST['graph'] = $graph;
	$_REQUEST['equation_title'] = $_CENTRE['CalcTitle'.$calculation_id];
	$num = $_runCalc_num;
	// so Calculations.php doesn't include the functions within this function
	$_REQUEST['modfunc'] = 'State_Reports/CalculationsReports.php';
	$_REQUEST['modfunc'] = 'echoXMLHttpRequest';
	$return = include("modules/State_Reports/Calculations.php");
	$_REQUEST = $_runCalc_start_REQUEST;
	return $return;
}
?>