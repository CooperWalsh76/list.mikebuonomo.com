<?php

class ListItemTable extends Table
{
    public function fetchAll()
    {
        $sql = "SELECT * FROM list_items";
        if (!$result = $this->getMysqli()->query($sql)) {
            throw new Exception('No results');
        }
        while($row = $result->fetch_assoc()) {
            $listItems[] = new ListItem(
                $row['id'],
                $row['list_id'],
                $row['name'],
                $row['description'],
                $row['is_checked'],
                $row['last_updated']
            );
        }
        return $listItems;
    }

    public function getItemsByListId($list_id)
    {
        $list_id = $this->getMysqli()->real_escape_string($list_id);
        $sql = "SELECT * FROM list_items WHERE list_id = $list_id";
        if (!$result = $this->getMysqli()->query($sql)) {
            throw new Exception('No results');
        }
        while($row = $result->fetch_assoc()) {
            $listItems[] = new ListItem(
                $row['id'],
                $row['list_id'],
                $row['name'],
                $row['description'],
                $row['is_checked'],
                $row['last_updated']
            );
        }
        return $listItems;
    }

    public function getItemsByListName($list_name)
    {
        $list_name = $this->getMysqli()->real_escape_string($list_name);
        $sql = "SELECT li.*
                FROM lists l
                JOIN list_items li ON l.id = li.list_id
                WHERE l.name = $list_name";
        if (!$result = $this->getMysqli()->query($sql)) {
            throw new Exception('No results');
        }
        while($row = $result->fetch_assoc()) {
            $listItems[] = new ListItem(
                $row['id'],
                $row['list_id'],
                $row['name'],
                $row['description'],
                $row['is_checked'],
                $row['last_updated']
            );
        }
        return $listItems;
    }

    public function checkItemById($id, $is_checked)
    {
        $id         = $this->getMysqli()->real_escape_string($id);
        $is_checked = $this->getMysqli()->real_escape_string($is_checked);
        $sql = "UPDATE list_items SET is_checked = '$is_checked' WHERE id = '$id'";
        if (!$result = $this->getMysqli()->query($sql)) {
            throw new Exception('Failed to save to db');
        }
        return true;
    }

    public function addItem(ListItem $listItem)
    {
        $listItem->setListId($this->getMysqli()->real_escape_string($listItem->getListId()));
        $listItem->setName($this->getMysqli()->real_escape_string($listItem->getName()));
        $listItem->setDescription($this->getMysqli()->real_escape_string($listItem->getDescription()));
        $sql = "INSERT INTO list_items VALUES(NULL, '".$listItem->getListId()."', '".$listItem->getName()."', '".$listItem->getDescription()."', '0', NULL)";
        if (!$result = $this->getMysqli()->query($sql)) {
            throw new Exception('Failed to save to db');
        }
        return true;
    }

    public function updateItem(ListItem $listItem)
    {
        $listItem->setId($this->getMysqli()->real_escape_string($listItem->getId()));
        $listItem->setName($this->getMysqli()->real_escape_string($listItem->getName()));
        $listItem->setDescription($this->getMysqli()->real_escape_string($listItem->getDescription()));
        $sql = "UPDATE list_items SET name = '".$listItem->getName()."', description = '".$listItem->getDescription()."' WHERE  id = '".$listItem->getId()."'";
        if (!$result = $this->getMysqli()->query($sql)) {
            throw new Exception('Failed to save to db');
        }
        return true;
    }

    public function deleteItemById($id)
    {
        $id = $this->getMysqli()->real_escape_string($id);
        $sql = "DELETE FROM list_items WHERE id = '$id'";
        if (!$result = $this->getMysqli()->query($sql)) {
            throw new Exception('Failed to save to db');
        }
        return true;
    }
}