<?php
session_start();
$dsn = "pgsql:host=localhost;port=5432;dbname=postgres";
$username = "postgres";
$password = "postgres";

// Create database connection
try {
    $conn = new PDO($dsn, $username, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Get form data
        $username = $_POST['fullname'];  // Using fullname as username
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $address = $_POST['address'];
        $phone = $_POST['phone'];
        $zipcode = $_POST['zipcode'];

        // Prepare SQL statement to match table structure
        $stmt = $conn->prepare("
            INSERT INTO users (username, password, address, phone, zipcode) 
            VALUES (?, ?, ?, ?, ?)
        ");

        // Execute with parameters
        $stmt->execute([$username, $password, $address, $phone, $zipcode]);

        // Redirect to thank you page
        header("Location: thankyou.php");
        exit();

    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Address Confirmation</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <style>
        body { background-color: #fffaf5; font-family: 'Arial', sans-serif; }
        .container { margin-top: 40px; }
        .card { padding: 25px; border-radius: 15px; box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1); background-color: #ffffff; }
        .card-title { font-size: 22px; font-weight: bold; color: #d81b60; text-align: center; }
        .btn { border-radius: 8px; font-weight: bold; width: 100%; transition: 0.3s ease-in-out; }
        .btn:hover { transform: scale(1.05); }
        .btn-confirm { background-color: #d81b60; }
        .btn-cancel { background-color: #9e9e9e; }
    </style>
</head>
<body>
<div class="container">
        <div class="row">
            <div class="col s12 m8 offset-m2">
                <div class="card">
                    <h4 class="card-title">กรอกข้อมูลผู้ใช้</h4>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <!-- Username field (using fullname) -->
                        <div class="input-field">
                            <i class="material-icons prefix">account_circle</i>
                            <input id="fullname" name="fullname" type="text" required>
                            <label for="fullname">ชื่อผู้ใช้</label>
                        </div>
                        
                        <!-- Password field -->
                        <div class="input-field">
                            <i class="material-icons prefix">lock</i>
                            <input id="password" name="password" type="password" required>
                            <label for="password">รหัสผ่าน</label>
                        </div>

                        <!-- Address field -->
                        <div class="input-field">
                            <i class="material-icons prefix">home</i>
                            <textarea id="address" name="address" class="materialize-textarea" required></textarea>
                            <label for="address">ที่อยู่</label>
                        </div>

                        <!-- Phone field -->
                        <div class="input-field">
                            <i class="material-icons prefix">phone</i>
                            <input id="phone" name="phone" type="tel" required>
                            <label for="phone">เบอร์โทรศัพท์</label>
                        </div>

                        <!-- Zipcode field -->
                        <div class="input-field">
                            <i class="material-icons prefix">markunread_mailbox</i>
                            <input id="zipcode" name="zipcode" type="text" required>
                            <label for="zipcode">รหัสไปรษณีย์</label>
                        </div>

                        <!-- Buttons -->
                        <div class="row">
                            <div class="col s6">
                                <a href="index.php" class="btn btn-cancel white-text">ยกเลิก</a>
                            </div>
                            <div class="col s6">
                                <button type="submit" class="btn btn-confirm white-text">ยืนยัน</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script>
        $(document).ready(function() {
            $('textarea').characterCounter();
        });
    </script>
</body>
</html>