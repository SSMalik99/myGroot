<?php

// THis is for adding new user role for the newer user 

$con = mysqli_connect('localhost', 'root', '', 'usermanagement');
$query = "SELECT * FROM `rolecategories`;";
$result = mysqli_query($con, $query);

if (isset($_POST['addRole'])) :
    $newRole = $_POST['newRole'];
    if(!empty($newRole)):
        $query2 = "INSERT INTO `usermanagement`.`rolecategories` (`roleCategory`) VALUES ('$newRole');";
        $updateResult = mysqli_query($con, $query2);
        // var_dump($updateResult);
        if ($updateResult) :
    ?>
            <div class="alert alert-success" role="alert">
            Role added successfully.
            </div>
        <?php else: ?>
            <div class="alert alert-danger" role="alert">
            Role already exists!
            </div>

        <?php endif; ?>
    <?php else: ?>
        <div class="alert alert-warning" role="alert">
            please enter valid User Role
        </div>
<?php endif; endif; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Document</title>
</head>

<body>
    <div class="container">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">roleId</th>
                    <th scope="col">roleCategory</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) : ?>
                    <tr>
                        <th scope="row"><?php echo $row['roleId']; ?></th>
                        <td><?php echo $row['roleCategory']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <form action="" method="POST">
            <input type="text" name="newRole" id="newRole" placeholder="enter new role">
            <button class="btn btn-warning" name="addRole">ADD</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js" integrity="sha384-SR1sx49pcuLnqZUnnPwx6FCym0wLsk5JZuNx2bPPENzswTNFaQU1RDvt3wT4gWFG" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js" integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc" crossorigin="anonymous"></script>
</body>

</html>