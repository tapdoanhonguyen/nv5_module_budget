<?php

/**
 * @Project NUKEVIET 4.x
 * @Author Bach Dinh Cao <contact@bcbsolution.vn>
 * @Copyright (C) 2021 Bach Dinh Cao. All rights reserved
 * @License: Not free read more http://nukeviet.vn/vi/store/modules/nvtools/
 * @Createdate Wed, 01 Sep 2021 16:38:08 GMT
 */

if (!defined('NV_IS_FILE_ADMIN'))
    die('Stop!!!');

//change status
if ($nv_Request->isset_request('change_status', 'post, get')) {
    $id = $nv_Request->get_int('id', 'post, get', 0);
    $status = $nv_Request->get_int('status', 'post, get', 0);
    if (defined('NV_IS_GODADMIN') && $status) {
        $query = 'UPDATE ' . NV_PREFIXLANG . '_' . $module_data . ' SET status=' . intval($status) . ' WHERE id=' . $id;
        $db->query($query);
        $content = 'OK_' . $id;
        $nv_Cache->delMod($module_name);
    } else {
        $content = 'NO_' . $id;
    }
    include NV_ROOTDIR . '/includes/header.php';
    echo $content;
    include NV_ROOTDIR . '/includes/footer.php';
    exit();
}

if ($nv_Request->isset_request('delete_id', 'get') and $nv_Request->isset_request('delete_checkss', 'get')) {
    $id = $nv_Request->get_int('delete_id', 'get');
    $delete_checkss = $nv_Request->get_string('delete_checkss', 'get');
    if (defined('NV_IS_GODADMIN') && $id > 0 and $delete_checkss == md5($id . NV_CACHE_PREFIX . $client_info['session_id'])) {
        $db->query('DELETE FROM ' . NV_PREFIXLANG . '_' . $module_data . '  WHERE id = ' . $db->quote($id));
        $nv_Cache->delMod($module_name);
        nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=' . $op);
    }
}

$base_url = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $op;
$error = [];
$where = "";

$array_search = [
    'q' => $nv_Request->get_title('q', 'post,get'),
    'status' => $nv_Request->get_int('status', 'post,get', 0),
    'cat' => $nv_Request->get_int('cat', 'post,get', 0),
    'year' => $nv_Request->get_int('year', 'post,get', 0),
];

if (!empty($array_search['q'])) {
    $base_url .= '&q=' . $array_search['q'];
    $where .= ' AND (title LIKE "%' . $array_search['q'] . '%" OR number LIKE "%' . $array_search['q'] . '%")';
}

if (!empty($array_search['status'])) {
    $base_url .= '&status=' . $array_search['status'];
    $where .= ' AND status=' . $array_search['status'];
}

if (!empty($array_search['cat'])) {
    $base_url .= '&cat=' . $array_search['cat'];
    $where .= ' AND catid=' . $array_search['cat'];
}

if (!empty($array_search['year'])) {
    $base_url .= '&year=' . $array_search['year'];
    $where .= ' AND reportyear=' . $array_search['year'];
}

// Fetch Limit
$show_view = false;
if (!$nv_Request->isset_request('id', 'post,get')) {
    $show_view = true;
    $per_page = 20;
    $page = $nv_Request->get_int('page', 'post,get', 1);
    $db->sqlreset()
        ->select('COUNT(*)')
        ->from('' . NV_PREFIXLANG . '_' . $module_data)
        ->where('1.1' . $where)
        ->order('addtime DESC');

    $sth = $db->prepare($db->sql());

    $sth->execute();
    $num_items = $sth->fetchColumn();

    $db->select('*')
        ->limit($per_page)
        ->offset(($page - 1) * $per_page);

    $sth = $db->prepare($db->sql());
    $sth->execute();
}

$xtpl = new XTemplate($op . '.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('MODULE_NAME', $module_name);
$xtpl->assign('MODULE_UPLOAD', $module_upload);
$xtpl->assign('OP', $op);
$xtpl->assign('ARRAY_SEARCH', $array_search);

if ($show_view) {
    $generate_page = nv_generate_page($base_url, $num_items, $per_page, $page);
    if (!empty($generate_page)) {
        $xtpl->assign('NV_GENERATE_PAGE', $generate_page);
        $xtpl->parse('main.view.generate_page');
    }
    $number = $page > 1 ? ($per_page * ($page - 1)) + 1 : 1;

    while ($view = $sth->fetch()) {
        $view['stt'] = $number++;
        $view['cat'] = $view['catid'] ? $array_cat[$view['catid']]['title'] : '';
        $view['reportyear'] = $array_reportyear[$view['reportyear']];
        $view['addtime'] = nv_date('H:i d/m/Y', $view['addtime']);
        $view['edittime'] = nv_date('H:i d/m/Y', $view['edittime']);
        $view['link'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $array_cat[$view['catid']]['alias'] . '/' . $view['alias'] . $global_config['rewrite_exturl'];
        $xtpl->assign('CHECK', $view['status'] == 1 ? 'checked' : '');
        $view['link_edit'] = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=content&amp;id=' . $view['id'];
        $view['link_delete'] = $base_url . '&amp;delete_id=' . $view['id'] . '&amp;delete_checkss=' . md5($view['id'] . NV_CACHE_PREFIX . $client_info['session_id']);
        $view['lang_status'] = $lang_module['status_' . $view['status']];
        $view['lang_status_action'] = $lang_module['status_' . ($view['status'] == 1 ? 2 : 1)];
        $view['status'] = $view['status'] == 1 ? 2 : 1;
        $xtpl->assign('VIEW', $view);
        $xtpl->parse('main.view.loop');
    }

    foreach ($array_status as $key => $value) {
        $xtpl->assign('STATUS', [
            'key' => $key,
            'title' => $value,
            'selected' => ($key == $array_search['status']) ? "selected='selected'" : ''
        ]);
        $xtpl->parse('main.view.status_search');
    }

    foreach ($array_reportyear as $key => $value) {
        $xtpl->assign('REPORTYEAR', [
            'key' => $key,
            'title' => $value,
            'selected' => ($key == $array_search['year']) ? "selected='selected'" : ''
        ]);
        $xtpl->parse('main.view.reportyear_search');
    }

    foreach ($array_cat as $value) {
        $xtpl->assign('CAT', [
            'key' => $value['id'],
            'title' => $value['title'],
            'selected' => ($value['id'] == $array_search['cat']) ? ' selected="selected"' : ''
        ]);
        $xtpl->parse('main.view.select_cat');
    }

    $xtpl->parse('main.view');
}


$xtpl->parse('main');
$contents = $xtpl->text('main');

$page_title = $lang_module['cat_list'];

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
