<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <title>Add Toy</title>
</head>
<body>
<h1>Add Toy Data</h1>
<div class="row">
    <div class="panel panel-default toy-add-edit">
        <div class="panel-heading">Add Toy <a href="index.php" class="glyphicon glyphicon-arrow-left"></a></div>
        <div class="panel-body">
            <form method="post" action="formFunctions.php" class="form" id="toyForm">
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" class="form-control" name="name"/>
                </div>
                <div class="form-group">
                    <label>Type</label>
                    <input type="text" class="form-control" name="type"/>
                </div>
                <div class="form-group">
                    <label>Price</label>
                    <input type="text" class="form-control" name="price"/>
                </div>
                <input type="hidden" name="action_type" value="add"/>
                <input type="submit" class="form-control btn-default" name="submit" value="Add Toy"/>
            </form>
        </div>
    </div>
</div>
    
</body>
</html>