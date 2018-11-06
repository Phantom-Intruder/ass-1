<?php echo validation_errors(); ?>
<?php echo $this->upload->display_errors('<div class="alert alert-error">', '</div>'); ?>
<?php echo form_open_multipart(); ?>
    <div>
        <?php echo form_label('Book Title', 'title'); ?>
        <?php echo form_input('title', set_value('title')); ?>
    </div>
    <div>
        <?php echo form_label('Book Price', 'price'); ?>
        <?php echo form_input('price', set_value('price')); ?>
    </div>
    <div>
        <?php echo form_label('Book Category', 'categoryId'); ?>
        <?php echo form_dropdown('categoryId', $category_options, set_value('categoryId'), 'class="browser-default"'); ?>
    </div>
    <div>
        <?php echo form_label('Book Cover', 'cover'); ?>
        <?php echo form_upload('cover'); ?>
    </div>
    <div>
        <?php echo form_label('Author', 'author'); ?>
        <?php echo form_input('author', set_value('author')); ?>
    </div>
    <div>
        <?php echo form_submit('save', 'Save'); ?>
    </div>
<?php echo form_close(); ?>