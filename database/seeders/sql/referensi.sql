/*
 Navicat Premium Data Transfer

 Source Server         : postgres
 Source Server Type    : PostgreSQL
 Source Server Version : 150002 (150002)
 Source Host           : localhost:5432
 Source Catalog        : situngkal_laravel
 Source Schema         : referensi

 Target Server Type    : PostgreSQL
 Target Server Version : 150002 (150002)
 File Encoding         : 65001

 Date: 22/05/2023 22:06:52
*/


-- ----------------------------
-- Table structure for agama
-- ----------------------------
DROP TABLE IF EXISTS "referensi"."agama";
CREATE TABLE "referensi"."agama" (
  "id" int4 NOT NULL,
  "agama" varchar(150) COLLATE "pg_catalog"."default" NOT NULL,
  "created_at" timestamp(6),
  "updated_at" timestamp(6),
  "expired_at" timestamp(6)
)
;

-- ----------------------------
-- Records of agama
-- ----------------------------
INSERT INTO "referensi"."agama" VALUES (2, 'Kristen', '2013-05-13 00:00:00', '2014-10-17 16:18:02', NULL);
INSERT INTO "referensi"."agama" VALUES (3, 'Katholik', '2013-05-13 00:00:00', '2014-10-17 16:18:02', NULL);
INSERT INTO "referensi"."agama" VALUES (4, 'Hindu', '2013-05-13 00:00:00', '2014-10-17 16:18:02', NULL);
INSERT INTO "referensi"."agama" VALUES (5, 'Budha', '2013-05-13 00:00:00', '2014-10-17 16:18:02', NULL);
INSERT INTO "referensi"."agama" VALUES (6, 'Kong Hu Chu', '2013-05-13 00:00:00', '2016-08-01 17:00:00', NULL);
INSERT INTO "referensi"."agama" VALUES (99, 'Lainnya', '2013-07-25 00:00:00', '2014-10-17 16:18:02', NULL);
INSERT INTO "referensi"."agama" VALUES (1, 'Islam', '2013-05-13 00:00:00', '2014-10-17 16:18:02', NULL);

-- ----------------------------
-- Table structure for alat_transportasi
-- ----------------------------
DROP TABLE IF EXISTS "referensi"."alat_transportasi";
CREATE TABLE "referensi"."alat_transportasi" (
  "id" int4 NOT NULL,
  "alat_transportasi" varchar(150) COLLATE "pg_catalog"."default" NOT NULL,
  "created_at" timestamp(6) NOT NULL,
  "updated_at" timestamp(6),
  "expired_at" timestamp(6)
)
;

-- ----------------------------
-- Records of alat_transportasi
-- ----------------------------
INSERT INTO "referensi"."alat_transportasi" VALUES (1, 'Jalan kaki', '2013-05-13 00:00:00', '2016-07-22 06:00:00', NULL);
INSERT INTO "referensi"."alat_transportasi" VALUES (2, 'Kendaraan pribadi', '2013-05-13 00:00:00', '2016-07-22 06:00:00', '2013-10-07 00:00:00');
INSERT INTO "referensi"."alat_transportasi" VALUES (3, 'Angkutan umum/bus/pete-pete', '2013-05-13 00:00:00', '2016-07-22 06:00:00', NULL);
INSERT INTO "referensi"."alat_transportasi" VALUES (4, 'Mobil/bus antar jemput', '2013-05-13 00:00:00', '2016-07-22 06:00:00', NULL);
INSERT INTO "referensi"."alat_transportasi" VALUES (5, 'Kereta api', '2013-05-13 00:00:00', '2016-07-22 06:00:00', NULL);
INSERT INTO "referensi"."alat_transportasi" VALUES (6, 'Ojek', '2013-05-13 00:00:00', '2016-07-22 06:00:00', NULL);
INSERT INTO "referensi"."alat_transportasi" VALUES (7, 'Andong/bendi/sado/dokar/delman/becak', '2013-05-13 00:00:00', '2016-07-22 06:00:00', NULL);
INSERT INTO "referensi"."alat_transportasi" VALUES (8, 'Perahu penyeberangan/rakit/getek', '2013-05-13 00:00:00', '2016-07-22 06:00:00', NULL);
INSERT INTO "referensi"."alat_transportasi" VALUES (11, 'Kuda', '2013-10-07 00:00:00', '2016-07-22 06:00:00', NULL);
INSERT INTO "referensi"."alat_transportasi" VALUES (12, 'Sepeda', '2013-10-07 00:00:00', '2016-07-22 06:00:00', NULL);
INSERT INTO "referensi"."alat_transportasi" VALUES (13, 'Sepeda motor', '2013-10-07 00:00:00', '2016-07-22 06:00:00', NULL);
INSERT INTO "referensi"."alat_transportasi" VALUES (14, 'Mobil pribadi', '2013-10-07 00:00:00', '2016-07-22 06:00:00', NULL);
INSERT INTO "referensi"."alat_transportasi" VALUES (99, 'Lainnya', '2013-05-13 00:00:00', '2016-07-22 06:00:00', NULL);

-- ----------------------------
-- Table structure for cita_cita
-- ----------------------------
DROP TABLE IF EXISTS "referensi"."cita_cita";
CREATE TABLE "referensi"."cita_cita" (
  "id" int4 NOT NULL,
  "cita_cita" varchar(150) COLLATE "pg_catalog"."default" NOT NULL,
  "created_at" timestamp(6),
  "updated_at" timestamp(6),
  "expired_at" timestamp(6)
)
;

-- ----------------------------
-- Records of cita_cita
-- ----------------------------
INSERT INTO "referensi"."cita_cita" VALUES (1, 'PNS', NULL, NULL, NULL);
INSERT INTO "referensi"."cita_cita" VALUES (2, 'TNI/Polri', NULL, NULL, NULL);
INSERT INTO "referensi"."cita_cita" VALUES (3, 'Guru/Dosen', NULL, NULL, NULL);
INSERT INTO "referensi"."cita_cita" VALUES (4, 'Dokter', NULL, NULL, NULL);
INSERT INTO "referensi"."cita_cita" VALUES (5, 'Politikus', NULL, NULL, NULL);
INSERT INTO "referensi"."cita_cita" VALUES (6, 'Wiraswasta', NULL, NULL, NULL);
INSERT INTO "referensi"."cita_cita" VALUES (7, 'Seni/Lukis/Artis/Sejenis', NULL, NULL, NULL);
INSERT INTO "referensi"."cita_cita" VALUES (99, 'Lainnya', NULL, NULL, NULL);

-- ----------------------------
-- Table structure for hari
-- ----------------------------
DROP TABLE IF EXISTS "referensi"."hari";
CREATE TABLE "referensi"."hari" (
  "id" int4 NOT NULL,
  "kode" varchar(11) COLLATE "pg_catalog"."default",
  "day" varchar(20) COLLATE "pg_catalog"."default",
  "hari" varchar(20) COLLATE "pg_catalog"."default",
  "created_at" timestamp(6),
  "updated_at" timestamp(6),
  "expired_at" timestamp(6)
)
;

-- ----------------------------
-- Records of hari
-- ----------------------------
INSERT INTO "referensi"."hari" VALUES (1, 'SN', 'Monday', 'Senin', NULL, '2020-08-28 06:20:11', NULL);
INSERT INTO "referensi"."hari" VALUES (2, 'SL', 'Tuesday', 'Selasa', NULL, '2020-08-28 06:20:13', NULL);
INSERT INTO "referensi"."hari" VALUES (3, 'RB', 'Wednesday', 'Rabu', NULL, '2020-08-28 06:20:14', NULL);
INSERT INTO "referensi"."hari" VALUES (4, 'KM', 'Thursday', 'Kamis', NULL, '2020-08-28 06:20:16', NULL);
INSERT INTO "referensi"."hari" VALUES (5, 'JM', 'Friday', 'Jumat', NULL, '2020-08-28 06:20:17', NULL);
INSERT INTO "referensi"."hari" VALUES (6, 'SB', 'Saturday', 'Sabtu', NULL, '2020-08-28 06:20:19', NULL);
INSERT INTO "referensi"."hari" VALUES (7, 'MG', 'Sunday', 'Minggu', NULL, '2020-08-28 06:20:21', NULL);

-- ----------------------------
-- Table structure for hobi
-- ----------------------------
DROP TABLE IF EXISTS "referensi"."hobi";
CREATE TABLE "referensi"."hobi" (
  "id" int4 NOT NULL,
  "hobi" varchar(150) COLLATE "pg_catalog"."default" NOT NULL,
  "created_at" timestamp(6),
  "updated_at" timestamp(6),
  "expired_at" timestamp(6)
)
;

