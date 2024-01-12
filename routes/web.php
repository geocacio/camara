<?php

use App\Http\Controllers\AcessibilityController;
use App\Http\Controllers\AdvancedSearchController;
use App\Http\Controllers\AgreementContractController;
use App\Http\Controllers\AgreementController;
use App\Http\Controllers\AgreementFileController;
use App\Http\Controllers\AgreementTransferController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\AvailableFilesController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\BiddingController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ChamberController;
use App\Http\Controllers\ChamberFinancialController;
use App\Http\Controllers\CommissionController;
use App\Http\Controllers\CommissionMaterialController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ConfigureOfficialDiaryController;
use App\Http\Controllers\ConstructionArtController;
use App\Http\Controllers\ConstructionContractController;
use App\Http\Controllers\ConstructionController;
use App\Http\Controllers\ConstructionFileController;
use App\Http\Controllers\ConstructionMeasurementsController;
use App\Http\Controllers\ConstructionProgressController;
use App\Http\Controllers\ContactUsController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\CouncilorComissionController;
use App\Http\Controllers\CouncilorController;
use App\Http\Controllers\CouncilorLegislatureController;
use App\Http\Controllers\CsvController;
use App\Http\Controllers\CsvExportController;
use App\Http\Controllers\DailyController;
use App\Http\Controllers\DailyPageController;
use App\Http\Controllers\DecreesController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DictionaryController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ExpensesController;
use App\Http\Controllers\ExternalLinkController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\GlossaryController;
use App\Http\Controllers\HomePageController;
use App\Http\Controllers\InspectorController;
use App\Http\Controllers\LaiController;
use App\Http\Controllers\LawController;
use App\Http\Controllers\LegislatureController;
use App\Http\Controllers\LinkController;
use App\Http\Controllers\LRFController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\MandateController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\MaterialsProgressController;
use App\Http\Controllers\MaterialVoteController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ModelController;
use App\Http\Controllers\OfficeController;
use App\Http\Controllers\OfficialJournalController;
use App\Http\Controllers\OmbudsmanPageController;
use App\Http\Controllers\OmbudsmanQuestionController;
use App\Http\Controllers\OmbudsmanSurveyController;
use App\Http\Controllers\OrdinanceController;
use App\Http\Controllers\OrdinancePageController;
use App\Http\Controllers\OrganController;
use App\Http\Controllers\OutsourcedController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PageServiceLetterController;
use App\Http\Controllers\PartyAffiliationController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\PcgController;
use App\Http\Controllers\PcsController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProceedingController;
use App\Http\Controllers\ProgressController;
use App\Http\Controllers\PublicationController;
use App\Http\Controllers\PublicationFormController;
use App\Http\Controllers\PublicationPageController;
use App\Http\Controllers\RecipesController;
use App\Http\Controllers\RecipientController;
use App\Http\Controllers\ResponsibilityController;
use App\Http\Controllers\RoleChamberController;
use App\Http\Controllers\RoleCouncilorController;
use App\Http\Controllers\SatisfactionSurveyController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\SecretaryController;
use App\Http\Controllers\SecretaryPublicationController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\SectorController;
use App\Http\Controllers\SectorEmployeesController;
use App\Http\Controllers\SelectiveProcessController;
use App\Http\Controllers\SelectiveProcessPageController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ServiceLetterController;
use App\Http\Controllers\SessionAttendanceController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SicController;
use App\Http\Controllers\SicFaqController;
use App\Http\Controllers\SicSolicitationController;
use App\Http\Controllers\SicSolicitationPanelController;
use App\Http\Controllers\SiteMapController;
use App\Http\Controllers\SymbolsController;
use App\Http\Controllers\TransparencyGroupController;
use App\Http\Controllers\TransparencyPortalController;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\VoteController;
use App\Models\ChamberFinancial;
use App\Models\Inspector;
use App\Models\Recipes;
use App\Models\ServiceLetter;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;
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

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/panel', function () {
//     return view('panel.index');
// });

Auth::routes();

Route::get('/gerar-pdf', [PdfController::class, 'gerarPDF'])->name('gerarPDF');
Route::get('/gerar-csv', [CsvController::class, 'gerarCSV'])->name('gerarCSV');
Route::get('/pdf', function () {
    $serviceLetter = ServiceLetter::first();
    $setting = Setting::first();
    return view('pdf.serviceLetter', compact('serviceLetter', 'setting'));
});

