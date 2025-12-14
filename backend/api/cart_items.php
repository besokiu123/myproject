<?php
require __DIR__ . '/api/db.php';

$sql = "
CREATE TABLE IF NOT EXISTS cart_items (
  id SERIAL PRIMARY KEY,
  session_id TEXT,
  product_id INT,
  quantity INT DEFAULT 1
);
";

$pdo->exec($sql);
echo "✅ cart_items table created successfully";
