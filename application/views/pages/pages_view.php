
<span class="field-name">
            Actions:
        </span>
Users List
<table  class="list">
    <tr class="mark">
            <td><b>N</b></td>
            <td><b>Name</b></td>
            <td><b>Nickname</b></td>
            <td><b>Surname</b></td>
            <td><i>actions</i></td>
    </tr>

     <?php
     $user_count = 0;
     foreach ($allUsers as $item) { ?>
            <tr>
                <td>
                    <li class="ui-button ui-widget ui-state-default ui-corner-all" title=".ui-icon-person">
                        <a  href="<?= base_url() . "users/show/$item[id]"; ?>"><?php
                            echo ++$user_count;
                        ?></a>
                    </li>
                </td>
                <td><?=htmlspecialchars($item['name']);?> </td>
                <td><?php echo htmlspecialchars($item['nick']); ?></td>
                <td><?php echo htmlspecialchars($item['surname']); ?></td>
                <td align="center">
                    <li class="ui-button ui-widget ui-state-default ui-corner-all">
                        <a class="ui-icon ui-icon-trash" onclick="if(!confirm('Sure, you want to delete this user?')) return false; return true;" href="<?php echo base_url(); ?>users/userremove/<?php echo htmlspecialchars($item['id']); ?>">del</a>
                    </li>
                    <li class="ui-button ui-widget ui-state-default ui-corner-all">
                        <a class="ui-icon ui-icon-pencil" href="<?php echo base_url(); ?>users/edit/<?php echo htmlspecialchars($item['id']); ?>"> Edit </a>
                    </li>
                </td>
            </tr>
            <?php }
    ?>
</table>
<div id="header">
<div class="nav"> 
    
    <table>
        <tr>
            <td>
                <a class="but-nav" href="<?php echo base_url(); ?>pages/field">New-Users</a>
            </td>
        </tr>
    </table>
    </div>
</div> 
