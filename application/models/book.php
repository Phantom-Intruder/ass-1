<?php

class Book extends MyModel {

    const DB_TABLE = 'book';
    const DB_TABLE_PK = 'id';

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
     * Book category
     * @var int
     */
    public $category;
    /**
     * Number of people who viewed a particular book
     * @var int
     */
    public $visitorStats;
    /**
     * Author or authors
     * @var string
     */
    public $author;
}