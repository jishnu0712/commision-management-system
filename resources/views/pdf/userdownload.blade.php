<style>
    body {
        font-family: Arial, sans-serif;
        margin: 20px;
    }

    #users-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    #users-table th,
    #users-table td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }

    #users-table th {
        background-color: #f2f2f2;
    }

    #users-table tbody tr:nth-child(even) {
        background-color: #f9f9f9;
    }
</style>

<table id="users-table" class="table table-striped table-hover">
    <thead class="thead-light">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Mobile</th>
            <th>Email</th>
            <th>Date Time</th>
        </tr>
    </thead>
    <tbody id="sortable_art">
        @foreach ($users as $key => $user)
        <tr>
            <td data-title="Sl No">
                {{ $key + 1 }}
            </td>
            <td data-title="name">{{ $user['name'] }}</td>
            <td data-title="mobile">
                {{ $user['mobile'] }}
            </td>
            <td data-title="email">
                {{ $user['email'] }}
            </td>
            <td data-title="Date Time">
                {{ CustomHelper::dateFormat('d/m/Y h:i a', $user['created_at']) }}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>