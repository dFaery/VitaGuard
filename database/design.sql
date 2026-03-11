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
    CONSTRAINT `fk_cities_provinces` FOREIGN KEY (`province_id`) REFERENCES `provinces` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
);

-- Table Districts
CREATE TABLE `districts` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `city_id` INT NOT NULL,
    `name` VARCHAR(200) NOT NULL,
    CONSTRAINT `fk_districts_cities` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
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
    `updated_at` TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT `fk_members_users` FOREIGN KEY (`username`) REFERENCES `users` (`username`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `fk_members_district` FOREIGN KEY (`district_id`) REFERENCES `districts` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
);

-- TODO: Table Medical Histories
-- TODO: Table Allergies
-- TODO: Table Current_Medications

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
    `id` BIGINT AUTO_INCREMENT PRIMARY KEY,
    `username` VARCHAR(50),
    `specialty_id` INT,
    CONSTRAINT `fk_doctor_specialties_username` FOREIGN KEY (`username`) REFERENCES `doctors` (`username`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `fk_doctor_specialties_id` FOREIGN KEY (`specialty_id`) REFERENCES `specialties` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE UNIQUE (`username`, `specialty_id`)
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
    `break_end_time` TIME,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT `fk_facility_hours_facility` FOREIGN KEY (`facility_id`) REFERENCES `facilities` (`id`) ON DELETE CASCADE,
    CHECK (
        `break_start_time` < `break_end_time`
    ),
    CHECK (`open_time` < `close_time`)
);

-- Table Practice Schedule
CREATE TABLE `schedules` (
    `id` BIGINT AUTO_INCREMENT PRIMARY KEY,
    `doctor_username` VARCHAR(50) NOT NULL,
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
    `start_time` TIME NOT NULL,
    `end_time` TIME NOT NULL,
    `slot_duration_minutes` INT DEFAULT 30,
    `max_patients` INT,
    `break_start_time` TIME,
    `break_end_time` TIME,
    `consultation_fee` DECIMAL(10, 2),
    `notes` TEXT,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP,
    CHECK (
        `break_start_time` < `break_end_time`
    ),
    CHECK (`start_time` < `end_time`)
);

CREATE TABLE `appointments` (
    `id` BIGINT AUTO_INCREMENT PRIMARY KEY,
    `member_username` VARCHAR(50) NOT NULL,
    `schedule_id` BIGINT NOT NULL,
    `appointment_date` DATE NOT NULL,
    `appointment_time` TIME NOT NULL,
    `queue_order` INT NOT NULL,
    `status` ENUM(
        'pending',
        'confirmed',
        'completed',
        'cancelled',
        'no_show'
    ) DEFAULT 'pending',
    `notes` TEXT,
    `check_in_time` DATETIME,
    `completed_time` DATETIME,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT `fk_appointments_member` FOREIGN KEY (`member_username`) REFERENCES `members` (`username`) ON DELETE CASCADE,
    CONSTRAINT `fk_appointments_schedule` FOREIGN KEY (`schedule_id`) REFERENCES `schedules` (`id`) ON DELETE CASCADE,
    UNIQUE (
        `schedule_id`,
        `appointment_date`,
        `appointment_time`
    ),
    UNIQUE (
        `schedule_id`,
        `appointment_date`,
        `queue_order`
    )
);

-- TODO: Table online_sessions
-- TODO: Table consult_sessions
-- TODO: Table chat
-- TODO:

-- Indexes
CREATE INDEX idx_schedules_doctor ON schedules (doctor_username);

CREATE INDEX idx_schedules_facility ON schedules (facility_id);

CREATE INDEX idx_schedules_day ON schedules (day_of_week);

CREATE INDEX idx_appointments_member ON appointments (member_username);

CREATE INDEX idx_appointments_schedule ON appointments (schedule_id);

CREATE INDEX idx_appointments_date ON appointments (appointment_date);