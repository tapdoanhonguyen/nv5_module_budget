<!-- BEGIN: main -->
<link type="text/css" href="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/jquery-ui/jquery-ui.min.css" rel="stylesheet" />
<!-- BEGIN: error -->
<div class="alert alert-warning">{ERROR}</div>
<!-- END: error -->

<form class="form-horizontal" action="{NV_BASE_ADMINURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&amp;{NV_NAME_VARIABLE}={MODULE_NAME}&amp;{NV_OP_VARIABLE}={OP}" method="post">
    <div class="panel panel-default">
        <div class="panel-body">
            <input type="hidden" name="id" value="{ROW.id}" />
            
			
			<!-- 00. Danh mục báo cáo -->
            <div class="form-group">
                <label class="col-sm-5 col-md-4 control-label"><strong>{LANG.cat}</strong></label>
                <div class="col-sm-19 col-md-20">
                    <select class="form-control" name="catid" id="catid">
                        <option value="">--- {LANG.choose_cat} ---</option>
                        <!-- BEGIN: select_catid -->
                        <option value="{CAT.key}"{CAT.selected}>{CAT.title}</option>
                        <!-- END: select_catid -->
                    </select>
                </div>
            </div>
			
			<!-- 01. Tiêu đề -->
			<div class="form-group">
                <label class="col-sm-5 col-md-4 control-label"><strong>{LANG.title}</strong> <span class="red">(*)</span></label>
                <div class="col-sm-19 col-md-20">
                    <input class="form-control" type="text" name="title" value="{ROW.title}" required="required" oninvalid="setCustomValidity( nv_required )" oninput="setCustomValidity('')" />
                </div>
            </div>
			<!-- 02. Mô tả chi tiết -->
			<div class="form-group">
                <label class="col-sm-5 col-md-4 control-label"><strong>{LANG.description}</strong></label>
                <div class="col-sm-19 col-md-20">
                    <textarea class="form-control" name="description">{ROW.description}</textarea>
                </div>
            </div>
			
			
			<!-- 03. Năm báo cáo -->
            <div class="form-group">
                <label class="col-sm-5 col-md-4 control-label"><strong>{LANG.reportyear}</strong></label>
                <div class="col-sm-20">
                    <select name="reportyear" class="form-control">
                        <option value="">--- {LANG.choose_reportyear} ---</option>
                        <!-- BEGIN: select_reportyear -->
                        <option value="{YEAR.key}" {YEAR.selected}>{YEAR.title}</option>
                        <!-- END: select_reportyear -->
                    </select>
                </div>
            </div>
            
			<!-- 04. Tên biểu mẫu báo cáo -->
            <div class="form-group">
                <label class="col-sm-5 col-md-4 control-label"><strong>{LANG.reporttemplate}</strong></label>
                <div class="col-sm-19 col-md-20">
                    <input class="form-control" type="text" name="reporttemplate" value="{ROW.reporttemplate}"/>
                </div>
            </div>
			
			
			<!-- 05. Ngày quyết định công bố -->
            <div class="form-group">
                <label class="col-sm-5 col-md-4 control-label"><strong>{LANG.qddate}</strong></label>
                <div class="col-sm-19 col-md-20">
                    <div class="input-group">
                        <input class="form-control datepicker" value="{ROW.qddate}" type="text" name="qddate" readonly="readonly" /> <span class="input-group-btn">
                            <button class="btn btn-default" type="button">
                                <em class="fa fa-calendar fa-fix">&nbsp;</em>
                            </button>
                        </span>
                    </div>
                </div>
            </div>
			
			<!-- 06. Số quyết định  -->
            <div class="form-group">
                <label class="col-sm-5 col-md-4 control-label"><strong>{LANG.number}</strong></label>
                <div class="col-sm-19 col-md-20">
                    <input class="form-control" type="text" name="number" value="{ROW.number}" required="required" oninvalid="setCustomValidity( nv_required )" oninput="setCustomValidity('')"/>
                </div>
            </div>
			
			<!-- 07.Ngày công khai trên cổng  -->
            <div class="form-group">
                <label class="col-sm-5 col-md-4 control-label"><strong>{LANG.pubdate}</strong></label>
                <div class="col-sm-19 col-md-20">
                    <div class="input-group">
                        <input class="form-control datepicker" value="{ROW.pubdate}" type="text" name="pubdate" readonly="readonly" /> <span class="input-group-btn">
                            <button class="btn btn-default" type="button">
                                <em class="fa fa-calendar fa-fix">&nbsp;</em>
                            </button>
                        </span>
                    </div>
                </div>
            </div>
			
			<!-- 08. Danh sách báo cáo -->
            <div class="form-group">
                <label class="col-sm-5 col-md-4 control-label"><strong>{LANG.file}</strong></label>
                <div class="col-sm-19 col-md-20">
                    <div id="file">
                        <!-- BEGIN: file -->
                        <div class="form-group">
                            <div class="input-group">
                                <input value="{FILE.value}" name="file[]" id="file_{FILE.id}" class="form-control" maxlength="255"> <span class="input-group-btn">
                                    <button class="btn btn-default" type="button" onclick="nv_open_browse( '{NV_BASE_ADMINURL}index.php?{NV_NAME_VARIABLE}=upload&popup=1&area=file_{FILE.id}&path={NV_UPLOADS_DIR}/{MODULE_UPLOAD}&currentpath={CURRENT}&type=file', 'NVImg', 850, 500, 'resizable=no,scrollbars=no,toolbar=no,location=no,status=no' ); return false; ">
                                        <em class="fa fa-folder-open-o fa-fix">&nbsp;</em>
                                    </button>
                                </span>
                            </div>
                        </div>
                        <!-- END: file -->
                    </div>
                    <input type="button" class="btn btn-info" onclick="nv_add_file();" value="{LANG.add_file}">
                </div>
            </div>
			
			<!-- 09. Liên kết tĩnh  -->
            <div class="form-group">
                <label class="col-sm-5 col-md-4 control-label"><strong>{LANG.alias}</strong></label>
                <div class="col-sm-19 col-md-20">
                    <div class="input-group">
                        <input class="form-control" type="text" name="alias" value="{ROW.alias}" id="id_alias" />
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button">
                                <i class="fa fa-refresh fa-lg" onclick="nv_get_alias('id_alias');">&nbsp;</i>
                            </button> </span></div>
                </div>
            </div>
			
			
			
			
            <div class="form-group text-center"><input class="btn btn-primary" name="submit" type="submit" value="{BUTTON_SUBMIT}" /></div>
        </div>
    </div>
