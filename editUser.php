<?php
    
    
    if(isset($_POST['updateInfo'])):
        $userId=$_POST['userId'];
        $userName=strtolower($_POST['userName']);
        $userEmail=strtolower($_POST['userEmail']);
        $userRole=strtolower($_POST['userRole']);
        $userValid=strtolower($_POST['userValid']);
        $userValid=strtolower($userValid);
        $dbObj=new dbConnection();
        $dbObj->connectDb();
        if($_SESSION['userRole']=='manager'):
            if($userRole!='admin'):
                $queryObj=new createDataQuery();
                $queryObj->updateInfoQuery($userId,$userName,$userEmail,$userRole,$userValid);
                // var_dump($queryObj->myQuery);
                $result=mysqli_query($dbObj->con,$queryObj->myQuery);
                // var_dump($result);
                $dbObj->dissconnectDb();
                if($result): ?>
                    <div class="alert alert-success" role="alert">
                        User is updated successfully
                    </div>
          <?php else: ?>
                <div class="alert alert-danger" role="alert">
                    Sorry! but currently we are not able to do this task!
                </div>
        <?php  endif;
            endif;
        elseif($_SESSION['userRole']):
            $dbObj=new dbConnection();
            $dbObj->connectDb();
            $queryObj=new createDataQuery();
            $queryObj->updateInfoQuery($userId,$userName,$userEmail,$userRole,$userValid);
            $result=mysqli_query($dbObj->con,$queryObj->myQuery);
            // var_dump($queryObj->myQuery);
            $dbObj->dissconnectDb();
            // var_dump($result);
            if($result): ?>
                <div class="alert alert-success" role="alert">
                    User is updated successfully
                </div>
        <?php else: ?>
                <div class="alert alert-danger" role="alert">
                Sorry! but currently we are not able to do this task!
            </div>
            <?php
            endif; endif; endif;
?>
