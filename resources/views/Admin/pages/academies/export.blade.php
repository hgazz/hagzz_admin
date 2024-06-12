<table>
    <thead>
    <tr>
        <th>ID</th>
        <th>Email</th>
        <th>Phone</th>
        <th>status</th>
        <th>role</th>
        <th>commercial_name</th>
        <th>trade_license_number</th>
        <th>trade_license_expire_date</th>
        <th>tax_number</th>
        <th>percentage</th>
        <th>contract_number</th>
        <th>account_manager</th>
        <th>is_registered</th>
        <th>branch_to</th>
        <th>Country</th>
        <th>City</th>
        <th>Area</th>
        <th>Sports</th>



    </tr>
    </thead>
    <tbody>
    @foreach($academies as $academy)
        <tr>
            <td>{{ $academy->id }}</td>
            <td>{{ $academy->email }}</td>
            <td>{{ $academy->phone }}</td>
            <td>{{ $academy->status }}</td>
            <td>{{ $academy->role }}</td>
            <td>{{ $academy->commercial_name }}</td>
            <td>{{ $academy->trade_license_number }}</td>
            <td>{{ $academy->trade_license_expire_date }}</td>
            <td>{{ $academy->tax_number }}</td>
            <td>{{ $academy->percentage }}</td>
            <td>{{ $academy->contract_number }}</td>
            <td>{{ $academy->account_manager }}</td>
            <td>{{ $academy->is_registered }}</td>
            <td>{{ $academy->academy->commercial_name ?? 'null' }}</td>
            <td>{{ $academy->county->name ?? 'null' }}</td>
            <td>{{ $academy->city->name ?? 'null' }}
            <td>{{ $academy->area->name ?? 'null' }}</td>
            <td>{{ $academy->sports->pluck('name')->implode(', ') }}</td>

        </tr>
    @endforeach
    </tbody>
</table>
