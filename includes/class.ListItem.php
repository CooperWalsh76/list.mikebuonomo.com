<?php

class ListItem
{
    private $id;
    private $list_id;
    private $name;
    private $description;
    private $is_checked;
    private $last_updated;

    public function __construct($id, $list_id, $name, $description, $is_checked, $last_updated)
    {
        $this->id           = $id;
        $this->list_id      = $list_id;
        $this->name         = $name;
        $this->description  = $description;
        $this->is_checked   = $is_checked;
        $this->last_updated = $last_updated;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getListId()
    {
        return $this->list_id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getIsChecked()
    {
        return $this->is_checked;
    }

    public function getLastUpdated()
    {
        return $this->last_updated;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setListId($list_id)
    {
        $this->list_id = $list_id;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function setIsChecked($is_checked)
    {
        $this->is_checked = $is_checked;
    }

    public function setLastUpdated($last_updated)
    {
        $this->last_updated = $last_updated;
    }
}