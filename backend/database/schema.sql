CREATE TABLE shops (
    shop_id INT(6) NOT NULL AUTO_INCREMENT,
    shop_name VARCHAR(64) NOT NULL,
    shop_halal BOOLEAN NOT NULL DEFAULT 0,
    shop_time DATETIME NOT NULL,
    shop_capacity INT(4),
    shop_lat float(10, 6),
    shop_long float(10, 6),
    PRIMARY KEY (shop_id)
);

CREATE TABLE locations (
    location_id INT(6) NOT NULL AUTO_INCREMENT,
    shop_id INT(6) NOT NULL,
    location_address VARCHAR(256),
    PRIMARY KEY (location_id),
    FOREIGN KEY (shop_id) REFERENCES shops(shop_id)
);
