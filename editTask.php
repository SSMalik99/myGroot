<?php
    if(isset($_POST['editThisTask'])):
        $taskId=$_POST['taskId'];
        $taskTitle=strtolower($_POST['teskTitle']);
        $taskDisc=strtolower($_POST['taskDisc']);
        $taskCategory=strtolower($_POST['taskCategory']);
        $taskCategoryObj=new taskCategoryQuery(); #this is the object to get the category of the task
        $dbObj=new dbConnection();#this will connect to the Database
        $dbObj->connectDb();
        $taskCategoryObj->selectWithCatName($taskCategory);#method to selec any category Id from the category Name
        // var_dump($taskCategoryObj->myQuery);
        $taskCategoryResult=mysqli_query($dbObj->con,$taskCategoryObj->myQuery);#Save the the result of category Id
        // var_dump($taskCategoryResult);
        $taskCategoryResultRow=$taskCategoryResult->fetch_assoc();#fetch the row
        $finalTaskCategory=$taskCategoryResultRow['categoryId'];
        // var_dump($finalTaskCategory);#define category id to save in the database
        $taskQueryObj=new createTaskQuery();#this wil creart an object for the user task table to for the CRUD on Tasks
        $taskQueryObj->updateTask($taskId,$taskTitle,$taskDisc,$finalTaskCategory);
        $success=mysqli_query($dbObj->con,$taskQueryObj->myQuery);
        if($success):
?>
        <div class="alert alert-success">
            Task is Updated SuccessFully!
        </div>
        <?php else: ?>
        <div class="alert alert-danger">
            We are unable to do this task! please Try Again.
        </div>
        <?php endif; ?>

<?php
    endif;
?>