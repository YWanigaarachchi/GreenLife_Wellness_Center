	CREATE TABLE `services` (
 `service_id` int NOT NULL AUTO_INCREMENT,
 `service_name` varchar(200) NOT NULL,
 `description` text NOT NULL,
 `price` decimal(10,2) NOT NULL,
 `icon` varchar(50) DEFAULT 0xF09F8CBF,
 PRIMARY KEY (`service_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci