<?php

namespace App\Models;

use Eloquent;

class TimeTableRecord extends Eloquent
{
    protected $fillable = ['name', 'my_class_id', 'exam_id', 'year', 'school_branch_id'];

    public function my_class()
    {
        return $this->belongsTo(MyClass::class);
    }

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function schoolBranch()
    {
        return $this->belongsTo(SchoolBranch::class, 'school_branch_id');
    }

    public function timeTables()
    {
        return $this->hasMany(TimeTable::class, 'ttr_id');
    }

    public function timeSlots()
    {
        return $this->hasMany(TimeSlot::class, 'ttr_id');
    }
}

class TimeTable extends Eloquent
{
    protected $fillable = ['ttr_id', 'subject_id', 'exam_date', 'day', 'ts_id', 'timestamp_from', 'timestamp_to'];

    public function timeTableRecord()
    {
        return $this->belongsTo(TimeTableRecord::class, 'ttr_id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function timeSlot()
    {
        return $this->belongsTo(TimeSlot::class, 'ts_id');
    }
}

class TimeSlot extends Eloquent
{
    protected $fillable = ['ttr_id', 'name', 'time_from', 'time_to', 'timestamp_from', 'timestamp_to', 'full'];

    public function timeTableRecord()
    {
        return $this->belongsTo(TimeTableRecord::class, 'ttr_id');
    }

    public function timeTables()
    {
        return $this->hasMany(TimeTable::class, 'ts_id');
    }
}
