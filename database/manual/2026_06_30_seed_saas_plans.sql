USE hagzz;

INSERT INTO saas_plans
    (code, name, monthly_price, annual_price, max_venues, max_spaces, max_staff, features, active, created_at, updated_at)
VALUES
    (
        'starter',
        JSON_OBJECT('ar', 'الباقة الأساسية', 'en', 'Starter'),
        299.00,
        2990.00,
        1,
        3,
        3,
        JSON_ARRAY('إدارة موقع واحد', 'إدارة 3 ملاعب', 'الحجوزات والمدفوعات', 'تقارير أساسية'),
        1,
        NOW(),
        NOW()
    ),
    (
        'professional',
        JSON_OBJECT('ar', 'الباقة الاحترافية', 'en', 'Professional'),
        699.00,
        6990.00,
        3,
        10,
        10,
        JSON_ARRAY('إدارة 3 مواقع', 'إدارة 10 ملاعب', 'حجوزات الأفراد والبطولات والفعاليات', 'تقارير متقدمة'),
        1,
        NOW(),
        NOW()
    ),
    (
        'business',
        JSON_OBJECT('ar', 'باقة الأعمال', 'en', 'Business'),
        1299.00,
        12990.00,
        10,
        50,
        30,
        JSON_ARRAY('إدارة 10 مواقع', 'إدارة 50 ملعبًا', 'عدد أكبر من الموظفين', 'مناسبة لسلاسل الملاعب'),
        1,
        NOW(),
        NOW()
    )
ON DUPLICATE KEY UPDATE
    name = VALUES(name),
    monthly_price = VALUES(monthly_price),
    annual_price = VALUES(annual_price),
    max_venues = VALUES(max_venues),
    max_spaces = VALUES(max_spaces),
    max_staff = VALUES(max_staff),
    features = VALUES(features),
    active = VALUES(active),
    updated_at = NOW();
