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
-- SET TRANSACTION ISOLATION LEVEL READ UNCOMMITTED;
-- SET TRANSACTION ISOLATION LEVEL READ COMMITTED;
-- SET TRANSACTION ISOLATION LEVEL REPEATABLE READ;
SET TRANSACTION ISOLATION LEVEL SERIALIZABLE;

START TRANSACTION;
EVAL # トランザクションA開始;
SELECT * FROM syain;

EVAL # ここで他のトランザクションがデータを更新する;
EVAL sleep(5);
SELECT * FROM syain;
SELECT * FROM syain LOCK IN SHARE MODE;

-- トランザクション終了 -----------------
COMMIT;
EVAL # トランザクションA終了;

EVAL sleep(5);
SELECT * FROM syain;
