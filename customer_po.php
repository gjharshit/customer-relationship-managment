<?php
	// Start the session
	session_start();
	ob_start();

	if (!isset($_SESSION['user']) || $_SESSION['user'] == "") {
        header("Location: index.php");
    }
	// Include the header file at the beginning of the page
	// include_once '../includes/header.php';
?>
<!DOCTYPE html>
<html>
<head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Customer PO Form</title>
	  <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
      <link href="https://fonts.googleapis.com/css?family=Josefin+Sans:400,400i,700,700i" rel="stylesheet">
      <link rel="stylesheet" href="css/main.css">
      <link rel="stylesheet" href="css/datepicker.css">
      <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
      <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/jquery-ui.min.js"></script>
      <script type="text/javascript">
        $(document).ready(function(){
          $("#datepicker1").datepicker({dateFormat : 'yy-mm-dd'});
          $("#datepicker2").datepicker({dateFormat : 'yy-mm-dd'});
        });
      </script>
      </script>
  </head>

	<style type="text/css">
		ul, li {
			display: inline;
			cursor: pointer;
			position: relative;
			top: 8%;
		}
		div.common_header {
			margin-top: 10px;
			margin-bottom: 20px;
			position: relative;
			background-color: #660066;
			color: white;
			width: 46%;
            left: 27.5%;
            height: 35px;
			border-radius: 25px;
		}
        #admin_panel,
        #customer_po,
        #yashasvi_po,
        #search_customer,
        #search_yashasvi,
        #logout {
            color: white;
            text-decoration: none;
        }
        #admin_panel,
        #customer_po,
        #yashasvi_po,
        #search_customer,
        #search_yashasvi,
        #logout {
			color: #ffe6ff;
		}
	</style>

  <body>
	<div class="common_header">
		<ul>
            <li><a id="admin_panel" href="admin_panel.php">Admin Panel | </a></li>
			<li><a id="customer_po" href="customer_po.php">Customer PO Details | </a></li>
			<li><a id="yashasvi_po" href="yashasvi_po.php">Yashasvi PO Details | </a></li>
			<li><a id="search_customer" href="search_customer.php">Search Customer DB | </a></li>
			<li><a id="search_yashasvi" href="search_yashasvi.php">Search Yashasvi DB | </a></li>
			<li><a id="logout" href="logout.php?logout">Sign Out</a></li>
		</ul>
	</div>
	<script type="text/javascript" src="javascript/header.js"></script>

    <form action="customer_po_entry.php" method="post" enctype="multipart/form-data" id="customer_po_form">
      <h1>Customer PO Details</h1>
      <fieldset>
        <legend><span class="number">1</span>Enter Basic Information</legend>
        <label for="name">Company Name:</label>
        <input type="text" id="name" name="comp_name" required/>

        <label for="comp_address">Company Address:</label>
        <textarea id="comp_address" name="comp_address" style="height: 100px; required"></textarea>

        <label for="city">City Name:</label>
        <input type="text" id="city" name="city" required />

        <label for="pincode">Pincode:</label>
        <input type="text" id="pincode" name="pincode" required />

        <label for="fin_contact_person">Name of Finance Contact Person:</label>
        <input type="text" id="fin_contact_person" name="fin_contact_person" required />

        <label for="phone">Phone Number:</label>
        <input type="text" id="phone" name="phone" required />

        <label for="mail">Email:</label>
        <input type="email" id="mail" name="email" required />

        <label for="other">Enter other details:</label>
        <input type="text" id="other" name="other" required />
      </fieldset>

      <fieldset>
        <legend><span class="number">2</span>Product and Billing Details</legend>

        <label for="order_value">Order Value:</label>
        <input type="text" id="order_value" name="order_value" required />

        <label for="purchase_value">Purchase Value:</label>
        <input type="text" id="purchase_value" name="purchase_value" required />

        <label for="margin">Margin:</label>
        <input type="text" id="margin" name="margin" required />

        <label for="billing_type">Select Billing Type:</label>
        <select name="billing_type" id="billing_type" required>
            <option value="vat">VAT</option>
            <option value="st">ST</option>
            <option value="vat_st">VAT + ST</option>
            <option value="cst">CST</option>
            <option value="cst_st">CST + ST</option>
            <option value="gst">GST</option>
        </select>

        <label for="payment_due">Payment due on (Customer -> Yashasvi):</label>
        <input type="text" id="datepicker1" name="cust_yash_date" required />

        <label for="payment_mode">Select Payment Mode:</label>
        <select name="payment_mode" id="payment_mode" required>
            <option value="advance">Advance</option>
            <option value="against_delivery">Against Delivery</option>
            <option value="30_days">30 Days</option>
            <option value="45_days">45 Days</option>
            <option value="60_days">60 Days</option>
            <option value="other">Other</option>
        </select>
    </fieldset>

    <fieldset>
        <legend><span class="number">3</span>Invoice Details</legend>
            <label for="yash_inv_number">Yashasvi Invoice Number:</label>
            <input type="text" id="yash_inv_number" name="yash_inv_number" required>

            <label for="yash_inv_value">Yashasvi Invoice Value:</label>
            <input type="text" id="yash_inv_value" name="yash_inv_value" required>

            <label for="yash_inv_date">Yashasvi Invoice Date:</label>
            <input type="text" id="datepicker2" name="yash_inv_date" required>

            <label for="remarks">Additional Remarks:</label>
            <textarea id="remarks" name="remarks" style="height: 100px;" required></textarea>
    </fieldset>

    <fieldset>
        <legend><span class="number">4</span>Attachments</legend>
            <label for="yash_inv">Attach a copy of the Customer PO here (must be a .pdf file):</label>
            <input type="file" id="attach_cust_po" name="attach_cust_po" required />

            <label for="yash_inv">Attach a copy of the Customer Quotation here (must be a .jpg/.png/.jpeg file):</label>
            <input type="file" id="attach_cust_quote" name="attach_cust_quote" required />
    </fieldset>

      <button type="submit" name="submit" id="submit">Submit</button>
    </form>

  </body>
</html>
