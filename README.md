# Rozholy Companion

همراه هوشمند قالب Rozholy — مدیریت رزروها و بلاک‌های سفارشی با استایل WordPress Design System (WPDS)

## ویژگی‌ها

### 📋 مدیریت رزروها
- پست تایپ اختصاصی `rz_booking` برای ذخیره رزروها
- REST API کامل برای مدیریت رزروها
- صفحه ادمین React با `@wordpress/components` برای مدیریت آسان
- تغییر وضعیت رزرو (در انتظار، تایید شده، انجام شده، لغو شده)
- جستجو و فیلتر پیشرفته
- جزئیات کامل هر رزرو

### 🧩 بلاک‌های سفارشی
- **Service Card**: کارت نمایش خدمات با آیکون، عنوان، توضیحات و قیمت
- **Testimonial**: کارت نظرات مشتریان با امتیاز و تصویر

### 🎨 استایل WPDS
- استفاده از کامپوننت‌های استاندارد `@wordpress/components`
- پالت رنگی هماهنگ با قالب Rozholy
- انطباق با اصول طراحی WordPress Design System

## نصب

1. پوشه `rozholy-companion` را به `/wp-content/plugins/` کپی کنید
2. از پیشخوان وردپرس > افزونه‌ها، افزونه را فعال کنید
3. منوی "Rozholy" در پیشخوان وردپرس ظاهر می‌شود

## توسعه

```bash
npm install
npm run build    # build for production
npm run start    # watch mode
```

## ساختار فایل‌ها

```
rozholy-companion/
├── rozholy-companion.php       # Main plugin file
├── includes/
│   ├── post-types.php          # CPT + admin columns
│   ├── admin-page.php          # Admin page + assets
│   ├── rest-api.php            # REST API endpoints
│   ├── blocks.php              # Block registration + render
│   └── frontend.php            # Public booking form handler
├── src/
│   ├── admin/
│   │   ├── index.js            # React admin app
│   │   └── style.scss          # Admin styles
│   └── blocks/
│       ├── service-card/
│       │   ├── block.json
│       │   └── index.js
│       └── testimonial/
│           ├── block.json
│           └── index.js
├── build/                      # Built assets
└── package.json
```

## API endpoints

| Method | Route | Description |
|--------|-------|-------------|
| GET | `/wp-json/rozholy-companion/v1/bookings` | List bookings |
| GET | `/wp-json/rozholy-companion/v1/bookings/:id` | Get booking |
| PUT | `/wp-json/rozholy-companion/v1/bookings/:id/status` | Update status |
| DELETE | `/wp-json/rozholy-companion/v1/bookings/:id` | Delete booking |
| POST | `/wp-json/rozholy-companion/v1/submit-booking` | Public booking form |
| GET | `/wp-json/rozholy-companion/v1/stats` | Get stats |

## License

GNU General Public License v2.0 or later
