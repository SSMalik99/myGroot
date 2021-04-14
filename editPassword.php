<?php
if (isset($_POST['submitUpdatePassword'])) :
    $userId = $_POST['updatingPassword'];
    $password = sha1($_POST['enterUpdatePassword']);
    $confirmPassword = sha1($_POST['confirmEnterUpdatePassword']);
    $dbObj = new dbConnection();
    $dbObj->connectDb();
    $queryObj = new createDataQuery();
    $queryObj->selectWithCond($userId);
    $result1 = mysqli_query($dbObj->con, $queryObj->myQuery);
    $dataRow = $result1->fetch_assoc();
    if ($password == $confirmPassword) :
        if ($dataRow['userPassword'] != $password) :
            $queryObj->updatePassword($userId, $password);
            // var_dump($queryObj->myQuery);
            $result = mysqli_query($dbObj->con, $queryObj->myQuery);
            // var_dump($result);
            if ($result) : ?>
                <div class="alert alert-success" role="alert">
                    Password is updated successfully!
                </div>
            <?php else : ?>
                <div class="alert alert-danger" role="alert">
                    We are not able to do this task!
                </div>
            <?php endif; ?>
        <?php else : ?>
            <div class="alert alert-warning" role="alert">
                In concern of Privacy! New Password is same as the Previous password;
            </div>
        <?php endif;
    else : ?>
        <div class="alert alert-warning" role="alert">
            Confirm password is mismatched! Try Again!
        </div>
<?php endif;
endif;
?>

<div>
    <form action="" method="POST">
        <div class="form-group">
            <input type="hidden" class="form-control" value="<?php echo $userId; ?>" id="updatingPassword" name="updatingPassword">
            <label for="enterUpdatePassword">Enter Password</label>
            <input type="password" class="form-control" id="enterUpdatePassword" name="enterUpdatePassword" placeholder="Enter Password">
        </div>
        <div class="form-group">
            <label for="confirmEnterUpdatePassword">Confirm Password</label>
            <input type="password" class="form-control" name="confirmEnterUpdatePassword" id="confirmEnterUpdatePassword" placeholder=" confirm Password">
        </div>
        <button name="submitUpdatePassword" class="btn btn-primary">Submit</button>
    </form>
</div>