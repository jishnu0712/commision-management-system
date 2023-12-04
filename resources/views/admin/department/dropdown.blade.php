<option value="">Select Department</option>
@foreach ($departments as $department)
    <option value="{{ $department->department_id }}">{{ $department->dept_name }} -
        {{ intval($department->percentage) }}%</option>
@endforeach
