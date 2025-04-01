<?php
$dsn = "pgsql:host=localhost;port=5432;dbname=postgres";
$username = "postgres";
$password = "postgres";

// Initialize variables with default values
$fullname = '';
$phone = '';
$address = '';
$province = '';
$zipcode = '';
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $conn = new PDO($dsn, $username, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

        // Safely get form data with defaults if keys are missing
        $fullname = isset($_POST['fullname']) ? $_POST['fullname'] : '';
        $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
        $address = isset($_POST['address']) ? $_POST['address'] : '';
        $province = isset($_POST['province']) ? $_POST['province'] : '';
        $zipcode = isset($_POST['zipcode']) ? $_POST['zipcode'] : '';

        // Check if required fields are empty
        if (empty($fullname) || empty($address)) {
            throw new Exception("กรุณากรอกชื่อและที่อยู่ให้ครบถ้วน");
        }

        // Prepare and execute the INSERT query
        $sql = "INSERT INTO users (username, address, phone, province, zipcode) 
                VALUES (:username, :address, :phone, :province, :zipcode)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':username' => $fullname,
            ':address' => $address,
            ':phone' => $phone,
            ':province' => $province,
            ':zipcode' => $zipcode
        ]);

        $message = "User added successfully!";

    } catch (PDOException $e) {
        $message = "Error: " . $e->getMessage();
    } catch (Exception $e) {
        $message = $e->getMessage();
    }

    // Close the connection
    $conn = null;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <style>
        body { background-color: #fffaf5; font-family: 'Arial', sans-serif; }
        .container { margin-top: 40px; text-align: center; }
        .card { padding: 25px; border-radius: 15px; box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1); background-color: #ffffff; }
        .btn { border-radius: 8px; font-weight: bold; background-color: #d81b60; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col s12 m8 offset-m2">
                <div class="card">
                    <h4><?php echo $message; ?></h4>
                    <?php if ($message === "User added successfully!") { ?>
                        <p>ข้อมูลผู้ใช้ถูกบันทึกเรียบร้อยแล้ว</p>
                    <?php } ?>
                    <a href="index.php" class="btn white-text">กลับสู่หน้าหลัก</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>