Route::middleware('auth')->group(function () {
    Route::get('/panel', function () {
        return view('panel.index');
    });

    Route::prefix('panel')->group(function () {
        Route::resource('modelo', ModelController::class);

        Route::get('settings-page', [SettingController::class, 'page'])->name('settings.page');
        Route::put('settings-page', [SettingController::class, 'pageUpdate'])->name('settings.page.update');
        Route::resource('/settings', SettingController::class);
        Route::resource('/users', UserController::class);

        Route::resource('/files', FileController::class);

        Route::get('contact-us-page', [ContactUsController::class, 'contactUsPage'])->name('contact-us.page');
        Route::post('contact-us-page', [ContactUsController::class, 'contactUsPageStore'])->name('contact-us.page.store');

        Route::get('generate-pdf-diary/{official_diary:id}', [PdfController::class, 'generateOfficialDiary'])->name('generate.pdf.diary');

        Route::resource('/home', HomePageController::class);
        Route::resource('/service', ServiceController::class);
        Route::resource('/section', SectionController::class);
        Route::resource('/posts', PostController::class);
        Route::resource('/categories', CategoryController::class);
        Route::get('/categories/{category:slug}/subcategories', [CategoryController::class, 'showSubcategories'])->name('subcategories.index');
        Route::get('/categories/{category:slug}/subcategories/create', [CategoryController::class, 'createSubcategories'])->name('subcategories.create');
        Route::post('/subcategories/create', [CategoryController::class, 'storeSubcategories'])->name('subcategories.store');
        Route::resource('types', TypeController::class);
        Route::resource('videos', VideoController::class);
        Route::resource('biddings', BiddingController::class);
        Route::resource('companies', CompanyController::class);
        Route::resource('contracts', ContractController::class);

        Route::get('types/{itemType:slug}/subtypes', [TypeController::class, 'index'])->name('subtypes.index');
        Route::get('types/{type:slug}/subtypes/create', [TypeController::class, 'create'])->name('subtypes.create');

        Route::get('legislatures-page', [LegislatureController::class, 'page'])->name('legislatures.page');
        Route::put('legislatures-page', [LegislatureController::class, 'pageUpdate'])->name('legislatures.page.update');

        Route::resource('/legislatures', LegislatureController::class);
        Route::resource('/affiliations', PartyAffiliationController::class);


        Route::get('commissions-page', [CommissionController::class, 'page'])->name('commissions.page');
        Route::put('commissions-page', [CommissionController::class, 'pageUpdate'])->name('commissions.page.update');
        Route::resource('/commissions', CommissionController::class);

        Route::get('materials-page', [MaterialController::class, 'page'])->name('materials.page');
        Route::put('materials-page', [MaterialController::class, 'pageUpdate'])->name('materials.page.update');
        Route::resource('/materials', MaterialController::class);
        Route::resource('/materials/{material}/authors', AuthorController::class);
        Route::resource('/materials/{material}/recipients', RecipientController::class);
        Route::resource('/materials/{material}/material-proceedings', MaterialsProgressController::class);
        Route::resource('/materials/{material}/votes', MaterialVoteController::class);

        Route::resource('/materials/{material}/material-commissions', CommissionMaterialController::class);

        Route::get('councilors-page', [CouncilorController::class, 'page'])->name('councilors.page');
        Route::put('councilors-page', [CouncilorController::class, 'pageUpdate'])->name('councilors.page.update');
        Route::resource('/councilors', CouncilorController::class);
        Route::resource('/councilors/{councilor:slug}/legislatures', CouncilorLegislatureController::class)->names([
            'index' => 'councilor.legislature.index',
            'create' => 'councilor.legislature.create',
            'store' => 'councilor.legislature.store',
            'show' => 'councilor.legislature.show',
            'edit' => 'councilor.legislature.edit',
            'update' => 'councilor.legislature.update',
            'destroy' => 'councilor.legislature.destroy',
        ]);
        Route::resource('/councilors/{councilor:slug}/councilor-commissions', CouncilorComissionController::class);
        Route::resource('/councilors/{councilor:slug}/party-affiliation', PartyAffiliationController::class);

        
        Route::get('sessions-page', [SessionController::class, 'page'])->name('sessions.page');
        Route::put('sessions-page', [SessionController::class, 'pageUpdate'])->name('sessions.page.update');
        Route::resource('/sessions', SessionController::class);
        Route::resource('/sessions/{session:slug}/attendances', SessionAttendanceController::class);
        Route::resource('/sessions/{session:slug}/proceedings', ProceedingController::class);


        Route::resource('/secretaries', SecretaryController::class);
        //creating reponsible of secretary
        Route::post('/secretaries/responsible/create', [SecretaryController::class, 'createResponsible'])->name('secretaries.responsible.store');

        Route::resource('/organs', OrganController::class);
        Route::resource('/departments', DepartmentController::class);
        Route::resource('/sectors', SectorController::class);

        Route::get('/sectors/{sector:slug}/employees', [SectorEmployeesController::class, 'index'])->name('sectors.employees.index');
        Route::get('/sectors/{sector:slug}/employees/create', [SectorEmployeesController::class, 'create'])->name('sectors.employees.create');
        Route::get('/sectors/{sector:slug}/employees/create2', [SectorEmployeesController::class, 'create2'])->name('sectors.employees.create2');
        Route::get('/sectors/{sector:slug}/employees/{id}/edit', [SectorEmployeesController::class, 'edit'])->name('sectors.employees.edit');
        Route::put('/sectors/{sector:slug}/employees/{id}/update', [SectorEmployeesController::class, 'update'])->name('sectors.employees.update');
        Route::post('/sectors/{sector:slug}/employees/store', [SectorEmployeesController::class, 'store'])->name('sectors.employees.store');
        Route::post('/sectors/{sector:slug}/employees/store2', [SectorEmployeesController::class, 'store'])->name('sectors.employees.store2');
        Route::delete('/sectors/{sector:slug}/employees/{id}', [SectorEmployeesController::class, 'destroy'])->name('sectors.employees.destroy');
        Route::post('/sectors/{sector:slug}/employees/{id}/change-satus', [SectorEmployeesController::class, 'changeStatus'])->name('sectors.employee.changeStatus');
        Route::resource('/employees', EmployeeController::class);
        Route::resource('/offices', OfficeController::class);
        Route::resource('/lai', LaiController::class);

        Route::resource('/glossary', GlossaryController::class);
        Route::get('glossary-page', [GlossaryController::class, 'page'])->name('glossary.page');
        Route::put('glossary-page', [GlossaryController::class, 'pageUpdate'])->name('glossary.page.update');

        Route::resource('/dictionary', DictionaryController::class);
        Route::get('dictionary-page', [DictionaryController::class, 'page'])->name('dictionary.page');
        Route::put('dictionary-page', [DictionaryController::class, 'pageUpdate'])->name('dictionary.page.update');

        Route::get('role-councilor-page', [RoleCouncilorController::class, 'page'])->name('role.councilor.page');
        Route::put('role-councilor-page', [RoleCouncilorController::class, 'pageUpdate'])->name('role.councilor.page.update');
        Route::resource('/role-councilor', RoleCouncilorController::class);


        Route::get('role-chambers-page', [RoleChamberController::class, 'page'])->name('chamber.page');
        Route::put('role-chambers-page', [RoleChamberController::class, 'pageUpdate'])->name('chamber.page.update');
        Route::resource('/role-chambers', RoleChamberController::class);

        Route::resource('/chambers-financials', ChamberFinancialController::class);
        Route::post('/chamber-financial/status', [ChamberFinancialController::class, 'status']);

        Route::get('funcionarios/terceirizados-page', [App\Http\Controllers\EmployeeController::class, 'outsourcedPage'])->name('terceirizados.page');
        Route::get('funcionarios/estagiarios-page', [App\Http\Controllers\EmployeeController::class, 'traineePage'])->name('treinee.page');
        
        Route::put('funcionarios/terceirizados-page', [App\Http\Controllers\EmployeeController::class, 'outsourcedPageUpdate'])->name('terceirizados.page.update');
        Route::put('funcionarios/estagiarios-page', [App\Http\Controllers\EmployeeController::class, 'traineePageUpdate'])->name('treinee.page.update');
        

        Route::get('official-diary/page', [App\Http\Controllers\OfficialJournalController::class, 'journalPage'])->name('journal.page');
        Route::put('official-diary/page', [App\Http\Controllers\OfficialJournalController::class, 'journalPageUpdate'])->name('journal.page.update');
        Route::resource('/fiscais', InspectorController::class);



        //Routes linked to biddings
        Route::resource('/progress', ProgressController::class);
        Route::delete('/publications/{publicationForm:slug}', [PublicationFormController::class, 'destroy'])->name('publications.destroy');
        // Route::resource('/responsibilities', ResponsibilityController::class);
        Route::prefix('biddings')->group(function () {

            Route::get('/{bidding:slug}/progress', [ProgressController::class, 'index'])->name('biddings.progress.index');
            Route::get('/{bidding:slug}/progress/create', [ProgressController::class, 'create'])->name('biddings.progress.create');
            Route::get('/{bidding:slug}/progress/{progress:slug}/edit', [ProgressController::class, 'edit'])->name('biddings.progress.edit');
            Route::delete('/{bidding:slug}/progress/{progress:slug}/destroy', [ProgressController::class, 'destroy'])->name('biddings.progress.destroy');

            Route::get('/{bidding:slug}/responsibilities', [ResponsibilityController::class, 'index'])->name('biddings.responsibilities.index');
            Route::get('/{bidding:slug}/responsibilities/create', [ResponsibilityController::class, 'create'])->name('biddings.responsibilities.create');
            Route::post('/{bidding:slug}/responsibilities/store', [ResponsibilityController::class, 'store'])->name('biddings.responsibilities.store');
            Route::get('/{bidding:slug}/responsibilities/edit', [ResponsibilityController::class, 'edit'])->name('biddings.responsibilities.edit');
            Route::delete('/{bidding:slug}/responsibilities/destroy', [ResponsibilityController::class, 'destroy'])->name('biddings.responsibilities.destroy');

            Route::delete('/{bidding:slug}/responsibility/{id}/destroy', [ResponsibilityController::class, 'destroyResponsibility'])->name('biddings.responsibility.destroy');

            Route::get('/{bidding:slug}/publications', [PublicationFormController::class, 'index'])->name('biddings.publications.index');
            Route::get('/{bidding:slug}/publications/create', [PublicationFormController::class, 'create'])->name('biddings.publications.create');
            Route::post('/{bidding:slug}/publications/store', [PublicationFormController::class, 'store'])->name('biddings.publications.store');
            Route::get('/{bidding:slug}/publications/{publicationForm:slug}/edit', [PublicationFormController::class, 'edit'])->name('biddings.publications.edit');
            Route::get('/{bidding:slug}/publications/{publicationForm:slug}/update', [PublicationFormController::class, 'update'])->name('biddings.publications.update');
            Route::delete('/{bidding:slug}/publications/{publicationForm:slug}/destroy', [PublicationFormController::class, 'destroy'])->name('biddings.publications.destroy');

            Route::get('/{bidding:slug}/available-files', [AvailableFilesController::class, 'index'])->name('biddings.available.files.index');
            Route::get('/{bidding:slug}/available-files/create', [AvailableFilesController::class, 'create'])->name('biddings.available.files.create');
            Route::post('/{bidding:slug}/available-files/store', [AvailableFilesController::class, 'store'])->name('biddings.available.files.store');
            Route::get('/{bidding:slug}/available-files/{id}/edit', [AvailableFilesController::class, 'edit'])->name('biddings.available.files.edit');
            Route::put('/{bidding:slug}/available-files/{id}/update', [AvailableFilesController::class, 'update'])->name('biddings.available.files.update');
            Route::delete('/{bidding:slug}/available-files/{id}/destroy', [AvailableFilesController::class, 'destroy'])->name('biddings.available.files.destroy');
            Route::post('/available-files/category/create', [AvailableFilesController::class, 'createCategory']);

            Route::get('/{bidding:slug}/company/create', [CompanyController::class, 'create'])->name('biddings.company.create');
            Route::post('/{bidding:slug}/company/store', [CompanyController::class, 'store'])->name('biddings.company.store');
            Route::get('/{bidding:slug}/company/contracts', [ContractController::class, 'index'])->name('biddings.company.contracts.index');
            Route::get('/{bidding:slug}/company/contracts/create', [ContractController::class, 'create'])->name('biddings.company.contracts.create');
            Route::post('/{bidding:slug}/company/contracts/store', [ContractController::class, 'store'])->name('biddings.company.contracts.store');
            Route::get('/{bidding:slug}/company/contracts/{id}/edit', [ContractController::class, 'edit'])->name('biddings.company.contracts.edit');
            Route::put('/{bidding:slug}/company/contracts/{id}/update', [ContractController::class, 'update'])->name('biddings.company.contracts.update');
            Route::delete('/{bidding:slug}/company/contracts/{id}/destroy', [ContractController::class, 'destroy'])->name('biddings.company.contracts.destroy');
        });


        Route::prefix('configurations')->group(function () {
            Route::prefix('pages')->group(function () {
                Route::resource('sections', SectionController::class);
                Route::post('sections/visibility', [SectionController::class, 'visibility']);
            });
            Route::resource('/pages', PageController::class);
            Route::prefix('menus')->group(function () {
                Route::get('/create/{menu:slug}', [MenuController::class, 'createLink'])->name('menus.create.link');
                Route::post('/create', [MenuController::class, 'storeLink'])->name('menus.store.link');
            });
            Route::resource('/links', LinkController::class);
            Route::post('/links/visibility', [LinkController::class, 'visibility']);
            Route::resource('/menus', MenuController::class);
            Route::resource('/maintenance', MaintenanceController::class);
            Route::post('/maintenance/visibility', [MaintenanceController::class, 'visibility']);
        });

        Route::prefix('transparency')->group(function () {
            Route::get('/', [TransparencyPortalController::class, 'index'])->name('transparency.index');
            Route::post('/', [TransparencyPortalController::class, 'store'])->name('transparency.store');
            Route::put('/', [TransparencyPortalController::class, 'update'])->name('transparency.update');

            Route::resource('/groups', TransparencyGroupController::class)->names([
                'index' => 'transparency.groups.index',
                'create' => 'transparency.groups.create',
                'store' => 'transparency.groups.store',
                'show' => 'transparency.groups.show',
                'edit' => 'transparency.groups.edit',
                'update' => 'transparency.groups.update',
                'destroy' => 'transparency.groups.destroy',
            ]);

            Route::resource('external-links', ExternalLinkController::class);
            Route::resource('veiculos', VehicleController::class);
            Route::resource('lrfs', LRFController::class);
            Route::put('page-lrfs', [LRFController::class, 'pageUpdate'])->name('lrfs-page.update');
            Route::get('page-lrfs', [LRFController::class, 'pageEdit'])->name('lrf-edit.page');
            // Route::get('lrfs-page', [LRFController::class, 'page'])->name('lrf.page');
            Route::resource('ombudsman', OmbudsmanPageController::class);
            Route::resource('ombudsman-feedback', App\Http\Controllers\OmbudsmanFeedbackController::class);
            Route::put('ombudsman-feedback/{ombudsman_feedback}/deadline', [App\Http\Controllers\OmbudsmanFeedbackController::class, 'deadline'])->name('ombudsman-feedback.deadline');
            Route::resource('ombudsman-institutional', App\Http\Controllers\OmbudsmanInstitutionalController::class);
            Route::resource('ombudsman-faq', App\Http\Controllers\OmbudsmanFAQController::class);

            Route::resource('ombudsman-survey', OmbudsmanSurveyController::class);
            Route::get('ombudsman-survey-page', [OmbudsmanSurveyController::class, 'page'])->name('ombudsman.survey.page');
            Route::post('ombudsman-survey-page', [OmbudsmanSurveyController::class, 'pageStore'])->name('ombudsman.survey.page.store');
            Route::put('ombudsman-survey-page', [OmbudsmanSurveyController::class, 'pageUpdate'])->name('ombudsman.survey.page.update');

            Route::resource('ombudsman-survey-questions', OmbudsmanQuestionController::class);

            Route::resource('/serviceLetter', ServiceLetterController::class);
            Route::get('/serviceLetter-page', [ServiceLetterController::class, 'indexPage'])->name('serviceLetter.indexPage');
            Route::put('/serviceLetter-page', [ServiceLetterController::class, 'pageUpdate'])->name('serviceLetter.page.update');
            Route::resource('/pageServiceLetter', PageServiceLetterController::class);

            Route::resource('managers', ManagerController::class);
            Route::get('managers-page', [ManagerController::class, 'indexPage'])->name('managers.indexPage');
            Route::get('page-managers', [ManagerController::class, 'page'])->name('gestores.page');
            Route::post('managers-page', [ManagerController::class, 'pageStore'])->name('managers.page.store');
            Route::put('managers-page', [ManagerController::class, 'pageUpdate'])->name('managers.page.update');

            Route::get('payrolls/export', [PayrollController::class, 'export'])->name('payrolls.export');
            Route::post('payrolls/import', [PayrollController::class, 'import'])->name('payrolls.import');
            Route::resource('payrolls', PayrollController::class);
            Route::get('payrolls/{payroll:slug}/payments/export-model', [PaymentController::class, 'exportModel'])->name('payments.export.model');
            Route::get('payrolls/{payroll:slug}/payments/export', [PaymentController::class, 'export'])->name('payments.export');
            Route::post('payrolls/{payroll:slug}/payments/import', [PaymentController::class, 'import'])->name('payments.import');
            Route::resource('payrolls/{payroll:slug}/payments', PaymentController::class);
            // Route::get('payrolls/{payroll:slug}/payments', [PaymentController::class, 'create'])->name('payments.create');
            // Route::post('payrolls/{payroll:slug}/payments', [PaymentController::class, 'store'])->name('payments.store');

            Route::resource('symbols', SymbolsController::class);

            Route::resource('decrees', DecreesController::class);
            Route::get('decrees-page', [DecreesController::class, 'page'])->name('decrees.page');
            Route::post('decrees-page', [DecreesController::class, 'pageStore'])->name('decrees.page.store');
            Route::put('decrees-page', [DecreesController::class, 'pageUpdate'])->name('decrees.page.update');

            Route::resource('laws', LawController::class);
            Route::get('laws-page', [LawController::class, 'page'])->name('laws.page');
            Route::post('laws-page', [LawController::class, 'pageStore'])->name('laws.page.store');
            Route::put('laws-page', [LawController::class, 'pageUpdate'])->name('laws.page.update');

            Route::resource('dailies', DailyController::class);
            Route::get('dailies-page', [DailyController::class, 'page'])->name('dailies.page');
            Route::post('dailies-page', [DailyController::class, 'pageStore'])->name('dailies.page.store');
            Route::put('dailies-page', [DailyController::class, 'pageUpdate'])->name('dailies.page.update');

            Route::resource('ordinances', OrdinanceController::class);
            Route::get('ordinances-page', [OrdinanceController::class, 'page'])->name('ordinances.page');
            Route::post('ordinances-page', [OrdinanceController::class, 'pageStore'])->name('ordinances.page.store');
            Route::put('ordinances-page', [OrdinanceController::class, 'pageUpdate'])->name('ordinances.page.update');

            Route::resource('all-publications', PublicationController::class);
            Route::get('publications-page', [PublicationController::class, 'page'])->name('publications.page');
            Route::post('publications-page', [PublicationController::class, 'pageStore'])->name('publications.page.store');
            Route::put('publications-page', [PublicationController::class, 'pageUpdate'])->name('publications.page.update');
            Route::put('ordinances-page', [OrdinanceController::class, 'pageUpdate'])->name('ordinances.page.update');

            Route::resource('selective-process', SelectiveProcessController::class);
            Route::get('page-selective-process', [SelectiveProcessController::class, 'page'])->name('proccess.selective.page');
            Route::post('page-selective-process', [SelectiveProcessController::class, 'pageStore'])->name('proccess.selective.page.store');
            Route::put('page-selective-process', [SelectiveProcessController::class, 'pageUpdate'])->name('proccess.selective.page.update');
            
            Route::resource('agreements', AgreementController::class);

            Route::get('agreements/{agreement:slug}/situations', [AgreementController::class, 'situations'])->name('agreements.situations');
            Route::get('agreements/{agreement:slug}/situations/create', [AgreementController::class, 'sitCreate'])->name('agreements.situations.create');
            Route::post('agreements/{agreement:slug}/situations', [AgreementController::class, 'sitStore'])->name('agreements.situations.store');
            Route::get('agreements/{agreement:slug}/situations/edit/{general_progress}', [AgreementController::class, 'sitEdit'])->name('agreements.situations.edit');
            Route::put('agreements/{agreement:slug}/situations/{general_progress}', [AgreementController::class, 'sitUpdate'])->name('agreements.situations.update');
            Route::delete('agreements/{agreement:slug}/situations/{general_progress}', [AgreementController::class, 'sitDestroy'])->name('agreements.situations.destroy');
            Route::resource('agreements/{agreement:slug}/contracts', AgreementContractController::class)->names([
                'index' => 'agreements.contracts.index',
                'create' => 'agreements.contracts.create',
                'store' => 'agreements.contracts.store',
                'edit' => 'agreements.contracts.edit',
                'update' => 'agreements.contracts.update',
                'show' => 'agreements.contracts.show',
                'destroy' => 'agreements.contracts.destroy',
            ]);
            Route::resource('agreements/{agreement:slug}/transfers', AgreementTransferController::class)->names([
                'index' => 'agreements.transfer.index',
                'create' => 'agreements.transfer.create',
                'store' => 'agreements.transfer.store',
                'edit' => 'agreements.transfer.edit',
                'update' => 'agreements.transfer.update',
                'show' => 'agreements.transfer.show',
                'destroy' => 'agreements.transfer.destroy',
            ]);

            Route::resource('agreements/{agreement:slug}/files', AgreementFileController::class)->names([
                'index' => 'agreements.file.index',
                'create' => 'agreements.file.create',
                'store' => 'agreements.file.store',
                'edit' => 'agreements.file.edit',
                'update' => 'agreements.file.update',
                'show' => 'agreements.file.show',
                'destroy' => 'agreements.file.destroy',
            ]);

            Route::resource('constructions', ConstructionController::class);
            Route::resource('constructions/{construction:slug}/measurements', ConstructionMeasurementsController::class);
            Route::resource('constructions/{construction:slug}/art', ConstructionArtController::class);
            Route::resource('constructions/{construction:slug}/contracts', ConstructionContractController::class)->names([
                'index' => 'constructions.contracts.index',
                'create' => 'constructions.contracts.create',
                'store' => 'constructions.contracts.store',
                'edit' => 'constructions.contracts.edit',
                'update' => 'constructions.contracts.update',
                'show' => 'constructions.contracts.show',
                'destroy' => 'constructions.contracts.destroy',
            ]);
            Route::resource('constructions/{construction:slug}/progress', ConstructionProgressController::class)->names([
                'index' => 'constructions.progress.index',
                'create' => 'constructions.progress.create',
                'store' => 'constructions.progress.store',
                'edit' => 'constructions.progress.edit',
                'update' => 'constructions.progress.update',
                'show' => 'constructions.progress.show',
                'destroy' => 'constructions.progress.destroy',
            ]);
            Route::resource('constructions/{construction:slug}/files', ConstructionFileController::class)->names([
                'index' => 'constructions.file.index',
                'create' => 'constructions.file.create',
                'store' => 'constructions.file.store',
                'edit' => 'constructions.file.edit',
                'update' => 'constructions.file.update',
                'show' => 'constructions.file.show',
                'destroy' => 'constructions.file.destroy',
            ]);
            Route::resource('pcg', PcgController::class);
            Route::resource('pcs', PcsController::class);

            //General contracts
        });

        Route::resource('/official-diary', OfficialJournalController::class);
        Route::get('/official-diary/expediente/page',[ OfficialJournalController::class, 'expedient'])->name('diary.expedient');
        Route::match(['post', 'put'], '/official-diary/expediente', [OfficialJournalController::class, 'expedienteStore'])->name('diary.expedient.store');

        Route::get('/official-diary/page/{type}', [OfficialJournalController::class, 'normativePage'])->name('diary.normative.page');
        Route::put('/official-diary/page/{type}', [OfficialJournalController::class, 'normativePresentationStore'])->name('normative.presentation.store');

        Route::get('/official-diary/{official_diary:id}/finish', [OfficialJournalController::class, 'createOfficialDiary'])->name('official.diary.finish');
        Route::resource('/official-diary/{official_diary:id}/publications', SecretaryPublicationController::class)->middleware('can:secretary-access');
        Route::resource('/schedules', ScheduleController::class)->middleware('can:secretary-access');
        Route::resource('/configure-official-diary', ConfigureOfficialDiaryController::class);

        Route::resource('/services', ServiceController::class);

        Route::prefix('esic')->group(function () {
            Route::resource('/solicitations', SicSolicitationPanelController::class);
            Route::put('/solicitations/{solicitation}', [SicSolicitationPanelController::class, 'update'])->name('sic.solicitation.update');
            Route::resource('/faqs', SicFaqController::class)->names([
                'index' => 'sic.faq.index',
                'create' => 'sic.faq.create',
                'store' => 'sic.faq.store',
                'edit' => 'sic.faq.edit',
                'update' => 'sic.faq.update',
                'show' => 'sic.faq.show',
                'destroy' => 'sic.faq.destroy',
            ]);
            Route::put('/solicitations/{solicitation:slug}/deadline', [SicSolicitationPanelController::class, 'deadline'])->name('sic.solicitation.deadline');

            Route::resource('/', SicController::class)->parameters(['' => 'sic'])->names([
                'index' => 'esic.index',
                'store' => 'esic.store',
                'update' => 'esic.update',
                'destroy' => 'esic.destroy',
            ]);
        });
        
        Route::resource('/acessibility', AcessibilityController::class);
        Route::resource('/banners', BannerController::class);
        Route::resource('/recipes', RecipesController::class);
        Route::get('/recipes-page', [RecipesController::class, 'page'])->name('recipes.page');
        Route::put('/recipes-page', [RecipesController::class, 'pageUpdate'])->name('recipes.page.update');
        Route::resource('/expenses', ExpensesController::class);
        Route::get('/expenses-page', [ExpensesController::class, 'page'])->name('expenses.page');
        Route::put('/expenses-page', [ExpensesController::class, 'pageUpdate'])->name('expenses.page.update');
        Route::get('/construction-page', [ConstructionController::class, 'page'])->name('constructions.page');
        Route::put('/construction-page', [ConstructionController::class, 'pageUpdate'])->name('constructions.page.update');
        Route::get('/pcs-page', [PcsController::class, 'page'])->name('pcs.page');
        Route::put('/pcs-page', [PcsController::class, 'pageUpdate'])->name('pcs.page.update');
        Route::get('/pcg-page', [PcgController::class, 'page'])->name('pcg.page');
        Route::put('/pcg-page', [PcgController::class, 'pageUpdate'])->name('pcg.page.update');
    });
});

