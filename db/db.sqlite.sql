BEGIN TRANSACTION;
DROP TABLE IF EXISTS "users";
CREATE TABLE IF NOT EXISTS "users" (
	"id"	INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
	"user"	TEXT NOT NULL,
	"password"	TEXT NOT NULL,
	"email"	TEXT NOT NULL
);
DROP TABLE IF EXISTS "comments";
CREATE TABLE IF NOT EXISTS "comments" (
	"id"	INTEGER PRIMARY KEY AUTOINCREMENT,
	"show"	INTEGER NOT NULL DEFAULT 0,
	"cod"	TEXT,
	"user"	TEXT NOT NULL,
	"email"	TEXT NOT NULL,
	"text"	TEXT NOT NULL,
	"url"	TEXT NOT NULL,
	"year"	INTEGER,
	"month"	INTEGER,
	"day"	INTEGER,
	"hour"	INTEGER,
	"minute"	INTEGER,
	"second"	INTEGER
);
DROP TABLE IF EXISTS "CAPTCHA";
CREATE TABLE IF NOT EXISTS "CAPTCHA" (
	"id"	INTEGER PRIMARY KEY AUTOINCREMENT,
	"question_code"	TEXT NOT NULL,
	"question_text"	TEXT NOT NULL,
	"answer"	TEXT NOT NULL
);
COMMIT;