<?php

namespace App\Services;

use App\Models\Course;

use Illuminate\Support\Collection;

use App\Repositories\Repository;
use App\Repositories\CourseRepository;

class CourseService extends Repository
{
    public function __construct(
    ) {
    }

    public function getAllCourses(): Collection
    { 
        $repository = new CourseRepository(Course::class);
        return $repository->getAll();
    }
}
