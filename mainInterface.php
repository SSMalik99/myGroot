<?php
    // echo "i'm from the main interface page"
    session_start();
    
    if($_SESSION['userRole']=='admin'){
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
    <title>User DashBoard</title>
</head>
<body>
    <!-- this is section for the navbar of the website mebers dashboard -->
    <nav class="navbar navbar-expand-lg navbar-light bg-info">
        <div class="container-fluid">
            <a class="navbar-brand" href="mainInterface.php?home=true">Groot</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    User
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="#">Add New Member</a></li>
                    <li><a class="dropdown-item" href="#">Show All Users</a></li>
                </ul>
                </li>
                <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Task
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="#">My Task</a></li>
                    <li><a class="dropdown-item" href="#">Add New Task</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="#">Show Other Users Task</a></li>
                    <li><a class="dropdown-item" href="#">Completed Task</a></li>
                </ul>
                </li>
                <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                   Categories
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="#">Designer</a></li>
                    <li><a class="dropdown-item" href="#">Developer</a></li>
                    <li><a class="dropdown-item" href="#">Testing</a></li>
                </ul>
                </li>
            </ul>
            <ul class="navbar-nav mb-2 mb-lg-0">
                <li class="nav-item">
                <?php
                    $userDetail=currentUserInformation();
                ?>
                <a class="nav-link active" aria-current="page" href="#"><?php echo ucwords($userDetail['userName']); ?></a>
                </li>
                <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="mainInterface.php?logMeOut=true">Log Out</a>
                </li>
            </ul>
            </div>
        </div>
        </nav>




    <!-- Section for the home page of the user dashboard -->
    <div class="container">
        <?php
            if(isset($_GET['home'])){
                include('userHome.php');
            }
        ?>
    </div>

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
        
        ?>
        <div class="container">
            <div class="card mb-3" style="max-width: 540px;">
                <div class="row g-0">
                    <div class="col-md-4">
                        <img src="./uploaded/<?php echo $userDetail['userImage']; ?>"  style="max-width:120px" alt="User Image">
                    </div>
                    <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $userDetail['userName']; ?></h5>
                        <p class="card-text"><?php echo $userDetail['userName']; ?> Your Email : <?php echo $userDetail['userEmail']; ?></p>
                        <p class="card-text"><small class="text-muted">Note: We are working on the update profile functions.</small></p>
                    </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>




    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js" integrity="sha384-SR1sx49pcuLnqZUnnPwx6FCym0wLsk5JZuNx2bPPENzswTNFaQU1RDvt3wT4gWFG" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js" integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc" crossorigin="anonymous"></script>
</body>
</html>