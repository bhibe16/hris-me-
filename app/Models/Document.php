<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function employee()
    {
        return $this->hasOneThrough(Employee::class, User::class, 'id', 'user_id', 'user_id', 'id');
    }
}

