
-- Tabela: Produkcje (filmy/seriale)
-- KM1: Katalog
CREATE TABLE production (
id INTEGER PRIMARY KEY AUTOINCREMENT,
title TEXT NOT NULL,
        type TEXT NOT NULL CHECK(type IN ('film', 'serial')),
        description TEXT,
        release_year INTEGER,
        genre TEXT,
        poster_url TEXT,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Tabela: Platformy streamingowe
-- KM2: Katalog - show-platform
CREATE TABLE platform (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT NOT NULL UNIQUE,
        logo_url TEXT
);

-- Tabela: Dostępność produkcji na platformach
-- KM2: Katalog - prod-available, change-of-availability
CREATE TABLE production_availability (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        production_id INTEGER NOT NULL,
        platform_id INTEGER NOT NULL,
        is_available BOOLEAN DEFAULT 1,
        CONSTRAINT fk_production
            FOREIGN KEY (production_id)
                REFERENCES production (id)
                ON DELETE CASCADE,
        CONSTRAINT fk_platform
            FOREIGN KEY (platform_id)
                REFERENCES platform (id)
                ON DELETE CASCADE,
        UNIQUE(production_id, platform_id)
);

-- Tabela: Sesje użytkowników (ciasteczka)
-- KM3: Cookie - zapis, odczyt, usuwanie
CREATE TABLE session (
        id TEXT PRIMARY KEY,
        cookie_data TEXT,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        expires_at DATETIME NOT NULL
);

-- Tabela: Listy użytkownika (ulubione)
-- KM3: Ulubione
CREATE TABLE user_list (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        session_id TEXT NOT NULL,
        name TEXT NOT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        CONSTRAINT fk_session_list
            FOREIGN KEY (session_id)
                REFERENCES session (id)
                ON DELETE CASCADE
);

-- Tabela: Produkcje w listach
-- KM3: Ulubione - add-to-list, del-from-list, no-duplicate
CREATE TABLE list_production (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        list_id INTEGER NOT NULL,
        production_id INTEGER NOT NULL,
        added_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        CONSTRAINT fk_list
            FOREIGN KEY (list_id)
                REFERENCES user_list (id)
                ON DELETE CASCADE,
        CONSTRAINT fk_production_list
            FOREIGN KEY (production_id)
                REFERENCES production (id)
                ON DELETE CASCADE,
        UNIQUE(list_id, production_id)
);

-- Tabela: Administratorzy
-- KM3: Panel administratora - login
CREATE TABLE admin (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        username TEXT NOT NULL UNIQUE,
        password_hash TEXT NOT NULL
);


-- Indeksy


CREATE INDEX idx_production_type ON production(type);
CREATE INDEX idx_production_genre ON production(genre);
CREATE INDEX idx_availability_production ON production_availability(production_id);
CREATE INDEX idx_availability_platform ON production_availability(platform_id);
CREATE INDEX idx_list_session ON user_list(session_id);
CREATE INDEX idx_list_production_list ON list_production(list_id);