<link type="text/css" href="/stylesheets/style.css" rel="stylesheet" />
<span class="field-name">
            Actions:
        </span>
        <span class="field-value">
            <li class="ui-button ui-widget ui-state-default ui-corner-all" title=".ui-icon-contact">
            <a class="ui-icon ui-icon-contact" href="<?php echo base_url(); ?>pages/filed">Add new user</a> </li>
        </span>
<h2>Users List</h2> <center>
<table border="1px">
	<tr class="mark">
		<td><b>id</b></td>
		<td><b>name</b></td>
		<td><b>Nickname</b></td>
		<td><b>Surname</b></td>
		<td><i>Actions</i></td>
        </tr>
       
	 <?php foreach ($all_users as $item) { ?>
       		<tr>
			<td><li class="ui-button ui-widget ui-state-default ui-corner-all" title=".ui-icon-unlocked">
                        <a class="ui-icon ui-icon-unlocked" href="<?= base_url() . "pages/show/$item[id]"; ?>"><?php echo htmlspecialchars($item['id']); ?></a>
                        </li></td>
			<td><?=htmlspecialchars($item['name']);?> </td>
			<td><?php echo htmlspecialchars($item['nick']); ?></td>
			<td><?php echo htmlspecialchars($item['surname']); ?></td>
			<td align="center">
                       <li class="ui-button ui-widget ui-state-default ui-corner-all" title=".ui-icon-trash">
                       <a class="ui-icon ui-icon-trash" href="<?php echo base_url(); ?>pages/userremove/<?php echo htmlspecialchars($item['id']); ?>">del</a>
                       </li>
                         <li class="ui-button ui-widget ui-state-default ui-corner-all" title=".ui-icon-pencil">
                         <a class="ui-icon ui-icon-pencil" href="<?php echo base_url(); ?>pages/edit/<?php echo htmlspecialchars($item['id']); ?>"> Edit </a>
                         </li>
			</td>
		</tr>
		<?php }
	?>
</table>
</center>