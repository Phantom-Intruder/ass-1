<h2>List of books</h2>

<?php
$this->table->set_heading('Title',
                          'Visitor Statistics',
                          'Category Id',
                          'Author');

echo $this->table->generate($books);