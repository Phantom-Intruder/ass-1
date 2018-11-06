<?php
class UserBook extends CI_Model
{
    const DB_TABLE_NAME = 'user_book';
    const DB_TABLE_PK_VALUE = 'id';

    /**
     * Unique id of table
     * @var int
     */
    public $id;

    /**
     * Unique id of User
     * @var int
     */
    public $userId;

    /**
     * Unique id of Book
     * @var int
     */
    public $bookId;

    /**
     * Timestamp
     * @var int
     */
    public $dateViewed;

    /**
     * Create a record for User and Book.
     */
    private function insert(){
        $this->db->insert($this::DB_TABLE_NAME, $this);
        $this->{$this::DB_TABLE_PK_VALUE} = $this->db->insert_id();
    }

    /**
     * Insert.
     */
    public function save(){
        $this->insert();
    }
}