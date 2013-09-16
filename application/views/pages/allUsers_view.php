
<span class="field-name">
            Actions:
        </span>
<div>
Users List
</div>
<div style ="text-align: center; ">
    <div class="i">
    <div class="users"> Num </div> 
    <div class="users">name</div> 
    <div class="users">nickname</div> 
    <div class="users">surname</div> 
    <div class="users"> actions </div>
    </div>
</div>
       <?php
        $user_count = 0;
        foreach ($allUsers as $item) { ?>
<div style ="text-align: center; ">
            <div class="i">
                <div class="users">
                    <li class="ui-button ui-widget ui-state-default ui-corner-all" >
                        <a  href="<?= base_url() . "users/show/$item[id]"; ?>"><?php
                            echo ++$user_count;
                         ?></a>
                    </li>

                </div>
                        <div class="users"><?=htmlspecialchars($item['name']);?></div> 
                        <div class="users"><?php echo htmlspecialchars($item['nick']); ?></div> 
                        <div class="users"><?php echo htmlspecialchars($item['surname']); ?></div> 
                        <div class="users"><li class="ui-button ui-widget ui-state-default ui-corner-all">
                                <a class="ui-icon ui-icon-trash" onclick="if(!confirm('Sure, you want to delete this user?')) return false; return true;" href="<?php echo base_url(); ?>users/userremove/<?php echo htmlspecialchars($item['id']); ?>">del</a>
                           </li>
                           <li class="ui-button ui-widget ui-state-default ui-corner-all">
                                <a class="ui-icon ui-icon-pencil" href="<?php echo base_url(); ?>users/edit/<?php echo htmlspecialchars($item['id']); ?>"> Edit </a>
                           </li>
                        </div>
           </div>
</div>
      <?php }
          ?>

          <div >
            <a class="ui-button ui-state-default ui-corner-all " href="<?php echo base_url(); ?>user/field">New-Users</a>
          </div>
