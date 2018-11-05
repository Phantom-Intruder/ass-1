<h2>List of books</h2>

<?php
$this->table->set_heading('Cover',
    'Title',
    'Visitor Statistics',
    'Category Id',
    'Author',
    'Actions');

echo $this->table->generate($books);

for ($x = 1; $x <= $page+1; $x++) {
    echo anchor('Home/listByCategory/' . $categoryId . '/' . $x * 2 . '/' . ($x * 2) - 2 , '<p>$x</p>');
}