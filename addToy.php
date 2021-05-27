<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <title>Add Toy</title>

<h1>Add Toy Data</h1>
<div class="row">
    <div class="panel panel-default toy-add-edit">
        <div class="panel-heading">Add Toy <a href="adminDashboard.php" class="glyphicon glyphicon-arrow-left"></a></div>
        <div class="panel-body">
        <!--http is an protocol that transports information via network-->
        <!-- this protocol has many method to do that like post (transport a huge information) get (transport one information like id, name) -->
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
                <div class="form-group">
                    <label>Min Age</label>
                    <input type="text" class="form-control" name="minAge"/>
                </div>
                <div class="form-group">
                    <label>Max Age</label>
                    <input type="text" class="form-control" name="maxAge"/>
                </div>
                <input type="hidden" name="action_type" value="add"/>
                <input type="submit" class="offset-sm-2 col-sm-10" name="submit" value="Add Toy"/>
            </form>
        </div>
    </div>
</div>
    
