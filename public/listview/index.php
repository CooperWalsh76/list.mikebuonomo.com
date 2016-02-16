<?php require_once '/var/www/sites/list.mikebuonomo.com/config.php';
$listTable = new ListTable();
$list = $listTable->getListById($_GET['list_id']);
$listItemTable = new ListItemTable();
try {
    $listItems = $listItemTable->getItemsByListId($_GET['list_id']);
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
    <title><?php echo $list->getName() ?> | Mike Buonomo</title>
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
<div class="container-fluid background full-height">
    <div class="container full-height">

        <div class="text-center fadeIn animated" id="list-items-well">
            <div class="panel panel-default text-left">
                <div class="panel-heading">
                    <h3 class="panel-title"><?php echo $list->getName() ?></h3>
                </div><!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="list-group" id="main-list" data-listId="<?php echo $list->getId() ?>">
                        <?php if ($listItems): ?>
                            <?php foreach ($listItems as $listItem): ?>
                                <div class="list-group-item" id="item_<?php echo $listItem->getId() ?>">
                                    <h4 class="list-group-item-heading">
                                        <table>
                                            <tr>
                                                <td class="checkbox-col">
                                                    <?php $icon = ($listItem->getIsChecked() == 1) ? 'fa-check-square-o' : 'fa-square-o' ?>
                                                    <i class="fa <?php echo $icon ?> checkbox" data-id="item_<?php echo $listItem->getId() ?>"></i>
                                                </td>
                                                <td class="listname-col"><?php echo $listItem->getName() ?></td>
                                                <td class="edit-col">
                                                    <i class="fa fa-pencil-square-o"
                                                        data-id="<?php echo $listItem->getId() ?>"
                                                        data-name="<?php echo $listItem->getName() ?>"
                                                        data-description="<?php echo $listItem->getDescription() ?>">
                                                    </i>
                                                    <i class="fa fa-times half-indent"
                                                        data-id="<?php echo $listItem->getId() ?>"
                                                        data-elid="item_<?php echo $listItem->getId() ?>">
                                                    </i>
                                                </td>
                                            </tr>
                                        </table>
                                    </h4>
                                    <div class="list-group-item-text">
                                        <table>
                                            <tr>
                                                <td class="checkbox-col"></td>
                                                <td class="listname-col item-description" colspan="2"><?php echo $listItem->getDescription() ?></td>
                                            </tr>
                                        </table>
                                        
                                    </div><!-- /.list-group-item-text -->
                                    <input type="hidden" name="is_checked_<?php echo $listItem->getName() ?>" value="<?php echo $listItem->getIsChecked() ?>">
                                </div><!-- /.list-group-item -->
                            <?php endforeach ?>
                        <?php endif ?>
                    </div><!-- /.list-group -->
                </div><!-- /.panel-body -->
                <div class="panel-footer text-center">
                    <i class="fa fa-arrow-left icon" id="back-to-lists-icon"></i>
                    <i class="fa fa-plus-square icon indent" id="add-new-listitem"></i>
                </div><!-- /.panel-footer -->
            </div><!-- /.panel -->
        </div><!-- /.text-center -->

        <div class="middle-align-out fadeIn animated" id="edit-list-item-well" style="display:none">
            <div class="middle-align-in">
                <div class="panel panel-default text-left">
                    <div class="panel-heading">
                        <h3 class="panel-title">Edit Item</h3>
                    </div><!-- /.panel-heading -->
                    <div class="panel-body">
                        <div class="form-group">
                            <input type="text" class="form-control" id="edit-listname-input" placeholder="Item Name">
                        </div><!-- /.form-group -->
                            <textarea class="form-control" id="edit-listdescription-input"placeholder="Item description"></textarea>
                        <input type="hidden" id="edit-id-input" value="">
                    </div><!-- /.panel-body -->
                    <div class="panel-footer text-center">
                        <i class="fa fa-arrow-left icon"></i>
                        <i class="fa fa-check-square icon indent"></i>
                    </div><!-- /.panel-footer -->
                </div><!-- /.panel -->
            </div><!-- /.middle-align-in -->
        </div><!-- /.middle-align-out -->

        <div class="middle-align-out fadeIn animated" id="add-list-item-well" style="display:none">
            <div class="middle-align-in">
                <div class="panel panel-default text-left">
                    <div class="panel-heading">
                        <h3 class="panel-title">Add Item</h3>
                    </div><!-- /.panel-heading -->
                    <div class="panel-body">
                        <div class="form-group">
                            <input type="text" class="form-control" id="add-listname-input" placeholder="Item Name">
                        </div><!-- /.form-group -->
                            <textarea class="form-control" id="add-listdescription-input" placeholder="Item description"></textarea>
                    </div><!-- /.panel-body -->
                    <div class="panel-footer text-center">
                        <i class="fa fa-arrow-left icon"></i>
                        <i class="fa fa-check-square icon indent"></i>
                    </div><!-- /.panel-footer -->
                </div><!-- /.panel -->

            </div><!-- /.middle-align-in -->
        </div><!-- /.middle-align-out -->
    </div><!-- /.container -->
</div><!-- /.container-fluid -->
</body>
<script>
$(document).on('click', '#back-to-lists-icon', function() {
    hideWell('list-items-well');
    setTimeout(function() {
        window.location.href = '/';
    }, 500);
});

//check / uncheck box
$(document).on('click', '#list-items-well .checkbox', function(e) {
    checkListItem($(this).data('id'));
});

//onclick - list-items-well TO edit-list-item-well
$(document).on('click', '#list-items-well .fa-pencil-square-o', function() {
    var listItemId = $(this).data('id');
    var listItemName = $(this).data('name');
    var listDescription = $(this).data('description');
    $('#edit-id-input').val(listItemId);
    $('#edit-listname-input').val(listItemName);
    $('#edit-listdescription-input').val(listDescription);
    changeWell('edit-list-item-well');
});

//onclick - edit-list-item-well TO list-items-well
$(document).on('click', '#edit-list-item-well .fa-arrow-left', function() {
    changeWell('list-items-well');
});

//onclick - submit form to adit list item
$(document).on('click', '#edit-list-item-well .fa-check-square', function(e) {
    if ($('#edd-list-item-well input[name="list_name"]').val() == '') {
        alert('Name is required');
    } else {
        var id = $('#edit-id-input').val();
        var name = $('#edit-listname-input').val();
        var description = $('#edit-listdescription-input').val();
        var data = "id="+id+"&name="+name+"&description="+description;
        data += "&submit=1&method=updateListItem";
        $.ajax({
            url: '/api/',
            data: data,
            type: "POST",
            timeout: 10000, //10 seconds
            success: function(response) {
                if (response != 'Success') {
                    alert('Something went wrong!');
                } else {
                    var url = '/listview/?list_id='+$('#main-list').data('listid');
                    refreshWell('list-items-well', url, function() {
                        changeWell('list-items-well');
                    });
                }
            },
            error: function(xhr, textStatus, errorThrown){
               alert('Connection lost! Unable to update item.');
            }
        });
    }
});

//onclick - add-list-item-well TO list-items-well
$(document).on('click', '#add-list-item-well .fa-arrow-left', function() {
    changeWell('list-items-well');
});

//onclick - list-items-well TO add-list-item-well
$(document).on('click', '#add-new-listitem', function() {
    changeWell('add-list-item-well');
});

//onclick - submit form to add new list item
$(document).on('click', '#add-list-item-well .fa-check-square', function(e) {
    if ($('#add-list-item-well input[name="list_name"]').val() == '') {
        alert('Name is required');
    } else {
        var listId = $('#main-list').data('listid');
        var name = $('#add-listname-input').val();
        var description = $('#add-listdescription-input').val();
        var data = "list_id="+listId+"&name="+name+"&description="+description;
        data += "&submit=1&method=addNewListItem";
        $.ajax({
            url: '/api/',
            data: data,
            type: "POST",
            timeout: 10000, //10 seconds
            success: function(response) {
                $('#add-listname-input').val('');
                $('#add-listdescription-input').val('');
                if (response != 'Success') {
                    alert('Something went wrong!');
                } else {
                    var url = '/listview/?list_id='+$('#main-list').data('listid');
                    refreshWell('list-items-well', url, function() {
                        changeWell('list-items-well');
                    });
                }
            },
            error: function(xhr, textStatus, errorThrown){
               alert('Connection lost! Unable to new item.');
            }
        });
    }
});

//onclick - delete item
$(document).on('dblclick', '#list-items-well .fa-times', function(e) {
    var id = $(this).data('id');
    var wellId = $(this).data('elid');
    data = "submit=1&method=deleteListItem&id="+id;
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
</script>
</html>