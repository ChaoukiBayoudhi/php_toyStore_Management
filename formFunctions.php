<?php
session_start();
include 'dbConfig.php';
$dbCon = new dbConnect();
$tableName = 'Toy';
if(isset($_REQUEST['action_type']) && !empty($_REQUEST['action_type'])){
    if($_REQUEST['action_type'] == 'add'){
        $toyData = array(
            'name' => $_POST['name'],
            'type' => $_POST['type'],
            'price' => $_POST['price']
        );
        $insert = $dbCon->insert($tableName,$toyData);
        $statusMsg = $insert?'Toy has been inserted successfully.':'Some problem occurred, please try again.';
        $_SESSION['statusMsg'] = $statusMsg;
        header("Location:index.php");
    }elseif($_REQUEST['action_type'] == 'edit'){
        if(!empty($_POST['id'])){
            $toyData = array(
                'name' => $_POST['name'],
                'type' => $_POST['type'],
                'price' => $_POST['price']
            );
            $condition = array('id' => $_POST['id']);
            $update = $dbCon->update($tableName,$toyData,$condition);
            $statusMsg = $update?'Toy has been updated successfully.':'Some problem occurred, please try again.';
            $_SESSION['statusMsg'] = $statusMsg;
            header("Location:index.php");
        }
    }elseif($_REQUEST['action_type'] == 'delete'){
        if(!empty($_GET['id'])){
            $condition = array('id' => $_GET['id']);
            $delete = $dbCon->delete($tableName,$condition);
            $statusMsg = $delete?'Toy has been deleted successfully.':'Some problem occurred, please try again.';
            $_SESSION['statusMsg'] = $statusMsg;
            header("Location:index.php");
        }
    }
}
?>