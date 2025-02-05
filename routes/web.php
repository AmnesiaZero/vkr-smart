<?php


use App\Http\Controllers\HandbookController;
use App\Http\Controllers\InviteCodesController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\Organizations\DepartmentsController;
use App\Http\Controllers\Organizations\FacultiesController;
use App\Http\Controllers\Organizations\OrganizationsController;
use App\Http\Controllers\Organizations\OrganizationsYearsController;
use App\Http\Controllers\Organizations\ProgramsController;
use App\Http\Controllers\Organizations\ProgramsSpecialtiesController;
use App\Http\Controllers\Organizations\SpecialtiesController;
use App\Http\Controllers\Portfolios\AchievementsController;
use App\Http\Controllers\Portfolios\AchievementsRecordsController;
use App\Http\Controllers\Portfolios\CareersController;
use App\Http\Controllers\Portfolios\EducationsController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\ScientificSupervisorsController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\Works\AdditionalFilesController;
use App\Http\Controllers\Works\CommentsController;
use App\Http\Controllers\Works\WorksController;
use App\Http\Controllers\Works\WorksTypesController;
use Illuminate\Http\Request;
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


Route::get('home', function () {
    return view('templates.site.index');
});
Route::get('/', function () {
    return view('templates.site.index');
})->name('home');;

Route::group([
    'prefix' => 'about'
], function () {
    Route::get('how-use', function () {
       return view('templates.site.about.how_use');
    });

    Route::get('storage', function () {
        return view('templates.site.about.storage');
    });
    Route::get('program', function () {
        return view('templates.site.about.program');
    });
    Route::get('product', function () {
        return view('templates.site.about.product');
    });
    Route::get('for-whom', function () {
        return view('templates.site.about.for_whom');
    });
    Route::get('price', function () {
        return view('templates.site.about.price');
    });
    Route::get('benefits', function () {
        return view('templates.site.about.benefits');
    });
    Route::get('algorithm', function () {
        return view('templates.site.about.algorithm');
    });
    Route::get('roles', function () {
        return view('templates.site.about.roles');
    });
});

Route::group([
    'prefix' => 'search'
], function () {
    Route::get('borrowings', function () {
        return view('templates.site.borrowings.borrowings');
    });
    Route::get('index', function () {
        return view('templates.site.borrowings.index');
    });
});

Route::get('test-access', function () {
    return view('templates.site.test_access');
});

Route::get('portfolios', function () {
    return view('templates.site.portfolio.portfolio');
});

Route::get('reviews', function () {
    return view('templates.site.reviews');
});

Route::get('check-reference', function () {
    return view('templates.site.check_reference');
});


Route::get('reset-password', function () {
    return view('templates.site.auth.reset_password');
});

Route::group([
    'prefix' => 'login'
], function () {
    Route::get('/', function () {
        return view('templates.site.auth.login');
    })->name('login');
    Route::post('/', [UsersController::class, 'login']);
    Route::post('by-code', [UsersController::class, 'registerRedirect']);
});


Route::group([
    'prefix' => 'registration',
], function () {
    Route::get('by-code', [UsersController::class, 'registerView']);
    Route::post('by-code', [UsersController::class, 'register']);
});


Route::group([
    'prefix' => 'password',
    'middleware' => 'verifyToken'
], function () {
    Route::get('new', function (Request $request) {
        $token = $request->token;
        return view('templates.site.auth.new_password', ['token' => $token]);
    });
    Route::post('new', [UsersController::class, 'newPassword']);
});

Route::group([
    'prefix' => 'mail'
], function () {
    Route::post('reset-password', [UsersController::class, 'resetPassword']);
});

