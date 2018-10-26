<?php

class Book extends CI_Model {
    /**
     * Book number unique id
     * @var int
     */
    public $bookId;
    /**
     * Book title
     * @var string
     */
    public $bookTitle;
    /**
     * Book category
     * @var string
     */
    public $bookCategory;
    /**
     * Number of people who viewed a particular book
     * @var int
     */
    public $bookVisitorStats;
    /**
     * Author or authors
     * @var string
     */
    public $bookAuthor;
}