-- テーブル作成 -------------------------
DROP TABLE IF EXISTS syain;
CREATE TABLE syain (
  syain_no int(10) NOT NULL,
  syain_name varchar(50),
  syain_age int(10),
  PRIMARY KEY (syain_no)
);
INSERT INTO syain VALUES(1,'Suzuki',50);
#;

-- トランザクション開始 ------------------
-- SET AUTOCOMMIT = 0;
START TRANSACTION;
SELECT * FROM syain;

-- テーブルの更新
UPDATE syain SET syain_age = syain_age + 1;
INSERT INTO syain VALUES(2,'Yamamoto',30);
SELECT * FROM syain;

-- トランザクション終了 -----------------
ROLLBACK;
SELECT * FROM syain;
