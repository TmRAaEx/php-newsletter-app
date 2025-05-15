CREATE TABLE `users` (
  `id` INT PRIMARY KEY AUTO_INCREMENT,
  `first_name` VARCHAR(255) NOT NULL,
  `last_name` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL UNIQUE,
  `password_hash` VARCHAR(255) NOT NULL,
  `salt` VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE `roles` (
  `id` INT PRIMARY KEY AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL
);

CREATE TABLE `user_roles` (
  `user_id` INT NOT NULL,
  `role_id` INT NOT NULL,
  PRIMARY KEY (`user_id`, `role_id`)
);

CREATE TABLE `newsletters` (
  `id` INT PRIMARY KEY AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `description` TEXT,
  `customer_id` INT NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE `subscriptions` (
  `id` INT PRIMARY KEY AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `newsletter_id` INT NOT NULL,
  `subscribed_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `unsubscribed_at` TIMESTAMP NULL,
  UNIQUE (`user_id`, `newsletter_id`)
);

CREATE TABLE `password_resets` (
  `id` INT PRIMARY KEY AUTO_INCREMENT,
  `email` VARCHAR(255) NOT NULL,
  `token` VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `expires_at` TIMESTAMP NOT NULL
);

CREATE TABLE `sessions` (
  `id` INT PRIMARY KEY AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `session_token` VARCHAR(255) NOT NULL,
  `ip_address` VARCHAR(45),
  `user_agent` VARCHAR(255),
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `expires_at` TIMESTAMP NOT NULL
);

-- Foreign keys
ALTER TABLE `user_roles`
  ADD FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

ALTER TABLE `newsletters`
  ADD FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

ALTER TABLE `subscriptions`
  ADD FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD FOREIGN KEY (`newsletter_id`) REFERENCES `newsletters` (`id`) ON DELETE CASCADE;

ALTER TABLE `sessions`
  ADD FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
