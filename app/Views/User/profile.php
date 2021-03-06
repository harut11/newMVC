<table class="table w-50 mx-auto">
    <thead class="thead-light">
    <tr>
        <th scope="col">Your Details</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <th scope="row">Avatar</th>
        <td><img class="img-thumbnail w-50" src="/public/uploads/<?=$avatar[0]['name']?>" alt="avatar">
        </td>
    </tr>
    <tr>
        <th scope="row">First Name</th>
        <td><?=$user[0]['first_name']?></td>
    </tr>
    <tr>
        <th scope="row">Last Name</th>
        <td><?=$user[0]['last_name']?></td>
    </tr>
    <tr>
        <th scope="row">Email</th>
        <td id="user_email"><?=$user[0]['email']?></td>
    </tr>
    </tbody>
</table>

<div class="editSection w-50 mx-auto mt-5">
    <a href="/editdetails" class="btn btn-warning text-white">Edit details</a>
</div>