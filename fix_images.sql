-- Fix Menu Items Images with Better External URLs
UPDATE menu_items SET image = 'https://images.unsplash.com/photo-1579871494447-9811cf80d66c?w=400' WHERE name = 'Sushi Platter';
UPDATE menu_items SET image = 'https://images.unsplash.com/photo-1525385133512-2f346b384390?w=400' WHERE name = 'Kung Pao Chicken';
UPDATE menu_items SET image = 'https://images.unsplash.com/photo-1612874742237-982867143825?w=400' WHERE name = 'Pasta Carbonara';
UPDATE menu_items SET image = 'https://images.unsplash.com/photo-1565299585323-38d6b0865b47?w=400' WHERE name = 'Tacos';
UPDATE menu_items SET image = 'https://images.unsplash.com/photo-1569718212165-3a8278d5f624?w=400' WHERE name = 'Ramen';
UPDATE menu_items SET image = 'https://images.unsplash.com/photo-1543353071-873f17a7a088?w=400' WHERE name = 'Hostel Thali';

-- Fix Venue Images with External URLs
UPDATE venues SET image = 'https://images.unsplash.com/photo-1552566626-52f8b828add9?w=400' WHERE name = 'Spicy Dragon';
UPDATE venues SET image = 'https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?w=400' WHERE name = 'Mama Mia Pizzeria';
UPDATE venues SET image = 'https://images.unsplash.com/photo-1543007630-9710e4a00a20?w=400' WHERE name = 'Student Hostel Canteen';
UPDATE venues SET image = 'https://images.unsplash.com/photo-1579027989536-b7b1f875659b?w=400' WHERE name = 'Tokyo Sushi Bar';
