<div class="fa-book">
    <div class="name_issue">
        <?php echo html_escape($book->title); ?>
        <br/>
        <?php echo html_escape($book->price); ?>
        <br/>
        <?php if ($book->cover){ ?>
            <div class="cover">
                <?php echo img(array('src'=> 'assets/'.$book->cover, 'alt'=>'Image not found','width'=>'100px', 'height'=>'100px')); ?>
            </div>
        <?php }?>
        <br/>
        <?php echo html_escape($category->name); ?>
        <br/>
        <?php echo html_escape($book->author); ?>
        <br/>

    </div>
    <hr/>
    <h3>
        Others also viewed:
    </h3>
    <div>
        <?php
        $this->table->set_heading('Cover',
            'Title',
            'Price',
            'Category Name',
            'Author',
            'Actions');

        echo $this->table->generate($recommendedBooks);
        ?>
    </div>
</div>