<?php

// database host, usually localhost
$host = "localhost";

// database username
$user = "postgres";

// database password
$pass = "";

// database name
$database = "riverine";

// Email account for receiving orders
$receipt = "root@riverine.org";

// Cost of shipping in format 59.00. If not used = 0
$add_shipping = "59.00";



if ($conn==abs(1))
        {
          echo "we are connected";
        }
else
        {
                $conn = pg_connect("host=$host dbname=$database user=$user");
                //echo $conn;
                //$checking="true";
                //echo "shamim";
                //echo pg_DBname($conn);

        }

//   Texts, Translations General
$txt_qty ="QTY";
$txt_art_no ="Art No";
$txt_item ="Item";
$txt_option ="Option";
$txt_price ="Price";
$txt_order ="Order";
$txt_add ="Add";
$txt_sub_total="Sub Total";
$txt_shipping ="Shipping";
$txt_tax="Tax";
$txt_total ="Total";
$txt_shopping_cart = "View Cart";
$txt_cart = "Shopping Cart";
$txt_order_form  = "Checkout";
$txt_shopping_meny    = "Products";
$txt_your_cart = "Your Shopping Cart";
$txt_empty_shopping_cart    = "Empty Shopping Cart";
$txt_shopping_cart_empty    = "Your shopping cart is empty!";
$txt_reset_shopping_cart    = "Reset shopping cart";
$txt_continue_shopping   = "Continue Shopping";
$txt_remove    = "Remove";
$txt_wrong_quantity   = "Wrong quantity";
$txt_update    = "Update";
$txt_select_field    = "Select field";
$txt_search    = "Search Engine";
$txt_go    = "Search";
$txt_accounttype  = "Account Type";
$txt_accountname  = "Account Name";
$txt_text    = "Text";
$txt_backwards   = "Backwards";
$txt_home    = "Home";
$txt_copyright   = " Copyright TechnoDome (PPT). All rights reserved";

//   Texts, Translations in order form
$txt_email   = "Email";
$txt_name    = "Name";
$txt_company   = "Company";
$txt_address    = "Address";
$txt_address2   = "Address2";
$txt_city   = "City";
$txt_state_province    = "State/Province";
$txt_zip   = "Zip";
$txt_country    = "Country";
$txt_phone   = "Phone";
$txt_comment    = "Comment";
$txt_checkout   = "Checkout";
$txt_reset    = "Reset";

$txt_missing_email   = "Please enter your e-mail account!";
$txt_missing_chequeno   = "Please enter Cheque No.";
$txt_missing_chequedate   = "Please enter Cheque Date";
$txt_missing_bankbranch   = "Please enter Branch Name";
$txt_missing_receivedate   = "Please enter Receive Date";
$txt_missing_payserial   = "Please enter Serial No.....You Have To generate it by Choosing a ship name";
$txt_missing_voucherdate   = "Please enter Voucher Date";
$txt_missing_matname = "Please Enter A Material Name!";
$txt_missing_fromlocname = "Please Enter From Location Name";
$txt_missing_tolocname = "Please Enter To Location Name";
$txt_missing_vouchername = "Please Enter A Voucher Nomber!";
$txt_missing_paytype = "Please Select A Payment Mode!";
$txt_missing_payamount = "Please Enter An Amount!";
$txt_missing_takarate = "Please Enter The Fair Rate!";
$txt_missing_locname = "Please Enter A Location Name!";
$txt_missing_bankname   = "Please Enter Bankname";
$txt_step1   = "Step 1";
$txt_step2   = "Step 2";
$txt_personal_information   = "Enter your personal information";
$txt_credit_card_payment   = "Secure Credit Card Payment";
$txt_submit   = "Submit";
$txt_credit_card_info   = "Enter your credit card information";
$txt_secure_payment_sucessfull   = "Sucessfull Payment";
$txt_date = "Date";
$txt_order_id  = "Order ID";
$txt_shipping_method   = "Shipping Method";
$txt_payment_method   = "Payment Method";
$txt_continue  = "Continue";
$txt_payment_information = "Payment Information";
$txt_credit_card = "CreditCard";
$txt_exp_date = "ExpDate";
$txt_amount  = "Amount";
$txt_missing_credit_card = "Please enter your credit card number!";
$txt_missing_expmo = "Please enter your credit card expiry month!";
$txt_missing_expyr = "Please enter your credit expiry year!";


