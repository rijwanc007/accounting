<?php

Route::get('/', 'HomeController@welcome')->name('welcome');
Auth::routes();
Route::group(['middleware' => ['preventbackbutton','auth']],function() {
    Route::get('/home', 'HomeController@index')->name('home');


                   /*     Admin Route*/
    Route::resource('/user', 'Admin\UserController');
    Route::get('user-index', 'Admin\UserController@index')->name('user.index');
    Route::get('user-create', 'Admin\UserController@create')->name('user.create');
    Route::get('user-edit-{id}', 'Admin\UserController@edit')->name('user.edit');
    Route::get('user-search', 'Admin\UserController@search')->name('user.search');

    Route::resource('/role','Admin\RoleController');
    Route::get('role-index','Admin\RoleController@index')->name('role.index');
    Route::get('role-create','Admin\RoleController@create')->name('role.create');

                      /*  Management Route*/
    Route::resource('sister_concern','Admin\SisterConcernController');
    Route::get('sister_concern-index','Admin\SisterConcernController@index')->name('sister_concern.index');
    Route::get('sister_concern-create','Admin\SisterConcernController@create')->name('sister_concern.create');
    Route::get('sister-concern-show-{id}','Admin\SisterConcernController@show')->name('sister_concern.show');
    Route::get('sister_concern-search','Admin\SisterConcernController@search')->name('sister_concern.search');


                       /*     Account Route*/

    Route::resource('/received', 'Admin\ReceivedController');
    Route::get('received-index', 'Admin\ReceivedController@index')->name('received.index');
    Route::get('received-create', 'Admin\ReceivedController@create')->name('received.create');
    Route::get('received-date-search', 'Admin\ReceivedController@date_search')->name('received.date_search');
    Route::get('/client_due/{cid}', 'Admin\ReceivedController@client_due');
    Route::get('/client_info/{cid}', 'Admin\ReceivedController@client_info');

    Route::resource('/payment', 'Admin\PaymentController');
    Route::get('payment-index', 'Admin\PaymentController@index')->name('payment.index');
    Route::get('payment-create', 'Admin\PaymentController@create')->name('payment.create');
    Route::get('payment-date-search', 'Admin\PaymentController@date_search')->name('payment.date_search');

    Route::resource('/chart_of_account','Admin\ChartofaccountController');
    Route::get('chart_of_account-index-all-{id}','Admin\ChartofaccountController@index')->name('chart_of_account.index');
    Route::get('chart_of_account-search','Admin\ChartofaccountController@search')->name('chart_of_account.search');
    Route::get('chart_of_account-create-all','Admin\ChartofaccountController@create')->name('chart_of_account.create');
    Route::get('/head_names/{id}','Admin\ChartofaccountController@head_names');
    Route::get('/head_id/','Admin\ChartofaccountController@head_id');
    Route::get('/sub_head_id/','Admin\ChartofaccountController@sub_head_id');
    Route::get('/child_head_id/','Admin\ChartofaccountController@child_head_id');
    Route::get('/category_heads/{id}/{sid}','Admin\ChartofaccountController@category_heads');
    Route::get('/sub_heads/{id}/{sid}','Admin\ChartofaccountController@sub_heads');
    Route::get('/heads_category/{id}/{sid}','Admin\ChartofaccountController@heads_category');
    Route::get('/sub_heads_category/{id}/{sid}','Admin\ChartofaccountController@sub_heads_category');
    Route::get('/charts/{id}','Admin\ChartofaccountController@ledger_charts');

    Route::resource('/contra_journal', 'Admin\ContraJournalController');
    Route::get('contra_journal-index', 'Admin\ContraJournalController@index')->name('contra_journal.index');
    Route::get('contra_journal-create', 'Admin\ContraJournalController@create')->name('contra_journal.create');
    Route::get('contra_journal-show-{id}', 'Admin\ContraJournalController@show')->name('contra_journal.show');
    Route::get('contra_journal-date-search', 'Admin\ContraJournalController@date_search')->name('contra_journal.date_search');
    Route::get('/banks/{id}', 'Admin\ContraJournalController@banks');

    Route::resource('/journal', 'Admin\JournalController');
    Route::get('journal_index','Admin\JournalController@index')->name('journal.index');
    Route::get('journal_create','Admin\JournalController@create')->name('journal.create');
    Route::get('journal-show-{id}', 'Admin\JournalController@show')->name('journal.show');
    Route::get('journal-date_search','Admin\JournalController@date_search')->name('journal.date_search');
    Route::get('journal_accept-{id}','Admin\JournalController@accept')->name('journal.accept');

    Route::resource('/debit_voucher', 'Admin\DebitVoucherController');
    Route::get('debit_voucher-index','Admin\DebitVoucherController@index')->name('debit_voucher.index');
    Route::get('debit_voucher-create','Admin\DebitVoucherController@create')->name('debit_voucher.create');
    Route::get('debit_voucher-date-search', 'Admin\DebitVoucherController@date_search')->name('debit_voucher.date_search');
    Route::get('debit_voucher_accept-{id}','Admin\DebitVoucherController@accept')->name('debit_voucher.accept');

    Route::resource('/credit_voucher', 'Admin\CreditVoucherController');
    Route::get('credit_voucher-index','Admin\CreditVoucherController@index')->name('credit_voucher.index');
    Route::get('credit_voucher-create','Admin\CreditVoucherController@create')->name('credit_voucher.create');
    Route::get('credit_voucher-date-search', 'Admin\CreditVoucherController@date_search')->name('credit_voucher.date_search');
    Route::get('credit_voucher_accept-{id}','Admin\CreditVoucherController@accept')->name('credit_voucher.accept');


                           /*   Bank Route*/


    Route::resource('/bank', 'Admin\BankController');
    Route::get('bank-index', 'Admin\BankController@index')->name('bank.index');
    Route::get('bank-search', 'Admin\BankController@search')->name('bank.search');
    Route::get('bank-create', 'Admin\BankController@create')->name('bank.create');
    Route::get('bank-show-{id}', 'Admin\BankController@show')->name('bank.show');
    Route::get('bank-balance-search', 'Admin\BankController@date_search')->name('bank.balance_search');
    Route::get('bank-status', 'Admin\BankController@bank_status')->name('bank.status');
    Route::get('cash-status', 'Admin\BankController@cash_status')->name('cash.status');
    Route::get('bank-cash_balance-search', 'Admin\BankController@cash_date_search')->name('bank.cash_balance_search');
    Route::get('bank-bank_status-search', 'Admin\BankController@bank_status_search')->name('bank.bank_status_search');

    Route::get('cheque-index', 'Admin\BankController@cheque_index')->name('cheque.index');
    Route::get('cheque-date-search', 'Admin\BankController@cheque_date_search')->name('cheque.date_search');
    Route::get('cheque-create', 'Admin\BankController@cheque_create')->name('cheque.create');
    Route::post('cheque-store', 'Admin\BankController@cheque_store')->name('cheque.store');
    Route::get('cheque-edit-{id}', 'Admin\BankController@cheque_edit')->name('cheque.edit');
    Route::post('cheque-update-{id}', 'Admin\BankController@cheque_update')->name('cheque.update');
    Route::get('cheque-show-{id}', 'Admin\BankController@cheque_show')->name('cheque.show');
    Route::post('cheque-delete-{id}', 'Admin\BankController@cheque_destroy')->name('cheque.destroy');

                                /*  Report */


    Route::get('report-balance', 'Admin\ReportController@balance')->name('report.balance');
    Route::get('report-balance-date_search', 'Admin\ReportController@balance_date_search')->name('report.balance_date_search');

    Route::get('report-income_statement', 'Admin\ReportController@income_statement')->name('report.income_statement');
    Route::get('report-income_statement-date_search', 'Admin\ReportController@income_statement_date_search')->name('report.income_statement_date_search');

    Route::get('report-equity_statement', 'Admin\ReportController@equity_statement')->name('report.equity_statement');
    Route::get('report-equity_statement-date_search', 'Admin\ReportController@equity_statement_date_search')->name('report.equity_statement_date_search');

    Route::get('report-ledger', 'Admin\ReportController@ledger')->name('report.ledger');
    Route::get('report-ledger-search', 'Admin\ReportController@ledger_search')->name('report.ledger_search');

    Route::get('report-cash_flow_statement', 'Admin\ReportController@cash_flow_statement')->name('report.cash_flow_statement');
    Route::get('report-cash_flow_statement-search', 'Admin\ReportController@cash_flow_statement_search')->name('report.cash_flow_statement_search');

});
