    <span>
         User Date
    </span>
<form action="<?php echo base_url(); ?>/users/show/<?php echo htmlspecialchars($main_info['id']); ?>" method="post">
    <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($main_info['id']); ?>" > 
    <div class="field-set">
        <?php htmlspecialchars($main_info['id']); ?>
        <div class="field-row">
            <span class="field-name">
                Nume Utilizator:
            </span>
            <span class="field-value">
                <?= $main_info['name']; ?>
            </span>
        </div>
        <div class="field-row">
            <span class="field-name">
                Prenume Utilizator:
            </span>
            <span class="field-value">
                <?= $main_info['surname']; ?>
            </span>
        </div>
        <div class="field-row">
            <span class="field-name">
                Nick:
            </span>
            <span class="field-value">
                <?= $main_info['nick']; ?>
            </span>
        </div>
        <div class="field-row">
          
           <li class="ui-button ui-widget ui-state-default ui-corner-all" title=".ui-icon-pencil">
            <a class="ui-icon ui-icon-pencil" href="<?php echo base_url(); ?>users/edit/<?php echo htmlspecialchars($main_info['id']); ?>"> Edit </a>
            </li>
            
            <li class="ui-button ui-widget ui-state-default ui-corner-all" title=".ui-icon-trash">
            <a class="ui-icon ui-icon-trash" onclick="if(!confirm('Sure, you want to delete this user?')) return false; return true;" href="<?php echo base_url(); ?>users/userremove/<?php echo htmlspecialchars($main_info['id']); ?>">delete</a>
            </li>

            <li class="ui-button ui-widget ui-state-default ui-corner-all" title=".ui-icon-home">
            <a class="ui-icon ui-icon-home" href="<?php echo base_url(); ?>users/all"> Cancel </a>
            </li>
        
        </div>
    </div>
</form>