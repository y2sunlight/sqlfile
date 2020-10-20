-- トランザクション開始 ------------------
START TRANSACTION;
EVAL #トランザクションB開始;

-- テーブルの更新
INSERT INTO syain VALUES(2,'Yamamoto',30);
UPDATE syain SET syain_age = syain_age + 1;
SELECT * FROM syain;

EVAL sleep(5);

-- トランザクション終了 -----------------
ROLLBACK;
EVAL #トランザクションB終了;
