<?php
    include 'libs/phpqrcode/qrlib.php';
    include 'config/config.php';
    session_start();

    if (!isset($_SESSION['admin_id'])) {
        echo '<meta http-equiv="refresh" content="0; url= login.php">';
    }

    $errors = array();
    if(isset($_POST['submit'])){

        $stock_name = mysqli_real_escape_string($conn, $_POST['stock_name']);
        $stock_quantity = mysqli_real_escape_string($conn, $_POST['stock_quantity']);

        $check_stock = "SELECT * FROM stock WHERE stock_name = '$stock_name'";
        $result = mysqli_query($conn, $check_stock);
        $row = mysqli_fetch_assoc($result);

        if (!empty($row)) {

            array_push($errors, "Stock Already Exist");
        }else {

            $qr_code = strtolower($stock_name).date('dmy-His');
            $temp_dir = "images";
            $qr_image_name = strtolower($stock_name).'_'.date('dmyHis').'.png';
            $qr_image_path = $temp_dir.'/'.$qr_image_name;
    
            QRcode::png($qr_code, $qr_image_path);

            $ins_stock = "INSERT INTO stock (stock_name, stock_quantity, qr_code, qr_image)
            VALUES ('$stock_name', '$stock_quantity', '$qr_code', '$qr_image_name')";
            mysqli_query($conn, $ins_stock);
            echo mysqli_error($conn);

            array_push($errors, "Stock Added Successfully.");
?>
            <script type="text/javascript">window.location.replace('<?php echo $qr_image_path ?>', '_blank')</script>;
<?php
        }
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="PhiLander">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
            <h3>Add Product</h3>
            <p>add product by entering the title and quantity</p>
        </div>
        <form action="" method="post" class="form">
            <input type="text" name="stock_name" placeholder="Product Name" required>
            <input type="number" name="stock_quantity" placeholder="Product Quantity" required>
            <?php 
				        if (count($errors) > 0){
				            foreach ($errors as $error){
                                 echo '<small style="color: orange">'.$error.'</small><br><br>'; 
                    }
                }
			      ?>
            <button type="submit" name="submit">Add Product</button>
        </form>
        <div class="heading-text">
            <h3>Stock Details</h3>
            <p>list of all stock</p>
        </div>
        <div class="stock">
            <table>
                <tr>
                    <th>Stock Name</th>
                    <th>Stock Quantity</th>
                    <th>Date Updated</th>
                    <th>Date Created</th>
                </tr>
                    <?php
                        $query_stock = "SELECT * FROM stock";
                        $results = mysqli_query($conn, $query_stock);
                        while($row = mysqli_fetch_assoc($results)){
                    ?>
                <tr>
                    <td><a href="single-stock.php?id=<?php echo $row['stock_id'] ?>"><?php echo $row['stock_name'] ?></a></td>
                    <td><?php echo $row['stock_quantity'] ?></td>
                    <td><?php echo $row['updated_at'] ?></td>
                    <td><?php echo $row['created_at'] ?></td>   
                </tr>
                    <?php
                        }
                    ?> 
            </table>
        </div>
    </div>
</body>
</html>