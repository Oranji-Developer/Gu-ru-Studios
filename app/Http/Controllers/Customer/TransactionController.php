<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Children;
use App\Models\Course;
use App\Models\UserCourse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class TransactionController extends Controller
{

    public function invoice($course_id, $children_id): \Inertia\Response
    {
        $children = Children::with('user')->findOrFail($children_id);
        $course = Course::with('mentor', 'schedule')->findOrFail($course_id);

        $isChildren = Gate::denies('can-view', $children);

        if ($isChildren) {
            abort(403);
        }

        return Inertia::render('Customer/Transaction/Invoice', [
            'course' => $course,
            'children' => $children,
        ]);
    }
    public function paymentWhatshapp($id)
    {
        $userCourse = UserCourse::with([
            'course',
            'children' => function ($query) {
                $query->with('user');
            }
        ])->findOrFail($id);

        return Inertia::render('Customer/Transaction/PaymentWhatshapp', [
            'data' => $userCourse,
        ]);
    }

}
