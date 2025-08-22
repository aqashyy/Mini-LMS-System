<?php

namespace App\Services;

use App\DTOs\CourseDTO;
use App\Interfaces\Admin\CourseRepoInterface;
use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class CourseService
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        private CourseRepoInterface $courseRepoInterface
    )
    {
        //
    }

    public function listAll()
    {
        return $this->courseRepoInterface->list();
    }

    public function getCourseById(int $id): ?Course
    {
        return $this->courseRepoInterface->findById($id);
    }

    public function store(CourseDTO $courseDTO): Course
    {
        return $this->courseRepoInterface->create($courseDTO);
    }

    public function update(int $id, array $data): ?Course
    {
        $course = $this->courseRepoInterface->findById($id);

        if(!$course) {
            return null;
        }

        return $this->courseRepoInterface->update($course, $data);

    }

    public function delete(int $id): void
    {
        $course = $this->courseRepoInterface->findById($id);

        if(!$course) {
            return ;
        }

        $this->courseRepoInterface->delete($course);
    }

    public function enrollCourse(Course $course): bool
    {
        $user = auth()->user();

        $user->enrolledCourses()->syncWithoutDetaching($course->id);

        return true;
    }

    public function myCourses(User $user): Collection
    {
        return $user->enrolledCourses()->get();
    }

    public function searchCourse(User $user, string $searchText)
    {
       return $this->courseRepoInterface->search($user, $searchText);
    }
}
