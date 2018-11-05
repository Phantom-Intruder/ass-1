<?php

class Book extends CI_Model {

    const DB_TABLE_NAME = 'book';
    const DB_TABLE_PK_VALUE = 'id';
    const DB_TABLE_CATEGORY_ID_VALUE = 'categoryId';

    /**
     * Book number unique id
     * @var int
     */
    public $id;

    /**
     * Book title
     * @var string
     */
    public $title;

    /**
     * Path to cover of the book
     * @var string
     */
    public $cover;

    /**
     * Number of people who viewed a particular book
     * @var int
     */
    public $visitorStats;

    /**
     * Book category
     * @var int
     */
    public $categoryId;

    /**
     * Author or authors
     * @var string
     */
    public $author;

    /**
     * Create a record for book.
     */
    private function insert(){
        $this->db->insert($this::DB_TABLE_NAME, $this);
        $this->{$this::DB_TABLE_PK_VALUE} = $this->db->insert_id();
    }

    /**
     * If the record for book is there then update.
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
     * Update book details
     */
    private function update(){
        $this->db->update($this::DB_TABLE_NAME, $this, $this::DB_TABLE_PK_VALUE);
    }

    /**
     * Load book data from the database
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

    /**
     * Retrieve array of book models.
     *
     * @param int $limit
     * @param int $offset
     * @return array of book models from db, key is PK.
     */
    public function get($limit = 100, $offset = 0){
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

    /**
     * Get all the books by category ID
     * @param int categoryID
     * @param int $limit
     * @param int $offset
     * @return array of book models from db, key is PK.
     */
    public function getByCategoryId($categoryId, $limit = 100, $offset = 0){
        $query = $this->db->get_where($this::DB_TABLE_NAME, array(
            $this::DB_TABLE_CATEGORY_ID_VALUE => $categoryId,
        ), $limit, $offset);
        $ret_value = array();
        $class = get_class($this);
        foreach ($query->result() as $row){
            $model = new $class;
            $model->populate($row);
            $ret_value[$row->{$this::DB_TABLE_PK_VALUE}] = $model;
        }
        return $ret_value;
    }
}