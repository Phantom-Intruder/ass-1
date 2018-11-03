<h2>List of books</h2>

<?php
$this->table->set_heading('Cover',
                          'Title',
                          'Visitor Statistics',
                          'Category Id',
                          'Author',
                          'Actions');

echo $this->table->generate($books);