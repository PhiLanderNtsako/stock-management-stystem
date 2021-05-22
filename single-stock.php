<?php
    include 'config/config.php';
    session_start();

    if (!isset($_SESSION['admin_id'])) {
        echo '<meta http-equiv="refresh" content="0; url= login.php">';
    }

    $errors = array();
    if(isset($_POST['update-submit'])){

        $stock_quantity = mysqli_real_escape_string($conn, $_POST['stock_quantity']);
        $stock_id = $_POST['stock_id'];
        $admin_id = $_SESSION['admin_id'];
        $datetime = date('d/m/y'.' - '.'H:i');
        
        $update_stock = "UPDATE stock SET stock_quantity = '$stock_quantity', updated_at = NOW() WHERE stock_id = '$stock_id'";
        mysqli_query($conn, $update_stock);
        
        $query_stock = mysqli_query($conn, "SELECT * FROM stock, admins WHERE stock.stock_id = '$stock_id'");
        $row = mysqli_fetch_assoc($query_stock);

        array_push($errors, "Stock Item Updated.");
        
        $code = $stock_id.$row['stock_name'];

        $stockArray = array(
            $code => array(
            'stock_id' => $stock_id,
            'stock_name' => $row['stock_name'],
            'stock_quantity' => $stock_quantity,
            'updated_at' => $datetime
           )
       );

       if(empty($_SESSION['stock'])) {

		    $_SESSION['stock'] = $stockArray;
	    }else {

		    $array_keys = array_keys($_SESSION['stock']);

		    if(!in_array($code, $array_keys)) {
			    $_SESSION['stock'] = array_merge($_SESSION['stock'], $stockArray);
		    }else {
                foreach($_SESSION['stock'] as &$val){
                    if($val['stock_id'] == $stock_id){
                        $val['stock_quantity'] = $stock_quantity;
                        $val['updated_at'] = $datetime;
                    }
                }
            }
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
    <link href="css/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <title>Stock Management System</title>
</head>
<body>
    <?php
        include 'header.php';
    ?>
    <div class="container">
        <div>
            <div class="header-text">
                <h3>Stock Details</h3>
            </div>
            <?php
                $stock_id = $_GET['id'];

                $query_stock = "SELECT * FROM stock WHERE stock_id = '$stock_id'";
                $results = mysqli_query($conn, $query_stock);
                $row = mysqli_fetch_assoc($results)
            ?>
            <div class="stock">
                <table>
                    <tr>
                        <th>Stock Name</th>
                        <th>Stock Quantity</th>
                        <th>Date Updated</th>
                        <th>Date Created</th>
                    </tr>
                    <tr>
                        <td><?php echo $row['stock_name'] ?></td>
                        <td><?php echo $row['stock_quantity'] ?></td>
                        <td><?php echo $row['updated_at'] ?></td>
                        <td><?php echo $row['created_at'] ?></td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="stock-update">
            <div class="header-text">
                <h3>Update stock quantity</h3>
            </div>
            <form action="" method="post" class="form">
                <input type="number" min="1" name="stock_quantity" placeholder="Stock Quantity" required>
                <input type="hidden" name="stock_id" value="<?php echo $stock_id ?>">
                <?php 
                    if (count($errors) > 0){
                        foreach ($errors as $error){
                            echo '<small style="color: cyan">'.$error.'</small><br><br>';   
                        }
                    }
                ?>
                <button type="submit" name="update-submit">Update Product</button>
            </form>
        </div>
    </div>
</body>
</html>