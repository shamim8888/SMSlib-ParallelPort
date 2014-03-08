function capfirst(name){
var name1="";
var name2="";
var name3 = "";
var currentcode = 0;
var i = 0;
var j=name.length;
var currrentchar= '';
var upperlower = true;
var spaceflag = true;
var dotflag = false;
var str=" /\-(){}[].,'~!`;:?-*^%$#@";

check:
		while(i<=j){
			currentchar=name.charAt(i);
			currentcode=name.charCodeAt(i);

			
			if(  str.search(currentchar)!==-1) {
				upperlower  = true;
				if (! spaceflag){
				  (! dotflag) ?(currentcode!==32) ? name2 = currentchar+' ' : name2 = currentchar : name2=name2 ;
					}
				dotflag = true;
				i++;
				continue check;
				}
			
			
				if( !upperlower){
					currentchar = currentchar.toLowerCase();
					spaceflag = false;
					dotflag = false;

					}
					
				else
					{currentchar = currentchar.toUpperCase();
					upperlower = false;
					spaceflag = false;
					dotflag = false;
					}
		
			name1=name1+name2+currentchar;
			name2 = '';
			i++;
		}
	return name1;
}








function moneyconvert(amount){

var name1="";
var name2="";
var _N_O = 0;
var _N_1 = 0;
var _N_2 = 0;
var currentcode = 0;
var i = 0;
var j=0;

if (isFinite(amount) !== true)
{
   {alert('Invalid Number Argument!');};
   return ('');
   
}

convertword = new Array();
convertword[1] ='One ';
convertword[2] ='Two ';
convertword[3] ='Three ';
convertword[4] ='Four ';
convertword[5]='Five ';
convertword[6]='Six ';
convertword[7]='Seven ';
convertword[8]='Eight ';
convertword[9]='Nine ';
convertword[10]='Ten ';
convertword[11]='Eleven ';
convertword[12]='Twelve ';
convertword[13]='Thirteen ';
convertword[14]='Fourteen ';
convertword[15]='Fifteen ';
convertword[16]='Sixteen ';
convertword[17]='Seventeen ';
convertword[18]='Eighteen ';
convertword[19]='Ninteen ';
convertword[20]='Twenty ';
convertword[30]='Thirty ';
convertword[40]='Forty ';
convertword[50]='Fifty ';
convertword[60]='Sixty ';
convertword[70]='Seventy ';
convertword[80]='Eighty ';
convertword[90]='Ninety ';

for( j=20;j<=90;j +=10)
	{

		for(i=1;i<=9;i++)
		{
			convertword[j+i]=convertword[j]+convertword[i];
		}
	}
specialword = new Array();

specialword[1]='Hundred ';
specialword[2]='Thousand ';
specialword[3]='Lakh ';
specialword[4]='Crore ';

_N_1=parseInt(amount, 10);

_N_2 = Number(amount);
_N_2 = _N_2.toFixed(5);
_N_2 = _N_2.toString();
_N_2=('00000000000000000000' + _N_2);

_N_2 = _N_2.substr((_N_2.length-5),5);


var 	posnegsign = (_N_1 < 0 ? 'Minus ' : '' );
var 	anotherspecialword = ( _N_1===0 ? 'Zero ' : '');

	_N_O = Math.abs(_N_1);
	
	_N_O = _N_O.toString();
	
	for (i=0;i<(17-_N_O.length);i++)
		{
			name1 = name1+ " ";
		}
	_N_O = name1+ _N_O;
	 _L =  new Array();
	 
	_L[1]= (Number(_N_O.substr(0,1))===0) ? '' : convertword[Number(_N_O.substr(0,1))]+specialword[1];
	_L[2]= (Number(_N_O.substr(1,2))===0) ? '' : convertword[Number(_N_O.substr(1,2))]+specialword[4];
	_L[3]= (Number(_N_O.substr(3,2))===0) ? '' : convertword[Number(_N_O.substr(3,2))]+specialword[3];
	_L[4]= (Number(_N_O.substr(5,2))===0) ? '' : convertword[Number(_N_O.substr(5,2))]+specialword[2];
	_L[5]= (Number(_N_O.substr(7,1))===0) ? '' : convertword[Number(_N_O.substr(7,1))]+specialword[1];
	_L[6]= (Number(_N_O.substr(8,2))===0) ? '' : convertword[Number(_N_O.substr(8,2))]+specialword[4];
	_L[7]= (Number(_N_O.substr(10,2))===0) ? '' : convertword[Number(_N_O.substr(10,2))]+specialword[3];
	_L[8]= (Number(_N_O.substr(12,2))===0) ? '' : convertword[Number(_N_O.substr(12,2))]+specialword[2];
	_L[9]= (Number(_N_O.substr(14,1))===0) ? '' : convertword[Number(_N_O.substr(14,1))]+specialword[1];
	_L[10]= (Number(_N_O.substr(15,2))===0) ? '' : convertword[Number(_N_O.substr(15,2))];

	 _M = new Array();
	
	_M[5]=(Number(_N_2.substr(4)) > 0) ? convertword[Number(_N_2.substr(4,1))] : '' ;
	_M[4]=(Number(_N_2.substr(3))>0) ? Number(_N_2.substr(3,1))>=1 ? convertword[Number(_N_2.substr(3,1))] :'Zero ' :'';
	_M[3]=(Number(_N_2.substr(2))>0) ? Number(_N_2.substr(2,1))>=1 ? convertword[Number(_N_2.substr(2,1))] :'Zero ' :'';
	_M[2]=(Number(_N_2.substr(1))>0) ? Number(_N_2.substr(1,1))>=1 ? convertword[Number(_N_2.substr(1,1))] :'Zero ' :'';
	_M[1]=(Number(_N_2.substr(0))>0) ? Number(_N_2.substr(0,1))>=1 ? convertword[Number(_N_2.substr(0,1))] :'Zero ' :'';
	
	_M[6] = Number(_N_2)>0 ? 'Point ':'';
	_O = posnegsign+anotherspecialword+_L[1]+_L[2]+_L[3]+_L[4]+_L[5]+_L[6]+_L[7]+_L[8]+_L[9]+_L[10];
	_P=_M[6]+_M[1]+_M[2]+_M[3]+_M[4]+_M[5];



return (_O+_P)+'Taka Only';

}






