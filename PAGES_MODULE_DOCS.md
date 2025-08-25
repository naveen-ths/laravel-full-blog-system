# Pages Module Documentation

## MySQL Schema Overview

The pages module includes a comprehensive `pages` table with the following structure:

### Database Table: `pages`

#### Basic Required Fields
- `id` - Primary key (auto-increment)
- `title` - Page title (required, max 255 chars)
- `slug` - URL-friendly identifier (unique, auto-generated from title)
- `content` - Main page content (longtext, supports HTML)
- `excerpt` - Short description/summary (text, nullable)
- `status` - Page status (enum: draft, published, private)
- `sort_order` - For custom ordering (integer, default 0)
- `is_featured` - Featured page flag (boolean, default false)
- `published_at` - Publication timestamp (nullable)

#### SEO Fields
- `meta_title` - SEO title tag (nullable, max 255 chars)
- `meta_description` - SEO meta description (nullable, max 500 chars)
- `meta_keywords` - SEO keywords (nullable)
- `meta_robots` - Robot indexing instructions (default: 'index,follow')
- `canonical_url` - Canonical URL for SEO (nullable)
- `og_data` - Open Graph data as JSON (nullable)
- `twitter_data` - Twitter Card data as JSON (nullable)
- `schema_markup` - JSON-LD structured data (nullable)

#### Featured Image Fields
- `featured_image` - Featured image path/URL (nullable)
- `featured_image_alt` - Alt text for featured image (nullable)
- `featured_image_caption` - Caption for featured image (nullable)
- `featured_image_meta` - Image metadata as JSON (width, height, file_size)

#### Additional Media Fields
- `gallery_images` - Array of gallery images as JSON (nullable)
- `banner_image` - Banner/header image path (nullable)
- `banner_image_alt` - Alt text for banner image (nullable)

#### User Relationships
- `author_id` - Foreign key to users table (nullable, set null on delete)
- `updated_by` - Foreign key to users table for last updater (nullable)

#### Timestamps
- `created_at` - Record creation timestamp
- `updated_at` - Record last update timestamp

#### Database Indexes
- Index on `status` and `published_at` for efficient published page queries
- Index on `slug` for fast URL lookups
- Index on `is_featured` for featured page queries
- Index on `sort_order` for ordering

## Laravel Components

### Model: `App\Models\Page`
- Includes all necessary relationships (author, updatedBy)
- Auto-generates slug from title
- Provides scopes for published and featured pages
- Includes accessor methods for SEO data
- Properly casts JSON fields and dates

### Controller: `App\Http\Controllers\PageController`
- Full CRUD operations with validation
- Search and filtering capabilities
- Public page display by slug
- Featured pages endpoint
- Handles slug generation and publication dates

### Factory: `Database\Factories\PageFactory`
- Generates realistic test data for all fields
- Includes proper relationships and realistic SEO data

### Routes
- Admin routes (protected by auth middleware):
  - `GET /pages` - List pages
  - `GET /pages/create` - Create form
  - `POST /pages` - Store new page
  - `GET /pages/{page}` - Show page details
  - `GET /pages/{page}/edit` - Edit form
  - `PUT /pages/{page}` - Update page
  - `DELETE /pages/{page}` - Delete page

- Public routes:
  - `GET /featured-pages` - Show featured pages
  - `GET /{slug}` - Display page by slug

## Usage Examples

### Creating a Page
```php
$page = Page::create([
    'title' => 'About Us',
    'content' => '<h1>About Our Company</h1><p>We are...</p>',
    'status' => 'published',
    'meta_title' => 'About Us - Company Info',
    'meta_description' => 'Learn about our company...',
    'featured_image' => '/images/about.jpg',
    'author_id' => auth()->id(),
]);
```

### Querying Pages
```php
// Get published pages
$publishedPages = Page::published()->get();

// Get featured pages
$featuredPages = Page::featured()->get();

// Find by slug
$page = Page::where('slug', 'about-us')->first();
```

### SEO Data Structure
```php
// Open Graph data example
'og_data' => [
    'title' => 'Page Title',
    'description' => 'Page description',
    'image' => '/images/og-image.jpg',
    'type' => 'article'
]

// Twitter Card data example
'twitter_data' => [
    'card' => 'summary_large_image',
    'title' => 'Page Title',
    'description' => 'Page description',
    'image' => '/images/twitter-image.jpg'
]
```

## Configuration

### Database Connection
- Uses MySQL connection as configured in `.env`
- Database: `laravel_app`
- Connection: `mysql` (127.0.0.1:3306)

### Migration
- File: `2025_06_11_055002_create_pages_table.php`
- Run with: `php artisan migrate`

The schema is now ready for use without any sample data. You can create pages through the controller or directly through the model as needed.
