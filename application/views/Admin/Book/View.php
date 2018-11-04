<div class="fa-book">
    <div class="name_issue">
        <?php echo html_escape($book->title); ?>
        <?php if ($book->cover){ ?>
            <div class="cover">
                <?php echo img(array('src'=> 'assets/'.$book->cover, 'alt'=>'Image not found','width'=>'100px', 'height'=>'100px')); ?>
            </div>
        <?php }?>
        <?php echo html_escape($category->name); ?>
        <?php echo html_escape($book->author); ?>
        #<?php echo html_escape($book->visitorStats); ?>
    </div>
</div>