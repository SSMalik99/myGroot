<?php

// THis is to define new category for the user---

$dbObj=new dbConnection();
$taskQuery=new taskCategoryQuery();
$dbObj->connectDb();

if (isset($_POST['addTaskCategory'])) :
    $newCategory = strtolower($_POST['newTaskCategory']);
    if(!empty($newCategory)):
        $taskQuery->addNewTaskCategory($newCategory);
        $updateResult =userChange::handleAnyQuery($dbObj->con,$taskQuery->myQuery);
        // var_dump($updateResult);
        if ($updateResult) :
    ?>
            <div class="alert alert-success" role="alert">
            Task category added successfully.
            </div>
        <?php else: ?>
            <div class="alert alert-danger" role="alert">
            unable to do this task!may be category exist already;
            </div>

    <?php endif; ?>
    <?php else: ?>
        <div class="alert alert-warning" role="alert">
            Please Enter Valid category!
        </div>
<?php endif; endif; ?>

    <div class="container">
        <div class="card bg-dark">
            <h3 class="card-title text-warning" style="text-align: center;"> Available categories</h3>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Sr. No.</th>
                    <th scope="col">CategoryName</th>
                </tr>
            </thead>
            <tbody>
                <?php
                   $taskQuery->selectAllData();
                    $result =userChange::handleAnyQuery($dbObj->con,$taskQuery->myQuery);
                    $srNo=0;
                    while ($row = $result->fetch_assoc()) :
                        $srNo+=1;
                    ?>
                    <tr>
                        <th scope="row"><?php echo $srNo; ?></th>
                        <td><?php echo ucFirst($row['categoryName']); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <div class="card bg-dark">
            <h3 class="card-title text-warning" style="text-align: center;">Inside below Given Area you can add Your Category</h3>
        </div>

        <form action="" method="POST">
            <div>
                <label for="taskCategory" class="form-label mt-4 fw-bold">Enter New category</label>
                <input type="text" class="form-control  fw-bold " name="newTaskCategory" id="newTaskCategory" placeholder="enter new task Category">
            </div>
            <div style="text-align: center;"> 
                <button class="btn btn-lg btn-success mt-3" name="addTaskCategory">ADD Category</button>
            </div>
        </form>
    </div>