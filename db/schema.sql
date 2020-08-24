CREATE TABLE "palabras" (
	"id"	INTEGER NOT NULL,
	"palabra"	TEXT NOT NULL UNIQUE,
	"significado"	TEXT NOT NULL,
	"ejemplo"	TEXT,
	"deleted" INTEGER NOT NULL DEFAULT 0 CHECK("deleted" IN(0, 1)),
	PRIMARY KEY("id" AUTOINCREMENT)
);

CREATE INDEX idx_palabra ON palabras(palabra);
CREATE INDEX idx_deleted ON palabras(deleted);