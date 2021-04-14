<?php
    #this file of php contain all the classes require for the change inside the user intefaces.
    include_once('db.php');

    class userChange{
        public static function handleAnyQuery($con,$query){
            $result=mysqli_query($con,$query);
            return $result;
        }
        public $makeChange;
        public function allowToChange($con,$query){
            $table=mysqli_query($con,$query);
            $row=$table->fetch_assoc();
            if($row['userRole']!="admin" && $row['userRole']!="manager"){
                $this->makeChange=TRUE;
                return $this->makeChange;
            }else{
                $this->makeChange=FALSE;
                return $this->makeChange;
            }
        }
        public static function makeTaskCompleted($taskId){
            $dbObj=new dbConnection();
            $userTaskObj=new createTaskQuery();
            $dbObj->connectDb();
            $userTaskObj->completeTask($taskId);
            $result=mysqli_query($dbObj->con,$userTaskObj->myQuery);
            $success=FALSE;
            if($result){
                $success=TRUE;
            }
            return $success;
        }
        public static function anyUserInformation($incomingUserId){
            $userId=$incomingUserId;
            $dbObj=new dbConnection();
            $userDataObj=new createDataQuery();
            $dbObj->connectDb();
            $userDataObj->userCompleteInformation($userId);
            $dataResult=mysqli_query($dbObj->con,$userDataObj->myQuery);
            $userDataRow=$dataResult->fetch_assoc();
            $dbObj->dissconnectDb();
            // var_dump($userDataRow);
            return $userDataRow;
        }
        public static function taskAllValue($incomingTaskId){
            #method to show all the task related to userId
            $taskId=$incomingTaskId;
            $dbObj=new dbConnection();
            $taskObj=new createTaskQuery();
            $dbObj->connectDb();
            $taskObj->taskCompleteInfo($taskId);
            $taskValueResult=mysqli_query($dbObj->con,$taskObj->myQuery);
            $taskValueRow=$taskValueResult->fetch_assoc();
            return $taskValueRow;
        }
        public static function userAllTask($incomingUserId){
            #method to show all the task related to userId
            $userId=$incomingUserId;
            $dbObj=new dbConnection();
            $userTasks=new createTaskQuery();
            $dbObj->connectDb();
            $userTasks->selectTaskWithUserId($userId);
            $userTasksResult=mysqli_query($dbObj->con,$userTasks->myQuery);
            return $userTasksResult;
        }
        public static function deleteAnyTask($taskId){
            #This method will delete any specific task by using its taskId
            $dbObj=new dbConnection();
            $queryObj=new createTaskQuery();
            $dbObj->connectDb();
            $queryObj->deleteTask($taskId);
            $result=userChange::handleAnyQuery($dbObj->con,$queryObj->myQuery);
            $dbObj->dissconnectDb();
            $success=FALSE;
            if($result){
                $success=TRUE;
            }
            return $success;
        }
        public static function reAssigningTask($taskId){
            $dbObj=new dbConnection();
            $queryObj=new createTaskQuery();
            $dbObj->connectDb();
            $queryObj->reassignTask($taskId);
            $result=userChange::handleAnyQuery($dbObj->con,$queryObj->myQuery);
            $success=FALSE;
            if($result){
                $success=TRUE;
            }
            return $success;
        }

    }
    //handle website members log in
    class handleUsers{
        
        public function loginUser($table,$email,$password){
            if($table){
                $result='Wrong Credentials';
                $valid=FALSE;
                session_start();
                while($row=$table->fetch_assoc()){
                    if($row['userEmail']==$email){
                        $dbObj=new dbConnection();
                        $roleObj=new UserRoleQuery();
                        $dbObj->connectDb();
                        $roleObj->selectWithRoleId($row['roleId']);
                        $roleTableResult=mysqli_query($dbObj->con,$roleObj->myQuery);
                        $rowRoleTable=$roleTableResult->fetch_assoc();
                        if($rowRoleTable['roleCategory']=="admin"){
                            if($row['userPassword']==$password){
                                $_SESSION['userRole']=$rowRoleTable['roleCategory'];
                                $_SESSION['userId']=$row['userId'];
                                $result="Location:mainInterface.php?home=true";
                                $valid=TRUE;
                            }else{
                                $result="Please Enter a Valid Password";
                                $valid=FALSE;
                            }
                        }elseif($rowRoleTable['roleCategory']=="manager"){
                            if($row['userPassword']==$password){
                                if($row['valid']=="yes"){
                                    $_SESSION['userRole']=$rowRoleTable['roleCategory'];
                                    $_SESSION['userId']=$row['userId'];
                                    $result="Location:managerInterface.php?home=true";
                                    $valid=TRUE;
                                }else{
                                    $result = "Your account is not approved!";
                                    $valid=FALSE;
                                }
                            }else{
                                $result="Please Enter a Valid Password";
                                $valid=FALSE;
                            }
                        }elseif($rowRoleTable['roleCategory']!="admin" && $rowRoleTable['roleCategory']!="manager"){
                            if($row['userPassword']==$password){
                                if($row['valid']=="yes"){
                                    $_SESSION['userId']=$row['userId'];
                                    $_SESSION['userRole']=$rowRoleTable['roleCategory'];
                                    $result="Location:staffInterface.php?home=true";
                                    $valid=TRUE;
                                }else{
                                    $result = "Your account is not approved!";
                                    $valid=FALSE;
                                }
                            }else{
                                $result="Please Enter a Valid Password";
                                $valid=FALSE;
                            }
                        }
                    }
                }
                return array($valid,$result);
            }
        }
    }
    // echo 'allclasses is working perfectly'
?>
