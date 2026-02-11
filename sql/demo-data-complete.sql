-- KarmaCMS Demo Data Export
-- Version: 1.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";

START TRANSACTION;

SET time_zone = "+00:00";

-- [Placeholder for complete SQL dump including all tables and relationships]
-- This file is intended for manual database import in phpMyAdmin or custom environments.

INSERT INTO
    `settings` (`key`, `value`)
VALUES ('site_name', 'KarmaCMS Demo');

INSERT INTO
    `categories` (`name`, `slug`)
VALUES ('General', 'general');

COMMIT;