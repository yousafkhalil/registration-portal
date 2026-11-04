<?php

namespace App\Providers;

use App\Models\AcademicProgram;
use App\Models\ConvocationFocalPerson;
use App\Models\ConvocationSetting;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Globally share convocation settings and focal persons across all Blade views
        View::composer('*', function ($view) {
            try {
                if (Schema::hasTable('convocation_settings')) {
                    $convocationSettings = ConvocationSetting::current();
                    $view->with('convocationSettings', $convocationSettings);
                }

                if (Schema::hasTable('convocation_focal_persons')) {
                    $convocationFocalPersons = ConvocationFocalPerson::active()->get();
                    $view->with('convocationFocalPersons', $convocationFocalPersons);
                }

                if (Schema::hasTable('academic_programs')) {
                    $academicPrograms = AcademicProgram::active()->get();
                    $view->with('academicPrograms', $academicPrograms);
                }
            } catch (\Exception $e) {
                // Graceful fallback for migration runs
            }
        });
    }
}
