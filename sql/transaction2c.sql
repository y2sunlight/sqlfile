-- 自動コミットモード -------------------
-- レコード挿入
INSERT INTO syain VALUES(2,'Yamamoto',30);
SELECT * FROM syain;

-- レコード更新
UPDATE syain SET syain_age = syain_age + 1;
SELECT * FROM syain;
