CREATE TABLE Reservations (
    reservation_id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
    user_id UUID REFERENCES Users(user_id),
    table_id INT REFERENCES DiningTables(table_id),
    reservation_date DATE NOT NULL,
    start_time TIME NOT NULL,
    end_time TIME NOT NULL,
    guest_count INT NOT NULL,
    status VARCHAR(20) DEFAULT 'Pending', -- 'Confirmed', 'Cancelled', 'No-Show'
    payment_intent_id VARCHAR(255), -- For the No-Show Guarantee
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE INDEX idx_res_date_time ON Reservations(reservation_date, start_time);