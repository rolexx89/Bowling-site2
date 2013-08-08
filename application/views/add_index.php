<h2>Users List</h2>
<table>
<tr>
    <td><b>id</b></td>
    <td><b>name</b></td>
    <td><b>surname</b></td>
    <td><b>nickname</b></td>
    <td><i>Actions</i></td>
</tr>



    <?php
    echo form_open($base_url . '');
    
    $username = array 
        (
        'name' => 'name',
        'surname' => 'surname',
        'nick' => 'nick'
        );
    
    ?>
    <ul>
        <li>
            <label> Username </label>
            <div>
                <?php echo form_input($username); ?>
            </div>
        </li>
        
        <li>
            <div>
                <?php echo form_submit(array('name'=> 'add'),'Register'); ?>
            </div>
        </li>
    </ul>
    <?php echo validation_errors();?>
    <?php echo form_close(); ?>
    
</table>