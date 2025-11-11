-- Schema for student event app
CREATE DATABASE IF NOT EXISTS student_events CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE student_events;

CREATE TABLE IF NOT EXISTS users (
  user_id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(150) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  role VARCHAR(20) DEFAULT 'user'
);

CREATE TABLE IF NOT EXISTS events (
  event_id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  date DATE NOT NULL,
  venue VARCHAR(255),
  description TEXT
);

CREATE TABLE IF NOT EXISTS registrations (
  reg_id INT AUTO_INCREMENT PRIMARY KEY,
  event_id INT NOT NULL,
  name VARCHAR(150) NOT NULL,
  student_id VARCHAR(50) NOT NULL,
  email VARCHAR(150) NOT NULL,
  contact VARCHAR(50),
  timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (event_id) REFERENCES events(event_id) ON DELETE CASCADE
);

-- Sample event
INSERT INTO events (title,date,venue,description) VALUES
('Intro to Web Dev','2025-12-01','Auditorium','A short workshop on HTML/CSS/JS');
