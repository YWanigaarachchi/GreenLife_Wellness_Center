	CREATE TABLE `appointments` (
 `appointment_id` int NOT NULL AUTO_INCREMENT,
 `client_id` int NOT NULL,
 `therapist_id` int NOT NULL,
 `appointment_date` date NOT NULL,
 `appointment_time` time NOT NULL,
 `status` enum('pending','confirmed','completed','cancelled') DEFAULT 'pending',
 `notes` text,
 PRIMARY KEY (`appointment_id`),
 KEY `client_id` (`client_id`),
 KEY `therapist_id` (`therapist_id`),
 CONSTRAINT `appointments_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
 CONSTRAINT `appointments_ibfk_2` FOREIGN KEY (`therapist_id`) REFERENCES `therapists` (`therapist_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci