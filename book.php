<?php
$dsn = "pgsql:host=localhost;port=5432;dbname=postgres";
$username = "postgres";
$password = "postgres";

try {
    // Create PDO connection
    $conn = new PDO($dsn, $username, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    
    // Query to fetch all available goods, ordered by category
    $query = "
        SELECT g.*
        FROM goods g
        WHERE g.availability_status = true
        ORDER BY g.category, g.goods_name
    ";
    
    // Execute query
    $stmt = $conn->query($query);
    $goods = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Group items by category
    $categorized_goods = [];
    foreach ($goods as $item) {
        // Use category name as key, defaulting to 'Other' if null
        $category = $item['category'] ?: 'Other';
        $categorized_goods[$category][] = $item;
    }
    
    // Sort categories alphabetically
    ksort($categorized_goods);
    
} catch(PDOException $e) {
    error_log("Database error: " . $e->getMessage());
    die('<div class="alert alert-danger m-3">ขออภัย เกิดข้อผิดพลาดในการเชื่อมต่อฐานข้อมูล</div>');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StyleSwap - Rental Store</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css">
    <style>
        .category-section {
            margin-bottom: 40px;
        }
        .category-title {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 25px;
            text-align: center;
            font-size: 24px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .card {
            border: none;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            transition: transform 0.3s;
            margin-bottom: 30px;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .card-img-top {
            height: 300px;
            object-fit: cover;
        }
        .card-body {
            padding: 20px;
        }
        .price-section {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin: 15px 0;
        }
        .btn-star {
            background: transparent;
            color: #ffd700;
            border: 2px solid #ffd700;
            margin-right: 10px;
        }
        .btn-star:hover {
            background: #ffd700;
            color: white;
        }
        .btn-rent {
            background: #667eea;
            border: none;
        }
        .btn-rent:hover {
            background: #764ba2;
        }
        .size-info {
            color: #666;
            font-size: 0.9em;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="container-fluid py-5">
        <?php foreach ($categorized_goods as $category => $items): ?>
        <div class="category-section">
            <h2 class="category-title">
                <i class="fas fa-tag mr-2"></i><?php echo htmlspecialchars($category); ?>
            </h2>
            
            <div class="row">
                <?php foreach (array_chunk($items, 3) as $chunk): ?>
                    <?php foreach ($chunk as $item): ?>
                    <div class="col-md-4">
                        <div class="card">
                            <img src="img/<?php echo htmlspecialchars($item['image_path']); ?>" 
                                 class="card-img-top" 
                                 alt="<?php echo htmlspecialchars($item['goods_name']); ?>">
                            <div class="card-body">
                                <h5 class="card-title font-weight-bold">
                                    <?php echo htmlspecialchars($item['goods_name']); ?>
                                </h5>
                                <p class="card-text">
                                    <?php echo nl2br(htmlspecialchars($item['description'])); ?>
                                </p>
                                <div class="size-info">
                                    <i class="fas fa-ruler mr-2"></i>
                                    <?php echo htmlspecialchars($item['size_info']); ?>
                                </div>
                                <div class="price-section">
                                    <div class="mb-2">
                                        <i class="far fa-clock mr-2"></i>1 วัน: <?php echo number_format($item['price_1_day']); ?> บาท
                                    </div>
                                    <div class="mb-2">
                                        <i class="far fa-clock mr-2"></i>3 วัน: <?php echo number_format($item['price_3_day']); ?> บาท
                                    </div>
                                    <div>
                                        <i class="far fa-clock mr-2"></i>7 วัน: <?php echo number_format($item['price_7_day']); ?> บาท
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <button id="star-btn-<?php echo $item['goods_id']; ?>" 
                                            onclick="toggleStar(this)" 
                                            class="btn btn-star">
                                        <i class="far fa-star"></i>
                                    </button>
                                    <a href="pay.php?id=<?php echo $item['goods_id']; ?>" 
                                       class="btn btn-rent text-white">
                                        <i class="fas fa-shopping-cart mr-2"></i>เช่าเลย
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <script>
    function toggleStar(btn) {
        const icon = btn.querySelector('i');
        if (icon.classList.contains('far')) {
            icon.classList.remove('far');
            icon.classList.add('fas');
            alert('เพิ่มในรายการโปรดแล้ว!');
        } else {
            icon.classList.remove('fas');
            icon.classList.add('far');
            alert('นำออกจากรายการโปรดแล้ว!');
        }
    }
    </script>
</body>
</html>