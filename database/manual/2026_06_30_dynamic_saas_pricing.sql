USE hagzz;

DROP PROCEDURE IF EXISTS upgrade_dynamic_saas_pricing;
DELIMITER //
CREATE PROCEDURE upgrade_dynamic_saas_pricing()
BEGIN
    IF NOT EXISTS (SELECT 1 FROM information_schema.columns WHERE table_schema=DATABASE() AND table_name='countries' AND column_name='iso2') THEN
        ALTER TABLE countries ADD COLUMN iso2 CHAR(2) NULL AFTER name, ADD UNIQUE KEY countries_iso2_unique (iso2);
    END IF;
    IF NOT EXISTS (SELECT 1 FROM information_schema.columns WHERE table_schema=DATABASE() AND table_name='countries' AND column_name='currency_code') THEN
        ALTER TABLE countries ADD COLUMN currency_code CHAR(3) NULL AFTER iso2;
    END IF;
    IF NOT EXISTS (SELECT 1 FROM information_schema.columns WHERE table_schema=DATABASE() AND table_name='academies' AND column_name='country_id') THEN
        ALTER TABLE academies ADD COLUMN country_id BIGINT UNSIGNED NULL AFTER branch_to,
            ADD INDEX academies_country_id_index (country_id),
            ADD CONSTRAINT academies_dynamic_country_fk FOREIGN KEY (country_id) REFERENCES countries(id) ON DELETE SET NULL;
    END IF;
END//
DELIMITER ;
CALL upgrade_dynamic_saas_pricing();
DROP PROCEDURE IF EXISTS upgrade_dynamic_saas_pricing;

UPDATE countries SET iso2='EG', currency_code='EGP' WHERE iso2 IS NULL AND (name LIKE '%Egypt%' OR name LIKE '%مصر%');
UPDATE countries SET iso2='QA', currency_code='QAR' WHERE iso2 IS NULL AND (name LIKE '%Qatar%' OR name LIKE '%قطر%');
UPDATE countries SET iso2='SA', currency_code='SAR' WHERE iso2 IS NULL AND (name LIKE '%Saudi%' OR name LIKE '%السعودية%');
UPDATE countries SET iso2='PT', currency_code='EUR' WHERE iso2 IS NULL AND (name LIKE '%Portugal%' OR name LIKE '%البرتغال%');

INSERT INTO countries (name, iso2, currency_code, created_at, updated_at)
SELECT JSON_OBJECT('ar','مصر','en','Egypt'), 'EG', 'EGP', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM countries WHERE iso2='EG');
INSERT INTO countries (name, iso2, currency_code, created_at, updated_at)
SELECT JSON_OBJECT('ar','قطر','en','Qatar'), 'QA', 'QAR', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM countries WHERE iso2='QA');
INSERT INTO countries (name, iso2, currency_code, created_at, updated_at)
SELECT JSON_OBJECT('ar','السعودية','en','Saudi Arabia'), 'SA', 'SAR', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM countries WHERE iso2='SA');
INSERT INTO countries (name, iso2, currency_code, created_at, updated_at)
SELECT JSON_OBJECT('ar','البرتغال','en','Portugal'), 'PT', 'EUR', NOW(), NOW() WHERE NOT EXISTS (SELECT 1 FROM countries WHERE iso2='PT');

CREATE TABLE IF NOT EXISTS saas_plan_prices (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    saas_plan_id BIGINT UNSIGNED NOT NULL,
    country_id BIGINT UNSIGNED NOT NULL,
    currency_code CHAR(3) NOT NULL,
    monthly_price DECIMAL(12,2) NOT NULL,
    annual_price DECIMAL(12,2) NOT NULL,
    tax_rate DECIMAL(5,2) NOT NULL DEFAULT 0,
    tax_included TINYINT(1) NOT NULL DEFAULT 0,
    active TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    UNIQUE KEY saas_plan_prices_plan_country_unique (saas_plan_id,country_id),
    CONSTRAINT saas_plan_prices_plan_fk FOREIGN KEY (saas_plan_id) REFERENCES saas_plans(id) ON DELETE CASCADE,
    CONSTRAINT saas_plan_prices_country_fk FOREIGN KEY (country_id) REFERENCES countries(id) ON DELETE CASCADE
);

