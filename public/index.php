<?php
require_once '/var/www/sites/list.mikebuonomo.com/config.php';
$listTable = new ListTable();
try {
    $lists = $listTable->fetchAll();
} catch (Exception $e) {
    echo $e->getMessage();
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Shopping list web app.">
    <title>List | Mike Buonomo</title>
    <link rel="shortcut icon" href="/favicon/favicon.ico">
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/animate.css">
    <link rel="stylesheet" href="/css/font-awesome.min.css">
    <link rel="stylesheet" href="/css/shopping-list.css">
    <script type="text/javascript" src="/js/jquery.min.js"></script>
    <script type="text/javascript" src="/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="/js/shopping-list.js"></script>
</head>
<body>
<div class="container-fluid background">
    <div class="container">

            <div class="panel panel-default text-left fadeIn animated" id="choose-list-well">
                <div class="panel-heading">
                    <h3 class="panel-title">Pick a List</h3>
                </div><!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="list-group">
                        <?php if ($lists): ?>
                            <?php foreach ($lists as $list): ?>
                                <div class="list-group-item" id="" data-id="<?php echo $list->getId() ?>">
                                    <h4 class="list-group-item-heading">
                                        <table>
                                            <tr>
                                                <td class="listname-col"><?php echo $list->getName() ?></td>
                                                <td class="edit-col" data-id="<?php echo $list->getId() ?>" data-name="<?php echo $list->getName() ?>">
                                                    <i class="fa fa-pencil-square-o" id="edit-list-icon"></i>
                                                    <i class="fa fa-times half-indent" id="delete-list-icon" data-elid="list_<?php echo $list->getId() ?>"></i>
                                                </td>
                                            </tr>
                                        </table>
                                    </h4>
                                </div><!-- /.list-group-item -->
                            <?php endforeach ?>
                        <?php endif ?>
                    </div><!-- /.list-group -->
                </div><!-- /.panel-body -->
                <div class="panel-footer text-center">
                    <i class="fa fa-plus-square icon"></i>
                </div><!-- /.panel-footer -->
            </div><!-- /.panel -->

            <div class="panel panel-default fadeIn animated" id="add-list-well" style="display:none">
                <div class="panel-heading">
                    <h3 class="panel-title">Create New List</h3>
                </div><!-- /.panel-heading -->
                <div class="panel-body">
                    <form id="add-list-form">
                        <input type="text" class="form-control" name="list_name" placeholder="List name">
                    </form>
                </div><!-- /.panel-body -->
                <div class="panel-footer text-center">
                    <i class="fa fa-arrow-left icon"></i>
                    <i class="fa fa-check-square icon indent"></i>
                </div><!-- /.panel-footer -->
            </div><!-- /.panel -->

            <div class="panel panel-default fadeIn animated" id="edit-list-well" style="display:none">
                <div class="panel-heading">
                    <h3 class="panel-title">Edit List Name</h3>
                </div><!-- /.panel-heading -->
                <div class="panel-body">
                    <form id="edit-list-form">
                        <input type="hidden" class="form-control" id="edit-listid-input">
                        <input type="text" class="form-control" id="edit-listname-input" placeholder="List name">
                    </form>
                </div><!-- /.panel-body -->
                <div class="panel-footer text-center">
                    <i class="fa fa-arrow-left icon"></i>
                    <i class="fa fa-check-square icon indent"></i>
                </div><!-- /.panel-footer -->
            </div><!-- /.panel -->

    </div><!-- /.container -->
</div><!-- /.container-fluid -->
<script>
//choose list
$(document).on('click', 'div.list-group-item', function(e) {
    e.stopPropagation();
    hideWell('choose-list-well');
    var that = $(this);
    setTimeout(function() {
        window.location.href = "/listview/?list_id="+that.data('id');
    }, 500);
});

//show edit list name well
$(document).on('click', '#edit-list-icon', function(e) {
    e.stopPropagation();
    var name = $(this).parents('.edit-col').data('name');
    var id = $(this).parents('.edit-col').data('id');
    $('#edit-listname-input').val(name);
    $('#edit-listid-input').val(id);
    changeWell('edit-list-well');
});

//save list name change
$(document).on('click', '#edit-list-well .fa-check-square', function(e) {
    if ($('#edit-listname-input').val() == '') {
        alert('Name is required');
    } else {
        var data = "list_name=" + $('#edit-listname-input').val()+"&id="+$('#edit-listid-input').val();
        data += "&submit=1&method=updateListName";
        $.ajax({
            url: '/api/',
            data: data,
            type: "POST",
            timeout: 10000, //10 seconds
            success: function(response) {
                if (response != 'Success') {
                    alert('Something went wrong!');
                } else {
                    //update selection
                    refreshWell('choose-list-well', '/', function() {
                        changeWell('choose-list-well');
                    });
                }
            },
            error: function(xhr, textStatus, errorThrown){
               alert('Connection lost! Unable to add new list.');
            }
        });
    }
});

//on dbl click - delete entire list
$(document).on('dblclick', '#delete-list-icon', function(e) {
    var id = $(this).parents('.edit-col').data('id');
    var wellId = $(this).parents('.edit-col').data('elid');
    data = "submit=1&method=deleteList&id="+id;
    $.ajax({
        url: '/api/',
        data: data,
        type: "POST",
        timeout: 10000, //10 seconds
        success: function(response) {
            if (response != 'Success') {
                alert('Something went wrong!');
            } else {
                $('#'+wellId).addClass('zoomOutRight animated');
                setTimeout(function() {
                    $('#'+wellId).remove();
                }, 500);
            }
        },
        error: function(xhr, textStatus, errorThrown){
           alert('Connection lost! Unable to new item.');
        }
    });
});

//on dbl click - delete entire list MUST HAVE THIS
$(document).on('click', '#delete-list-icon', function(e) {
    //e.stopPropagation();
});

//onclick - choose-list-well TO add-list-well
$(document).on('click', '#choose-list-well .fa-plus-square', function() {
    changeWell('add-list-well');
});

//onclick - add-list-well TO choose-list-well
$(document).on('click', '#add-list-well .fa-arrow-left', function() {
    changeWell('choose-list-well');
});

//onclick - add-list-well TO choose-list-well
$(document).on('click', '#edit-list-well .fa-arrow-left', function() {
    changeWell('choose-list-well');
});

//onclick - submit form to add new list
$(document).on('click', '#add-list-well .fa-check-square', function(e) {
    if ($('#add-list-well input[name="list_name"]').val() == '') {
        alert('Name is required');
    } else {
        var data = "list_name=" + $('#add-list-well input[name="list_name"]').val();
        data += "&submit=1&method=addNewList";
        $.ajax({
            url: '/api/',
            data: data,
            type: "POST",
            timeout: 10000, //10 seconds
            success: function(response) {
                if (response != 'Success') {
                    alert('Something went wrong!');
                } else {
                    //update selection
                    refreshWell('choose-list-well', '/', function() {
                        changeWell('choose-list-well');
                    });
                }
            },
            error: function(xhr, textStatus, errorThrown){
               alert('Connection lost! Unable to add new list.');
            }
        });
    }
});
</script>
</body>
</html>