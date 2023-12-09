<style>
    body {
        font-family: Arial, sans-serif;
        margin: 20px;
    }

    #doctors-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    #doctors-table th,
    #doctors-table td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }

    #doctors-table th {
        background-color: #f2f2f2;
    }

    #doctors-table tbody tr:nth-child(even) {
        background-color: #f9f9f9;
    }
</style>

<table id="doctors-table" class="table table-striped table-hover">
    <thead class="thead-light">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Mobile</th>
            <th>Email</th>
            <th>Address</th>
            <th>Specialization</th>
            <th>Hospital Name</th>
            <th>Date Time</th>
        </tr>
    </thead>
    <tbody id="sortable_art">
        @foreach ($doctors as $key => $doctor)
        <tr>
            <td data-title="Sl No">
                {{ $key + 1 }}
            </td>
            <td data-title="name">{{ $doctor['name'] }}</td>
            <td data-title="mobile">
                {{ $doctor['mobile'] }}
            </td>
            <td data-title="email">
                {{ $doctor['email'] }}
            </td>
            <td>
                {{ $doctor['address'] }}
            </td>
            <td>
                {{ $doctor['specialization'] }}
            </td>
            <td>
                {{ $doctor['hospital_name'] }}
            </td>
            <td data-title="Date Time">
                {{ date('d/m/Y h:i a', strtotime($doctor['created_at'])) }}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<script>
    window.print()
</script>