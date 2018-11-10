<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    /**
     * Admin constructor.
     * Checks if user is admin
     */
    function __construct() {
        parent::__construct();
        //Set a unique ID for the user
        if (!isset($this->session->userIsAdmin)){
            $this->load->helper('form');
            $this->load->library('form_validation');
            $this->form_validation->set_rules(array(
                array(
                    'field' => 'userName',
                    'label' => 'Username',
                    'rules' => 'required|callback_checkAdminUserName',
                ),
                array(
                    'field' => 'password',
                    'label' => 'Password',
                    'rules' => 'required|callback_checkAdminPassword',
                )
            ));
            $this->form_validation->set_error_delimiters('<div class="card red">', '</div>');
            if (!$this->form_validation->run()){
                echo $this->load->view('Admin/Login/index', '', TRUE);
                die();
            }else{
                //set session
                $this->session->userIsAdmin = TRUE;
            }
        }
    }

    /**
     * Index Page for Admin controller.
     */
    public function index()
    {
        /**
            $this->load->model('category');
            $book = new Category();
            $book->name = "Self help";

            $book->save();

            echo '<tt><pre>' . var_export($book, TRUE) . '</pre></tt>';
        **/
        $this->load->view('Navigation/AdminNavigation/Header');
        $this->load->library('table');
        $this->load->model('Book');
        $books = $this->Book->get();
        $books_list = array();
        foreach ($books as $book){
            $this->load->model('Category');
            $category = new Category();
            $category->load($book->categoryId);

            $this->load->model('UserBook');
            $userBook = new UserBook();
            $viewArray = $userBook->getByBookId($book->id);
            $books_list[] = array(
                img(array('src'=> 'assets/'.$book->cover, 'alt'=>'Image not found','width'=>'100px', 'height'=>'150px')),
                anchor('Admin/showBook/' . $book->id, $book->title),
                $book->price,
                sizeof($viewArray),
                $category->name,
                $book->author,
                anchor('Admin/deleteBook/' . $book->id, 'Delete'),
            );
        }

        $this->load->view('Admin/index', array(
             'books' => $books_list
        ));
        $this->load->view('Navigation/AdminNavigation/footer');
    }

    /**
     * Loads view for adding Book
     */
    public function addBook(){
        $config = array(
            'upload_path' => 'assets',
            'allowed_types' => 'gif|jpg|png',
            'max_size' => 250,
            'max_width' => 1920,
            'max_height' => 1080,
        );

        $this->load->library('upload', $config);

        $this->load->view('Navigation/AdminNavigation/header');
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
                'field' => 'price',
                'label' => 'Price',
                'rules' => 'required',
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
        $this->form_validation->set_error_delimiters('<div class="card red">', '</div>');
        $check_file_upload = FALSE;
        if (isset($_FILES['cover']['error']) && ($_FILES['cover']['error'] != 4)) {
            $check_file_upload = TRUE;
        }
        if (!$this->form_validation->run() || ($check_file_upload && !$this->upload->do_upload('cover'))){
            $this->load->view('Admin/Book/InsertForm', array(
                'category_options' => $category_options,
            ));
        }
        else{
            $this->load->model('Book');
            $book = new Book();
            $book->categoryId = $this->input->post('categoryId');
            $book->title = $this->input->post('title');
            $book->price = $this->input->post('price');
            $book->cover = $this->input->post('cover');
            $book->author = $this->input->post('author');
            $book->visitorStats = 0;
            $upload_data = $this->upload->data();
            if (isset($upload_data['file_name'])) {
                print_r('', $upload_data['file_name']);
                $book->cover = $upload_data['file_name'];
            }
            $book->save();
            $this->load->view('Admin/Book/InsertSuccess', array(
                'book' => $book,
            ));
        }
        $this->load->view('Navigation/AdminNavigation/footer');
    }

    /**
     * Delete Book
     * @param int $bookId
     */
    public function deleteBook($bookId){
        $this->load->view('Navigation/AdminNavigation/header');
        $this->load->model('Book');
        $book = new Book();
        $book->load($bookId);
        if (!$book->id){
            show_404();
        }
        $book->delete($bookId);
        $this->load->view('Admin/Book/DeleteSuccess', array(
            'book' => $book,
        ));
        $this->load->view('Navigation/AdminNavigation/footer');
    }

    /**
     * Loads view for adding a category
     */
    public function addCategory()
    {
        $this->load->view('Navigation/AdminNavigation/header');
        $this->load->helper('form');

        $this->load->library('form_validation');
        $this->form_validation->set_rules('name', 'Category Name', 'required'); // | callback_checkIfExistingCategory

        $this->form_validation->set_error_delimiters('<div class="card red">', '</div>');
        if (!$this->form_validation->run()){
            $this->load->view('Admin/Category/InsertForm');
        }
        else{
            $this->load->model('Category');
            $category = new Category();
            $category->name = $this->input->post('name');
            $category->save();

            $this->load->view('Admin/Category/InsertSuccess', array(
                'category' => $category,
            ));
        }
        $this->load->view('Navigation/AdminNavigation/footer');
    }

    /**
     * Callback that checks if category already exists
     * @param string $input
     * @return boolean
     */
    public function checkIfExistingCategory($input){
        $data = array();

        $this->load->model('Category');
        $category = new Category();
        $category->loadByName($input);
        $data['Category'] = $category;

        if (empty($data)){
            return TRUE;
        }else{
            $this->form_validation->set_message(__FUNCTION__, 'This category has already been added to the database');
            return FALSE;
        }
    }

    /**
     * Show individual book details
     * @param int $id
     */
    public function showBook($id){
        $this->output->enable_profiler(TRUE);

        $this->load->helper('html');
        $this->load->view('Navigation/AdminNavigation/header');
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
        $this->load->view('Navigation/AdminNavigation/footer');
    }

    /**
     * Search by author or book title
     */
    public function searchBook(){
        $this->load->view('Navigation/AdminNavigation/header');
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('search', 'Search', 'required');

        $this->form_validation->set_error_delimiters('<div class="card red">', '</div>');
        if (!$this->form_validation->run()){
            $this->load->view('Admin/Search/index');
        }
        else{
            $this->output->enable_profiler(TRUE);

            $searchTerm = $this->input->post('search');
            $this->load->library('table');
            $this->load->model('Book');
            $books = $this->Book->GetBySearchTerm($searchTerm);
            $books_list = array();

            foreach ($books as $book){
                $this->load->model('Category');
                $category = new Category();
                $category->load($book->categoryId);
                $books_list[] = array(
                    img(array('src'=> 'assets/'.$book->cover, 'alt'=>'Image not found','width'=>'100px', 'height'=>'100px')),
                    anchor('Admin/showBook/' . $book->id, $book->title),
                    $book->price,
                    $book->visitorStats,
                    $category->name,
                    $book->author,
                    anchor('Home/addToCart/' . $book->id, 'Add to shopping cart'),
                );
            }

            $this->load->view('Admin/index', array(
                'books' => $books_list,
            ));
        }
        $this->load->view('Navigation/AdminNavigation/footer');
    }

    /**
     * receive admin username
     * Check to see if correct
     * return true
     * else false
     * @param string $userName
     * @return boolean
     */
    public function checkAdminUserName($userName){
        if ($userName == 'admin'){
            return TRUE;
        }else{
            $this->form_validation->set_message('checkAdminUserName', 'error');
            return FALSE;
        }
    }

    /**
     * receive admin password
     * Check to see if correct
     * return true
     * else false
     * @param string $password
     * @return boolean
     */
    public function checkAdminPassword($password){
        if ($password == 'admin123'){
            return TRUE;
        }else{
            $this->form_validation->set_message('checkAdminPassword', 'error2');
            return FALSE;
        }
    }
}
