<script type="text/javascript">
    function updateAjaxSpace(data) {
        $.post(
                window.location.href + "/1",
                data ? data : {},
                function(dataResponse) {

                    // json example
                    // $('div#ajax-space').get(0).innerHTML = dataResponse["html-output"];

                    // xml example
                    var text = $('bowling-data > html-output', dataResponse).text();
                    $('div#ajax-space', document).html(text);
                    $('input#i0').val('');
                    // get new url
                    var i;
                    if (i = $('.new-url-replace').get(0)) {
                        // set new url
                        // console.log($(i).val())
                        window.history.replaceState({}, 'show-game-id', $(i).val());
                    }
                    $('input#i0').focus();
                }, 'xml');
    }
</script>
<div id="ajax-space">
    <?php
    if (isset($currentGameData['game-status'])) {  // controlam ca datele jocului au fost primite in view
        if ($currentGameData['game-status']['status'] != "completed") {
            // afiseaza lista tuturor user pentru a ii selecta 
            if ($currentGameData['game-status']['allowed-new'] == true && empty($currentGameData['game-players']) && empty($currentGameData['game-data'])
            ) {
                ?>
                <form action="/games/newgame" charset="utf-8" method="post"
                      style="border: 1px solid #c0c0c0; padding: 10px; margin: 10px; text-align: center;">
                    <div> <font color=#1B76AA size=3> Write name Games: </font></div>
                    <input type="text" placeholder="Game Name..." name="game_data[game-name]" style="width: 270px;" />
                    <div style="padding-top: 10px;">
                        Select User
                        <sub> <font color=#1B76AA>While the first round is not finished in game can enter other players</font></sub>
                        <?php foreach ($currentGameData['all-users'] as $item_id => $item)
                            if (!isset($currentGameData['game-data-grouped']['users'][$item_id])) {
                                ?>
                                <label class="ui-state-default" >
                                    <input type="checkbox" name="game_data[player][]" value="<?= $item_id; ?>">
                                    <span>
                                        <?= htmlspecialchars($item['name']); ?>
                    <?= htmlspecialchars($item['surname']); ?>
                                        ( <?= htmlspecialchars($item['nick']); ?> )
                                    </span>
                                </label>
                            <?php }
                        ?></div>
                    <div >
                        <input class="ui-button ui-state-default ui-corner-all" type="submit" value="Submit">
                    </div>

                </form>
                <?php } else /* if (empty($currentGameData['game-data'])) {
              // afisam lista useri care joaca
              //la control daca putem arunca sau e complet cu ajax
              ?>
              Select User
              <?php
              $only_first = true;
              foreach ($currentGameData['all-users'] as $item_id => $item)
              if (in_array($item_id, $currentGameData['game-players'])) {
              ?>
              <div style="padding-left: 30px;">
              <label class="ui-state-default" >
              <input <?php if ($only_first) {
              $only_first = false;
              echo " checked=\"true\" match=\"this\" ";
              } ?> type="radio" name="game_data[player]" value="<?= $item_id; ?>">
              <span>
              <?= htmlspecialchars($item['name']); ?>
              <?= htmlspecialchars($item['surname']); ?>
              ( <?= htmlspecialchars($item['nick']); ?> )
              </span>
              </label>
              </div>
              <?php } ?>
              <input id="i0" type="text" name="game_data[value]" value="" autocomplete="off" />
              <input type="submit" class="button" />
              <script type="text/javascript">
              updateAjaxSpace();
              </script>
              <?php } else */ {
                ?>
                <script type="text/javascript">
                    updateAjaxSpace();
                </script>
            <?php }
        } else {
            ?>
            <script type="text/javascript">
                updateAjaxSpace();
            </script>
    <?php }
    ?>
    </div>
    <?php
    if ($currentGameData['game-status']['status'] != "completed" && (!empty($currentGameData['game-data']) || !empty($currentGameData['game-players'])
            )
    ) {
        ?><span>
            Push Data
            Enter Throw score</span>
        <input id="i0" type="text" name="game_data[value]" value="" autocomplete="off" />
        <input class="ui-button ui-state-default ui-corner-all" type="submit" value="Arunca" onclick="
                    updateAjaxSpace({
                        // input#i0 = introdu val , match= round , $#x22 = '' '' 
                        'game_data[value]': $('input#i0').val(),
                        'game_data[player]': $('input[name=&#x22;game_data[player]&#x22;][match]').val()
                    });" />

        <div>
            <a class="ui-button ui-state-default ui-corner-all" href="<?php echo base_url(); ?>games/newgame">New-Game</a>
        </div>

    <?php
    }
} else {
    ?>

<?php } ?>