<?php
	// Start the session
	session_start();
	ob_start();
?>

<!DOCTYPE html>
<head>
	<title>Customer PO Entry Confirmation</title>
</head>

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

    if (isset($_POST['submit'])) {
	    // Process the form

        // Data coming from basic information
		$comp_name = $_POST["comp_name"];
		// Set comp_name as a session variable
		$_SESSION["comp_name"] = $comp_name;
        $comp_address = $_POST["comp_address"];
        $city = $_POST["city"];
        $pincode = $_POST["pincode"];
        $fin_contact_person = $_POST["fin_contact_person"];
        $phone = $_POST["phone"];
        $email = $_POST["email"];
        $other = $_POST["other"];

        // Data coming from product and billing details
        $order_value = $_POST["order_value"];
        $purchase_value = $_POST["purchase_value"];
        $margin = $_POST["margin"];
        $billing_type = $_POST["billing_type"];
        $cust_yash_date = $_POST["cust_yash_date"];
        $payment_mode = $_POST["payment_mode"];

        // Data coming from invoice details
        $yash_inv_number = $_POST["yash_inv_number"];
		// Set yash_inv_number as a session variable
		$_SESSION["yash_inv_number"] = $yash_inv_number;
        $yash_inv_value = $_POST["yash_inv_value"];
        $yash_inv_date = $_POST["yash_inv_date"];
        $remarks = $_POST["remarks"];

        // Query to insert records into the database
        $query  = "INSERT INTO customer_po (";
        $query .= "comp_name, comp_address, city, pincode, fin_contact_person, phone, email, other, ";
        $query .= "order_value, purchase_value, margin, billing_type, cust_yash_date, payment_mode, yash_inv_number, ";
        $query .= "yash_inv_value, yash_inv_date, remarks";
        $query .= ") VALUES (";
        $query .= "'$comp_name', '$comp_address', '$city', '$pincode', '$fin_contact_person', '$phone', '$email', ";
        $query .= "'$other', '$order_value', '$purchase_value', '$margin', '$billing_type', '$cust_yash_date', '$payment_mode', ";
        $query .= "'$yash_inv_number', '$yash_inv_value', '$yash_inv_date', '$remarks'";
        $query .= ")";

        // 2. Query to the database
        $result = mysqli_query($connection, $query);

        if ($result) {
            // Success

            $retreive_customer = "SELECT * FROM customer_po ";
            $retreive_customer .= "WHERE yash_inv_number LIKE $yash_inv_number";
            $customer_ret_success = mysqli_query($connection, $retreive_customer);

            if ($customer_ret_success) {

                echo "<table width='100%'>";
                echo "<tr><th>Company Name</th><th>Company Address</th><th>City</th><th>Pincode</th>";
                echo "<th>Financial Contact Person</th><th>Phone</th><th>Email</th>";
                echo "<th>Other</th><th>Order Value</th><th>Purchase Value</th><th>Margin</th>";
                echo "<th>Billing Type</th><th>Cutomer_Yash Date</th><th>Payment Mode</th>";
                echo "<th>Yash Invoice Number</th><th>Yash Invoice Value</th><th>Yash Invoice Date</th><th>Remarks</th></tr>";

                $row = mysqli_fetch_array($customer_ret_success, MYSQLI_ASSOC);

                echo '<tr><td align="center">' . $row['comp_name'] . '</td><td align="left">' . $row['comp_address'] . '</td>';
                echo '<td align="center">' . $row['city'] . '</td><td align="left">' . $row['pincode'] . '</td>';
                echo '<td align="center">' . $row['fin_contact_person'] . '</td><td align="left">' . $row['phone'] . '</td>';
                echo '<td align="center">' . $row['email'] . '</td><td align="left">' . $row['other'] . '</td>';
                echo '<td align="center">' . $row['order_value'] . '</td><td align="left">' . $row['purchase_value'] . '</td>';
                echo '<td align="center">' . $row['margin'] . '</td><td align="left">' . $row['billing_type'] . '</td>';
                echo '<td align="center">' . $row['cust_yash_date'] . '</td><td align="left">' . $row['payment_mode'] . '</td>';
                echo '<td align="center">' . $row['yash_inv_number'] . '</td><td align="left">' . $row['yash_inv_value'] . '</td>';
                echo '<td align="center">' . $row['yash_inv_date'] . '</td><td align="left">' . $row['remarks'] . '</td></tr>';

                echo "<link href=\"https://fonts.googleapis.com/css?family=Josefin+Sans:400,400i,700,700i\" rel=\"stylesheet\">";
                echo "<style type=\"text/css\">";
                echo "th, td { border-style: solid; border-color: black; font-family: Josefin Sans; }";
                echo "td { text-align: center; }";
                echo "</style>";
                echo "</table>";

                mysqli_free_result($customer_ret_success);
            } else {
        		// Failure
        		echo "Your query has failed.";
    			printf("Errors: %s\n", mysqli_error($connection));
    		}
        }
	}
    // 3. Close connection to the database
	if (isset($connection)) { mysqli_close($connection); }
?>

