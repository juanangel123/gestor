<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

// Authenticated pages
//Route::auth();

// ALL IDS MUST BE NUMBERS
Route::pattern('id', '\d+');

// Clients
Route::get('/', 'ClientsController@index');
Route::get('/clients', 'ClientsController@index');
Route::get('/clients/create', 'ClientsController@create');
Route::get('/clients/edit/{id}', 'ClientsController@edit');
Route::post('/clients/save', 'ClientsController@save');
Route::post('/clients/delete/{id}', 'ClientsController@delete');


// Municipalities
Route::get('/provinces/{id}/municipalities', 'MunicipalitiesController@getByProvince');


// Contracts
Route::get('/contracts', 'ContractsController@index');
Route::get('/contracts/{id}', 'ContractsController@getById');
Route::get('/contracts/create', 'ContractsController@create');
Route::get('/contracts/create/{id}', 'ContractsController@create');
Route::get('/contracts/edit/{id}', 'ContractsController@edit');
Route::post('/contracts/save', 'ContractsController@save');
Route::post('/contracts/delete/{id}', 'ContractsController@delete');


// Supplier companies
Route::get('/supplier-companies', 'SupplierCompaniesController@index');
Route::get('/supplier-companies/create', 'SupplierCompaniesController@create');
Route::get('/supplier-companies/edit/{id}', 'SupplierCompaniesController@edit');
Route::post('/supplier-companies/save', 'SupplierCompaniesController@save');
Route::post('/supplier-companies/delete/{id}', 'SupplierCompaniesController@delete');


// Alerts
Route::get('/alerts', 'AlertsController@index');
Route::get('/alerts/not-sended', 'AlertsController@getNotSended');


// Documents
Route::get('/documents/{id}', 'DocumentsController@getById');
Route::get('/documents/contract/{id}', 'DocumentsController@getByContractId');
Route::post('/documents/contract/save/{id}', 'DocumentsController@saveByContractId');
Route::get('/documents/client/{id}', 'DocumentsController@getByClientId');
Route::post('/documents/client/save/{id}', 'DocumentsController@saveByClientId');
Route::get('/documents/delete/{id}', 'DocumentsController@delete');