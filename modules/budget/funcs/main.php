<?php

/**
 * @Project NUKEVIET 4.x
 * @Author Bach Dinh Cao <contact@bcbsolution.vn>
 * @Copyright (C) 2021 Bach Dinh Cao. All rights reserved
 * @License: Not free read more http://nukeviet.vn/vi/store/modules/nvtools/
 * @Createdate Wed, 01 Sep 2021 16:38:08 GMT
 */

if (!defined('NV_IS_MOD_BUDGET'))
    die('Stop!!!');

$page_title = $lang_module['budget'];
$key_words = $module_info['keywords'];

$base_url = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op;
$array_data = [];
$where = "";
$base_url_mod = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op . '&amp;per_page=' . $per_page;


$array_search = [
    'q' => $nv_Request->get_title('q', 'post,get'),
    'cat' => $nv_Request->get_int('cat', 'post,get', 0),
    'year' => $nv_Request->get_int('year', 'post,get', 0),
];

if (!empty($array_search['q'])) {
    $base_url .= '&amp;q=' . $array_search['q'];
    $where .= ' AND (title LIKE "%' . $array_search['q'] . '%" OR number LIKE "%' . $array_search['q'] . '%")';
}

if (!empty($array_search['cat'])) {
     $base_url .= '&amp;cat=' . $array_search['cat'];
    $where .= ' AND catid=' . $array_search['cat'];
}

if (!empty($array_search['year'])) {
     $base_url .= '&amp;year=' . $array_search['year'];
    $where .= ' AND reportyear=' . $array_search['year'];
}

// Fetch Limit
$show_view = false;
if (!$nv_Request->isset_request('id', 'post,get')) {
    $show_view = true;
	$page = $nv_Request->get_int('page', 'post,get', 1);
    $db->sqlreset()
        ->select('COUNT(*)')
        ->from('' . NV_PREFIXLANG . '_' . $module_data)
        ->where('1.1' . $where)
        ->order('qddate DESC');

    $sth = $db->prepare($db->sql());

    $sth->execute();
    $num_items = $sth->fetchColumn();

    $db->select('*')
        ->limit($per_page)
        ->offset(($page - 1) * $per_page);

    $sth = $db->prepare($db->sql());
    $sth->execute();
}

$result = $db->query($db->sql());
$base_url_mod .= '&amp;num_items=' . $num_items;
 $number = $page > 1 ? ($per_page * ($page - 1)) + 1 : 1;
while ($item = $result->fetch()) {
	$item['stt'] = $number;
    $array_data[$item['id']] = $item;
	$number++;
}

$result = $db->query($db->sql());

while ($item = $result->fetch()) {
    $array_ckns[$item['id']]['title'] = $item['title'];
    $array_ckns[$item['id']]['link'] = $item['catid'];
    $array_ckns[$item['id']]['description'] = $item['description'];
    $array_ckns[$item['id']]['reportyear'] = $item['reportyear'];
    $array_ckns[$item['id']]['reporttemplate'] = $item['reporttemplate'];
    $array_ckns[$item['id']]['qddate'] = $item['qddate'];
    $array_ckns[$item['id']]['qdnumber'] = $item['number'];
    $array_ckns[$item['id']]['pubdate'] = $item['pubdate'];
    $array_ckns[$item['id']]['file'] = $item['file'];
    $array_ckns[$item['id']]['guid'] = $array_cat[$item['catid']]['alias'] . '/' . $item['alias'];
}

//$base_url = $base_url_mod;
$generate_page = nv_generate_page($base_url, $num_items, $per_page, $page);
   
if ($page > 1) {
    $page_title = $page_title . ' - ' . $lang_global['page'] . ' ' . $page;
}

$contents = nv_theme_budget_main($array_data, $array_ckns, $array_search, $generate_page);

include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
