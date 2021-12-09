<!-- BEGIN: main -->
<div class="well">
	<form action="{NV_BASE_SITEURL}index.php?language=vi&nv={MODULE_NAME}&op=main" method="get">
		<input type="hidden" name="{NV_LANG_VARIABLE}" value="{NV_LANG_DATA}" />
		<input type="hidden" name="{NV_NAME_VARIABLE}" value="{MODULE_NAME}" />
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
		<tbody>
			<tr>
				<td class="w20"><strong>{LANG.title}</strong></td>
				<td><strong>{DATA.title}</strong></td>
			</tr>
			<tr>
				<td>{LANG.description}</td>
				<td>{DATA.description}</td>
			</tr>
			<tr>
				<td>{LANG.reportyear}</td>
				<td>{DATA.reportyear}</td>
			</tr>
			<tr>
				<td>{LANG.reporttemplate}</td>
				<td>{DATA.reporttemplate}</td>
			</tr>
			<tr>
				<td>{LANG.qddate2}</td>
				<td>{DATA.qddate}</td>
			</tr>
			<tr>
				<td>{LANG.number2}</td>
				<td>{DATA.number}</td>
			</tr>
			<tr>
				<td>{LANG.pubdate}</td>
				<td>{DATA.pubdate}</td>
			</tr>
			<tr>
				<td>{LANG.file}</td>
				<td>
					<ul>
					<!-- BEGIN: file -->
						<li><a href="{FILE.link}" title="{FILE.title}" target="_blank">{FILE.title}</a></li>
					<!-- END: file -->
					</ul>
				</td>
			</tr>
		</tbody>
	</table>
</div>
<!-- END: main -->