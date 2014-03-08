
<html>
<head>
  <title>Expenditure</title>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <meta name="GENERATOR" content="Quanta Plus">
</head>
<body bgcolor="#B1CE93">
   <form name="test" method="POST">
   <b><u><font size=+4><div align="center">Expenditure</div></font></u></b><p></p>
      Expenditure Head :&nbsp;&nbsp;&nbsp;&nbsp; <select name="expensetype">
         <option selected> Entertainment</option>
         <option>Convence & Transport</option>
         <option>Salary & Remuneration</option>
          <option>House Rent & Utilities</option>
           <option>Printing & stationaries</option>
            <option>Office Management</option>
             <option>Furnitures</option>
              <option>Business Promotion</option>
               <option>Miscellenious</option>
       </select>
     <p></p>
     Date : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<p></p>
     Voucher / Bill No.&nbsp;&nbsp;&nbsp;&nbsp;
     <input type="text" name="voucherno" size=10><p></p>
     Particulars :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
     <input type="text" name="particulars" size=50><p></p>
     Amount Tk. :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
     <input type="text" name="tkamount" size=10>

<INPUT TYPE="hidden" name="filling" value="eggplant">
<INPUT TYPE="hidden" name="gotocheck" value="<?php echo $gotocheck  ?>" >
<INPUT TYPE="hidden" name="accountid" value="<?php echo $accountid  ?>">
<BR>
   <p></p>  <p></p>
  <table border="0" width="92%" height="83">
    <tr>
      <td width="14%" height="43" valign="baseline" align="center">
<input type="button" value="Add" name="addbutton" style=" width: 84; height: 25" onClick="reset();add_edit_press('addedit');button_job(document.test.addbutton.name)"  ></td>
      <td width="15%" height="43" valign="baseline" align="center">
<input type="button" value="Edit" name="editbutton" style="width: 84; height: 25" onClick="add_edit_press('addedit');button_job(document.test.editbutton.name)"></td>
      <td width="16%" height="43" valign="baseline" align="center">
<input type="button"  value="View" name="viewbutton" style="width: 84; height: 25" onclick = "view_record()"></td>
      <td width="15%" height="43" valign="baseline" align="center">
<input type="button" value="Delete" name="deletebutton" style=" width: 84; height: 25" onclick = "del_confirm()"></td>
      <td width="15%" height="43" valign="baseline" align="center">
<input type="submit" value="Save" name="savebutton" style=" width: 84; height: 25" >
      <td width="16%" height="43" valign="baseline" align="center">
<input type="reset" value="Cancel" name="cancelbutton" style=" width: 84; height: 25" ></td></td>
    </tr>
    <tr>
      <td width="14%" height="32" valign="baseline" align="center">
<input type="button" value="Top" name="topbutton" style=" width: 84; height: 25" onclick = "button_job(document.test.topbutton.name);submit()"></td>
      <td width="15%" height="32" valign="baseline" align="center">
<input type="button" value="Prior" name="prevrecord" style=" width: 84; height: 25" onClick="button_job(document.test.prevrecord.name);submit()">
</td>
      <td width="16%" height="32" valign="baseline" align="center">
<input type="button" value="Next " name="nextrecord" style=" width: 84; height: 25" onClick="button_job(document.test.nextrecord.name);submit()" >
</td>
      <td width="15%" height="32" valign="baseline" align="center">
<input type="button" value="Bottom" name="bottombutton" style=" width: 84; height: 25" onclick = "button_job(document.test.bottombutton.name);submit()">
</td>
      <td width="15%" height="32" valign="baseline" align="center">
 <input type="submit" value="Goto" name="gotobutton" style=" width: 84; height: 25" onclick = "goto_window();button_job(document.test.gotobutton.name);submit()">
</td>
      <td width="16%" height="32" valign="baseline" align="center">
<input type="button" value="Exit" name="exitbutton" style=" width: 84; height: 25">
</td>
    </tr>
  </table>
   </form>
</body>
</html>