<?php
    require 'libs/vendor/autoload.php';
    include 'config/config.php';
    session_start();

    if (!isset($_SESSION['admin_id'])) {
        echo '<meta http-equiv="refresh" content="0; url= login.php">';
    }

    use Zxing\QrReader;
    $errors = array();

    if(isset($_POST['submit'])){

        $qr_image = $_FILES['qr_image']['name'];
    
        $qr = new QrReader('images/'.$qr_image);
        $text = $qr->text();

        $check_qrcode = "SELECT * FROM stock WHERE qr_code = '$text' LIMIT 1";
        $result = mysqli_query($conn, $check_qrcode);
        $row = mysqli_fetch_assoc($result);

        if (!empty($row)) {

            echo '<meta http-equiv="refresh" content="0; url= single-stock.php?id='.$row['stock_id'].'">';
        }else {

            array_push($errors, "Stock Does not exist.");
        }
    }
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="PhiLander">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="libs/webcamjs/webcam.min.js"></script>
    <link href="css/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <title>Stock Management System</title>
</head>
<body>
    <?php
      include 'header.php';
    ?>
    <div class="container">
        <div class="heading-text">
            <h3>Scan</h3>
            <p>scan the QR code by uploading an image of the QR code from stock-management-system/images/</p>
        </div>
        <form action="" method="post" class="form" enctype="multipart/form-data">
            <input type="file" name="qr_image" required>
            <?php 
				if (count($errors) > 0){
				    foreach ($errors as $error){
				        echo '<small style="color: cyan">'.$error.'</small><br><br>';   
                    }
                }
			?>
            <button type="submit" name="submit"><i class="fa fa-qrcode"></i> Scan</button>
        </form>
    </div>
</body>
</html>