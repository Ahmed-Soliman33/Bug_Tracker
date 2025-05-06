CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    name VARCHAR(256),
    email VARCHAR(256) NOT NULL UNIQUE,
    password VARCHAR(256) NOT NULL,
    role ENUM('customer', 'admin', 'staff') NOT NULL DEFAULT 'customer',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE projects (
    project_id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    project_title VARCHAR(300) NOT NULL,
    project_type ENUM('web', 'mobile', 'desktop') NOT NULL,
    project_description TEXT NOT NULL,
    client_name VARCHAR(200) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE bugs (
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    bug_name VARCHAR(120) NOT NULL,
    project_id INT NOT NULL,
    category TEXT NOT NULL,
    details TEXT,
    assigned_to INT,
    status ENUM('waiting', 'in_progress', 'solved') DEFAULT 'waiting',
    priority ENUM('low', 'medium', 'high') DEFAULT 'medium',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (project_id) REFERENCES projects(project_id),
    FOREIGN KEY (assigned_to) REFERENCES users(user_id),
    INDEX idx_project_id (project_id)
);

CREATE TABLE messages (
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    user_id INT NOT NULL,
    email VARCHAR(300) NOT NULL,
    message TEXT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id),
    INDEX idx_user_id (user_id)
);