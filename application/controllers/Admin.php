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

        /**
            $this->load->model('category');
            $book = new Category();
            $book->name = "Science Fiction";

            $book->save();

            echo '<tt><pre>' . var_export($book, TRUE) . '</pre></tt>';
        */
        $this->load->view('Admin/index');
    }

    /**
     * Add Book
     */
    public function add(){
        $this->output->enable_profiler(TRUE);
        $this->load->helper('form');
        $this->load->model('Category');
        $categories = $this->Category->get();
        $category_options = array();
        foreach ($categories as $id => $category){
            $category_options[$id] = $category->name;
        }

        $this->load->library('form_validation');
        $this->form_validation->set_rules(array(
            array(
                'field' => 'title',
                'label' => 'Title',
                'rules' => 'required',
            ),
            array(
                'field' => 'cover',
                'label' => 'Cover',
                'rules' => '',
            ),
            array(
                'field' => 'categoryId',
                'label' => 'Category',
                'rules' => 'required',
            ),
            array(
                'field' => 'author',
                'label' => 'Authors',
                'rules' => 'required',
            )
        ));
        $this->form_validation->set_error_delimiters('<div class="alert alert-error">', '</div>');
        if (!$this->form_validation->run()){
            $this->load->view('Book/insert_form', array(
                'category_options' => $category_options,
            ));
        }
        else{
            $this->load->model('Book');
            $book = new Book();
            $book->categoryId = $this->input->post('categoryId');
            $book->title = $this->input->post('title');
            $book->cover = $this->input->post('cover');
            $book->author = $this->input->post('author');
            print_r('', $book);
            $book->save();
            $this->load->view('Book/insert_success', array(
                'book' => $book,
            ));
        }
    }
}
