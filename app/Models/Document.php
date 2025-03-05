<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'user_id',
        'first_name',
        'last_name',
        'document_type',
        'file_path',
        'status',
        'rejection_comment'
    ];

    const DOCUMENT_TYPES = [
        'personal_identification' => [
            'birth_certificate' => 'Birth Certificate',
            'government_id' => 'Government-issued ID (Passport, Driver’s License, etc.)',
            'tin_sss_pagibig_philhealth' => 'TIN / SSS / Pag-IBIG / PhilHealth',
        ],
        'pre_employment' => [
            'nbi_clearance' => 'NBI Clearance',
            'barangay_clearance' => 'Barangay Clearance',
            'police_clearance' => 'Police Clearance',
            'medical_certificate' => 'Medical Certificate',
            'drug_test_result' => 'Drug Test Result',
        ],
        'employment_and_work_related' => [
            'resume' => 'Resume / CV',
            'diploma_tor' => 'Diploma / Transcript of Records',
            'certificate_of_employment' => 'Certificate of Employment (COE)',
            'training_certificates' => 'Training Certificates',
            'employment_contract' => 'Employment Contract',
        ],
        'company_specific' => [
            'atm_payroll' => 'ATM Account for Payroll',
            'company_id' => 'Company ID',
        ],
    ];

    // ✅ Relationship with User (Using `user_id` as a string)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id'); // Ensure correct key mapping
    }

    // ✅ Relationship with Employee
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'user_id', 'user_id'); // Match user_id from employees
    }
}

