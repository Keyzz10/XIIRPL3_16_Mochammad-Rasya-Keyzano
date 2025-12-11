-- Add missing added_at column required by TestSuite model

ALTER TABLE test_suite_cases
    ADD COLUMN `added_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP AFTER `execution_order`;


