CREATE TABLE sentiment_reports (
    id SERIAL PRIMARY KEY,
    user_id VARCHAR(255) NOT NULL,
    positive_count INT,
    neutral_count INT,
    negative_count INT,
    positive_percentage DECIMAL(5, 2),
    neutral_percentage DECIMAL(5, 2),
    negative_percentage DECIMAL(5, 2),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);