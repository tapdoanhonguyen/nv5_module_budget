<?php

/**
 * @Project NUKEVIET 4.x
 * @Author Bach Dinh Cao <contact@bcbsolution.vn>
 * @Copyright (C) 2021 Bach Dinh Cao. All rights reserved
 * @License: Not free read more http://nukeviet.vn/vi/store/modules/nvtools/
 * @Createdate Wed, 01 Sep 2021 16:38:08 GMT
 */

if (!defined('NV_IS_MOD_BUDGET')) die('Stop!!!');
$base_url = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name ;

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

$related_new_array = [];
$related_array = [];
$st_links = 10;
if ($st_links > 0) {
    $db_slave->sqlreset()
        ->select('*')
        ->from(NV_PREFIXLANG . '_' . $module_data )
        ->where('status=1 AND pubdate > ' . $data_content['pubdate'] . ' AND catid = ' . $data_content['catid'])
        ->order('pubdate ASC')
        ->limit($st_links);

    $related = $db_slave->query($db_slave->sql());
	$number = 0;
    while ($row = $related->fetch()) {
		$number++;
        $link = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $array_cat[$data_content['catid']]['alias'] . '/' . $row['alias'] . $global_config['rewrite_exturl'];
        $related_new_array[] = [
            'stt' => $number,
            'cat' => $row['catid'] ? $array_cat[$row['catid']]['title'] : '',
            'title' => $row['title'],
            'time' => $row['pubdate'],
            'qddate' => $row['qddate'],
            'reporttemplate' => $row['reporttemplate'],
            'number' => $row['number'],
            'file' => $row['file'],
            'reportyear' => $array_reportyear[$row['reportyear']],
            'addtime' => nv_date('H:i d/m/Y', $row['addtime']),
            'edittime' => nv_date('H:i d/m/Y', $row['edittime']),
            'link' => $link
        ];
    }
    $related->closeCursor();

    sort($related_new_array, SORT_NUMERIC);

    $db_slave->sqlreset()
        ->select('*')
        ->from(NV_PREFIXLANG . '_' . $module_data )
        ->where('status=1 AND pubdate < ' . $data_content['pubdate'] . ' AND catid = ' . $data_content['catid'])
        ->order('pubdate DESC')
        ->limit($st_links);

    $related = $db_slave->query($db_slave->sql());
	$number = 0;
    while ($row = $related->fetch()) {
		$number++;
        $link = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $array_cat[$data_content['catid']]['alias'] . '/' . $row['alias'] . $global_config['rewrite_exturl'];
        $related_array[] = [
            'stt' => $number,
            'cat' => $row['catid'] ? $array_cat[$row['catid']]['title'] : '',
            'title' => $row['title'],
            'time' => $row['pubdate'],
            'reporttemplate' => $row['reporttemplate'],
            'qddate' => $row['qddate'],
            'number' => $row['number'],
            'file' => $row['file'],
            'reportyear' => $array_reportyear[$row['reportyear']],
            'addtime' => nv_date('H:i d/m/Y', $row['addtime']),
            'edittime' => nv_date('H:i d/m/Y', $row['edittime']),
            'link' => $link
        ];
    }

    $related->closeCursor();
    unset($related, $row);
}
$page_title = $data_content['title'];
$description = $data_content['description'];

$contents = nv_theme_budget_detail($data_content,$array_search,$related_new_array, $related_array);

include NV_ROOTDIR . '/includes/header.php';
echo nv_site_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';