<!-- PHP script that ensures the file is uploaded correctly -->
<?php
	echo "<link href=\"https://fonts.googleapis.com/css?family=Josefin+Sans:400,400i,700,700i\" rel=\"stylesheet\">";
	echo "<style type=\"text/css\">";
	echo "html, body { font-family: Josefin Sans; text-align: center;}";
	echo "</style>";
	echo "</table>";

    $target_dir = "customer_uploads/po_uploads/";
    $target_file_po = $target_dir . basename($_FILES["attach_cust_po"]["name"]);
    $FileType_po = pathinfo($target_file_po,PATHINFO_EXTENSION);
    // Validation to check if the file is actaully a PDF
    if(isset($_POST["submit"])) {
        $check = strcmp($FileType_po, "pdf");
		if($check !== false) {
            echo "Validation:";
            echo "<b>The file uploaded is a PDF.</b>";
            echo "<br>";
        } else {
            echo "Validation:";
            echo "<b><p>The file uploaded is not a PDF.</p></b>";
            echo "<br>";
        }
    }
    // Check if file already exists
    if (file_exists($target_file_po)) {
		echo "Error:";
        echo "<b>Sorry, the file already exists.</b>";
        echo "<br>";
    }
    // Check file size
    if ($_FILES["attach_cust_po"]["size"] > 50000000) {
		echo "Error:";
        echo "<b>Sorry, your file is too large.</b>";
        echo "<br>";
    }
    // if everything is ok, try to upload file
    if (move_uploaded_file($_FILES["attach_cust_po"]["tmp_name"], $target_file_po)) {
		echo "Result:";
        echo "<b>The file ". basename( $_FILES["attach_cust_po"]["name"]). " has been uploaded.</b>";
        echo "<br>";
    } else {
        echo "<b>Sorry, there was an error uploading your file.</b>";
        echo "<br>";
    }
?>

<?php
	$target_dir = "customer_uploads/quote_uploads/";
	$target_file = $target_dir . basename($_FILES["attach_cust_quote"]["name"]);
	$uploadOk = 1;
	$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
	// Check if image file is a actual image or fake image
	if(isset($_POST["submit"])) {
	    $check = getimagesize($_FILES["attach_cust_quote"]["tmp_name"]);
	    if($check !== false) {
			echo "<br>";
	        echo "<b>File is an image - " . $check["mime"] . ".</b>";
	        $uploadOk = 1;
			echo "<br>";
	    } else {
			echo "<br>";
	        echo "File is not an image.";
	        $uploadOk = 0;
			echo "<br>";
	    }
	}
	// Check if file already exists
	if (file_exists($target_file)) {
	    echo "Sorry, file already exists.";
	    $uploadOk = 0;
		echo "<br>";
	}
	// Check file size
	if ($_FILES["attach_cust_quote"]["size"] > 50000000) {
	    echo "Sorry, your file is too large.";
	    $uploadOk = 0;
		echo "<br>";
	}
	// Allow certain file formats
	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
	&& $imageFileType != "gif" ) {
	    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
	    $uploadOk = 0;
		echo "<br>";
	}
	// Check if $uploadOk is set to 0 by an error
	if ($uploadOk == 0) {
	    echo "Sorry, your file was not uploaded.";
		echo "<br>";
	// if everything is ok, try to upload file
	} else {
	    if (move_uploaded_file($_FILES["attach_cust_quote"]["tmp_name"], $target_file)) {
	        echo "The file ". basename( $_FILES["attach_cust_quote"]["name"]). " has been uploaded.";
			echo "<br>";
			$yash_inv_number = $_SESSION["yash_inv_number"];
			$customer_po_name = basename($_FILES["attach_cust_po"]["name"]);
			$customer_quote_name = basename($_FILES["attach_cust_quote"]["name"]);
			$cust_file_query = "INSERT INTO customer_attachments (";
			$cust_file_query .= "yash_inv_number, customer_po, customer_quote, comp_name) VALUES (";
			$cust_file_query .= "'$yash_inv_number', '$customer_po_name', '$customer_quote_name', '$comp_name')";
			// echo $cust_file_query;

			define("DB_SERVER2", "localhost");
			define("DB_USER2", "root");
			define("DB_PASS2", "");
			define("DB_NAME2", "yashasvi_orders");

		    // 1. Create a database connection
		    $connection = mysqli_connect(DB_SERVER2, DB_USER2, DB_PASS2, DB_NAME2);
		    // Test if connection succeeded
		    if(mysqli_connect_errno()) {
		        die("Database connection failed: " .
		        mysqli_connect_error() . " (" . mysqli_connect_errno() . ")"
		        );
		    }

			// 2. Process the query written above
			$result = mysqli_query($connection, $cust_file_query);

			if ($result) {
				echo "Data successfully entered the database!";
			} else {
				echo "Data not entered the database. Please try again.";
			}

			// 3. Close connection to the database
			if (isset($connection)) { mysqli_close($connection); }
	    } else {
	        echo "Sorry, there was an error uploading your file.";
			echo "<br>";
	    }
	}
?>
