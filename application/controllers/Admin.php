<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    /**
     * Index Page for Admin controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/book
     *	- or -
     * 		http://example.com/index.php/book/index
     *	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */
    public function index()
    {
        $this->load->model('book');
        $book = new Book();
        $book->title = "Thinking, fast and slow";
        $book->cover = "somewhere";
        $book->visitorStats = 100;
        $book->categoryId = 1;
        $book->authorId = 1;

        $book->save();

        echo '<tt><pre>' . var_export($book, TRUE) . '</pre></tt>';
        $this->load->view('admin');
    }
}
