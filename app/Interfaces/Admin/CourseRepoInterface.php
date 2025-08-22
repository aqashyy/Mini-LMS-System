<?php

namespace App\Interfaces\Admin;

use App\DTOs\CourseDTO;
use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface CourseRepoInterface
{
    public function list();

    public function findById(int $id): ?Course;

    public function create(CourseDTO $courseDTO): Course;

    public function update(Course $course, array $data): Course;

    public function delete(Course $course): void;

    public function search(User $user, string $searchText);
}
