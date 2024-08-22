<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('login',[\App\Http\Controllers\AdminPanel\Admin\AdminController::class,'login']);
Route::get('state/list',[\App\Http\Controllers\AdminPanel\Admin\AdminController::class,'statelist']);
Route::get('city/list',[\App\Http\Controllers\AdminPanel\Admin\AdminController::class,'citylist']);
Route::post('fiscal/transaction/initial/subscriber/{sub_scriber}/store',[\App\Http\Controllers\AdminPanel\FiscalTransaction\FiscalTransactionController::class,'initialStore']);
Route::get('facility/banklist',[\App\Http\Controllers\AdminPanel\PaymentInstallment\PaymentInstallmentController::class,'banklist']);



Route::middleware('auth:sanctum')->group(function () {

        Route::get('info',[\App\Http\Controllers\AdminPanel\Admin\AdminController::class,'info']);
        Route::get('admin/dashboard/get',[\App\Http\Controllers\AdminPanel\Admin\AdminController::class,'getDashboard']);
        Route::get('subscriber/dashboard/get',[\App\Http\Controllers\AdminPanel\SubScriber\SubScriberController::class,'getDashboard']);

    //Authenticate
    Route::prefix('report')->group(function (){
        Route::get('payment/installment',[\App\Http\Controllers\AdminPanel\ReportCenter\ReportCenterController::class,'paymentInstallment']);
        Route::get('facility/wage',[\App\Http\Controllers\AdminPanel\ReportCenter\ReportCenterController::class,'wageFacility']);
        Route::get('participant/right',[\App\Http\Controllers\AdminPanel\ReportCenter\ReportCenterController::class,'participantRight']);
        Route::get('membership/right',[\App\Http\Controllers\AdminPanel\ReportCenter\ReportCenterController::class,'membershipRight']);
        Route::post('normal',[\App\Http\Controllers\AdminPanel\ReportCenter\ReportCenterController::class,'normalReport']);
    });

    //Authenticate
    Route::prefix('colleague')->group(function (){

        Route::post('register',[\App\Http\Controllers\AdminPanel\Admin\AdminController::class,'register']);
        Route::post('logout',[\App\Http\Controllers\AdminPanel\Admin\AdminController::class,'logout']);
        Route::get('list',[\App\Http\Controllers\AdminPanel\Admin\AdminController::class,'index']);
        Route::get('{admin}/show',[\App\Http\Controllers\AdminPanel\Admin\AdminController::class,'show']);

        Route::put('{admin}/update',[\App\Http\Controllers\AdminPanel\Admin\AdminController::class,'update']);
        Route::put('update',[\App\Http\Controllers\AdminPanel\Admin\AdminController::class,'updateWithToken']);
        Route::post('delete',[\App\Http\Controllers\AdminPanel\Admin\AdminController::class,'autoDestroy']);
        Route::put('{admin}/permission/assign',[\App\Http\Controllers\AdminPanel\Admin\AdminController::class,'assignPermission']);
        Route::put('{admin}/role/assign',[\App\Http\Controllers\AdminPanel\Admin\AdminController::class,'assignRole']);
    });

    //SubScriber
    Route::prefix('subscriber')->group(function (){

        Route::post('register',[\App\Http\Controllers\AdminPanel\SubScriber\SubScriberController::class,'register']);
        Route::get('list',[\App\Http\Controllers\AdminPanel\SubScriber\SubScriberController::class,'index']);
        Route::get('info',[\App\Http\Controllers\AdminPanel\SubScriber\SubScriberController::class,'info']);

        Route::get('{sub_scriber}/show',[\App\Http\Controllers\AdminPanel\SubScriber\SubScriberController::class,'show']);
        Route::put('{sub_scriber}/update',[\App\Http\Controllers\AdminPanel\SubScriber\SubScriberController::class,'update']);
        Route::put('update',[\App\Http\Controllers\AdminPanel\SubScriber\SubScriberController::class,'updateWithToken']);
        Route::put('{sub_scriber}/password/update',[\App\Http\Controllers\AdminPanel\SubScriber\SubScriberController::class,'pass_update']);
        Route::post('delete',[\App\Http\Controllers\AdminPanel\SubScriber\SubScriberController::class,'autoDestroy']);

    //Family-SubScriber
        Route::post('{sub_scriber}/family/store',[\App\Http\Controllers\AdminPanel\FamilySubScriber\FamilySubScriberController::class,'register']);
        Route::get('{sub_scriber}/family/list',[\App\Http\Controllers\AdminPanel\FamilySubScriber\FamilySubScriberController::class,'index']);
        Route::put('family/{family_sub_scriber}/update',[\App\Http\Controllers\AdminPanel\FamilySubScriber\FamilySubScriberController::class,'update']);
        Route::get('family/{family_sub_scriber}/show',[\App\Http\Controllers\AdminPanel\FamilySubScriber\FamilySubScriberController::class,'show']);
        Route::post('family/delete',[\App\Http\Controllers\AdminPanel\FamilySubScriber\FamilySubScriberController::class,'autoDestroy']);

    });



    //Permission
    Route::prefix('permission')->group(function (){

        Route::post('store',[\App\Http\Controllers\AdminPanel\Permission\PermissionsController::class,'store']);
        Route::get('list',[\App\Http\Controllers\AdminPanel\Permission\PermissionsController::class,'index']);
        Route::get('{permissions}/show',[\App\Http\Controllers\AdminPanel\Permission\PermissionsController::class,'show']);
        Route::put('{permissions}/update',[\App\Http\Controllers\AdminPanel\Permission\PermissionsController::class,'update']);
        Route::post('delete',[\App\Http\Controllers\AdminPanel\Permission\PermissionsController::class,'delete']);
    });

    //Role
    Route::prefix('role')->group(function (){

        Route::post('store',[\App\Http\Controllers\AdminPanel\Role\RoleController::class,'store']);
        Route::get('list',[\App\Http\Controllers\AdminPanel\Role\RoleController::class,'index']);
        Route::get('{role}/show',[\App\Http\Controllers\AdminPanel\Role\RoleController::class,'show']);
        Route::put('{role}/update',[\App\Http\Controllers\AdminPanel\Role\RoleController::class,'update']);
        Route::post('{role}/permission/assign',[\App\Http\Controllers\AdminPanel\Role\RoleController::class,'assignPermission']);
        Route::get('{role}/permissions',[\App\Http\Controllers\AdminPanel\Role\RoleController::class,'permissionList']);
        Route::post('delete',[\App\Http\Controllers\AdminPanel\Role\RoleController::class,'delete']);
    });

    //Total Account

    Route::prefix('group/account')->group(function (){

        Route::post('store',[\App\Http\Controllers\AdminPanel\AccountGroupe\AccountGroupeController::class,'store']);
        Route::get('list',[\App\Http\Controllers\AdminPanel\AccountGroupe\AccountGroupeController::class,'index']);
        Route::get('{account_groupe}/show',[\App\Http\Controllers\AdminPanel\AccountGroupe\AccountGroupeController::class,'show']);
        Route::put('{account_groupe}/update',[\App\Http\Controllers\AdminPanel\AccountGroupe\AccountGroupeController::class,'update']);
        Route::post('delete',[\App\Http\Controllers\AdminPanel\AccountGroupe\AccountGroupeController::class,'delete']);
    });

    //Account

    Route::prefix('account')->group(function (){

        Route::post('store',[\App\Http\Controllers\AdminPanel\Account\AccountController::class,'store']);
        Route::get('list',[\App\Http\Controllers\AdminPanel\Account\AccountController::class,'index']);
        Route::get('{account}/show',[\App\Http\Controllers\AdminPanel\Account\AccountController::class,'show']);
        Route::put('{account}/update',[\App\Http\Controllers\AdminPanel\Account\AccountController::class,'update']);
        Route::post('delete',[\App\Http\Controllers\AdminPanel\Account\AccountController::class,'delete']);
    });

    //Receipt
    Route::prefix('receipt')->group(function (){
        Route::post('store',[\App\Http\Controllers\AdminPanel\Receipt\ReceiptController::class,'store']);
        Route::get('{receipt}/show',[\App\Http\Controllers\AdminPanel\Receipt\ReceiptController::class,'show']);
        Route::get('{receipt}/export',[\App\Http\Controllers\AdminPanel\Receipt\ReceiptController::class,'exportReceipt']);
        Route::get('list',[\App\Http\Controllers\AdminPanel\Receipt\ReceiptController::class,'index']);
        Route::put('{receipt}/update',[\App\Http\Controllers\AdminPanel\Receipt\ReceiptController::class,'update']);
        Route::post('delete',[\App\Http\Controllers\AdminPanel\Receipt\ReceiptController::class,'autoDestroy']);
    });

    //Cheque

    Route::prefix('cheque')->group(function (){

        Route::get('bank/list',[\App\Http\Controllers\AdminPanel\Bank\BankController::class,'index']);
        Route::post('store',[\App\Http\Controllers\AdminPanel\Cheque\ChequeController::class,'store']);
        Route::get('list',[\App\Http\Controllers\AdminPanel\Cheque\ChequeController::class,'index']);
        Route::get('{cheque}/show',[\App\Http\Controllers\AdminPanel\Cheque\ChequeController::class,'show']);
        Route::put('{cheque}/update',[\App\Http\Controllers\AdminPanel\Cheque\ChequeController::class,'update']);
        Route::get('{cheque}/sheets/list',[\App\Http\Controllers\AdminPanel\Cheque\ChequeController::class,'chequeSheetList']);
        Route::post('delete',[\App\Http\Controllers\AdminPanel\Cheque\ChequeController::class,'delete']);

    });


    //Cheque Sheet

    Route::prefix('cheque/sheet')->group(function (){

        Route::get('list',[\App\Http\Controllers\AdminPanel\ChequeSheet\ChequeSheetController::class,'index']);
        Route::get('{cheque_sheet}/show',[\App\Http\Controllers\AdminPanel\ChequeSheet\ChequeSheetController::class,'show']);
        Route::get('{cheque_sheet}/export',[\App\Http\Controllers\AdminPanel\ChequeSheet\ChequeSheetController::class,'printChequeSheet']);
        Route::put('{cheque_sheet}/update',[\App\Http\Controllers\AdminPanel\ChequeSheet\ChequeSheetController::class,'update']);
    });


    //Payment Instruction
    Route::get('payment/instruction/{fiscal_document}/export',[\App\Http\Controllers\AdminPanel\FiscalDocument\FiscalDocumentController::class,'exportPaymentInstruction']);

    //Fiscal Year

    Route::prefix('year/fiscal')->group(function (){

        Route::post('store',[\App\Http\Controllers\AdminPanel\FiscalYear\FiscalYearController::class,'store']);
        Route::get('list',[\App\Http\Controllers\AdminPanel\FiscalYear\FiscalYearController::class,'index']);
        Route::get('{fiscal_year}/show',[\App\Http\Controllers\AdminPanel\FiscalYear\FiscalYearController::class,'show']);
        Route::put('{fiscal_year}/update',[\App\Http\Controllers\AdminPanel\FiscalYear\FiscalYearController::class,'update']);
        Route::post('delete',[\App\Http\Controllers\AdminPanel\FiscalYear\FiscalYearController::class,'delete']);
        Route::post('{fiscal_year}/item/store',[\App\Http\Controllers\AdminPanel\FiscalYearItem\FiscalYearsItemController::class,'store']);
        Route::get('{fiscal_year}/item/list',[\App\Http\Controllers\AdminPanel\FiscalYearItem\FiscalYearsItemController::class,'index']);
        Route::get('item/{fiscal_years_item}/show',[\App\Http\Controllers\AdminPanel\FiscalYearItem\FiscalYearsItemController::class,'show']);
        Route::put('item/{fiscal_years_item}/update',[\App\Http\Controllers\AdminPanel\FiscalYearItem\FiscalYearsItemController::class,'update']);
        Route::post('item/delete',[\App\Http\Controllers\AdminPanel\FiscalYearItem\FiscalYearsItemController::class,'delete']);
        Route::post('status/update',[\App\Http\Controllers\AdminPanel\FiscalYear\FiscalYearController::class,'update_status']);

    });

    //Facility

    Route::prefix('facility')->group(function (){

        Route::post('store',[\App\Http\Controllers\AdminPanel\Facilities\FacilitiesController::class,'store']);
        Route::get('list',[\App\Http\Controllers\AdminPanel\Facilities\FacilitiesController::class,'index']);
        Route::get('{facilities}/show',[\App\Http\Controllers\AdminPanel\Facilities\FacilitiesController::class,'show']);
        Route::put('{facilities}/update',[\App\Http\Controllers\AdminPanel\Facilities\FacilitiesController::class,'update']);
        Route::post('delete',[\App\Http\Controllers\AdminPanel\Facilities\FacilitiesController::class,'delete']);
        Route::post('{facilities}/installment/store',[\App\Http\Controllers\AdminPanel\InstallmentBooklet\InstallmentBookletController::class,'store']);
        Route::get('{facilities}/installments/list',[\App\Http\Controllers\AdminPanel\InstallmentBooklet\InstallmentBookletController::class,'index']);
        Route::get('{facilities}/payment/installments/list',[\App\Http\Controllers\AdminPanel\PaymentInstallment\PaymentInstallmentController::class,'index']);
        Route::get('installment/{installment_booklet}/show',[\App\Http\Controllers\AdminPanel\InstallmentBooklet\InstallmentBookletController::class,'show']);
        Route::put('installment/{installment_booklet}/update',[\App\Http\Controllers\AdminPanel\InstallmentBooklet\InstallmentBookletController::class,'update']);
        Route::post('installment/delete',[\App\Http\Controllers\AdminPanel\InstallmentBooklet\InstallmentBookletController::class,'delete']);
        Route::post('{facilities}/payment/installment/store',[\App\Http\Controllers\AdminPanel\PaymentInstallment\PaymentInstallmentController::class,'store']);
        Route::get('payment/{payment_installment}/show',[\App\Http\Controllers\AdminPanel\PaymentInstallment\PaymentInstallmentController::class,'show']);
        Route::put('payment/{payment_installment}/update',[\App\Http\Controllers\AdminPanel\PaymentInstallment\PaymentInstallmentController::class,'update']);
        Route::post('payment/delete',[\App\Http\Controllers\AdminPanel\PaymentInstallment\PaymentInstallmentController::class,'delete']);

    });

    //FiscalDocument

    Route::prefix('fiscal/document')->group(function (){
        Route::get('installment/check',[\App\Http\Controllers\AdminPanel\FiscalDocument\FiscalDocumentController::class,'check_Installment_Document']);
        Route::get('installment/build',[\App\Http\Controllers\AdminPanel\FiscalDocument\FiscalDocumentController::class,'check_Installment_Document']);
        Route::get('membership/build',[\App\Http\Controllers\AdminPanel\FiscalDocument\FiscalDocumentController::class,'check_Membership_right_Document']);
        Route::post('store',[\App\Http\Controllers\AdminPanel\FiscalDocument\FiscalDocumentController::class,'store']);
        Route::put('{fiscal_document}/update',[\App\Http\Controllers\AdminPanel\FiscalDocument\FiscalDocumentController::class,'update']);
        Route::post('delete',[\App\Http\Controllers\AdminPanel\FiscalDocument\FiscalDocumentController::class,'delete']);
        Route::get('list',[\App\Http\Controllers\AdminPanel\FiscalDocument\FiscalDocumentController::class,'index']);
        Route::get('{fiscal_document}/show',[\App\Http\Controllers\AdminPanel\FiscalDocument\FiscalDocumentController::class,'show']);
        Route::get('check',[\App\Http\Controllers\AdminPanel\FiscalDocument\FiscalDocumentController::class,'check']);
    });

    //Message

    Route::prefix('message')->group(function (){
        Route::post('send',[\App\Http\Controllers\AdminPanel\Message\MessageController::class,'send']);
        Route::get('list',[\App\Http\Controllers\AdminPanel\MessageBox\MessageBoxController::class,'index']);
        Route::get('{message_box}/content/show',[\App\Http\Controllers\AdminPanel\MessageBox\MessageBoxController::class,'show']);
    });

    //Fiscal Transaction
    Route::prefix('fiscal/transaction')->group(function (){
        Route::post('subscriber/{sub_scriber}/status/get',[\App\Http\Controllers\AdminPanel\FiscalTransaction\FiscalTransactionController::class,'statusGet']);
        Route::get('list',[\App\Http\Controllers\AdminPanel\FiscalTransaction\FiscalTransactionController::class,'index']);
        Route::post('subscriber/{sub_scriber}/store',[\App\Http\Controllers\AdminPanel\FiscalTransaction\FiscalTransactionController::class,'store']);
        Route::get('{fiscal_transaction}/show',[\App\Http\Controllers\AdminPanel\FiscalTransaction\FiscalTransactionController::class,'show']);
        Route::put('{fiscal_transaction}/update',[\App\Http\Controllers\AdminPanel\FiscalTransaction\FiscalTransactionController::class,'update']);
        Route::post('delete',[\App\Http\Controllers\AdminPanel\FiscalTransaction\FiscalTransactionController::class,'delete']);
    });


});
