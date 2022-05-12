<?php

use Illuminate\Support\Facades\Route;

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
Route::get('scheduler/cron/{cron_name}', 'Backoffice\CronJobController@callCron');

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix'     => 'admin', 'namespace'  => 'Backoffice',], function () {
	//auth
	Route::namespace('Auth')->group(function () {
		Route::get('/', function () {
            return redirect()->route('sysadmin.auth');
        });
		Route::get('login', 'LoginController@index')->name('sysadmin.auth');
		Route::post('login', 'LoginController@login')->name('sysadmin.login');
		Route::get('logout', 'LoginController@logout')->name('sysadmin.logout');

		//Lupa Password
		Route::get('forgot-password', 'ForgotPasswordController@getEmail')->name('sysadmin.forgotpassword');
		Route::post('forgot-password', 'ForgotPasswordController@sendEmail')->name('sysadmin.forgetpassword.send');
		Route::get('reset-password/{token}', 'ForgotPasswordController@editPassword')->name('sysadmin.edit.password');
		Route::put('reset-password', 'ForgotPasswordController@updatePassword')->name('sysadmin.update.password');
		Route::get('activity-user/{token}', 'ForgotPasswordController@activatedUser')->name('sysadmin.active-user');
	});
	Route::group(['middleware' => ['auth']], function() {
		Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

		Route::namespace('Masterdata')->group(function () {
			Route::resource('sliders', SliderController::class);
			Route::get('sliders/{slider}/{status}', 'SliderController@activeNonActive')->name('sliders.active_nonactive');

			Route::resource('banks', BankController::class);
			Route::get('banks/{bank}/{status}', 'BankController@activeNonActive')->name('banks.active_nonactive');

			Route::resource('bank_accounts', BankAccountController::class);
			Route::get('bank_accounts/{bank_account}/{status}', 'BankAccountController@activeNonActive')->name('bank_accounts.active_nonactive');

			Route::resource('categories', CategoryController::class);
			Route::get('categories/{category}/{status}', 'CategoryController@activeNonActive')->name('categories.active_nonactive');

			Route::resource('type_corporates', TypeCorporateController::class);
			Route::get('type_corporates/{type_corporate}/{status}', 'TypeCorporateController@activeNonActive')->name('type_corporates.active_nonactive');

			Route::resource('faq_categories', FAQCategoryController::class);
			Route::get('faq_categories/{faq_category}/{status}', 'FAQCategoryController@activeNonActive')->name('faq_categories.active_nonactive');

			Route::resource('transaction_types', TransactionTypeController::class);
			Route::get('transaction_types/{transaction_type}/{status}', 'TransactionTypeController@activeNonActive')->name('transaction_types.active_nonactive');

			Route::resource('transaction_detail', TransactionDetailController::class);
			Route::get('transaction_detail/{transaction_detail}/{status}', 'TransactionDetailController@activeNonActive')->name('transaction_detail.active_nonactive');

			Route::resource('faq_descriptions', FAQDescriptionController::class);
			Route::get('faq_descriptions/{faq_description}/{status}', 'FAQDescriptionController@activeNonActive')->name('faq_descriptions.active_nonactive');
			Route::post('faq_descriptions/ckeditor/image_upload', 'FAQDescriptionController@upload')->name('upload_faq-description');
		});

		Route::namespace('Approval')->group(function () {
			Route::get('campaigner-approval', 'ApprovalCampaignerController@index')->name('campaigner-approval.index');
			Route::get('campaigner-approval/{id}', 'ApprovalCampaignerController@show')->name('campaigner-approval.show');
			Route::post('campaigner-approval/approve', 'ApprovalCampaignerController@approvalProccess')->name('campaigner-approval.approvalCampaigner');
			Route::get('campaigner-approval/{campaigner_approval}/{status}', 'ApprovalCampaignerController@activeNonActive')->name('campaigner-approval.active_nonactive');

			Route::get('transaction-approval', 'ApprovalTransactionController@index')->name('transaction-approval.index');
			Route::get('transaction-approval/{id}', 'ApprovalTransactionController@show')->name('transaction-approval.show');
			Route::put('transaction-approval/update/{id}', 'ApprovalTransactionController@update')->name('transaction-approval.update');
			Route::post('transaction-approval/approve', 'ApprovalTransactionController@approvalProccess')->name('transaction-approval.approvalTransaction');
			Route::get('transaction-approval/{transaction_approval}/{status}', 'ApprovalTransactionController@activeNonActive')->name('transaction-approval.active_nonactive');

			Route::get('widhdrawal-approval', 'ApprovalWidhdrawalController@index')->name('widhdrawal-approval.index');
			Route::get('widhdrawal-approval/{id}', 'ApprovalWidhdrawalController@show')->name('widhdrawal-approval.show');
			Route::post('widhdrawal-approval/approve', 'ApprovalWidhdrawalController@approvalProccess')->name('widhdrawal-approval.approvalWidhdrawal');
			Route::get('widhdrawal-approval/{widhdrawal_approval}/{status}', 'ApprovalWidhdrawalController@activeNonActive')->name('widhdrawal-approval.active_nonactive');

			// Route::get('campaign-approval', 'ApprovalCampaignController@index')->name('campaign-approval.index');
			// Route::get('campaign-approval/{id}/{status}', 'ApprovalCampaignController@mainProgramStatus')->name('campaign-approval.status');
			// Route::get('campaign-approval/{id}', 'ApprovalCampaignController@show')->name('campaign-approval.show');
			// Route::post('campaign-approval/approve', 'ApprovalCampaignController@approvalProccess')->name('campaign-approval.approvalCampaign');
		});

		Route::namespace('Report')->group(function () {
			Route::get('laporan-campaign', 'ReportCampaignController@index')->name('laporan-campaign.index');
			Route::get('laporan-campaign/{id}/{status}', 'ReportCampaignController@mainProgramStatus')->name('laporan-campaign.status');
			Route::get('laporan-campaign/{id}', 'ReportCampaignController@show')->name('laporan-campaign.show');

			Route::get('laporan-transaksi', 'ReportTransactionController@index')->name('laporan-transaction.index');
			Route::get('laporan-transaksi/{id}', 'ReportTransactionController@show')->name('laporan-transaction.show');
			Route::get('laporan-transaksi/exportTransaksi/{id}', 'ReportTransactionController@exportExcel')->name('laporan-transaction.excel');
		});

		Route::namespace('Settings')->group(function () {
			// Profile
			Route::get('profile/{user}',  'ProfileController@show')->name('sysprofile.user');
			Route::get('edit-profile/{user}',  'ProfileController@edit')->name('sysprofile.edit');
			Route::put('edit-profile/{user}',  'ProfileController@update')->name('sysprofile.update');
			Route::get('change-password/{user}',  'ProfileController@changePassword')->name('sysprofile.change-password');
			Route::put('change-password/{user}',  'ProfileController@updatePassword')->name('sysprofile.update-password');

			Route::resource('roles', RoleController::class);
			Route::get('roles/{role}/{status}', 'RoleController@activeNonActive')->name('roles.active_nonactive');
			Route::resource('users', SysUserController::class);
			Route::get('users/{user}/{status}', 'SysUserController@activeNonActive')->name('users.active_nonactive');
			Route::resource('menus', SysMenuController::class);
			Route::get('menus/{menu}/{status}', 'SysMenuController@activeNonActive')->name('menus.active_nonactive');
			Route::resource('template_messages', TemplateMessageController::class);
			Route::get('template_messages/{template_message}/{status}', 'TemplateMessageController@activeNonActive')->name('template_messages.active_nonactive');

			Route::resource('profile-yayasan', ProfileYayasanController::class);
			Route::post('profile-yayasan/image_upload', 'ProfileYayasanController@upload')->name('profile-yayasan.upload');
			Route::post('template_messages/image_upload', 'TemplateMessageController@upload')->name('template_messages.upload');
		});
	});
		//Route::post('ckeditor/image_upload', 'CKEditorController@upload')->name('upload');
});

