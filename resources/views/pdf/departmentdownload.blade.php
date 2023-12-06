<style>
    body {
        font-family: Arial, sans-serif;
        margin: 20px;
    }

    #departments-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    #departments-table th,
    #departments-table td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }

    #departments-table th {
        background-color: #f2f2f2;
    }

    #departments-table tbody tr:nth-child(even) {
        background-color: #f9f9f9;
    }
</style>

<table id="departments-table" class="table table-striped table-hover">
    <thead class="thead-light">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Description</th>
            <th>Default Commision</th>
            <th>Date Time</th>
        </tr>
    </thead>
    <tbody id="sortable_art">
        @foreach ($departments as $key => $department)
        <tr>
            <td >
                {{ $key + 1 }}
            </td>
            <td >{{ $department['dept_name'] }}</td>
         
            <td>
                {{ $department['description'] }}
            </td>
            <td>
                {{ $department['percentage'] }}
            </td>
            <td>
                {{ date('d/m/Y h:i a', strtotime($department['created_at'])) }}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<script>
    window.print()
</script>