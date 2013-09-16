<span>
    Lists Game-Play 
</span>
<div>
    <script type="text/javascript">
        // transform a string into a JavaScript Object
        // "Joram, max created: 2345 id: 34 identify: max popovici"
        // into
        // { _ : "max", created: "2345", id: "34", identify: "max popovici" }
        var buildQuery = function(s) {
            var r = /^\s*([a-z]+)\:\s*(\S[^\:]*?|)\s*(\s[a-z]+\:.*|)$/i
            var o = {"_keys": []}, m, k, f = s.split(/([a-z]+)\:/i);
            if (m = f[0].match(/^\s*(\S[\s\S]*?)\s*$/)) {
                o["_keys"].push("_");
                o['_'] = m[1];
            }
            ;
            f = s.substring(f[0].length, s.length);
            while (m = f.match(r)) {
                o[k = m[1].toLowerCase()] = m[2];
                o["_keys"].push(k);
                f = f.split(m[0]).join(m[3]);
            }
            ;
            return o;
        };
        // Update the jQuery UI - autocomplete element
        function updateAutoComplete(arr) {
            var input = $('#autocomplete-filter').get(0);
            var prefix = input.value.replace(/[^\:]+$/, '');
            var arrVar = [];
            var i;
            for (i = 0; i < arr.length; i++)
                arrVar.push(prefix + ' ' + arr[i] + ' ');
            $(input).autocomplete({source: arrVar});
        }
        ;
        // request data from server
        function requestAutoCompleteData() {
            var input = $('#autocomplete-filter').get(0);
            var query = buildQuery(input.value);
            // cream un obiect ce contine lista de key admisibile pentru filtru
            var allowed_keys = {
                "game": {clean: /[^\d\D]/, "name": "name"},
                "_": {clean: /[^\d\D]/, "name": "name"},
                "id": {clean: /\D/g, "name": "game_id"},
                "created": {clean: /\D/g, "name": "ctime"},
                "modified": {clean: /\D/g, "name": "mtime"},
                "users": {clean: /[^\d\D]/, "name": "users"},
                "round": {clean: /\D/g, "name": "round"}
            };
            var i, k, req = {listFilter: {}, "selectKey": "name", "valCurr": input.value};
            // indicam de ce categorie de valori avem nevoie
            if (query._keys.length) {
                k = query._keys.pop();
                if (k in allowed_keys)
                    req["selectKey"] = allowed_keys[k]["name"];
            }
            ;
            // construim filtru utilizind lista de key admise pentru cerere ajax
            for (i in query)
                if (i in allowed_keys) {
                    req["listFilter"][allowed_keys[i]["name"]] = allowed_keys[i]["clean"]
                            ? query[i].replace(allowed_keys[i]["clean"], '')
                            : query[i];
                }
            ;
            // executam cererea ajax
            $.post('/games/filtereddata/', req, function(jsonObj) {
                if (!jsonObj)
                    return false;
                // { arr : [ .. ], slectedKey : "", val-curr : "" }
                if ('list' in jsonObj)
                    updatePageContent(jsonObj.list);
                var input = $('#autocomplete-filter').get(0);
                if (input.value != jsonObj["valCurr"])
                    return false;
                // exceptie pentru cimpul users.. cimpul data vine ca un string ce reprezinta un obiect JSON
                // deci din acest string efectuam selectarea valorii cuvenite
                if (jsonObj.selectKey == "users") {
                    var a = [], i, v, l = {};
                    for (i = 0; i < jsonObj["arr"].length; i++) {
                        if (jsonObj["filter"][jsonObj["selectKey"]]) {
                            v = jsonObj["arr"][i].substring(
                                    jsonObj["arr"][i].indexOf(jsonObj["filter"][jsonObj["selectKey"]]),
                                    jsonObj["arr"][i].length
                                    // [] definim caracterile
                                    // [^..] definim caracterile ce sa fie diferite
                                    // [^ spatii
                                    // \S nu is spatii
                                    // \w char de cuvinte
                                    // \W invers la \W
                                    // \d \D ca si \s doar cifre
                                    // $ sfirsitul stringului
                                    // ^ inceputul stringului
                                    // * .. zero sau mai mult
                                    // + .. unul sau mai mut
                                    ).replace(/[^\w\s][\s\S]*$/, '');
                        } else {
                            v = jsonObj["arr"][i].replace(/^[\s\S]*\"name\"\s*\:\s*\"/g, '').replace(/\"[\s\S]*$/, '')
                        }
                        if (!(v in l)) {
                            a.push(v);
                            l[v] = true;
                        }
                    }
                    jsonObj["arr"] = a;
                }
                // incarcam noile valori in auto complete
                updateAutoComplete(jsonObj["arr"]);
            }, 'json');
            return true;
        }
        // build list of games
        function updatePageContent(list) {
            var tpl = '<div class="content-left">\
                    <a style="display: block;" href="<?= base_url() . "games/show/"; ?>{game-id}" class="ui-button ui-state-default ui-corner-all">\
                        <span class="field-name"> Game #: </span>\
                        <span class="field-value">{game-name}</span>\
                        <span>{game-id}</span>\
                    </a>\
                </div>';
            var i, html = [];
            for (i in list) {
                html.push(tpl.split('{game-id}').join(list[i]["game_id"]).split('{game-name}').join(list[i]["name"]))
            }
            $('#games-list').html(html.join(''));
        }
    </script>
    <input  type="text"
            value=""
            placeholder="Filter, ex: &#x22;game-name id:33 round:3 created: 2013-05-02 modified: 2013.04.20 23.44 user: Maxim Pavel &#x22;"
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
