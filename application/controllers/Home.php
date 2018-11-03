<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    /**
     * Index Page for Book controller.
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
        $this->load->library('table');
        $this->load->model('Book');
        $books = $this->Book->get();
        $books_list = array();
        foreach ($books as $book){
            $books_list[] = array(
              $book->title,
              $book->categoryId,
              $book->author
            );
        }
        $this->load->view('Book/List', $books_list);
    }
}
