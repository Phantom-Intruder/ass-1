<div class="fa-book">
    <div class="name_issue">
        <?php echo html_escape($book->title); ?>
        <?php if ($book->cover){ ?>
            <div class="cover">
                <?php echo img('assets/', $book->cover); ?>
            </div>
        <?php }?>
        <?php echo html_escape($book->categoryId); ?>
        <?php echo html_escape($book->author); ?>
        #<?php echo html_escape($book->visitorStats); ?>
    </div>
</div>