-- ----------------------------
-- Records of hobi
-- ----------------------------
INSERT INTO "referensi"."hobi" VALUES (1, 'Olah Raga', NULL, NULL, NULL);
INSERT INTO "referensi"."hobi" VALUES (2, 'Kesenian', NULL, NULL, NULL);
INSERT INTO "referensi"."hobi" VALUES (3, 'Membaca', NULL, NULL, NULL);
INSERT INTO "referensi"."hobi" VALUES (4, 'Menulis', NULL, NULL, NULL);
INSERT INTO "referensi"."hobi" VALUES (5, 'Traveling', NULL, NULL, NULL);
INSERT INTO "referensi"."hobi" VALUES (99, 'Lainnya', NULL, NULL, NULL);

-- ----------------------------
-- Table structure for jabatan_tugas_ptk
-- ----------------------------
DROP TABLE IF EXISTS "referensi"."jabatan_tugas_ptk";
CREATE TABLE "referensi"."jabatan_tugas_ptk" (
  "id" int4 NOT NULL,
  "code1" char(20) COLLATE "pg_catalog"."default",
  "code2" char(20) COLLATE "pg_catalog"."default",
  "code3" char(20) COLLATE "pg_catalog"."default",
  "jabatan_tugas_ptk" varchar(100) COLLATE "pg_catalog"."default",
  "expired_date" timestamp(6),
  "updated_at" timestamp(6),
  "created_at" timestamp(6)
)
;

-- ----------------------------
-- Records of jabatan_tugas_ptk
-- ----------------------------
INSERT INTO "referensi"."jabatan_tugas_ptk" VALUES (1, '1                   ', '0                   ', NULL, 'Guru', NULL, '2018-10-24 10:06:38', NULL);
INSERT INTO "referensi"."jabatan_tugas_ptk" VALUES (2, '0                   ', '1                   ', NULL, 'Kepala Sekolah', NULL, '2018-10-24 10:06:38', NULL);
INSERT INTO "referensi"."jabatan_tugas_ptk" VALUES (3, '0                   ', '1                   ', NULL, 'Kepala Perpustakaan', NULL, '2018-10-24 10:06:38', NULL);
INSERT INTO "referensi"."jabatan_tugas_ptk" VALUES (4, '0                   ', '1                   ', NULL, 'Tenaga Perpustakaan', NULL, '2018-10-24 10:06:38', NULL);
INSERT INTO "referensi"."jabatan_tugas_ptk" VALUES (5, '1                   ', '0                   ', NULL, 'Kepala Tenaga Administrasi', NULL, '2018-10-24 10:06:38', NULL);
INSERT INTO "referensi"."jabatan_tugas_ptk" VALUES (6, '1                   ', '0                   ', NULL, 'Tenaga Administrasi', NULL, '2018-10-24 10:06:38', NULL);
INSERT INTO "referensi"."jabatan_tugas_ptk" VALUES (7, '0                   ', '1                   ', NULL, 'Kepala Laboratorium', NULL, '2018-10-24 10:06:38', NULL);
INSERT INTO "referensi"."jabatan_tugas_ptk" VALUES (8, '1                   ', '0                   ', NULL, 'Teknisi Laboratorium', NULL, '2018-10-24 10:06:38', NULL);
INSERT INTO "referensi"."jabatan_tugas_ptk" VALUES (9, '1                   ', '0                   ', NULL, 'Laboran', NULL, '2018-10-24 10:06:38', NULL);
INSERT INTO "referensi"."jabatan_tugas_ptk" VALUES (10, '1                   ', '0                   ', NULL, 'Pengawas', NULL, '2018-10-24 10:06:38', NULL);
INSERT INTO "referensi"."jabatan_tugas_ptk" VALUES (11, '0                   ', '1                   ', NULL, 'Wakil Kepala Sekolah', NULL, '2018-10-24 10:06:38', NULL);
INSERT INTO "referensi"."jabatan_tugas_ptk" VALUES (12, '1                   ', '0                   ', NULL, 'Bendahara', NULL, '2018-10-24 10:06:38', NULL);
INSERT INTO "referensi"."jabatan_tugas_ptk" VALUES (13, '1                   ', '0                   ', NULL, 'Pustakawan', NULL, '2018-10-24 10:06:38', NULL);
INSERT INTO "referensi"."jabatan_tugas_ptk" VALUES (14, '1                   ', '0                   ', NULL, 'Pesuruh/Penjaga Sekolah', NULL, '2018-10-24 10:06:38', NULL);
INSERT INTO "referensi"."jabatan_tugas_ptk" VALUES (15, '1                   ', '0                   ', NULL, 'Tutor Kesetaraan', NULL, '2018-10-24 10:06:38', NULL);
INSERT INTO "referensi"."jabatan_tugas_ptk" VALUES (16, '1                   ', '0                   ', NULL, 'Pamong Belajar', NULL, '2018-10-24 10:06:38', NULL);
INSERT INTO "referensi"."jabatan_tugas_ptk" VALUES (17, '1                   ', '0                   ', NULL, 'TLD', NULL, '2018-10-24 10:06:38', NULL);
INSERT INTO "referensi"."jabatan_tugas_ptk" VALUES (18, '1                   ', '0                   ', NULL, 'Pengelola PKBM', NULL, '2018-10-24 10:06:38', NULL);
INSERT INTO "referensi"."jabatan_tugas_ptk" VALUES (19, '1                   ', '0                   ', NULL, 'Pendidik PAUD', NULL, '2018-10-24 10:06:38', NULL);
INSERT INTO "referensi"."jabatan_tugas_ptk" VALUES (20, '1                   ', '0                   ', NULL, 'Penilik', NULL, '2018-10-24 10:06:38', NULL);
INSERT INTO "referensi"."jabatan_tugas_ptk" VALUES (21, '1                   ', '0                   ', NULL, 'Instruktur Kursus', NULL, '2018-10-24 10:06:38', NULL);
INSERT INTO "referensi"."jabatan_tugas_ptk" VALUES (22, '1                   ', '0                   ', NULL, 'Tutor Paket A', NULL, '2018-10-24 10:06:38', NULL);
INSERT INTO "referensi"."jabatan_tugas_ptk" VALUES (23, '1                   ', '0                   ', NULL, 'Tutor Paket B', NULL, '2018-10-24 10:06:38', NULL);
INSERT INTO "referensi"."jabatan_tugas_ptk" VALUES (24, '1                   ', '0                   ', NULL, 'Tutor Paket C', NULL, '2018-10-24 10:06:38', NULL);
INSERT INTO "referensi"."jabatan_tugas_ptk" VALUES (25, '1                   ', '0                   ', NULL, 'Kepala Lab (Non Guru)', NULL, '2018-10-24 10:06:38', NULL);
INSERT INTO "referensi"."jabatan_tugas_ptk" VALUES (26, '1                   ', '0                   ', NULL, 'Kepala Perpustakaan (Non Guru)', NULL, '2018-10-24 10:06:38', NULL);
INSERT INTO "referensi"."jabatan_tugas_ptk" VALUES (27, '1                   ', '0                   ', NULL, 'Tutor Keaksaraan', NULL, '2018-10-24 10:06:38', NULL);
INSERT INTO "referensi"."jabatan_tugas_ptk" VALUES (28, '1                   ', '0                   ', NULL, 'Pengelola Kursus', NULL, '2018-10-24 10:06:38', NULL);
INSERT INTO "referensi"."jabatan_tugas_ptk" VALUES (29, '1                   ', '0                   ', NULL, 'Pengelola Keaksaraan', NULL, '2018-10-24 10:06:38', NULL);
INSERT INTO "referensi"."jabatan_tugas_ptk" VALUES (30, '1                   ', '0                   ', NULL, 'Pengelola PAUD', NULL, '2018-10-24 10:06:38', NULL);
INSERT INTO "referensi"."jabatan_tugas_ptk" VALUES (31, '1                   ', '0                   ', NULL, 'Pengelola Kesetaraan', NULL, '2018-10-24 10:06:38', NULL);
INSERT INTO "referensi"."jabatan_tugas_ptk" VALUES (32, '1                   ', '0                   ', NULL, 'Pengelola TBM', NULL, '2018-10-24 10:06:38', NULL);
INSERT INTO "referensi"."jabatan_tugas_ptk" VALUES (33, '0                   ', '1                   ', NULL, 'PLT Kepala Sekolah', NULL, '2018-10-24 10:06:38', NULL);
INSERT INTO "referensi"."jabatan_tugas_ptk" VALUES (34, '0                   ', '1                   ', NULL, 'Wakil Kepala Sekolah Kesiswaan', NULL, '2018-10-24 10:06:38', NULL);
INSERT INTO "referensi"."jabatan_tugas_ptk" VALUES (35, '0                   ', '1                   ', NULL, 'Wakil Kepala Sekolah Sarpras', NULL, '2018-10-24 10:06:38', NULL);
INSERT INTO "referensi"."jabatan_tugas_ptk" VALUES (36, '0                   ', '1                   ', NULL, 'Wakil Kepala Sekolah Humas', NULL, '2018-10-24 10:06:38', NULL);
INSERT INTO "referensi"."jabatan_tugas_ptk" VALUES (37, '0                   ', '1                   ', NULL, 'Kepala Bengkel', NULL, '2018-10-24 10:06:38', NULL);
INSERT INTO "referensi"."jabatan_tugas_ptk" VALUES (38, '0                   ', '1                   ', NULL, 'Kepala Program Keahlian', NULL, '2018-10-24 10:06:38', NULL);
INSERT INTO "referensi"."jabatan_tugas_ptk" VALUES (39, '0                   ', '1                   ', NULL, 'Kepala Unit Produksi', NULL, '2018-10-24 10:06:38', NULL);
INSERT INTO "referensi"."jabatan_tugas_ptk" VALUES (40, '0                   ', '1                   ', NULL, 'Koordinator Laboratorium', NULL, '2018-10-24 10:06:38', NULL);
INSERT INTO "referensi"."jabatan_tugas_ptk" VALUES (41, '0                   ', '1                   ', NULL, 'Guru Piket', NULL, '2018-10-24 10:06:38', NULL);
INSERT INTO "referensi"."jabatan_tugas_ptk" VALUES (42, '0                   ', '1                   ', NULL, 'Pembina Pramuka Putra', NULL, '2018-10-24 10:06:38', NULL);
INSERT INTO "referensi"."jabatan_tugas_ptk" VALUES (43, '0                   ', '1                   ', NULL, 'Pembina Pramuka Putri', NULL, '2018-10-24 10:06:38', NULL);
INSERT INTO "referensi"."jabatan_tugas_ptk" VALUES (44, '0                   ', '1                   ', NULL, 'Pembina OSIS', NULL, '2018-10-24 10:06:38', NULL);
INSERT INTO "referensi"."jabatan_tugas_ptk" VALUES (45, '0                   ', '1                   ', NULL, 'Pembina Ekstrakurikuler', NULL, '2018-10-24 10:06:38', NULL);
INSERT INTO "referensi"."jabatan_tugas_ptk" VALUES (46, '0                   ', '1                   ', NULL, 'Wakil Kepala Sekolah Kurikulum', NULL, '2018-10-24 10:06:38', NULL);
INSERT INTO "referensi"."jabatan_tugas_ptk" VALUES (47, '0                   ', '1                   ', NULL, 'Instruktur Nasional', '2018-07-11 20:00:00', '2018-10-24 10:06:38', NULL);
INSERT INTO "referensi"."jabatan_tugas_ptk" VALUES (48, '0                   ', '1                   ', NULL, 'Narasumber Nasional', '2018-07-11 20:00:00', '2018-10-24 10:06:38', NULL);
INSERT INTO "referensi"."jabatan_tugas_ptk" VALUES (49, '0                   ', '1                   ', NULL, 'Tim Pengembang Kurikulum', '2018-07-11 20:00:00', '2018-10-24 10:06:38', NULL);
INSERT INTO "referensi"."jabatan_tugas_ptk" VALUES (50, '0                   ', '1                   ', NULL, 'Mentor Diklat/Kurikulum', '2018-07-11 20:00:00', '2018-10-24 10:06:38', NULL);
INSERT INTO "referensi"."jabatan_tugas_ptk" VALUES (61, '0                   ', '1                   ', NULL, 'Koordinator Pengembangan PKB/PKG', NULL, '2018-10-24 10:06:38', NULL);
INSERT INTO "referensi"."jabatan_tugas_ptk" VALUES (62, '0                   ', '1                   ', NULL, 'Koordinator Bursa Kerja Khusus SMK', NULL, '2018-10-24 10:06:38', NULL);
INSERT INTO "referensi"."jabatan_tugas_ptk" VALUES (63, '0                   ', '1                   ', NULL, 'Ketua LPS-P1 untuk SMK', NULL, '2018-10-24 10:06:38', NULL);
INSERT INTO "referensi"."jabatan_tugas_ptk" VALUES (64, '0                   ', '1                   ', NULL, 'Penilaian Kinerja Guru', NULL, '2018-10-24 10:06:38', NULL);
INSERT INTO "referensi"."jabatan_tugas_ptk" VALUES (65, '0                   ', '1                   ', NULL, 'Pengurus Organisasi Tingkat Nasional', NULL, '2018-10-24 10:06:38', NULL);
INSERT INTO "referensi"."jabatan_tugas_ptk" VALUES (66, '0                   ', '1                   ', NULL, 'Pengurus Organisasi Tingkat Propinsi', NULL, '2018-10-24 10:06:38', NULL);
INSERT INTO "referensi"."jabatan_tugas_ptk" VALUES (67, '0                   ', '1                   ', NULL, 'Pengurus Organisasi Tingkat Kabupaten / Kota', NULL, '2018-10-24 10:06:38', NULL);
INSERT INTO "referensi"."jabatan_tugas_ptk" VALUES (91, '0                   ', '1                   ', NULL, 'Bendahara BOS', NULL, '2018-10-24 10:06:38', NULL);
INSERT INTO "referensi"."jabatan_tugas_ptk" VALUES (98, '0                   ', '0                   ', NULL, 'Tidak diisi', NULL, '2018-10-24 10:06:38', NULL);
INSERT INTO "referensi"."jabatan_tugas_ptk" VALUES (99, '0                   ', '0                   ', NULL, 'Lainnya', NULL, '2018-10-24 10:06:38', NULL);
INSERT INTO "referensi"."jabatan_tugas_ptk" VALUES (151, '1                   ', '0                   ', NULL, 'Principal for Senior High School', NULL, '2018-10-24 10:06:38', NULL);
INSERT INTO "referensi"."jabatan_tugas_ptk" VALUES (152, '1                   ', '0                   ', NULL, 'Vice Principal for Senior High School', NULL, '2018-10-24 10:06:38', NULL);
INSERT INTO "referensi"."jabatan_tugas_ptk" VALUES (153, '1                   ', '0                   ', NULL, 'Principal for Junior High School', NULL, '2018-10-24 10:06:38', NULL);
INSERT INTO "referensi"."jabatan_tugas_ptk" VALUES (154, '1                   ', '0                   ', NULL, 'Vice Principal for Junior High School', NULL, '2018-10-24 10:06:38', NULL);
INSERT INTO "referensi"."jabatan_tugas_ptk" VALUES (155, '1                   ', '0                   ', NULL, 'Principal for Elementary School', NULL, '2018-10-24 10:06:38', NULL);
INSERT INTO "referensi"."jabatan_tugas_ptk" VALUES (156, '1                   ', '0                   ', NULL, 'Vice Principal for Elementary School', NULL, '2018-10-24 10:06:38', NULL);
INSERT INTO "referensi"."jabatan_tugas_ptk" VALUES (157, '1                   ', '0                   ', NULL, 'Academic Advisor', NULL, '2018-10-24 10:06:38', NULL);
INSERT INTO "referensi"."jabatan_tugas_ptk" VALUES (158, '1                   ', '0                   ', NULL, 'Management Advisor', NULL, '2018-10-24 10:06:38', NULL);
INSERT INTO "referensi"."jabatan_tugas_ptk" VALUES (159, '1                   ', '0                   ', NULL, 'Curriculum Development Advisor', NULL, '2018-10-24 10:06:38', NULL);
INSERT INTO "referensi"."jabatan_tugas_ptk" VALUES (160, '1                   ', '0                   ', NULL, 'Academic Specialist For E. School', NULL, '2018-10-24 10:06:38', NULL);
INSERT INTO "referensi"."jabatan_tugas_ptk" VALUES (161, '1                   ', '0                   ', NULL, 'Academic Specialist For J.High School', NULL, '2018-10-24 10:06:38', NULL);
INSERT INTO "referensi"."jabatan_tugas_ptk" VALUES (162, '1                   ', '0                   ', NULL, 'Academic Specialist For S.High School', NULL, '2018-10-24 10:06:38', NULL);
INSERT INTO "referensi"."jabatan_tugas_ptk" VALUES (163, '1                   ', '0                   ', NULL, 'Arabic Teacher', NULL, '2018-10-24 10:06:38', NULL);
INSERT INTO "referensi"."jabatan_tugas_ptk" VALUES (164, '1                   ', '0                   ', NULL, 'Islamic Study Teacher', NULL, '2018-10-24 10:06:38', NULL);
INSERT INTO "referensi"."jabatan_tugas_ptk" VALUES (165, '1                   ', '0                   ', NULL, 'Dutch Teacher', NULL, '2018-10-24 10:06:38', NULL);
INSERT INTO "referensi"."jabatan_tugas_ptk" VALUES (166, '1                   ', '0                   ', NULL, 'Mandarin  (Chinese) Teacher', NULL, '2018-10-24 10:06:38', NULL);
INSERT INTO "referensi"."jabatan_tugas_ptk" VALUES (167, '1                   ', '0                   ', NULL, 'English Teacher', NULL, '2018-10-24 10:06:38', NULL);
INSERT INTO "referensi"."jabatan_tugas_ptk" VALUES (168, '1                   ', '0                   ', NULL, 'Japanese Teacher', NULL, '2018-10-24 10:06:38', NULL);
INSERT INTO "referensi"."jabatan_tugas_ptk" VALUES (169, '1                   ', '0                   ', NULL, 'Korean Teacher', NULL, '2018-10-24 10:06:38', NULL);
INSERT INTO "referensi"."jabatan_tugas_ptk" VALUES (170, '1                   ', '0                   ', NULL, 'Deutsch Teacher', NULL, '2018-10-24 10:06:38', NULL);
INSERT INTO "referensi"."jabatan_tugas_ptk" VALUES (171, '1                   ', '0                   ', NULL, 'French Teacher', NULL, '2018-10-24 10:06:38', NULL);
INSERT INTO "referensi"."jabatan_tugas_ptk" VALUES (172, '1                   ', '0                   ', NULL, 'Turkish Teacher', NULL, '2018-10-24 10:06:38', NULL);
INSERT INTO "referensi"."jabatan_tugas_ptk" VALUES (173, '1                   ', '0                   ', NULL, 'Hindi Teacher', NULL, '2018-10-24 10:06:38', NULL);
INSERT INTO "referensi"."jabatan_tugas_ptk" VALUES (174, '1                   ', '0                   ', NULL, 'Physic Teacher', NULL, '2018-10-24 10:06:38', NULL);
INSERT INTO "referensi"."jabatan_tugas_ptk" VALUES (175, '1                   ', '0                   ', NULL, 'Biology Teacher', NULL, '2018-10-24 10:06:38', NULL);
INSERT INTO "referensi"."jabatan_tugas_ptk" VALUES (176, '1                   ', '0                   ', NULL, 'Mathematics Teacher', NULL, '2018-10-24 10:06:38', NULL);
INSERT INTO "referensi"."jabatan_tugas_ptk" VALUES (177, '1                   ', '0                   ', NULL, 'Business Study Teacher', NULL, '2018-10-24 10:06:38', NULL);
INSERT INTO "referensi"."jabatan_tugas_ptk" VALUES (178, '1                   ', '0                   ', NULL, 'Economics Teacher', NULL, '2018-10-24 10:06:38', NULL);
INSERT INTO "referensi"."jabatan_tugas_ptk" VALUES (179, '1                   ', '0                   ', NULL, 'Music Teacher', NULL, '2018-10-24 10:06:38', NULL);
INSERT INTO "referensi"."jabatan_tugas_ptk" VALUES (180, '1                   ', '0                   ', NULL, 'Geography Teacher', NULL, '2018-10-24 10:06:38', NULL);
INSERT INTO "referensi"."jabatan_tugas_ptk" VALUES (181, '1                   ', '0                   ', NULL, 'Science Teacher', NULL, '2018-10-24 10:06:38', NULL);
INSERT INTO "referensi"."jabatan_tugas_ptk" VALUES (182, '1                   ', '0                   ', NULL, 'Art Teacher', NULL, '2018-10-24 10:06:38', NULL);
INSERT INTO "referensi"."jabatan_tugas_ptk" VALUES (183, '1                   ', '0                   ', NULL, 'Health Teacher', NULL, '2018-10-24 10:06:38', NULL);
INSERT INTO "referensi"."jabatan_tugas_ptk" VALUES (184, '1                   ', '0                   ', NULL, 'Art and Music Teacher', NULL, '2018-10-24 10:06:38', NULL);
INSERT INTO "referensi"."jabatan_tugas_ptk" VALUES (185, '1                   ', '0                   ', NULL, 'Skills Teacher', NULL, '2018-10-24 10:06:38', NULL);
INSERT INTO "referensi"."jabatan_tugas_ptk" VALUES (186, '1                   ', '0                   ', NULL, 'Computer Teacher', NULL, '2018-10-24 10:06:38', NULL);
INSERT INTO "referensi"."jabatan_tugas_ptk" VALUES (187, '1                   ', '0                   ', NULL, 'Physical Education Teacher', NULL, '2018-10-24 10:06:38', NULL);
INSERT INTO "referensi"."jabatan_tugas_ptk" VALUES (188, '1                   ', '0                   ', NULL, 'Moral Ethic Teacher', NULL, '2018-10-24 10:06:38', NULL);
INSERT INTO "referensi"."jabatan_tugas_ptk" VALUES (189, '1                   ', '0                   ', NULL, '6 th Grade Teacher', NULL, '2018-10-24 10:06:38', NULL);
INSERT INTO "referensi"."jabatan_tugas_ptk" VALUES (190, '1                   ', '0                   ', NULL, '5 th Grade Teacher', NULL, '2018-10-24 10:06:38', NULL);
INSERT INTO "referensi"."jabatan_tugas_ptk" VALUES (191, '1                   ', '0                   ', NULL, '4 th Grade Teacher', NULL, '2018-10-24 10:06:38', NULL);
INSERT INTO "referensi"."jabatan_tugas_ptk" VALUES (192, '1                   ', '0                   ', NULL, '3 rd Grade Teacher', NULL, '2018-10-24 10:06:38', NULL);
INSERT INTO "referensi"."jabatan_tugas_ptk" VALUES (193, '1                   ', '0                   ', NULL, '2 nd Grade Teacher', NULL, '2018-10-24 10:06:38', NULL);
INSERT INTO "referensi"."jabatan_tugas_ptk" VALUES (194, '1                   ', '0                   ', NULL, '1st Grade  Teacher', NULL, '2018-10-24 10:06:38', NULL);
INSERT INTO "referensi"."jabatan_tugas_ptk" VALUES (195, '1                   ', '0                   ', NULL, 'Play Group Teacher', NULL, '2018-10-24 10:06:38', NULL);
INSERT INTO "referensi"."jabatan_tugas_ptk" VALUES (196, '1                   ', '0                   ', NULL, 'Kindergarten Teacher', NULL, '2018-10-24 10:06:38', NULL);
INSERT INTO "referensi"."jabatan_tugas_ptk" VALUES (197, '1                   ', '0                   ', NULL, 'Special Needs Teacher', NULL, '2018-10-24 10:06:38', NULL);
INSERT INTO "referensi"."jabatan_tugas_ptk" VALUES (198, '1                   ', '0                   ', NULL, 'Teaching Assistant', NULL, '2018-10-24 10:06:38', NULL);

-- ----------------------------
-- Table structure for jenis_keluar
-- ----------------------------
DROP TABLE IF EXISTS "referensi"."jenis_keluar";
CREATE TABLE "referensi"."jenis_keluar" (
  "id" int4 NOT NULL,
  "jenis_keluar" varchar(150) COLLATE "pg_catalog"."default" DEFAULT NULL::character varying,
  "keluar_pd" numeric(1,0),
  "keluar_ptk" numeric(1,0),
  "created_at" timestamp(6),
  "updated_at" timestamp(6),
  "expired_at" timestamp(6)
)
;

-- ----------------------------
-- Records of jenis_keluar
-- ----------------------------
INSERT INTO "referensi"."jenis_keluar" VALUES (0, 'Aktif', 1, 1, '2019-10-03 10:43:26', '2019-10-03 10:43:32', NULL);
INSERT INTO "referensi"."jenis_keluar" VALUES (1, 'Lulus', 1, 0, '2013-07-09 00:00:00', '2016-07-22 06:00:00', NULL);
INSERT INTO "referensi"."jenis_keluar" VALUES (2, 'Mutasi', 1, 1, '2013-07-09 00:00:00', '2016-07-22 06:00:00', NULL);
INSERT INTO "referensi"."jenis_keluar" VALUES (3, 'Dikeluarkan', 1, 1, '2013-07-09 00:00:00', '2016-07-22 06:00:00', NULL);
INSERT INTO "referensi"."jenis_keluar" VALUES (4, 'Mengundurkan diri', 1, 1, '2013-07-09 00:00:00', '2016-07-22 06:00:00', NULL);
INSERT INTO "referensi"."jenis_keluar" VALUES (5, 'Putus Sekolah', 1, 0, '2013-07-09 00:00:00', '2016-07-22 06:00:00', NULL);
INSERT INTO "referensi"."jenis_keluar" VALUES (6, 'Wafat', 1, 1, '2013-07-09 00:00:00', '2016-07-22 06:00:00', NULL);
INSERT INTO "referensi"."jenis_keluar" VALUES (7, 'Hilang', 1, 1, '2013-11-07 00:00:00', '2016-07-22 06:00:00', NULL);
INSERT INTO "referensi"."jenis_keluar" VALUES (8, 'Alih Fungsi', 0, 1, '2013-11-07 00:00:00', '2016-07-22 06:00:00', NULL);
INSERT INTO "referensi"."jenis_keluar" VALUES (9, 'Pensiun', 0, 1, '2013-11-07 00:00:00', '2016-07-22 06:00:00', NULL);
INSERT INTO "referensi"."jenis_keluar" VALUES (99, 'Lainnya', 1, 1, '2013-11-07 00:00:00', '2016-07-22 06:00:00', NULL);

-- ----------------------------
-- Table structure for jenis_pendaftaran
-- ----------------------------
DROP TABLE IF EXISTS "referensi"."jenis_pendaftaran";
CREATE TABLE "referensi"."jenis_pendaftaran" (
  "id" int4 NOT NULL,
  "jenis_pendaftaran" varchar(150) COLLATE "pg_catalog"."default" NOT NULL,
  "daftar_sekolah" numeric(1,0),
  "daftar_rombel" numeric(1,0),
  "created_at" timestamp(6),
  "updated_at" timestamp(6),
  "expired_at" timestamp(6)
)
;

-- ----------------------------
-- Records of jenis_pendaftaran
-- ----------------------------
INSERT INTO "referensi"."jenis_pendaftaran" VALUES (1, 'Siswa baru', 1, 1, '2013-05-13 00:00:00', '2016-07-22 06:00:00', NULL);
INSERT INTO "referensi"."jenis_pendaftaran" VALUES (2, 'Pindahan', 1, 1, '2013-05-13 00:00:00', '2016-07-22 06:00:00', NULL);
INSERT INTO "referensi"."jenis_pendaftaran" VALUES (3, 'Naik kelas', 0, 1, '2013-05-13 00:00:00', '2016-07-22 06:00:00', NULL);
INSERT INTO "referensi"."jenis_pendaftaran" VALUES (4, 'Akselerasi', 0, 1, '2013-05-13 00:00:00', '2016-07-22 06:00:00', NULL);
INSERT INTO "referensi"."jenis_pendaftaran" VALUES (5, 'Mengulang', 0, 1, '2013-05-13 00:00:00', '2016-07-22 06:00:00', NULL);
INSERT INTO "referensi"."jenis_pendaftaran" VALUES (6, 'Lanjutan semester', 0, 1, '2013-05-13 00:00:00', '2016-07-22 06:00:00', NULL);
INSERT INTO "referensi"."jenis_pendaftaran" VALUES (7, 'Kembali bersekolah', 1, 1, '2015-09-03 17:30:00', '2016-07-22 06:00:00', NULL);
INSERT INTO "referensi"."jenis_pendaftaran" VALUES (9, 'Putus Sekolah', 0, 0, '2013-05-13 00:00:00', '2016-07-22 06:00:00', '2013-05-13 00:00:00');

-- ----------------------------
-- Table structure for jenis_ptk
-- ----------------------------
DROP TABLE IF EXISTS "referensi"."jenis_ptk";
CREATE TABLE "referensi"."jenis_ptk" (
  "id" int4 NOT NULL,
  "jenis_ptk" varchar(150) COLLATE "pg_catalog"."default" NOT NULL,
  "guru_kelas" numeric(1,0),
  "guru_matpel" numeric(1,0),
  "guru_bk" numeric(1,0),
  "guru_inklusi" numeric(1,0),
  "pengawas_satdik" numeric(1,0),
  "pengawas_plb" numeric(1,0),
  "pengawas_matpel" numeric(1,0),
  "pengawas_bidang" numeric(1,0),
  "tas" numeric(1,0),
  "formal" numeric(1,0),
  "created_at" timestamp(6),
  "updated_at" timestamp(6),
  "expired_at" timestamp(6)
)
;

-- ----------------------------
-- Records of jenis_ptk
-- ----------------------------
INSERT INTO "referensi"."jenis_ptk" VALUES (3, 'Guru Kelas', 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2013-05-08 00:00:00', '2016-07-22 06:00:00', NULL);
INSERT INTO "referensi"."jenis_ptk" VALUES (4, 'Guru Mapel', 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, '2013-05-08 00:00:00', '2016-07-22 06:00:00', NULL);
INSERT INTO "referensi"."jenis_ptk" VALUES (5, 'Guru BK', 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '2013-05-08 00:00:00', '2016-07-22 06:00:00', NULL);
INSERT INTO "referensi"."jenis_ptk" VALUES (6, 'Guru Inklusi', 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, '2013-05-08 00:00:00', '2016-07-22 06:00:00', NULL);
INSERT INTO "referensi"."jenis_ptk" VALUES (7, 'Pengawas Satuan Pendidikan', 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, '2013-05-08 00:00:00', '2016-07-22 06:00:00', NULL);
INSERT INTO "referensi"."jenis_ptk" VALUES (8, 'Pengawas PLB', 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, '2013-09-05 00:00:00', '2016-07-22 06:00:00', NULL);
INSERT INTO "referensi"."jenis_ptk" VALUES (9, 'Pengawas Metpel/Rumpun', 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, '2013-09-05 00:00:00', '2017-12-06 15:42:17', NULL);
INSERT INTO "referensi"."jenis_ptk" VALUES (10, 'Pengawas Bidang', 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, '2013-09-05 00:00:00', '2016-07-22 06:00:00', NULL);
INSERT INTO "referensi"."jenis_ptk" VALUES (12, 'Guru Pendamping', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2013-09-30 00:00:00', '2017-12-06 15:42:17', NULL);
INSERT INTO "referensi"."jenis_ptk" VALUES (13, 'Guru Magang', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2013-09-30 00:00:00', '2017-12-06 15:42:17', NULL);
INSERT INTO "referensi"."jenis_ptk" VALUES (14, 'Guru TIK', 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, '2014-05-08 00:00:00', '2016-07-22 06:00:00', NULL);
INSERT INTO "referensi"."jenis_ptk" VALUES (20, 'Kepala Sekolah', 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, '2017-07-18 00:00:00', '2017-12-06 15:42:17', NULL);
INSERT INTO "referensi"."jenis_ptk" VALUES (25, 'Pengawas BK', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2017-02-07 18:00:00', '2018-03-28 16:04:30', NULL);
INSERT INTO "referensi"."jenis_ptk" VALUES (26, 'Pengawas SD', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2017-02-07 18:00:00', '2017-12-06 15:42:17', NULL);
INSERT INTO "referensi"."jenis_ptk" VALUES (30, 'Laboran', 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, '2014-05-08 00:00:00', '2016-07-22 06:00:00', NULL);
INSERT INTO "referensi"."jenis_ptk" VALUES (40, 'Tenaga Perpustakaan', 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, '2014-05-08 00:00:00', '2017-12-06 15:42:17', NULL);
INSERT INTO "referensi"."jenis_ptk" VALUES (41, 'Tukang Kebun', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2016-07-22 06:00:00', '2016-07-22 06:00:00', NULL);
INSERT INTO "referensi"."jenis_ptk" VALUES (42, 'Penjaga Sekolah', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2016-07-22 06:00:00', '2016-07-22 06:00:00', NULL);
INSERT INTO "referensi"."jenis_ptk" VALUES (43, 'Petugas Keamanan', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2016-07-22 06:00:00', '2016-07-22 06:00:00', NULL);
INSERT INTO "referensi"."jenis_ptk" VALUES (44, 'Pesuruh/Office Boy', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2016-07-22 06:00:00', '2016-07-22 06:00:00', NULL);
INSERT INTO "referensi"."jenis_ptk" VALUES (56, 'Play Group Teacher', 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2015-05-14 00:00:00', '2016-07-22 06:00:00', NULL);
INSERT INTO "referensi"."jenis_ptk" VALUES (99, 'Lainnya', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2013-05-08 00:00:00', '2017-12-06 15:42:17', NULL);
INSERT INTO "referensi"."jenis_ptk" VALUES (51, 'Academic Advisor', 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, '2015-05-14 00:00:00', '2016-07-22 06:00:00', '2023-05-21 08:18:02');
INSERT INTO "referensi"."jenis_ptk" VALUES (52, 'Academic Specialist', 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, '2015-05-14 00:00:00', '2016-07-22 06:00:00', '2023-05-21 08:18:02');
INSERT INTO "referensi"."jenis_ptk" VALUES (53, 'Curriculum Development Advisor', 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, '2015-05-14 00:00:00', '2016-07-22 06:00:00', '2023-05-21 08:18:02');
INSERT INTO "referensi"."jenis_ptk" VALUES (54, 'Kindergarten Teacher', 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2015-05-14 00:00:00', '2016-07-22 06:00:00', '2023-05-21 08:18:02');
INSERT INTO "referensi"."jenis_ptk" VALUES (55, 'Management Advisor', 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2015-05-14 00:00:00', '2016-07-22 06:00:00', '2023-05-21 08:18:02');
INSERT INTO "referensi"."jenis_ptk" VALUES (57, 'Principal', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2015-05-14 00:00:00', '2016-07-22 06:00:00', '2023-05-21 08:18:02');
INSERT INTO "referensi"."jenis_ptk" VALUES (58, 'Teaching Assistant', 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, '2015-05-14 00:00:00', '2016-07-22 06:00:00', '2023-05-21 08:18:02');
INSERT INTO "referensi"."jenis_ptk" VALUES (59, 'Vice Principal', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '2015-05-14 00:00:00', '2016-07-22 06:00:00', '2023-05-21 08:18:02');
INSERT INTO "referensi"."jenis_ptk" VALUES (11, 'Tenaga Administrasi Sekolah', 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, '2013-09-05 00:00:00', '2016-07-22 06:00:00', NULL);

-- ----------------------------
-- Table structure for jenis_tinggal
-- ----------------------------
DROP TABLE IF EXISTS "referensi"."jenis_tinggal";
CREATE TABLE "referensi"."jenis_tinggal" (
  "id" int4 NOT NULL,
  "jenis_tinggal" varchar(150) COLLATE "pg_catalog"."default" NOT NULL,
  "created_at" timestamp(6) NOT NULL,
  "updated_at" timestamp(6),
  "expired_at" timestamp(6)
)
;

-- ----------------------------
-- Records of jenis_tinggal
-- ----------------------------
INSERT INTO "referensi"."jenis_tinggal" VALUES (0, 'unknown', '2014-01-02 04:21:07', '2017-12-06 15:42:17', '2014-01-02 04:21:07');
INSERT INTO "referensi"."jenis_tinggal" VALUES (1, 'Bersama orang tua', '2013-05-13 00:00:00', '2017-12-06 15:42:17', NULL);
INSERT INTO "referensi"."jenis_tinggal" VALUES (2, 'Wali', '2013-05-13 00:00:00', '2017-12-06 15:42:17', NULL);
INSERT INTO "referensi"."jenis_tinggal" VALUES (3, 'Kost', '2013-05-13 00:00:00', '2017-12-06 15:42:17', NULL);
INSERT INTO "referensi"."jenis_tinggal" VALUES (4, 'Asrama', '2013-05-13 00:00:00', '2017-12-06 15:42:17', NULL);
INSERT INTO "referensi"."jenis_tinggal" VALUES (5, 'Panti asuhan', '2013-05-13 00:00:00', '2017-12-06 15:42:17', NULL);
INSERT INTO "referensi"."jenis_tinggal" VALUES (6, 'unknown', '2014-01-02 04:21:23', '2017-12-06 15:42:17', '2014-01-02 04:21:07');
INSERT INTO "referensi"."jenis_tinggal" VALUES (7, 'unknown', '2014-01-02 04:21:34', '2017-12-06 15:42:17', '2014-01-02 04:21:23');
INSERT INTO "referensi"."jenis_tinggal" VALUES (8, 'unknown', '2014-01-02 04:21:43', '2017-12-06 15:42:17', '2014-01-02 04:21:43');
INSERT INTO "referensi"."jenis_tinggal" VALUES (9, 'unknown', '2014-01-02 04:21:52', '2017-12-06 15:42:17', '2014-01-02 04:21:43');
INSERT INTO "referensi"."jenis_tinggal" VALUES (10, 'Pesantren', '2017-07-21 00:00:00', '2017-12-06 15:42:17', NULL);
INSERT INTO "referensi"."jenis_tinggal" VALUES (99, 'Lainnya', '2013-05-13 00:00:00', '2017-12-06 15:42:17', NULL);

-- ----------------------------
-- Table structure for jenjang_pendidikan
-- ----------------------------
DROP TABLE IF EXISTS "referensi"."jenjang_pendidikan";
CREATE TABLE "referensi"."jenjang_pendidikan" (
  "id" int4 NOT NULL,
  "jenjang_pendidikan" varchar(150) COLLATE "pg_catalog"."default" NOT NULL,
  "jenjang_lembaga" numeric(1,0),
  "jenjang_orang" numeric(1,0),
  "created_at" timestamp(6),
  "updated_at" timestamp(6),
  "expired_at" timestamp(6)
)
;

-- ----------------------------
-- Records of jenjang_pendidikan
-- ----------------------------
INSERT INTO "referensi"."jenjang_pendidikan" VALUES (0, 'Tidak sekolah', 0, 1, '2013-05-13 00:00:00', '2016-07-22 06:00:00', NULL);
INSERT INTO "referensi"."jenjang_pendidikan" VALUES (1, 'PAUD', 1, 0, '2013-05-13 00:00:00', '2016-07-22 06:00:00', NULL);
INSERT INTO "referensi"."jenjang_pendidikan" VALUES (2, 'TK / sederajat', 1, 0, '2013-05-13 00:00:00', '2016-07-22 06:00:00', NULL);
INSERT INTO "referensi"."jenjang_pendidikan" VALUES (3, 'Putus SD', 0, 1, '2013-05-13 00:00:00', '2016-07-22 06:00:00', NULL);
INSERT INTO "referensi"."jenjang_pendidikan" VALUES (4, 'SD / sederajat', 1, 1, '2013-05-13 00:00:00', '2016-07-22 06:00:00', NULL);
INSERT INTO "referensi"."jenjang_pendidikan" VALUES (5, 'SMP / sederajat', 1, 1, '2013-05-13 00:00:00', '2016-07-22 06:00:00', NULL);
INSERT INTO "referensi"."jenjang_pendidikan" VALUES (6, 'SMA / sederajat', 1, 1, '2013-05-13 00:00:00', '2016-07-22 06:00:00', NULL);
INSERT INTO "referensi"."jenjang_pendidikan" VALUES (7, 'Paket A', 1, 0, '2013-05-13 00:00:00', '2016-07-22 06:00:00', NULL);
INSERT INTO "referensi"."jenjang_pendidikan" VALUES (8, 'Paket B', 1, 0, '2013-05-13 00:00:00', '2016-07-22 06:00:00', NULL);
INSERT INTO "referensi"."jenjang_pendidikan" VALUES (9, 'Paket C', 1, 0, '2013-05-13 00:00:00', '2016-07-22 06:00:00', NULL);
INSERT INTO "referensi"."jenjang_pendidikan" VALUES (20, 'D1', 1, 1, '2013-05-13 00:00:00', '2016-07-22 06:00:00', NULL);
INSERT INTO "referensi"."jenjang_pendidikan" VALUES (21, 'D2', 1, 1, '2013-05-13 00:00:00', '2016-07-22 06:00:00', NULL);
INSERT INTO "referensi"."jenjang_pendidikan" VALUES (22, 'D3', 1, 1, '2013-05-14 00:00:00', '2016-07-22 06:00:00', NULL);
INSERT INTO "referensi"."jenjang_pendidikan" VALUES (23, 'D4', 1, 1, '2013-05-14 00:00:00', '2016-07-22 06:00:00', NULL);
INSERT INTO "referensi"."jenjang_pendidikan" VALUES (30, 'S1', 1, 1, '2013-05-14 00:00:00', '2016-07-22 06:00:00', NULL);
INSERT INTO "referensi"."jenjang_pendidikan" VALUES (35, 'S2', 1, 1, '2013-05-14 00:00:00', '2016-07-22 06:00:00', NULL);
INSERT INTO "referensi"."jenjang_pendidikan" VALUES (40, 'S3', 1, 1, '2013-05-14 00:00:00', '2016-07-22 06:00:00', NULL);
INSERT INTO "referensi"."jenjang_pendidikan" VALUES (90, 'Non formal', 1, 0, '2013-05-14 00:00:00', '2016-07-22 06:00:00', NULL);
INSERT INTO "referensi"."jenjang_pendidikan" VALUES (91, 'Informal', 1, 0, '2013-05-14 00:00:00', '2016-07-22 06:00:00', NULL);
INSERT INTO "referensi"."jenjang_pendidikan" VALUES (98, '(tidak diisi)', 0, 0, '2013-05-25 00:00:00', '2016-07-22 06:00:00', '2013-05-25 00:00:00');
INSERT INTO "referensi"."jenjang_pendidikan" VALUES (99, 'Lainnya', 1, 0, '2013-05-14 00:00:00', '2021-01-16 15:04:15', '2021-01-16 15:04:03');

-- ----------------------------
-- Table structure for kurikulum
-- ----------------------------
DROP TABLE IF EXISTS "referensi"."kurikulum";
CREATE TABLE "referensi"."kurikulum" (
  "id" uuid NOT NULL,
  "kode" varchar(150) COLLATE "pg_catalog"."default" NOT NULL,
  "kurikulum" varchar(150) COLLATE "pg_catalog"."default" NOT NULL,
  "created_at" timestamp(0),
  "updated_at" timestamp(0),
  "expired_at" timestamp(0)
)
;

-- ----------------------------
-- Records of kurikulum
-- ----------------------------
INSERT INTO "referensi"."kurikulum" VALUES ('98e4e8b4-3da5-4748-80f6-ecb92508935c', 'KM', 'Kurikulum Merdeka', '2023-04-10 01:14:00', '2023-04-10 01:15:04', NULL);
INSERT INTO "referensi"."kurikulum" VALUES ('98e4e8cf-ca0c-43fb-a923-3f1c955a66f9', 'K13', 'Kurikulum 2013', '2023-04-10 01:14:18', '2023-04-10 01:15:07', NULL);

-- ----------------------------
-- Table structure for pangkat_golongan
-- ----------------------------
DROP TABLE IF EXISTS "referensi"."pangkat_golongan";
CREATE TABLE "referensi"."pangkat_golongan" (
  "id" int4 NOT NULL,
  "golongan" varchar(50) COLLATE "pg_catalog"."default",
  "sub_golongan" varchar(50) COLLATE "pg_catalog"."default",
  "pangkat" varchar(100) COLLATE "pg_catalog"."default",
  "created_at" timestamp(6),
  "created_by" char(36) COLLATE "pg_catalog"."default",
  "updated_at" timestamp(6),
  "updated_by" char(36) COLLATE "pg_catalog"."default",
  "deleted_at" timestamp(6),
  "deleted_by" char(36) COLLATE "pg_catalog"."default"
)
;

-- ----------------------------
-- Records of pangkat_golongan
-- ----------------------------
INSERT INTO "referensi"."pangkat_golongan" VALUES (1, 'I', 'I/a', 'Juru Muda', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO "referensi"."pangkat_golongan" VALUES (2, 'I', 'I/b', 'Juru Muda Tingkat I', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO "referensi"."pangkat_golongan" VALUES (3, 'I', 'I/c', 'Juru', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO "referensi"."pangkat_golongan" VALUES (4, 'I', 'I/d', 'Juru Tingkat I', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO "referensi"."pangkat_golongan" VALUES (5, 'II', 'II/a', 'Pengatur Muda', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO "referensi"."pangkat_golongan" VALUES (6, 'II', 'II/b', 'Pengatur Muda Tingkat I', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO "referensi"."pangkat_golongan" VALUES (7, 'II', 'II/c', 'Pengatur', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO "referensi"."pangkat_golongan" VALUES (8, 'II', 'II/d', 'Pengatur Tingkat I', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO "referensi"."pangkat_golongan" VALUES (9, 'III', 'III/a', 'Penata Muda', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO "referensi"."pangkat_golongan" VALUES (10, 'III', 'III/b', 'Penata Muda Tingkat I', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO "referensi"."pangkat_golongan" VALUES (11, 'III', 'III/c', 'Penata', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO "referensi"."pangkat_golongan" VALUES (12, 'III', 'III/d', 'Penata Tingkat I', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO "referensi"."pangkat_golongan" VALUES (13, 'IV', 'IV/a', 'Pembina', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO "referensi"."pangkat_golongan" VALUES (14, 'IV', 'IV/b', 'Pembina Tingkat I', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO "referensi"."pangkat_golongan" VALUES (15, 'IV', 'IV/c', 'Pembina Utama Muda', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO "referensi"."pangkat_golongan" VALUES (16, 'IV', 'IV/d', 'Pembina Utama Madya', NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO "referensi"."pangkat_golongan" VALUES (17, 'IV', 'IV/e', 'Pembina Utama', NULL, NULL, NULL, NULL, NULL, NULL);

-- ----------------------------
-- Table structure for pekerjaan
-- ----------------------------
DROP TABLE IF EXISTS "referensi"."pekerjaan";
CREATE TABLE "referensi"."pekerjaan" (
  "id" int4 NOT NULL,
  "pekerjaan" varchar(150) COLLATE "pg_catalog"."default" DEFAULT NULL::character varying,
  "created_at" timestamp(6),
  "updated_at" timestamp(6),
  "expired_at" timestamp(6)
)
;

-- ----------------------------
-- Records of pekerjaan
-- ----------------------------
INSERT INTO "referensi"."pekerjaan" VALUES (0, '', '2013-05-25 00:00:00', '2016-07-22 06:00:00', '2013-09-04 00:00:00');
INSERT INTO "referensi"."pekerjaan" VALUES (1, 'Tidak bekerja', '2013-05-13 00:00:00', '2016-07-22 06:00:00', NULL);
INSERT INTO "referensi"."pekerjaan" VALUES (2, 'Nelayan', '2013-05-13 00:00:00', '2016-07-22 06:00:00', NULL);
INSERT INTO "referensi"."pekerjaan" VALUES (3, 'Petani', '2013-05-13 00:00:00', '2016-07-22 06:00:00', NULL);
INSERT INTO "referensi"."pekerjaan" VALUES (4, 'Peternak', '2013-05-13 00:00:00', '2016-07-22 06:00:00', NULL);
INSERT INTO "referensi"."pekerjaan" VALUES (5, 'PNS/TNI/Polri', '2013-05-13 00:00:00', '2016-07-22 06:00:00', NULL);
INSERT INTO "referensi"."pekerjaan" VALUES (6, 'Karyawan Swasta', '2013-05-13 00:00:00', '2016-07-22 06:00:00', NULL);
INSERT INTO "referensi"."pekerjaan" VALUES (7, 'Pedagang Kecil', '2013-05-13 00:00:00', '2016-07-22 06:00:00', NULL);
INSERT INTO "referensi"."pekerjaan" VALUES (8, 'Pedagang Besar', '2013-05-13 00:00:00', '2016-07-22 06:00:00', NULL);
INSERT INTO "referensi"."pekerjaan" VALUES (9, 'Wiraswasta', '2013-05-13 00:00:00', '2016-07-22 06:00:00', NULL);
INSERT INTO "referensi"."pekerjaan" VALUES (10, 'Wirausaha', '2013-05-13 00:00:00', '2016-07-22 06:00:00', NULL);
INSERT INTO "referensi"."pekerjaan" VALUES (11, 'Buruh', '2013-05-13 00:00:00', '2016-07-22 06:00:00', NULL);
INSERT INTO "referensi"."pekerjaan" VALUES (12, 'Pensiunan', '2013-05-13 00:00:00', '2016-07-22 06:00:00', NULL);
INSERT INTO "referensi"."pekerjaan" VALUES (13, 'Tenaga Kerja Indonesia', '2016-02-14 10:00:00', '2016-07-22 06:00:00', NULL);
INSERT INTO "referensi"."pekerjaan" VALUES (90, 'Tidak dapat diterapkan', '2015-07-30 12:05:00', '2016-07-22 06:00:00', NULL);
INSERT INTO "referensi"."pekerjaan" VALUES (98, 'Sudah Meninggal', '2013-09-04 00:00:00', '2016-07-22 06:00:00', NULL);
INSERT INTO "referensi"."pekerjaan" VALUES (99, 'Lainnya', '2013-09-04 00:00:00', '2016-07-22 06:00:00', NULL);

-- ----------------------------
-- Table structure for penghasilan
-- ----------------------------
DROP TABLE IF EXISTS "referensi"."penghasilan";
CREATE TABLE "referensi"."penghasilan" (
  "id" int4 NOT NULL,
  "penghasilan" varchar(150) COLLATE "pg_catalog"."default" NOT NULL,
  "batas_bawah" int4,
  "batas_atas" int4,
  "created_at" timestamp(6),
  "updated_at" timestamp(6),
  "expired_at" timestamp(6)
)
;

-- ----------------------------
-- Records of penghasilan
-- ----------------------------
INSERT INTO "referensi"."penghasilan" VALUES (0, '-', 0, 0, '2013-05-25 00:00:00', '2016-07-22 06:00:00', NULL);
INSERT INTO "referensi"."penghasilan" VALUES (1, 'Kurang dari Rp 1.000.000', 0, 0, '2013-05-13 00:00:00', '2016-07-22 06:00:00', '2013-01-08 00:00:00');
INSERT INTO "referensi"."penghasilan" VALUES (2, 'Rp 1.000.000 - Rp 2.000.000', 0, 0, '2013-05-13 00:00:00', '2016-07-22 06:00:00', '2013-01-08 00:00:00');
INSERT INTO "referensi"."penghasilan" VALUES (3, 'Lebih dari Rp 2.000.000', 0, 0, '2013-05-13 00:00:00', '2016-07-22 06:00:00', '2013-01-08 00:00:00');
INSERT INTO "referensi"."penghasilan" VALUES (9, 'Lainnya', 0, 0, '2013-05-14 00:00:00', '2016-07-22 06:00:00', '2013-01-08 00:00:00');
INSERT INTO "referensi"."penghasilan" VALUES (11, 'Kurang dari Rp. 500,000', 499999, 0, '2013-07-05 00:00:00', '2016-07-22 06:00:00', NULL);
INSERT INTO "referensi"."penghasilan" VALUES (12, 'Rp. 500,000 - Rp. 999,999', 999999, 500000, '2013-07-05 00:00:00', '2016-07-22 06:00:00', NULL);
INSERT INTO "referensi"."penghasilan" VALUES (13, 'Rp. 1,000,000 - Rp. 1,999,999', 1999999, 1000000, '2013-07-05 00:00:00', '2016-07-22 06:00:00', NULL);
INSERT INTO "referensi"."penghasilan" VALUES (14, 'Rp. 2,000,000 - Rp. 4,999,999', 4999999, 2000000, '2013-07-05 00:00:00', '2016-07-22 06:00:00', NULL);
INSERT INTO "referensi"."penghasilan" VALUES (15, 'Rp. 5,000,000 - Rp. 20,000,000', 20000000, 5000000, '2013-07-05 00:00:00', '2016-07-22 06:00:00', NULL);
INSERT INTO "referensi"."penghasilan" VALUES (16, 'Lebih dari Rp. 20,000,000', 0, 20000001, '2013-07-05 00:00:00', '2016-07-22 06:00:00', NULL);
INSERT INTO "referensi"."penghasilan" VALUES (99, 'Tidak Berpenghasilan', 0, 0, '2017-07-31 17:18:52', '2017-12-06 15:42:17', NULL);

-- ----------------------------
-- Table structure for status_kepegawaian
-- ----------------------------
DROP TABLE IF EXISTS "referensi"."status_kepegawaian";
CREATE TABLE "referensi"."status_kepegawaian" (
  "id" int4 NOT NULL,
  "status_kepegawaian" varchar(150) COLLATE "pg_catalog"."default" NOT NULL,
  "created_at" timestamp(6) NOT NULL,
  "updated_at" timestamp(6),
  "expired_at" timestamp(6)
)
;

-- ----------------------------
-- Records of status_kepegawaian
-- ----------------------------
INSERT INTO "referensi"."status_kepegawaian" VALUES (1, 'PNS', '2013-05-13 00:00:00', '2016-07-22 06:00:00', NULL);
INSERT INTO "referensi"."status_kepegawaian" VALUES (2, 'PNS Diperbantukan', '2013-05-13 00:00:00', '2016-07-22 06:00:00', NULL);
INSERT INTO "referensi"."status_kepegawaian" VALUES (3, 'PNS Depag', '2013-05-13 00:00:00', '2016-07-22 06:00:00', NULL);
INSERT INTO "referensi"."status_kepegawaian" VALUES (4, 'GTY/PTY', '2013-05-13 00:00:00', '2016-07-22 06:00:00', NULL);
INSERT INTO "referensi"."status_kepegawaian" VALUES (5, 'Honor Daerah TK.I Provinsi', '2013-05-13 00:00:00', '2016-07-22 06:00:00', NULL);
INSERT INTO "referensi"."status_kepegawaian" VALUES (6, 'Honor Daerah TK.II Kab/Kota', '2013-05-13 00:00:00', '2016-07-22 06:00:00', NULL);
INSERT INTO "referensi"."status_kepegawaian" VALUES (7, 'Guru Bantu Pusat', '2013-05-13 00:00:00', '2018-03-28 16:04:30', '2018-01-27 01:00:00');
INSERT INTO "referensi"."status_kepegawaian" VALUES (8, 'Guru Honor Sekolah', '2013-05-13 00:00:00', '2016-07-22 06:00:00', NULL);
INSERT INTO "referensi"."status_kepegawaian" VALUES (9, 'Tenaga Honor Sekolah', '2013-05-13 00:00:00', '2016-07-22 06:00:00', NULL);
INSERT INTO "referensi"."status_kepegawaian" VALUES (10, 'CPNS', '2014-02-07 16:14:44', '2016-07-22 06:00:00', NULL);
INSERT INTO "referensi"."status_kepegawaian" VALUES (51, 'Kontrak Kerja WNA', '2015-05-14 00:00:00', '2016-07-22 06:00:00', NULL);
INSERT INTO "referensi"."status_kepegawaian" VALUES (99, 'Lainnya', '2013-04-30 00:00:00', '2017-12-06 15:42:17', '2017-02-07 00:00:00');

-- ----------------------------
-- Table structure for tingkat_kelas
-- ----------------------------
DROP TABLE IF EXISTS "referensi"."tingkat_kelas";
CREATE TABLE "referensi"."tingkat_kelas" (
  "id" int4 NOT NULL,
  "kode" varchar(50) COLLATE "pg_catalog"."default",
  "tingkat_kelas" varchar(100) COLLATE "pg_catalog"."default",
  "sd" int4,
  "smp" int4,
  "sma" int4,
  "smk" int4,
  "expired_at" timestamp(6),
  "created_at" timestamp(6),
  "updated_at" timestamp(6)
)
;

-- ----------------------------
-- Records of tingkat_kelas
-- ----------------------------
INSERT INTO "referensi"."tingkat_kelas" VALUES (1, 'I', 'Kelas I', 1, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO "referensi"."tingkat_kelas" VALUES (2, 'II', 'Kelas II', 1, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO "referensi"."tingkat_kelas" VALUES (3, 'III', 'Kelas III', 1, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO "referensi"."tingkat_kelas" VALUES (4, 'IV', 'Kelas IV', 1, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO "referensi"."tingkat_kelas" VALUES (5, 'V', 'Kelas V', 1, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO "referensi"."tingkat_kelas" VALUES (6, 'VI', 'Kelas VI', 1, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO "referensi"."tingkat_kelas" VALUES (7, 'VII', 'Kelas VII', NULL, 1, NULL, NULL, NULL, NULL, NULL);
INSERT INTO "referensi"."tingkat_kelas" VALUES (8, 'VIII', 'Kelas VIII', NULL, 1, NULL, NULL, NULL, NULL, NULL);
INSERT INTO "referensi"."tingkat_kelas" VALUES (9, 'IX', 'Kelas IX', NULL, 1, NULL, NULL, NULL, NULL, NULL);
INSERT INTO "referensi"."tingkat_kelas" VALUES (10, 'X', 'Kelas X', NULL, NULL, 1, 1, NULL, NULL, NULL);
INSERT INTO "referensi"."tingkat_kelas" VALUES (11, 'XI', 'Kelas XI', NULL, NULL, 1, 1, NULL, NULL, NULL);
INSERT INTO "referensi"."tingkat_kelas" VALUES (12, 'XII', 'Kelas XII', NULL, NULL, 1, 1, NULL, NULL, NULL);
INSERT INTO "referensi"."tingkat_kelas" VALUES (13, 'XIII', 'Kelas XIII', NULL, NULL, NULL, 1, NULL, NULL, NULL);

-- ----------------------------
-- Primary Key structure for table agama
-- ----------------------------
ALTER TABLE "referensi"."agama" ADD CONSTRAINT "ref_agama_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Primary Key structure for table alat_transportasi
-- ----------------------------
ALTER TABLE "referensi"."alat_transportasi" ADD CONSTRAINT "ref_alat_transportasi_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Primary Key structure for table cita_cita
-- ----------------------------
ALTER TABLE "referensi"."cita_cita" ADD CONSTRAINT "ref_cita_cita_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Primary Key structure for table hari
-- ----------------------------
ALTER TABLE "referensi"."hari" ADD CONSTRAINT "ref_hari_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Primary Key structure for table hobi
-- ----------------------------
ALTER TABLE "referensi"."hobi" ADD CONSTRAINT "ref_hobi_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Primary Key structure for table jabatan_tugas_ptk
-- ----------------------------
ALTER TABLE "referensi"."jabatan_tugas_ptk" ADD CONSTRAINT "ref_jabatan_tugas_ptk_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Primary Key structure for table jenis_keluar
-- ----------------------------
ALTER TABLE "referensi"."jenis_keluar" ADD CONSTRAINT "ref_jenis_keluar_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Primary Key structure for table jenis_pendaftaran
-- ----------------------------
ALTER TABLE "referensi"."jenis_pendaftaran" ADD CONSTRAINT "ref_jenis_pendaftaran_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Primary Key structure for table jenis_ptk
-- ----------------------------
ALTER TABLE "referensi"."jenis_ptk" ADD CONSTRAINT "ref_jenis_ptk_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Primary Key structure for table jenis_tinggal
-- ----------------------------
ALTER TABLE "referensi"."jenis_tinggal" ADD CONSTRAINT "ref_jenis_tinggal_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Primary Key structure for table jenjang_pendidikan
-- ----------------------------
ALTER TABLE "referensi"."jenjang_pendidikan" ADD CONSTRAINT "ref_jenjang_pendidikan_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Primary Key structure for table kurikulum
-- ----------------------------
ALTER TABLE "referensi"."kurikulum" ADD CONSTRAINT "kurikulum_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Primary Key structure for table pangkat_golongan
-- ----------------------------
ALTER TABLE "referensi"."pangkat_golongan" ADD CONSTRAINT "ref_pangkat_golongan_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Primary Key structure for table pekerjaan
-- ----------------------------
ALTER TABLE "referensi"."pekerjaan" ADD CONSTRAINT "ref_pekerjaan_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Primary Key structure for table penghasilan
-- ----------------------------
ALTER TABLE "referensi"."penghasilan" ADD CONSTRAINT "ref_penghasilan_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Primary Key structure for table status_kepegawaian
-- ----------------------------
ALTER TABLE "referensi"."status_kepegawaian" ADD CONSTRAINT "ref_status_kepegawaian_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Primary Key structure for table tingkat_kelas
-- ----------------------------
ALTER TABLE "referensi"."tingkat_kelas" ADD CONSTRAINT "ref_tingkat_kelas_pkey" PRIMARY KEY ("id");