Route::group(['prefix'     => '/', 'namespace'  => 'Frontoffice',], function () {
	Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
	Route::get('/', 'HomeController@index')->name('frontoffice');
	Route::get('/pencarian', 'HomeController@search')->name('frontoffice.search');
	// Route::get('/data-campaign/{id}', 'HomeController@getDataCampaign')->name('frontoffice.dataCampaign');
	Route::get('/detail/{slug}', 'HomeController@campaignDetail')->name('frontoffice.campaignDetail');
	Route::get('semua-kategori', 'HomeController@campaignList')->name('frontoffice.campaignList');
	Route::get('bantuan', 'HomeController@faq')->name('frontoffice.faq');
	Route::get('syarat-dan-ketentuan', 'HomeController@term')->name('frontoffice.term');
	Route::get('syarat-dan-ketentuan-fundraiser', 'HomeController@termFundraiser')->name('frontoffice.term-fundraiser');
	Route::get('tentang-kami', 'HomeController@about')->name('frontoffice.about');

	// Like
	// Route::post('/like/{id}/{campaignerId}/{campaignId}', 'HomeController@likeStory')->name('like-campaigner');
	// Route::get('/checkLike/{campaignerId}/{campaignId}', 'HomeController@checkLike')->name('checkLike-campaigner');

	// Campaigner
	Route::get('/data-campaigner/{type}/{id}', 'HomeController@pageCampaigner')->name('frontoffice.campaigner');

	Route::get('/pembayaran/{slug}', 'TransactionController@index')->name('frontoffice.payment');
	Route::post('/transaksi-pembayaran', 'TransactionController@store')->name('frontoffice.paymentTransaction');
	Route::get('/invoice/{id}', 'TransactionController@invoice')->name('frontoffice.invoice');
	Route::get('/invoice-user/{id}', 'TransactionController@invoiceNon')->name('frontoffice.invoice-user');

	// Fundraiser
	Route::get('/{slug}/reff={slug_token}', 'HomeController@detailFundraiser')->name('frontoffice.fundraiser-detail');
	Route::get('/{slug}/payment/{token}/fundraiser', 'TransactionController@paymentFundraiser')->name('frontoffice.fundraiser-payment');

	Route::group(['middleware' => ['auth:member']], function(){
		// Halaman Program Fundraiser
		Route::get('/daftar-fundraiser/{slug}', 'HomeController@registerFundraiser')->name('frontoffice.fundraiser-register');
	});

	Route::namespace('Auth')->group(function () {
		Route::get('halaman-login', 'AuthController@onBoardLogin')->name('auth-user.onboardLogin');
		Route::get('login', 'AuthController@showLoginForm')->name('auth-user.login');
		Route::post('login-user', 'AuthController@LoginProcess')->name('auth-user.loginProcess');

		Route::get('daftar', 'AuthController@showRegisterForm')->name('auth-user.register');
		Route::post('daftar', 'AuthController@store')->name('auth-user.store');

		Route::get('/sukses-daftar/{id}', 'AuthController@successRegister')->name('auth-user.successRegister');
		Route::post('/sukses-daftar/{id}', 'AuthController@confirmationPin')->name('auth-user.confirmationPin');
		Route::get('/success-register-send-otp/{id}', 'AuthController@sendEmail')->name('auth-user.sendEmail');
		Route::get('/pendaftaran-berhasil/{id}', 'AuthController@showInfoUserForm')->name('auth-user.success');

		Route::post('auth-user/logout', 'AuthController@logout')->name('auth-user.logout');

		// Social Authentication
		Route::get('/auth/{provider}', 'OauthController@redirectToProvider');
		Route::get('/auth/{provider}/callback', 'OauthController@handleProviderCallback');

		//Lupa Password
		Route::get('lupa-password', 'ForgotPasswordController@formPassword')->name('auth-user.forgotPassword');
		Route::post('lupa-password', 'ForgotPasswordController@sendEmail')->name('auth-user.sendForgotPassword');
		Route::get('reset-password/{token}', 'ForgotPasswordController@editPasswordOtp')->name('auth-user.editPassword');
		Route::post('konfirmasi-otp/{token}', 'ForgotPasswordController@confirmationOTP')->name('auth-user.reset_confirmationOtp');
		Route::get('edit-password/{id}', 'ForgotPasswordController@editPassword')->name('auth-user.editFormPassword');
		Route::put('edit-password', 'ForgotPasswordController@updatePassword')->name('auth-user.updatePassword');
		Route::get('aktivasi-user/{token}', 'ForgotPasswordController@activatedUser')->name('auth-user.activeUser');
	});

	Route::group(['middleware' => ['auth:member']], function(){
		Route::namespace('Donatur')->group(function(){
			Route::get('/dashboard-overview', 'DashboardController@index')->name('dashboard-users');
			Route::get('/fundraising-saya', 'DashboardController@fundraiser')->name('dashboard-fundraiser');
			Route::get('/fundraising-detail/{id}', 'DashboardController@fundraiserDetail')->name('dashboard-fundraiserDetail');
			Route::get('/konfirmasi-pembayaran', 'DashboardController@confirmationManual')->name('dashboard-confirmation_manual');
			Route::get('/konfirmasi-pembayaran/{transaction_number?}', 'DashboardController@confirmationByTransaction')->name('dashboard-confirmation_manualTransaction');
			Route::post('/konfirmasi-pembayaran', 'DashboardController@confirmationManualProcess')->name('dashboard-confirmation_manual.store');
			Route::get('/data-pembayaran/{id}', 'DashboardController@getDataTransaction')->name('dashboard-dataConfirmation');
			Route::get('/riwayat-donasi', 'DashboardController@getMyDonation')->name('dashboard-myDonation');
			Route::get('/riwayat-donasi/{id}', 'DashboardController@detailMyDonation')->name('dashboard-myDonation.detail');
			Route::get('/riwayat-cancel-donasi/{id}', 'DashboardController@cancelMyDonation')->name('dashboard-myDonation.cancel');

			// Campaigner
			Route::get('/jadi-campaigner', 'CampaignerController@index')->name('registrasi-campaign');
			Route::get('/jadi-campaigner/{type}', 'CampaignerController@onBoardRegCampaigner')->name('registrasi-tipeCampaign');
			Route::get('/syarat-ketentuan-campaigner/{type}', 'CampaignerController@terms')->name('terms-campaign');
			Route::put('/daftar-campaigner-personal', 'CampaignerController@storeRegisterCampaigner')->name('store-registrasiCampaigner');
			Route::post('/daftar-campaigner-corporate', 'CampaignerController@storeRegisterCorporateCampaigner')->name('store-registrasiCorporateCampaigner');
			Route::get('/info-campaigner', 'CampaignerController@pageSuccess')->name('success-pageCampaigner');

			// Bank Pencairan
			Route::get('/data-bank-saya', 'CampaignerController@pageBank')->name('bank-campaigner');
			Route::get('/tambah-bank', 'CampaignerController@createBank')->name('create-bank-campaigner');
			Route::post('/tambah-bank/store', 'CampaignerController@storeBank')->name('store-bank-campaigner');
			Route::get('/edit-bank/{id}', 'CampaignerController@editBank')->name('edit-bank-campaigner');
			Route::put('/update-bank/{id}', 'CampaignerController@updateBank')->name('update-bank-campaigner');
			Route::get('/delete-bank/{id}', 'CampaignerController@deleteBank')->name('delete-bank-campaigner');

			Route::get('/jadi-campaigner/{id}/cities', 'CampaignerController@getCity')->name('get-city');
			Route::get('/jadi-campaigner/{id}/district', 'CampaignerController@getDistrict')->name('get-district');
			Route::get('/jadi-campaigner/{id}/area', 'CampaignerController@getArea')->name('get-area');

			// Personal
			Route::get('/dashboard-campaigner-personal', 'CampaignController@indexPersonal')->name('dashboard-personal-campaign');
			Route::get('/pengaturan-personal/{id}/', 'CampaignController@editPersonal')->name('setting-campaignerPersonal');
			Route::put('/pengaturan-personal/{id}/update', 'CampaignController@updatePersonal')->name('update-campaignerPersonal');

			// Corporate
			Route::get('/dashboard-campaigner-corporate', 'CampaignController@indexCorporate')->name('dashboard-campaign');
			Route::get('/pengaturan-corporate/{id}/', 'CampaignController@editCorporate')->name('setting-campaignerCorporate');
			Route::put('/pengaturan-corporate/{id}/update', 'CampaignController@updateCorporate')->name('update-campaignerCorporate');

			// Widhdrawal
			Route::get('/pencairan-dana-campaign/{slug}', 'CampaignController@widhdrawal')->name('dashboard-widhdrawal');
			Route::get('/export-data-donatur/{id}', 'CampaignController@exportDonatur')->name('dashboard-export_donatur');
			Route::post('/konfirmasi-password/{slug}', 'CampaignController@confirmationPassword')->name('dashboard-confirmation-password');
			Route::get('/form-pencairan-dana/{slug}', 'CampaignController@widhdrawalCreate')->name('dashboard-widhdrawa.create');
			Route::post('/form-pencairan-dana/store', 'CampaignController@widhdrawalStore')->name('dashboard-widhdrawal-store');

			Route::get('/halaman-galang-dana', 'CampaignController@onBoardCampaign')->name('onboard-campaign');
			Route::get('/campaign-saya', 'CampaignController@myCampaign')->name('list-campaign');
			Route::get('/form-galang-dana', 'CampaignController@indexCreateCampaign')->name('create-campaign');
			Route::post('/form-galang-dana/store', 'CampaignController@formCampaign')->name('store-campaign');
			Route::get('/form-galang-dana/edit/{id}', 'CampaignController@indexEditCampaign')->name('edit-campaign');
			Route::put('/form-galang-dana/update/{id}', 'CampaignController@formCampaignUpdate')->name('update-campaign');
			Route::get('/sukses-campaign', 'CampaignController@successCreateForm')->name('success-campaign');
			Route::get('/sukses-update-campaign', 'CampaignController@successEditForm')->name('success-edit-campaign');

			// Program Update
			Route::get('/data-kabar-terbaru/{id}', 'CampaignController@pageUpdateNew')->name('campaign-update.list');
			Route::get('/tambah-kabar-terbaru/{id}', 'CampaignController@createUpdateNew')->name('campaign-update.new');
			Route::post('/tambah-kabar-terbaru/store', 'CampaignController@storeUpdate')->name('campaign-update.store');
			Route::get('/ubah-kabar-terbaru/{id}', 'CampaignController@editUpdateNew')->name('campaign-update.edit');
			Route::put('/ubah-kabar-terbaru/{id}/update', 'CampaignController@updateUpdateNew')->name('campaign-update.update');
			Route::get('/delete-kabar-terbaru/{id}', 'CampaignController@deleteUpdateNew')->name('campaign-update.delete');

			// Profile
			Route::get('/pengaturan-profile', 'ProfileController@index')->name('dashboard-setting_users');
			Route::post('/pengaturan-profile/edit-profile/{id}', 'ProfileController@editProfile')->name('dashboard-editProfile');
			Route::post('/pengaturan-profile/edit-address/{id}', 'ProfileController@editAddress')->name('dashboard-editAddress');
			Route::post('/pengaturan-profile/edit-password/{id}', 'ProfileController@editPassword')->name('dashboard-editPassword');
			Route::get('/pengaturan-profile/{id}/create/cities', 'ProfileController@getCity')->name('users.get-city');
			Route::get('/pengaturan-profile/{id}/create/district', 'ProfileController@getDistrict')->name('users.get-district');
			Route::get('/pengaturan-profile/{id}/create/area', 'ProfileController@getArea')->name('users.get-area');

			// Amen
			Route::get('/amen/{transaction_id?}/{value?}', 'AmenController@store')->name('frontoffice.amen');
		});


	});

});
