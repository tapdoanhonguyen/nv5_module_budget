<?php

/**
 * @Project NUKEVIET 4.x
 * @Author Bach Dinh Cao <contact@bcbsolution.vn>
 * @Copyright (C) 2021 Bach Dinh Cao. All rights reserved
 * @License: Not free read more http://nukeviet.vn/vi/store/modules/nvtools/
 * @Createdate Wed, 01 Sep 2021 16:38:08 GMT
 */

if (!defined('NV_SYSTEM'))
    die('Stop!!!');

define('NV_IS_MOD_BUDGET', true);

include_once NV_ROOTDIR . '/modules/' . $module_file . '/site.functions.php';

$catid = 0;
$page = 1;
$per_page = 10;
$url_string = !empty($array_op) ? $array_op[0] : '';

$array_search_params = array(
    'catid' => 0 
);

if (!empty($url_string)) {
    foreach ($array_cat as $row) {
        $array_cat_alias[] = $row['alias'];
        $array_cat[$row['id']]['link'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $row['alias'];
        if (preg_match('/' . $row['alias'] . '$/i', $url_string)) {
            $array_search_params['catid'] = $catid = $row['id'];
            break;
        }
    }
}

$count_op = sizeof($array_op);

if (!empty($array_op) and $op == 'main') {
    if (empty($array_search_params['catid']) and count($array_op) < 2) {
        if (isset($array_op[0]) and substr($array_op[0], 0, 5) == 'page-') {
            $page = intval(substr($array_op[0], 5));
        } elseif (!empty($alias_cat_url)) {
            $redirect = '<meta http-equiv="Refresh" content="3;URL=' . nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name, true) . '" />';
            nv_info_die($lang_global['error_404_title'], $lang_global['error_404_title'], $lang_global['error_404_content'] . $redirect);
        }
    } else {
        $op = 'main';
        
        if ($count_op == 1 or substr($array_op[1], 0, 5) == 'page-') {
            if (!empty($array_search_params['catid'])) {
                $op = 'viewcat';
            } 
            if ($count_op > 1) {
                $page = intval(substr($array_op[1], 5));
            }
        } elseif ($count_op == 2) {
            $alias_url = $array_op[1];
            if ($alias_url != '') {
                $op = 'detail';
            }
        }
        
        $parentid = $array_search_params['catid'];
        if ($parentid > 0) {
            $array_mod_title[] = array(
                'catid' => $parentid,
                'title' => $array_cat[$parentid]['title'],
                'link' => $array_cat[$parentid]['link']
            );
        }
        sort($array_mod_title, SORT_NUMERIC);
    }
}