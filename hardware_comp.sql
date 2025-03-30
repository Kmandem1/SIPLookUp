-- Table for storing hardware components related to SIPs
CREATE TABLE hardware_components (
    hardware_id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT,
    component_name VARCHAR(255),
    details TEXT,
    FOREIGN KEY (product_id) REFERENCES products(product_id) ON DELETE CASCADE
);