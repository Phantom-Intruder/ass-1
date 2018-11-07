<?php echo validation_errors(); ?>
<?php echo form_open(); ?>
    <div>
        <?php echo form_label('Username', 'userName'); ?>
        <?php echo form_input('userName', set_value('userName')); ?>
    </div>
    <div>
        <?php echo form_label('Password', 'password'); ?>
        <?php echo form_password('password', set_value('password')); ?>
    </div>
    <div>
        <?php echo form_submit('save', 'Save'); ?>
    </div>
<?php echo form_close(); ?>