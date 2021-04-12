<?php
    // include('./resources/db.php');
    // $dbObj=new dbConnection();
    // $dataObj=new createDataQuery();
    // $taskObj=new createTaskQuery();
    // $taskCatObj=new taskCategoryQuery();
    // $roleObj=new UserRoleQuery();
    // $dbObj->connectDb();
    // $dataObj->selectAllData();
    // var_dump($dataObj);
    // echo "</br>";
    // $taskObj->selectAllData();
    // var_dump($taskObj);
    // echo "</br>";
    // $taskCatObj->selectAllData();
    // var_dump($taskCatObj);
    // echo "</br>";
    // $roleObj->selectAllData();
    // var_dump($roleObj);
    // echo "</br>";
    // $dataResult=mysqli_query($dbObj->con,$dataObj->myQuery);
    // var_dump($dataResult);
    // echo "</br>";
    // $taskResult=mysqli_query($dbObj->con,$taskObj->myQuery);
    // var_dump($taskResult);
    // echo "</br>";
    // $taskCatResult=mysqli_query($dbObj->con,$taskCatObj->myQuery);
    // var_dump($taskCatResult);
    // echo "</br>";
    // $roleResult=mysqli_query($dbObj->con,$roleObj->myQuery);
    // var_dump($roleResult);
    // echo "<hr/>";
    // while($dataRow=$dataResult->fetch_assoc()){
    //     var_dump($dataRow);
    //     echo "</br>";
    // }
    // echo "<hr/>";
    // while($taskRow=$taskResult->fetch_assoc()){
    //     var_dump($taskRow);
    //     echo "</br>";
    // }
    // echo "<hr/>";
    // while($taskCatRow=$taskCatResult->fetch_assoc()){
    //     var_dump($taskCatRow);
    //     echo "</br>";
    // }
    // echo "<hr/>";
    // while($roleRow=$roleResult->fetch_assoc()){
    //     var_dump($roleRow);
    //     echo "</br>";
    // }
    // echo "<hr/>";
    // echo "</br>";
    // echo "</br>";
    // echo "</br>";


?>  








<?php
    $conn=mysqli_connect('localhost','root','','masterdb');
    if($conn){
        echo "i'm connected";
    }else{
        echo "i'm unable to connect";
    }
    if(isset($_POST['submit'])){
        echo __DIR__;
        $image=$_FILES['profileImage'];
        // print_r($image);
        $fileName = $image['name'];
        $fileType = $image['type'];
        $fileSize = $image['size'];
        $filePath = $image['tmp_name']; 
        $imageMakerName=explode(".",$fileName);
        // print_r($imageExt);
        $finalImageName=$imageMakerName[0].date('ymd').time(); #this willgive the final name of the uploaded image 
        $finalImageExt=strtolower(end($imageMakerName)); #this is the final image extention
        // echo "$finalImageName"."$finalImageExt";
        $finalImgWithExt=$finalImageName.".".$finalImageExt;  #this is the final name of the file to save in the database;
        // echo $finalImgWithExt;

        // $allowedExt=array('jpeg','jpg','image/png');
        if(($fileType="image/jpeg"||$fileType="image/png"||$fileType="image/gif")){
            
            // echo "i'm in the first Condition";
            if($fileSize<614400){
                // echo "i'm in the 2nd condition ";
                $action=move_uploaded_file($filePath,__DIR__.'./uploaded/'.$finalImgWithExt);
                if($action){
                    // echo "i'm in the action";
                    $query=mysqli_query($conn,"INSERT INTO `masterdb`.`imageinfo` ( `image` ) VALUES ('$finalImgWithExt')");
                    if($query){
                        echo "File is uploaded successfully";
                    }else{
                        echo "we need to complete this taks again";
                    }
                }
            }else{
                echo "file is too big in  size";
            }
        }else{
            echo "only jpeg/jpg/png are allowed to upload";
        }
// if($file_name!="" && ($file_type="image/jpeg"||$file_type="image/png"||$file_type="image/gif")&& $file_size<=614400)

        // [name] => wallpaper1.jpg [type] => image/jpeg [tmp_name] => C:\Users\ratio\AppData\Local\Temp\phpA851.tmp [error] => 0 [size] => 115215
        // $query="INSERT INTO `masterdb`.`imageinfo` (`image`) VALUES ('$image')";
        // $result = mysqli_query($conn,$image);
        // if($result){
        //     echo "image added successfully";
        // }else{
        //     echo "we are not able to add this image";
        // }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faltu Page</title>
</head>
<body>
    <form action="" method="POST" enctype="multipart/form-data">
        <input type="file" name="profileImage" id="profileImage">
        <button name="submit">Submit</button>
    </form>


    <?php
        $result=  mysqli_query($conn,"SELECT `image` FROM `masterdb`.`imageinfo`");
        if($result): 
            while($row=$result->fetch_assoc()):
            // var_dump($row['image']);
    ?>  
            <img src="./uploaded/<?php echo $row['image']; ?>" class="card-img-top" alt="database image">

        <?php endwhile; endif; ?>
 
</body>
</html>