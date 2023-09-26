-- Adminer 4.8.1 PostgreSQL 15.3 (Debian 15.3-1.pgdg120+1) dump

DROP TABLE IF EXISTS "program_studi";
CREATE TABLE "public"."program_studi" (
    "kode" character varying(2) NOT NULL,
    "kode_fakultas" character varying(10) NOT NULL,
    "nama" character varying(100) NOT NULL,
    CONSTRAINT "program_studi_kode" PRIMARY KEY ("kode")
) WITH (oids = false);

INSERT INTO "program_studi" ("kode", "kode_fakultas", "nama") VALUES
('IF',	'STEI',	'Teknik Informatika'),
('II',	'STEI',	'Sistem Teknologi dan Informasi'),
('TI',	'FTI',	'Teknik Industri');

ALTER TABLE ONLY "public"."program_studi" ADD CONSTRAINT "program_studi_kode_fakultas_fkey" FOREIGN KEY (kode_fakultas) REFERENCES fakultas(kode) ON UPDATE CASCADE ON DELETE CASCADE NOT DEFERRABLE;

-- 2023-09-26 15:08:25.040896+00