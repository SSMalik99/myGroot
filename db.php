<?php
    class dbConnection{
        private $serverName="localhost";  #  this is hostName
        private $userName="root";    # this the user name for the database
        private $userPass="";    #this is the password for the user database  
        private $dbName="usermanagement";    #this is the official name of our database
        public $con = FALSE;
        #this method will try to connect database for the different purposes;
        public function connectDb(){
            try{
                $this->con = mysqli_connect($this->serverName,$this->userName,$this->userPass,$this->dbName);
                // echo "i'm established";
                return $this->con;
            }
            catch(mysqli_sql_exception $error){
                throw $error;
            }
        }
        # this will dissconnect database 
        public function dissconnectDb(){
            $this->con = NULL;
            // echo "i'm disconnected";
            return $this->con;
        }
    }

    class queryClasses{
        # this will contain the methods and varibles common to all other classes in a secret way
        public $myQuery;
        public function selectAllData(){
            //This will select all the Information of the seleted table
            $this->myQuery="SELECT * FROM $this->tableName";
            return $this->myQuery;
        }
        public function userCompleteInformation($userId){
            $this->myQuery="SELECT *
            FROM workmate
            JOIN rolecategories ON workmate.roleId= rolecategories.roleId 
            WHERE workmate.userId=$userId;";
            return $this->myQuery;
        }
        public function taskCompleteInfo($taskId){
            $this->myQuery="SELECT *
            FROM usertask 
            JOIN taskcategories ON usertask.categoryId=taskcategories.categoryId
            JOIN workmate ON usertask.userId=workmate.userId
            JOIN rolecategories on workmate.roleId=rolecategories.roleId
            WHERE usertask.taskId=$taskId;";
            return $this->myQuery;
        }

    }

    class createDataQuery extends queryClasses{#this class will generate queries for the different tasks;
        public $tableName = 'workmate';

        public function selectAllData(){
            //This will select all the Information of the seleted table
            $this->myQuery="SELECT * FROM $this->tableName JOIN roleCategories ON $this->tableName.roleId=rolecategories.roleId;";
            return $this->myQuery;
        }
        //this method will add new user into our database
        public function addUserQuery($name,$email,$password,$roleId,$valid){
            $this->myQuery="INSERT INTO `$this->tableName` (`userName`, `userEmail`, `userPassword`,`roleId`,`valid`) VALUES ('$name', '$email','$password',$roleId,'$valid');";
            return $this->myQuery;
        }
        #select any user on the basis of userId
        public function selectWithCond($condition){
            $this->myQuery="SELECT * FROM $this->tableName WHERE userId=$condition";
            return $this->myQuery;
        }
        public function fetchWithEmail($condition){
            $this->myQuery="SELECT * FROM `$this->tableName` WHERE userEmail='$condition'";
            return $this->myQuery;
        }
        #this method will help end user and admin to change the info the users;
        public function updateInfoQuery($userId,$name,$email,$userRole,$valid){
            $this->myQuery= "UPDATE `usermanagement`.`workmate` SET `userName`='$name', `userEmail`='$email', `roleId`=$userRole, `valid`='$valid' WHERE  `userId`='$userId';";
            return $this->myQuery;
        }
        #this method will help tp change the password of the users;
        public function updatePassword($userId,$userPassword){
            $this->myQuery="UPDATE `$this->tableName` SET `userPassword` = '$userPassword' WHERE `$this->tableName`.`userId` = $userId;";
        }
        #this method will help tp change the Profile Image of the users;
        public function updateProfileImage($userId,$profilePhoto){
            $this->myQuery="UPDATE `usermanagement`.`workmate` SET `userImage`= '$profilePhoto' WHERE  `userId`=$userId;";
        }
        #this will delete an end user from the database
        public function deleteQuery($userId){
            $this->myQuery="DELETE FROM $this->tableName WHERE $this->tableName.`userId`=$userId";
            return $this->myQuery;
        }
        #this method will validate the user
        public function validateQuery($userId){
            $this->myQuery="UPDATE `$this->tableName` SET `valid`='yes' WHERE  `userId`=$userId;";
            return $this->myQuery;
        }
        #this auery can be used to block the user login 
        public function deValidateQuery($userId){
            $this->myQuery="UPDATE `$this->tableName` SET `valid`='no' WHERE  `userId`=$userId;";
            return $this->myQuery;
        }
        public function selectDataWithUserRole($userRole){
            $this->myQuery="SELECT * FROM `$this->tableName` WHERE userRole='$userRole'";
            return $this->myQuery;
        }
    }
    #This class is for the creation of the query for the "usertask" table 
    class createTaskQuery extends queryClasses{
        public $tableName = 'usertask';
        public function selectAllTaskId(){
            $this->myQuery="SELECT taskId FROM $this->tableName";
            return $this->myQuery;
        }
        public function addTaskQuery($userId,$taskTitle,$taskDisc,$categoryId){
            $this->myQuery="INSERT INTO `usermanagement`.`$this->tableName` (`userId`, `taskTitle`, `taskDisc`,`categoryId`) VALUES ('$userId', '$taskTitle', '$taskDisc', '$categoryId');";
            // echo "i'm working Buddy";
            return $this->myQuery;
        }
        #select any user on the basis of userId
        public function selectTaskWithCond($condition){
            $this->myQuery="SELECT * FROM `usermanagement`.`$this->tableName` WHERE taskId=$condition";
            return $this->myQuery;
        }
        public function selectTaskWithUserId($condition){
            $this->myQuery="SELECT * FROM `usermanagement`.`$this->tableName` WHERE userId=$condition";
            return $this->myQuery;
        }
        #this method will help end user and admin to change the info the users;
        public function updateTask($taskId,$taskTitle,$taskDisc,$catId){
            $this->myQuery= "UPDATE `usermanagement`.`$this->tableName` SET `taskTitle`='$taskTitle', `taskDisc`='$taskDisc', `categoryId`='$catId' WHERE  `taskId`='$taskId';";
            return $this->myQuery;
        }
        #this will delete an end user from the database
        public function deleteTask($taskId){
            $this->myQuery="DELETE FROM $this->tableName WHERE $this->tableName.`taskId`=$taskId";
            return $this->myQuery;
        }
        public function reassignTask($taskId){
            $this->myQuery= "UPDATE `usermanagement`.`$this->tableName` SET `taskCompleted`='no' WHERE  `taskId`=$taskId;";
            return $this->myQuery;
        }
        public function completeTask($taskId){
            $this->myQuery= "UPDATE `usermanagement`.`$this->tableName` SET `taskCompleted`='yes' WHERE  `taskId`=$taskId;";
            return $this->myQuery;
        }

        #function to get the distinct value of user ID column from the "usertask" table
        public function getDistinctUserIdTask(){
            $this->myQuery="SELECT DISTINCT userId FROM $this->tableName";
            return $this->myQuery;
        }

        public function getDistinctCategoryIdTask(){
            $this->myQuery="SELECT DISTINCT userId FROM $this->tableName";
            return $this->myQuery;
        }
        
    }
    #this class is for the "taskcategories" table
    class taskCategoryQuery extends queryClasses{
        public $tableName = 'taskcategories';

        public function addNewTaskCategory($catName){
            #method to add new task category
            $this->myQuery="INSERT INTO `usermanagement`.`$this->tableName` (`categoryName`) VALUES ('$catName');";
            return $this->myQuery;
        }

        public function DeleteTaskCategory($catId){
            #method to delete any task category
            $this->myQuery="DELETE FROM $this->tableName WHERE $this->tableName.`categoryId`='$catId';";
            return $this->myQuery;
        }
        public function selectWithTaskId($catId){
            #method to select category with perticular category id;
            $this->myQuery="SELECT * FROM $this->tableName WHERE $this->tableName.`categoryId`='$catId';";
            return $this->myQuery;
        }

        public function selectWithCatName($catName){
            #method to select category id with perticular categoryName;
            $this->myQuery="SELECT * FROM `$this->tableName` WHERE `$this->tableName`.`categoryName`='$catName';";
            return $this->myQuery;
        }

    }
    # this class is for the "rolecategories" table
    class UserRoleQuery extends queryClasses{
        public $tableName='rolecategories';
        public function addNewRoleCategory($roleCategory){
            #method to add new role for the newer user;
            $this->myQuery="INSERT INTO `$this->tableName` (`roleCategory`) VALUES ('$roleCategory');";
            return $this->myQuery;
        }
        public function DeleteRoleCategory($roleId){
            #method to delete any role catagory 
            $this->myQuery="DELETE FROM `$this->tableName` WHERE `$this->tableName`.`roleId`='$roleId';";
            return $this->myQuery;
        }
        public function selectWithRoleId($roleId){
            #method to select role with perticular role id;
            $this->myQuery="SELECT * FROM `$this->tableName` WHERE `$this->tableName`.`roleId`='$roleId';";
            return $this->myQuery;
        }
        public function selectWithRoleName($roleName){
            #method to select category id with perticular categoryName;
            $this->myQuery="SELECT * FROM `$this->tableName` WHERE `$this->tableName`.`roleCategory`='$roleName';";
            return $this->myQuery;
        }
    }

    // echo "<h3>Hey buddy!,,,I'm from database connectivity page and this page is working perfectly.</h3>"
?>