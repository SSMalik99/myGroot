<?php
    if(isset($_POST['addThisMember'])):
        $newUserName=strtolower($_POST['newMemberName']);
        $newUserEmail=strtolower($_POST['newMemberEmail']);
        $newUserPassword=sha1($_POST['newMemberPassword']);
        $newUserRole=$_POST['newUserRole'];
        $newUserValid=strtolower($_POST['newUservalid']);
        $dbObj=new dbConnection();
        $userDataObj=new createDataQuery();
        $dbObj->connectDb();
        $userDataObj->addUserQuery($newUserName,$newUserEmail,$newUserPassword,$newUserRole,$newUserValid);
        // var_dump($userDataObj->myQuery);
        $result=userChange::handleAnyQuery($dbObj->con,$userDataObj->myQuery);
        // var_dump($result);
        if($result):
?>          
        <div class="alert alert-success">
            New Member is Added successfully.
        </div>
    <?php else: ?>
        <div class="alert alert-danger">
            Adding new member is incomplete! Try Again.
        </div>
    <?php endif; endif; ?>
<div class="mt-3">
<form action="" method="POST">
    <div class="form-group">
        <label class="form-label">Enter New Member Name</label>
        <input type="text" name="newMemberName" id="newMemberName" required class="form-control" placeholder="Enter Name" >
    </div>
    <div class="form-group">
    <label class="form-label">Enter New Member Email</label>
        <input type="email" name="newMemberEmail" required id="newMemberEmail" class="form-control" placeholder="Enter Email">
    </div>
    <div class="form-group">
    <label class="form-label">Enter password for New Member</label>
        <input type="password" name="newMemberPassword" required id="newMemberPassword" class="form-control" placeholder="Enter Password">
    </div>
    <div class="form-group">
    <label class="form-label">Select Role for New Member</label>
        <select name="newUserRole" id="newUserRole"  class="form-select">
        <option value="">---SELECT USER ROLE---</option>
        <?php
            $dbObj=new dbConnection();
            $roleQueryObj=new UserRoleQuery();
            $dbObj->connectDb();
            $roleQueryObj->selectAllData();
            $roleQueryObjResult=userChange::handleAnyQuery($dbObj->con,$roleQueryObj->myQuery);
            $dbObj->dissconnectDb();
            while($roleQueryObjResultRow=$roleQueryObjResult->fetch_assoc()):
        ?>
            <option value="<?php echo $roleQueryObjResultRow['roleId']; ?>"><?php echo ucfirst($roleQueryObjResultRow['roleCategory']); ?></option>
            <?php endwhile; ?>

        </select>
    </div>
    <div class="form-group">
    <label class="form-label">Allow Or Disallow User</label>
        <select name="newUservalid" id="newUservalid" class="form-select">
        <option value="">---USER Availabilty---</option>
        <option value="yes">Approve</option>
        <option value="no">Don't Approve</option>
        </select>
    </div>
    <button class="btn btn-lg btn-success" name="addThisMember">ADD MEMBER</button>

</form>
</div>