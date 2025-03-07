<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmploymentHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_name',
        'position',
        'address',
        'start_date',
        'end_date',
        'user_id'];

    // Define the relationship with the User model
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'user_id', 'user_id');
    }
    
}
