<?php

use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SiteMapController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::post('/increment-download-count',[\App\Http\Controllers\ContactController::class,'incrementDownloadCount'])->name('incrementDownloadCount');
Route::get('/login',function (){ return redirect('portal/login'); })->name('login');
Route::get('/register',function (){ return redirect('portal/register'); })->name('register');
Route::get('/', [App\Http\Controllers\WebsiteController::class, 'index'])->name('website');
Route::get('/page/{slug}', [App\Http\Controllers\PageController::class, 'view_page'])->name('website.page');
Route::get('/admin/pages/{page}/editor', [App\Http\Controllers\PageController::class, 'editor'])->name('website.page.editor');
Route::get('/blog', [App\Http\Controllers\WebsiteController::class, 'blog'])->name('blog');

Route::get('/courses', [App\Http\Controllers\CourseController::class, 'courses'])->name('courses');
Route::get('/course-category/{slug}', [App\Http\Controllers\CourseController::class, 'course_category'])->name('course_category');
Route::get('/course/{slug}', [App\Http\Controllers\CourseController::class, 'course'])->name('course');
Route::post('/course-enroll/{id}', [App\Http\Controllers\CourseController::class, 'course_enroll'])->name('course_enroll')->middleware('auth');
Route::get('/learn/{slug}', [App\Http\Controllers\CourseController::class, 'learn'])->name('learn')->middleware(['auth']);


Route::get('/exam', [App\Http\Controllers\WebsiteController::class, 'exam'])->name('exam');
Route::get('/ebook', [App\Http\Controllers\WebsiteController::class, 'ebook'])->name('ebook');
Route::get('/notes', [App\Http\Controllers\WebsiteController::class, 'notes'])->name('notes');
Route::get('/notice', [App\Http\Controllers\WebsiteController::class, 'notice'])->name('notice');
Route::get('/categories', [App\Http\Controllers\WebsiteController::class, 'category_clouds'])->name('website.category_clouds');
Route::get('/category/{slug}', [App\Http\Controllers\WebsiteController::class, 'category'])->name('website.category');
Route::get('/author/{slug}', [App\Http\Controllers\WebsiteController::class, 'author'])->name('website.author');
Route::post('/comment', [App\Http\Controllers\HomeController::class, 'comment'])->name('website.comment');
Route::post('/comment-store', [App\Http\Controllers\ContactController::class, 'storeComment'])->name('comment.store');
Route::get('/contact', [App\Http\Controllers\ContactController::class, 'contact'])->name('website.contact');
Route::get('/about', [App\Http\Controllers\WebsiteController::class, 'about'])->name('website.about');
Route::post('/contact-form', [App\Http\Controllers\ContactController::class, 'storeContactForm'])->name('contact_form.store');
Route::get('/profile', [App\Http\Controllers\HomeController::class, 'index'])->name('profile');
Route::post('/update', [App\Http\Controllers\HomeController::class, 'update'])->name('update');
Route::get('/subject/{slug}', [App\Http\Controllers\WebsiteController::class, 'subject'])->name('subject');
Route::get('/exam-category/{slug}', [App\Http\Controllers\WebsiteController::class, 'exam_category'])->name('exam_category');
Route::get('/clone/{id}', [App\Http\Controllers\WebsiteController::class, 'clone'])->name('ep.clone');
Route::get('/start/{id}', [App\Http\Controllers\WebsiteController::class, 'start'])->name('start');

Route::get('/test/{id}', [App\Http\Controllers\ExamController::class, 'index'])->name('test')->middleware('exam_paper_password');
Route::post('/test-pass', [App\Http\Controllers\ExamController::class, 'pass'])->name('test_pass');
Route::get('/results/{id}', [App\Http\Controllers\WebsiteController::class, 'results'])->name('results');
Route::get('/result/{result}', [App\Http\Controllers\WebsiteController::class, 'result'])->name('result');
Route::get('/rank/{id}', [App\Http\Controllers\WebsiteController::class, 'rank'])->name('rank');
Route::post('/check-test', [App\Http\Controllers\ExamController::class, 'checking'])->name('checking');

Route::post('/download', [App\Http\Controllers\ExamController::class, 'download'])->name('download');

Route::get('/question-pdf/{id}', [App\Http\Controllers\WebsiteController::class, 'generatePDFquestion'])->name('question');
Route::get('/rank-pdf/{id}', [App\Http\Controllers\WebsiteController::class, 'generatePDFrank'])->name('rankpdf');
Route::get('/resultCardPdf/{id}', [App\Http\Controllers\WebsiteController::class, 'generatePDFresultCardPdf'])->name('resultCardPdf');

Route::post('/order-pay/{id}', [App\Http\Controllers\PaymentController::class, 'order_pay'])->name('order_pay');
Route::get('/order/{id}', [App\Http\Controllers\PaymentController::class, 'view_order'])->name('view_order');
Route::get('/invoice/{id}', [App\Http\Controllers\PaymentController::class, 'invoice'])->name('invoice');
Route::get('/payment/{id}',[PaymentController::class,'payment'])->name('payment');
Route::get('/payment/success/{id}/pass/{pass}',[PaymentController::class,'success'])->name('payment_success');

// Checkout (URL) User Part
Route::get('/bkash/create/{id}', [\App\Http\Controllers\Payment\BkashController::class, 'createPayment'])->name('bkash_payment');
Route::get('/bkash/callback', [\App\Http\Controllers\Payment\BkashController::class, 'callback'])->name('bkash_url_callback');

// Checkout (URL) Admin Part
//Route::get('/bkash/refund', [\App\Http\Controllers\Payment\BkashController::class, 'getRefund'])->name('url-get-refund');
//Route::post('/bkash/refund', [\App\Http\Controllers\Payment\BkashController::class, 'refundPayment'])->name('bkash_url_post_refund');

Route::get('sitemap',[SiteMapController::class,'generateSitemap']);
Route::get('/{slug}', [App\Http\Controllers\WebsiteController::class, 'post'])->name('website.post');
