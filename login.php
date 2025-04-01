<?php
session_start();

$dsn = "pgsql:host=localhost;port=5432;dbname=postgres";
$username = "postgres";
$password = "postgres";

try {
    $conn = new PDO($dsn, $username, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    try {
        // Check user credentials
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        
        if ($stmt->rowCount() > 0) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if (password_verify($password, $user['password'])) {
                // Login successful
                $_SESSION['username'] = $user['username'];
                header("Location: thankyou.php");
                exit();
            } else {
                $error = "รหัสผ่านไม่ถูกต้อง";
            }
        } else {
            $error = "ไม่พบชื่อผู้ใช้";
        }
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
    <title>เข้าสู่ระบบ</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(to right, #e4cca2, #eeb98b);
        }
        .card {
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }
        .card-title {
            font-size: 24px;
            font-weight: bold;
            color: #333;
            text-align: center;
            margin-bottom: 30px;
        }
        .btn {
            width: 100%;
            margin-top: 20px;
            background-color: #000;
        }
        .error-message {
            color: #d32f2f;
            text-align: center;
            margin-top: 10px;
        }
        .input-field .prefix {
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col s12 m6 offset-m3">
                <div class="card">
                    <div class="card-content">
                        <h4 class="card-title">เข้าสู่ระบบ</h4>
                        <?php if (isset($error)): ?>
                            <div class="error-message"><?php echo $error; ?></div>
                        <?php endif; ?>
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                            <div class="input-field">
                                <i class="material-icons prefix">account_circle</i>
                                <input id="username" name="username" type="text" required>
                                <label for="username">ชื่อผู้ใช้</label>
                            </div>
                            <div class="input-field">
                                <i class="material-icons prefix">lock</i>
                                <input id="password" name="password" type="password" required>
                                <label for="password">รหัสผ่าน</label>
                            </div>
                            <button type="submit" class="btn waves-effect waves-light">
                                เข้าสู่ระบบ
                                <i class="material-icons right">send</i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</body>
</html>