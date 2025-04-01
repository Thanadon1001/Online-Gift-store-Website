<?php
$dsn = "pgsql:host=localhost;port=5432;dbname=postgres";
$username = "postgres";
$password = "postgres";

try {
    $conn = new PDO($dsn, $username, $password, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

    // Create Users table with password column
    $sql_users = "
        CREATE TABLE IF NOT EXISTS users (
            user_id SERIAL PRIMARY KEY,
            username VARCHAR(100) NOT NULL,
            address TEXT NOT NULL,
            phone VARCHAR(20),          -- Added phone column
            zipcode VARCHAR(10),        -- Added zipcode column
            password TEXT NOT NULL      -- Added password column
        )";

    // Add password column if table exists but column doesn't
    $sql_add_password = "
        DO $$
        BEGIN
            IF EXISTS (
                SELECT FROM information_schema.tables 
                WHERE table_name = 'users'
            ) AND NOT EXISTS (
                SELECT FROM information_schema.columns 
                WHERE table_name = 'users' AND column_name = 'password'
            ) THEN
                ALTER TABLE users ADD COLUMN password TEXT NOT NULL DEFAULT '';
            END IF;
        END $$;
    ";

    // Create Goods table (unchanged)
    $sql_goods = "
        CREATE TABLE IF NOT EXISTS goods (
            goods_id SERIAL PRIMARY KEY,
            goods_name VARCHAR(100) NOT NULL
        )";

    // Create Pricing table (unchanged)
    $sql_pricing = "
        CREATE TABLE IF NOT EXISTS pricing (
            pricing_id SERIAL PRIMARY KEY,
            goods_id INT REFERENCES goods(goods_id) ON DELETE CASCADE,
            rent_days INT CHECK (rent_days IN (1, 3, 7)),
            price DECIMAL(10,2) NOT NULL
        )";

    // Create Rentals table (unchanged)
    $sql_rentals = "
        CREATE TABLE IF NOT EXISTS rentals (
            rental_id SERIAL PRIMARY KEY,
            user_id INT REFERENCES users(user_id) ON DELETE CASCADE,
            goods_id INT REFERENCES goods(goods_id) ON DELETE CASCADE,
            rent_days INT CHECK (rent_days IN (1, 3, 7)),
            total_cost DECIMAL(10,2),
            rental_date DATE NOT NULL DEFAULT CURRENT_DATE
        )";

    // Execute the table creation queries
    $conn->exec($sql_users);
    $conn->exec($sql_add_password);
    $conn->exec($sql_goods);
    $conn->exec($sql_pricing);
    $conn->exec($sql_rentals);

    echo "Database tables created/updated successfully";

} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Close the connection
$conn = null;
?>