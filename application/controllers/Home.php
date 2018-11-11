<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    /**
     * Home constructor.
     * Checks if user has a unique ID set
     */
    function __construct() {
        parent::__construct();
        //Set a unique ID for the user
        if (!isset($this->session->userUniqueId)){
            $this->session->userUniqueId = uniqid();
        }
    }

    /**
     * Index Page for Book controller.
     */
    public function index()
    {
        $this->load->view('Navigation/UserNavigation/header');
        $this->load->library('table');
        $this->load->model('Category');
        $categories = $this->Category->get();
        $categoriesList = array();

        foreach ($categories as $category) {
            $categoriesList[] = array(
                anchor('Home/Category/List/' . $category->id, $category->name),
            );
        }
        $this->load->view('Category/List', array(
            'categories' => $categoriesList
        ));
        $this->load->view('Navigation/UserNavigation/footer');
    }


    /**
     * View books in a particular category
     * @param int categoryId
     * @param int $limit
     * @param int $offset
     */
    public function listByCategory($categoryId, $limit = 3, $offset = 0){
        $this->config->set_item('numberOfPages', $limit);
        $this->load->library('table');
        $this->load->model('Book');
        $books = $this->Book->getByCategoryId($categoryId, $limit, $offset);
        $booksList = array();
        $bookCount = $this->Book->getNumberOfBooksInCategory($categoryId);
        $pages = ceil($bookCount/$this->config->item('numberOfPages'));
        $this->load->view('Navigation/UserNavigation/header');
        foreach ($books as $book){
            $this->load->model('Category');
            $category = new Category();
            $category->load($book->categoryId);
            $booksList[] = array(
                img(array('src'=> 'assets/'.$book->cover, 'alt'=>'Image not found','width'=>'100px', 'height'=>'100px')),
                anchor('Home/Book/Show/' . $book->id, $book->title),
                $book->price,
                $category->name,
                $book->author,
                anchor('Home/Cart/Add/' . $book->id, 'Add to shopping cart'),
            );
        }
        $this->load->view('Book/List', array(
            'books' => $booksList,
            'page' => $pages,
            'categoryId' => $categoryId
        ));
        $this->load->view('Navigation/UserNavigation/footer');
    }

    /**
     * Show individual book details
     * @param int $id
     */
    public function showBook($id){

        //Record details of book visit

        $this->load->model('UserBook');
        $userBook = new UserBook();
        $userBook->userId = $this->session->userUniqueId;
        $userBook->bookId = $id;
        date_default_timezone_set('Asia/Colombo');
        $userBook->dateViewed = date("Y-m-d H:i:s");
        $userBook->save();

        $this->load->helper('html');
        $this->load->view('Navigation/UserNavigation/header');
        $this->load->model('Book');
        $book = new Book();
        $book->load($id);

        if (!$book->id){
            show_404();
        }
        $this->load->library('table');

        $recommendedBooks = $this->Book->getByBookId($book->id);
        $recommendedBooksList = array();

        foreach ($recommendedBooks as $recommendedBook){
            $this->load->model('Category');
            $category = new Category();
            $category->load($book->categoryId);
            $recommendedBooksList[] = array(
                img(array('src'=> 'assets/'.$recommendedBook->cover, 'alt'=>'Image not found','width'=>'100px', 'height'=>'100px')),
                anchor('Home/Book/Show/' . $recommendedBook->id, $recommendedBook->title),
                $book->price,
                $category->name,
                $book->author,
                anchor('Home/Cart/Add/' . $book->id, 'Add to shopping cart'),
            );
        }

        $this->load->model('Category');
        $category = new Category();
        $category->load($book->categoryId);
        $this->load->view('Book/View', array(
            'book' => $book,
            'category' => $category,
            'recommendedBooks' => $recommendedBooksList
        ));
        $this->load->view('Navigation/UserNavigation/footer');
    }

    /**
     * Add a book to shopping cart
     * @param int bookId
     */
    public function addToCart($bookId){
        $alreadyAddedBooks = array();

        //Set book Id to session object
        if (isset($this->session->userCart)){
            //create new cart for user and add to cart
            $alreadyAddedBooks  = $this->session->userCart;
        }

        //Add to cart
        if (!in_array($bookId, $alreadyAddedBooks)){
            array_push($alreadyAddedBooks, $bookId);
        }
        $this->session->userCart = $alreadyAddedBooks;

        $this->load->view('Cart/InsertSuccess',array(
            'cart' => $alreadyAddedBooks
        ));
        redirect('/Home/Cart/Show', 'refresh');
    }

    /**
     * Show shopping cart
     */
    public function showCart(){
        $this->load->view('Navigation/UserNavigation/header');
        $this->load->library('table');
        $this->load->model('Book');
        $booksList = array();
        if(isset($this->session->userCart)) {
            $bookIDInCart = $this->session->userCart;
            foreach ($bookIDInCart as $bookID) {
                $book = new Book();
                $book->load($bookID);
                $this->load->model('Category');
                $category = new Category();
                $category->load($book->categoryId);
                $booksList[] = array(
                    img(array('src' => 'assets/' . $book->cover, 'alt' => 'Image not found', 'width' => '100px', 'height' => '100px')),
                    anchor('Home/Book/Show/' . $book->id, $book->title),
                    $book->price,
                    $category->name,
                    $book->author,
                    anchor('Home/Cart/Delete/' . $book->id, "Delete from shopping cart"),
                );
            }
        }
        $this->load->view('Cart/View', array(
            'books' => $booksList
        ));
        $this->load->view('Navigation/UserNavigation/footer');
    }

    /**
     * Delete book from shopping cart
     * @param int $bookId
     */
    public function deleteFromCart($bookId){
        $this->load->view('Navigation/UserNavigation/header');

        $alreadyAddedBooks = array();

        //Set book Id to session object
        if (isset($this->session->userCart)){
            //TODO: create new cart for user and add to cart
            $alreadyAddedBooks  = $this->session->userCart;
        }

        //Add to cart
        if (in_array($bookId, $alreadyAddedBooks)){
            $alreadyAddedBooks = array_diff($alreadyAddedBooks, array($bookId));
        }
        $this->session->userCart = $alreadyAddedBooks;

        $this->load->view('Cart/DeleteSuccess',array(
            'cart' => $alreadyAddedBooks
        ));
        $this->load->view('Navigation/UserNavigation/footer');

    }
}
