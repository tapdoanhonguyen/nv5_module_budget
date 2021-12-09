<?php

/**
 * @Project NUKEVIET 4.x
 * @Author Bach Dinh Cao <contact@bcbsolution.vn>
 * @Copyright (C) 2021 Bach Dinh Cao. All rights reserved
 * @License: Not free read more http://nukeviet.vn/vi/store/modules/nvtools/
 * @Createdate Wed, 01 Sep 2021 16:38:08 GMT
 */

if (!defined('NV_IS_MOD_BUDGET')) die('Stop!!!');

$page_title = $array_cat[$array_search_params['catid']]['title'];
$description = $array_cat[$array_search_params['catid']]['note'];

$base_url = $array_cat[$array_search_params['catid']]['link'];
$array_data = [];
$where = "";

$array_op = ($array_op[0]);

$array_search = [
    'q' => $nv_Request->get_title('q', 'post,get'),
    'cat' => $nv_Request->get_int('cat', 'post,get', 0),
    'year' => $nv_Request->get_int('year', 'post,get', 0),
];

if (!empty($array_search['q'])) {
    $base_url .= '&q=' . $array_search['q'];
    $where .= ' AND (title LIKE "%' . $array_search['q'] . '%" OR number LIKE "%' . $array_search['q'] . '%")';
}

if (!empty($array_search['cat'])) {
    $base_url .= '&cat=' . $array_search['cat'];
    $where .= ' AND catid=' . $array_search['cat'];
}

if (!empty($array_search['year'])) {
    $base_url .= '&year=' . $array_search['year'];
    $where .= ' AND reportyear=' . $array_search['year'];
}

if (!$nv_Request->isset_request('id', 'post,get')) {
    $page = $nv_Request->get_int('page', 'post,get', 1);

    $db->sqlreset()
    ->select('COUNT(*) ')
    ->from('' . NV_PREFIXLANG . '_' . $module_data)
    ->where('status=1 AND catid=' . $array_search_params['catid'] . $where);

    $num_items = $db->query($db->sql())
        ->fetchColumn();

    $db->select('*')
        ->order('qddate DESC')
        ->limit($per_page)
        ->offset(($page - 1) * $per_page);

    $result = $db->query($db->sql());

    while ($item = $result->fetch()) {
        $array_data[$item['id']] = $item;
    }
}

$generate_page = nv_alias_page($page_title, $base_url, $num_items, $per_page, $page);
if ($page > 1) {
    $page_title = $page_title . ' - ' . $lang_global['page'] . ' ' . $page;
}

$contents = nv_theme_budget_viewcat($array_data, $array_op, $array_search, $generate_page);

include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';