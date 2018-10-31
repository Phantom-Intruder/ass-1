<?php echo validation_errors(); ?>
<?php echo form_open(); ?>
    <div>
        <?php echo form_label('Book Title', 'title'); ?>
        <?php echo form_input('title', set_value('title')); ?>
    </div>
    <div>
        <?php echo form_label('Book Cover Image', 'cover'); ?>
        <?php echo form_input('cover', set_value('cover')); ?>
    </div>
    <div>
        <?php echo form_label('Book Category', 'categoryId'); ?>
        <?php echo form_input('categoryId', $category_options, set_value('categoryId')); ?>
    </div>
    <div>
        <?php echo form_label('Author', 'author'); ?>
        <?php echo form_input('author', set_value('author')); ?>
    </div>
    <div>
        <?php echo form_submit('save', 'Save'); ?>
    </div>
<?php echo form_close(); ?>