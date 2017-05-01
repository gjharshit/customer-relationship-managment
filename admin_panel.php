<?php
	// Start the session
	session_start();
	ob_start();

	if (!isset($_SESSION['user'])) {
		header("Location: index.php");
	}
?>

<!DOCTYPE html>
<html lang="en-US">
<head>
  <meta http-equiv="Content-Type" content="text/html;charset=utf-8">
  <title>Admin Panel</title>
  <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
  <link rel="stylesheet" type="text/css" media="all" href="css/admin_panel.css">
  <link href="https://fonts.googleapis.com/css?family=Josefin+Sans:400,400i,700,700i" rel="stylesheet">
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
</head>

<body>
	<h1 style="position: relative; left: 40%; font-weight: bold; font-size: 40px; margin-top: 10px;">Yashasvi Information Solutions</h1>
	<p style="position: relative; left: 50%; font-size: 30px;">Admin Panel</p>
  <div id="w">
    <!-- <img id="head_logo" src="images/company-logo.png" alt="company-logo" /> -->
    <nav id="navigation">
      <ul>
        <li><a href="customer_po.php">Customer PO Form</a></li>
        <li><a href="yashasvi_po.php">Yashasvi PO Form</a></li>
        <li><a href="search_customer.php">Search Customer DB</a></li>
        <li><a href="search_yashasvi.php">Search Yashasvi DB</a></li>
        <li><a href="download_list_customer.php">Download Customer Files</a></li>
        <li><a href="download_list_yashasvi.php">Download Yashasvi Files</a></li>
        <li><a href="customer_table_snapshot.php">Customer Table Snapshot</a></li>
        <li><a href="yashasvi_table_snapshot.php">Yashasvi Table Snapshot</a></li>
		<li><a href="send_mail.php">Trigger Mail</a></li>
		<li><a href="logout.php?logout">Sign Out</a></li>
      </ul>
    </nav>

    <div id="content">
	<br>
    <h1>Brief Documentation.</h1>
    </div></div>
	<br><br><br><br><br><br>
	</body>
</html>

<?php
	define("DB_SERVER", "localhost");
	define("DB_USER", "root");
	define("DB_PASS", "");
	define("DB_NAME", "yashasvi_orders");

    // 1. Create a database connection
    $connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
    // Test if connection succeeded
    if(mysqli_connect_errno()) {
        die("Database connection failed: " .
        mysqli_connect_error() . " (" . mysqli_connect_errno() . ")"
        );
    }

	// 2. Write the required query
	$advance_query = "SELECT payment_mode FROM customer_po ";
	$advance_query .= "WHERE payment_mode LIKE 'advance'";
	$advance_result = mysqli_query($connection, $advance_query);
	// print_r($advance_result->num_rows);

	$against_delivery_query = "SELECT payment_mode FROM customer_po ";
	$against_delivery_query .= "WHERE payment_mode LIKE 'against_delivery'";
	$against_delivery_result = mysqli_query($connection, $against_delivery_query);
	// print_r($against_delivery_result->num_rows);

	$thirty_query = "SELECT payment_mode FROM customer_po ";
	$thirty_query .= "WHERE payment_mode LIKE '30_days'";
	$thirty_result = mysqli_query($connection, $thirty_query);
	// print_r($thirty_result->num_rows);

	$forty_five_query = "SELECT payment_mode FROM customer_po ";
	$forty_five_query .= "WHERE payment_mode LIKE '45_days'";
	$forty_five_result = mysqli_query($connection, $forty_five_query);
	// print_r($forty_five_result->num_rows);

	$sixty_query = "SELECT payment_mode FROM customer_po ";
	$sixty_query .= "WHERE payment_mode LIKE '60_days'";
	$sixty_result = mysqli_query($connection, $sixty_query);
	// print_r($sixty_result->num_rows);

	$other_query = "SELECT payment_mode FROM customer_po ";
	$other_query .= "WHERE payment_mode LIKE 'other'";
	$other_result = mysqli_query($connection, $other_query);
	// print_r($other_result->num_rows);

    // 3. Close connection to the database
	if (isset($connection)) { mysqli_close($connection); }
?>

<html>
<body>

</body>
</html>

