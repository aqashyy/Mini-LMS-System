<?php

namespace App\Repositories;

use App\DTOs\CourseDTO;
use App\Interfaces\Admin\CourseRepoInterface;
use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use PHPUnit\Framework\Constraint\Count;

class CourseRepo implements CourseRepoInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }
    public function list()
    {
        $user = auth()->user();
        $courses = Course::withCount('students')->get()->map(function (Course $course) use($user) {

            return [
                'title' => $course->title,
                'description'   => $course->description,
                'price' => $course->price,
                'students_count' => $course->students_count,
                'is_enrolled' => $course->students->contains($user)
            ];
        });
        return $courses;
    }

    public function findById(int $id): Course|null
    {
        return Course::find($id);
    }

    public function create(CourseDTO $courseDTO): Course
    {
        return Course::create($courseDTO->toArray());
    }

    public function update(Course $course, array $data): Course
    {
        $course->update($data);

        return $course;
    }

    public function delete(Course $course): void
    {
        $course->delete();
    }

    public function search(User $user, string $searchText)
    {
        $query = Course::withCount('students');

        $query->where(function ($q) use ($searchText) {

            $q->where('title', 'like', '%'. $searchText .'%')
            ->orWhere('description' , 'like', '%'. $searchText .'%');

        });

        $courses = $query->get()->map(function ($course) use ($user) {
                return [
                    'title' => $course->title,
                    'description'   => $course->description,
                    'price' => $course->price,
                    'students_count' => $course->students_count,
                    'is_enrolled' => $course->students->contains($user)
                ];
        });

        return $courses;
    }
}
