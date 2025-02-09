<?php

namespace App\Http\Controllers;

use App\Enum\Courses\CourseType;
use Illuminate\Http\Request;
use App\Models\Course;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
class GlobalController extends Controller
{
    public function home(Request $request)
    {
        $filterCourse = $request->input('course_type');

        $courses = Course::when($filterCourse, function ($query, $filterCourse) {
            return $query->where('course_type', $filterCourse);
        })->take(6)->get();

        return Inertia::render('Landing/Welcome', [
            'courses' => $courses,
            'course_type' => $filterCourse,
            'courseTypes' => CourseType::getValues(),
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
        ]);
    }

    public function courses(Request $request)
    {
        $filterCourse = $request->input('course_type');

        $courses = Course::when($filterCourse, function ($query, $filterCourse) {
            return $query->where('course_type', $filterCourse);
        })->get();
        return Inertia::render('Courses/Index', [
            'course_type' => $filterCourse,
            'courseTypes' => CourseType::getValues(),
            'courses' => $courses,
        ]);
    }

    public function dashboard()
    {
        return Inertia::render('DashboardRole');
    }
}
