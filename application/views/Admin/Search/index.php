<?php echo form_open(); ?>
    <div>
        <?php echo form_label('Search By Book Or Author', 'search'); ?>
        <?php echo form_input('search', set_value('search')); ?>
    </div>
    <div>
        <?php echo form_submit('save', 'Search'); ?>
    </div>
<?php echo form_close(); ?>