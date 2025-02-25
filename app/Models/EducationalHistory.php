<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EducationalHistory extends Model
{
    use HasFactory;

    // Define the table name (optional, Laravel will use plural form by default)
    protected $table = 'educational_histories';

    // Specify which fields are mass assignable (these will be the fields you want to store)
    protected $fillable = [
        'user_id', 
        'school_name',
        'education_level', // 'Junior High', 'Senior High', or 'Tertiary'
        'start_year',
        'end_year',
        'graduation_status', // 'Completed', 'Not Completed'
        'track_strand', // Only for Senior High
        'program', // Only for College
    ];

    // Define any relationships (optional, if you have relationships with other models)

    // Example: Assuming there's a relationship with a 'User' model (user_id is the foreign key)
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'user_id', 'user_id');
    }
}

