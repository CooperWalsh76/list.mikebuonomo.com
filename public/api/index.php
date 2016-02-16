<?php
require_once '/var/www/sites/list.mikebuonomo.com/config.php';

if (!isset($_POST['submit']) || $_POST['submit'] != '1' || strpos($_SERVER['HTTP_REFERER'], "http://list.mikebuonomo.com") === false) {
    echo strpos($_SERVER['HTTP_REFERER'], "http://list.mikebuonomo.com");
    exit;
}

$listTable     = new ListTable();
$listItemTable = new ListItemTable();

switch ($_POST['method']) {
    case 'addNewList':
        $name = $_POST['list_name'];
        if (!isset($name) || $name == '') {
            echo "Fail";
            exit;
        }
        $list = new AList(null, $name);
        try {
            $result = $listTable->addList($list);
            echo "Success";
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        break;

    case 'checkbox':
        if ($_POST['checkbox_val'] != '1' && $_POST['checkbox_val'] != '0') {
            echo "Fail";
            exit;
        } else if ($_POST['listItemId'] == '') {
            echo "Fail";
            exit;
        }
        try {
            $listItemTable->checkItemById($_POST['listItemId'], $_POST['checkbox_val']);
            echo "Success";
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        break;

    case 'addNewListItem':
        if ($_POST['list_id'] == '' || $_POST['name'] == '' || $_POST['description'] == '') {
            echo "Fail";
            exit;
        }
        $listItem = new ListItem(
            null,
            $_POST['list_id'],
            $_POST['name'],
            $_POST['description'],
            null,
            null
        );
        try {
            $listItemTable->addItem($listItem);
            echo "Success";
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        break;

    case 'updateListItem':
        if ($_POST['id'] == '' || $_POST['name'] == '' || $_POST['description'] == '') {
            echo "Fail";
            exit;
        }
        $listItem = new ListItem(
            $_POST['id'],
            null,
            $_POST['name'],
            $_POST['description'],
            null,
            null
        );
        try {
            $listItemTable->updateItem($listItem);
            echo "Success";
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        break;

    case 'deleteListItem':
        if ($_POST['id'] == '') {
            echo "Fail";
            exit;
        }
        try {
            $listItemTable->deleteItemById($_POST['id']);
            echo "Success";
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        break;

    case 'updateListName':
        if ($_POST['id'] == '' || $_POST['list_name'] == '') {
            echo "Fail";
            exit;
        }
        $list = new AList($_POST['id'], $_POST['list_name']);
        try {
            $listTable->updateList($list);
            echo "Success";
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        break;

    case 'deleteList':
        if ($_POST['id'] == '') {
            echo "Fail";
            exit;
        }
        try {
            $listTable->deleteListById($_POST['id']);
            echo "Success";
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        break;
}