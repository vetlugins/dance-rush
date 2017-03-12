<tr>
    <td><?php echo $user->id ?></td>
    <td><a href="/admin/users/<?php echo $user->id ?>"><?php echo $user->username ?></a></td>
    <td><?php echo $user->email ?></td>
    <td><?php echo $user->logins ?></td>
    <td><?php echo date('Y-m-d H:i:s', $visit->date) ?></td>
</tr>
