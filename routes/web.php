<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FirstTimeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\ManagerAdminController;
use App\Http\Controllers\MessagesController;
use App\Http\Controllers\SystemAdminController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\MeetingController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\FinanceController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;

// Redirect root to login
Route::redirect('/', '/login')->name('loginn');

// Auth/Login Routes
Route::get('/loginn', [FirstTimeController::class, 'firmus_login_red']);
Route::get('/first-login', [FirstTimeController::class, 'first_page_show']);
Route::post('/pass_confirm_update', [FirstTimeController::class, 'employee_confirm_password']);
Route::post('/reset_user_password/{user_id}', [FirstTimeController::class, 'reset_user_password']);

Auth::routes();


// Home
Route::get('/home', [HomeController::class, 'index'])->name('home');

// Manager Routes
Route::prefix('manager')->group(function () {
    Route::get('/home/{user?}', [ManagerController::class, 'managerIndex']);
    Route::get('/my-jobs/{user?}', [ManagerController::class, 'managerMyJobs']);
    Route::get('/employees/{user?}', [ManagerController::class, 'managerEmployees']);
    Route::get('/report/{user?}', [ManagerController::class, 'index']);
    Route::post('/generate_report', [ManagerController::class, 'getQueriedResults']);
    Route::get('/clients/{user?}', [ManagerController::class, 'managerClients']);
});

Route::prefix('manager-jobs')->group(function () {
    Route::get('/{user?}', [ManagerAdminController::class, 'viewJobRequests']);
    Route::post('/add/{user?}', [ManagerAdminController::class, 'addJobRequest'])->name('addJobRequest');
    Route::post('/edit/{user?}', [ManagerAdminController::class, 'editJobRequest'])->name('editJobRequest');
    Route::post('/delete/{user?}', [ManagerAdminController::class, 'deleteJobRequest'])->name('deleteJobRequest');
    Route::post('/assign/{user?}', [ManagerAdminController::class, 'job_make_assignment']);
    Route::get('/details/{user?}/{id?}', [ManagerAdminController::class, 'viewJobDetails']);
    Route::get('/assign_retrieve_information/{id}', [ManagerAdminController::class, 'job_assign_retrieve']);
});

Route::post('/message', [MessagesController::class, 'message']);
Route::get('/getMessages/{id}', [MessagesController::class, 'getMessages']);

Route::post('/send_client_information/{user?}', [ManagerController::class, 'firmus_client_send']);
Route::get('/client_edit_get_information/{id}', [ManagerController::class, 'firmus_client_edit']);
Route::post('/client_edit_information/{id}', [ManagerController::class, 'firmus_client_real_edit']);
Route::post('/client_delete_information/{id}', [ManagerController::class, 'firmus_client_delete']);

Route::get('/new_contact_information_retrieve/{user?}', [ManagerController::class, 'firmus_new_clients']);
Route::get('/new_contact_information_retrieve_php/{user?}', [ManagerController::class, 'firmus_new_clients_php']);

// Admin Routes
Route::prefix('admin')->group(function () {
    Route::get('/home/{user?}', [SystemAdminController::class, 'adminIndex']);
    Route::get('/jobs/{user?}', [SystemAdminController::class, 'view_jobs']);
    Route::post('/edit_jobs', [SystemAdminController::class, 'edit_job'])->name('editJob');
    Route::post('/add_tasks/{user?}', [SystemAdminController::class, 'add_task'])->name('editTask');
    Route::post('/delete_jobs/{user?}', [SystemAdminController::class, 'delete_job'])->name('deleteJob');
    Route::post('/add_jobs/{user?}', [SystemAdminController::class, 'add_job'])->name('addJob');
    Route::get('/employees/{user?}', [SystemAdminController::class, 'adminEmployees']);
    Route::get('/web-stats/{user?}', [SystemAdminController::class, 'adminWebStats']);
    Route::post('/employees-send-info', [SystemAdminController::class, 'employee_in_system']);
    Route::get('/employees/{user?}', [SystemAdminController::class, 'employee_in_system_retrieve']);
    Route::get('/employee_in_update_record/{id}', [SystemAdminController::class, 'employee_in_update_record']);
    Route::post('/employee_in_update_record_user/{id}', [SystemAdminController::class, 'employee_in_update_record_individual']);
    Route::post('/employee_delete_information/{id}', [SystemAdminController::class, 'firmus_employee_delete']);
});

// Job CRUD (for admin)
Route::post('/add_job', [SystemAdminController::class, 'add_job'])->name('addJob');
Route::post('/edit_job', [SystemAdminController::class, 'edit_job'])->name('editJob');
Route::post('/delete_job', [SystemAdminController::class, 'delete_job'])->name('deleteJob');

