<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="style.css">
<h1>Update Toy Data</h1>
<?php
include 'dbConfig.php';
$dbCon = new dbConnect();
$toyData = $dbCon->getRows('Toy',array('where'=>array('id'=>$_GET['id']),'return_type'=>'single'));
if(!empty($toyData)){
?>
<div class="row">
    <div class="panel panel-default toy-add-edit">
        <div class="panel-heading">Update Toy <a href="index.php" class="glyphicon glyphicon-arrow-left"></a></div>
        <div class="panel-body">
            <form method="post" action="formFunctions.php" class="form" id="toyForm">
            <div class="form-group">
                    <label>Name</label>
                    <input type="text" class="form-control" name="name" value="<?php echo $toyData['name']; ?>"/>
                </div>
                <div class="form-group">
                    <label>Type</label>
                    <input type="text" class="form-control" name="type" value="<?php echo $toyData['type']; ?>"/>
                </div>
                <div class="form-group">
                    <label>Price</label>
                    <input type="text" class="form-control" name="price" value="<?php echo $toyData['price']; ?>"/>
                </div>
                <div class="form-group">
                    <label>Min Age</label>
                    <input type="text" class="form-control" name="minAge" value="<?php echo $toyData['minAge']; ?>"/>
                </div>
                <div class="form-group">
                    <label>Max Age</label>
                    <input type="text" class="form-control" name="maxAge" value="<?php echo $toyData['maxAge']; ?>"/>
                </div>
                <input type="hidden" name="id" value="<?php echo $toyData['id']; ?>"/>
                <input type="hidden" name="action_type" value="update"/>
                <input type="submit" class="offset-sm-2 col-sm-10" name="submit" value="Update Toy"/>
            </form>
        </div>
    </div>
</div>
<?php } ?>