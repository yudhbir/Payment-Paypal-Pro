<?php
$characters = 'abcdefghijklmnopqrstuvwxyz0123456789';
$string = '';
$random_string_length = 6;
for ($i = 0; $i < $random_string_length; $i++) {
	  $string .= $characters[rand(0, strlen($characters) - 1)];
}
$_SESSION['order_id'] = $string;
$cards = array(
	array(
		'text'  => 'Visa', 
		'value' => 'VISA'
	),
	array(
		'text'  => 'MasterCard', 
		'value' => 'MASTERCARD'
	),array(
		'text'  => 'Discover Card', 
		'value' => 'DISCOVER'
	),array(
		'text'  => 'American Express', 
		'value' => 'AMEX'
	),array(
		'text'  => 'Maestro', 
		'value' => 'SWITCH'
	),array(
		'text'  => 'Solo', 
		'value' => 'SOLO'
	)
);

$months = array(
	array(
		'text'  => 'January', 
		'value' => '01'
	),
	array(
		'text'  => 'February', 
		'value' => '02'
	),
	array(
		'text'  => 'March', 
		'value' => '03'
	),
	array(
		'text'  => 'April', 
		'value' => '04'
	),
	array(
		'text'  => 'May', 
		'value' => '05'
	),
	array(
		'text'  => 'June', 
		'value' => '06'
	),
	array(
		'text'  => 'July', 
		'value' => '07'
	),
	array(
		'text'  => 'August', 
		'value' => '08'
	),
	array(
		'text'  => 'September', 
		'value' => '09'
	),
	array(
		'text'  => 'October', 
		'value' => '10'
	),
	array(
		'text'  => 'November', 
		'value' => '11'
	),
	array(
		'text'  => 'December', 
		'value' => '12'
	)
);

$year_valid = array(
	array(
		'text'  => '2004', 
		'value' => '2004'
	),
	array(
		'text'  => '2005', 
		'value' => '2005'
	),
	array(
		'text'  => '2006', 
		'value' => '2006'
	),
	array(
		'text'  => '2007', 
		'value' => '2007'
	),
	array(
		'text'  => '2008', 
		'value' => '2008'
	),
	array(
		'text'  => '2009', 
		'value' => '2009'
	),
	array(
		'text'  => '2010', 
		'value' => '2010'
	),
	array(
		'text'  => '2011', 
		'value' => '2011'
	),
	array(
		'text'  => '2012', 
		'value' => '2012'
	),
	array(
		'text'  => '2013', 
		'value' => '2013'
	),
	array(
		'text'  => '2014', 
		'value' => '2014'
	)
);

$year_expire = array(
	array(
		'text'  => '2016', 
		'value' => '2016'
	),
	array(
		'text'  => '2017', 
		'value' => '2017'
	),
	array(
		'text'  => '2018', 
		'value' => '2018'
	),
	array(
		'text'  => '2019', 
		'value' => '2019'
	),
	array(
		'text'  => '2020', 
		'value' => '2020'
	),
	array(
		'text'  => '2021', 
		'value' => '2021'
	),
	array(
		'text'  => '2022', 
		'value' => '2022'
	),
	array(
		'text'  => '2023', 
		'value' => '2023'
	),
	array(
		'text'  => '2024', 
		'value' => '2024'
	)
);
?>
<html lang="en">
  
<head>
	<title>Credit Guru Payment</title>
	<meta charset="utf-8" />
	<link href='http://fonts.googleapis.com/css?family=Lato:300,400|Lobster' rel='stylesheet' type='text/css'>
	<link href='payment_paypal/style.css' rel='stylesheet' type='text/css'>

</head>
<body>
 <header>
    <a href="<?php echo $base_url; ?>"><img class="header-img" src="<?php echo $base_url; ?>/themes/default/images/company_logo.png"></a>
  </header>

