<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Course;
use App\Models\Enrollment;
use App\Policies\CategoryPolicy;
use App\Policies\CoursePolicy;
use App\Policies\EnrollmentPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Category::class => CategoryPolicy::class,
        Course::class => CoursePolicy::class,
        Enrollment::class => EnrollmentPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }
}

