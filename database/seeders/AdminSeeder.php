<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Employee;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        $employees = [
            [
                'name' => 'Sana Minatozaki',
                'email' => 'emp1@gmail.com',
                'password' => Hash::make('emp1@gmail.com'),
                'role' => 'employee',
                'employee_details' => [
                    'first_name' => 'Sana',
                    'last_name' => 'Minatozaki',
                    'middle_name' => 'A',
                    'phone' => '1234567890',
                    'address' => '123 Main St',
                    'date_of_birth' => '1990-01-01',
                    'gender' => 'Female',
                    'nationality' => 'Japanese',
                    'marital_status' => 'Single',
                    'start_date' => '2023-01-01',
                    'end_date' => '2024-01-01',
                    'employment_status' => 'Active',
                ],
            ],
            [
                'name' => 'Jihyo Park',
                'email' => 'emp2@gmail.com',
                'password' => Hash::make('emp2@gmail.com'),
                'role' => 'employee',
                'employee_details' => [
                    'first_name' => 'Jihyo',
                    'last_name' => 'Park',
                    'middle_name' => 'B',
                    'phone' => '9876543210',
                    'address' => '456 Elm St',
                    'date_of_birth' => '1985-05-15',
                    'gender' => 'Female',
                    'nationality' => 'Korean',
                    'marital_status' => 'Married',
                    'start_date' => '2020-06-15',
                    'end_date' => '2024-01-01',
                    'employment_status' => 'Active',
                ],
            ],
            [
                'name' => 'Momo Hirai',
                'email' => 'emp3@gmail.com',
                'password' => Hash::make('emp3@gmail.com'),
                'role' => 'employee',
                'employee_details' => [
                    'first_name' => 'Momo',
                    'last_name' => 'Hirai',
                    'middle_name' => 'B',
                    'phone' => '0977655451',
                    'address' => '123 Main St',
                    'date_of_birth' => '1990-01-01',
                    'gender' => 'Female',
                    'nationality' => 'Japanese',
                    'marital_status' => 'Single',
                    'start_date' => '2023-01-01',
                    'end_date' => '2024-01-01',
                    'employment_status' => 'Active',
                ],
            ],
            [
                'name' => 'Nayeon Im',
                'email' => 'emp4@gmail.com',
                'password' => Hash::make('emp4@gmail.com'),
                'role' => 'employee',
                'employee_details' => [
                    'first_name' => 'Nayeon',
                    'last_name' => 'Im',
                    'middle_name' => 'C',
                    'phone' => '1234567890',
                    'address' => '789 Pine St',
                    'date_of_birth' => '1995-09-22',
                    'gender' => 'Female',
                    'nationality' => 'Korean',
                    'marital_status' => 'Single',
                    'start_date' => '2023-02-01',
                    'end_date' => '2024-01-01',
                    'employment_status' => 'Active',
                ],
            ],
            [
                'name' => 'Jeongyeon Yoo',
                'email' => 'emp5@gmail.com',
                'password' => Hash::make('emp5@gmail.com'),
                'role' => 'employee',
                'employee_details' => [
                    'first_name' => 'Jeongyeon',
                    'last_name' => 'Yoo',
                    'middle_name' => 'D',
                    'phone' => '0987654321',
                    'address' => '456 Maple St',
                    'date_of_birth' => '1996-11-01',
                    'gender' => 'Female',
                    'nationality' => 'Korean',
                    'marital_status' => 'Single',
                    'start_date' => '2022-03-15',
                    'end_date' => '2024-01-01',
                    'employment_status' => 'Active',
                ],
            ],
            [
                'name' => 'Mina Myoui',
                'email' => 'emp6@gmail.com',
                'password' => Hash::make('emp6@gmail.com'),
                'role' => 'employee',
                'employee_details' => [
                    'first_name' => 'Mina',
                    'last_name' => 'Myoui',
                    'middle_name' => 'E',
                    'phone' => '1230987654',
                    'address' => '789 Oak St',
                    'date_of_birth' => '1996-03-24',
                    'gender' => 'Female',
                    'nationality' => 'Japanese',
                    'marital_status' => 'Single',
                    'start_date' => '2023-05-01',
                    'end_date' => '2024-01-01',
                    'employment_status' => 'Active',
                ],
            ],
            [
                'name' => 'Dahyun Kim',
                'email' => 'emp7@gmail.com',
                'password' => Hash::make('emp7@gmail.com'),
                'role' => 'employee',
                'employee_details' => [
                    'first_name' => 'Dahyun',
                    'last_name' => 'Kim',
                    'phone' => '4561230987',
                    'address' => '101 Birch St',
                    'date_of_birth' => '1998-05-28',
                    'gender' => 'Female',
                    'nationality' => 'Korean',
                    'marital_status' => 'Single',
                    'start_date' => '2022-07-01',
                    'end_date' => '2024-01-01',
                    'employment_status' => 'Active',
                ],
            ],
            [
                'name' => 'Chaeyoung Son',
                'email' => 'emp8@gmail.com',
                'password' => Hash::make('emp8@gmail.com'),
                'role' => 'employee',
                'employee_details' => [
                    'first_name' => 'Chaeyoung',
                    'last_name' => 'Son',
                    'middle_name' => 'G',
                    'phone' => '9870123456',
                    'address' => '202 Cedar St',
                    'date_of_birth' => '1999-08-23',
                    'gender' => 'Female',
                    'nationality' => 'Korean',
                    'marital_status' => 'Single',
                    'start_date' => '2021-09-12',
                    'end_date' => '2024-01-01',
                    'employment_status' => 'Active',
                ],
            ],
            [
                'name' => 'Tzuyu Chou',
                'email' => 'emp9@gmail.com',
                'password' => Hash::make('emp9@gmail.com'),
                'role' => 'employee',
                'employee_details' => [
                    'first_name' => 'Tzuyu',
                    'last_name' => 'Chou',
                    'middle_name' => 'H',
                    'phone' => '3456789012',
                    'address' => '303 Pine St',
                    'date_of_birth' => '1999-06-14',
                    'gender' => 'Female',
                    'nationality' => 'Taiwanese',
                    'marital_status' => 'Single',
                    'start_date' => '2023-10-01',
                    'end_date' => '2024-01-01',
                    'employment_status' => 'Active',
                ],
            ],
            // Repeat for email8 and email9 for the next two members
        ];        

        foreach ($employees as $employeeData) {
            $user = User::create([
                'name' => $employeeData['name'],
                'email' => $employeeData['email'],
                'password' => $employeeData['password'],
                'role' => $employeeData['role'],
            ]);

            Employee::create(array_merge($employeeData['employee_details'], [
                'user_id' => $user->user_id,
                'email' => $employeeData['email'],
                'position_id' => rand(1, 25), // Random position between 1-10
                'department_id' => rand(1, 10), // Random department between 1-5
            ]));
        }
    }
}
