<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SolutionController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ChallengeController;
use App\Http\Controllers\LeaderboardController;
use App\Http\Controllers\PricingController;
use App\Http\Controllers\CompletedChallengesController;

use Laravel\Fortify\Http\Controllers\TwoFactorAuthenticatedSessionController;

use Laravel\Fortify\Http\Controllers\ConfirmablePasswordController;
use Laravel\Fortify\Http\Controllers\ConfirmedPasswordStatusController;
use Laravel\Fortify\Http\Controllers\ConfirmedTwoFactorAuthenticationController;
use Laravel\Fortify\Http\Controllers\TwoFactorAuthenticationController;
use Laravel\Fortify\Http\Controllers\TwoFactorQrCodeController;
use Laravel\Fortify\Http\Controllers\RecoveryCodeController;
use Laravel\Fortify\Http\Controllers\TwoFactorSecretKeyController;
use App\Http\Controllers\PayPalController;
use App\Http\Controllers\Auth\TwoFactorAuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/solutions', [SolutionController::class, 'index'])->name('solutions.index');
Route::get('/solutions/{id}', [SolutionController::class, 'show'])->name('solutions.show');
Route::put('/solutions/{id}/update-status', [SolutionController::class, 'updateStatus'])->name('solutions.updateStatus');

// ... other routes ...

Route::get('/2fa-challenge', [TwoFactorAuthController::class, 'showChallenge'])->name('2fa.challenge');
Route::post('/2fa-challenge', [TwoFactorAuthController::class, 'verifyCode'])->name('2fa.verify');
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');


Route::get('/', [App\Http\Controllers\PublicController::class, 'index'])->name('index');
//Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');

Route::resource('categories', CategoryController::class)->except(['show', 'edit', 'update']);

Route::get('/challenges', [ChallengeController::class, 'index'])->name('challenges')->middleware('auth');
Route::get('/challenges/{id}', [ChallengeController::class, 'show'])->name('challenges.show');
Route::get('/challenges/category/{slug}', [ChallengeController::class, 'category'])->name('challenges.category');
Route::get('/challenges/create', [ChallengeController::class, 'create'])->name('challenges.create');
Route::post('/challenges', [ChallengeController::class, 'store'])->name('challenges.store');
Route::get('/challenges/{challenge}/editor', [ChallengeController::class, 'editor'])->name('challenges.editor');
Route::post('/challenges/{challenge}/submit', [ChallengeController::class, 'submit'])->name('challenges.submit');
Route::get('/certificates', [ChallengeController::class, 'certificates'])->name('certificates');


Route::get('/leaderboard', [LeaderboardController::class, 'index'])->name('leaderboard');
Route::get('/pricing', [PricingController::class, 'index'])->name('pricing');
Route::get('/pricing/choose/{id}', [PricingController::class, 'choose'])->name('pricing.choose');


Route::get('process-transaction/{amount}', [\App\Http\Controllers\PaypalController::class, 'processTransaction'])->name('processTransaction');
Route::post('/process-transaction', [PaypalController::class, 'processTransaction'])->name('processTransaction');
Route::get('success-transaction', [\App\Http\Controllers\PaypalController::class, 'successTransaction'])->name('successTransaction');
Route::get('cancel-transaction', [\App\Http\Controllers\PaypalController::class, 'cancelTransaction'])->name('cancelTransaction');


Route::get('/two-factor-challenge', [TwoFactorAuthenticatedSessionController::class, 'create'])
    ->name('two-factor.login');

Route::post('/two-factor-challenge', [TwoFactorAuthenticatedSessionController::class, 'store']);

Route::get('/user/confirm-password', [ConfirmablePasswordController::class, 'show'])
    ->middleware(['auth'])
    ->name('password.confirm');

Route::post('/user/confirm-password', [ConfirmablePasswordController::class, 'store'])
    ->middleware(['auth'])
    ->name('password.confirm');

Route::get('/user/confirmed-password-status', [ConfirmedPasswordStatusController::class, 'show'])
    ->middleware(['auth'])
    ->name('password.confirmation');

Route::post('/user/confirmed-two-factor-authentication', [ConfirmedTwoFactorAuthenticationController::class, 'store'])
    ->middleware(['auth'])
    ->name('two-factor.confirm');

Route::post('/user/two-factor-authentication', [TwoFactorAuthenticationController::class, 'store'])
    ->middleware(['auth', 'password.confirm'])
    ->name('two-factor.enable');

Route::delete('/user/two-factor-authentication', [TwoFactorAuthenticationController::class, 'destroy'])
    ->middleware(['auth', 'password.confirm'])
    ->name('two-factor.disable');

Route::get('/user/two-factor-qr-code', [TwoFactorQrCodeController::class, 'show'])
    ->middleware(['auth', 'password.confirm'])
    ->name('two-factor.qr-code');

Route::get('/user/two-factor-recovery-codes', [RecoveryCodeController::class, 'index'])
    ->middleware(['auth', 'password.confirm'])
    ->name('two-factor.recovery-codes');

Route::post('/user/two-factor-recovery-codes', [RecoveryCodeController::class, 'store'])
    ->middleware(['auth', 'password.confirm']);

Route::get('/user/two-factor-secret-key', [TwoFactorSecretKeyController::class, 'show'])
    ->middleware(['auth', 'password.confirm'])
    ->name('two-factor.secret-key');


Route::get('/completed-challenges', [CompletedChallengesController::class, 'index'])->name('completed-challenges.index');
Route::post('/completed-challenges/{challenge}/request-certificate', [CompletedChallengesController::class, 'requestCertificate'])->name('completed-challenges.request-certificate');
Route::get('/completed-challenges/success', [CompletedChallengesController::class, 'successTransaction'])->name('successTransaction');
Route::get('/completed-challenges/cancel', [CompletedChallengesController::class, 'cancelTransaction'])->name('cancelTransaction');

Route::middleware('auth')->group(function () {
    Route::post('/subscriptions', [SubscriptionController::class, 'store'])->name('subscriptions.store');
    Route::get('/paypal/process/{subscription_id}', [PayPalController::class, 'processTransaction'])->name('paypal.process');
    Route::resource('users', UserController::class);

});