</form>
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/jquery-ui/jquery-ui.min.js"></script>
<script type="text/javascript" src="{NV_BASE_SITEURL}{NV_ASSETS_DIR}/js/language/jquery.ui.datepicker-{NV_LANG_INTERFACE}.js"></script>
<script type="text/javascript">
    //<![CDATA[
    var file_items = '{FILE_ITEMS}';
    var nv_base_adminurl = '{NV_BASE_ADMINURL}';
    var file_dir = '{NV_UPLOADS_DIR}/{MODULE_UPLOAD}';
    var currentpath = "{CURRENT}";

    $(".datepicker").datepicker({
        dateFormat : "dd/mm/yy",
        changeMonth : !0,
        changeYear : !0,
        showOtherMonths : !0,
        showOn : "focus",
        yearRange : "-90:+0"
    });

    function nv_add_file() {
        var newitem = '';
        newitem += "<div class=\"form-group\">";
        newitem += "<div class=\"input-group\">";
        newitem += "    <input class=\"form-control\" type=\"text\" name=\"file[]\" id=\"file_" + file_items + "\" />";
        newitem += "    <span class=\"input-group-btn\">";
        newitem += "        <button class=\"btn btn-default\" type=\"button\" onclick=\"nv_open_browse( '" + nv_base_adminurl + "index.php?" + nv_name_variable + "=upload&popup=1&area=file_" + file_items + "&path=" + file_dir + "&type=file&currentpath=" + currentpath + "', 'NVImg', 850, 400, 'resizable=no,scrollbars=no,toolbar=no,location=no,status=no' ); return false; \" >";
        newitem += "            <em class=\"fa fa-folder-open-o fa-fix\">&nbsp;</em></button>";
        newitem += "    </span>";
        newitem += "</div>";
        newitem += "</div>";

        $("#file").append(newitem);
        file_items++;
    }

    function nv_get_alias(id) {
        var title = strip_tags($("[name='title']").val());
        if (title != '') {
            $.post(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=content&nocache=' + new Date().getTime(), 'get_alias_title=' + encodeURIComponent(title), function(res) {
                $("#" + id).val(strip_tags(res));
            });
        }
        return false;
    }
    //]]>
</script>

<!-- BEGIN: auto_get_alias -->
<script type="text/javascript">
    //<![CDATA[
    $("[name='title']").change(function() {
        nv_get_alias('id_alias');
    });
    //]]>
</script>
<!-- END: auto_get_alias -->
<!-- END: main -->