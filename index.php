<?php
    include_once('db.php');
    include_once('userHandlerClasses.php');
    
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <title>Admin LogIn</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
    $(document).ready(function(){
        $('#registrationForm').hide();
        $('#registerQueryClick').click(function(){
            $('#loginForm').hide();
            $('#registrationForm').show();
        });
        $('#LoginQueryClick').click(function(){
            $('#registrationForm').hide();
            $('#loginForm').show();
        });
    });
    </script>
</head>

<body class="bg-dark">
    <div class="container bg-dark">
        <div class="bg-info " style="height:260px;text-align:center;">
            <h3 class="p-5">This website is a demo website to learn PHP and to make user management system.</h3>
        </div>
        <div class="row" id="loginForm">
            <div class="col card mt-4" style="width: 18rem;">
                <span class="text-weight-bold">You Can Login Here.</span>
                <?php
                    if(isset($_POST['loginClick'])):
                        $loginEmail=strtolower($_POST['loginEmail']);
                        $loginPassword=sha1($_POST['loginPassword']);
                        $dbObj=new dbConnection();
                        $queryObj = new createDataQuery();
                        $memberObj = new handleUsers();
                        $dbObj->connectDb();                        
                        $queryObj->fetchWithEmail($loginEmail);
                        $table=mysqli_query($dbObj->con,$queryObj->myQuery);
                        // var_dump($table);
                        $dbObj->dissconnectDb();
                        if($table):
                            list($valid,$resultvalue)=$memberObj->loginUser($table,$loginEmail,$loginPassword);
                            // var_dump($valid);
                            // var_dump($resultvalue);
                            if($valid):
                                header($resultvalue);
                            else: 
                            ?>
                                <div class='alert alert-danger' role='alert'>
                                
                                    <?php echo $resultvalue; ?>
                                </div>
                    <?php   endif; 
                        else: 
                        ?>
                            <div class='alert alert-warning' role='alert'>
                                Wrong Credentials!
                            </div>
                  <?php endif; endif;?>

                    <?php
                    if(isset($_POST['registrationClick'])):
                        $registrationName=strtolower($_POST['registrationName']);
                        $registrationEmail=strtolower($_POST['registrationEmail']);
                        $registrationPassword=sha1($_POST['registrationPassword']);
                        $userValid='no';
                        $dbObj=new dbConnection();
                        $queryObj = new createDataQuery();
                        $dbObj->connectDb();                        
                        $queryObj->addUserQuery($registrationName,$registrationEmail,$registrationPassword,$userValid);
                        $result=mysqli_query($dbObj->con,$queryObj->myQuery);
                        $dbObj->dissconnectDb();
                        if($result): ?>
                            <div class='alert alert-success' role='alert'>
                            You are registered successfully! Wait for Your approval;
                            </div>

                    <?php else: ?>
                            <div class='alert alert-danger' role='alert'>
                                We are unable to register you currently!
                            </div>
                <?php endif; endif; ?>
                        
                <form action="" method="POST" class="form" >
                    <div class="mb-3">
                        <input type="email" name="loginEmail" id="loginEmail" class="form-control" placeholder="Enter Your Email" required> 
                    </div>
                    <div class="mb-3">
                        <input type="password" class="form-control" name="loginPassword" id="loginPassword" placeholder="Enter Your Password" required>
                    </div>
                    <div class="mb-3">
                        <button id="loginClick" name="loginClick" class="btn btn-primary">LogIN</button>
                    </div>
                </form>
                </br>
                <p>
                    <b>Note:</b> If You are not registered please register Yourself.
                    <button class="btn btn-primary" id="registerQueryClick" >Click to Register</button>
                </p>
            </div>
        </div>
    </div>
    <div class="container"  id="registrationForm">
        
        <div class="col card mt-3" >
            <div>You Can Register with us.</div>
            <form action="" method="POST" class="form" >
                <div class="mb-3">
                    <input type="text" name="registrationName" id="registrationName" class="form-control" placeholder="Enter Your Name" required> 
                </div>
                <div class="mb-3">
                    <input type="email" name="registrationEmail" id="registrationEmail" class="form-control" placeholder="Enter Your Email" required> 
                </div>
                <div class="mb-3">
                    <input type="password" class="form-control" name="registrationPassword" id="registrationPassword" placeholder="Enter Your Password" required>
                </div>
                <div class="mb-3">
                    <button id="registrationClick" name="registrationClick" class="btn btn-primary">Register</button>
                    
                </div>
            </form>
            </br>
                <p>
                    <button class="btn btn-primary" id="LoginQueryClick">Click to Login</button>
                </p>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js" integrity="sha384-SR1sx49pcuLnqZUnnPwx6FCym0wLsk5JZuNx2bPPENzswTNFaQU1RDvt3wT4gWFG" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js" integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc" crossorigin="anonymous"></script>
</body>

</html>