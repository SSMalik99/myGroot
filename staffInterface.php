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
    function currentUserInformation(){
        $userId=$_SESSION['userId'];
        $dbObj=new dbConnection();
        $userDataObj=new createDataQuery();
        $dbObj->connectDb();
        $userDataObj->selectWithCond($userId);
        $dataResult=mysqli_query($dbObj->con,$userDataObj->myQuery);
        $userDataRow=$dataResult->fetch_assoc();
        // var_dump($userDataRow);
        return $userDataRow;
    }
?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <title>Staff DashBoard</title>
</head>
<body>
    <!-- this is section for the navbar of the website mebers dashboard -->
    <nav class="navbar navbar-expand-lg navbar-light bg-info">
        <div class="container-fluid">
            <a class="navbar-brand" href="staffInterface.php?home=true">Groot</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Task
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="staffInterface.php?myTask=true">My Task</a></li>
                    <li><a class="dropdown-item" href="staffInterface.php?addNewTask=true">Add New Task</a></li>
                    <li><hr class="dropdown-divider"></li>
                </ul>
                </li>
            </ul>
            <ul class="navbar-nav mb-2 mb-lg-0">
                <li class="nav-item">
                    <?php
                        $userDetail=currentUserInformation();
                    ?>
                <a class="nav-link active" aria-current="page" href="staffInterface.php?myDetail=true"><?php echo ucwords($userDetail['userName']); ?></a>
                </li>
                <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="staffInterface.php?logMeOut=true">Log Out</a>
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
            $userDetail=currentUserInformation();
            $userRole=userChange::anyuserRole($userDetail['roleId'])
        ?>
        <div class="container">
            <div class="card mb-3" style="max-width: 540px;">
                <div class="row g-0">
                    <div class="col-md-4">
                        <img src="./uploaded/<?php echo $userDetail['userImage']; ?>"  style="max-width:120px" alt="User Image">
                    </div>
                    <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo ucwords($userDetail['userName']); ?></h5>
                        <p class="card-text"><?php echo $userDetail['userName']; ?> Your Email : <?php echo $userDetail['userEmail']; ?></p>
                        <p class="card-text"><small class="text-muted">You are working with us on the profile: <?php echo ucfirst($userRole['roleCategory']); ?> </small></p>
                    </div>
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
                    $userTaskCategory=userChange::anyTaskCategory($userTaskRow['categoryId']); 
                    $srNo+=1;
        ?>
                    <tr>
                        <td><?php echo $srNo; ?></td>
                        <td><?php echo $userTaskRow['taskId']; ?></td>
                        <td><?php echo $userTaskRow['taskTitle']; ?></td>
                        <td><?php echo $userTaskRow['taskDisc']; ?></td>
                        <td><?php echo $userTaskCategory['categoryName']; ?></td>
                        <td>
                            <a href="staffInterface.php?editTask=<?php echo $userTaskRow['taskId'];  ?>">Edit</a>|
                            <a href="staffInterface.php?makeComplete=<?php echo $userTaskRow['taskId'];  ?>">Add To Complete</a>
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

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js" integrity="sha384-SR1sx49pcuLnqZUnnPwx6FCym0wLsk5JZuNx2bPPENzswTNFaQU1RDvt3wT4gWFG" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js" integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc" crossorigin="anonymous"></script>
</body>
</html>