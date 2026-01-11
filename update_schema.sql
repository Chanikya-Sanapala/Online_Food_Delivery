-- Add Venues Table (Restaurants/Hostels)
CREATE TABLE IF NOT EXISTS venues (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    type ENUM('restaurant', 'hostel', 'canteen') DEFAULT 'restaurant',
    image VARCHAR(255),
    address VARCHAR(255),
    latitude DECIMAL(10, 8),
    longitude DECIMAL(11, 8),
    rating DECIMAL(2, 1) DEFAULT 4.0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Add venue_id to menu_items
-- Check if column exists first (MariaDB/MySQL specific hack not needed if we ignore errors or just add)
-- For simplicity in this environment, we just try to add it.
ALTER TABLE menu_items ADD COLUMN IF NOT EXISTS venue_id INT NULL;
ALTER TABLE menu_items ADD FOREIGN KEY (venue_id) REFERENCES venues(id) ON DELETE SET NULL;

-- Seed Venues
INSERT INTO venues (name, type, image, address, rating) VALUES 
('Spicy Dragon', 'restaurant', 'restaurant_chinese.jpg', '123 Dragon St, Food City', 4.5),
('Mama Mia Pizzeria', 'restaurant', 'restaurant_italian.jpg', '45 Napoli Blvd', 4.8),
('Student Hostel Canteen', 'hostel', 'hostel_canteen.jpg', 'Campus Block A', 3.5),
('Tokyo Sushi Bar', 'restaurant', 'sushi_bar.jpg', '88 Sakura Ave', 4.9)
ON DUPLICATE KEY UPDATE name=name;

-- Seed International Food Items
INSERT INTO menu_items (name, description, price, image, venue_id) VALUES 
('Sushi Platter', 'Fresh assorted sushi rolls', 850.00, 'sushi.jpg', (SELECT id FROM venues WHERE name='Tokyo Sushi Bar' LIMIT 1)),
('Kung Pao Chicken', 'Spicy stir-fry chicken with peanuts', 450.00, 'kung_pao.jpg', (SELECT id FROM venues WHERE name='Spicy Dragon' LIMIT 1)),
('Pasta Carbonara', 'Creamy pasta with bacon and egg', 380.00, 'pasta.jpg', (SELECT id FROM venues WHERE name='Mama Mia Pizzeria' LIMIT 1)),
('Tacos', 'Mexican beef tacos with salsa', 250.00, 'tacos.jpg', NULL),
('Ramen', 'Japanese noodle soup', 400.00, 'ramen.jpg', (SELECT id FROM venues WHERE name='Tokyo Sushi Bar' LIMIT 1)),
('Hostel Thali', 'Daily special rice and curry', 80.00, 'thali.jpg', (SELECT id FROM venues WHERE name='Student Hostel Canteen' LIMIT 1))
ON DUPLICATE KEY UPDATE price=price;