Route::get('/diario-oficial/reading/{id?}', [OfficialJournalController::class, 'page'])->name('official.diary.page');
Route::match(['get', 'post'], '/diario-oficial/publicacoes', [OfficialJournalController::class, 'search'])->name('official.diary.search');
Route::get('/diario-oficial/edicoes', [OfficialJournalController::class, 'allEditions'])->name('official.diary.all');
Route::get('/diario-oficial/normativas', [OfficialJournalController::class, 'normative'])->name('official.diary.normative');
Route::get('/diario-oficial/apresentacao', [OfficialJournalController::class, 'presentation'])->name('official.diary.presentation');
Route::get('/diario-oficial/expediente', [OfficialJournalController::class, 'expedientShow'])->name('expediente.show');
Route::post('/advanced-search', [AdvancedSearchController::class, 'search'])->name('advanced.search');
Route::get('/busca', [AdvancedSearchController::class, 'result'])->name('advanced-search.result');
Route::get('/pcs', [PcsController::class, 'show'])->name('prestacao-conta-gestao');
Route::get('/pcg', [PcgController::class, 'show'])->name('prestacao-conta-governo');
Route::get('/acessibilidade', [AcessibilityController::class, 'page'])->name('acessibilidade.page');
Route::get('/acessibilidade', [AcessibilityController::class, 'page'])->name('acessibilidade.page');
Route::get('/mapa-site', [SiteMapController::class, 'page'])->name('mapa-site.page');
Route::get('/expenses', [ExpensesController::class, 'show'])->name('despesas.page');
Route::get('/recipes', [RecipesController::class, 'show'])->name('receitas.page');
Route::match(['get', 'post'], '/construcoes', [ConstructionController::class, 'show'])->name('obras.page');
Route::get('/simbolos', [SymbolsController::class, 'page'])->name('simbolos.page');

