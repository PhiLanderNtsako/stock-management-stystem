<?php
    $admin_id = $_SESSION['admin_id'];

    $query_admin = "SELECT * FROM admins WHERE admin_id = '$admin_id'";
    $results = mysqli_query($conn, $query_admin);
    $row = mysqli_fetch_assoc($results);
?>
<div class="header">
    <div class="logo">
        <h3>Stock Manager</h3>
    </div>
    <div class="main-navigation">
        <ul>
            <li><a href="index.php">Scan</a></li>
            <li><a href="stock.php">Stock</a></li>
            <li><a href="send-report.php">Send Report</a></li>
            <li><a href="logout.php">Logout</a></li>
            
            <ul>
                <li><a href="javascript:;"><?php echo $row['admin_name'] ?></a></li>
            </ul>
        </ul>
    </div>
    <div class="mobile-navigation">
        <ul>
            <li><a href="index.php">Scan</a></li>
            <li><a href="stock.php">Stock</a></li>
            <li class="dropdown"><a href="javascript:;"><?php echo $row['admin_name'] ?></a>
                <div class="dropdown-content">
                    <ul>
                        <li><a href="send-report.php">Send Report</a></li>
                        <li><a href="logout.php">Logout</a></li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</div>