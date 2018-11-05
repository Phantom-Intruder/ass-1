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
        $this->load->view('Navigation/header');
        $this->load->library('table');
        $this->load->model('Book');
        $books = $this->Book->get();
        $books_list = array();
        foreach ($books as $book){
            $this->load->model('Category');
            $category = new Category();
            $category->load($book->categoryId);
            $books_list[] = array(
                img(array('src'=> 'assets/'.$book->cover, 'alt'=>'Image not found','width'=>'100px', 'height'=>'100px')),
                anchor('Admin/showBook/' . $book->id, $book->title),
                $category->name,
                $book->author,
            );
        }

        $this->load->view('Book/List', array(
            'books' => $books_list
        ));
        $this->load->view('Navigation/footer');
    }

    /**
     * View list of categories
     */
    public function listCategories()
    {
        $this->load->view('Navigation/header');
        $this->load->library('table');
        $this->load->model('Category');
        $categories = $this->Category->get();
        $categories_list = array();

        foreach ($categories as $category) {
            $categories_list[] = array(
                anchor('Home/listByCategory/' . $category->id, $category->name),
            );
        }
        $this->load->view('Category/List', array(
            'categories' => $categories_list
        ));
        $this->load->view('Navigation/footer');
    }

    /**
     * View books in a particular category
     * @param int categoryId
     */
    public function listByCategory($categoryId, $limit = 2, $offset = 0){
        $this->output->enable_profiler(TRUE);
        $this->load->view('Navigation/header');
        $this->load->library('table');
        $this->load->model('Book');
        $books = $this->Book->getByCategoryId($categoryId, $limit, $offset);
        $books_list = array();
        $pages = sizeof($books)/2;
        foreach ($books as $book){
            $this->load->model('Category');
            $category = new Category();
            $category->load($book->categoryId);
            $books_list[] = array(
                img(array('src'=> 'assets/'.$book->cover, 'alt'=>'Image not found','width'=>'100px', 'height'=>'100px')),
                anchor('Home/showBook/' . $book->id, $book->title),
                $category->name,
                $book->author,
            );
        }

        $this->load->view('Book/List', array(
            'books' => $books_list,
            'page' => $pages,
            'categoryId' => $books_list[0]->categoryId
        ));
        $this->load->view('Navigation/footer');
    }

    /**
     * Show individual book details
     * @param int $id
     */
    public function showBook($id){
        $this->output->enable_profiler(TRUE);

        $this->load->helper('html');
        $this->load->view('Navigation/header');
        $this->load->model('Book');
        $book = new Book();
        $book->load($id);
        if (!$book->id){
            show_404();
        }
        $this->load->model('Category');
        $category = new Category();
        $category->load($book->categoryId);
        $this->load->view('Admin/Book/View', array(
            'book' => $book,
            'category' => $category
        ));
        $this->load->view('Navigation/Footer');
    }

}
