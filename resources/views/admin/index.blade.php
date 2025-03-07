<tbody>
@foreach ($data as $employee)
    <tr class="border-b">
        <td class="p-3">{{ $employee['first_name'] ?? 'N/A' }} {{ $employee['last_name'] ?? '' }}</td>
        <td class="p-3">{{ $employee['email'] ?? 'N/A' }}</td>
        <td class="p-3">{{ $employee['gender'] ?? 'N/A' }}</td>
        <td class="p-3">{{ $employee['birth_date'] ?? 'N/A' }}</td>
        <td class="p-3">{{ $employee['contact'] ?? 'N/A' }}</td>
        <td class="p-3">{{ $employee['job_position'] ?? 'N/A' }}</td>
        <td class="p-3">{{ $employee['salary'] ?? 'N/A' }}</td>
        <td class="p-3">{{ $employee['department'] ?? 'N/A' }}</td>
        <td class="p-3"> 
            <a href="/test/{{ $employee['id'] }}"> {{ $employee['id'] ?? 'N/A' }} </a>
        </td>
    </tr>
@endforeach
</tbody>