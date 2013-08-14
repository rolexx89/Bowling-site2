<div id="wrapper">
    <div id="content">
        
        
        <form action="http://test.local/pages/filed" method="post">
        <p> Numele vostru <br>
            <input type ="text" name="name" value="<?=set_value('name');?>"><br>
            <strong><?=form_error('name');?></strong>
        </p>
        
        <p> prenumele <br>
            <input type="text" name="surname" value="<?=set_value('surname');?>"><br>
            <strong> <?=form_error('surname');?></strong>
        </p>
        
        <p> Nickname <br>
            <input type="text" name="nick" value="<?=set_value('nick');?>"><br>
            <strong> <?=form_error('nick');?></strong>
        </p>
        
        <p>introdu textul din imagine </p>
        
        <p> <?=$imgcode?> </p>
        <p> <input type="text" name="captcha" size="10"> <br>
            <strong><?=form_error('captcha'),$info;?></strong>
        </p>
        <p><input type="submit" name="send_message" value="inregistrare">
        </p>
        
        </form>    
        </div>
        </div>