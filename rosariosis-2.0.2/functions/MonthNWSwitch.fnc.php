<?php
function MonthNWSwitch($month, $direction='both')
{
	if($direction=='tonum')
	{
		if(mb_strlen($month)<3) // assume already num.
			return $month;
		else
			return __mnwswitch_char2num($month);
	}
	elseif($direction=='tochar')
	{
		if(mb_strlen($month)==3) // assume already char.
			return $month;
		else
			return __mnwswitch_num2char($month);
	}
	else
	{
		$month=__mnwswitch_num2char($month);
		$month=__mnwswitch_char2num($month);
		return $month;
	}
} 

function __mnwswitch_num2char($month)
{
	if(mb_strlen($month)==1)
		$month='0'.$month;
		
	if($month=='01'){$out="JAN";}
	elseif($month=='02'){$out="FEB";}
	elseif($month=='03'){$out="MAR";}
	elseif($month=='04'){$out="APR";}
	elseif($month=='05'){$out="MAY";}
	elseif($month=='06'){$out="JUN";}
	elseif($month=='07'){$out="JUL";}
	elseif($month=='08'){$out="AUG";}
	elseif($month=='09'){$out="SEP";}
	elseif($month=='10'){$out="OCT";}
	elseif($month=='11'){$out="NOV";}
	elseif($month=='12' || $month=='00'){$out="DEC";}
	else $out=$month;
	return $out;
}

function __mnwswitch_char2num($month)
{
	if(mb_strtoupper($month)=='JAN'){$out="01";}
	elseif(mb_strtoupper($month)=='FEB'){$out="02";}
	elseif(mb_strtoupper($month)=='MAR'){$out="03";}
	elseif(mb_strtoupper($month)=='APR'){$out="04";}
	elseif(mb_strtoupper($month)=='MAY'){$out="05";}
	elseif(mb_strtoupper($month)=='JUN'){$out="06";}
	elseif(mb_strtoupper($month)=='JUL'){$out="07";}
	elseif(mb_strtoupper($month)=='AUG'){$out="08";}
	elseif(mb_strtoupper($month)=='SEP'){$out="09";}
	elseif(mb_strtoupper($month)=='OCT'){$out="10";}
	elseif(mb_strtoupper($month)=='NOV'){$out="11";}
	elseif(mb_strtoupper($month)=='DEC'){$out="12";}
	else $out=$month;
	return $out;
}
?>