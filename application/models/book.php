<?php

class Book extends CI_Model {

    const DB_TABLE_NAME = 'book';
    const DB_TABLE_PK_VALUE = 'id';

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
     * @var int
     */
    public $authorId;

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
}