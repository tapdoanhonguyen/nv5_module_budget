<?php

/**
 * @Project NUKEVIET 4.x
 * @Author Bach Dinh Cao <contact@bcbsolution.vn>
 * @Copyright (C) 2021 Bach Dinh Cao. All rights reserved
 * @License: Not free read more http://nukeviet.vn/vi/store/modules/nvtools/
 * @Createdate Wed, 01 Sep 2021 16:38:08 GMT
 */

if (!defined('NV_IS_MOD_BUDGET')) die('Stop!!!');
$array_search = [
    'q' => $nv_Request->get_title('q', 'post,get'),
    'status' => $nv_Request->get_int('status', 'post,get', 0),
    'cat' => $nv_Request->get_int('cat', 'post,get', 0),
    'year' => $nv_Request->get_int('year', 'post,get', 0),
];
$sql = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . ' WHERE alias = ' . $db->quote($alias_url) . ' AND status=1  AND catid = ' . $array_search_params['catid']);
$data_content = $sql->fetch();

if (empty($data_content)) {
    $nv_redirect = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name;
    redict_link($lang_module['detail_do_not_view'], $lang_module['redirect_to_back_shops'], $nv_redirect);
}
$id = $data_content['id'];

$page_title = $data_content['title'];
$description = $data_content['description'];

$contents = nv_theme_budget_detail($data_content,$array_search);

include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';