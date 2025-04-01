<?php
$dsn = "pgsql:host=localhost;port=5432;dbname=postgres";
$username = "postgres";
$password = "postgres";

try {
    $conn = new PDO($dsn, $username, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    
    // Get product ID from URL
    $goods_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
    
    // Fetch product details
    $stmt = $conn->prepare("
        SELECT goods_name, price_1_day, price_3_day, price_7_day 
        FROM goods 
        WHERE goods_id = ? AND availability_status = true
    ");
    $stmt->execute([$goods_id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$product) {
        die('<div class="alert alert-danger">Product not available or not found</div>');
    }
    
} catch(PDOException $e) {
    error_log($e->getMessage());
    die('<div class="alert alert-danger">Sorry, a database error occurred</div>');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment - StyleSwap Rental</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            padding: 40px 0;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 30px;
            background: white;
            border-radius: 20px;
            box-shadow: 0 15px 30px rgba(0,0,0,0.1);
        }

        .header {
            text-align: center;
            margin-bottom: 40px;
            padding-bottom: 20px;
            border-bottom: 2px solid #f0f0f0;
        }

        .header h2 {
            color: #2d3436;
            font-size: 32px;
            margin-bottom: 10px;
        }

        .product-info {
            background: #f8f9fa;
            padding: 25px;
            border-radius: 15px;
            margin-bottom: 30px;
        }

        .product-info h3 {
            color: #2d3436;
            font-size: 24px;
            margin-bottom: 15px;
        }

        .packages-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin: 30px 0;
        }

        .package {
            background: white;
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            padding: 20px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .package:hover {
            transform: translateY(-5px);
            border-color: #667eea;
        }

        .package.selected {
            border-color: #667eea;
            background: #f0f4ff;
        }

        .price {
            font-size: 24px;
            font-weight: 600;
            color: #2d3436;
            margin: 10px 0;
        }

        .duration {
            color: #636e72;
            font-size: 14px;
        }

        .total-section {
            background: #2d3436;
            color: white;
            padding: 20px;
            border-radius: 12px;
            margin: 30px 0;
            text-align: center;
        }

        .total-section .total {
            font-size: 28px;
            font-weight: 600;
        }

        .payment-methods {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin: 30px 0;
        }

        .payment-option {
            background: white;
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            padding: 20px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .payment-option:hover {
            border-color: #667eea;
        }

        .payment-option.selected-payment {
            border-color: #667eea;
            background: #f0f4ff;
        }

        .payment-option i {
            font-size: 24px;
            color: #667eea;
        }

        .input-field {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            margin-bottom: 15px;
            font-size: 16px;
            transition: border-color 0.3s ease;
        }

        .input-field:focus {
            border-color: #667eea;
            outline: none;
        }

        .btn-confirm {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 8px;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            width: 100%;
            margin-top: 20px;
            transition: transform 0.3s ease;
        }

        .btn-confirm:hover {
            transform: translateY(-2px);
        }

        .qr-code {
            text-align: center;
            padding: 20px;
        }

        .qr-code img {
            max-width: 200px;
            margin: 20px 0;
        }

        .hidden {
            display: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2><i class="fas fa-shopping-cart"></i> Secure Payment</h2>
            <p>Complete your rental transaction securely</p>
        </div>

        <div class="product-info">
            <h3>Selected Item</h3>
            <p><?php echo htmlspecialchars($product['goods_name']); ?></p>
        </div>

        <h3>Select Rental Duration</h3>
        <div class="packages-grid">
            <div class="package" onclick="selectPackage(1, <?php echo $product['price_1_day']; ?>, this)">
                <div class="duration">1 Day Rental</div>
                <div class="price"><?php echo number_format($product['price_1_day']); ?> THB</div>
                <div class="details">Perfect for one-day events</div>
            </div>
            <div class="package" onclick="selectPackage(3, <?php echo $product['price_3_day']; ?>, this)">
                <div class="duration">3 Days Rental</div>
                <div class="price"><?php echo number_format($product['price_3_day']); ?> THB</div>
                <div class="details">Ideal for weekend use</div>
            </div>
            <div class="package" onclick="selectPackage(7, <?php echo $product['price_7_day']; ?>, this)">
                <div class="duration">7 Days Rental</div>
                <div class="price"><?php echo number_format($product['price_7_day']); ?> THB</div>
                <div class="details">Best value for weekly rental</div>
            </div>
        </div>

        <div class="total-section">
            <div>Total Amount (including 50 THB shipping)</div>
            <div class="total"><span id="total-price">0</span> THB</div>
        </div>

        <h3>Payment Method</h3>
        <div class="payment-methods">
            <div class="payment-option" onclick="togglePayment('credit', this)">
                <i class="fas fa-credit-card"></i>
                <div>
                    <h4>Credit/Debit Card</h4>
                    <small>Pay securely with your card</small>
                </div>
            </div>
            <div class="payment-option" onclick="togglePayment('qr', this)">
                <i class="fas fa-qrcode"></i>
                <div>
                    <h4>QR Payment</h4>
                    <small>Scan and pay instantly</small>
                </div>
            </div>
        </div>

        <div id="credit-form" class="hidden">
            <h4>Card Details</h4>
            <input type="text" class="input-field" placeholder="Card Number">
            <input type="text" class="input-field" placeholder="Cardholder Name">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                <input type="text" class="input-field" placeholder="MM/YY">
                <input type="text" class="input-field" placeholder="CVV">
            </div>
        </div>

        <div id="qr-code-form" class="hidden qr-code">
            <h4>Scan QR Code to Pay</h4>
            <img src="https://via.placeholder.com/200" alt="QR Code">
            <p>Scan this QR code with your mobile banking app</p>
        </div>

        <button class="btn-confirm" onclick="goToThankYou()">
            <i class="fas fa-lock"></i> Complete Payment
        </button>
    </div>

    <script>
    // ...existing JavaScript code...
    </script>
</body>
</html>
<script>
let selectedPrice = 0;
let selectedPackage = null;
let selectedPayment = null;
const shippingFee = 50;
const productId = <?php echo $goods_id; ?>;

function selectPackage(days, price, element) {
    // Update selected price
    selectedPrice = parseFloat(price);
    
    // Update total price display with shipping fee
    const totalPrice = selectedPrice + shippingFee;
    document.getElementById("total-price").textContent = totalPrice.toLocaleString();

    // Update package selection styling
    if (selectedPackage) {
        selectedPackage.classList.remove("selected");
    }
    element.classList.add("selected");
    selectedPackage = element;
}

function togglePayment(method, element) {
    // Toggle payment form visibility
    document.getElementById('credit-form').classList.toggle('hidden', method !== 'credit');
    document.getElementById('qr-code-form').classList.toggle('hidden', method !== 'qr');

    // Update payment method selection styling
    if (selectedPayment) {
        selectedPayment.classList.remove("selected-payment");
    }
    element.classList.add("selected-payment");
    selectedPayment = element;
}

function goToThankYou() {
    if (!selectedPackage) {
        alert("Please select a rental package before proceeding");
        return;
    }
    if (!selectedPayment) {
        alert("Please select a payment method before proceeding");
        return;
    }
    
    // Redirect to thank you page with product ID and selected package info
    window.location.href = `type.html?id=${productId}&price=${selectedPrice}&shipping=${shippingFee}`;
}
</script>