Route::resource('/faleconosco', ContactUsController::class);

Route::match(['get', 'post'], 'balancetes-financeiros', [ChamberFinancialController::class, 'page'])->name('balancetes-all');

Route::get('/gestores/lista', [App\Http\Controllers\SecretaryController::class, 'show'])->name('gestores.lista.show');

Route::prefix('/secretarias')->group(function() {
    Route::match(['get', 'post'], '/', [App\Http\Controllers\SecretaryController::class, 'show'])->name('secretarias.show');
    Route::get('/{secretary:slug}', [App\Http\Controllers\SecretaryController::class, 'single'])->name('secretarias.single');
    Route::get('/{secretary:slug}/departamentos/{department:slug}', [App\Http\Controllers\SecretaryController::class, 'departmentBySecretary'])->name('secretarias.departments.single');

});

Route::get('/agendas', [App\Http\Controllers\ScheduleController::class, 'show'])->name('agendas.show');

//Satisfaction surveys
Route::post('pesquisa-satisfacao', [SatisfactionSurveyController::class, 'store'])->name('pesquisa-satisfacao.store');

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::match(['get', 'post'], '/posts', [App\Http\Controllers\PostController::class, 'getPosts'])->name('posts.getPosts');
Route::get('/posts/{post:slug}', [App\Http\Controllers\PostController::class, 'show'])->name('posts.show');

