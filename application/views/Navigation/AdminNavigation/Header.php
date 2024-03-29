<?php
// Quick and dirty navigation.
$menu_item_default = 'index';
$menu_items = array(
    'index' => array(
    'label' => 'Home',
    'desc' => 'A list of all categories',
  ),
  'Book/Add' => array(
    'label' => 'Add Book',
    'desc' => 'Add Book',
  ),
  'Category/Add' => array(
    'label' => 'Add Category',
    'desc' => 'Add Category',
  ),
  'Book/Search/' => array(
    'label' => 'Search Book',
    'desc' => 'Search book',
  ),
);

// Determine the current menu item.
$menu_current = $menu_item_default;
// If there is a query for a specific menu item and that menu item exists...
if (@array_key_exists($this->uri->segment(2), $menu_items)) {
  $menu_current = $this->uri->segment(2);
}
?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Book Store - Admin</title>
        <meta name="description" content="<?php html_escape($menu_items[$menu_current]['desc']); ?>">
        <meta name="viewport" content="width=device-width">

        <?= link_tag(base_url().'css/bootstrap.min.css'); ?>
        <?= link_tag(base_url().'css/bootstrap-responsive.min.css'); ?>
        <?= link_tag(base_url().'css/main.css'); ?>

        <style>
            body {
                padding-top: 60px;
                padding-bottom: 40px;
            }
        </style>

        <script src=<?= base_url()."js/vendor/modernizr-2.6.2.min.js"?>></script>
    </head>
    <body>
        <!-- This code is taken from http://twitter.github.com/bootstrap/examples/hero.html -->

        <div class="navbar navbar-inverse navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container">
                    <a class="brand">Book Store</a>
                    <div class="nav-collapse collapse">
                        <ul class="nav">
                          <?php
                            foreach ($menu_items as $item => $item_data) {
                              echo '<li>';
                                echo '<a href="' . base_url(). 'index.php/Admin/' . $item . '" title="' . $item_data['desc'] . '">' . $item_data['label'] . '</a>';
                              echo '</li>';
                            }
                          ?>
                        </ul>
                    </div><!--/.nav-collapse -->
                </div>
            </div>
        </div>

        <div class="container">