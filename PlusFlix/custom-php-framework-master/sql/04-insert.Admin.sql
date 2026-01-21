-- Dodanie administratora z danymi logowania: admin / admin
-- Hasło można zahashować za pomocą password_hash() w PHP, nie zrobiłem jeszcze tej funkcji w projekcie

INSERT INTO admin (username, password_hash)
VALUES ('admin', 'admin');

-- :)

DROP TABLE IF EXISTS session;
CREATE TABLE session (
    id TEXT PRIMARY KEY,
    guest_id TEXT,
    cookie_data TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    expires_at DATETIME NOT NULL
);
