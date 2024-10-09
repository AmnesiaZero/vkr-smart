<?php

namespace App\Providers;

use App\Exports\WorksExport;
use App\Services\Decorations\Repositories\DecorationRepositoryInterface;
use App\Services\Decorations\Repositories\EloquentDecorationRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Maatwebsite\Excel\Facades\Excel;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->register(HelperServiceProvider::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();
        $repositories = [
            'Organization' => 'Organizations',
            'OrganizationYear' => 'OrganizationsYears',
            'User' => 'Users',
            'Faculty' => 'Faculties',
            'Department' => 'Departments',
            'Program' => 'Programs',
            'Specialty' => 'Specialties',
            'ProgramSpecialty' => 'ProgramsSpecialties',
            'Role' => 'Roles',
            'InviteCode' => 'InviteCodes',
            'Work' => 'Works',
            'ScientificSupervisor' => 'ScientificSupervisors',
            'WorksType' => 'WorksTypes',
            'AdditionalFile' => 'AdditionalFiles',
            'Comment' => 'Comments',
            'Achievement' => 'Achievements',
            'AchievementRecord' => 'AchievementsRecords',
            'ReportAsset' => 'ReportsAssets',
            'Education' => 'Educations',
            'Career' => 'Careers',
            'News' => 'News'
        ];

        foreach ($repositories as $k => $v) {
            $this->app->bind('App\\Services\\' . $v . '\\Repositories\\' . $k . 'RepositoryInterface',
                'App\\Services\\' . $v . '\\Repositories\\Eloquent' . $k . 'Repository');
        }

    }
}
