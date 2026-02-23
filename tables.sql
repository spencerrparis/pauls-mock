CREATE DATABASE epicurean_themes;
USE epicurean_themes;

DROP TABLE IF EXISTS Reservations;
DROP TABLE IF EXISTS MenuItems;
DROP TABLE IF EXISTS Categories;
DROP TABLE IF EXISTS DiningTables;
DROP TABLE IF EXISTS Users;
DROP TABLE IF EXISTS Roles;

CREATE TABLE Roles (
    role_id INT AUTO_INCREMENT PRIMARY KEY,
    role_name VARCHAR(20) NOT NULL 
);

CREATE TABLE Categories (
    category_id INT AUTO_INCREMENT PRIMARY KEY,
    category_name VARCHAR(50) NOT NULL,
    description TEXT
);

CREATE TABLE DiningTables (
    table_id INT AUTO_INCREMENT PRIMARY KEY,
    table_number VARCHAR(10) UNIQUE NOT NULL,
    capacity INT NOT NULL,
    is_active TINYINT(1) DEFAULT 1
);

CREATE TABLE Users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    role_id INT,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL, 
    phone_number VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (role_id) REFERENCES Roles(role_id) ON DELETE SET NULL
);

CREATE TABLE MenuItems (
    item_id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    image_url TEXT,
    is_available TINYINT(1) DEFAULT 1,
    FOREIGN KEY (category_id) REFERENCES Categories(category_id) ON DELETE CASCADE
);

CREATE TABLE Reservations (
    reservation_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NULL, 
    table_id INT,
    reservation_date DATE NOT NULL,
    start_time TIME NULL, 
    end_time TIME NULL,
    guest_count INT NOT NULL,
    status VARCHAR(20) DEFAULT 'Pending', 
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES Users(user_id) ON DELETE SET NULL,
    FOREIGN KEY (table_id) REFERENCES DiningTables(table_id) ON DELETE CASCADE
);

INSERT INTO Roles (role_name) VALUES ('Manager'), ('Staff'), ('Guest');

-- Admin User (password: admin123)
-- role_id 1 matches 'Manager'
INSERT INTO Users (role_id, full_name, email, password_hash) 
VALUES (1, 'Site Manager', 'admin@apexneon.com', '$2y$10$8W3Y6uCunpWbE0/uW/XvB.XyMh.uB6v/Fm7M8yH.oP3h6kO1yXhXy');

-- Test ables
INSERT INTO DiningTables (table_number, capacity, is_active) VALUES 
('T1', 2, 1), ('T2', 4, 1), ('T3', 6, 1);

INSERT INTO Categories (category_name, description) VALUES 
('Small Dishes', 'High-tech apps'),
('Main Dishes', 'Neon fuel'),
('Drinks', 'Synthetic refreshments');

INSERT INTO MenuItems (category_id, name, description, price, is_available) VALUES 
(1, 'Cyber Gyoza', 'Electric ginger soy.', 8.50, 1),
(2, 'Neon Glazed Salmon', 'Wasabi pea crust.', 22.00, 1),
(3, 'Liquid Chrome Soda', 'Silver citrus blend.', 6.50, 1);