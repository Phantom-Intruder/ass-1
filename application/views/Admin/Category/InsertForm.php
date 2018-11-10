<?php echo validation_errors(); ?>
<?php echo form_open(); ?>
    <div>
        <?php echo form_label('Category Name', 'name'); ?>
        <?php echo form_input('name', set_value('name'), 'class="input-field col s6"'); ?>
    </div>
    <div>
        <?php echo form_submit('save', 'Save', 'class="waves-effect waves-light btn"'); ?>
    </div>
<?php echo form_close(); ?>