//Services Routes
Route::match(['get', 'post'], '/cartaservicos', [ServiceLetterController::class, 'page'])->name('serviceLetter.page');
Route::get('/cartaservicos/{serviceLetter:slug}', [ServiceLetterController::class, 'show'])->name('serviceLetter.show');
Route::get('/a-camara', [ChamberController::class, 'index'])->name('a-camara.show');
Route::get('/papel-vereador', [RoleCouncilorController::class, 'show'])->name('papel-vereador');
Route::get('/papel-camara', [RoleChamberController::class, 'show'])->name('papel-camara');

Route::get('/vereadores/{councilor:slug}', [CouncilorController::class, 'show'])->name('vereador.single');
Route::match(['get', 'post'], '/legislaturas/vereadores/{legislature:slug?}', [CouncilorController::class, 'allcouncilors'])->name('vereadores-all');

Route::match(['get', 'post'], 'materiais', [MaterialController::class, 'allMaterials'])->name('materiais-all');
Route::get('/materiais/{material}', [MaterialController::class, 'show'])->name('materiais.single');

Route::match(['get', 'post'], 'sessoes', [SessionController::class, 'allSessions'])->name('sessoes-all');
Route::get('/sessoes/{session}', [SessionController::class, 'show'])->name('sessoes.single');

