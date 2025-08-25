

<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\PassportClientController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\SlideController;
use App\Http\Controllers\HomeController;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

// Passport OAuth2 Authorization Code Grant routes
Route::get('/auth/redirect', function (Request $request) {
    $request->session()->put('state', $state = Str::random(40));
 
    $query = http_build_query([
        'client_id' =>  env('PASSPORT_CLIENT_ID'),
        'redirect_uri' => 'https://third-party-app.com/callback',
        'response_type' => 'code',
        'scope' => 'user:read orders:create',
        'state' => $state,
        // 'prompt' => '', // "none", "consent", or "login"
    ]);

     return redirect(url('/oauth/authorize?') . $query);
});
Route::get('/auth/callback', function (Request $request) {
    $state = $request->session()->pull('state');
 
    throw_unless(
        strlen($state) > 0 && $state === $request->state,
        InvalidArgumentException::class,
        'Invalid state value.'
    );
 
    $response = Http::asForm()->post('https://passport-app.test/oauth/token', [
        'grant_type' => 'authorization_code',
        'client_id' => env('PASSPORT_CLIENT_ID'),
        'client_secret' => env('PASSPORT_CLIENT_SECRET'),
        'redirect_uri' => 'https://third-party-app.com/callback',
        'code' => $request->code,
    ]);
 
    return $response->json();
});
// Route::get('/auth/redirect', [PassportClientController::class, 'redirectToPassport'])->name('passport.redirect');
// Route::get('/auth/callback', [PassportClientController::class, 'handlePassportCallback'])->name('passport.callback');

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


// Admin routes for users with edit articles permission
Route::middleware('role_or_permission:edit articles')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // Pages management routes (admin)
    Route::resource('pages', PageController::class);
    // Slides management routes (admin)
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('slides', SlideController::class);
    });
});

// Superadmin-only admin routes for managing users, roles, and permissions
Route::middleware(['role:superadmin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('users/export', [\App\Http\Controllers\UserController::class, 'export'])->name('users.export');
    Route::resource('users', \App\Http\Controllers\UserController::class);
    Route::resource('roles', \App\Http\Controllers\RoleController::class);
    Route::resource('permissions', \App\Http\Controllers\PermissionController::class);
    
    // Blog Management Routes
    Route::prefix('blog')->name('blog.')->group(function () {
        Route::resource('categories', \App\Http\Controllers\Admin\BlogCategoryController::class);
        Route::resource('tags', \App\Http\Controllers\Admin\BlogTagController::class);
        Route::resource('posts', \App\Http\Controllers\Admin\BlogPostController::class);
        Route::resource('comments', \App\Http\Controllers\Admin\BlogCommentController::class);
        
        // Comment actions
        Route::post('comments/{comment}/approve', [\App\Http\Controllers\Admin\BlogCommentController::class, 'approve'])->name('comments.approve');
        Route::post('comments/{comment}/spam', [\App\Http\Controllers\Admin\BlogCommentController::class, 'spam'])->name('comments.spam');
        Route::post('comments/{comment}/pending', [\App\Http\Controllers\Admin\BlogCommentController::class, 'pending'])->name('comments.pending');
        Route::post('comments/bulk-action', [\App\Http\Controllers\Admin\BlogCommentController::class, 'bulkAction'])->name('comments.bulk-action');
    });
});

require __DIR__.'/auth.php';

// Public blog routes
Route::get('/blog', [\App\Http\Controllers\BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/category/{category:slug}', [\App\Http\Controllers\BlogController::class, 'category'])->name('blog.category');
Route::get('/blog/{post:slug}', [\App\Http\Controllers\BlogController::class, 'show'])->name('blog.show');
Route::post('/blog/{post:slug}/comments', [\App\Http\Controllers\BlogController::class, 'storeComment'])->name('blog.comments.store');

// Public page routes
Route::get('/featured-pages', [PageController::class, 'featured'])->name('pages.featured');
Route::get('/{slug}', [PageController::class, 'showBySlug'])->name('pages.public')->where('slug', '[a-zA-Z0-9\-_]+');


