<div id="wrapper">
    <div id="content">
        <form action="<?php echo base_url(); ?>/users/edit/<?php echo htmlspecialchars($main_info['id']); ?>/" method="post" charset="utf-8">
            <div class="field-rows">
                <span>
                    Edit user date
                </span>
                <div class="field-row">
                    <span class="field-name">
                        Name:
                    </span>
                    <span class="field-value">
                        <input type="text" name="name" value="<?= htmlspecialchars(set_value('name', $main_info['name'])); ?>">
                        <strong><?= form_error('name'); ?></strong>
                    </span>
                </div>
                <div class="field-row">
                    <span class="field-name">
                        Surname:
                    </span>
                    <span class="field-value">
                        <input type="text" name="surname" value="<?= htmlspecialchars(set_value('surname', $main_info['surname'])); ?>">
                        <strong> <?= form_error('surname'); ?></strong>
                    </span>
                </div>
                <div class="field-row">
                    <span class="field-name">
                        Nickname:
                    </span>
                    <span class="field-value">
                        <input type="text" name="nick" value="<?= htmlspecialchars(set_value('nick', $main_info['nick'])); ?>">
                        <strong> <?= form_error('nick'); ?></strong>
                    </span>
                </div>
                <div class="field-row">
                    <input class="ui-button ui-state-default ui-corner-all"  type="submit" value="editare" name="edit" >
                    <li class="ui-button ui-widget ui-state-default ui-corner-all" title=".ui-icon-home">
                        <a class="ui-icon ui-icon-home" href="<?php echo base_url(); ?>users/all"> Cancel </a>
                    </li>

                </div>
            </div>
        </form>
        <script type="text/javascript">
        $(document).ready(function () {
        $('#drop1').change(function(){
            $.ajax({
            type :"POST",
            url:base_url,
            data:"idislajs="+dato,success:function(msg){
                $("#idmunicipio").empty().removeAttr("disabled").append(msg);
                callback();
            }
          //  $.post(function(data){
           // $('#show').html(data);
        });
        });
        });
        </script>
        <a id="show" style="cursor: pointer"> show </a>
        <div id="show"> </div>
        
    </div>
</div>