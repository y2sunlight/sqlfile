USE test_utf8;

DROP TABLE IF EXISTS syain;
CREATE TABLE syain (
  syain_no int(10) NOT NULL,
  syain_name varchar(50),
  bumon_no int(10),
  PRIMARY KEY (syain_no)
);
SHOW CREATE TABLE syain;
