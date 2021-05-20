

    <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <title>Toy Store Management</title>

<h1>Toy List</h1>

<?php
session_start();
if(!empty($_SESSION['statusMsg'])){
    echo '<p>'.$_SESSION['statusMsg'].'</p>';
    unset($_SESSION['statusMsg']);
}
?>

<div class="row">
    <div class="panel panel-default toys-content">
        <div class="panel-heading">Toys <a href="addToy.php" class="glyphicon glyphicon-plus"></a></div>
        <table class="table">
            <tr>
                <th width="5%">#</th>
                <th width="20%">Name</th>
                <th width="30%">Type</th>
                <th width="20%">Price</th>
                <!-- <th width="12%">Created</th> -->
                <th width="13%"></th>
            </tr>
            <?php
            include 'dbConfig.php';
            $dbCon = new dbConnect();
            $toys = $dbCon->getRows('toys',array('order_by'=>'id DESC'));
            if(!empty($toys)){ $count = 0; foreach($toys as $toy){ $count++;?>
            <tr>
                <td><?php echo $count; ?></td>
                <td><?php echo $toy['name']; ?></td>
                <td><?php echo $toy['type']; ?></td>
                <td><?php echo $toy['price']; ?></td>
                <td><?php echo $toy['created']; ?></td>
                <td>
                    <a href="edit.php?id=<?php echo $toy['id']; ?>" class="glyphicon glyphicon-edit"></a>
                    <a href="formFunctions.php" class="glyphicon glyphicon-trash" onclick="return confirm('Are you sure?');"></a>
                </td>
            </tr>
            <?php } }else{ ?>
            <tr><td colspan="4">No toy(s) found......</td>
            <?php } ?>
        </table>
    </div>
</div>
