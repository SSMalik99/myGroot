<?php
    if(isset($_POST['updateImage'])):
        $userId= $_POST['profileImageUserId'];
        $dbObj=new dbConnection();
        $queryObj=new createDataQuery();
        $dbObj->connectDb();
        $oldImage=$_POST['oldProfileImage'];
        $image=$_FILES['profileImage'];
        $fileName = $image['name'];
        $fileType = $image['type'];
        $fileSize = $image['size'];
        $filePath = $image['tmp_name']; 
        $imageMakerName=explode(".",$fileName);
        $finalImageName=$imageMakerName[0].date('ymd').time(); #this willgive the final name of the uploaded image 
        $finalImageExt=strtolower(end($imageMakerName)); #this is the final image extention
        $finalImgWithExt=$finalImageName.".".$finalImageExt;  #this is the final name of the file to save in the database;
        if(($fileType="image/jpeg"||$fileType="image/png"||$fileType="image/gif")):
            
            if($fileSize<614400): 
                $action=move_uploaded_file($filePath,__DIR__.'./uploaded/'.$finalImgWithExt);
                if($action):
                    $queryObj->updateProfileImage($userId,$finalImgWithExt);
                    $updatedResult=mysqli_query($dbObj->con,$queryObj->myQuery);
                    if($updatedResult):
                        #deletion of the old picture is not workin;
                        // unlink(__DIR__."/uploded/".$oldImage);
                    ?>
                        <div class="alert alert-success">
                            Profile picture is updated successfully.
                        </div>
                <?php else: ?>
                    <div class="alert alert-danger">
                        There is some technical issue please try after some time.
                    </div>
              <?php endif; ?>
                
         <?php  else: ?>
                <div class="alert alert-danger">
                    file is too big in  size".
                </div>
            
        <?php endif; ?>


        <?php else: ?>
            <div class="alert alert-danger">
                only jpeg/jpg/png are allowed to upload.
            </div>
        <?php endif; ?>
    <?php endif; ?>
<?php endif; ?>
