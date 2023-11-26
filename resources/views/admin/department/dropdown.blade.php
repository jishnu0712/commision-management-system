<option value="">Select Department</option>
@foreach ($percentages as $percentage)
    <option value="{{ $percentage->department->id }}">{{ $percentage->department->dept_name }} -
        {{ intval($percentage->percentage) }}%</option>
@endforeach