//   Texts, Translations in shop admin
$txt_unique   = "Must be unique";
$txt_image   = "Image";
$txt_added_to_database = "added to database ";
$txt_reload   = "Reload";
$txt_save   = "Save";
$txt_remove   = "Remove";
$txt_removed  = "is removed from the database";
$txt_new_item   = "Add new item";
$txt_advanced   = "Advanced";
$txt_upload_image   = "Upload image";
$txt_upload  = "Upload";
$txt_updated  = "is updated";
$txt_uploaded  = "uploaded";
$txt_upload_ok  = "Upload OK!";
$txt_no_file = "No file";
$txt_file_error = "File upload error";
$txt_close_window = "Close window";
$txt_credit_card_payment = "Credit Card Payment";

$txt_missing_takarate   = "Please enter First Material Fair Rate ";
$txt_missing_takaratetwo   = "Please enter Second Material Fair Rate ";
$txt_missing_accounttype   = "Please enter an Account Type !";
$txt_missing_accountname   = "Please enter an Account Name !";
$txt_missing_officeaddress   = "Please enter Account's Office Address !";
$txt_missing_shipname   = "Please Enter A Ship Name!";
$txt_missing_shipowner   = "Please Enter Ship Owner's Name!";
$txt_missing_image   = "Please enter a image for this item!";
$cfgBorder      			= "0";
$cfgThBgcolor				= "#D3DCE3";
$cfgBgcolorOne				= "#CCCCCC";
$cfgBgcolorTwo				= "#DDDDDD";


$coloralternator = "";


