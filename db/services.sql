CREATE TABLE `services` (
 `service_id` int NOT NULL AUTO_INCREMENT,
 `name` varchar(100) NOT NULL,
 `description` text,
 `price` decimal(10,2) NOT NULL,
 PRIMARY KEY (`service_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci