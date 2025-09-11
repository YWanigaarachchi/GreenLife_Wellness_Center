CREATE TABLE `feedback` (
 `feedback_id` int NOT NULL AUTO_INCREMENT,
 `user_id` int NOT NULL,
 `subject` varchar(200) NOT NULL,
 `message` text NOT NULL,
 `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
 PRIMARY KEY (`feedback_id`),
 KEY `user_id` (`user_id`),
 CONSTRAINT `feedback_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci