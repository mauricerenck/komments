ALTER TABLE comments ADD COLUMN status TEXT CHECK(status IN ("PENDING", "VERIFIED", "PUBLISHED")) DEFAULT "PENDING";

UPDATE "comments" SET status = 'PUBLISHED' WHERE published = true;

-- Always add the migration version to the migrations table:
INSERT INTO migrations (version) VALUES (202511071020);
