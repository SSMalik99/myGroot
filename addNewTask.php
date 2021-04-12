<?php
    if(isset($_POST['addThisTask'])):
        $userId=$_POST['userId'];
        $taskTitle=$_POST['teskTitle'];
        $taskDisc=$_POST['taskDisc'];
        $categoryIdList=$_POST['categoryList'];
        $dbObj=new dbConnection();
        $taskQueryObj=new createTaskQuery();
        foreach ($categoryIdList as $value) {
            $dbObj->connectDb();
            $taskQueryObj->addTaskQuery($userId,$taskTitle,$taskDisc,$value);
            $success=mysqli_query($dbObj->con,$taskQueryObj->myQuery);
            if(!$success):
                ?>
                <div class="alert alert-danger">
                    some Technical issue is occurring! please try again.
                </div>
            <?php    break; 
            else: ?>
                <div class="alert alert-success">
                Task is added SuccssFully
                </div>
<?php  endif;  }
        
    endif;
?>