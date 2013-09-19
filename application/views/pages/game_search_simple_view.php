<span>
    Lists Game-Play 
</span>
<div>
    <script type="text/javascript">
        // Update the jQuery UI - autocomplete element
        function updateAutoComplete(arr) {
            var input = $('#autocomplete-filter').get(0);
            $(input).autocomplete({source: arr});
        };
        // request data from server
        function requestAutoCompleteData() {
            var input = $('#autocomplete-filter').get(0);
            // executam cererea ajax
            $.post('/games/filtereddatasimple/', {"valCurr": input.value}, function(jsonObj) {
                if (!jsonObj)
                    return false;
                // { arr : [ .. ], val-curr : "" }
                if ('list' in jsonObj)
                    updatePageContent(jsonObj.list);
                var input = $('#autocomplete-filter').get(0);
                if (input.value != jsonObj["valCurr"])
                    return false;
                // incarcam noile valori in auto complete
                updateAutoComplete(jsonObj["arr"]);
            }, 'json');
            return true;
        }
        // build list of games
        function updatePageContent(list) {
            var tpl = '<div class="content-left">\
                    <a style="display: block;" href="<?= base_url() . "games/show/"; ?>{game-id}" class="ui-button ui-state-default ui-corner-all">\
                        <span class="field-name"> Game #{game-id}: </span>\
                        <span class="field-value">{game-name}</span>\
                    </a>\
                </div>';
            var i, html = [],games_inserted = {};
            for (i in list) if( !( i in games_inserted ) ) {
                games_inserted[i]   = true;
                html.push(  tpl .split('{game-id}').join(list[i]["game-id"])
                                .split('{game-name}').join(list[i]["game-name"])
                                .split('{user-name}').join(list[i]["users-name"])
                                .split('{user-surname}').join(list[i]["users-surname"])
                    );
            }
            $('#games-list').html(html.join(''));
        }
    </script>
    <input  type="text"
            value=""
            placeholder="find by user or by game name"
            style="display: block;width: 560px; margin: 10px auto; padding: 10px 9px; font-size: 11px;" id="autocomplete-filter"
            onkeyup="requestAutoCompleteData();" />
</div>
<div id="games-list"></div>
<script type="text/javascript">
        requestAutoCompleteData();
</script>
<style type="text/css">
    .ui-autocomplete {
        opacity: 0.63;
        text-align: left;
    }
</style>
<div>
    <a class="ui-button ui-state-default ui-corner-all" href="<?php echo base_url(); ?>games/newgame">New-Game</a>
</div>