<form id="payment_form">
<div class="content" id="payment">
		<p class="intro">Fill Your Credit Card Details:</p>
		
	  <p class="inputfield"><label for="f_name">First Name:</label></p> 
	  <input type="text" name="first_name" value="<?php echo $user_leads['first_name'];?>" required readonly/>
  
		<p class="inputfield"><label for="l_name">Last Name:</label></p>   
		<input type="text" name="last_name" value="<?php echo $user_leads['last_name'];?>" required readonly/>
		
		<p class="inputfield"><label for="email">Email Address:</label></p>
		<input type="text" name="email_address" value="<?php echo $final_email_id;?>" required readonly/>
		
		<p class="inputfield"><label for="phone">Phone No:</label></p> 
		<input type="text" name="phone_no" value="<?php echo $user_leads['phone_work'];?>" required readonly/>
		
		<p class="inputfield"><label for="country">Country:</label></p> 
		<input type="text" name="country_code" value="US" required readonly/>
		
		<p class="inputfield"><label for="amount">Amount:</p>
		<input type="text" name="amount" value="100" required readonly/>
		
		<p class="inputfield"><label for="card">Card Type:</p>      
        <select name="cc_type" required>
          <?php foreach ($cards as $card) { ?>
            <option value="<?php echo $card['value']; ?>"><?php echo $card['text']; ?></option>
          <?php } ?>
        </select>
		
		<p class="inputfield"><label for="card_number">Card Number:</p>
		<input type="text" name="cc_number" value="" required/>

		<p class="inputfield"><label for="card_expiry">Card Expiry Date:</p>

        <select name="cc_expire_date_month" required class="expire_year">
          <?php foreach ($months as $month) { ?>
            <option value="<?php echo $month['value']; ?>"><?php echo $month['text']; ?></option>
          <?php } ?>
        </select>
        
        <select name="cc_expire_date_year" required class="expire_year">
          <?php foreach ($year_expire as $year) { ?>
            <option value="<?php echo $year['value']; ?>"><?php echo $year['text']; ?></option>
          <?php } ?>
        </select>
		
		<p class="inputfield"><label for="card_expiry">Card Security Code (CVV2):</p>
		<input type="text" name="cc_cvv2" value="123" size="3" required/>
    
		<div style="display:none;">
		  <p>Card Issue Number:</p>
		  <input type="text" name="cc_issue" value="" size="1" required/>
			(for Maestro and Solo cards only)
		</div>
   
	<input type="hidden" name="leads_ids" value="<?php echo $lead_id;?>">
</div>
<div class="buttons">
  <div class="right">
    <input type="button" value="Pay With Card" id="button-confirm" class="button" />
  </div>
</div>
</form>
<footer>
		<p class="footer" style="font-size: 17px;">Copyrighted 2016. All rights reserved in CreditguruCrm.</a></p>
</footer>
<style>
.show_message{ position: relative; color: #ff0000;  vertical-align: middle;  padding: 12px; width: 350px;}
</style>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.15.0/jquery.validate.min.js"></script>
<script type="text/javascript"><!--
$(document).ready(function(){
// $('#button-confirm').bind('click', function() {	
// if($("#payment_form").valid()){alert("done")}else{alert("no deone")}
// });

$('#button-confirm').bind('click', function() {
	$.ajax({
		url: 'payment_paypal/process.php',
		type: 'post',
		data: $('#payment :input'),
		dataType: 'json',		
		beforeSend: function() {
			$('#button-confirm').attr('disabled', true);
			$('#button-confirm').after('<div class="show_message"><img src="payment_paypal/loader.gif" alt="" />Please wait!........</div>');
		},
		complete: function() {
			$('#button-confirm').attr('disabled', false);
			$('.attention').remove();
			$('.show_message').remove();
		},				
		success: function(json) {
			if (json['error']) {
				alert(json['error']);
				$('.show_message').remove();
			}

			if (json['success']) {
				location = json['success'];
			}
		}
	});
});
});
//--></script> 
		
  
  </body>
</html>