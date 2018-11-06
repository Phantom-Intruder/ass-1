<?php

class User extends CI_Model
{

    const DB_TABLE_NAME = 'user';
    const DB_TABLE_PK_VALUE = 'id';

    /**
     * User number unique id
     * @var int
     */
    public $id;

    /**
     * Unique shopping cart assigned to the user
     * @var int
     */
    public $cartId;

}