<html>
  <head>
    <!--Load the AJAX API-->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
	    <script type="text/javascript">

	      // Load the Visualization API and the controls package.
	      google.charts.load('current', {'packages':['corechart', 'controls']});

	      // Set a callback to run when the Google Visualization API is loaded.
	      google.charts.setOnLoadCallback(drawDashboard);

	      // Callback that creates and populates a data table,
	      // instantiates a dashboard, a range slider and a pie chart,
	      // passes in the data and draws it.
	      function drawDashboard() {

	        // Create our data table.
	        var data = google.visualization.arrayToDataTable([
	          ['Billing Type', 'Payment Mode Count'],
	          ['Advance', <?php echo $advance_result->num_rows; ?>],
	          ['Against Delivery' , <?php echo $against_delivery_result->num_rows; ?>],
	          ['30 Days', <?php echo $thirty_result->num_rows; ?>],
	          ['45 Days', <?php echo $forty_five_result->num_rows; ?>],
	          ['60 Days', <?php echo $sixty_result->num_rows; ?>],
	          ['Other', <?php echo $other_result->num_rows; ?>]
	        ]);

	        // Create a dashboard.
	        var dashboard = new google.visualization.Dashboard(
	            document.getElementById('dashboard_div'));

	        // Create a range slider, passing some options
	        var paymentRangeSlider = new google.visualization.ControlWrapper({
	          'controlType': 'NumberRangeFilter',
	          'containerId': 'filter_div',
	          'options': {
	            'filterColumnLabel': 'Payment Mode Count',
				'fontName': 'Josefin Sans',
				'fontSize': 20
	          }
	        });

	        // Create a pie chart, passing some options
	        var pieChart = new google.visualization.ChartWrapper({
	          'chartType': 'PieChart',
	          'containerId': 'chart_div',
	          'options': {
	            'width': 700,
	            'height': 400,
	            'pieSliceText': 'value',
				'fontName': 'Josefin Sans',
				'fontSize': 20,
				'title': 'Various Payment Modes (of Customer)'
	          }
	        });

	        // Establish dependencies, declaring that 'filter' drives 'pieChart',
	        // so that the pie chart will only display entries that are let through
	        // given the chosen slider range.
	        dashboard.bind(paymentRangeSlider, pieChart);

	        // Draw the dashboard.
	        dashboard.draw(data);
		}
		</script>

	<!-- The bar chart being rendered -->
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  	<script type="text/javascript">
	    google.charts.load("current", {packages:['corechart']});
	    google.charts.setOnLoadCallback(drawChart);
	    function drawChart() {
	      var data = google.visualization.arrayToDataTable([
	        ["Billing Type", "Payment Mode Count", { role: "style" } ],
	        ["Advance", <?php echo $advance_result->num_rows; ?>, "#b87333"],
	        ["Against Delivery", <?php echo $against_delivery_result->num_rows; ?>, "silver"],
	        ["30 Days", <?php echo $thirty_result->num_rows; ?>, "gold"],
	        ["45 Days", <?php echo $forty_five_result->num_rows; ?>, "color: #e5e4e2"]
	        ["60 Days", <?php echo $sixty_result->num_rows; ?>, "color: pink"]
	        ["Other", <?php echo $other_result->num_rows; ?>, "color: blue"]
	      ]);

	      var view = new google.visualization.DataView(data);
	      view.setColumns([0, 1,
	                       { calc: "stringify",
	                         sourceColumn: 1,
	                         type: "string",
	                         role: "annotation" },
	                       2, 3, 4, 5, 6, 7]);

	      var options = {
	        title: "Density of Precious Metals, in g/cm^3",
	        width: 600,
	        height: 400,
	        bar: {groupWidth: "95%"},
	        legend: { position: "none" },
			fontName: 'Josefin Sans'
	      };
	      var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values"));
	      chart.draw(view, options);
	  	}
  	</script>
	  </head>

	  <body>
	    <div id="dashboard_div" style="position: relative; left: 40%;">
		    <!--Divs that will hold each control and chart-->
		    <div id="filter_div"></div>
		    <div id="chart_div"></div>
	    </div>
		<!-- <div id="columnchart_values" style="width: 900px; height: 300px; position: relative; left: 20%; float: left;"></div> -->
	  </body>
	</html>
