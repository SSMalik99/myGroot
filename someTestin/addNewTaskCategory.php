<?php

// THis is to define new category for the user---

$con = mysqli_connect('localhost', 'root', '', 'usermanagement');


if (isset($_POST['addTaskCategory'])) :
    $newCategory = strtolower($_POST['newTaskCategory']);
    if(!empty($newCategory)):
        $query2 = "INSERT INTO `usermanagement`.`taskcategories` (`categoryName`) VALUES ('$newCategory');";
        $updateResult = mysqli_query($con, $query2);
        // var_dump($updateResult);
        if ($updateResult) :
    ?>
            <div class="alert alert-success" role="alert">
            Task category added successfully.
            </div>
        <?php else: ?>
            <div class="alert alert-danger" role="alert">
            unable to do this task!
            </div>

    <?php endif; ?>
    <?php else: ?>
        <div class="alert alert-warning" role="alert">
            Please Enter Valid category!
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
                    <th scope="col">categoryId</th>
                    <th scope="col">CategoryName</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $query = "SELECT * FROM `taskcategories`;";
                    $result = mysqli_query($con, $query);
                    while ($row = $result->fetch_assoc()) : ?>
                    <tr>
                        <th scope="row"><?php echo $row['categoryId']; ?></th>
                        <td><?php echo ucFirst($row['categoryName']); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <form action="" method="POST">
            <input type="text" name="newTaskCategory" id="newTaskCategory" placeholder="enter new task Category">
            <button class="btn btn-warning" name="addTaskCategory">ADD</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js" integrity="sha384-SR1sx49pcuLnqZUnnPwx6FCym0wLsk5JZuNx2bPPENzswTNFaQU1RDvt3wT4gWFG" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js" integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc" crossorigin="anonymous"></script>
</body>

</html>