USE test;
SET storage_engine = Aria;         #この設定は有効です
SET character_set_database = sjis; #この設定は無意味です

DROP TABLE IF EXISTS syain;
CREATE TABLE syain (
  syain_no int(10) NOT NULL,
  syain_name varchar(50),
  bumon_no int(10),
  PRIMARY KEY (syain_no)
);
SHOW CREATE TABLE syain;
