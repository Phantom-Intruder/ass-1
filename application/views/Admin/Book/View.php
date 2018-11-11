<div class="fa-book">
    <div class="name_issue">
        <?php echo html_escape($book->title); ?>
        <br/>
        <?php echo html_escape($book->price); ?>
        <br/>
        <?php if ($book->cover){ ?>
            <div class="cover">
                <?php echo img(array('src'=> 'assets/'.$book->cover, 'alt'=>'Image not found','width'=>'100px', 'height'=>'150px')); ?>
            </div>
        <?php }?>
        <br/>
        <?php echo html_escape($category->name); ?>
        <br/>
        <?php echo html_escape($book->author); ?>
        <br/>
        Visitors: #<?php echo html_escape($book->visitorStats); ?>
    </div>
</div>