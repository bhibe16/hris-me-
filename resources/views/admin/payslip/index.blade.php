
<div class="container">
    <h2 class="text-xl font-bold mb-4">Employee Payslips</h2>

    @if(session('error'))
        <div class="text-red-500">{{ session('error') }}</div>
    @endif

    <div class="overflow-x-auto">
        <table class="table-auto w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border px-4 py-2">Employee Name</th>
                    <th class="border px-4 py-2">Pay Period</th>
                    <th class="border px-4 py-2">Payment Date</th>
                    <th class="border px-4 py-2">Base Salary</th>
                    <th class="border px-4 py-2">Overtime</th>
                    <th class="border px-4 py-2">Bonuses</th>
                    <th class="border px-4 py-2">Gross Earnings</th>
                    <th class="border px-4 py-2">Deductions</th>
                    <th class="border px-4 py-2">Net Pay</th>
                    <th class="border px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($payslips as $payslip)
                <tr>
                    <td class="border px-4 py-2">{{ $payslip['employee_name'] }}</td>
                    <td class="border px-4 py-2">{{ ucfirst($payslip['pay_period']) }}</td>
                    <td class="border px-4 py-2">{{ date('F d, Y', strtotime($payslip['payment_date'])) }}</td>
                    <td class="border px-4 py-2">{{ number_format($payslip['base_salary'], 2) }}</td>
                    <td class="border px-4 py-2">{{ number_format($payslip['overtime'], 2) }}</td>
                    <td class="border px-4 py-2">{{ number_format($payslip['bonuses'], 2) }}</td>
                    <td class="border px-4 py-2 font-bold">{{ number_format($payslip['gross_earnings'], 2) }}</td>
                    <td class="border px-4 py-2">{{ number_format($payslip['total_deductions'], 2) }}</td>
                    <td class="border px-4 py-2 font-bold">{{ number_format($payslip['net_pay'], 2) }}</td>
                    <td class="border px-4 py-2">
                        <a href="#" class="text-blue-500">View</a> |
                        <a href="#" class="text-green-500">Download</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

