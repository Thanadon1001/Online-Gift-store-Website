<?php
include 'db.php'; // Includes the database connection file

if ($conn) { // Checks if the $conn variable is set and not null
    echo "Database connected"; // If $conn is set, it prints "Database connected"
} else {
    echo "Database not connected"; // If $conn is not set, it prints "Database not connected"
}
?>