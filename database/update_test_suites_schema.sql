-- Update test_suites schema to support type, priority, and schedule

ALTER TABLE test_suites
    ADD COLUMN `type` ENUM(
        'smoke','regression','functional','integration','system','acceptance',
        'performance','security','ui','usability','compatibility'
    ) NOT NULL DEFAULT 'functional' AFTER `description`;

ALTER TABLE test_suites
    ADD COLUMN `priority` ENUM('critical','high','medium','low') NOT NULL DEFAULT 'medium' AFTER `type`;

ALTER TABLE test_suites
    ADD COLUMN `schedule` ENUM('manual','daily','weekly','release') NOT NULL DEFAULT 'manual' AFTER `priority`;


