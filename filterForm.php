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
