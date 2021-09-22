<?php


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

Auth::routes();


Route::group(['middleware' => ['MSP']], function () {

	Route::get('/authentication/{id}','TestController@authentication');

	Route::get('/sorry_this_page_is_under_maintenance','DASHBOARDController@maintenance');

	Route::get('/home', 'HomeController@index')->name('home');

	// Route::get('custom-login', 'LOGINController@showLoginForm')->name('custom.login');
	// Route::post('custom-attempt', 'LOGINController@attempt')->name('custom.attempt');

	Route::get('/dashboardqoe','DASHBOARDController@indexqoe')->middleware('HRDash');
	Route::get('/testEmail', 'TestController@send_mail');

	//salescontroller
	Route::post('/store', 'SalesController@store');
	Route::post('/update_lead_register', 'SalesController@update_lead_register');
	Route::post('/salesAddLead', 'SalesController@store');
	// Route::get('/sales','SalesController@index');
	Route::get('/detail_sales/{lead_id}','SalesController@detail_sales');
	Route::post('/update_tp/{lead_id}', 'SalesController@update_tp');

	Route::post('/update_result', 'SalesController@update_result');
	Route::post('/update_next_status', 'SalesController@update_next_status');

	Route::get('/','DASHBOARDController@index')->middleware('HRDash');
	/*Route::get('/','DASHBOARDController@index')->middleware('Maintenance');*/

	Route::get('/project','SalesController@index')->middleware('ManagerStaffMiddleware');
	/*Route::get('/project','SalesController@index')->middleware('Maintenance');*/
	Route::get('/year_initial', 'SalesController@year_initial');
	Route::get('/year_open', 'SalesController@year_open');
	Route::get('/year_sd', 'SalesController@year_sd');
	Route::get('/year_tp', 'SalesController@year_tp');
	Route::get('/year_win', 'SalesController@year_win');
	Route::get('/year_lose', 'SalesController@year_lose');

	Route::get('/detail_project/{lead_id}','SalesController@detail_sales');
	Route::get('/item','WarehouseController@index');

	Route::get('/customer', 'SalesController@customer_index')->middleware('ManagerStaffMiddleware');
	Route::post('customer/store', 'SalesController@customer_store');
	Route::get('/customer/getcus','SalesController@getdatacustomer');
	Route::post('update_customer', 'SalesController@update_customer');
	Route::post('/add_changelog_progress','SalesController@add_changelog_progress');

	Route::get('/show/{lead_id}','SalesController@show');

	Route::get('/warehouse', 'WarehouseController@index');
	Route::post('/warehouse/store', 'WarehouseController@store');
	Route::post('/warehouse/update_warehouse', 'WarehouseController@update_warehouse');
	Route::get('/warehouse/delete_item/{item_code}', 'WarehouseController@destroy');

	Route::get('/getChart', 'DASHBOARDController@getChart');
	Route::get('/getChartInv', 'DASHBOARDController@getChartInv');
	Route::get('/getPieChart', 'DASHBOARDController@getPieChart');
	Route::get('/getPieChartAFH', 'DASHBOARDController@getPieChartAFH');
	Route::get('/getAreaChart', 'DASHBOARDController@getAreaChart');
	Route::get('/getAreaChart2019', 'DASHBOARDController@getAreaChart2019');
	Route::get('/getAreaChartAdmin', 'DASHBOARDController@getAreaChartAdmin');
	Route::get('/getAreaChartAdmin2018', 'DASHBOARDController@getAreaChartAdmin2018');
	Route::get('/getDoughnutChart', 'DASHBOARDController@getDoughnutChart');
	Route::get('/getDoughnutChartAFH', 'DASHBOARDController@getDoughnutChartAFH');

	Route::get('/getChartAdmin', 'DASHBOARDController@getChartAdmin');

	Route::get('/getCustomer', 'ReportController@getCustomer');
	Route::get('/getCustomerbyDate', 'ReportController@getCustomerbyDate');
	Route::get('/getCustomerbyDate2', 'ReportController@getCustomerbyDate2');

	/*Route::get('/presales','SalesController@index')->middleware('TechnicalPresalesMiddleware', 'ManagerStaffMiddleware')*/;
	Route::post('/update_sd/{lead_id}', 'SalesController@update_sd');
	Route::post('/assign_to_presales','SalesController@assign_to_presales');
	Route::post('/reassign_to_presales','SalesController@reassign_to_presales');

	Route::get('/pr', 'PrController@index');
	Route::get('/PoAdmin', 'PrController@PoAdmin');
	Route::post('/store_pr', 'PrController@store_pr');
	Route::post('/update_pr','PrController@update_pr');
	Route::get('/delete_pr/{id_pr}','PrController@destroy_pr');
	Route::get('prAdmin','PrController@PrAdmin');
	Route::get('downloadExcelPrAdmin','PrController@downloadExcelPr');


	Route::get('/po', 'PONumberController@index');
	Route::post('/store_po', 'PONumberController@store');
	Route::post('/update_po','PONumberController@update');
	Route::get('/delete_po/{id_po}','PONumberController@destroy');

	Route::post('/add_contribute','SalesController@add_contribute');
	Route::post('/add_contribute_pmo','PMOController@add_contribute');
	Route::post('/add_contribute_engineer','EngineerController@add_contribute');

	Route::post('/raise_to_tender', 'SalesController@raise_to_tender');
	/*Route::get('/detail_presales/{lead_id}','PRESALESController@detail_presales');*/
	/*
	Route::get('/edit/{id_sd}', 'PRESALESController@edit');
	Route::post('/update/{id_sd}', 'PRESALESController@update');*/

	Route::get('/view_lead', 'ReportController@view_lead');
	Route::get('/view_open', 'ReportController@view_open');
	Route::get('/view_win', 'ReportController@view_win');
	Route::get('/view_lose', 'ReportController@view_lose');

	Route::get('/report', 'ReportController@report');
	Route::get('/report_range', 'ReportController@report_range');
	Route::get('/report_sales', 'ReportController@report_sales');

	Route::get('/downloadPdfreport', 'ReportController@downloadPdfreport');
	Route::get('/downloadPdflead', 'ReportController@downloadPdflead');
	Route::get('/downloadPdfopen', 'ReportController@downloadPdfopen');
	Route::get('/downloadPdfwin', 'ReportController@downloadPdfwin');
	Route::get('/downloadPdflose', 'ReportController@downloadPdflose');

	Route::get('/downloadReportPDF', 'ReportController@downloadReportPDF');

	Route::get('/exportExcelLead', 'ReportController@exportExcelLead');
	Route::get('/exportExcelOpen', 'ReportController@exportExcelOpen');
	Route::get('/exportExcelWin', 'ReportController@exportExcelWin');
	Route::get('/exportExcelLose', 'ReportController@exportExcelLose');

	Route::get('/getfiltersd', 'ReportController@getfiltersd');
	Route::get('/getfiltertp', 'ReportController@getfiltertp');
	Route::get('/getfilterwin', 'ReportController@getfilterwin');
	Route::get('/getfilterlose', 'ReportController@getfilterlose');

	/*Route::get('/presales_manager','PRESALES_MANAGERController@index');
	Route::post('/presales/store', 'PRESALES_MANAGERController@store');*/

	Route::get('/po', 'PONumberController@index');
	Route::post('/store_po', 'PONumberController@store');
	Route::post('/store_copy_po', 'POAssetMSPController@store_copy_po');
	Route::post('/update_po','PONumberController@update');
	Route::get('/delete_po/{id_po}','PONumberController@destroy');

	Route::get('/client', 'ReportController@getDropdown');
	Route::get('/assign_quote', 'SalesController@getDropdown');
	Route::get('/data_lead', 'SalesController@getDatalead');
	Route::get('/getIdTask', 'HRGAController@getIdTask');
	Route::get('/sho','SHOController@index');
	Route::get('/detail_sho/{id_sho}','SHOController@detail_sho');
	Route::post('/update_sho','SHOController@update_sho');
	Route::post('/update_sho_transac','SHOController@update_sho_transac');

	Route::get('/dropdownTech', 'HRController@getDropdownTech');
	Route::get('/hu_rec','HRController@index')->middleware('HRMiddleware');
	Route::post('/hu_rec/store', 'HRController@store')->middleware('HRMiddleware');
	Route::post('/hu_rec/update', 'HRController@update_humanresource')->middleware('HRMiddleware');
	Route::get('delete_hr/{nik}', 'HRController@destroy_hr')->middleware('HRMiddleware');
	Route::get('/profile_user','HRController@user_profile');
	Route::post('/update_profile','HRController@update_profile');
	Route::post('/profile/delete_pict','HRController@delete_pict');

	Route::get('/show_cuti', 'HRGAController@show_cuti');
	Route::post('/store_cuti','HRGAController@store_cuti');
	Route::post('/update_cuti','HRGAController@update_cuti');
	Route::post('/approve_cuti','HRGAController@approve_cuti');
	Route::post('/decline_cuti','HRGAController@decline_cuti');
	Route::get('/getCutiUsers','HRGAController@getCutiUsers');
	Route::get('/detilcuti','HRGAController@detil_cuti');
	Route::get('/getCutiAuth','HRGAController@getCutiAuth');
	Route::get('/delete_cuti/{id_cuti}', 'HRGAController@delete_cuti');
	Route::get('/follow_up/{id_cuti}', 'HRGAController@follow_up');
	Route::post('/update_cuti_done','HRGAController@update_done');
	Route::get('/get_list_cuti', 'HRGAController@get_list_cuti');

	Route::post('/store_sho','SHOController@store');
	Route::post('/store_sho_transac','SHOController@store_sho_transac');

	Route::get('/quote', 'QuoteController@index')->middleware('ManagerStaffMiddleware');

	Route::get('/add', 'QuoteController@create');
	Route::post('/quote/store', 'QuoteController@store');
	Route::post('/quote/update', 'QuoteController@update');
	Route::get('/report_quote', 'QuoteController@report_quote');
	Route::get('delete', 'QuoteController@destroy_quote');
	Route::post('/store_quotebackdate', 'QuoteController@store_backdate');
	Route::get('/downloadExcelQuote', 'QuoteController@donwloadExcelQuote');

	Route::get('/delete_detail_sho/{id_transaction}', 'SHOController@destroy_detail');

	Route::get('/delete_customer/{id_customer}', 'SalesController@destroy_customer');

	Route::get('/profile','HRController@edit_password');
	Route::post('/changePassword','HRController@changePassword');
	Route::get('/salesproject', 'SalesController@sales_project_index');
	Route::get('/salesproject/saveRequestID','SalesController@saveRequestID');
	Route::get('/salesproject/getQuoteDetail','SalesController@getQuoteDetail');
	Route::get('/store_sp', 'SalesController@store_sales_project');
	Route::post('/add_idpro_manual', 'SalesController@add_idpro_manual');
	Route::post('/update_sp', 'SalesController@update_sp');
	Route::get('/delete_project', 'SalesController@destroy_sp');
	Route::post('import_id_pro', 'SalesController@import_id_pro');
	Route::post('/add_id_pro','WarehouseProjectController@add_id_project');
	Route::get('/getleadpid','SalesController@getleadpid');
	Route::post('/update_result_idpro', 'SalesController@update_result_request_id');
	Route::get('/getIdProject', 'SalesController@getidproject');
	Route::post('/store_po', 'SalesController@store_po');


	Route::post('/engineer_assign','EngineerController@store');

	Route::post('/update_cek/{id_transaction}','SHOController@update_detail_sho');

	Route::get('/getMountNow',function(){

		echo date("n");

	});

	Route::post('/assign_to_pmo','PMOController@store');
	Route::post('/reassign_to_pmo','PMOController@update_pmo');
	Route::get('/delete_contribute_pmo/{id_pmo}', 'PMOController@destroy');
	Route::get('/delete_contribute_engineer/{id_engineer}','EngineerController@delete_contribute_engineer');
	Route::get('/delete_contribute_sd','SalesController@delete_contribute_sd');

	Route::get('/delete_sales/{lead_id}', 'SalesController@destroy');

	Route::post('/reassign_to_engineer','EngineerController@reassign_engineer');

	Route::post('/pmo_progress','PMOController@progress_store');
	Route::post('/engineer_progress','EngineerController@progress_store');
	Route::post('/update_status_eng','EngineerController@update_status_engineer');

	// Route::get('/hrga','HRGAController@index');
	Route::get('/add_barang', 'HRGAController@create');
	Route::post('/store_barang', 'HRGAController@store');
	Route::get('/delete/{id}', 'HRGAController@destroy');
	Route::get('/edit/{id}', 'HRGAController@edit');
	Route::post('/barang/update', 'HRGAController@update');
	Route::get('/timesheet','EngineerController@timesheet');
	Route::post('/store_task','EngineerController@store_task');
	Route::post('/done_task','EngineerController@done_task');

	Route::get('/downloadPdfPMO', 'PMOController@downloadPDF');

	Route::get('/export', 'SalesController@export');
	Route::get('/export_msp', 'SalesController@export_msp');
	Route::get('/exportExcel', 'PMOController@exportExcel');

	// Config Management
	Route::get('/config_management','CMController@index');
	Route::post('/store_cm', 'CMController@store');
	Route::get('/delete_cm/{no}', 'CMController@destroy');
	Route::post('/update_cm', 'CMController@update');

	Route::get('/downloadPdfCM', 'CMController@downloadPDF');
	Route::get('/exportExcelCM', 'CMController@exportExcel');

	//PR asset management
	Route::get('/pr_asset','PAMController@index');
	Route::post('/store_pr_asset', 'PAMController@tambah');
	Route::post('/store_produk', 'PAMController@store_produk');
	Route::get('/delete_pr_asset', 'PAMController@destroy');
	Route::post('/edit_pr_asset', 'PAMController@update');
	Route::post('/assign_to_hrd_pr_asset','PAMController@assign_to_hrd');
	Route::post('/assign_to_fnc_pr_asset','PAMController@assign_to_fnc');
	Route::post('/assign_to_adm_pr_asset','PAMController@assign_to_adm');
	Route::post('/tambah_return_hr_pr_asset', 'PAMController@tambah_return_hr');
	Route::post('/tambah_return_fnc_pr_asset', 'PAMController@tambah_return_fnc');

	Route::get('/detail_pam/{id_pam}', 'PAMController@detail_pam');

	Route::get('/downloadPdfPR', 'PAMController@downloadPDF');
	Route::get('/downloadPdfPR2/{id_pam}', 'PAMController@downloadPDF2');
	Route::get('/exportExcelPR', 'PAMController@exportExcel');

	//Incident Management
	Route::get('/incident_management', 'INCIDENTController@index');
	Route::get('/add_incident', 'INCIDENTController@create');
	Route::post('/store_incident', 'INCIDENTController@store');
	Route::get('/delete_incident/{no}', 'INCIDENTController@destroy');
	Route::get('/edit_incident/{no}', 'INCIDENTController@edit');
	Route::post('/update_incident', 'INCIDENTController@update');
	Route::get('/read/{no}', 'INCIDENTController@show');
	Route::get('/downloadPdfIM', 'INCIDENTController@downloadPDF');
	Route::get('/exportExcelIM', 'INCIDENTController@exportExcelIM');

	//Engineer Management
	Route::get('/esm', 'ESMController@index');
	Route::post('/store_esm', 'ESMController@store');
	Route::get('/delete_esm/{id}', 'ESMController@destroy');
	Route::post('/edit_esm', 'ESMController@edit');
	Route::get('/downloadPdfESM', 'ESMController@downloadpdf');
	Route::get('/downloadExcelESM', 'ESMController@downloadExcel');
	Route::post('/assign_to_hrd', 'ESMController@assign_to_hrd');
	Route::post('/assign_to_fnc', 'ESMController@assign_to_fnc');
	Route::post('/assign_to_adm', 'ESMController@assign_to_adm');
	Route::get('/detail_esm/{no}', 'ESMController@detail_esm');
	Route::post('/tambah_return_hr', 'ESMController@tambah_return_hr');
	Route::post('/tambah_return_fnc', 'ESMController@tambah_return_fnc');
	Route::get('/claim_pending', 'ESMController@claim_pending');
	Route::get('/claim_transfer', 'ESMController@claim_transfer');
	Route::get('/claim_admin', 'ESMController@claim_admin');

	Route::get('/downloadExcelPO', 'PONumberController@downloadExcelPO');
	Route::get('/downloadExcelPr', 'PrController@downloadExcelPr');

	Route::get('/letter', 'LetterController@index');
	Route::post('/store_letter', 'LetterController@store');
	Route::post('/update_letter', 'LetterController@edit');
	Route::get('/delete_letter/{id}', 'LetterController@destroy');
	Route::get('/downloadExcelLetter', 'LetterController@downloadExcel');
	Route::post('/store_letterbackdate', 'LetterController@store_backdate');

	Route::get('/do', 'DONumberController@index');
	Route::post('/store_do', 'DONumberController@store');
	Route::post('/update_do', 'DONumberController@update');

	Route::get('/partnership', 'PartnershipController@index');
	Route::post('/store_partnership', 'PartnershipController@store');
	Route::post('/update_partnership', 'PartnershipController@update');
	Route::get('/downloadPdfpartnership', 'PartnershipController@downloadpdf');
	Route::get('/downloadExcelPartnership','PartnershipController@downloadExcel');
	Route::get('/delete_partnership/{id}', 'PartnershipController@destroy');

	Route::get('/admin_hr', 'HRNumberController@index');
	Route::post('/store_admin_hr', 'HRNumberController@store');
	Route::post('/update_admin_hr', 'HRNumberController@update');
	Route::get('/delete_admin_hr', 'HRNumberController@destroy');
	Route::get('/downloadExcelAdminHR', 'HRNumberController@downloadExcelAdminHR');

	//Inventory
	Route::post('/inventory/store', 'WarehouseController@inventory_store');
	Route::post('/inventory/update', 'WarehouseController@inventory_update');
	Route::post('/inventory/store_detail_produk', 'WarehouseController@inventory_detail_produk');
	Route::get('/inventory', 'WarehouseController@inventory_index');
	Route::post('/warehouse/inventory_update', 'WarehouseController@inventory_update');
	Route::get('/detail_inventory/{id_product}','WarehouseController@Detail_inventory');
	Route::post('/update_serial_number','WarehouseController@update_serial_number');
	Route::get('/warehouse/destroy_produk/{id_barang}', 'WarehouseController@destroy_produk');
	Route::get('/delete_id_detail','WarehouseController@destroy_detail_produk');
	Route::get('/dropdownPO', 'WarehouseController@getDropdownPO');
	Route::get('/dropdownPoSIP', 'WarehouseController@getDropdownPoSIP');
	Route::get('/dropdownSubmitPO', 'WarehouseController@getDropdownSubmitPO');
	Route::get('/dropdownSubmitPoSIP', 'WarehouseController@getDropdownSubmitPoSIP');
	Route::get('/getbtnSN', 'WarehouseController@getbtnSN');
	Route::post('/katalog/store', 'WarehouseController@store_katalog_inventory');

	//Project
	Route::get('/inventory/project', 'WarehouseProjectController@index');
	Route::get('/add/project_delivery', 'WarehouseProjectController@add_project_delivery');
	Route::get('/add/do_sip', 'WarehouseProjectController@add_project_sip');
	Route::post('/inventory/store_project_inventory', 'WarehouseProjectController@store_project_inventory');
	Route::get('/dropdownProject', 'WarehouseProjectController@getDropdown');
	Route::get('/dropdownDetailProject', 'WarehouseProjectController@getDetailProduk');
	Route::post('/inventory/project/store', 'WarehouseProjectController@project_store');
	Route::post('/return_do_product_msp', 'WarehouseProjectController@return_do_product_msp');
	Route::post('/edit_qty_do', 'WarehouseProjectController@edit_qty_do');
	Route::get('/detail_project_inventory/{id_transaction}','WarehouseProjectController@Detail_project');
	Route::get('/getDropdownSubmit','WarehouseProjectController@getDropdownSubmit');
	Route::get('/return_produk_delivery','WarehouseProjectController@return_produk_delivery');
	Route::get('/update_project_delivery/{id_transaction}','WarehouseProjectController@update_view_project_delivery');
	Route::post('/update_delivery', 'WarehouseProjectController@update_project_do');
	// Route::get('/delete_project/{id_detail_do_msp}', 'WarehouseProjectController@destroy');
	Route::post('/delete_produk', 'WarehouseProjectController@delete_produk');
	Route::get('/delete_produk', 'WarehouseProjectController@delete_produk');
	Route::post('/revisi_stok', 'WarehouseProjectController@revisi_stok');
	Route::get('/dropdownPO2', 'WarehouseProjectController@getDropdownPO');
	Route::get('/filterTableWarehouse','WarehouseProjectController@filterTableWarehouse');
	Route::get('/inventory/getDataDo', 'WarehouseProjectController@getDataDo');

	//category+type
	Route::get('/category', 'WarehouseController@category_index');
	Route::post('/store_category', 'WarehouseController@store_category');
	Route::post('/store_type', 'WarehouseController@store_type');
	Route::post('/update_category', 'WarehouseController@update_category');
	Route::post('/update_type', 'WarehouseController@update_tipe');

	Route::get('/asset', 'WarehouseAssetController@index');
	Route::post('/store_asset_warehouse', 'WarehouseAssetController@store');
	Route::post('/update_asset_warehouse', 'WarehouseAssetController@edit');
	Route::get('/delete_asset_warehouse/{id_barang}', 'WarehouseAssetController@destroy');
	Route::post('/update_peminjaman_asset', 'WarehouseAssetController@peminjaman');
	Route::post('/accept_pinjam_warehouse', 'WarehouseAssetController@accept_pinjam');
	Route::post('/reject_pinjam_warehouse', 'WarehouseAssetController@reject');
	Route::post('/ambil_pinjam_warehouse', 'WarehouseAssetController@ambil');
	Route::post('/kembali_pinjam_warehouse', 'WarehouseAssetController@kembali');
	Route::get('/detail_asset/{id_barang}','WarehouseAssetController@detail_asset');

	//MSP inventory gudang
	Route::get('/inventory/msp','WarehouseController@inventory_msp');
	Route::post('/inventory/store/msp','WarehouseController@inventory_store_msp');
	Route::get('/detail_inventory_msp/{id_barang}','WarehouseController@Detail_inventory_msp');
	Route::post('/inventory/detail/store/msp','WarehouseController@inventory_detail_store_msp');
	Route::post('/inventory/msp/update','WarehouseController@inventory_msp_update');
	Route::post('/store/msp/serial_number','WarehouseController@update_serial_number_msp');
	Route::get('/inventoryWarehouse','WarehouseController@view_inventory');
	Route::get('/do-sup/index', 'WarehouseController@do_sup_index');
	Route::get('/add_gudang', 'WarehouseController@add_do_sup');
	Route::post('/store_do_sup', 'WarehouseController@store_do_sup_msp');
	Route::get('/detail/do_sup/{id_po_asset}','WarehouseController@detail_do_sup');

	//MSP DO
	Route::get('/inventory/do/msp','WarehouseProjectController@inventory_index_msp');
	Route::get('/dropdownQty','WarehouseProjectController@getQtyMSP');
	Route::get('/dropdownidpro','WarehouseProjectController@dropdownidpro');
	Route::post('/inventory/store/do/msp','WarehouseProjectController@store_delivery_msp');
	Route::post('/store/product/do/msp','WarehouseProjectController@store_product_do_msp');
	Route::get('/detail/do/msp/{id_transaction}','WarehouseProjectController@Detail_do_msp');
	Route::post('/publish-status','WarehouseProjectController@publish_status');
	Route::post('/store_return_delivery','WarehouseProjectController@return_product_delivery');
	Route::get('/copy/do/msp/{id_transaction}','WarehouseProjectController@copy_do_msp');
	Route::post('/store_copy_do','WarehouseProjectController@store_copy_do');

	Route::get('/doWarehouse','WarehouseProjectController@view_do');
	Route::get('/downloadExcelDO/{id_transaction}','WarehouseProjectController@downloadExcel');

	//DO number
	Route::get('/do_number_msp','DONumberController@index_msp');
	Route::get('/downloadPdfDO/{id_transaction}', 'WarehouseProjectController@downloadPdfDO');

	Route::post('/tambah_meter_do', 'WarehouseProjectController@tambah_meter_do');	

	Route::get('/po_asset', 'POAssetController@index');
	Route::get('/downloadPdfPO/{id_po_asset}', 'POAssetController@downloadPDF2');
	Route::post('/update_term_po', 'POAssetController@update');

	//Asset MSP
	Route::get('/asset_msp', 'WarehouseAssetController@index_msp');
	Route::post('/store_peminjaman_asset_msp', 'WarehouseAssetController@pinjam_msp');
	Route::get('/detail_asset_msp/{id_barang}','WarehouseAssetController@detail_asset_msp');
	Route::post('/accept_pinjam_warehouse_msp', 'WarehouseAssetController@accept_pinjam_msp');
	Route::post('/reject_pinjam_warehouse_msp', 'WarehouseAssetController@reject_msp');
	Route::post('/diambil_pinjam_warehouse_msp', 'WarehouseAssetController@diambil_msp');
	Route::post('/kembali_pinjam_warehouse_msp', 'WarehouseAssetController@kembali_msp');
	Route::post('/confirm_kembali_pinjam_warehouse_msp', 'WarehouseAssetController@confirm_kembali_msp');

	Route::get('/assetWarehouse', 'WarehouseAssetController@view_asset');

	//PO MSP
	Route::get('/po_msp', 'PONumberMSPController@index');
	Route::post('/store_po_msp', 'PONumberMSPController@store');
	Route::post('/update_po_msp','PONumberMSPController@update');
	Route::get('/delete_po_msp/{id_po}','PONumberMSPController@destroy');
	Route::get('/downloadExcelPOMSP', 'PONumberMSPController@downloadExcelPO');
	Route::get('/po_asset_msp', 'POAssetMSPController@index');
	Route::post('/update_term_po_msp', 'POAssetMSPController@update');
	Route::post('/update_invoice_po_msp', 'POAssetMSPController@update_invoice');
	Route::get('/downloadPdfPO2/{id_po_asset}', 'POAssetMSPController@downloadPDF2');
	Route::get('/dropdownPR', 'POAssetMSPController@getdropdownPR');
	Route::get('/dropdownSubmitPR', 'POAssetMSPController@getdropdownSubmitPR');
	Route::get('/downloadEXCEL/{id_po_asset}', 'POAssetMSPController@downloadEXCEL');
	Route::get('/add_po_asset_msp', 'POAssetMSPController@add_po');
	Route::get('/inventory_report', 'WarehouseReportController@index_inventory_report');
	Route::get('/getdatapr', 'POAssetMSPController@getdatapr');
	Route::get("/add_produk_po/{id_po_asset}", "POAssetMSPController@add_produk");
	Route::post('/store_po_asset_msp', 'POAssetMSPController@store_po');
	Route::post('/store_produk_po_msp', 'POAssetMSPController@store_produk');
	Route::get('/detail_po/{id_po_asset}', 'POAssetMSPController@detail_po');
	Route::post('/publish_status', 'POAssetMSPController@publish_status');
	Route::get('/delete_produk_po_msp','POAssetMSPController@delete_produk');
	Route::post('/update_produk_po_msp','POAssetMSPController@update_produk');
	Route::get('/copy_po/{id_po_asset}','POAssetMSPController@copy_po');

	Route::get('/month_report', 'WarehouseReportController@month_report');
	Route::post('/month_report/fetch_data', 'WarehouseReportController@fetch_data')->name('month_report.fetch_data');
	Route::get('/idpro_report_bydate', 'WarehouseAssetController@idpro_report');
	Route::get('/idpro_report', 'WarehouseReportController@idpro_report');
	Route::get('/getDataMonth', 'WarehouseReportController@getDataMonth');
	Route::get('/getDataMonthExcel', 'WarehouseReportController@getDataMonthExcel');


	//PR MSP
	Route::get('/pr_msp', 'PrMSPController@index');
	Route::post('/store_pr_msp', 'PrMSPController@store_pr');
	Route::post('/update_pr_msp','PrMSPController@update_pr');
	Route::get('/delete_pr_msp/{id_pr}','PrMSPController@destroy_pr');
	Route::post('/import_pr_msp', 'PrMSPController@import_pr_msp');
	Route::get('/add_pr_msp', 'PrMSPController@add_pr');
	Route::post('/add_id_pro_pr', 'PrMSPController@add_id_pro');

	//PR Asset MSP
	Route::get('/pr_asset_msp','PAMMSPController@index');
	Route::post('/store_pr_asset_msp', 'PAMMSPController@tambah');
	Route::post('/store_produk_msp', 'PAMMSPController@store_produk');
	Route::get('/delete_produk_msp','PAMMSPController@delete_produk');
	Route::post('/update_produk_msp','PAMMSPController@update_produk');
	Route::get('/delete_pr_asset_msp/{id}', 'PAMMSPController@destroy');
	Route::post('/edit_pr_asset_msp', 'PAMMSPController@update');
	Route::get('/detail_pam_msp/{id_pam}', 'PAMMSPController@detail_pam');
	Route::post('/assign_to_fnc_pr_asset_msp','PAMMSPController@assign_to_fnc');
	Route::post('/assign_to_adm_pr_asset_msp','PAMMSPController@assign_to_adm');
	Route::get('/downloadPdfPRMSP/{id_pam}', 'PAMMSPController@downloadPDF2');
	Route::post('/tambah_return_fnc_pr_asset_msp', 'PAMMSPController@tambah_return_fnc');
	Route::get('/getIDbarang', 'PAMMSPController@getDropdownId');
	Route::get('/add_pam','PAMMSPController@add_pam');
	Route::get('/add_produk_pam/{id_pam}', 'PAMMSPController@add_produk_pam');
	Route::get('/view_pdf_quotation/{file}', 'PAMMSPController@response');

	// Backup Route Demo for New Templating
	Route::get('/s4l3s1324','SalesDemoController@index')->middleware('ManagerStaffMiddleware');
	Route::get('/s4l3s1324_detail/{lead_id}','SalesDemoController@detail_sales');
	Route::get('/s4l3s1324_pr','SalesDemoController@admin_pr');
	Route::get('/s4l3s1324_po','SalesDemoController@admin_po');
	Route::get('/s4l3s1324_letter','SalesDemoController@admin_letter');
	Route::get('/s4l3s1324_quote','SalesDemoController@admin_quote');
	Route::get('/s4l3s1324_hr','SalesDemoController@admin_hr');
	Route::get('/s4l3s1324_employees','SalesDemoController@employees');
	Route::get('/s4l3s1324_leaving_permit','SalesDemoController@leaving_permit');
	Route::get('/s4l3s1324_customer','SalesDemoController@customer');
	Route::get('/s4l3s1324_idpro','SalesDemoController@idpro');
	Route::get('/s4l3s1324_partnership','SalesDemoController@partnership');
	Route::get('/s4l3s1324_sho','SalesDemoController@sho');
	Route::get('/s4l3s1324_detail_sho/{id_sho}','SalesDemoController@detail_sho');
	Route::get('/s4l3s1324_report_range','SalesDemoController@report_range');
	Route::get('/s4l3s1324_claim','SalesDemoController@claim');
	Route::get('/s4l3s1324_detail_claim/{no}', 'SalesDemoController@detail_claim');
	Route::get('/s4l3s1324_pam', 'SalesDemoController@pam');
	Route::get('/s4l3s1324_detail_pam/{id_pam}', 'SalesDemoController@detail_pam');
	Route::get('/s4l3s1324_profile', 'SalesDemoController@profile');
	Route::get('/s4l3s1324_dashboard', 'SalesDemoController@dashboard');
	Route::get('/s4l3s1324_view_lead', 'SalesDemoController@view_lead');
	Route::get('/s4l3s1324_view_open', 'SalesDemoController@view_open');
	Route::get('/s4l3s1324_view_lose', 'SalesDemoController@view_lose');
	Route::get('/s4l3s1324_view_win', 'SalesDemoController@view_win');
	Route::get('/s4l3s1324_claim_pending', 'SalesDemoController@claim_pending');
	Route::get('/s4l3s1324_claim_transfer', 'SalesDemoController@claim_transfer');
	Route::get('/s4l3s1324_claim_admin', 'SalesDemoController@claim_admin');

	// Add Kategori Inventory
	Route::post('/add_kat', 'WarehouseController@store');
	Route::post('/add_kat_asset', 'WarehouseAssetController@store_kat');
	Route::post('/add_katalog_asset', 'WarehouseAssetController@store');
	Route::post('import', 'WarehouseController@import');
	Route::get('/dropdownKategori', 'WarehouseController@getDropdownKategori');
	Route::post('/turunkan', 'WarehouseController@turunkan_jml');

	// Report Inventory
	Route::get('/getdropdownreport', 'WarehouseReportController@getDropdown');
	Route::get('/getdatadropdown2', 'WarehouseReportController@getdatadropdown2');
	Route::get('/getdatadropdown_do', 'WarehouseReportController@getdatadropdown_do');
	Route::get('/getdatadropdown_do2', 'WarehouseReportController@getdatadropdown_do2');
	Route::get('/getdatadropdown_po', 'WarehouseReportController@getdatadropdown_po');
	Route::get('/nopoo', 'WarehouseReportController@nopoo');
	Route::get('/nodoo', 'WarehouseReportController@nodoo');
	Route::get('/getdatadropdownpo', 'WarehouseReportController@getdatadropdownpo');
	Route::get('/getdofilter', 'WarehouseReportController@getdofilter');
	Route::get('/getpofilter', 'WarehouseReportController@getpofilter');
	Route::get('/getpostockfilter', 'WarehouseReportController@getpostockfilter');
	Route::get('/getdataidprobydate', 'WarehouseAssetController@getdataidpro');
	Route::get('/getdataidprobydate2', 'WarehouseAssetController@getdataidpro2');
	Route::get('/getqtypo', 'WarehouseAssetController@getqtypo');
	Route::get('/getqtydo', 'WarehouseAssetController@getqtydo');
	Route::get('/getdataidpro', 'WarehouseReportController@getdataidpro');
	Route::get('/getdataidpro2', 'WarehouseReportController@getdataidpro2');
	Route::get('/getnopo', 'WarehouseReportController@getnopo');
	Route::get('/getnodo', 'WarehouseReportController@getnodo');
	Route::get('/getdataidpropdf', 'WarehouseReportController@getdataidpropdf');
	Route::get('/getdataidproexcel', 'WarehouseReportController@getdataidproexcel');
	Route::get('/getdatawarehouse', 'WarehouseController@getdatawarehouse');
	Route::get('/getnopobydate', 'WarehouseAssetController@getnopo');
	Route::get('/getnodobydate', 'WarehouseAssetController@getnodo');
	Route::get('/getdataidproexcelbydate', 'WarehouseAssetController@getdataidproexcelbydate');
	Route::get('/getdataidpropdfbydate', 'WarehouseAssetController@getdataidpropdfbydate');

	//Money Request
	Route::get('/money_req', 'MoneyRequestController@index');
	Route::post('/store_money_req', 'MoneyRequestController@store');
	Route::get('/delete_money_req/{id_money_req}', 'MoneyRequestController@destroy');
	Route::get('/detail_money_req/{id_money_req}', 'MoneyRequestController@detail_money');
	Route::get('/edit_money_req/{id_money_req}', 'MoneyRequestController@edit');
	Route::post('/update_money_req', 'MoneyRequestController@update');
	Route::post('/changelog_money_req', 'MoneyRequestController@changelog_money_req');
	Route::post('/update_cogs', 'MoneyRequestController@update_cogs');
	Route::get('/export_excel', 'MoneyRequestController@export_excel');
	Route::get('/export_pdf/{id_money_req}', 'MoneyRequestController@export_pdf');
	Route::get('/export_pdf2/{id_money_req}', 'MoneyRequestController@export_pdf2');
	Route::get('/export_pdf3/{id_money_req}', 'MoneyRequestController@export_pdf3');
	Route::get('/export1/{id_money_req}', 'MoneyRequestController@export1');
	Route::get('/export2/{id_money_req}', 'MoneyRequestController@export2');
	Route::get('/export3/{id_money_req}', 'MoneyRequestController@export3');
	Route::get('/export_uangsaku1/{id_money_req}', 'MoneyRequestController@export_uangsaku1');
	Route::get('/export_uangsaku2/{id_money_req}', 'MoneyRequestController@export_uangsaku2');
	Route::get('/export_uangsaku3/{id_money_req}', 'MoneyRequestController@export_uangsaku3');

	//PO Customer
	Route::post('/add_po_customer','SalesController@add_po');
	Route::post('/update_po_customer','SalesController@update_po');
	Route::get('/delete_po_customer/{id_tb_po_cus}','SalesController@delete_po');

	Route::get('asset_atk', 'AssetAtkController@index');
	Route::post('store_asset_atk', 'AssetAtkController@store');
	Route::get('get_qty_atk','AssetAtkController@getqtyatk');
	Route::post('request_atk', 'AssetAtkController@request_atk');
	Route::post('accept_request', 'AssetAtkController@accept_request');
	Route::post('edit_atk', 'AssetAtkController@edit_atk');
	Route::post('reject_request', 'AssetAtkController@reject_request');
	Route::get('/detail_asset_atk/{id_barang}','AssetAtkController@detail');

	Route::get('firebase','FirebaseController@index');
	Route::get('/firebase/store','FirebaseController@SetFirebaseUpdate');

	Route::get('/po_id_pro', 'IdProNotaController@index');
	Route::post('/store_po_idpro', 'IdProNotaController@store');
	Route::get('/getdatapo', 'IdProNotaController@getdata');


	//presence msp
	Route::get('/presence','PresenceController@index');
	Route::get('/presence/history/personal', 'PresenceController@personalHistory');
});
