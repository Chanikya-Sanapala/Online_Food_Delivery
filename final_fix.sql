-- 1. Remove Duplicate Menu Items (Keep the one with the lowest ID)
DELETE m1 FROM menu_items m1
INNER JOIN menu_items m2 
WHERE m1.id > m2.id AND m1.name = m2.name;

-- 2. Update Images to Correct External URLs
UPDATE menu_items SET image = 'https://images.unsplash.com/photo-1555126634-323283e090fa?w=400' WHERE name LIKE '%Ramen%';
UPDATE menu_items SET image = 'https://images.unsplash.com/photo-1599974579688-8dbdd335c77f?w=400' WHERE name LIKE '%Tacos%';
UPDATE menu_items SET image = 'https://images.unsplash.com/photo-1621996346565-e3dbc646d9a9?w=400' WHERE name LIKE '%Carbonara%';
UPDATE menu_items SET image = 'https://images.unsplash.com/photo-1525385133512-2f346b384390?w=400' WHERE name LIKE '%Kung Pao%';
UPDATE menu_items SET image = 'https://images.unsplash.com/photo-1579584425555-c3ce17fd4351?w=400' WHERE name LIKE '%Sushi%';
UPDATE menu_items SET image = 'https://images.unsplash.com/photo-1543353071-873f17a7a088?w=400' WHERE name LIKE '%Thali%';

-- 3. Update Venues to Correct External URLs
UPDATE venues SET image = 'https://images.unsplash.com/photo-1552566626-52f8b828add9?w=400' WHERE name LIKE '%Dragon%';
UPDATE venues SET image = 'https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?w=400' WHERE name LIKE '%Pizzeria%';
UPDATE venues SET image = 'https://images.unsplash.com/photo-1543007630-9710e4a00a20?w=400' WHERE name LIKE '%Canteen%';
UPDATE venues SET image = 'https://images.unsplash.com/photo-1579027989536-b7b1f875659b?w=400' WHERE name LIKE '%Sushi Bar%';
