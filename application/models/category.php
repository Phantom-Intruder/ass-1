<?php

class Category extends My_Model {

    const DB_TABLE_NAME = 'category';
    const DB_TABLE_PK_VALUE = 'id';

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
     * Populate data from an array
     * @param mixed $row
     */
    public function populate($row){
        foreach ($row as $key => $value){
            $this->$key = $value;
        }
    }
}