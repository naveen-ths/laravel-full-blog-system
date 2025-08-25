# Laravel Blog CMS

A modern, feature-rich Content Management System built with Laravel 12, featuring a comprehensive blog system, page management, and role-based access control.

## 🚀 Features

### Blog System
- **Blog Posts Management** - Create, edit, delete, and publish blog posts
- **Category System** - Organize posts with color-coded categories
- **Tagging System** - Tag posts for better organization
- **Comment System** - AJAX-powered commenting with moderation
- **SEO Optimization** - Meta tags, Open Graph, and SEO-friendly URLs
- **Featured Images** - Upload and manage post images
- **Draft & Scheduling** - Save drafts and schedule posts
- **Search Functionality** - Search posts by title, content, and excerpt

### Content Management
- **Page Management** - Create custom pages with SEO optimization
- **Featured Pages** - Highlight important pages
- **Slideshow System** - Manage homepage slideshows
- **Rich Text Editor** - WYSIWYG content editing
- **Media Management** - Upload and organize images

### User Management & Security
- **Role-Based Access Control** - Using Spatie Laravel Permission
- **Multiple User Roles** - Admin, Editor, Author permissions
- **OAuth2 Integration** - Laravel Passport for API authentication
- **User Management** - Admin panel for user administration
- **Permission System** - Granular permission control

### Frontend Features
- **Responsive Design** - Mobile-first Tailwind CSS design
- **Dark Mode Support** - Complete dark/light theme toggle
- **Category Browsing** - Dedicated category pages with filtering
- **AJAX Comments** - Real-time comment submission and validation
- **Search & Filtering** - Advanced post filtering and search
- **Pagination** - Optimized pagination for large datasets
- **Breadcrumb Navigation** - User-friendly navigation

## 🛠️ Technology Stack

- **Backend**: Laravel 12.x (PHP 8.2+)
- **Frontend**: Tailwind CSS, Alpine.js
- **Database**: MySQL/SQLite
- **Authentication**: Laravel Breeze + Laravel Passport
- **Permissions**: Spatie Laravel Permission
- **Build Tools**: Vite
- **Styling**: Tailwind CSS with dark mode support

## 📋 Requirements

- PHP 8.2 or higher
- Composer
- Node.js & NPM
- MySQL 8.0+ or SQLite
- Web server (Apache/Nginx) or Laravel's built-in server

## ⚡ Quick Start

### 1. Clone the Repository
```bash
git clone <repository-url> laravel-blog-cms
cd laravel-blog-cms
```

### 2. Install Dependencies
```bash
# Install PHP dependencies
composer install

# Install Node.js dependencies
npm install
```

### 3. Environment Setup
```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Generate Passport keys (for API)
php artisan passport:install
```

### 4. Configure Environment
Edit `.env` file with your database credentials:
```env
APP_NAME="Laravel Blog CMS"
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_blog
DB_USERNAME=your_username
DB_PASSWORD=your_password

# For SQLite (alternative)
# DB_CONNECTION=sqlite
# DB_DATABASE=/absolute/path/to/database.sqlite
```

### 5. Database Setup
```bash
# Run migrations
php artisan migrate

# Seed the database (optional)
php artisan db:seed

# Create initial roles and permissions
php artisan permission:cache-reset
```

### 6. Build Assets
```bash
# Development
npm run dev

# Production
npm run build
```

### 7. Start the Server
```bash
# Development server
php artisan serve

# Visit: http://localhost:8000
```

## 🔧 Configuration

### Creating Admin User
```bash
# Using Tinker
php artisan tinker

# Create superadmin user
$user = App\Models\User::create([
    'name' => 'Admin User',
    'email' => 'admin@example.com',
    'password' => bcrypt('password')
]);

# Assign superadmin role
$user->assignRole('superadmin');
```

### Setting Up Permissions
The application uses role-based permissions:
- **superadmin**: Full system access
- **admin**: Content and user management
- **editor**: Content editing
- **author**: Own content management

### Passport Configuration
```bash
# Create Passport client for API access
php artisan passport:client

# Set client credentials in .env
PASSPORT_CLIENT_ID=your_client_id
PASSPORT_CLIENT_SECRET=your_client_secret
```

## 📝 Usage

### Admin Panel Access
- Navigate to `/dashboard` after logging in
- Requires authentication and appropriate permissions

### Blog Management
- **Posts**: `/admin/blog/posts`
- **Categories**: `/admin/blog/categories`
- **Tags**: `/admin/blog/tags`
- **Comments**: `/admin/blog/comments`

### Page Management
- **Pages**: `/pages`
- **Slides**: `/admin/slides`

### User Management (Superadmin only)
- **Users**: `/admin/users`
- **Roles**: `/admin/roles`
- **Permissions**: `/admin/permissions`

### Public Frontend
- **Blog**: `/blog`
- **Categories**: `/blog/category/{category-slug}`
- **Posts**: `/blog/{post-slug}`
- **Pages**: `/{page-slug}`
- **Featured Pages**: `/featured-pages`

## 🎨 Customization

### Styling
- Tailwind CSS configuration: `tailwind.config.js`
- Main CSS file: `resources/css/app.css`
- Dark mode classes included throughout

### Layout
- Main layout: `resources/views/layouts/app.blade.php`
- Blog layouts: `resources/views/blog/`
- Admin layouts: Uses Laravel Breeze components

### Adding New Features
1. Create models with relationships
2. Add routes in `routes/web.php`
3. Create controllers with proper middleware
4. Design views with Tailwind CSS
5. Update permissions as needed

## 🧪 Testing

```bash
# Run PHPUnit tests
php artisan test

# Run specific test
php artisan test --filter BlogTest
```

## 📦 Deployment

### Production Setup
1. Set `APP_ENV=production` in `.env`
2. Set `APP_DEBUG=false`
3. Configure web server (Apache/Nginx)
4. Set up SSL certificate
5. Configure caching:
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### File Permissions
```bash
# Set proper permissions
chmod -R 755 storage
chmod -R 755 bootstrap/cache
```

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## 📄 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## 🐛 Bug Reports

If you discover any bugs, please create an issue on GitHub with:
- Laravel version
- PHP version
- Error message/stack trace
- Steps to reproduce

## 📞 Support

For support and questions:
- Create an issue on GitHub
- Check the Laravel documentation
- Review the application logs in `storage/logs/`

## 🔮 Roadmap

- [ ] Multi-language support
- [ ] Advanced SEO features
- [ ] Email newsletter integration
- [ ] Social media integration
- [ ] Advanced analytics
- [ ] Content scheduling
- [ ] API documentation
- [ ] Mobile app API

---

Built with ❤️ using Laravel 12 and Tailwind CSS
