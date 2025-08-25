<?php

namespace App\Observers;

use App\Models\CourseContent;

class CourseContentObserver
{
    /**
     * Handle the CourseContent "created" event.
     */
    public function created(CourseContent $courseContent): void
    {
        CourseContent::recalculateGlobalOrder($courseContent->course_id);
    }

    /**
     * Handle the CourseContent "updated" event.
     */
    public function updated(CourseContent $courseContent): void
    {
        CourseContent::recalculateGlobalOrder($courseContent->course_id);
    }

    /**
     * Handle the CourseContent "deleted" event.
     */
    public function deleted(CourseContent $courseContent): void
    {
        CourseContent::recalculateGlobalOrder($courseContent->course_id);
    }

    /**
     * Handle the CourseContent "restored" event.
     */
    public function restored(CourseContent $courseContent): void
    {
        CourseContent::recalculateGlobalOrder($courseContent->course_id);
    }

    /**
     * Handle the CourseContent "force deleted" event.
     */
    public function forceDeleted(CourseContent $courseContent): void
    {
        CourseContent::recalculateGlobalOrder($courseContent->course_id);
    }
}
