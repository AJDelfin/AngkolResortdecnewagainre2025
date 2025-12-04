<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Staff</title>
</head>
<body>
    <h1>Edit Staff</h1>

    <form action="{{ route('admin.staff.update', $staff) }}" method="POST">
        @csrf
        @method('PUT')
        <div>
            <label for="name">Name</label>
            <input type="text" name="name" id="name" value="{{ $staff->name }}">
        </div>
        <div>
            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="{{ $staff->email }}">
        </div>
        <div>
            <label for="password">Password (leave blank to keep current password)</label>
            <input type="password" name="password" id="password">
        </div>
        <button type="submit">Update Staff</button>
    </form>
</body>
</html>
