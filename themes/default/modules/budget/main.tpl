<!-- BEGIN: main -->
<div class="well">
	<form action="{NV_BASE_SITEURL}index.php" method="get">
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
                        <option value="">{LANG.reportyear}</option>
                        <!-- BEGIN: reportyear_search -->
                        <option value="{REPORTYEAR.key}" {REPORTYEAR.selected}>{REPORTYEAR.title}</option>
                        <!-- END: reportyear_search -->
                    </select>
                </div>
            </div>
			<div class="col-xs-12 col-md-6">
				<div class="form-group">
					<input class="btn btn-primary" type="submit" value="{LANG.search_submit}" />
					<a class="btn btn-success " href="{EXPORT}" download="ckns">{LANG.export}</a>
				</div>
			</div>
		</div>
	</form>
</div>
<div class="table-responsive">
	<table class="table table-striped table-bordered table-hover">
		<thead>
			<tr>
				<th class="w50 text-center">STT</th>
				<th>{LANG.title}</th>
				<th>{LANG.reportyear}</th>
				<th>{LANG.template}</th>
				<th>{LANG.number}</th>
				<th>{LANG.qddate}</th>
				<th>{LANG.link_file}</th>
			</tr>
		</thead>
		<!-- BEGIN: generate_page -->
		<tfoot>
			<tr>
				<td class="text-center" colspan="6">{NV_GENERATE_PAGE}</td>
			</tr>
		</tfoot>
		<!-- END: generate_page -->
		<tbody>
			<!-- BEGIN: loop -->
			<tr>
				<td class="text-center"> {DATA.stt} </td>
				<td><a href="{DATA.link}" title="{DATA.title}">{DATA.title}</a></td>
				<td>{DATA.reportyear}</td>
				<td>{DATA.reporttemplate}</td>
				<td>{DATA.number}</td>
				<td>{DATA.qddate}</td>
				<td class="link_ckns_stc">
					<ul>
					<!-- BEGIN: file -->
						<li><a href="{FILE.link}" title="{FILE.title}" target="_blank">{FILE.title}</a></li>
					<!-- END: file -->
					</ul>
				</td>
			</tr>
			<!-- END: loop -->
		</tbody>
	</table>
</div>
<!-- END: main -->