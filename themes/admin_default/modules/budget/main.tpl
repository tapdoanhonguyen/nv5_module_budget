<!-- BEGIN: main -->
<!-- BEGIN: view -->
<div class="well">
    <form action="{NV_BASE_ADMINURL}index.php" method="get">
        <input type="hidden" name="{NV_LANG_VARIABLE}" value="{NV_LANG_DATA}" />
        <input type="hidden" name="{NV_NAME_VARIABLE}" value="{MODULE_NAME}" />
        <input type="hidden" name="{NV_OP_VARIABLE}" value="{OP}" />
        <div class="row">
            <div class="col-xs-24 col-md-6">
                <div class="form-group">
                    <input class="form-control" type="text" value="{ARRAY_SEARCH.q}" name="q" maxlength="255" placeholder="{LANG.search_title}" />
                </div>
            </div>
            <div class="col-xs-24 col-md-6">
                <div class="form-group">
                    <select class="form-control" name="cat">
                        <option value="">--- {LANG.choose_cat} ---</option>
                        <!-- BEGIN: select_cat -->
                        <option value="{CAT.key}"{CAT.selected}>{CAT.title}</option>
                        <!-- END: select_cat -->
                    </select>
                </div>
            </div>
            <div class="col-xs-24 col-md-4">
                <div class="form-group">
                    <select class="form-control" name="year">
                        <option value=""> --- {LANG.choose_reportyear} ---</option>
                        <!-- BEGIN: reportyear_search -->
                        <option value="{REPORTYEAR.key}" {REPORTYEAR.selected}>{REPORTYEAR.title}</option>
                        <!-- END: reportyear_search -->
                    </select>
                </div>
            </div>
            <div class="col-xs-24 col-md-4">
                <div class="form-group">
                    <select class="form-control" name="status">
                        <option value="0"> --- {LANG.status_choose} ---</option>
                        <!-- BEGIN: status_search -->
                        <option value="{STATUS.key}" {STATUS.selected}>{STATUS.title}</option>
                        <!-- END: status_search -->
                    </select>
                </div>
            </div>
            <div class="col-xs-12 col-md-3">
                <div class="form-group">
                    <input class="btn btn-primary" type="submit" value="{LANG.search_submit}" />
                </div>
            </div>
        </div>
    </form>
</div>
<form action="{NV_BASE_ADMINURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&amp;{NV_NAME_VARIABLE}={MODULE_NAME}&amp;{NV_OP_VARIABLE}={OP}" method="post">
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th class="w50 text-center">STT</th>
                    <th>{LANG.number}</th>
                    <th>{LANG.title}</th>
                    <th>{LANG.cat}</th>
                    <th>{LANG.reportyear}</th>
                    <th>{LANG.addtime}</th>
                    <th>{LANG.edittime}</th>
                    <th class="w150 text-center">{LANG.status}</th>
                    <th class="w150">&nbsp;</th>
                </tr>
            </thead>
            <!-- BEGIN: generate_page -->
            <tfoot>
                <tr>
                    <td class="text-center" colspan="8">{NV_GENERATE_PAGE}</td>
                </tr>
            </tfoot>
            <!-- END: generate_page -->
            <tbody>
                <!-- BEGIN: loop -->
                <tr>
                    <td class="text-center"> {VIEW.stt} </td>
                    <td> {VIEW.number} </td>
                    <td>
                        <a target="_blank" href="{VIEW.link}">{VIEW.title}</a>
                    </td>
                    <td> {VIEW.cat} </td>
                    <td class="text-center"> {VIEW.reportyear}</td>
                    <td> {VIEW.addtime} </td>
                    <td> {VIEW.edittime} </td>
                    <td class="text-center">{VIEW.lang_status}</td>
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">{LANG.action}
                            <span class="caret"></span></button>
                            <ul class="dropdown-menu" style="right: 0; left: unset;">
                                <li><a target="_blank" href="{VIEW.link}">{LANG.view}</a></li>
                                <li><a href="" id="change_status_{VIEW.id}" onclick="nv_change_status('{OP}', {VIEW.id}, {VIEW.status});">{VIEW.lang_status_action}</a></li>
                                <li><a href="{VIEW.link_edit}#edit">{LANG.edit}</a></li>
                                <li><a href="{VIEW.link_delete}" onclick="return confirm(nv_is_del_confirm[0]);">{LANG.delete}</a></li>
                            </ul>
                        </div>
                    </td>
                </tr>
                <!-- END: loop -->
            </tbody>
        </table>
    </div>
</form>
<!-- END: view -->
<script type="text/javascript">
    //<![CDATA[
    function nv_change_status(page, id, status) {
        if (confirm(nv_is_change_act_confirm[0])) {
            var nv_timer = nv_settimeout_disable('change_status_' + id, 5000);
            $.post(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=' + page + '&nocache=' + new Date().getTime(), 'change_status=1&id=' + id + '&status=' + status, function(res) {
                var r_split = res.split('_');
                if (r_split[0] != 'OK') {
                    alert(nv_is_change_act_confirm[2]);
                }
            });
        } else {
            $('#change_status_' + id).prop('checked', new_status ? false : true);
        }
         window.location.href = script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=main';
        return;
    }
     //]]>
</script>
<!-- END: main -->