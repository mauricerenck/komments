ALTER TABLE comments DROP COLUMN status;
ALTER TABLE comments ADD COLUMN verification_status TEXT DEFAULT "PENDING";