DROP PROCEDURE IF EXISTS upgrade_subscription_snapshots;
DELIMITER //
CREATE PROCEDURE upgrade_subscription_snapshots()
BEGIN
    IF NOT EXISTS (SELECT 1 FROM information_schema.columns WHERE table_schema=DATABASE() AND table_name='tenant_subscriptions' AND column_name='saas_plan_price_id') THEN
        ALTER TABLE tenant_subscriptions ADD COLUMN saas_plan_price_id BIGINT UNSIGNED NULL AFTER saas_plan_id,
            ADD CONSTRAINT tenant_subscriptions_price_fk FOREIGN KEY (saas_plan_price_id) REFERENCES saas_plan_prices(id) ON DELETE SET NULL;
    END IF;
    IF NOT EXISTS (SELECT 1 FROM information_schema.columns WHERE table_schema=DATABASE() AND table_name='tenant_subscriptions' AND column_name='price_amount') THEN
        ALTER TABLE tenant_subscriptions ADD COLUMN price_amount DECIMAL(12,2) NULL AFTER custom_price;
    END IF;
    IF NOT EXISTS (SELECT 1 FROM information_schema.columns WHERE table_schema=DATABASE() AND table_name='tenant_subscriptions' AND column_name='currency_code') THEN
        ALTER TABLE tenant_subscriptions ADD COLUMN currency_code CHAR(3) NULL AFTER price_amount;
    END IF;
    IF NOT EXISTS (SELECT 1 FROM information_schema.columns WHERE table_schema=DATABASE() AND table_name='tenant_subscriptions' AND column_name='tax_rate') THEN
        ALTER TABLE tenant_subscriptions ADD COLUMN tax_rate DECIMAL(5,2) NOT NULL DEFAULT 0 AFTER currency_code;
    END IF;
    IF NOT EXISTS (SELECT 1 FROM information_schema.columns WHERE table_schema=DATABASE() AND table_name='tenant_subscriptions' AND column_name='tax_included') THEN
        ALTER TABLE tenant_subscriptions ADD COLUMN tax_included TINYINT(1) NOT NULL DEFAULT 0 AFTER tax_rate;
    END IF;
END//
DELIMITER ;
CALL upgrade_subscription_snapshots();
DROP PROCEDURE IF EXISTS upgrade_subscription_snapshots;

INSERT INTO saas_plan_prices (saas_plan_id,country_id,currency_code,monthly_price,annual_price,tax_rate,tax_included,active,created_at,updated_at)
SELECT p.id,c.id,c.currency_code,
    CASE p.code WHEN 'starter' THEN 299 WHEN 'professional' THEN 699 WHEN 'business' THEN 1299 ELSE p.monthly_price END,
    CASE p.code WHEN 'starter' THEN 2990 WHEN 'professional' THEN 6990 WHEN 'business' THEN 12990 ELSE p.annual_price END,
    14,0,1,NOW(),NOW() FROM saas_plans p JOIN countries c ON c.iso2='EG'
ON DUPLICATE KEY UPDATE currency_code=VALUES(currency_code),updated_at=NOW();

INSERT INTO saas_plan_prices (saas_plan_id,country_id,currency_code,monthly_price,annual_price,tax_rate,tax_included,active,created_at,updated_at)
SELECT p.id,c.id,c.currency_code,
    CASE p.code WHEN 'starter' THEN 99 WHEN 'professional' THEN 249 WHEN 'business' THEN 499 ELSE p.monthly_price END,
    CASE p.code WHEN 'starter' THEN 990 WHEN 'professional' THEN 2490 WHEN 'business' THEN 4990 ELSE p.annual_price END,
    0,0,1,NOW(),NOW() FROM saas_plans p JOIN countries c ON c.iso2='QA'
ON DUPLICATE KEY UPDATE currency_code=VALUES(currency_code),updated_at=NOW();

INSERT INTO saas_plan_prices (saas_plan_id,country_id,currency_code,monthly_price,annual_price,tax_rate,tax_included,active,created_at,updated_at)
SELECT p.id,c.id,c.currency_code,
    CASE p.code WHEN 'starter' THEN 99 WHEN 'professional' THEN 249 WHEN 'business' THEN 499 ELSE p.monthly_price END,
    CASE p.code WHEN 'starter' THEN 990 WHEN 'professional' THEN 2490 WHEN 'business' THEN 4990 ELSE p.annual_price END,
    15,0,1,NOW(),NOW() FROM saas_plans p JOIN countries c ON c.iso2='SA'
ON DUPLICATE KEY UPDATE currency_code=VALUES(currency_code),updated_at=NOW();

INSERT INTO saas_plan_prices (saas_plan_id,country_id,currency_code,monthly_price,annual_price,tax_rate,tax_included,active,created_at,updated_at)
SELECT p.id,c.id,c.currency_code,
    CASE p.code WHEN 'starter' THEN 29 WHEN 'professional' THEN 59 WHEN 'business' THEN 119 ELSE p.monthly_price END,
    CASE p.code WHEN 'starter' THEN 290 WHEN 'professional' THEN 590 WHEN 'business' THEN 1190 ELSE p.annual_price END,
    23,0,1,NOW(),NOW() FROM saas_plans p JOIN countries c ON c.iso2='PT'
ON DUPLICATE KEY UPDATE currency_code=VALUES(currency_code),updated_at=NOW();

UPDATE tenant_subscriptions s
JOIN academies a ON a.id=s.academy_id
JOIN saas_plan_prices pp ON pp.saas_plan_id=s.saas_plan_id AND pp.country_id=a.country_id
SET s.saas_plan_price_id=pp.id,
    s.price_amount=COALESCE(s.custom_price,IF(s.billing_cycle='annual',pp.annual_price,pp.monthly_price)),
    s.currency_code=pp.currency_code,s.tax_rate=pp.tax_rate,s.tax_included=pp.tax_included
WHERE s.saas_plan_price_id IS NULL;