function button_job(buttonname)
        {
	        if(buttonname === "topbutton")
            	{
				document.test.navigation.value = "true";
		                document.test.filling.value = "topbutton";
		                document.test.gotocheck.value = 1;
	            }

	        if(buttonname === "prevrecord")
                        {
				document.test.navigation.value = "true";
		                document.test.filling.value = "prevrecord";

		                if (Number(document.test.gotocheck.value)>1 )
                                        {
		                                document.test.gotocheck.value = Number(document.test.gotocheck.value)-1;
		                        }
		                else
			                {
				                document.test.gotocheck.value = 1;
			                }

	                }

	        if(buttonname === "nextrecord")
                        {
						document.test.navigation.value = "true";
		                document.test.filling.value = "nextrecord";

		                if (Number(document.test.gotocheck.value)<  numrows )
                                        {

		                                document.test.gotocheck.value = Number(document.test.gotocheck.value)+1;
		                        }
		                else
			                {
				                document.test.gotocheck.value = numrows;
			                }

                                window.status = document.test.gotocheck.value+"/"+ numrows ;
	                }

	        if(buttonname === "bottombutton")
                        {
				document.test.navigation.value = "true";
		                document.test.filling.value = "bottombutton";
		                document.test.gotocheck.value = numrows  ;
	                }

	        if(buttonname === "gotobutton")
                        {
				document.test.navigation.value = "true";
		                document.test.filling.value = "gotobutton";

                                if (Number(document.test.gotocheck.value)> numrows  )
                                        {
		                                document.test.gotocheck.value = numrows;
		                        }

                                if (Number(document.test.gotocheck.value)<1 )
                                        {
		                                document.test.gotocheck.value = 1;
		                        }

                        }

	        if(buttonname === "deletebutton")
                        {
				document.test.navigation.value = "true";
		                document.test.filling.value = "deletebutton";
	                }

                if(buttonname === "viewbutton")
                        {
		                document.test.filling.value = "viewbutton";
	                }

	        if(buttonname === "addbutton")
                        {
		                document.test.filling.value = "addbutton";
	                }

                if(buttonname === "editbutton")
                        {
		                document.test.filling.value = "editbutton";
	                }

                

                if(buttonname === "cancelbutton")
                        {
		                document.test.filling.value = "cancelbutton";
	                }


        }






function goto_window()
        {
  	        var nameprompt = prompt("Enter the Desired Record Number", "","Goto Record");

                if (isFinite(nameprompt) != true)
	                {
   		                alert('Invalid Record Argument!');
                        }



	        else
                        {
		                if (Number(nameprompt)==0)
                                        {

                                                //document.test.gotocheck.value= gotocheck ;

                                        }
		                else
		                        {
                                                document.test.gotocheck.value=nameprompt;

                                                if (Number(document.test.gotocheck.value)> numrows  )
                                                        {
                                                                document.test.gotocheck.value = numrows;
                                                        }

                                                if (Number(document.test.gotocheck.value)<1 )
                                                        {
                                                                document.test.gotocheck.value = 1;
                                                        }

                                                document.test.submit();



		                        }

                        }


        }




