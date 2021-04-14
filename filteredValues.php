<?php
if(isset($_POST['filterTask'])):
    $dbObj=new dbConnection();
    $dbObj->connectDb();
    $filterRole=$_POST['filterRole'];
    $filterTaskCategory=$_POST['filterTaskCategory'];
    $table=filterValueFun($dbObj,$filterRole,$filterTaskCategory);
    
endif;
function filterValueFun($dbObj,$filterRole,$filterTaskCategory){
    if(empty($filterRole)):
        if(!empty($filterTaskCategory)):
            $query="SELECT * FROM usertask JOIN taskCategories ON usertask.categoryId=taskCategories.categoryId JOIN workmate ON workmate.userId=userTask.userId JOIN rolecategories ON workmate.roleId=rolecategories.roleId WHERE usertask.categoryId=$filterTaskCategory;";
            $table=mysqli_query($dbObj->con,$query);
        else:
            $query="SELECT * FROM usertask 
            JOIN taskCategories ON usertask.categoryId=taskCategories.categoryId
            JOIN workmate ON usertask.userId=workMate.userId
            JOIN rolecategories ON workmate.roleId=rolecategories.roleId;";
            $table=mysqli_query($dbObj->con,$query);
        endif;
    else:
        if(!empty($filterTaskCategory)):
            $query="SELECT * FROM usertask 
            JOIN workmate ON workmate.userId=usertask.userId
            JOIN taskCategories ON usertask.categoryId=taskCategories.categoryId
            JOIN rolecategories ON workmate.roleId=rolecategories.roleId
            WHERE workmate.roleId=$filterRole;";
            $table=mysqli_query($dbObj->con,$query);
        else:
            $query="SELECT * FROM usertask 
            JOIN workmate ON workmate.userId=usertask.userId
            JOIN taskCategories ON usertask.categoryId=taskCategories.categoryId
            JOIN rolecategories ON workmate.roleId=rolecategories.roleId
            WHERE workmate.roleId=$filterRole AND usertask.categoryId=$filterTaskCategory;";
            $table=mysqli_query($dbObj->con,$query);
        endif;
    endif;
    return $table;
}

?>