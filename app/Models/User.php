<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'role', 'status', 'phoneNumber', 'address', 
        'profilePic', 'coverPic', 'created_at', 'updated_at', 'password'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // ✅ Define relationship with Employee
    public function employee()
    {
        return $this->hasOne(Employee::class, 'user_id');
    }

    // ✅ Define relationship with Employment History
    public function employmentHistory()
    {
        return $this->hasMany(EmploymentHistory::class, 'user_id');
    }

    // ✅ Define relationship with Documents
    public function documents()
    {
        return $this->hasMany(Document::class, 'user_id');
    }

    // ✅ Automatically Generate `user_id` Starting from 0001
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            $lastUser = self::latest('id')->first();
            $user->user_id = $lastUser ? str_pad($lastUser->user_id + 1, 5, '0', STR_PAD_LEFT) : '00001';
        });

        static::updating(function ($user) {
            // ✅ Update email in Employee model (including soft-deleted records)
            Employee::withTrashed()->where('user_id', $user->user_id)->update(['email' => $user->email]);
        });

        static::deleting(function ($user) {
            // ✅ Delete Employment History Records
            $user->employmentHistory()->delete();

            // ✅ Delete Employee Record
            if ($user->employee) {
                $user->employee->delete();
            }

            // ✅ Delete Documents (Including File Storage)
            foreach ($user->documents as $document) {
                if ($document->file_path) {
                    Storage::delete('public/' . $document->file_path); // Delete stored file
                }
                $document->delete(); // Delete database record
            }
        });
    }
}