function del_confirm()
        {
                var agree = confirm ("Are You Sure to delete the Record?", "");

                if (agree==true)
                        {
		                document.test.filling.value = "deletebutton";
	                        document.test.submit();
	                }

        }









function button_option(whatever)
        {
                if (whatever=="normal")
                        {
                                document.test.addbutton.disabled=false;
                                document.test.editbutton.disabled=false;
                                document.test.viewbutton.disabled=false;
                                document.test.deletebutton.disabled=false;

                                document.test.savebutton.disabled=true;
                                document.test.cancelbutton.disabled=true;

                                document.test.prevrecord.disabled=false;
                                document.test.nextrecord.disabled=false;
                                document.test.topbutton.disabled=false;
                                document.test.gotobutton.disabled=false;
                                document.test.bottombutton.disabled=false;
                                document.test.printbutton.disabled=false;

                        }

                if (whatever=="pressed")
                        {
                                document.test.addbutton.disabled=true;
                                document.test.editbutton.disabled=true;
                                document.test.viewbutton.disabled=true;
                                document.test.deletebutton.disabled=true;

                                document.test.savebutton.disabled=false;
                                document.test.cancelbutton.disabled=false;

                                document.test.prevrecord.disabled=true;
                                document.test.nextrecord.disabled=true;
                                document.test.topbutton.disabled=true;
                                document.test.gotobutton.disabled=true;
                                document.test.bottombutton.disabled=true;
                                document.test.printbutton.disabled=true;
                        }



                if (whatever=="norecord")
                        {

                                document.test.addbutton.disabled=false;
                                document.test.editbutton.disabled=true;
                                document.test.viewbutton.disabled=true;
                                document.test.deletebutton.disabled=true;

                                document.test.savebutton.disabled=true;
                                document.test.cancelbutton.disabled=true;

                                document.test.prevrecord.disabled=true;
                                document.test.nextrecord.disabled=true;
                                document.test.topbutton.disabled=true;
                                document.test.gotobutton.disabled=true;
                                document.test.printbutton.disabled=true;
                                document.test.bottombutton.disabled=true;


                        }


        }




        function navforview_button_job(buttonname)
                {
        	        if(buttonname == "topbutton")
                                {
        		                document.test.filling.value = "topbutton";
        		                document.test.pagenum.value = 1;
        	                }

        	        if(buttonname == "prevrecord")
                                {
        		                document.test.filling.value = "prevrecord";

        		                if (Number(document.test.pagenum.value)>1 )
                                        {
        		                                document.test.pagenum.value = Number(document.test.pagenum.value)-1;
        		                        }
        		                else
        			                {
        				                document.test.pagenum.value = 1;
        			                }

        	                }

        	        if(buttonname == "nextrecord")
                                {
        		                document.test.filling.value = "nextrecord";

        		                if (Number(document.test.pagenum.value)<  totalnumofpage )
                                                {

        		                                document.test.pagenum.value = Number(document.test.pagenum.value)+1;
        		                        }
        		                else
        			                {
        				                document.test.pagenum.value = totalnumofpage;
        			                }

                                        window.status = document.test.pagenum.value+"/"+ totalnumofpage ;
        	                }

        	        if(buttonname == "bottombutton")
                                {
        		                document.test.filling.value = "bottombutton";
        		                document.test.pagenum.value = totalnumofpage  ;
        	                }

        	        if(buttonname == "gotobutton")
                                {
        		                document.test.filling.value = "gotobutton";

                                        if (Number(document.test.pagenum.value)> totalnumofpage  )
                                                {
        		                                document.test.pagenum.value = totalnumofpage;
        		                        }

                                        if (Number(document.test.pagenum.value)<1 )
                                                {
        		                                document.test.pagenum.value = 1;
        		                        }

                                }




                }




        function navforview_goto_window()
                {
          	        var nameprompt = prompt("Enter the Desired Page Number", "","Goto Record");

                        if (isFinite(nameprompt) != true)
        	                {
           		                alert('Invalid Record Argument!');
                                }



        	        else
                                {
        		                if (Number(nameprompt)==0)
                                                {

                                                        //document.test.gotocheck.value= gotocheck ;

                                                }
        		                else
        		                        {
                                                        document.test.pagenum.value=nameprompt;

                                                        if (Number(document.test.pagenum.value)> totalnumofpage  )
                                                                {
                                                                        document.test.pagenum.value = totalnumofpage;
                                                                }

                                                        if (Number(document.test.pagenum.value)<1 )
                                                                {
                                                                        document.test.pagenum.value = 1;
                                                                }

                                                        document.test.submit();



        		                        }

                                }


                }


























