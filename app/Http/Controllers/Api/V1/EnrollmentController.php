<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEnrollmentRequest;
use App\Http\Resources\EnrollmentResource;
use App\Models\Enrollment;
use App\Models\Course;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    public function index()
    {
        $enrollments = Enrollment::with(['user', 'course'])->get();
        return EnrollmentResource::collection($enrollments);
    }

    public function store(StoreEnrollmentRequest $request)
    {
        $this->authorize('create', Enrollment::class);
        
        $existingEnrollment = Enrollment::where('user_id', auth()->id())
            ->where('course_id', $request->validated()['course_id'])
            ->first();
            
        if ($existingEnrollment) {
            return response()->json(['message' => 'Already enrolled in this course'], 409);
        }
        
        $enrollment = Enrollment::create($request->validated());
        
        $enrollment->load(['user', 'course']);
        
        return new EnrollmentResource($enrollment);
    }

    public function show(Enrollment $enrollment)
    {
        $this->authorize('view', $enrollment);
        
        $enrollment->load(['user', 'course']);
        return new EnrollmentResource($enrollment);
    }

    public function update(StoreEnrollmentRequest $request, Enrollment $enrollment)
    {
        $this->authorize('update', $enrollment);
        
        $enrollment->update($request->validated());
        $enrollment->load(['user', 'course']);
        
        return new EnrollmentResource($enrollment);
    }

    public function destroy(Enrollment $enrollment)
    {
        $this->authorize('delete', $enrollment);
        
        $enrollment->delete();
        
        return response()->json(['message' => 'Enrollment removed successfully']);
    }

    public function courseStudents(Course $course)
    {
        $enrollments = $course->enrollments()->with('user')->get();
        return EnrollmentResource::collection($enrollments);
    }

    public function userEnrollments()
    {
        $enrollments = auth()->user()->enrollments()->with('course')->get();
        return EnrollmentResource::collection($enrollments);
    }
}