// Address Routes
Route::prefix('address-book')->group(function () {
    Route::post('/send_contact', [AddressController::class, 'send_contact_information']);
    Route::get('/{user?}', [AddressController::class, 'contact_information_retrieve']);
    Route::get('/contact/{id}', [AddressController::class, 'contact_ind_retrieve']);
    Route::get('/view_firmus_contact/{id}', [AddressController::class, 'contact_retrieve']);
    Route::post('/update_firmus_contact_info/{id}', [AddressController::class, 'contact_update']);
    Route::post('/delete_firmus_contact_info/{id}', [AddressController::class, 'contact_delete']);
    Route::get('/sendReminder', [AddressController::class, 'sendRenewalReminder']);
    Route::post('/sendEmailRequest', [AddressController::class, 'clientEmailNotification']);
});

// Meetings Routes
Route::prefix('meeting')->group(function () {
    Route::get('/directory/{user?}', [MeetingController::class, 'meeting_information_display']);
    Route::post('/make', [MeetingController::class, 'create_meeting']);
    Route::get('/get_information/{id}', [MeetingController::class, 'get_meeting_back']);
    Route::post('/update_minutes/{id}', [MeetingController::class, 'update_meeting_minute']);
    Route::post('/update_status/{id}', [MeetingController::class, 'update_meeting_status']);
    Route::post('/send_email_firmus', [AddressController::class, 'sendClientEmail']);
});

// Employee Routes
Route::prefix('employee')->group(function () {
    Route::get('/home', [EmployeeController::class, 'employeeIndex']);
    Route::get('/jobs/{user?}', [EmployeeController::class, 'employeeJobs']);
    Route::get('/meetings', [EmployeeController::class, 'employeeMeetings']);
    Route::post('/save_job_task_completion', [EmployeeController::class, 'save_job_task']);
    Route::get('/clients/{user?}', [EmployeeController::class, 'employeeClients']);
    Route::post('/send_client_information/{user?}', [EmployeeController::class, 'firmus_client_send']);
    Route::get('/client_edit_get_information/{id}', [EmployeeController::class, 'firmus_client_edit']);
    Route::post('/client_edit_information/{id}', [EmployeeController::class, 'firmus_client_real_edit']);
    Route::post('/client_delete_information/{id}', [EmployeeController::class, 'firmus_client_delete']);
});

Route::prefix('employee-jobs')->group(function () {
    Route::get('/{user?}', [EmployeeController::class, 'viewJobRequests']);
    Route::post('/add/{user?}', [EmployeeController::class, 'addJobRequest'])->name('addJobRequest');
    Route::post('/edit/{user?}', [EmployeeController::class, 'editJobRequest'])->name('editJobRequest');
    Route::post('/delete/{user?}', [EmployeeController::class, 'deleteJobRequest'])->name('deleteJobRequest');
    Route::post('/assign/{user?}', [EmployeeController::class, 'job_make_assignment']);
    Route::get('/details/{user?}/{id?}', [EmployeeController::class, 'viewJobDetails']);
    Route::get('/assign_retrieve_information/{id}', [EmployeeController::class, 'job_assign_retrieve']);
});

// Finance Officer Routes
Route::prefix('finance')->group(function () {
    Route::get('/home/{user}', [FinanceController::class, 'financeIndex']);
    Route::get('/address-book/{user}', [FinanceController::class, 'financeAddressBook']);
    Route::get('/jobs/{user}', [FinanceController::class, 'viewJobs']);
    Route::post('/make_payment', [FinanceController::class, 'makePayment']);
    Route::get('/viewTransactions/{ref_no?}', [FinanceController::class, 'viewTransactions']);
});

// Client Routes
Route::get('/track', [ClientController::class, 'track']);
Route::post('/tracked-result', [ClientController::class, 'trackedResult']);

// Notifications
Route::prefix('notification')->group(function () {
    Route::post('/send', [NotificationController::class, 'sendNotification']);
    Route::get('/get', [NotificationController::class, 'getNotification']);
    Route::post('/delete', [NotificationController::class, 'deleteNotification']);
    Route::get('/count', [NotificationController::class, 'countNotification']);
    Route::post('/deleteEmployee/{id}', [NotificationController::class, 'deleteNotificationEmployee']);
    Route::post('/deleteAll', [NotificationController::class, 'deleteAllNotificationEmployee']);
});

// Profile
Route::prefix('profile')->group(function () {
    Route::get('/{user}', [ProfileController::class, 'index']);
    Route::post('/update', [ProfileController::class, 'update']);
    Route::post('/uploadProfilePic', [ProfileController::class, 'uploadProfilePic']);
});

// Stats
Route::get('/getManagerStats', [ManagerController::class, 'getStats']);
Route::get('/getEmployeeStats', [EmployeeController::class, 'getStats']);
Route::get('/getAdminStats', [SystemAdminController::class, 'getStats']);
Route::get('/getFinanceStats', [FinanceController::class, 'getStats']);
