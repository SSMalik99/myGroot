<?php


if (isset($_POST['updateInfo'])) :
    $userId = $_POST['userId'];
    $userName = strtolower($_POST['userName']);
    $userEmail = strtolower($_POST['userEmail']);
    $userRole = strtolower($_POST['userRole']);
    $userValid = strtolower($_POST['userValid']);
    $dbObj = new dbConnection();
    $dbObj->connectDb();
    $roleQueryObj = new UserRoleQuery();
    $roleQueryObj->selectWithRoleName($userRole);
    // var_dump($roleQueryObj->myQuery);
    $roleValueResult = mysqli_query($dbObj->con, $roleQueryObj->myQuery);
    $roleValueRow = $roleValueResult->fetch_assoc();
    if ($_SESSION['userRole'] == 'manager') :
        if ($userRole != 'admin') :
            $queryObj = new createDataQuery();
            $queryObj->updateInfoQuery($userId, $userName, $userEmail, $roleValueRow['roleId'], $userValid);
            // var_dump($queryObj->myQuery);
            $result = mysqli_query($dbObj->con, $queryObj->myQuery);
            // var_dump($result);
            $dbObj->dissconnectDb();
            if ($result) : ?>
                <div class="alert alert-success" role="alert">
                    User is updated successfully
                </div>
            <?php else : ?>
                <div class="alert alert-danger" role="alert">
                    Sorry! but currently we are not able to do this task!
                </div>
            <?php endif;
        endif;
    elseif ($_SESSION['userRole']) :
        $dbObj = new dbConnection();
        $dbObj->connectDb();
        $queryObj = new createDataQuery();
        $queryObj->updateInfoQuery($userId, $userName, $userEmail, $roleValueRow['roleId'], $userValid);
        $result = mysqli_query($dbObj->con, $queryObj->myQuery);
        // var_dump($queryObj->myQuery);
        $dbObj->dissconnectDb();
        // var_dump($result);
        if ($result) : ?>
            <div class="alert alert-success" role="alert">
                User is updated successfully
            </div>
        <?php else : ?>
            <div class="alert alert-danger" role="alert">
                Sorry! but currently we are not able to do this task!
            </div>
<?php
        endif;
    endif;
endif;
?>


<div>
    <form action="" method="POST" class="container">
        <div class="form-row">
            <input type="hidden" class="form-control" id="userId" value="<?php echo $userId ?>" name="userId" placeholder="User Id">
            <div class="form-group col-md-6">
                <label for="userName">User Name</label>
                <input type="text" class="form-control" id="userName" name="userName" value="<?php echo $userInfo['userName']; ?>" placeholder="Name">
            </div>
            <div class="form-group col-md-6">
                <label for="userEmail">Email</label>
                <input type="email" class="form-control" id="userEmail" name="userEmail" value="<?php echo $userInfo['userEmail']; ?>" placeholder="Email">
            </div>
            <div class="form-group col-md-6">
                <label for="userRole">Your Role</label>
                <input type="text" class="form-control" id="userRole" value="<?php echo $userInfo['roleCategory']; ?>" name="userRole" placeholder="user Role">
            </div>
            <div class="form-group col-md-6">
                <label for="userValid">Approved</label>
                <select name="userValid" id="userValid" class="form-select">
                    <?php if ($userInfo['valid'] == 'yes') : ?>
                        <option value="yes" selected>Approved</option>
                        <option value="no">DisApprove</option>
                    <?php else : ?>
                        <option value="yes">Approved</option>
                        <option value="no" selected>DisApprove</option>
                    <?php endif; ?>
                </select>
                <!-- <input type="text" class="form-control" id="userValid" value="<?php //echo $userInfo['valid']; 
                                                                                    ?>" name="userValid" placeholder="user Role"> -->
            </div>
        </div></br>
        <button type="submit" name="updateInfo" class="btn btn-primary">Update</button>
    </form>
</div>