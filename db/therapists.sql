	CREATE TABLE `therapists` (
 `therapist_id` int NOT NULL AUTO_INCREMENT,
 `user_id` int NOT NULL,
 `specialization` varchar(150) DEFAULT NULL,
 `experience_years` int DEFAULT NULL,
 `bio` text,
 PRIMARY KEY (`therapist_id`),
 KEY `user_id` (`user_id`),
 CONSTRAINT `therapists_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci