<?php
class UserBook extends CI_Model
{
    const DB_TABLE_NAME = 'user_book';
    const DB_TABLE_PK_VALUE = 'id';
    const DB_TABLE_BOOKID_VALUE = 'bookId';


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

    /**
     * Load User view data from the database
     * @param int $bookId
     * @return array of UserView models from db, key is PK.
     */
    public function getByBookId($bookId){
        $query = $this->db->get_where($this::DB_TABLE_NAME, array(
            $this::DB_TABLE_BOOKID_VALUE => $bookId,
        ));
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
     * Populate data from an array
     * @param mixed $row
     */
    public function populate($row){
        foreach ($row as $key => $value){
            $this->$key = $value;
        }
    }
}