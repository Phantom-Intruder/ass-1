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
            $book->name = "Self help";

            $book->save();

            echo '<tt><pre>' . var_export($book, TRUE) . '</pre></tt>';
        **/
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
                $book->visitorStats,
                $category->name,
                $book->author,
                anchor('Admin/deleteBook/' . $book->id, 'Delete'),
            );
        }

        $this->load->view('Admin/index', array(
             'books' => $books_list
        ));
        $this->load->view('Navigation/footer');
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

        $this->load->view('Navigation/header');
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
        $this->load->view('Navigation/footer');
    }

    /**
     * Loads view for adding a category
     */
    public function addCategory()
    {
        $this->load->view('Navigation/header');
        $this->load->helper('form');

        $this->load->library('form_validation');
        $this->form_validation->set_rules('name', 'Category Name', 'required'); // | callback_checkIfExistingCategory

        $this->form_validation->set_error_delimiters('<div class="alert alert-error">', '</div>');
        if (!$this->form_validation->run()){
            $this->load->view('Admin/Category/InsertForm');
        }
        else{
            $this->load->model('Category');
            $category = new Category();
            $category->name = $this->input->post('name');
            $category->save();

            $this->load->view('Admin/Category/InsertSuccess', array(
            'book' => $category,
            ));
        }
        $this->load->view('Navigation/footer');
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

    /**
     * Search by author or book title
     * @param string searchTerm
     */
    public function searchBook($searchTerm){
        $this->load->view('Navigation/header');
        $this->load->helper('form');
        if (empty($searchTerm)){
            //TODO: No parameters, just show empty box
            $this->load->view('Admin/Search/index', array(
                'search' => $searchTerm,
            ));
        }else{
            //Has parameters, perform search
            $this->load->model('Book');
            $search = new Search();
            $search->searchTerm = $this->input->post('searchTerm');
            $category->save();

            $this->load->view('Admin/Category/InsertSuccess', array(
                'book' => $category,
            ));
        }
        $this->load->view('Navigation/footer');
    }

}
