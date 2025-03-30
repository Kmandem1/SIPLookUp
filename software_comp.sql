-- Table for storing software components related to SIPs
CREATE TABLE software_components (
    software_id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT,
    component_name VARCHAR(255),
    details TEXT,
    FOREIGN KEY (product_id) REFERENCES products(product_id) ON DELETE CASCADE
);