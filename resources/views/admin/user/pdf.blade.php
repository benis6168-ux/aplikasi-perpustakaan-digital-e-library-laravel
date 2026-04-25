<h3>Data User</h3>

<table border="1" width="100%">
<tr>
    <th>Username</th>
    <th>Email</th>
    <th>Role</th>
</tr>

@foreach($users as $u)
<tr>
    <td>{{ $u->username }}</td>
    <td>{{ $u->email }}</td>
    <td>{{ $u->role }}</td>
</tr>
@endforeach
</table>
