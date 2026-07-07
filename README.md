# Rozholy Companion

A companion plugin for the Rozholy WordPress theme — booking management system with React admin UI and custom Gutenberg blocks styled with WordPress Design System (WPDS).

---

## Features

### Booking Management
- Custom `rz_booking` post type for storing appointments
- Full REST API for booking CRUD operations
- React admin page built with `@wordpress/components`
- Status management: pending, confirmed, completed, cancelled
- Advanced search and filtering
- Detailed booking view with modal

### Custom Blocks
- **Service Card** — display services with icon, title, description, and price
- **Testimonial** — customer testimonial cards with rating and avatar

### WPDS Styling
- Uses standard `@wordpress/components` for admin UI
- Color palette aligned with the Rozholy theme
- Follows WordPress Design System principles

---

## Installation

1. Copy the `rozholy-companion` folder to `/wp-content/plugins/`
2. Activate from **Plugins** in the WordPress admin
3. A "Rozholy" menu item appears in the admin sidebar

---

## Development

```bash
npm install
npm run build     # Production build
npm run start     # Watch mode with hot reload
```

---

## File Structure

```
rozholy-companion/
├── rozholy-companion.php       # Main plugin file
├── includes/
│   ├── post-types.php          # CPT registration + admin columns
│   ├── admin-page.php          # Admin page + asset enqueue
│   ├── rest-api.php            # REST API endpoints
│   ├── blocks.php              # Block registration + render callbacks
│   └── frontend.php            # Public booking form handler
├── src/
│   ├── admin/
│   │   ├── index.js            # React admin application
│   │   └── style.scss          # Admin styles
│   └── blocks/
│       ├── service-card/
│       │   ├── block.json
│       │   └── index.js
│       └── testimonial/
│           ├── block.json
│           └── index.js
├── build/                      # Compiled assets
└── package.json
```

---

## REST API Endpoints

| Method | Route | Description |
|--------|-------|-------------|
| GET | `/wp-json/rozholy-companion/v1/bookings` | List all bookings |
| GET | `/wp-json/rozholy-companion/v1/bookings/:id` | Get single booking |
| PUT | `/wp-json/rozholy-companion/v1/bookings/:id/status` | Update booking status |
| DELETE | `/wp-json/rozholy-companion/v1/bookings/:id` | Delete booking |
| POST | `/wp-json/rozholy-companion/v1/submit-booking` | Submit a new booking |
| GET | `/wp-json/rozholy-companion/v1/stats` | Get booking statistics |

---

## Author

**Hordekiller** — [github.com/Hordekiller](https://github.com/Hordekiller)

---

## License

GNU General Public License v2.0 or later.
