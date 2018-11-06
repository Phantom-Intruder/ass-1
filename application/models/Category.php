<?php

class Category extends CI_Model {

    const DB_TABLE_NAME = 'category';
    const DB_TABLE_PK_VALUE = 'id';
    const DB_TABLE_FIELD_NAME_VALUE = 'name';

    /**
     * Category number unique id
     * @var int
     */
    public $id;
    /**
     * Category name
     * @var string
     */
    public $name;

    /**
     * Create a record for Category.
     */
    private function insert(){
        $this->db->insert($this::DB_TABLE_NAME, $this);
        $this->{$this::DB_TABLE_PK_VALUE} = $this->db->insert_id();
    }

    /**
     * If the record for category is there then update.
     * Else insert.
     */
    public function save(){
        if (isset($this->{$this::DB_TABLE_PK_VALUE})){
            $this->update();
        }else{
            $this->insert();
        }
    }

    /**
     * Update category details
     */
    private function update(){
        $this->db->update($this::DB_TABLE_NAME, $this, $this::DB_TABLE_PK_VALUE);
    }

    /**
     * Load category data from the database
     * @param int $id
     */
    public function load($id){
        $query = $this->db->get_where($this::DB_TABLE_NAME, array(
            $this::DB_TABLE_PK_VALUE => $id,
        ));
        $this->populate($query->row());
    }

    /**
     * Load category data from the database using category name
     * @param string $name
     */
    public function loadByName($name){
        $query = $this->db->get_where($this::DB_TABLE_NAME, array(
            $this::DB_TABLE_FIELD_NAME_VALUE => $name,
        ));
        $this->populate($query->row());
    }

    /**
     * Populate data from an array
     * @param mixed $row
     */
    public function populate($row){
        foreach ($row as $key => $value){
            $this->$key = $value;
        }
    }

    /**
     * Retrieve array of category models.
     *
     * @param int $limit
     * @param int $offset
     * @return array of category models from db, key is PK.
     */
    public function get($limit = 0, $offset = 0){
        if ($limit){
            $query = $this->db->get($this::DB_TABLE_NAME, $limit, $offset);
        }
        else{
            $query = $this->db->get($this::DB_TABLE_NAME);
        }
        $ret_value = array();
        $class = get_class($this);
        foreach ($query->result() as $row){
            $model = new $class;
            $model->populate($row);
            $ret_value[$row->{$this::DB_TABLE_PK_VALUE}] = $model;
        }
        return $ret_value;
    }

    public function checkIfExists($categoryName){

    }
}