Route::group([
    'prefix' => 'dashboard',
    'middleware' => ['web', 'auth']
], function () {

    Route::get('/',[UsersController::class,'dashboard']);
    //личный кабинет для студентов и преподавателей,profile для сотрудников организации. Страницы там слишком разные,чтобы в одну вьюху вставлять
    Route::get('personal-cabinet', [UsersController::class, 'personalCabinetView']);
    Route::get('profile', [UsersController::class, 'profileView']);
    Route::group([
        'prefix' => 'settings'
    ], function () {
        Route::get('organizations-structure', [OrganizationsController::class, 'organizationsStructure']);
        Route::get('teacher-departments', [UsersController::class, 'teacherDepartmentsView']);
        Route::get('access', function () {
            return view('templates.dashboard.settings.access');
        });
        Route::get('invite-codes', function () {
            return view('templates.dashboard.settings.invite_codes');
        });
        Route::get('user-management', [UsersController::class, 'userManagement']);
        Route::get('handbook-management', [HandbookController::class, 'view']);
        Route::get('integration', [OrganizationsController::class, 'integrationView']);
        Route::get('api', [UsersController::class, 'apiView']);
    });
    Route::group([
        'prefix' => 'works'
    ], function () {
        Route::get('employees', [WorksController::class, 'employeesWorksView']);
        Route::get('students', [WorksController::class, 'studentsWorksView']);
        Route::get('you', [WorksController::class, 'youWorksView']);
        Route::post('create', [WorksController::class, 'create']);
        Route::get('get', [WorksController::class, 'get']);
        Route::get('get-user-works', [WorksController::class, 'getUserWorks']);
        Route::get('search', [WorksController::class, 'search']);
        Route::get('check-code',[WorksController::class,'checkCode'])->withoutMiddleware(['web', 'auth']);
        Route::group([
            'prefix' => 'update'
        ], function () {
            Route::post('visibility', [WorksController::class, 'updateVisibility']);
            Route::post('self-check', [WorksController::class, 'updateSelfCheckStatus']);
            Route::post('/', [WorksController::class, 'update']);
        });
        Route::post('update', [WorksController::class, 'update']);
        Route::get('find', [WorksController::class, 'find'])->withoutMiddleware(['web', 'auth']);;
        Route::get('download', [WorksController::class, 'download']);
        Route::post('upload', [WorksController::class, 'upload']);
        Route::post('copy', [WorksController::class, 'copy']);
        Route::post('delete', [WorksController::class, 'delete']);
        Route::post('destroy', [WorksController::class, 'destroy']);
        Route::post('restore', [WorksController::class, 'restore']);
        Route::post('import', [WorksController::class, 'import']);
        Route::get('export', [WorksController::class, 'export']);
        Route::group([
            'prefix' => 'certificates'
        ], function () {
            Route::post('upload', [WorksController::class, 'uploadCertificate']);
            Route::get('download', [WorksController::class, 'downloadCertificate']);
        });
        Route::group([
            'prefix' => 'additional-files'
        ], function () {
            Route::get('get', [AdditionalFilesController::class, 'get']);
            Route::post('create', [AdditionalFilesController::class, 'create']);
            Route::post('delete', [AdditionalFilesController::class, 'delete']);
            Route::get('download', [AdditionalFilesController::class, 'download']);
        });
        Route::group([
            'prefix' => 'types'
        ], function () {
            Route::get('get', [WorksTypesController::class, 'get']);
            Route::post('create', [WorksTypesController::class, 'create']);
            Route::post('delete', [WorksTypesController::class, 'delete']);
        });

        Route::group([
            'prefix' => 'comments'
        ], function () {
            Route::post('create', [CommentsController::class, 'create']);
            Route::get('get', [CommentsController::class, 'get']);
            Route::post('delete', [CommentsController::class, 'delete']);
        });

        Route::group([
            'prefix' => 'report',
        ], function () {
            Route::get('get', [WorksController::class, 'getReport'])->withoutMiddleware(['web', 'auth']);
        });

    });

    Route::group([
        'prefix' => 'platform',
//        'middleware' => 'role:platformAdmin'
    ], function () {
        Route::get('/', [UsersController::class, 'mainPlatformView'])->name('platform.index');;
        Route::group([
            'prefix' => 'organizations'
        ], function () {
            Route::get('/', [OrganizationsController::class, 'view'])->name('organizations.index');
            Route::get('departments', [DepartmentsController::class, 'view'])->name('departments.index');
        });
    });


    Route::group([
        'prefix' => 'portfolios'
    ], function () {
        Route::get('students', [UsersController::class, 'studentsPortfoliosView']);
        Route::get('teachers', [UsersController::class, 'teachersPortfoliosView']);
        Route::get('{id}', [UsersController::class, 'openPortfolio']);

        Route::group([
            'prefix' => 'achievements'
        ], function () {

            Route::get('you', [AchievementsController::class, 'youAchievementsView']);
            Route::post('create', [AchievementsController::class, 'create']);
            Route::get('get', [AchievementsController::class, 'get']);
            Route::get('find', [AchievementsController::class, 'find']);
            Route::post('delete', [AchievementsController::class, 'delete']);
            Route::get('search', [AchievementsController::class, 'search']);
            Route::group([
                'prefix' => 'records'
            ], function () {
                Route::post('create', [AchievementsRecordsController::class, 'create']);
                Route::get('get', [AchievementsRecordsController::class, 'get']);
                Route::get('find', [AchievementsRecordsController::class, 'find']);
                Route::get('download', [AchievementsRecordsController::class, 'download']);
                Route::post('delete', [AchievementsRecordsController::class, 'delete']);
            });
            Route::get('{id}', [AchievementsController::class, 'view']);
        });

        Route::group([
            'prefix' => 'educations'
        ], function () {
            Route::post('create', [EducationsController::class, 'create']);
            Route::get('get', [EducationsController::class, 'get']);
            Route::post('delete', [EducationsController::class, 'delete']);
        });

        Route::group([
            'prefix' => 'careers'
        ], function () {
            Route::post('create', [CareersController::class, 'create']);
            Route::get('get', [CareersController::class, 'get']);
            Route::post('delete', [CareersController::class, 'delete']);
        });
    });

    Route::group([
        'prefix' => 'reports'
    ], function () {
        Route::get('get', [ReportsController::class, 'get']);
        Route::get('/', [ReportsController::class, 'view']);
    });

    Route::get('documentation', function () {
        return view('templates.dashboard.documentation');
    });

    Route::group([
        'prefix' => 'organizations'
    ], function () {

        Route::get('get', [OrganizationsController::class, 'get'])->name('organizations.get');

        Route::post('create', [OrganizationsController::class, 'create'])->name('organizations.create');;
        Route::get('add', [OrganizationsController::class, 'addView'])->name('organizations.add');

        Route::post('delete', [OrganizationsController::class, 'delete'])->name('organizations.delete');
        Route::post('destroy', [OrganizationsController::class, 'destroy'])->name('organizations.destroy');


        Route::group([
            'prefix' => 'update'
        ], function () {
            Route::post('/', [OrganizationsController::class, 'update'])->name('organizations.update');
            Route::post('basic', [OrganizationsController::class, 'updateBasic'])->name('organizations.update.basic');
            Route::post('premium', [OrganizationsController::class, 'updatePremium'])->name('organizations.update.premium');
            Route::post('status', [OrganizationsController::class, 'updateStatus'])->name('organizations.update.status');

        });
        Route::get('edit', [OrganizationsController::class, 'editView'])->name('organizations.edit');

        Route::post('restore', [OrganizationsController::class, 'restore'])->name('organizations.restore');


        Route::group([
            'prefix' => 'jwt'
        ], function () {
            Route::post('generate', [OrganizationsController::class, 'generateApiKey']);
        });


        Route::get('find', [OrganizationsController::class, 'find']);
        Route::post('inspectors-access', [OrganizationsController::class, 'configureInspectorsAccess']);

        Route::group([
            'prefix' => 'years'
        ], function () {
            Route::get('get', [OrganizationsYearsController::class, 'get']);
            Route::get('get-without-auth',[OrganizationsYearsController::class,'get'])->withoutMiddleware(['web', 'auth']);
            Route::post('create', [OrganizationsYearsController::class, 'create']);
            Route::post('update', [OrganizationsYearsController::class, 'update']);
            Route::post('delete', [OrganizationsYearsController::class, 'delete']);
            Route::post('copy', [OrganizationsYearsController::class, 'copy']);
            Route::get('find', [OrganizationsYearsController::class, 'find']);
            Route::get('specialties',[OrganizationsYearsController::class,'specialties']);
        });
        Route::group([
            'prefix' => 'faculties'
        ], function () {
            Route::get('get', [FacultiesController::class, 'get'])->withoutMiddleware(['web', 'auth']);;
            Route::get('find',[FacultiesController::class,'find']);
            Route::post('create', [FacultiesController::class, 'create']);
            Route::post('update', [FacultiesController::class, 'update']);
            Route::post('delete', [FacultiesController::class, 'delete']);
        });

        Route::group([
            'prefix' => 'departments'
        ], function () {
            Route::get('add', [DepartmentsController::class, 'addView'])->name('departments.add');
            Route::get('edit', [DepartmentsController::class, 'editView'])->name('departments.view.edit');
            Route::post('edit', [DepartmentsController::class, 'edit'])->name('departments.edit');
            Route::get('search', [DepartmentsController::class, 'search']);
            Route::get('find', [DepartmentsController::class, 'find']);
            Route::get('all', [DepartmentsController::class, 'all']);
            Route::get('get', [DepartmentsController::class, 'get'])->withoutMiddleware(['web', 'auth']);
            Route::post('create', [DepartmentsController::class, 'create']);
            Route::post('store', [DepartmentsController::class, 'store'])->name('departments.store');
            Route::group([
                'prefix' => 'update'
            ], function () {
                Route::post('/', [DepartmentsController::class, 'update']);
                Route::post('status', [DepartmentsController::class, 'updateStatus']);

            });
            Route::post('delete', [DepartmentsController::class, 'delete'])->name('departments.delete');
            Route::post('destroy', [DepartmentsController::class, 'destroy'])->name('departments.destroy');
            Route::post('restore', [DepartmentsController::class, 'restore'])->name('departments.restore');
            Route::get('by-user', [DepartmentsController::class, 'getByUserId']);
            Route::get('get-info', [DepartmentsController::class, 'find']);
            Route::get('specialties',[DepartmentsController::class,'specialties']);
            Route::get('program-specialties', [DepartmentsController::class, 'getProgramSpecialties'])->withoutMiddleware(['web', 'auth']);;
        });

        Route::group([
            'prefix' => 'programs'
        ], function () {
            Route::get('get', [ProgramsController::class, 'get'])->withoutMiddleware(['web', 'auth']);;
            Route::post('create', [ProgramsController::class, 'create']);
            Route::post('delete', [ProgramsController::class, 'delete']);
            Route::post('update', [ProgramsController::class, 'update']);
            Route::get('find', [ProgramsController::class, 'find']);
            Route::group([
                'prefix' => 'specialties'
            ], function () {
                Route::post('create', [ProgramsSpecialtiesController::class, 'create']);
                Route::get('get', [ProgramsSpecialtiesController::class, 'get']);
                Route::get('get-by-department', [ProgramsSpecialtiesController::class, 'getByDepartment']);
                Route::get('get-by-organization', [ProgramsSpecialtiesController::class, 'getByOrganization']);
                Route::post('delete', [ProgramsSpecialtiesController::class, 'delete']);
            });
        });

        Route::group([
            'prefix' => 'specialties'
        ], function () {
            Route::get('all', [SpecialtiesController::class, 'all'])->withoutMiddleware(['web', 'auth']);;
        });
    });


    Route::group([
        'prefix' => 'news'
    ], function () {
        Route::get('/', [NewsController::class, 'index'])->name('news.index');

        Route::get('create', [NewsController::class, 'create'])->name('news.create');
        Route::post('store', [NewsController::class, 'store'])->name('news.store');

        Route::get('edit', [NewsController::class, 'edit'])->name('news.edit');
        Route::post('update', [NewsController::class, 'update'])->name('news.update');
        Route::get('updateStatus', [NewsController::class, 'updateStatus'])->name('news.updateStatus');

        Route::post('delete', [NewsController::class, 'delete'])->name('news.delete');
        Route::post('destroy', [NewsController::class, 'destroy'])->name('news.destroy');
        Route::post('restore', [NewsController::class, 'restore'])->name('news.restore');

    });

    Route::group([
        'prefix' => 'users'
    ], function () {
        Route::get('index', [UsersController::class, 'index'])->name('users.index');
        Route::post('filter', [UsersController::class, 'filter'])->name('users.filter');
        Route::get('add', [UsersController::class, 'addView'])->name('users.add');
//        Route::post('delete/view',[UsersController::class,'deleteView'])->name('users.delete');
//        Route::post('destroy/view',[UsersController::class,'destroyView'])->name('users.destroy');
//        Route::post('restore/view',[UsersController::class,'restoreView'])->name('users.restore');
        Route::post('destroy', [UsersController::class, 'destroy'])->name('users.destroy');
        Route::get('get', [UsersController::class, 'get']);
        Route::post('create', [UsersController::class, 'create']);
        Route::post('store', [UsersController::class, 'store'])->name('users.store');
        Route::post('delete', [UsersController::class, 'delete'])->name('users.delete');
        Route::post('destroy', [UsersController::class, 'destroy'])->name('users.destroy');
        Route::post('restore', [UsersController::class, 'restore'])->name('users.restore');
        Route::get('find', [UsersController::class, 'find']);
        Route::group([
            'prefix' => 'update'
        ], function () {
            Route::post('/', [UsersController::class, 'update']);
            Route::post('status', [UsersController::class, 'updateStatus']);
        });
        Route::get('editView', [UsersController::class, 'editView'])->name('users.edit.view');
        Route::post('edit', [UsersController::class, 'edit'])->name('users.edit');
        Route::post('add-department', [UsersController::class, 'addDepartment']);
        Route::get('search', [UsersController::class, 'search']);
        Route::get('filer', [UsersController::class, 'filter'])->name('users.filter');
        Route::get('you', [UsersController::class, 'you']);
        Route::post('configure-departments', [UsersController::class, 'configureDepartments']);
        Route::get('logout', [UsersController::class, 'logout'])->name('users.logout');

    });

    Route::group([
        'prefix' => 'invite-codes'
    ], function () {
        Route::get('find',[InviteCodesController::class,'find'])->withoutMiddleware(['web', 'auth']);;
        Route::post('create', [InviteCodesController::class, 'create']);
        Route::get('get', [InviteCodesController::class, 'get']);
        Route::get('load', [InviteCodesController::class, 'loadExcel']);
    });

    Route::group([
        'prefix' => 'scientific-supervisors'
    ], function () {
        Route::get('get', [ScientificSupervisorsController::class, 'get']);
        Route::post('create', [ScientificSupervisorsController::class, 'create']);
        Route::post('delete', [ScientificSupervisorsController::class, 'delete']);
    });
});








