<?php
// echo "i'm from the main interface page"
session_start();

if ($_SESSION['userRole'] == 'admin') {
    include('db.php'); #this will include the data of the Database and queries;
    include('userHandlerClasses.php');
    include('filteredValues.php');
    // include('userHandlerQueries.php');
} else {
    header("Location:index.php");
}
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
function usersAllTasks()
{
    # this function will get all the task store in the database for all the users.
    $dbObj = new dbConnection();
    $taskQueryObj = new createTaskQuery();
    $dbObj->connectDb();
    $taskQueryObj->selectAllData();
    $result = userChange::handleAnyQuery($dbObj->con, $taskQueryObj->myQuery);
    return $result;
}
function anyUserInfomation($userId)
{
    #This function will provide the infomation for the user by using user Id.
    $dbObj = new dbConnection();
    $userInfoQuery = new createDataQuery();
    $dbObj->connectDb();
    $userInfoQuery->selectWithCond($userId);
    $result = userChange::handleAnyQuery($dbObj->con, $userInfoQuery->myQuery);
    $resultRow = $result->fetch_assoc();
    return $resultRow;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <link rel="stylesheet" href="index.css">
    <title>User DashBoard</title>
</head>

<body>
    <!-- this is section for the navbar of the website mebers dashboard -->
    <nav class="navbar navbar-expand-lg navbar-light bg-info">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="mainInterface.php?home=true">Groot</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle myFont" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            User
                        </a>
                        <ul class="dropdown-menu bg-secondary" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item myFont" href="mainInterface.php?addNewMember=true">Add New Member</a></li>
                            <li><a class="dropdown-item myFont" href="mainInterface.php?showAllUsers=true">Show All Users</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle  myFont" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Task
                        </a>
                        <ul class="dropdown-menu bg-secondary" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item myFont" href="mainInterface.php?myTask=true">My Pending Task</a></li>
                            <li><a class="dropdown-item myFont" href="mainInterface.php?myCompletedTask=true">MY Completed Task</a></li>
                            <li>
                                <hr class="dropdown-divider bg-light fw-bold">
                            </li>
                            <li><a class="dropdown-item myFont" href="mainInterface.php?otherUsersTask=true">Users Pending Task</a></li>
                            <li><a class="dropdown-item myFont" href="mainInterface.php?otherUsersCompletedTask=true">Users Completed Task</a></li>
                            <li><a class="dropdown-item myFont" href="mainInterface.php?addTaskDirect=true">Assign New Task</a></li>
                        </ul>
                    </li>
                </ul>
                <ul class="navbar-nav mb-2 mb-lg-0">
                    <li class="nav-item">
                        <?php
                        $userDetail = userChange::anyUserInformation($_SESSION['userId']);
                        ?>
                        <a class="nav-link active myFont" aria-current="page" href="mainInterface.php?myDetail=true"><?php echo ucwords($userDetail['userName']); ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active myFont" aria-current="page" href="mainInterface.php?logMeOut=true">Log Out</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>




    <!-- THIS SECTION IS ALL ABOUT THE CURRENT USER MEANS TASK DETAIL EVERYTHING -->

    <!-- Section for the home page of the user dashboard -->
    <div class="container">
        <?php
        if (isset($_GET['home'])) {
            include_once('userHome.php');
        }
        ?>
    </div>

    <!-- TO Log Out the current User -->
    <div>
        <?php
        if (isset($_GET['logMeOut'])) {
            include('logOut.php');
        }
        ?>
    </div>


    <!-- section to get the information of the current user -->
    <div>
        <?php
        if (isset($_GET['myDetail'])) :
            $userDetail = userChange::anyUserInformation($_SESSION['userId']);
        ?>
            <div class="container">
                <div class="card mb-3" style="max-width: 540px;">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <img src="./uploaded/<?php echo $userDetail['userImage']; ?>" style="max-width:180px; border-radius:20%;" alt="User Image">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo ucwords($userDetail['userName']); ?></h5>
                                <p class="card-text"><?php echo ucwords($userDetail['userName']); ?> Your Email : <?php echo $userDetail['userEmail']; ?></p>
                                <p class="card-text"><small class="text-muted">You are working with us on the profile: <h3><?php echo ucfirst($userDetail['roleCategory']); ?> </h3></small></p>
                            </div>
                        </div>
                        <div style="text-align: center; display:inline-block" class="col-md-12 mb-3">
                            <a href="mainInterface.php?editMyInfo=true" class="btn btn-primary btn-sm fw-bold">Edit Info</a>
                            <a href="mainInterface.php?editMyPassword=true" class="btn btn-secondary btn-sm fw-bold">Edit Password</a>
                            <a href="mainInterface.php?editMyImage=true" class="btn btn-primary btn-sm fw-bold">Edit Profile Image</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- SECTION TO EDIT THE CURRENT USER INFORMATION -->

    <!-- SECTION to edit the user Information. -->
    <div class="container">
        <?php
        if (isset($_GET['editMyInfo'])) :
            $userId = $_SESSION['userId'];
            $userInfo = userChange::anyUserInformation($userId);
            include('editUser.php');
        ?>
        <?php endif; ?>
    </div>
    <!-- SECTION to edit the other user Information. -->
    <div class="container">
        <?php
        if (isset($_GET['editUser'])) :
            $userId = $_GET['editUser'];
            $userInfo = userChange::anyUserInformation($userId);
            include('editUser.php');
        ?>
        <?php endif; ?>
    </div>

    <!-- SECTION to edit the passWord -->
    <div class="container">
        <?php
        if (isset($_GET['editMyPassword'])) :
            $userId = $_SESSION['userId'];
            include('editPassword.php');

        ?>
        <?php endif; ?>
    </div>

    <!-- SECTION TO EDIT THE Profile image -->
    <div class="container">
        <?php
        if (isset($_GET['editMyImage'])) :
            include('editProfileImage.php');
            $currentUserInfo = userChange::anyUserInformation($_SESSION['userId']);
        ?>
            <div>
                <form action="" class="form" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <input type="hidden" class="form-control" name="oldProfileImage" value="<?php echo $currentUserInfo['userImage']; ?>" id="oldProfileImage">
                    </div>
                    <div class="form-group">
                        <input type="hidden" class="form-control" name="profileImageUserId" value="<?php echo $_SESSION['userId'] ?>" id="profileImageUserId">
                    </div>
                    <div class="form-group">
                        <input type="file" class="form-control" name="profileImage" id="profileImage">
                    </div>
                    <button class="btn btn-primary" name="updateImage">UPDATE</button>
                </form>
            </div>
        <?php endif; ?>
    </div>

    <!-- SECTION TO SHOW CURRENT USER PENDING TASK -->
    <div class="row">

        <!-- below div we will use to filter the tasks -->
        <?php
        if (isset($_GET['myTask'])) :
            $userTasks = userChange::userAllTask($_SESSION['userId']);
            $srNo = 0;
        ?>
            <div class="col-md-2 mt-2">
                <?php
                if(isset($_POST['filterTask'])):
                    $dbObj=new dbConnection();
                    $dbObj->connectDb();
                    $filterRole=$_POST['filterRole'];
                    $filterTaskCategory=$_POST['filterTaskCategory'];
                    $allTask=filterValueFun($dbObj,$filterRole,$filterTaskCategory);
                    $allRole = userChange::handleAnyQuery($dbObj->con, $roleCategoryObj->myQuery);
                else:
                $dbObj = new dbConnection();
                $taskCategoryObj = new taskCategoryQuery();
                $roleCategoryObj = new UserRoleQuery();
                $dbObj->connectDb();
                $taskCategoryObj->selectAllData();
                $roleCategoryObj->selectAllData();
                $allTask = userChange::handleAnyQuery($dbObj->con, $taskCategoryObj->myQuery);
                $allRole = userChange::handleAnyQuery($dbObj->con, $roleCategoryObj->myQuery);
                ?>

                <div>
                    <form action="" method="POST" class="form">
                        <label class="form-label fw-bold" style="margin-left: 5%;">Filter</label>
                        <div class="form-group" style="display: none;">
                            <select name="filterRole" id="filterRole" class="form-select">
                                <option value="">SELECT USER ROLE</option>
                                <?php
                                while ($roleRow = $allRole->fetch_assoc()) :
                                ?>
                                    <option value="<?php echo $roleRow['roleId']; ?>"><?php echo $roleRow['roleCategory']; ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div>
                            <select name="filterTaskCategory" id="filterTaskCategory" class="form-select mt-3">
                                <option value="">Select Task Category</option>
                                <?php
                                while ($taskRow = $allTask->fetch_assoc()) :
                                ?>
                                    <option value="<?php echo $taskRow['categoryId']; ?>"><?php echo $taskRow['categoryName']; ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <button style="margin-left: 2%;border-radius:50%;" class="btn btn-sm btn-primary mt-3" name="filterTask">GO</button>
                    </form>

                </div>
            </div>
            <div class="col-md-10">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">SR. No.</th>
                            <th scope="col">Task Id</th>
                            <th scope="col">Task Title</th>
                            <th scope="col">Task Detail</th>
                            <th scope="col">Task Categry</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php while ($userTaskRow = $userTasks->fetch_assoc()) :
                            if ($userTaskRow['taskCompleted'] == 'no') :
                                $userTaskCategory = userChange::taskAllValue($userTaskRow['categoryId']);
                                $srNo += 1;
                        ?>
                                <tr>
                                    <td><?php echo $srNo; ?></td>
                                    <td><?php echo $userTaskRow['taskId']; ?></td>
                                    <td><?php echo $userTaskRow['taskTitle']; ?></td>
                                    <td><?php echo $userTaskRow['taskDisc']; ?></td>
                                    <td><?php echo $userTaskCategory['categoryName']; ?></td>
                                    <td>
                                        <a class="btn btn-sm btn-info" href="mainInterface.php?editTask=<?php echo $userTaskRow['taskId'];  ?>">Edit</a>
                                        <a class="btn btn-sm btn-success" href="mainInterface.php?makeComplete=<?php echo $userTaskRow['taskId'];  ?>">Add To Complete</a>
                                        <a class="btn btn-sm btn-danger" href="mainInterface.php?deleteTask=<?php echo $userTaskRow['taskId'];  ?>" onclick="return confirmDelete()">Delete</a>
                                    </td>
                                </tr>
                    <?php endif;
                        endwhile;
                    endif; ?>

                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>

    
    <?php
        if(isset($_GET['filterTable'])){
            $table=$_SESSION['filteredTable'];
            while($row=$table->fetch_assoc()):
                echo "i'm working";
            endwhile;
        }
    ?>


    <!-- SECTION TO SHOW CURRENT Completed TASK -->
    <div class="row">
        <?php
        if (isset($_GET['myCompletedTask'])) :
            $userTasks = userChange::userAllTask($_SESSION['userId']);
            $srNo = 0;
        ?>
            <div class="col-md-2 mt-2">
                <?php
                $dbObj = new dbConnection();
                $taskCategoryObj = new taskCategoryQuery();
                $roleCategoryObj = new UserRoleQuery();
                $dbObj->connectDb();
                $taskCategoryObj->selectAllData();
                $roleCategoryObj->selectAllData();
                $allTask = userChange::handleAnyQuery($dbObj->con, $taskCategoryObj->myQuery);
                $allRole = userChange::handleAnyQuery($dbObj->con, $roleCategoryObj->myQuery);
                ?>
                <div>
                    <form action="filteredValues.php" method="POST" class="form">
                        <label class="form-label fw-bold" style="margin-left: 5%;">Filter</label>
                        <div class="form-group" style="display: none;">
                            <select name="filterRole" id="filterRole" class="form-select">
                                <option value="">SELECT USER ROLE</option>
                                <?php
                                while ($roleRow = $allRole->fetch_assoc()) :
                                ?>
                                    <option value="<?php echo $roleRow['roleId']; ?>"><?php echo $roleRow['roleCategory']; ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div>
                            <select class="form-select mt-3" name="filterTaskCategory" id="filterTaskCategory">
                                <option value="">Select Task Category</option>
                                <?php
                                while ($taskRow = $allTask->fetch_assoc()) :
                                ?>
                                    <option value="<?php echo $taskRow['categoryId']; ?>"><?php echo $taskRow['categoryName']; ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <button class="btn btn-sm btn-primary mt-3" style="margin-left: 2%;border-radius:50%;" name="filterTask">GO</button>
                    </form>
                </div>
            </div>
            <div class="col-md-10">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">SR. No.</th>
                            <th scope="col">Task Id</th>
                            <th scope="col">Task Title</th>
                            <th scope="col">Task Detail</th>
                            <th scope="col">Task Categry</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php while ($userTaskRow = $userTasks->fetch_assoc()) :
                            if ($userTaskRow['taskCompleted'] == 'yes') :
                                $userTaskCategory = userChange::taskAllValue($userTaskRow['categoryId']);
                                $srNo += 1;
                        ?>
                                <tr>
                                    <td><?php echo $srNo; ?></td>
                                    <td><?php echo $userTaskRow['taskId']; ?></td>
                                    <td><?php echo $userTaskRow['taskTitle']; ?></td>
                                    <td><?php echo $userTaskRow['taskDisc']; ?></td>
                                    <td><?php echo $userTaskCategory['categoryName']; ?></td>
                                    <td>
                                        <a class="btn btn-sm btn-primary" href="mainInterface.php?reassignTask=<?php echo $userTaskRow['taskId'];  ?>">Reassign Task</a>
                                        <a class="btn btn-sm btn-danger" href="mainInterface.php?deleteTask=<?php echo $userTaskRow['taskId'];  ?>" onclick="return confirmDelete()">Delete</a>
                                    </td>
                                </tr>
                    <?php endif;
                        endwhile;
                    endif; ?>

                    </tbody>
                </table>
            </div>
    </div>


    <!-- SECTION TO EDIT TASK -->
    <div class="container">
        <?php
        if (isset($_GET['editTask'])) :
            include('editTask.php');
            $taskId = $_GET['editTask'];
            $dbObj = new dbConnection();
            $taskQueryObj = new createTaskQuery();
            $dbObj->connectDb();
            $taskResultRow = userChange::taskAllValue($taskId);
            $taskCategoryObj = new taskCategoryQuery();
            $taskCategoryObj->selectAllData();
            $taskCategoryResult = mysqli_query($dbObj->con, $taskCategoryObj->myQuery);

        ?>
            <div>
                <!-- this div is for the EDITING of the task -->
                <form action="" class="row" method="POST">
                    <div class="col-md-9">
                        <div class="mb-3">
                            <input type="hidden" id="taskId" class="form-control" name="taskId" value="<?php echo $taskId; ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Update Title</label>
                            <input type="text" class="form-control" name="teskTitle" id="taskTitle" aria-describedby="taskHelp" value="<?php echo $taskResultRow['taskTitle']; ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Update Disc Discription</label>
                            <input type="text" name="taskDisc" class="form-control" id="taskDisc" value="<?php echo $taskResultRow['taskDisc']; ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Update Category</label>
                            <select name="taskCategory" id="taskCategory" class="form-select">
                                <?php
                                while ($taskCategoryResultRow = $taskCategoryResult->fetch_assoc()) :
                                ?>
                                    <?php if ($taskCategoryResultRow['categoryName'] == $taskCategory['categoryName']) : ?>
                                        <option value="<?php echo $taskCategoryResultRow['categoryName']; ?>" selected>
                                            <?php echo ucwords($taskCategoryResultRow['categoryName']); ?>
                                        </option>
                                    <?php else :  ?>
                                        <option value="<?php echo $taskCategoryResultRow['categoryName']; ?>">
                                            <?php echo ucwords($taskCategoryResultRow['categoryName']); ?>
                                        </option>
                                <?php endif;
                                endwhile; ?>
                            </select>
                        </div>
                        <button type="submit" name='editThisTask' class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>

        <?php endif; ?>
    </div>

    <!-- SECTION TO MAKE ANY TASK COMPLETE -->
    <div class="container">
        <?php
        if (isset($_GET['makeComplete'])) :
            $taskId = $_GET['makeComplete'];
            $success = userChange::makeTaskCompleted($taskId);
            if ($success) :
        ?>
                <div class="alert alert-success">
                    Task is added to the completed List
                </div>
            <?php else : ?>
                <div class="alert alert-danger">
                    we are unable to do this task! please try Later.
                </div>

        <?php endif;
        endif; ?>
    </div>


    <!-- SECTION TO DELETE ANY TASK -->
    <div class="container">
        <?php
        if (isset($_GET['deleteTask'])) :
            $taskId = $_GET['deleteTask'];
            $success = userChange::deleteAnyTask($taskId);
            if ($success) : ?>
                <div class="alert alert-warning" role="alert">
                    Task is DELETED successfully!
                </div>
            <?php else : ?>
                <div class="alert alert-danger" role="alert">
                    We are unable to do this task!
                </div>
        <?php endif;
        endif;
        ?>
    </div>

    <!-- SECTION TO REASSIGNING A TASK -->
    <div class="container">
        <?php
        if (isset($_GET['reassignTask'])) :
            $taskId = $_GET['reassignTask'];
            $success = userChange::reAssigningTask($taskId);
            if ($success) :
        ?>
                <div class="alert alert-success">
                    Task is reassigned!
                </div>
            <?php else : ?>
                <div class="alert alert-danger">
                    We are not able to do this task!
                </div>
        <?php endif;
        endif; ?>
    </div>


    <!-- SECTION FOR THE OTHER USERS TASK -->


    <!-- SECTION TO SHOW OTHER USERs PENDING TASK -->
    <div class="row">

        <?php
        if (isset($_GET['otherUsersTask'])) :
            $taskResult = usersAllTasks();
            $srNo = 0;
        ?>
            <div class="col-md-2 mt-2">
                <?php
                include('filterForm.php');
                ?>
                <div>
                    <form action="filteredValues.php" method="POST" class="form">
                        <label class="form-label fw-bold" style="margin-left: 5%;">Filter</label>
                        <div class="form-group">
                            <select name="filterRole" id="filterRole" class="form-select">
                                <option value="">SELECT USER ROLE</option>
                                <?php
                                while ($roleRow = $allRole->fetch_assoc()) :
                                ?>
                                    <option value="<?php echo $roleRow['roleId']; ?>"><?php echo $roleRow['roleCategory']; ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div>
                            <select name="filterTaskCategory" id="filterTaskCategory" class="form-select mt-3">
                                <option value="">Select Task Category</option>
                                <?php
                                while ($taskRow = $allTask->fetch_assoc()) :
                                ?>
                                    <option value="<?php echo $taskRow['categoryId']; ?>"><?php echo $taskRow['categoryName']; ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <button class="btn btn-sm btn-primary mt-3" style="margin-left: 3%; border-radius:50%;" name="filterTask">GO</button>
                    </form>

                </div>
            </div>
            <div class="col-md-10">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">SR. No.</th>
                            <th scope="col">Task Id</th>
                            <th scope="col">User Id</th>
                            <th scope="col">User Name</th>
                            <th scope="col">Task Title</th>
                            <th scope="col">Task Detail</th>
                            <th scope="col">Task Categry</th>
                            <th scope="col">User Role</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php while ($taskResultRow = $taskResult->fetch_assoc()) :
                            if ($taskResultRow['taskCompleted'] == 'no' && $taskResultRow['userId'] != $_SESSION['userId']) :
                                $userTaskCategory = userChange::taskAllValue($taskResultRow['categoryId']);
                                $userInfoRow = userChange::anyUserInformation($taskResultRow['userId']);
                                $srNo += 1;
                        ?>
                                <tr>
                                    <td><?php echo $srNo; ?></td>
                                    <td><?php echo $taskResultRow['taskId']; ?></td>
                                    <td><?php echo $taskResultRow['userId']; ?></td>
                                    <td><?php echo ucwords($userInfoRow['userName']); ?></td>
                                    <td><?php echo ucwords($taskResultRow['taskTitle']); ?></td>
                                    <td><?php echo ucfirst($taskResultRow['taskDisc']); ?></td>
                                    <td><?php echo ucwords($userTaskCategory['categoryName']); ?></td>
                                    <td><?php echo ucfirst($userInfoRow['roleCategory']); ?></td>
                                    <td>
                                        <a class="btn btn-sm btn-info" href="mainInterface.php?editTask=<?php echo $taskResultRow['taskId'];  ?>">Edit</a>
                                        <a class="btn btn-sm btn-success" href="mainInterface.php?makeComplete=<?php echo $taskResultRow['taskId'];  ?>">Add To Complete</a>
                                        <a class="btn btn-sm btn-danger" href="mainInterface.php?deleteTask=<?php echo $taskResultRow['taskId'];  ?>" onclick="return confirmDelete()">Delete</a>
                                    </td>
                                </tr>
                    <?php endif;
                        endwhile;
                    endif; ?>

                    </tbody>
                </table>
            </div>
    </div>


    <!-- SECTION For other Users Completed TASK -->
    <div class="row">

        <?php
        if (isset($_GET['otherUsersCompletedTask'])) :
            $taskResult = usersAllTasks();
            $srNo = 0;
        ?>
            <div class="col-md-2 mt-2">
                <?php
                include('filterForm.php');
                ?>
                <div>
                    <form action="filteredValues.php" method="POST" class="form">
                        <label class="form-label fw-bold" style="margin-left: 5%;">Filter</label>
                        <div class="form-group">
                            <select name="filterRole" id="filterRole" class="form-select">
                                <option value="">SELECT USER ROLE</option>
                                <?php
                                while ($roleRow = $allRole->fetch_assoc()) :
                                ?>
                                    <option value="<?php echo $roleRow['roleId']; ?>"><?php echo $roleRow['roleCategory']; ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div>
                            <select name="filterTaskCategory" id="filterTaskCategory" class="form-select mt-3">
                                <option value="">Select Task Category</option>
                                <?php
                                while ($taskRow = $allTask->fetch_assoc()) :
                                ?>
                                    <option value="<?php echo $taskRow['categoryId']; ?>"><?php echo $taskRow['categoryName']; ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <button class="btn btn-sm btn-primary mt-3" style="margin-left: 3%; border-radius:50%;" name="filterTask">GO</button>
                    </form>

                </div>
            </div>
            <div class="col-md-10">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">SR. No.</th>
                            <th scope="col">Task Id</th>
                            <th scope="col">User Id</th>
                            <th scope="col">User Name</th>
                            <th scope="col">Task Title</th>
                            <th scope="col">Task Detail</th>
                            <th scope="col">Task Categry</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        while ($taskResultRow = $taskResult->fetch_assoc()) :
                            if ($taskResultRow['taskCompleted'] == 'yes' && $taskResultRow['userId'] != $_SESSION['userId']) :
                                $userTaskCategory = userChange::taskAllValue($taskResultRow['categoryId']);
                                $userInfoRow = anyUserInfomation($taskResultRow['userId']);
                                $srNo += 1;
                        ?>
                                <tr>
                                    <td><?php echo $srNo; ?></td>
                                    <td><?php echo $taskResultRow['taskId']; ?></td>
                                    <td><?php echo $taskResultRow['userId']; ?></td>
                                    <td><?php echo ucwords($userInfoRow['userName']); ?></td>
                                    <td><?php echo ucwords($taskResultRow['taskTitle']); ?></td>
                                    <td><?php echo ucfirst($taskResultRow['taskDisc']); ?></td>
                                    <td><?php echo ucwords($userTaskCategory['categoryName']); ?></td>
                                    <td>
                                        <a class="btn btn-sm btn-warning fw-bold" href="mainInterface.php?reassignTask=<?php echo $taskResultRow['taskId'];  ?>">Reassign Task</a>
                                        <a class="btn btn-sm btn-danger" href="mainInterface.php?deleteTask=<?php echo $taskResultRow['taskId'];  ?>" onclick="return confirmDelete()">Delete</a>
                                    </td>
                                </tr>
                        <?php endif;
                        endwhile; ?>

                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>

    <!-- DIRECTLY ADD NEW Task -->
    <div>
        <?php
        if (isset($_GET['addTaskDirect'])) :
            $queryDataObj = new createDataQuery;
            $dbObj = new dbConnection();
            // $queryTaskObj=new createTaskQuery();
            $dbObj->connectDb();
            $queryDataObj->selectAllData();
            $queryTask = "SELECT DISTINCT `taskCategory` FROM usertask;";
            // var_dump($queryObj->myQuery);
            $resultData = mysqli_query($dbObj->con, $queryDataObj->myQuery);
            $resultTask = mysqli_query($dbObj->con, $queryTask);
            include('./addNewTask.php');
            // var_dump($result);
        ?>
            <form action="" class="row mt-3 " method="POST">
                <div class="col-md-2" style="margin-left: 3%;">
                    <h4>SELECT Task's Category</h4>
                    <small>You can select multiple categories</small>
                    <?php
                    $dbObj = new dbConnection();
                    $taskCategoryObj = new taskCategoryQuery();
                    $dbObj->connectDb();
                    $taskCategoryObj->selectAllData();
                    $allTaskCategory = userChange::handleAnyQuery($dbObj->con, $taskCategoryObj->myQuery);
                    if ($allTaskCategory) :
                        while ($allTaskCategoryRow = $allTaskCategory->fetch_assoc()) :
                    ?>
                            <div class="form-check" style="display: inline-flex;">
                                <input class="form-check-input" type="checkbox" name="categoryList[]" value="<?php echo $allTaskCategoryRow['categoryId']; ?>" id="checkValue">
                                <label class="form-check-label">
                                    <?php echo ucfirst($allTaskCategoryRow['categoryName']); ?>
                                </label>
                            </div>
                    <?php endwhile;
                    endif; ?>
                    <br>
                    <small class="text text-Info fw-bold">Note:- Not Finding exact category add new category first</small><br>
                    <a class="btn btn-sm btn-primary" href="mainInterface.php?addNewTaskCategory=true">ADD NEW CATEGORY</a>

                </div>
                <div class="col-md-8 ">
                    <label>Select User </label>
                    <select class="form-select" name="userId">
                        <option>---select User---</option>
                        <?php while ($dataRow = $resultData->fetch_assoc()) : ?>
                            <option value="<?php echo $dataRow['userId']; ?>"><?php echo "id " . $dataRow['userId'] . ", Name " . $dataRow['userName']; ?></option>

                        <?php endwhile; ?>
                    </select>
                    <div class="form-group">
                        <label for="teskTitle">Task Title</label>
                        <input type="text" class="form-control" name="teskTitle" id="teskTitle" placeholder="Enter title for the task">
                    </div>
                    <div class="form-group">
                        <label for="taskDisc" class="form-label">Task Detail</label>
                        <input type="text" class="form-control" name="taskDisc" id="taskDisc" placeholder="enter some detail of the task">
                    </div>
                    <!-- <div class="form-group">
                        <label for="directEntersTaskCategory">Task Detail</label>
                        <input type="text" class="form-control" name="directEntersTaskCategory" id="directEntersTaskCategory" placeholder="enter new category">
                    </div><br> -->
                    <button class="btn btn-primary" name="addThisTask">Add This Task</button>
                </div>
            </form>
        <?php endif; ?>
    </div>


    <!-- Add New Category for the task -->
    <div class="container">
        <?php
        if (isset($_GET['addNewTaskCategory'])) :
            include('./addNewTaskCategory.php');
        endif;
        ?>
    </div>



    <!-- ADD NEW MEMBER -->
    <div class="container">
        <?php
        if (isset($_GET['addNewMember'])) :
            include('./addNewMember.php');
        endif;
        ?>
    </div>

    <!-- SECTION TO SHOW ALL USERS -->
    <div class="row">

        <?php
        if (isset($_GET['showAllUsers'])) :
            $dbObj = new dbConnection();
            $userDataObj = new createDataQuery();
            $dbObj->connectDb();
            $userDataObj->selectAllData();
            $result = userChange::handleAnyQuery($dbObj->con, $userDataObj->myQuery);
            $srNo = 0;
        ?>
            <div class="col-md-2 mt-2">
                <?php
                $dbObj = new dbConnection();
                $taskCategoryObj = new taskCategoryQuery();
                $roleCategoryObj = new UserRoleQuery();
                $dbObj->connectDb();
                $taskCategoryObj->selectAllData();
                $roleCategoryObj->selectAllData();
                $allTask = userChange::handleAnyQuery($dbObj->con, $taskCategoryObj->myQuery);
                $allRole = userChange::handleAnyQuery($dbObj->con, $roleCategoryObj->myQuery);
                ?>

                <div>
                    <form action="filteredValues.php" method="POST" class="form">
                        <label class="form-label fw-bold" style="margin-left: 5%;">Filter</label>
                        <div class="form-group">
                            <select name="filterRole" id="filterRole" class="form-select">
                                <option value="">SELECT USER ROLE</option>
                                <?php
                                while ($roleRow = $allRole->fetch_assoc()) :
                                ?>
                                    <option value="<?php echo $roleRow['roleId']; ?>"><?php echo $roleRow['roleCategory']; ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div>
                            <select name="filterTaskCategory" id="filterTaskCategory" style="display: none;" class="form-select mt-3">
                                <option value="">Select Task Category</option>
                                <?php
                                while ($taskRow = $allTask->fetch_assoc()) :
                                ?>
                                    <option value="<?php echo $taskRow['categoryId']; ?>"><?php echo $taskRow['categoryName']; ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <button style="margin-left: 2%;border-radius:50%;" class="btn btn-sm btn-primary mt-3" name="filterTask">GO</button>
                    </form>

                </div>
            </div>
            <div class="col-md-10">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">SR. No.</th>
                            <th scope="col">User Id</th>
                            <th scope="col">User Name</th>
                            <th scope="col">User Email</th>
                            <th scope="col">User Role</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        while ($row = $result->fetch_assoc()) :
                            $srNo += 1;
                        ?>
                            <tr>
                                <td><?php echo $srNo; ?></td>
                                <td><?php echo $row['userId']; ?></td>
                                <td><?php echo ucwords($row['userName']); ?></td>
                                <td><?php echo ucwords($row['userEmail']); ?></td>
                                <td><?php echo ucfirst($row['roleCategory']); ?></td>
                                <td>
                                    <a class="btn btn-sm btn-info" href="mainInterface.php?editUser=<?php echo $row['userId'];  ?>">Edit</a>
                                    <a class="btn btn-sm btn-success" href="mainInterface.php?assignTask=<?php echo $row['userId'];  ?>">Assign New Task</a>
                                    <a class="btn btn-sm btn-danger" href="mainInterface.php?deleteUser=<?php echo $row['userId'];  ?>" onclick="return confirmDelete()">Delete</a>
                                </td>
                            </tr>
                    <?php endwhile;
                    endif; ?>

                    </tbody>
                </table>
            </div>
    </div>

    <!-- ASSIGN NEW TASK -->
    <div class="container">
        <?php
        if (isset($_GET['assignTask'])) :
            $userId = $_GET['assignTask'];
            // var_dump($userid);
            include('addNewTask.php');
        ?>
            <div>
                <!-- this div is for the add new task Form-->
                <form action="" class="row" method="POST">
                    <div class="col-md-3">
                        <?php
                        $dbObj = new dbConnection();
                        $taskCategoryObj = new taskCategoryQuery();
                        $dbObj->connectDb();
                        $taskCategoryObj->selectAllData();
                        $allTaskCategory = userChange::handleAnyQuery($dbObj->con, $taskCategoryObj->myQuery);
                        if ($allTaskCategory) :
                            while ($allTaskCategoryRow = $allTaskCategory->fetch_assoc()) :
                        ?>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="categoryList[]" value="<?php echo $allTaskCategoryRow['categoryId']; ?>" id="checkValue">
                                    <label class="form-check-label">
                                        <?php echo ucfirst($allTaskCategoryRow['categoryName']); ?>
                                    </label>
                                </div>
                        <?php endwhile;
                        endif; ?>

                    </div>
                    <div class="col-md-9">
                        <div class="mb-3">
                            <input type="hidden" id="userId" class="form-control" name="userId" value="<?php echo $userId; ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Enter Title</label>
                            <input type="text" class="form-control" name="teskTitle" id="taskTitle" aria-describedby="emailHelp">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Write Discription</label>
                            <input type="text" name="taskDisc" class="form-control" id="taskDisc">
                        </div>
                        <button type="submit" name='addThisTask' class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        <?php endif; ?>
    </div>

    <!-- JAVASCRIPT PART  -->
    <script>
        function confirmDelete() {
            return confirm('Do you want to delete this Pemanently!');
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js" integrity="sha384-SR1sx49pcuLnqZUnnPwx6FCym0wLsk5JZuNx2bPPENzswTNFaQU1RDvt3wT4gWFG" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js" integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc" crossorigin="anonymous"></script>
</body>

</html>