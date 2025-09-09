CREATE TABLE `wellness_tips` (
 `tip_id` int NOT NULL AUTO_INCREMENT,
 `title` varchar(200) NOT NULL,
 `content` text NOT NULL,
 `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
 PRIMARY KEY (`tip_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci