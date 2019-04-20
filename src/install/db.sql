/**
 * IDE: IntelliJ IDEA
 * Project: Kariyer
 * Owner: M. Kalender
 * Contact: muhammedkalender@protonmail.com
 * Date: 15-04-2019
 * Time: 15:08
 */
create database if not exists kariyer;

use kariyer;

create table if not exists member
(
    member_id            int auto_increment primary key,
    member_type          tinyint(1)        default 0,    #0 => User, 1 => Company
    member_power         int               default 1,    #Yetki, sonra değişebilir varsayılan
    member_email         VARCHAR(256) NOT NULL,
    member_gsm           VARCHAR(256)      DEFAULT NULL,
    member_fax           VARCHAR(256)      DEFAULT NULL,
    member_name          VARCHAR(256) NOT NULL,          ##Firma içni sadece name
    member_surname       VARCHAR(256)      DEFAULT NULL,
    member_nick          VARCHAR(256)      DEFAULT NULL,
    member_email_confirm TINYINT(1)        DEFAULT 1,
    member_gsm_confirm   TINYINT(1)        DEFAULT 1,
    member_password      VARCHAR(256) NOT NULL,
    member_prefix        VARCHAR(256) NOT NULL,
    member_description   VARCHAR(4096)     DEFAULT NULL, #Kişide yazı, Firmada tanıtım
    member_website       VARCHAR(256)      DEFAULT NULL,
    member_picture       VARCHAR(256)      DEFAULT 'avatar.jpg',
    member_gender        TINYINT(1)        DEFAULT 0,    ##0 => Belirtilmemiş, 1 = Erkek, 2 = Kadın, 3 = Diğer
    member_military      TINYINT(1)        DEFAULT 0,## 0 => Belirtilmemiş, 1 = Yapıldı, 2 = Muaf, 3 = Tecilli
    member_military_date timestamp    null default null,
    member_smoke         TINYINT(1)        DEFAULT 0,    ##0=> Belirtilmemiş, 1 = Hayır, 2 = Evet
    member_special       TINYINT(1)        DEFAULT 0,    ## 0=> Belirtilmemiş, 1 => Hayır, 2 = Evet
    member_ban           TINYINT(1)        DEFAULT 0,    ##0=> Bansız, 1 => Banlı Ban bitimini kotnrol edip 1 i 0 yap
    member_ban_date      timestamp    null default null,
    member_insert        TIMESTAMP         DEFAULT CURRENT_TIMESTAMP,
    member_update        timestamp         default CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    member_active        TINYINT(1)        DEFAULT 1
);

create table if not exists education
(
    education_id         int auto_increment primary key,
    education_member     int          not null,
    education_name       varchar(128) not null,          ##Üni
    education_department varchar(128) not null,          ##Bölüm
    education_note       varchar(8)        default null, ##Not ortalaması
    education_type       int          not null,          ##0 => İlk, 1 = Orta, 2 = Lise, 3 = Ön L., 4 = Mas....
    education_start      timestamp    not null,
    education_end        timestamp    null default null, ##Nullsa devam ediyor
    education_order      int               default 0,
    education_insert     timestamp         default current_timestamp,
    education_update     timestamp         default CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    education_active     tinyint(1)        default 1
    #,foreign key education (education_member) references member (member_id)
);

create table if not exists experience
(
    experience_id      int auto_increment primary key,
    experience_member  int          not null,
    experience_name    varchar(128) not null,          ##İş
    experience_company varchar(128) not null,          ##Şirket
    experience_desc    varchar(512) not null,          ##Açıklama
    experience_start   timestamp    not null,          ##İşe Başlama
    experience_end     timestamp    null default null, ##Nullsa işe devam ediyor
    experience_order   int               default 0,
    experience_insert  timestamp         default current_timestamp,
    experience_update  timestamp         default CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    experience_active  tinyint(1)        default 1
    #,foreign key experience (experience_member) references member (member_id),
);

create table if not exists reference
(
    reference_id          int auto_increment primary key,
    reference_member      int          not null,
    reference_name        varchar(128) not null,
    reference_company     varchar(128) not null,
    reference_title       varchar(128) not null,
    reference_email       varchar(64)  not null,
    reference_gsm         varchar(64)  not null,
    reference_description varchar(512) default null,
    reference_order       int          default 0,
    reference_insert      timestamp    default current_timestamp,
    reference_update      timestamp    default CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    reference_active      tinyint(1)   default 1
    #,foreign key reference (reference_member) references member (member_id)
);

create table if not exists certificate
(
    certificate_id      int auto_increment primary key,
    certificate_member  int           not null,
    certificate_name    varchar(128)  not null, ##Adı
    certificate_company varchar(128)  not null, ##Veren Kurum
    certificate_url     varchar(1024) not null,
    certificate_desc    varchar(512)       default null,
    certificate_date    timestamp     null default null,
    certificate_order   int                default 0,
    certificate_insert  timestamp          default current_timestamp,
    certificate_update  timestamp          default CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    certificate_active  tinyint(1)         default 1
    #,foreign key certificate (certificate_member) references member (member_id)
);

create table if not exists token
(
    token_id     int auto_increment primary key,
    token_member int          not null,
    token_key    varchar(256) not null,
    token_lock   varchar(256) not null,
    token_ip     varchar(256) not null,
    token_insert timestamp  DEFAULT CURRENT_TIMESTAMP,
    token_update timestamp  default CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    token_active tinyint(1) default 1
    #,foreign key token (token_member) references member (member_id)
);

create table if not exists skill
(
    skill_id     int auto_increment primary key,
    skill_member int          not null,
    skill_name   varchar(128) not null,
    skill_level  int        default 0, ##0 Giriş, 1 Junior, 2 Middler, 3 Up, 4 expert vs... 1-5
    skill_order  int        default 0,
    skill_insert timestamp  default current_timestamp,
    skill_update timestamp  default CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    skill_active tinyint(1) default 1
);

create table if not exists language
(
    language_id     int auto_increment primary key,
    language_member int not null,
    language_code   int not null,
    language_desc   varchar(256) default null, ##toelf 180 aldım felan
    language_order  int          default 0,
    language_level  int          default 0,    ##todo
    language_insert timestamp    default current_timestamp,
    language_update timestamp    default CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    language_active tinyint(1)   default 1
);

##todo
create table if not exists lang
(
    lang_id     int auto_increment primary key,
    lang_code   varchar(12) not null,
    lang_active tinyint(1) default 1
);
##todo
insert into lang (lang_code)
VALUES ("tr"),
       ("en"),
       ("de"),
       ("fr"),
       ("ru"),
       ("es");
##todo

create table if not exists licence
(
    licence_id     int auto_increment primary key,
    licence_member   int          not null,
    licence_name   varchar(128) not null,
    licence_date   timestamp    null not null,
    licence_code   varchar(12)  not null,
    licence_order  int        default 0,
    licence_insert timestamp  default current_timestamp,
    licence_update timestamp  default CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    licence_active tinyint(1) default 1
);
