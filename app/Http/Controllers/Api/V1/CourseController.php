<?php

namespace App\Http\Controllers\Api\V1;

use App\DTOs\CourseDTO;
use App\Http\Controllers\Controller;
use App\Services\CourseService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function __construct(
        private CourseService $courseService
    ) {}
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        return response()->json([
            'data'  => $this->courseService->listAll(),
        ],200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title' => 'required',
            'description'   => 'required',
            'price' => 'required|numeric',
        ]);

        $course = $this->courseService->store(CourseDTO::fromArray($validated));

        return response()->json([
                'message'   => 'Course created success!',
                'data'=> $course,
            ],201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $validated = $request->validate([
            'title'=> 'required',
            'description'=> 'required',
            'price'=> 'required',
            ]);

            $course = $this->courseService->update($id, $validated);
            if(! $course) {

                return response()->json([
                        'message'=> 'Course not found',
                    ],404);

            }
            return response()->json([
                    'message'=> 'Updated success',
                    'data'=> $course,
                ],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $this->courseService->delete($id);
        return response()->json([
            'message'=> 'Deleted success',
            ],200);
    }

    public function enrolnow(string $id): JsonResponse
    {
        $course = $this->courseService->getCourseById($id);
        if(! $course) {
            return response()->json([
                'message'=> 'Course not found',
                ],404);
        }
        $enroll = $this->courseService->enrollCourse($course);

        if( $enroll) {
            return response()->json([
                    'message'=> 'Enrolled success',
                    'data'=> $course,
                ],200);
        }
        return response()->json([
                    'message'=> 'Enrollment Failed',
                    'data'=> $course,
                ],422);
    }

    public function myCourses(Request $request): JsonResponse
    {
        return response()->json([
            'data' => $this->courseService->myCourses($request->user())
            ],200);
    }

    public function search(Request $request): JsonResponse
    {
        $request->validate([
            'search' => 'required',
        ]);

        $courses = $this->courseService->searchCourse($request->user(), $request->search);
        if( $courses->count() > 0 ) {

            return response()->json([
                    'message'   => 'Records fetched success',
                    'data' => $courses
                ],200);
        }
        return response()->json([
                    'message'   => 'No records found',
                    'data' => []
                ],200);
    }
}
