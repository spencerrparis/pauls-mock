CREATE TABLE DiningTables (
    table_id SERIAL PRIMARY KEY,
    table_number VARCHAR(10) UNIQUE NOT NULL,
    capacity INT NOT NULL,
    is_active BOOLEAN DEFAULT TRUE
);