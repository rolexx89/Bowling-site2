<h2>Users List</h2>
<table>
<tr>
    <td><b>id</b></td>
    <td><b>name</b></td>
    <td><b>surname</b></td>
    <td><b>nickname</b></td>
    <td><i>Actions</i></td>
</tr>



    <?php echo form_open();
    
    $username = array 
        (
        'id' => 'id',
        'name' => 'name',
        'surname' => 'surname',
        'nick' => 'nick'
        );
    
    ?>
    <ul>
        <li>
            <label> Username </label>
            <div>
              <b>  <?php echo form_input('id'); ?> ID </b> </br>
              <b>  <?php echo form_input('name'); ?> name </b> </br>
              <b>  <?php echo form_input('surname'); ?> surname</b> </br>
              <b>  <?php echo form_input('nick'); ?> </b> </br>
            </div>
        </li>
        
        <li>
            <div>
                <?php echo form_submit(array('id','name','surname','nick'=> 'add'),'Register'); ?>
            </div>
        </li>
    </ul>
    <?php echo validation_errors();?>
    <?php echo form_close(); ?>
    
</table>