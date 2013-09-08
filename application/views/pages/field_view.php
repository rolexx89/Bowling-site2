<div id="wrapper">
    <div id="content">

<hr />
    <span>
        <center> <h3> New User </h3></center>
    </span>
<hr />
        <form action="<?php echo base_url(); ?>users/field" method="post">
            <div class="field-set">
                <div class="field-row">
                    <span class="field-name">
                        Numele vostru
                    </span>
                    <span class="field-value">
                        <input type ="text" name="name" value="<?= set_value('name'); ?>"><br>
                        <strong><?= form_error('name'); ?></strong>
                    </span>
                </div>
                <div class="field-row">
                    <span class="field-name">
                        prenumele
                    </span>
                    <span class="field-value">
                        <input type="text" name="surname" value="<?= set_value('surname'); ?>"><br>
                        <strong> <?= form_error('surname'); ?></strong>
                    </span>
                </div>
                <div class="field-row">
                    <span class="field-name">
                        Nickname
                    </span>
                    <span class="field-value">
                        <input type="text" name="nick" value="<?= set_value('nick'); ?>"><br>
                        <strong> <?= form_error('nick'); ?></strong>
                    </span>
                </div>
                <div class="field-row">
                    <span class="field-name">
                        <?= $imgcode ?>
                    </span>
                    <span class="field-value">
                        <input class="ui-button ui-widget ui-state-default ui-corner-all" type="text" name="captcha" placeholder="introdu textul din imagine"><br>
                        <strong><?= form_error('captcha'), $info; ?></strong>
                    </span>
                </div>
                <div class="field-row">
                    <input class="ui-button ui-state-default ui-corner-all" type="submit" name="send_message" value="inregistrare">
                    
                    <li class="ui-button ui-widget ui-state-default ui-corner-all" title=".ui-icon-home">
                    <a class="ui-icon ui-icon-home" href="<?php echo base_url(); ?>users/all"> Cancel </a>
                    </li>
                     
                
                </div>
                &nbsp;
                 <hr />
                     &nbsp;
                 <hr />
            </div>
        </form>
    </div>
</div>