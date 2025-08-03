# مشروع Laravel مع Filament

هذا مشروع Laravel يستخدم Filament كواجهة إدارية.

## المميزات

- Laravel Framework
- Filament Admin Panel
- دعم اللغة العربية
- نظام إدارة المشاريع
- نظام العقود
- نظام الشؤون المالية
- نظام الموافقات

## متطلبات النظام

- PHP 8.1+
- Composer
- Node.js & NPM
- MySQL/PostgreSQL

## التثبيت

1. استنسخ المشروع:
```bash
git clone [رابط المستودع]
cd my-project
```

2. ثبت التبعيات:
```bash
composer install
npm install
```

3. انسخ ملف البيئة:
```bash
cp .env.example .env
```

4. أنشئ مفتاح التطبيق:
```bash
php artisan key:generate
```

5. عدّل إعدادات قاعدة البيانات في ملف `.env`

6. قم بتشغيل الهجرات:
```bash
php artisan migrate
```

7. شغل البناء:
```bash
npm run build
```

8. شغل الخادم:
```bash
php artisan serve
```

## الوصول للوحة الإدارية

يمكنك الوصول للوحة الإدارية على: `http://localhost:8000/admin`

## المساهمة

نرحب بالمساهمات! يرجى إنشاء fork للمشروع وإرسال pull request.

## الرخصة

هذا المشروع مرخص تحت رخصة MIT. 