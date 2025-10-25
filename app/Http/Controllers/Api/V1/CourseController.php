<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCourseRequest;
use App\Http\Resources\CourseResource;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::with(['instructor', 'category', 'students'])->get();
        return CourseResource::collection($courses);
    }

    public function store(StoreCourseRequest $request)
    {
        $this->authorize('create', Course::class);
        
        $course = Course::create($request->validated());
        $course->load(['instructor', 'category']);
        
        return new CourseResource($course);
    }

    public function show(Course $course)
    {
        $course->load(['instructor', 'category', 'students']);
        return new CourseResource($course);
    }

    public function update(StoreCourseRequest $request, Course $course)
    {
        $this->authorize('update', $course);
        
        $course->update($request->validated());
        $course->load(['instructor', 'category']);
        
        return new CourseResource($course);
    }

    public function destroy(Course $course)
    {
        $this->authorize('delete', $course);
        
        $course->delete();
        
        return response()->json(['message' => 'Course deleted successfully']);
    }
}
