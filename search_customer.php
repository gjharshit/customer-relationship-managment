<?php
    // Start the session_start
    session_start();
    ob_start();

    if (!isset($_SESSION['user'])) {
        header("Location: index.php");
    }
?>

<!DOCTYPE html>
<html>
<head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Search Customer</title>
      <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
      <link href="https://fonts.googleapis.com/css?family=Josefin+Sans:400,400i,700,700i" rel="stylesheet">
      <link rel="stylesheet" href="css/main.css">
      <link rel="stylesheet" href="css/datepicker.css">
      <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
      <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js"></script>
      <script type="text/javascript">
        $(document).ready(function(){
          $("#datepicker").datepicker({dateFormat : 'yy-mm-dd'});
        });
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

    <form action="search_customer_results.php" method="post">
      <h1>Filter your Search</h1>
      <fieldset>
        <legend>Select or Enter the Customer paramters you want to filter with respect to:</legend>
        <label for="name">Company Name:</label>
        <input type="text" id="name" name="comp_name" />

        <label for="city">City Name:</label>
        <input type="text" id="city" name="city" />

        <label for="fin_contact_person">Name of Finance Contact Person:</label>
        <input type="text" id="fin_contact_person" name="fin_contact_person" />

        <label for="yash_inv_number">Yashasvi Invoice Number:</label>
        <input type="text" id="yash_inv_number" name="yash_inv_number">

        <label for="yash_inv_value">Yashasvi Invoice Value:</label>
        <input type="text" id="yash_inv_value" name="yash_inv_value">
      </select>

      </fieldset>

      <button type="submit" name="submit" id="submit">Submit</button>
    </form>

  </body>
</html>
