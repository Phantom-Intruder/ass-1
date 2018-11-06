<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

<?= link_tag(base_url().'/css/materialize.css'); ?>
<?= link_tag(base_url().'/css/style.css'); ?>

<nav class="light-blue lighten-1" role="navigation">
    <div class="nav-wrapper container"><a id="logo-container" href="#" class="brand-logo">Logo</a>
        <ul class="right hide-on-med-and-down">
            <li><a href=<?= base_url(). 'index.php/Home/showCart'?>>Shopping Cart</a></li>
        </ul>
        <a href="#" data-target="nav-mobile" class="sidenav-trigger"><i class="material-icons">menu</i></a>
    </div>
</nav>
