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
    public function listByCategory($categoryId){
        $this->output->enable_profiler(TRUE);
        $this->load->view('Navigation/header');
        $this->load->library('table');
        $this->load->model('Book');
        $books = $this->Book->getByCategoryId($categoryId);
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
}
