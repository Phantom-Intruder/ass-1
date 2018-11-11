<?php

class Book extends CI_Model {

    const DB_TABLE_NAME = 'book';
    const DB_TABLE_PK_VALUE = 'id';
    const DB_TABLE_USERID_VALUE = 'userId';
    const DB_TABLE_BOOKID_VALUE = 'bookId';
    const DB_TABLE_CATEGORY_ID_VALUE = 'categoryId';
    const DB_TABLE_NAME_USERBOOK = 'user_book';

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
     * Price of book
     * @var int
     */
    public $price;

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
     * Delete book
     * @param int $id
     */
    public function delete($id){
        $this->db->delete($this::DB_TABLE_NAME, array($this::DB_TABLE_PK_VALUE => $id));
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

    /**
     * Get number of all books by category ID
     * @param int categoryID
     * @return int of number of books from db, key is PK.
     */
    public function getNumberOfBooksInCategory($categoryId){
        $query = $this->db->get_where($this::DB_TABLE_NAME, array(
            $this::DB_TABLE_CATEGORY_ID_VALUE => $categoryId,
        ));
        $ret_value = array();
        $class = get_class($this);
        foreach ($query->result() as $row){
            $model = new $class;
            $model->populate($row);
            $ret_value[$row->{$this::DB_TABLE_PK_VALUE}] = $model;
        }
        return sizeof($ret_value);
    }

    /**
     * Get related books to book being currently viewed
     * @param int bookId
     * @return array of book models from db, key is PK.
     */
    public function getByBookId($bookId){
        $userID = $this->session->userUniqueId;

        $query = $this->db->query("SELECT
										book.*
									FROM
										(
										SELECT
											bookId,
											COUNT(*) AS viewCount
										FROM
											user_book UB2
										WHERE EXISTS (
											SELECT 1
											FROM
												user_book UB
											WHERE
												UB.bookId = ".$bookId." AND UB.userid != '".$userID."' AND UB.userId = UB2.userId
										) AND UB2.bookid != ".$bookId."
									GROUP BY
										bookId
									) temp
									INNER JOIN book ON book.id = temp.bookId
									ORDER BY
										viewCount
									DESC
									LIMIT 5");


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
     * Search by title or author
     * @param $searchTerm string
     * @return array of book models from db, key is PK.
     */
    public function GetBySearchTerm($searchTerm){
        $arrayLike = explode(' ', $searchTerm);
        foreach($arrayLike as $key => $value) {
            if($key == 0) {
                $this->db->like('title', $value);
            } else {
                $this->db->or_like('title', $value);
            }
        }
        foreach($arrayLike as $key => $value) {
            $this->db->or_like('author', $value);
        }
        $query = $this->db->get($this::DB_TABLE_NAME);
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