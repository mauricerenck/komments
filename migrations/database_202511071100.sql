CREATE TABLE IF NOT EXISTS comment_verification (
    hash TEXT PRIMARY KEY,
    comment_id TEXT UNIQUE,
    expires_at TEXT,
    created_at TEXT
);

-- Always add the migration version to the migrations table:
INSERT INTO migrations (version) VALUES (202511071100);
