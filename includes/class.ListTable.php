<?php

class ListTable extends Table
{
    public function fetchAll()
    {
        $sql = "SELECT * FROM lists";
        if (!$result = $this->getMysqli()->query($sql)) {
            throw new Exception('No results');
        }
        while($row = $result->fetch_assoc()) {
            $lists[] = new AList($row['id'], $row['name']);
        }
        return $lists;
    }

    public function getListById($id)
    {
        $sql = "SELECT * FROM lists WHERE id = $id";
        if (!$result = $this->getMysqli()->query($sql)) {
            throw new Exception('No results');
        }
        $row = $result->fetch_assoc();
        $list = new AList($row['id'], $row['name']);
        return $list;
    }

    public function addList(AList $list)
    {
        $list_name = $this->getMysqli()->real_escape_string($list->getName());
        $sql = "INSERT INTO lists VALUES(null, '$list_name')";
        if (!$result = $this->getMysqli()->query($sql)) {
            throw new Exception('Failed to save to db');
        }
        return true;
    }

    public function updateList(AList $list)
    {
        $list->setId($this->getMysqli()->real_escape_string($list->getId()));
        $list->setName($this->getMysqli()->real_escape_string($list->getName()));
        $sql = "UPDATE lists SET name = '".$list->getName()."' WHERE  id = '".$list->getId()."'";
        if (!$result = $this->getMysqli()->query($sql)) {
            throw new Exception('Failed to save to db');
        }
        return true;
    }

    public function deleteListById($id)
    {
        $id = $this->getMysqli()->real_escape_string($id);
        $sql = "DELETE FROM lists WHERE id = '$id'";
        if (!$result = $this->getMysqli()->query($sql)) {
            throw new Exception('Failed to save to db');
        }
        return true;
    }
}