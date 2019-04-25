insert into category (category_id, category_name_tr, category_name_en, category_father)
VALUES (10001, 'Banka/Sigorta', '', 0),
       (10002, 'Bilişim/Telekom', '', 0),
       (10003, 'Eğitim/Öğretim', '', 0),
       (10004, 'Güvenlik', '', 0),
       (10005, 'Hukuk/Avukat', '', 0),
       (10006, 'İnsan Kaynakları/Yönetim', '', 0),
       (10007, 'Lojistik/Taşımacılık/Depo', '', 0),
       (10008, 'Mağaza/Perakende', '', 0),
       (10009, 'Muhasebe/Finans', '', 0),
       (10010, 'Pazarlama/Reklam/Tanıtım/Tasarım', '', 0),
       (10011, 'Sağlık', '', 0),
       (10012, 'Satış/Satış Müdürü/TeleSatış', '', 0),
       (10013, 'Sekreter/Yönetici Asistanı', '', 0),
       (10014, 'Staj/Yeni Mezun/Part-Time', '', 0),
       (10015, 'Tekstil', '', 0),
       (10016, 'Turizm/Gıda/Hizmet', '', 0),
       (10017, 'Üretim/Endüstriyel Ürünler/Otomotiv', '', 0),
       (10018, 'Yapı/Mimar/İnşaat', '', 0);

insert into category (category_name_tr, category_name_en, category_father)
VALUES ('Banka/Bankacılık İşlemleri', '', 10001),
       ('Hazine/Kontrol/Denetim', '', 10001),
       ('İş Analizi/Raporlama', '', 10001),
       ('Müşteri Hizmetleri/İlişkileri', '', 10001),
       ('Portföy/Portföy Yönetimi', '', 10001),
       ('Proje Yönetimi', '', 10001),
       ('Risk Yönetimi', '', 10001),
       ('Sigorta/Sigorta Satış/Acente Danışmanlığı', '', 10001),
       ('Yatırım/Fonlar/Krediler/Mortgage', '', 10001),
       ('Ağ Uzmanları/Mühendisler/Güvenlik', '', 10002),
       ('Arayüz/Önyüz Kodlama', '', 10002),
       ('Bilgi İşlem/Helpdesk', '', 10002),
       ('BT/Yazılım/Yazılım Geliştirme', '', 10002),
       ('Grafik Tasarım', '', 10002),
       ('İş Zekası/Veritabanı Uzmanı', '', 10002),
       ('Mobil Programlama', '', 10002),
       ('Müşteri Hizmetleri/İlişkileri', '', 10002),
       ('Proje Yönetimi/İş Analizi', '', 10002),
       ('SAP/ERP/CRM', '', 10002),
       ('Sistem Yönetimi', '', 10002),
       ('Teknisyen/Tekniker', '', 10002),
       ('Test/Denetim', '', 10002),
       ('Ürün Yönetimi/Ürün Geliştirme', '', 10002),
       ('Web/Web Tasarım', '', 10002);