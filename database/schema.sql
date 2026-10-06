-- Database and enquiry storage used by the contact form.
CREATE DATABASE IF NOT EXISTS sea_asia_shipping
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE sea_asia_shipping;

CREATE TABLE IF NOT EXISTS contact_enquiries (
  id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  name VARCHAR(100) NOT NULL,
  company VARCHAR(150) NULL,
  email VARCHAR(190) NOT NULL,
  phone VARCHAR(30) NULL,
  service VARCHAR(80) NULL,
  message TEXT NOT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  KEY idx_contact_enquiries_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
