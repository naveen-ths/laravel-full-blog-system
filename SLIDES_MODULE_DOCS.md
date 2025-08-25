# Slides Module Documentation

## Overview
The Slides Module provides a complete image slider/carousel functionality for the home page with full CRUD (Create, Read, Update, Delete) operations through an admin interface.

## Features

### Database Schema
- **Slide Name**: Title/heading for the slide
- **Description**: Optional descriptive text
- **Image**: Main slide image with upload functionality
- **Image Alt Text**: Accessibility alt text for images
- **Link Settings**: Optional call-to-action links
- **Status**: Active/Inactive slide management
- **Sort Order**: Custom ordering of slides

### Admin Interface
- **Manage Slides**: Complete CRUD interface accessible via admin navigation
- **Search & Filter**: Find slides by name/description and filter by status
- **Image Upload**: Direct file upload with validation
- **Bulk Management**: Sort ordering and status management

### Frontend Display
- **Bootstrap 5 Carousel**: Mobile-responsive slider implementation
- **Auto-rotation**: Automatic slide transitions
- **Navigation Controls**: Previous/Next buttons and indicators
- **Call-to-Action**: Optional buttons with external/internal links

## File Structure

### Backend Files
```
app/Models/Slide.php                           # Slide model with relationships and scopes
app/Http/Controllers/SlideController.php       # CRUD controller for admin operations
app/Http/Controllers/HomeController.php        # Home page controller
database/migrations/create_slides_table.php    # Database schema
database/factories/SlideFactory.php            # Test data factory
database/seeders/SlideSeeder.php               # Sample data seeder
```

### Frontend Files
```
resources/views/slides/                        # Admin CRUD views
├── index.blade.php                           # List all slides
├── create.blade.php                          # Create new slide
├── edit.blade.php                            # Edit existing slide
├── show.blade.php                            # View slide details
└── form.blade.php                            # Shared form component

resources/views/home.blade.php                 # Home page with Bootstrap slider
```

### Routes
```php
// Admin routes (protected by auth middleware)
Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('slides', SlideController::class);
});

// Public route
Route::get('/', [HomeController::class, 'index'])->name('home');
```

## Usage

### Admin Management
1. Login to the admin panel
2. Navigate to "Manage Slides" in the main navigation
3. Create, edit, or delete slides as needed
4. Set sort order for display sequence
5. Toggle active/inactive status

### Adding New Slides
1. Click "Add New Slide" button
2. Fill in slide name and description
3. Upload image (JPEG, PNG, GIF, WebP supported)
4. Optional: Add call-to-action link
5. Set status and sort order
6. Save the slide

### Frontend Display
- Active slides automatically appear on the home page
- Slides are ordered by sort_order field
- Responsive design works on all devices
- Auto-rotation with manual navigation controls

## Technical Details

### Image Handling
- Images stored in `storage/app/public/slides/`
- Automatic resizing/optimization recommended
- Supports external URLs and local uploads
- Alt text for accessibility compliance

### Bootstrap Integration
- Bootstrap 5.3.3 via CDN
- Custom CSS for enhanced styling
- Mobile-first responsive design
- Touch/swipe support on mobile devices

### Security
- File upload validation
- Image type restrictions
- Admin-only access to management interface
- CSRF protection on all forms

## Sample Data
The module includes a seeder with 5 sample slides demonstrating various features:
- Welcome slide with internal link
- Content management showcase
- Design presentation
- Feature overview with external link
- Call-to-action slide

Run the seeder with:
```bash
php artisan db:seed --class=SlideSeeder
```

## Customization

### Styling
Edit the CSS in `resources/views/home.blade.php` to customize:
- Slide dimensions
- Caption styling
- Button appearance
- Animation effects

### Functionality
Extend the Slide model or controller to add:
- Video slides
- Background overlays
- Animation options
- Advanced scheduling

## Dependencies
- Laravel 11.x
- Bootstrap 5.3.3
- MySQL database
- Storage link for public file access
