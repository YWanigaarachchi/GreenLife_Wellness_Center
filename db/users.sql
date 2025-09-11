	CREATE TABLE `users` (
 `user_id` int NOT NULL AUTO_INCREMENT,
 `first_name` varchar(100) NOT NULL,
 `last_name` varchar(100) NOT NULL,
 `username` varchar(100) NOT NULL,
 `email` varchar(150) NOT NULL,
 `phone` varchar(20) NOT NULL,
 `password` varchar(255) NOT NULL,
 `role` enum('client','admin','therapist') NOT NULL DEFAULT 'client',
 `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
 `reset_token` varchar(255) DEFAULT NULL,
 `token_expiry` datetime DEFAULT NULL,
 PRIMARY KEY (`user_id`),
 UNIQUE KEY `username` (`username`),
 UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci