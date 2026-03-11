CREATE SCHEMA IF NOT EXISTS vitaguard;

-- Table Provinces
CREATE TABLE `provinces` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(200) NOT NULL
);

-- Table Cities
CREATE TABLE `cities` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `province_id` INT NOT NULL,
    `name` VARCHAR(200) NOT NULL,
    CONSTRAINT `fk_cities_provinces` FOREIGN KEY (`id_provinces`) REFERENCES `provinces` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
);

-- Table Districts
CREATE TABLE `districts` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `city_id` INT NOT NULL,
    `name` VARCHAR(200) NOT NULL,
    CONSTRAINT `fk_districts_cities` FOREIGN KEY (`id_cities`) REFERENCES `cities` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
);

-- Table Users
CREATE TABLE `users` (
    `username` VARCHAR(50) PRIMARY KEY,
    `password_hashed` VARCHAR(255) NOT NULL,
    `email` VARCHAR(100) NOT NULL UNIQUE,
    `phone_number` VARCHAR(20),
    `role` ENUM('member', 'doctor') DEFAULT 'member',
    `status` ENUM('active', 'suspended') DEFAULT 'active',
    `last_login_at` TIMESTAMP NULL,
    `email_verified_at` TIMESTAMP NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    `deleted_at` TIMESTAMP NULL
);

-- Table Members
CREATE TABLE `members` (
    `username` VARCHAR(50) PRIMARY KEY,
    `first_name` VARCHAR(100) NOT NULL,
    `middle_name` VARCHAR(100),
    `last_name` VARCHAR(100) NOT NULL,
    `address` VARCHAR(255) NOT NULL,
    `district_id` INT NOT NULL,
    `date_of_birth` DATE,
    `gender` ENUM('male', 'female') NOT NULL,
    `blood_type` ENUM(
        'A+',
        'A-',
        'B+',
        'B-',
        'AB+',
        'AB-',
        'O+',
        'O-'
    ),
    `weight_kg` DECIMAL(5, 2),
    `height_cm` DECIMAL(5, 2),
    `smoking_status` ENUM('never', 'former', 'current'),
    `alcohol_consumption` ENUM(
        'none',
        'light',
        'moderate',
        'heavy'
    ),
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP
);

-- Table Doctors
CREATE TABLE `doctors` (
    `username` VARCHAR(50) PRIMARY KEY,
    `prefix_name` VARCHAR(20),
    `first_name` VARCHAR(100) NOT NULL,
    `middle_name` VARCHAR(100),
    `last_name` VARCHAR(100) NOT NULL,
    `suffix_name` VARCHAR(100),
    `address` VARCHAR(255) NOT NULL,
    `district_id` INT NOT NULL,
    `date_of_birth` DATE,
    `rating_avg` DECIMAL(3, 2),
    `rating_count` INT DEFAULT 0,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT `fk_doctors_users` FOREIGN KEY (`username`) REFERENCES `users` (`username`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `fk_doctors_district` FOREIGN KEY (`district_id`) REFERENCES `districts` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
);

-- Table Specialties
CREATE TABLE `specialties` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(150) UNIQUE
);

-- Table Doctor Specialties
CREATE TABLE `doctor_specialties` (
    `username` varchar(50) PRIMARY KEY,
    `specialty_id` INT PRIMARY KEY,
    CONSTRAINT `fk_doctor_specialties_username` FOREIGN KEY (`username`) REFERENCES `users` (`username`) ON DELETE RESTRICT ON UPDATE CASCADE,
    CONSTRAINT `fk_doctor_specialties_id` FOREIGN KEY (`specialty_id`) REFERENCES `specialties` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
);

-- Table Facilities
CREATE TABLE `facilities` (
    `id` BIGINT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL,
    `address` VARCHAR(255) NOT NULL,
    `district_id` INT,
    `phone_number` VARCHAR(20),
    `rating_avg` DECIMAL(3, 2),
    `rating_count` INT DEFAULT 0,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (`district_id`) REFERENCES `districts` (`id`) ON DELETE RESTRICT
);

-- Table Facilities Hours
CREATE TABLE `facility_hours` (
    `id` BIGINT AUTO_INCREMENT PRIMARY KEY,
    `facility_id` BIGINT NOT NULL,
    `day_of_week` ENUM(
        'monday',
        'tuesday',
        'wednesday',
        'thursday',
        'friday',
        'saturday',
        'sunday'
    ) NOT NULL,
    `open_time` TIME NOT NULL,
    `close_time` TIME NOT NULL,
    `break_start_time` TIME,
    `break_stop_time` TIME,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT `fk_facility_hours_facility` FOREIGN KEY (`facility_id`) REFERENCES `facilities` (`id`) ON DELETE CASCADE
);

-- Table Practice Schedule
CREATE TABLE `schedules` (
    `id` BIGINT AUTO_INCREMENT PRIMARY KEY,

    `doctor_username` VARCHAR(50) NOT NULL,
    `facility_id` BIGINT NOT NULL,

    `day_of_week` ENUM(
        'monday','tuesday','wednesday',
        'thursday','friday','saturday','sunday'
    ) NOT NULL,

    `start_time` TIME NOT NULL,
    `end_time` TIME NOT NULL,

    `slot_duration_minutes` INT DEFAULT 30,
    `max_patients` INT,

    `break_start_time` TIME,
    `break_end_time` TIME,
    `consultation_fee` DECIMAL(10,2),
    `notes` TEXT,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP
);
CREATE INDEX idx_schedules_doctor
ON schedules(doctor_username);

CREATE INDEX idx_schedules_facility
ON schedules(facility_id);

CREATE INDEX idx_schedules_day
ON schedules(day_of_week);