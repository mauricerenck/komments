CREATE TABLE IF NOT EXISTS migrations (
    version NUMBER UNIQUE
);

CREATE TABLE IF NOT EXISTS comments (
    id VARCHAR UNIQUE,
    page_uuid VARCHAR,
    parent_id VARCHAR,
    content TEXT,
    author_name VARCHAR,
    author_avatar TEXT,
    author_email VARCHAR,
    author_url TEXT,
    published BOOLEAN,
    verified BOOLEAN,
    spamlevel INTEGER,
    type VARCHAR,
    language VARCHAR,
    upvotes INTEGER,
    downvotes INTEGER,
    created_at TEXT,
    updated_at TEXT
);

-- Always add the migration version to the migrations table:
INSERT INTO migrations (version) VALUES (202407211411);