function button_print() {

print ( "<table border=\"0\" width=\"92%\" height=\"83\">
    <tr>
      <td width=\"14%\" height=\"43\" valign=\"baseline\" align=\"center\">
<input type=\"button\" value=\"Add\" name=\"addbutton\" style=\" width: 84; height: 25\" onclick=\"reset();button_job(document.test.addbutton.name);add_edit_press('addedit')\"  ></td>
      <td width=\"15%\" height=\"43\" valign=\"baseline\" align=\"center\">
<input type=\"button\" value=\"Edit\" name=\"editbutton\" style=\"width: 84; height: 25\" onclick=\"button_job(document.test.editbutton.name);add_edit_press('addedit')\"></td>
      <td width=\"16%\" height=\"43\" valign=\"baseline\" align=\"center\">
<input type=\"button\"  value=\"View\" name=\"viewbutton\" style=\"width: 84; height: 25\" onclick = \"view_record()\"></td>
      <td width=\"15%\" height=\"43\" valign=\"baseline\" align=\"center\">
<input type=\"button\" value=\"Delete\" name=\"deletebutton\" style=\" width: 84; height: 25\" onclick = \"button_job(document.test.deletebutton.name);del_confirm()\"></td>
      <td width=\"15%\" height=\"43\" valign=\"baseline\" align=\"center\">
<input type=\"submit\" value=\"Save\" name=\"savebutton\" style=\" width: 84; height: 25\" >
      <td width=\"16%\" height=\"43\" valign=\"baseline\" align=\"center\">
<input type=\"reset\" value=\"Cancel\" name=\"cancelbutton\" style=\" width: 84; height: 25\" onclick = \"button_job(document.test.cancelbutton.name)\"></td></td>
    </tr>
    <tr>
      <td width=\"14%\" height=\"32\" valign=\"baseline\" align=\"center\">
<input type=\"button\" value=\"Top\" name=\"topbutton\" style=\" width: 84; height: 25\" onclick = \"button_job(document.test.topbutton.name);submit()\"></td>
      <td width=\"15%\" height=\"32\" valign=\"baseline\" align=\"center\">
<input type=\"button\" value=\"Prior\" name=\"prevrecord\" style=\" width: 84; height: 25\" onClick=\"button_job(document.test.prevrecord.name);submit()\">
</td>
      <td width=\"16%\" height=\"32\" valign=\"baseline\" align=\"center\">
<input type=\"button\" value=\"Next \" name=\"nextrecord\" style=\" width: 84; height: 25\" onClick=\"button_job(document.test.nextrecord.name);submit()\" >
</td>
      <td width=\"15%\" height=\"32\" valign=\"baseline\" align=\"center\">
<input type=\"button\" value=\"Bottom\" name=\"bottombutton\" style=\" width: 84; height: 25\" onclick = \"button_job(document.test.bottombutton.name);submit()\">
</td>
      <td width=\"15%\" height=\"32\" valign=\"baseline\" align=\"center\">
 <input type=\"button\" value=\"Goto\" name=\"gotobutton\" style=\" width: 84; height: 25\" onclick = \"button_job(document.test.gotobutton.name);goto_window()\">
</td>
      <td width=\"16%\" height=\"32\" valign=\"baseline\" align=\"center\">
<input type=\"button\" value=\"Print\" name=\"printbutton\" style=\" width: 84; height: 25\" onclick = \"print_record()\" >
</td>
    </tr>
  </table> ");

}




function navforview_button_print() {

print ( "<table border=\"0\" width=\"100%\" height=\"36\">

    <tr>
      <td width=\"14%\" height=\"32\" valign=\"baseline\" align=\"center\">
<input type=\"button\" value=\"Top Page\" name=\"topbutton\" style=\" width: 120; height: 30\" onclick = \"navforview_button_job(document.test.topbutton.name);submit()\"></td>
      <td width=\"14%\" height=\"32\" valign=\"baseline\" align=\"center\">
<input type=\"button\" value=\"Prior Page\" name=\"prevrecord\" style=\" width: 120; height: 30\" onClick=\"navforview_button_job(document.test.prevrecord.name);submit()\">
</td>
      <td width=\"14%\" height=\"32\" valign=\"baseline\" align=\"center\">
<input type=\"button\" value=\"Next Page\" name=\"nextrecord\" style=\" width: 120; height: 30\" onClick=\"navforview_button_job(document.test.nextrecord.name);submit()\" >
</td>
      <td width=\"14%\" height=\"32\" valign=\"baseline\" align=\"center\">
<input type=\"button\" value=\"Bottom Page\" name=\"bottombutton\" style=\" width: 120; height: 30\" onclick = \"navforview_button_job(document.test.bottombutton.name);submit()\">
</td>
      <td width=\"14%\" height=\"32\" valign=\"baseline\" align=\"center\">
 <input type=\"button\" value=\"Goto Page\" name=\"gotobutton\" style=\" width: 120; height: 30\" onclick = \"navforview_button_job(document.test.gotobutton.name);navforview_goto_window()\">
</td>

<td width=\"14%\" height=\"32\" valign=\"baseline\" align=\"center\">
 <input type=\"button\" value=\"Search\" name=\"searchbutton\" style=\" width: 120; height: 30\" onclick = \"navforview_button_job(document.test.searchbutton.name);navforview_search_window()\">
</td>

<td width=\"14%\" height=\"32\" valign=\"baseline\" align=\"center\"> 
<input type=\"button\" value=\"Exit\" name=\"exitbutton\" style=\" width: 120; height: 30\" onclick= \"set_main()\"> 

    </tr>
  </table> ");

}





function normal_payment_data()
						{
                                        		$voucherid = $row[0];
                                        		$voucherdate = $row[1];
                                        		$payserial = $row[2];

                                        		// Following are the name of the values
                                        		$accountname = $row[4];
                                        		$nameofship = $row[6];
                                        		$fromlocname = $row[8];
                                        		$tolocname = $row[10];
                                        		$matonename = $row[12];
                                        		$mattwoname = $row[14];

                                        		// Follwing are the values
                                        		$clientname = $row[3];
                                        		$shipname = $row[5];
                                        		$fromloc = $row[7];
                                        		$toloc = $row[9];
                                        		$matone = $row[11];
                                        		$mattwo = $row[13];
                                        		$payamount = $row[15];                                                                           
                                        		$paytype = $row[16];                                        
                                        		$bankname = $row[17];
                                        		$bankbranch = $row[18];
							$chequeno = $row[19];
                                        		$chequepaydate = $row[20];
							$comment = $row[21];
							$tkrate =$row[23];
							$partoradvance = $row[24];
                                        		$departuredate = $row[25];
							$paylocation = $row[26];
							$through = $row[27];
							$shiptripid = $row[28];
							$tkratetwo =$row[29];
						}






















?>
