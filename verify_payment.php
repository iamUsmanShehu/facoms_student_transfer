<?php
include("includes/config.php");// Database connection

if (!$_SESSION['id']){
    header("location: login");
}
  $reference = $_GET['reference'];
  $student_id =  $_SESSION['id']; //applicant ID

  if ($reference == "") {
    header("location: payment");
  }
  $curl = curl_init();
  
  curl_setopt_array($curl, array(
    CURLOPT_URL => "https://api.paystack.co/transaction/verify/" . rawurlencode($reference),
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => array(
      "Authorization: Bearer sk_test_8485ab180c68a902d4b959682d847be732d82dff",
      "Cache-Control: no-cache",
    ),
  ));
  
  $response = curl_exec($curl);
  $err = curl_error($curl);

  curl_close($curl);
  
  if ($err) {
    echo "cURL Error #:" . $err;
  } else {
    // echo $response;
    $response = json_decode($response, true);

    if ($response["data"]["status"] == "success") {

    $message = $response['message'];
    $status = $response["data"]['status'];
    $reference = $response["data"]['reference'];
    $amount = $response["data"]['amount'];
    $paid_at = $response["data"]['paid_at'];
    $channel = $response["data"]['channel'];
    $currency = $response["data"]['currency'];
    $ip_address = $response["data"]['ip_address'];
    $fixed_amount = 2500;
 if (($amount / 100) == $fixed_amount ) {
             
    // Prepare the SQL query
    $query = "INSERT INTO payments (student_id, message, status, reference, amount, paid_at, channel, currency, ip_address) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $query);

    if ($stmt) {
        // Bind the parameters and execute the query
        mysqli_stmt_bind_param($stmt, "isssdssss", $student_id, $message, $status, $reference, $amount, $paid_at, $channel, $currency, $ip_address);

        if (mysqli_stmt_execute($stmt)) {
            // Payment data inserted successfully
           
            header("location: acknowledgment_slip");
            
        } else {
            // Error handling if the query execution fails
            echo "Error: " . mysqli_error($conn);
        }

        // Close the prepared statement
        mysqli_stmt_close($stmt);
    } else {
        // Error handling if the statement preparation fails
        echo "Error: " . mysqli_error($conn);
    }
    
  }else {
    header("refresh:3; incomplete_payment");
  }
    // Close the database connection
    mysqli_close($conn);
  }
    }
?>


<!-- "As a Backend Developer with a passion for Data Analysis and proficiency in SQL, I specialize in creating robust and efficient server-side solutions. My expertise lies in designing and implementing back-end systems that power data-driven applications, ensuring seamless performance and data accuracy. I'm dedicated to leveraging data insights to drive strategic decisions and enhance user experiences. Let's connect and explore opportunities at the intersection of technology and data!" -->