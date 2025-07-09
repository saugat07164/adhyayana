<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::with('category')->get()->map(function($course) {
            $course->students_count = $course->enrollments()->count() ?? 0;
            $course->duration = $course->units()->sum('duration') . ' hours'; // or any logic you want
            return $course;
        });
        return view('courses.index', compact('courses'));
    }
} 