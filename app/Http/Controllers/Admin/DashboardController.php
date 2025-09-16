<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Course;
use Illuminate\Http\Request;
use App\Models\CourseCategory;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Spatie\Activitylog\Models\Activity;

class DashboardController extends Controller
{

    public function index(){
        $now = now();
        $thisMonth = \App\Models\Transaction::where('status', 'paid')
            ->whereMonth('created_at', $now->month)
            ->whereYear('created_at', $now->year)
            ->sum('price');

        $lastMonth = \App\Models\Transaction::where('status', 'paid')
            ->whereMonth('created_at', $now->subMonth()->month)
            ->whereYear('created_at', $now->year)
            ->sum('price');

        $revenueGrowth = $lastMonth > 0 
            ? (($thisMonth - $lastMonth) / $lastMonth) * 100 
            : 0;
        $publishedCourses = Course::where('is_published', true)->count();
        $allCourses = Course::count();
        $now = Carbon::now();
        $allStudents = User::role('student')->count();
        $thisMonthStudents = User::role('student')
            ->whereMonth('created_at', $now->month)
            ->whereYear('created_at', $now->year)
            ->count();
        $lastMonthStudents = User::role('student')
            ->whereMonth('created_at', $now->copy()->subMonth()->month)
            ->whereYear('created_at', $now->year)
            ->count();
        $studentGrowth = $thisMonthStudents - $lastMonthStudents;
        $allInstructors = User::role('instructor')->count();
        $thisMonthInstructors = User::role('instructor')
            ->whereMonth('created_at', $now->month)
            ->whereYear('created_at', $now->year)
            ->count();
        $lastMonthInstructors = User::role('instructor')
            ->whereMonth('created_at', $now->copy()->subMonth()->month)
            ->whereYear('created_at', $now->year)
            ->count();
        $instructorGrowth = $thisMonthInstructors - $lastMonthInstructors;
        $revenue = DB::table('transactions')
            ->select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('SUM(price) as total')
            )
            ->whereYear('created_at', Carbon::now()->year)
            ->where('status', 'paid')
            ->groupBy('month')
            ->orderBy('month')
            ->get();
        $revenueChartLabels = $revenue->pluck('month')->map(function ($m) {
            return Carbon::create()->month($m)->format('M');
        });
        $revenueChartData = $revenue->pluck('total');
        $totalEnrollments = DB::table('enrollments')->count();
        $completed = DB::table('enrollments as ce')
            ->join('course_contents as cc', 'cc.course_id', '=', 'ce.course_id')
            ->leftJoin('course_progress as cp', function ($join) {
                $join->on('cp.course_content_id', '=', 'cc.id')
                    ->on('cp.student_id', '=', 'ce.student_id');
            })
            ->select('ce.student_id', 'ce.course_id',
                DB::raw('COUNT(cc.id) as total_contents'),
                DB::raw('SUM(CASE WHEN cp.is_completed = true THEN 1 ELSE 0 END) as completed_contents')
            )
            ->groupBy('ce.student_id', 'ce.course_id')
            ->havingRaw('total_contents = completed_contents')
            ->get()
            ->count();
        $ongoing = $totalEnrollments - $completed;
        $data = [
            'labels' => ['Selesai', 'Sedang dipelajari'],
            'values' => [$completed, $ongoing]
        ];
        $popularInstructors = User::role('instructor')
        ->withCount(['courses', 'courses as total_students' => function ($q) {
            $q->join('enrollments', 'courses.id', '=', 'enrollments.course_id');
        }])
        ->orderByDesc('total_students')
        ->take(7)
        ->get();
        $latestCourses = Course::with('teacher')->latest()->take(6)->get();
        $latestStudentActivities = Activity::whereHasMorph(
            'causer', 
            [User::class],
            function ($q) {
                $q->whereHas('roles', fn($r) => $r->where('name', 'student'));
            }
        )
        ->latest() 
        ->take(4)
        ->get();
        return view('admin.dashboard', compact(
            ["thisMonth", "lastMonth", "revenueGrowth", "publishedCourses", "allCourses", "allStudents", "studentGrowth", "allInstructors", "instructorGrowth",
            "revenueChartLabels", "revenueChartData", "data", "completed", "ongoing", "popularInstructors", "latestCourses", "latestStudentActivities"]
        ));
    }
}
