<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Staff</title>
</head>
<body>
    <h1>Staff</h1>
    <a href="{{ route('admin.staff.create') }}">Add Staff</a>

    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($staff as $staffMember)
                <tr>
                    <td>{{ $staffMember->name }}</td>
                    <td>{{ $staffMember->email }}</td>
                    <td>
                        <a href="{{ route('admin.staff.edit', $staffMember) }}">Edit</a>
                        <form action="{{ route('admin.staff.destroy', $staffMember) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
