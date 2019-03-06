<table class="table">
    <thead class="thead-light">
    <tr>
        <th scope="col">Your Details</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <th scope="row">Avatar</th>
        <td><img class="img-thumbnail w-25" src="/public/uploads/<?=session_get('user_avatar', 'name')?>" alt="avatar">
        </td>
    </tr>
    <tr>
        <th scope="row">First Name</th>
        <td><?=session_get('user_details', 'first_name')?></td>
    </tr>
    <tr>
        <th scope="row">Last Name</th>
        <td><?=session_get('user_details', 'last_name')?></td>
    </tr>
    <tr>
        <th scope="row">Email</th>
        <td><?=session_get('user_details', 'email')?></td>
    </tr>
    </tbody>
</table>

<button class="btn btn-warning text-white mt-5" type="button">Edit details</button>