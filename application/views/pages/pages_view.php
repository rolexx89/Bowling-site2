<link type="text/css" href="/stylesheets/style.css" rel="stylesheet" />
<center>
    <hr />
<span class="field-name">
            Actions:
        </span>
        <hr />
<h2>Users List</h2> 
<hr />
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
         foreach ($all_users as $item) { ?>
       		<tr>
                 
			<td><li class="ui-button ui-widget ui-state-default ui-corner-all" title=".ui-icon-person">
                        <a  href="<?= base_url() . "users/show/$item[id]"; ?>"><?php
                        echo ++$user_count;
	?></a>
                        </li></td>
			<td><?=htmlspecialchars($item['name']);?> </td>
			<td><?php echo htmlspecialchars($item['nick']); ?></td>
			<td><?php echo htmlspecialchars($item['surname']); ?></td>
			<td align="center">
                       <li class="ui-button ui-widget ui-state-default ui-corner-all" title=".ui-icon-trash">
                       <a class="ui-icon ui-icon-trash" onclick="if(!confirm('Sure, you want to delete this user?')) return false; return true;" href="<?php echo base_url(); ?>users/userremove/<?php echo htmlspecialchars($item['id']); ?>">del</a>
                       </li>
                         <li class="ui-button ui-widget ui-state-default ui-corner-all" title=".ui-icon-pencil">
                         <a class="ui-icon ui-icon-pencil" href="<?php echo base_url(); ?>users/edit/<?php echo htmlspecialchars($item['id']); ?>"> Edit </a>
                         </li>
			</td>
		</tr>
		<?php }
	?>
</table>
<hr />
&nbsp;
<hr />
</center>