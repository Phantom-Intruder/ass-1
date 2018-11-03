<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

<?= link_tag(base_url().'/css/materialize.css'); ?>
<?= link_tag(base_url().'/css/style.css'); ?>

<nav class="light-blue lighten-1" role="navigation">
    <div class="nav-wrapper container"><a id="logo-container" href="#" class="brand-logo">Logo</a>
        <ul class="right hide-on-med-and-down">
            <li><a href='addBook'>Add Book</a></li>
        </ul>
        <ul class="right hide-on-med-and-down">
            <li><a href='addCategory'>Add Category</a></li>
        </ul>
        <ul id="nav-mobile" class="sidenav">
            <li><a href="#">Navbar Link</a></li>
        </ul>
        <a href="#" data-target="nav-mobile" class="sidenav-trigger"><i class="material-icons">menu</i></a>
    </div>
</nav>