Route::match(['get', 'post'], 'legislaturas', [LegislatureController::class, 'allLegislatures'])->name('legislaturas-all');
Route::get('/legislaturas/{legislature}', [LegislatureController::class, 'show'])->name('legislaturas.single');

Route::match(['get', 'post'], 'comissoes', [CommissionController::class, 'allCommissions'])->name('comissoes-all');
Route::get('/comissoes/{commission}', [CommissionController::class, 'show'])->name('comissoes.single');

Route::match(['get', 'post'], 'dicionario', [DictionaryController::class, 'allDictionary'])->name('dicionario');
Route::match(['get', 'post'], 'glossario', [GlossaryController::class, 'allGlossary'])->name('glossario.show');

Route::match(['get', 'post'], 'meus-videos', [VideoController::class, 'allVideos'])->name('videos-all');
Route::get('/meus-videos/{video}', [VideoController::class, 'show'])->name('video.single');

Route::get('/fale-conosco', [ContactUsController::class, 'index'])->name('fale-conosco.index');

Route::match(['get', 'post'], '/meus-lrf', [LRFController::class, 'allLrf'])->name('lrf.page');
Route::get('/meus-lrf/{lrf:slug}', [LRFController::class, 'show'])->name('all-lrf.show');

//Transparency Routes
Route::get('/transparencia', [App\Http\Controllers\TransparencyPortalController::class, 'show'])->name('transparency.show');
Route::prefix('/transparencia')->group(function () {
    Route::match(['get', 'post'], 'veiculos', [App\Http\Controllers\VehicleController::class, 'show'])->name('veiculos.show');
    Route::get('veiculos-page', [App\Http\Controllers\VehicleController::class, 'page'])->name('veiculos.page');
    Route::put('veiculos-page', [App\Http\Controllers\VehicleController::class, 'pageUpdate'])->name('veiculos.update');
    Route::get('veiculo/{modelo?}', [App\Http\Controllers\VehicleController::class, 'single'])->name('veiculos.single');
    Route::match(['get', 'post'], '/leis', [App\Http\Controllers\LawController::class, 'show'])->name('leis.show');
    Route::get('leis/{category?}', [App\Http\Controllers\LawController::class, 'byCategory'])->name('leis.category');
    Route::match(['get', 'post'], '/decretos', [App\Http\Controllers\DecreesController::class, 'show'])->name('decretos.show');
    Route::get('/diarias/{daily:id}', [App\Http\Controllers\DailyController::class, 'single'])->name('diarias.single');
    Route::match(['get', 'post'], '/diarias', [App\Http\Controllers\DailyController::class, 'show'])->name('diarias.show');
    Route::get('/decreto/{decree:slug}', [App\Http\Controllers\DecreesController::class, 'showDecree'])->name('decreto.show');
    Route::match(['get', 'post'], '/portarias', [App\Http\Controllers\OrdinanceController::class, 'show'])->name('portarias.show');
    Route::match(['get', 'post'], '/publicacoes', [App\Http\Controllers\PublicationController::class, 'show'])->name('publicacoes.show');
    Route::match(['get', 'post'], '/processo-seletivo', [App\Http\Controllers\SelectiveProcessController::class, 'show'])->name('processo-seletivo.show');
    Route::get('/ouvidoria', [App\Http\Controllers\OmbudsmanPageController::class, 'show'])->name('ouvidoria.show');
    Route::prefix('/ouvidoria')->group(function () {
        Route::get('institucional', [App\Http\Controllers\OmbudsmanInstitutionalController::class, 'show'])->name('institucional.show');
        Route::get('estatisticas', [App\Http\Controllers\OmbudsmanPageController::class, 'reports'])->name('estatisticas.reports');
        Route::get('faq', [App\Http\Controllers\OmbudsmanPageController::class, 'faq'])->name('ombudsman.faqs.show');
        Route::get('relatorios-estatisticos', [App\Http\Controllers\OmbudsmanPageController::class, 'statisticalReports'])->name('relatorios.estatisticos.reports');
        Route::get('relatorios-estatisticos/{pdfName}/pdf', [App\Http\Controllers\OmbudsmanPageController::class, 'showPDF'])->name('relatorios.estatisticos.pdf');
        Route::get('manifestacao', [App\Http\Controllers\OmbudsmanFeedbackController::class, 'create'])->name('manifestacao.show');
        Route::get('manifestacao/buscar', [App\Http\Controllers\OmbudsmanFeedbackController::class, 'seekManifestation'])->name('seekManifestation.show');
        Route::post('manifestacao', [App\Http\Controllers\OmbudsmanFeedbackController::class, 'searchManifestation'])->name('manifestacao.search');
        Route::post('manifestacao-feedback/store', [App\Http\Controllers\OmbudsmanFeedbackController::class, 'store'])->name('manifestacao.store');
        Route::get('pesquisa-de-satisfacao', [App\Http\Controllers\OmbudsmanQuestionController::class, 'show'])->name('survey.show');
        Route::post('pesquisa-de-satisfacao', [App\Http\Controllers\OmbudsmanSurveyController::class, 'store'])->name('survey.store');
    });

    Route::match(['get', 'post'] ,'funcionarios/estagiarios', [App\Http\Controllers\EmployeeController::class, 'Trainee'])->name('trainee.show');
    Route::match(['get', 'post'] ,'funcionarios/terceirizados', [App\Http\Controllers\EmployeeController::class, 'Outsourced'])->name('terceirizados.show');
    Route::get('/mapa-site', [SiteMapController::class, 'pageShow'])->name('mapa.page.show');
    Route::put('/mapa-site', [SiteMapController::class, 'pageUpdate'])->name('mapa-site.page.update');
    
    Route::prefix('licitacoes')->group(function () {
        Route::get('/', [BiddingController::class, 'BiddingPage'])->name('bidding.page');
        Route::match(['get', 'post'], 'dispensa-e-inexigibilidade', [BiddingController::class, 'DispensaInexigibilidade'])->name('dispensa.inexigibilidade');
        Route::match(['get', 'post'], 'fiscais-contrato', [InspectorController::class, 'showAll'])->name('fiscais.contrato');
        Route::match(['get', 'post'], 'chamamento-publico', [BiddingController::class, 'publicCall'])->name('public.call');
        Route::match(['get', 'post'], 'suspensas-inidoneas', [BiddingController::class, 'suspended'])->name('suspended.index');
        Route::match(['get', 'post'], 'registro-preco', [BiddingController::class, 'PriceRegistration'])->name('price.registration.index');
        Route::get('fiscais-contrato/{slug}', [InspectorController::class, 'show'])->name('fiscais.show');
    });

    Route::prefix('/sic')->group(function () {

        Route::get('/', [App\Http\Controllers\SicController::class, 'show'])->name('sic.show');

        Route::post('/login', [App\Http\Controllers\SicLoginController::class, 'login'])->name('sic.login');
        Route::get('/login', [App\Http\Controllers\SicLoginController::class, 'showForm'])->name('sic.showForm');

        Route::post('/register', [App\Http\Controllers\SicUserController::class, 'register'])->name('sicUser.register');
        Route::get('/register', [App\Http\Controllers\SicController::class, 'register'])->name('sic.register');

        Route::middleware(['auth.sic'])->group(function () {
            Route::post('/logout', [App\Http\Controllers\SicLoginController::class, 'logout'])->name('sic.logout');
            Route::get('painel', [App\Http\Controllers\SicController::class, 'panel'])->name('sic.panel');
            Route::get('perfil', [App\Http\Controllers\SicController::class, 'profile'])->name('sic.profile');
            Route::put('perfil/{sicUser}', [App\Http\Controllers\SicUserController::class, 'update'])->name('sic.updateProfile');
            Route::resource('solicitacoes', App\Http\Controllers\SicSolicitationController::class);
            // Route::get('solicitacoes', [App\Http\Controllers\sicSol::class, 'solicitations'])->name('sic.solicitations');
            // Route::post('solicitacoes', [App\Http\Controllers\SicSolicitationController::class, 'store'])->name('sic.solicitations.store');
            // Route::get('solicitacoes/create', [App\Http\Controllers\SicController::class, 'solicitationCreate'])->name('sic.solicitation.create');
            Route::get('solicitacoes/edit', [App\Http\Controllers\SicController::class, 'solicitationEdit'])->name('sic.solicitation.edit');
        });
            Route::get('estatisticas', [App\Http\Controllers\SicController::class, 'reports'])->name('sic.reports');
            Route::get('/relatorios-estatisticos', [App\Http\Controllers\SicController::class, 'statisticalReports'])->name('sic.relatorios.estatisticos');
            Route::get('/faq', [App\Http\Controllers\SicController::class, 'faq'])->name('sic.faq');
            Route::match(['get', 'post'], '/relatorios', [SicController::class, 'search'])->name('sic.search');
    });
});
