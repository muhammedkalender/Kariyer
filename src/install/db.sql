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
    member_address       VARCHAR(256)      DEFAULT NULL,
    member_bd            VARCHAR(32)       DEFAULT NULL,
    member_picture       VARCHAR(256)      DEFAULT 'avatar.jpg',
    member_gender        TINYINT(1)        DEFAULT 0,    ##0 => Belirtilmemiş, 1 = Erkek, 2 = Kadın, 3 = Diğer
    member_military      TINYINT(1)        DEFAULT 0,## 0 => Belirtilmemiş, 1 = Yapıldı, 2 = Muaf, 3 = Tecilli
    member_military_date date         null default null,
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
    education_start      date         not null,
    education_end        date         null default null, ##Nullsa devam ediyor
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
    experience_start   varchar(32)  not null,          ##İşe Başlama
    experience_end     varchar(32)  null default null, ##Nullsa işe devam ediyor
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
    certificate_member  int          not null,
    certificate_name    varchar(128) not null, ##Adı
    certificate_company varchar(128) not null, ##Veren Kurum
    certificate_url     varchar(1024)     default '#',
    certificate_desc    varchar(512)      default null,
    certificate_date    date         null default null,
    certificate_order   int               default 0,
    certificate_insert  timestamp         default current_timestamp,
    certificate_update  timestamp         default CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    certificate_active  tinyint(1)        default 1
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

create table if not exists licence
(
    licence_id     int auto_increment primary key,
    licence_member int          not null,
    licence_name   varchar(128) not null,
    licence_date   date         null not null,
    licence_code   varchar(12)  not null,
    licence_order  int        default 0,
    licence_insert timestamp  default current_timestamp,
    licence_update timestamp  default CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    licence_active tinyint(1) default 1
);

/* gewrek yok sabit zaten çak json e
create table if not exists education_level
(
    education_level_id     int auto_increment primary key,
    education_level_code   varchar(16) not null unique, #dil dosyası için
    education_level_active tinyint(1) default 1
);


insert into education_level (education_level_code)
VALUES ("ES"),
       ("ESG"),
       ("HS"),
       ("HSG"),
       ("AD"),
       ("ADG"),
       ("BD"),
       ("BDD"),
       ("MD"),
       ("MDG"),
       ("PHD"),
       ("PHDG");
*/
##todo Çalışma Şekli - Part, Tam ...
##todo departman ?
##todo pozisyon seviyesi ( yönetici, eleman,uzman syaj..)
##todo pozisyon ?? gerek olmayabilir
##todo sektör

##todo function
create table if not exists job_adv
(
    job_adv_id          int auto_increment primary key,
    job_adv_author      int           not null,
    ## sornadan çekme job_adv_country int not null ,
    ## sornadan çekme job_ad
    job_adv_experience  int           not null,
    job_adv_title       varchar(256)  not null,
    job_adv_count       int         default 1,
    job_adv_type        int           not null,   ## çalışma şekli, free tam part
  job_adv_military_type varchar(32)           not null,
    job_adv_sex         int         default 0,    # 1 => erkek, 2 kadın, 0 farketmez,
    job_adv_description varchar(4096) not null,
    job_adv_view        int         default 0,
    job_adv_app         int         default 0,
    job_adv_special         int         default 0,
    job_adv_category    int         default 0,    ##Yazılım > Web Yazışlım gibi
    job_adv_father      int         default 0,    ##Yazılım > Web Yazışlım gibi
    job_adv_close       varchar(32) default null, ##şu zaman kadar ...
    job_adv_insert      timestamp   default current_timestamp,
    job_adv_update      timestamp   default CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    job_adv_active      tinyint(1)  default 1
);
##todo function
###TODO  sadece en küçük birimi alsın ( tuzla seçilsin, üstüne doğru istanbul bilmmene oraya bağlı olanlar felan
## idleri öyle dağılsın, üste gittikçe gitsin   tuzla father (ist) istanbul father ( türkiye ) türkiye father 0 gibi
/*
create table if not exists job_adv_country
(
    job_adv_country_id     int auto_increment not null,
    job_adv_id             int                not null,
    job_adv_country        int                not null,
    job_adv_country_active tinyint(1) default 1
);*/

##todo function
##todo json a çıktı versin, pert eder bu serveri
## update, insertte versin dilide çaksın hatta içinde olsun
create table if not exists job_adv_location
(
    job_adv_location_id     int auto_increment primary key not null,
    job_adv_id              int                            not null,
    location_id             int                            not null,
    job_adv_location_active tinyint(1) default 1
);
##todo function
create table if not exists job_adv_language
(
    job_adv_language_id     int auto_increment primary key not null,
    job_adv_id              int                            not null,
    language_id             int                            not null, ##json a aktarmalı olsun
    job_adv_language_active tinyint(1) default 1
);

create table if not exists job_adv_military
(
    job_adv_military_id     int auto_increment primary key not null,
    job_adv_military_type   int                            not null,
    job_adv_id              int                            not null,
    job_adv_military_active tinyint(1) default 1
);

##todo function
##todo temp alıcak bol bol :/
##todo static isimli templer oclak, update- delte de silecek
create table if not exists location
(
    location_id     int auto_increment primary key,
    location_father int        default 0,
    location_name   varchar(64) not null,
    location_level  int        default 0, # 0 ülke, 1 şehir, 2 içe
    location_active tinyint(1) default 1
);


##todo function
##Application for employment
create table if not exists afe
(
    afe         int auto_increment primary key,
    efe_member  int not null,
    efe_job_adv int not null,
    efe_message varchar(1024) default null,
    efe_status  int           default 0, ##Firma geri dönüş yapacak, beyenirse silsin ilanı
    efe_insert  timestamp     default current_timestamp,
    efe_update  timestamp     default CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    efe_active  tinyint(1)    default 1
);

##todo fonskiyon
create table if not exists category
(
    category_id      int auto_increment primary key,
    category_name_tr varchar(128) not null,
    category_name_en varchar(128),
    category_father  int        default 0,
    category_active  tinyint(1) default 1
);


create table if not exists job_apply
(
    job_apply_id         int auto_increment primary key,
    job_apply_member     int not null,
    job_apply_message    varchar(256),
    job_apply_job_adv_id int not null,
    job_apply_review     tinyint(1) default 0,
    job_apply_insert     timestamp  default current_timestamp,
    job_apply_update     timestamp  default CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    job_apply_active     tinyint(1) default 1
);


create table if not exists cv
(
    cv_id     int auto_increment primary key,
    cv_member int          not null,
    cv_name   varchar(36)  not null,
    cv_desc   varchar(512) not null,
    cv_file   varchar(256) not null,
    cv_order int default 0,
    cv_insert timestamp  default current_timestamp,
    cv_update timestamp  default CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    cv_active tinyint(1) default 1
);