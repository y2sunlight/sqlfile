-- テーブル作成
DROP TABLE IF EXISTS syain;
CREATE TABLE syain (
  syain_no int(10) NOT NULL,
  syain_name varchar(50),
  bumon_no int(10),
  PRIMARY KEY (syain_no)
);

-- テーブルにデータを挿入
INSERT INTO syain VALUES(1,'Suzuki',3);
INSERT INTO syain VALUES(2,'Yamamoto',1);
INSERT INTO syain VALUES(3,'Tanaka',2);

-- テーブルの検索
SELECT * FROM syain;
