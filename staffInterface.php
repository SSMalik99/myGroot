<?php
    // echo "i'm from the main interface page"
    session_start();
    
    if($_SESSION['userRole']!='admin' || $_SESSION['userRole']!='manager'){
        include('db.php'); #this will include the data of the Database and queries;
        include('userHandlerClasses.php');
        // include('userHandlerQueries.php');
    }else{
        header("Location:index.php");
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
    <title>Staff DashBoard</title>
</head>
<body>
    <!-- this is section for the navbar of the website mebers dashboard -->
    <nav class="navbar navbar-expand-lg navbar-light bg-info">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="staffInterface.php?home=true">Groot</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle fw-bold myFont"  href="staffInterface.php?myTask=true" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Task
                </a>
                <ul class="dropdown-menu bg-secondary" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item fw-bold myFont" href="staffInterface.php?myTask=true">My Task</a></li>
                    <li><a class="dropdown-item myFont" href="staffInterface.php?addNewTask=true">Add New Task</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item myFont" href="staffInterface.php?completedTask=true">My Completed Task</a></li>
                </ul>
                </li>
            </ul>
            <ul class="navbar-nav mb-2 mb-lg-0">
                <li class="nav-item">
                    <?php
                        $userDetail=userChange::anyUserInformation($_SESSION['userId']);
                    ?>
                <a class="nav-link active myFont" aria-current="page" href="staffInterface.php?myDetail=true"><?php echo ucwords($userDetail['userName']); ?></a>
                </li>
                <li class="nav-item">
                <a class="nav-link active myFont" aria-current="page" href="staffInterface.php?logMeOut=true">Log Out</a>
                </li>
            </ul>
            </div>
        </div>
        </nav>
















<!-- This will contain the furteher process after the click  means most of the task of the PHP is given inside the below section. -->


    <!-- Section for the home page of the user dashboard -->
    <div class="container">
        <?php
            if(isset($_GET['home'])){
                include('userHome.php');
            }
        ?>
    </div>
            <!-- TO Log Out the current User -->
    <div>
        <?php
            if(isset($_GET['logMeOut'])){
                include('logOut.php');
            } ?>
    </div>

    <!-- section to get the information of the current user -->
    <div>
        <?php
        if(isset($_GET['myDetail'])):
            $userDetail=userChange::anyUserInformation($_SESSION['userId']);
        ?>
        <div class="container">
            <div class="card mb-3" style="max-width: 540px;">
                <div class="row g-0">
                    <div class="col-md-4">
                        <img src="./uploaded/<?php echo $userDetail['userImage']; ?>"  style="max-width:180px; border-radius:20%;" alt="User Image">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo ucwords($userDetail['userName']); ?></h5>
                            <p class="card-text"><?php echo ucwords($userDetail['userName']); ?> Your Email : <?php echo $userDetail['userEmail']; ?></p>
                            <p class="card-text"><small class="text-muted">You are working with us on the profile: <h3><?php echo ucfirst($userDetail['roleCategory']); ?> </h3></small></p>
                        </div> 
                    </div>
                    <div style="text-align: center; display:inline-block" class="col-md-12 mb-3">
                            <a href="staffInterface.php?editMyInfo=true" class="btn btn-primary">Edit Info</a>
                            <a href="staffInterface.php?editMyPassword=true" class="btn btn-primary">Edit Password</a>
                            <a href="staffInterface.php?editMyImage=true" class="btn btn-primary">Edit Profile Image</a>
                    </div>
                </div>
            </div>          
        </div>
        <?php endif; ?>
    </div>



    <!-- section to show task -->
    <div class="container">
        
        <?php 
            if(isset($_GET['myTask'])):
                $userTasks=userChange::userAllTask($_SESSION['userId']);
                $srNo=0; 
        ?>
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

        <?php    while($userTaskRow=$userTasks->fetch_assoc()):
                    if($userTaskRow['taskCompleted']=='no'):
                    $userTaskCategory=userChange::taskAllValue($userTaskRow['taskId']); 
                    $srNo+=1;
        ?>
                    <tr>
                        <td><?php echo $srNo; ?></td>
                        <td><?php echo $userTaskRow['taskId']; ?></td>
                        <td><?php echo $userTaskRow['taskTitle']; ?></td>
                        <td><?php echo $userTaskRow['taskDisc']; ?></td>
                        <td><?php echo $userTaskCategory['categoryName']; ?></td>
                        <td>
                            <a class="btn btn-sm btn-secondary" href="staffInterface.php?editTask=<?php echo $userTaskRow['taskId'];  ?>">Edit</a>
                            <a class="btn btn-sm btn-success" href="staffInterface.php?makeComplete=<?php echo $userTaskRow['taskId'];  ?>">Add To Complete</a>
                        </td>
                    </tr>
                    <?php endif; endwhile; endif; ?>

                </tbody>
        </table>
    </div>
    

    <!-- SECTION TO ADD NEW TASK -->
    <div class="container">
    <?php
        if(isset($_GET['addNewTask'])):
            include('addNewTask.php');
    ?>
        <div><!-- this div is for the add new task Form-->
            <form action="" class="row" method="POST">
                <div class="col-md-3">
                    <?php
                        $dbObj=new dbConnection();
                        $taskCategoryObj=new taskCategoryQuery();
                        $dbObj->connectDb();
                        $taskCategoryObj->selectAllData();
                        $allTaskCategory=userChange::handleAnyQuery($dbObj->con,$taskCategoryObj->myQuery);
                        if($allTaskCategory):
                            while($allTaskCategoryRow=$allTaskCategory->fetch_assoc()):
                    ?>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="categoryList[]" value="<?php echo $allTaskCategoryRow['categoryId']; ?>" id="checkValue">
                            <label class="form-check-label">
                                <?php echo ucfirst($allTaskCategoryRow['categoryName']); ?>
                            </label>
                        </div>
                        <?php endwhile; endif;?>

                </div>
                <div class="col-md-9">
                    <div class="mb-3">
                        <input type="hidden" id="userId"  class="form-control" name="userId" value="<?php echo $_SESSION['userId']; ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Enter Title</label>
                        <input type="text" class="form-control" name="teskTitle" id="taskTitle" aria-describedby="emailHelp" >
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

    <!-- SECTION TO EDIT A GIven Task -->

    <div class="container">
        <?php 
            if(isset($_GET['editTask'])): 
                include('editTask.php');
                $taskId=$_GET['editTask'];
                $taskResultRow=userChange::taskAllValue($taskId);
                // var_dump($taskCategory['categoryId']);
        ?>
            <div><!-- this div is for the EDITING of the task -->
            <form action="" class="row" method="POST">
                <div class="col-md-9">
                    <div class="mb-3">
                        <input type="hidden" id="taskId"  class="form-control" name="taskId" value="<?php echo $taskId; ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Update Title</label>
                        <input type="text" class="form-control" name="teskTitle" id="taskTitle" aria-describedby="taskHelp" value="<?php echo $taskResultRow['taskTitle']; ?>" >
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Update Disc Discription</label>
                        <input type="text" name="taskDisc" class="form-control" id="taskDisc" value="<?php echo $taskResultRow['taskDisc']; ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Update Category</label>
                        <input type="text" name="taskCategory" class="form-control" id="taskCategory" value="<?php echo $taskResultRow['categoryName']; ?>">
                    </div>
                    <button type="submit" name='editThisTask' class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
            
        <?php endif; ?>
    </div>

    <!-- Make Any Task Complete -->
    <div class="container">
        <?php
            if(isset($_GET['makeComplete'])):
                $taskId=$_GET['makeComplete'];
                $success=userChange::makeTaskCompleted($taskId);
                if($success):
        ?>
                <div class="alert alert-success">
                    Task is added to the completed List
                </div>
                <?php else: ?>
                    <div class="alert alert-danger">
                        we are unable to do this task! please try Later.
                    </div>

            <?php endif; endif; ?>
    </div>

    <!-- section to show COMPLETED task -->
    <div class="container">
        
        <?php 
            if(isset($_GET['completedTask'])):
                $userTasks=userChange::userAllTask($_SESSION['userId']);
                $srNo=0; 
        ?>
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

        <?php    while($userTaskRow=$userTasks->fetch_assoc()):
                    if($userTaskRow['taskCompleted']=='yes'):
                    $userTaskCategory=userChange::taskAllValue($userTaskRow['categoryId']); 
                    $srNo+=1;
        ?>
                    <tr>
                        <td><?php echo $srNo; ?></td>
                        <td><?php echo $userTaskRow['taskId']; ?></td>
                        <td><?php echo ucfirst($userTaskRow['taskTitle']); ?></td>
                        <td><?php echo ucfirst($userTaskRow['taskDisc']); ?></td>
                        <td><?php echo ucfirst($userTaskCategory['categoryName']); ?></td>
                        <td>
                            <h6>You can't change anything here contact to the Admin or the manager to take any action regarding this projects.</h6>
                        </td>
                    </tr>
                    <?php endif; endwhile; endif; ?>

                </tbody>
        </table>
    </div>

    <!-- SECTION to edit the user Information. -->
    <div class="container">
        <?php
            if(isset($_GET['editMyInfo'])):
                $userId=$_SESSION['userId'];
                $userInfo=userChange::anyUserInformation($userId);
                include('editUser.php');
        ?>
        <?php  endif; ?>
    </div>

    <!-- SECTION to edit the Password -->
    <div class="container">
        <?php
            if(isset($_GET['editMyPassword'])):
                $userId=$_SESSION['userId'];
                include('editPassword.php');
        ?>
        <?php endif; ?>
    </div>


    <!-- SECTION TO EDIT THE Profile image IMAGE -->
    <div class="container">
        <?php
            if(isset($_GET['editMyImage'])):
                include('editProfileImage.php');
                $currentUserInfo=userChange::anyUserInformation($_SESSION['userId']);
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

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js" integrity="sha384-SR1sx49pcuLnqZUnnPwx6FCym0wLsk5JZuNx2bPPENzswTNFaQU1RDvt3wT4gWFG" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js" integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc" crossorigin="anonymous"></script>
</body>
</html>