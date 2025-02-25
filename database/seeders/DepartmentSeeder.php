<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;
use App\Models\Position;

class DepartmentSeeder extends Seeder {
    public function run(): void {
        $departments = [
            'Purchasing' => ['Purchasing Manager', 'Procurement Specialist', 'Buyer', 'Sourcing Analyst', 'Vendor Relations Coordinator'],
            'Sales' => ['Sales Manager', 'Account Executive', 'Business Development Representative', 'Sales Associate', 'Key Account Manager'],
            'Marketing' => ['Marketing Manager', 'Digital Marketing Specialist', 'Brand Manager', 'Social Media Manager', 'Market Research Analyst'],
            'Merchandising' => ['Merchandising Manager', 'Visual Merchandiser', 'Product Manager', 'Category Manager', 'Retail Merchandiser'],
            'Inventory Management' => ['Inventory Control Manager', 'Stock Analyst', 'Warehouse Coordinator', 'Supply Chain Analyst', 'Inventory Planner'],
            'Finance' => ['Finance Manager', 'Accountant', 'Financial Analyst', 'Accounts Payable/Receivable Specialist', 'Payroll Specialist'],
            'Human Resources' => ['HR Manager', 'Talent Acquisition Specialist', 'Training & Development Officer', 'Compensation & Benefits Analyst', 'HR Generalist'],
            'Customer Service' => ['Customer Service Manager', 'Call Center Representative', 'Customer Support Specialist', 'Client Relations Coordinator', 'Technical Support Representative'],
            'IT (Information Technology)' => ['IT Manager', 'Software Developer', 'Network Administrator', 'Cybersecurity Analyst', 'IT Support Specialist'],
            'Logistics' => ['Logistics Manager', 'Supply Chain Coordinator', 'Transportation Analyst', 'Warehouse Supervisor', 'Fleet Manager']
        ];

        foreach ($departments as $deptName => $positions) {
            $department = Department::create(['name' => $deptName]);

            foreach ($positions as $position) {
                Position::create([
                    'name' => $position,
                    'department_id' => $department->id
                ]);
            }
        }
    }
}

