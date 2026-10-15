USE recycle_here;

SET NAMES utf8mb4;

CREATE TABLE IF NOT EXISTS collection_points (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    company_id INT UNSIGNED NOT NULL,

    name VARCHAR(150) NOT NULL,

    street VARCHAR(180) NOT NULL,

    number VARCHAR(20) NOT NULL,

    complement VARCHAR(100) NULL,

    neighborhood VARCHAR(100) NOT NULL,

    city VARCHAR(100) NOT NULL DEFAULT 'Sorocaba',

    state CHAR(2) NOT NULL DEFAULT 'SP',

    zip_code CHAR(8) NULL,

    phone VARCHAR(20) NULL,

    opening_hours VARCHAR(255) NOT NULL,

    active BOOLEAN NOT NULL DEFAULT TRUE,

    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,

    updated_at TIMESTAMP NOT NULL
        DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP,

    CONSTRAINT fk_collection_points_company
        FOREIGN KEY (company_id)
        REFERENCES companies(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

CREATE INDEX idx_collection_points_company
    ON collection_points(company_id);

CREATE INDEX idx_collection_points_location
    ON collection_points(city, neighborhood);

CREATE INDEX idx_collection_points_active
    ON collection_points(active);
    