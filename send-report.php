<?php
    include 'config/config.php';
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require 'libs/PHPMailer/src/Exception.php';
    require 'libs/PHPMailer/src/PHPMailer.php';
    require 'libs/PHPMailer/src/SMTP.php';
    require 'libs/fpdf/fpdf.php';
    session_start();

    if(isset($_SESSION['stock'])){

        $query_scannedStock_header = "SELECT UCASE(`COLUMN_NAME`) FROM `INFORMATION_SCHEMA`.`COLUMNS` WHERE `TABLE_SCHEMA`='stock_management_db' AND `TABLE_NAME`='stock' AND `COLUMN_NAME` IN ('stock_id','stock_name', 'stock_quantity','updated_at')";
        $scannedStock_header = mysqli_query($conn, $query_scannedStock_header);
        $scannedStock = $_SESSION['stock'];

        $query_stock_header = "SELECT UCASE(`COLUMN_NAME`) FROM `INFORMATION_SCHEMA`.`COLUMNS` WHERE `TABLE_SCHEMA`='stock_management_db' AND `TABLE_NAME`='stock' AND `COLUMN_NAME` IN ('stock_id','stock_name', 'stock_quantity','updated_at','created_at')";
        $stock_header = mysqli_query($conn, $query_stock_header);
        $query_stock = "SELECT stock_id, stock_name, stock_quantity, updated_at, created_at FROM stock";
        $stock = mysqli_query($conn, $query_stock);

        $admin_id = $_SESSION['admin_id'];
        $query_admin = "SELECT * FROM admins WHERE admin_id = '$admin_id'";
        $result_admin = mysqli_query($conn, $query_admin);
        $row_admin = mysqli_fetch_assoc($result_admin);

        class PDF extends FPDF {
        
            function Header(){

                $this->SetFont('Arial', 'B', 7);
                $this->Cell(80);
                $this->Cell(30, 10, 'PhiLander Ntsako Stock Management System', 0, 0);
                $this->Ln(20);
            }

            function Footer(){

                $this->SetY(-15);
                $this->SetFont('Arial', 'I', 8);
                $this->SetTextColor(128);
                $this->Cell(0, 10, 'Page '.$this->PageNo(), 0, 0, 'C');
            }

            function Admin($name, $username){

                $this->SetFont('Arial', '', 12);
                $this->SetFillColor(200, 220, 255);
                $this->Cell(0, 6, "Generated By $name : $username", 0, 1, 'L', true);
                $this->Ln(4);
            }

            function ScannedStock($scannedStock_header, $scannedStock){
                foreach($scannedStock_header as $heading) {
                    foreach($heading as $heading_row)
                        $this->Cell(47, 10, $heading_row, 1, 0, 'C');
                }
                foreach($scannedStock as $scanned_row) {
                    $this->Ln();
                    foreach($scanned_row as $scanned_col)
                        $this->Cell(47, 10, $scanned_col, 1, 0, 'C');
                }
            }

            function Stock($stock_header, $stock){
                foreach($stock_header as $heading) {
                    foreach($heading as $heading_row)
                        $this->Cell(38, 20, $heading_row, 1, 0, 'C');
                }
                foreach($stock as $Stock_row) {
                    
                    $this->SetFont('Arial','',10);
                    $this->Ln();
                    foreach($Stock_row as $stock_col)
                        $this->Cell(38, 20, $stock_col, 1, 0, 'C');
                }
            }
        }

        $pdf = new PDF();
        $pdf->SetFont('Arial','B',3);
        $pdf->AddPage();
        $pdf->Admin($row_admin['admin_name'], $row_admin['admin_username']);
        $pdf->ScannedStock($scannedStock_header, $scannedStock);
        $pdf->AddPage();
        $pdf->Stock($stock_header, $stock);
        $filename = 'reports/'.$row_admin['admin_name'].'_report-'.date('Hidmy').'.pdf';
        $pdf->Output($filename,'F');

?>
        <script type="text/javascript">window.location.replace('<?php echo $filename ?>', '_blank')</script>;
<?php

        $mail = new PHPMailer(true);
        $mail->From = $row_admin['admin_username'];
        $mail->FromName = $row_admin['admin_name'];
        $mail->AddAddress('phil.ntsako98@gmail.com');
        $mail->isHTML(true);

        $mail->Subject = 'Report for Scanned Stock';
        $mail->Body = '<h2>Report for scanned Stock and updated list of all stock items</h2>';

        $mail->addAttachment($filename);

        try {
            $mail->send();
            echo "Report has been sent successfully";
        } catch(Exception $e){
            echo "Mailer Error: ".$mail->ErrorInfo;
        }

        unset($_SESSION['stock']);
        $message = "Report sent to your manager AKA #Boss";
        echo "<script type='text/javascript'>alert('$message')</script>";
        echo '<meta http-equiv="refresh" content="0; url= index.php">';

    }else{
        echo '<meta http-equiv="refresh" content="0; url= index.php">';
    }
?> 