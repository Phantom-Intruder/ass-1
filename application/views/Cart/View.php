<h2>Your shopping cart</h2>

<?php
$this->table->set_heading('Cover',
    'Title',
    'Price',
    'Category',
    'Author',
    'Actions');

echo $this->table->generate($books);
