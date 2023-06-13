-- Create the `cv_data` table
CREATE TABLE IF NOT EXISTS `cv_data` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `full_name` VARCHAR(255) NOT NULL,
  `dob` DATE NOT NULL,
  `place_of_birth` VARCHAR(255) NOT NULL,
  `location` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `phone_number` VARCHAR(255) NOT NULL,
  `last_school` VARCHAR(255) NOT NULL,
  `last_school_year` VARCHAR(255) NOT NULL,
  `last_school_graduated` VARCHAR(255) NOT NULL,
  `summary` TEXT NOT NULL,
  `skills` TEXT NOT NULL,
  `portrait` VARCHAR(255) NOT NULL
);

-- Create the `achievements` table
CREATE TABLE IF NOT EXISTS `achievements` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `cv_data_id` INT NOT NULL,
  `achievement` VARCHAR(255) NOT NULL,
  `year` VARCHAR(255) NOT NULL,
  FOREIGN KEY (`cv_data_id`) REFERENCES `cv_data` (`id`) ON DELETE CASCADE
);

-- Create the `users` table
CREATE TABLE IF NOT EXISTS `users` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `email` VARCHAR(255) NOT NULL,
  `username` VARCHAR(255) NOT NULL,
  `full_name` VARCHAR(255) NOT NULL,
  `phone_number` VARCHAR(255) NOT NULL,
  `dob` DATE NOT NULL,
  `gender` ENUM('Male', 'Female') NOT NULL
);
