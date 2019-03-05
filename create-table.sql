CREATE TABLE users (
  id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  first_name VARCHAR (100) NOT NULL,
  last_name VARCHAR (100) NOT NULL,
  email VARCHAR (255) NOT NULL UNIQUE,
  password varchar (255) NOT NULL,
  email_verified varchar (255),
  access_token varchar (255),
  created_at TIMESTAMP DEFAULT now(),
  updated_at TIMESTAMP DEFAULT now()
);

CREATE TABLE images (
  id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  user_id INT(11) UNSIGNED NOT NULL,
  created_at TIMESTAMP DEFAULT now(),
  updated_at TIMESTAMP DEFAULT now(),
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE
);