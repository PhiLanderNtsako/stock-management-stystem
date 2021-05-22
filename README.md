<!-- INSTALLATION -->

1. Install XAMPP or WAMPP.
        -Download XAMPP from https://www.apachefriends.org.

2. Open XAMPP Control panell and start [apache] and [mysql].

3. Extract project files in C:\xampp\htdocs.

4. Open link localhost/phpmyadmin on a prefered web browser.

5. Create a new database with the name [stock_management_system_db].

6. Browse the database file in directory [stock-management-system/config/stock_management_system_db.sql].

7. Open link http://localhost/stock-management-system.

8. Login
        -Admin login details: Username = [admin1@gmail.com] and Password = [admin1].
        -Admin login details: Username = [admin2@gmail.com] and Password = [admin2].

9. If it requires libraries, check links below and install in directory [stock-management-system/libs].

<!-- HOW TO USE -->

1. After loging in you will be redirected to the home page [stock-management-system/index.php] then navigate to [stock-management-system/stock.php] and add as many stock you want.

2. The QRCode image will be automatically downloaded and uploaded to the directory [stock-management-system/images/]

3. Navigate to scan and upload the QRCode image and it will redirect to single stock details.

4. After updating stock quantity, you can either navigate to [stock-management-system/send-update.php] or [stock-management-system/logout.php] it will send report to manager's email in pdf format.

<!-- LIBRARIES USED -->

1. PHP QRCode Detector Decoder
    - $ composer require khanamiryan/qrcode-detector-decoder

2. PHP QRCode Generator
    - Download: https://phpqrcode.sourceforge.net

3. FPDF
    - Download: https://fpdf.org/download

4. PHP Mailer
    - Download: https://sourceforge.net/projects/phpmailer/  