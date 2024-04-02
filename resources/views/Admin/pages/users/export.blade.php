<table>
    <thead>
    <tr>
        <th>Name</th>
        <th>Phone</th>
        <th>Gender</th>
        <th>Birth Date</th>
        <th>Country</th>
        <th>City</th>
        <th>Area</th>
    </tr>
    </thead>
    <tbody>
    @foreach($users as $user)
        <tr>
            <td>{{ $user->name}}</td>
            <td>{{ $user->phone}}</td>
            <td>{{ $user->gender}}</td>
            <td>{{ $user->birth_date}}</td>
            <td>{{ $user->country->name ?? 'null'}}</td>
            <td>{{ $user->city->name ?? 'null'}}</td>
            <td>{{ $user->area->name ?? 'null'}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
