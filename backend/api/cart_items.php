CREATE TABLE cart_items (
  id SERIAL PRIMARY KEY,
  session_id TEXT,
  product_id INT,
  quantity INT DEFAULT 1
);
