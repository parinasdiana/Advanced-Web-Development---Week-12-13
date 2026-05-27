<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Profile Picture & Paging</title>
</head>
<style>
    body {
        font-family: Arial, sans-serif;
        margin: 10px;
        display: flex;
        flex-direction: column;
        padding: 50px;
    }
    h1 {
        color: #000;
        text-align: center;
        margin-top: 50px;
    }
    h2 {
        color: #000;
        margin-top: 70px;
        font-size: 24px;
    }
    form {
        margin: 20px;
        padding: 5px;
        justify-content: center;
    }
    label {
        font-weight: bold;
    }
    input {
        padding: 5px;
        margin: 5px 0;
        width: 20%;
        border: 1px solid #050383;
        border-radius: 3px;
    }
    button {
        padding: 8px 15px;
        background-color: #072881;
        color: #fff;
        border: none;
        cursor: pointer;
        border-radius: 3px;
    }
    button:hover {
        background-color: #003dc1;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        border: 2px solid #ccc;
    }
    th, td {
        border: 1px solid #ccc;
        padding: 10px;
        text-align: left;
    }
    th {
        background-color: #f4f4f4;
    }
    img {
        border-radius: 50%;
    }
    .pagination {
        margin-top: 15px;
    }
    .pagination a {
        margin: 0 5px;
        padding: 5px 10px;
        border: 1px solid #ccc;
        text-decoration: none;
        color: #333;
    }
    .pagination a.active {
        background-color: #333;
        color: #fff;
    }
</style>
<body>
    <h1>Upload User Profile</h1>
    
    <form action="<?= base_url('users/upload') ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>
        
        <label>Name:</label>
        <input type="text" name="name" required><br><br>
        
        <label>Profile Picture:</label>
        <input type="file" name="avatar" required><br><br>
        
        <button type="submit">Upload Profile</button>
    </form>

    <hr>

    <h2>Users List</h2>
    <form action="<?= base_url('users') ?>" method="get">
        <input type="text" name="search" placeholder="Search by name..." value="<?= esc($search ?? '') ?>">
        <button type="submit">Search</button>
    </form>
    <br>

    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Avatar</th>
        </tr>
        <?php if(!empty($users)): ?>
            <?php foreach ($users as $user): ?>
            <tr>
                <td><?= esc($user['id']) ?></td>
                <td><?= esc($user['name']) ?></td>
                <td>
                    <img src="<?= base_url('uploads/' . esc($user['avatar'])) ?>" width="60" alt="Avatar">
                </td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="3">No users found.</td></tr>
        <?php endif; ?>
    </table>

    <div style="margin-top: 15px;">
        <?= $pager->links() ?>
    </div>

</body>
</html>