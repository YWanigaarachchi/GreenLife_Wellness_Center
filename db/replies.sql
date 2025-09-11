CREATE TABLE `replies` (
 `reply_id` int NOT NULL AUTO_INCREMENT,
 `feedback_id` int NOT NULL,
 `admin_id` int DEFAULT NULL,
 `reply_message` text NOT NULL,
 `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
 PRIMARY KEY (`reply_id`),
 KEY `feedback_id` (`feedback_id`),
 CONSTRAINT `replies_ibfk_1` FOREIGN KEY (`feedback_id`) REFERENCES `feedback` (`feedback_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci