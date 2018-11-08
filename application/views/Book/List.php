<h2>List of books</h2>

<?php
$this->table->set_heading('Cover',
    'Title',
    'Price',
    'Category',
    'Author',
    'Actions');

echo $this->table->generate($books);


for ($x = 1; $x <= $page; $x++) {
    echo "<a href= '" . base_url(). "index.php/Home/listByCategory/ . $categoryId . "/" . $x * 2 . "/" . (($x * 2) - 2) . "'> " . $x . "</a> |";
}