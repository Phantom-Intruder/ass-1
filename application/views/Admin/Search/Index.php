<?php echo validation_errors(); ?>
<?php echo form_open(); ?>
    <div>
        <?php echo form_label('Search By Book Or Author', 'search'); ?>
        <?php echo form_input('search', set_value('search')); ?>
    </div>
    <div>
        <?php echo form_submit('save', 'Search', 'class="waves-effect waves-light btn"'); ?>
    </div>
<?php echo form_close(); ?>