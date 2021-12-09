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

if(empty($db->query('SELECT count(*) FROM ' . NV_PREFIXLANG . '_' . $module_data . '_cat WHERE status=1')->fetchColumn())){
    $url_back = NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=cat';
    $contents = nv_theme_alert($lang_module['alert_title_not_cat'],  $lang_module['alert_content_not_cat'],  'danger',  $url_back,  $lang_module['alert_back']);
    include NV_ROOTDIR . '/includes/header.php';
    echo nv_admin_theme($contents);
    include NV_ROOTDIR . '/includes/footer.php';
}

if ($nv_Request->isset_request('get_alias_title', 'post')) {
    $alias = $nv_Request->get_title('get_alias_title', 'post', '');
    $alias = change_alias($alias);
    die(strtolower($alias));
}

$currentpath = NV_UPLOADS_DIR . '/' . $module_upload . '/' . date('Y_m');
if (!file_exists($currentpath)) {
    nv_mkdir(NV_UPLOADS_REAL_DIR . '/' . $module_upload, date('Y_m'), true);
}

$row = array();
$error = array();
$row['id'] = $nv_Request->get_int('id', 'post,get', 0);
if ($nv_Request->isset_request('submit', 'post')) {
    $row['title'] = $nv_Request->get_title('title', 'post', '');
    $row['alias'] = $nv_Request->get_title('alias', 'post', '');
    $row['alias'] = (empty($row['alias'])) ? change_alias($row['title']) : change_alias($row['alias']);
    $row['catid'] = $nv_Request->get_int('catid', 'post', 0);
    $row['description'] = $nv_Request->get_string('description', 'post', '');
    $row['reportyear'] = $nv_Request->get_int('reportyear', 'post', 0);
    $row['reporttemplate'] = $nv_Request->get_title('reporttemplate', 'post', '');
    $row['number'] = $nv_Request->get_title('number', 'post', '');
    $button_submit = $lang_module['budget_addnew'];
	
		$alias_exit = $db->query('SELECT id FROM ' . NV_PREFIXLANG . '_' . $module_data . ' WHERE alias = "' . $row['alias'] . '"')->fetchColumn();
    if (preg_match('/^([0-9]{1,2})\/([0-9]{1,2})\/([0-9]{4})$/', $nv_Request->get_string('qddate', 'post'), $m)) {
        $row['qddate'] = mktime(date("H",NV_CURRENTTIME), mktime(date("i",NV_CURRENTTIME), mktime(date("s",NV_CURRENTTIME), $m[2], $m[1], $m[3]);
    } else {
        $row['qddate'] = 0;
    }
	
    if (preg_match('/^([0-9]{1,2})\/([0-9]{1,2})\/([0-9]{4})$/', $nv_Request->get_string('pubdate', 'post'), $m)) {
        $row['pubdate'] = mktime(date("H",NV_CURRENTTIME), mktime(date("i",NV_CURRENTTIME), mktime(date("s",NV_CURRENTTIME), $m[2], $m[1], $m[3]);
    } else {
        $row['pubdate'] = 0;
    }

    // Xu ly file
    $file = $nv_Request->get_typed_array('file', 'post', 'string');
    $array_files = [];
    foreach ($file as $file_i) {
        if (!nv_is_url($file_i) and file_exists(NV_DOCUMENT_ROOT . $file_i)) {
            $lu = strlen(NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/');
            $file_i = substr($file_i, $lu);
        } elseif (!nv_is_url($file_i)) {
            $file_i = '';
        }
        if (!empty($file_i)) {
            $array_files[] = $file_i;
        }
    }
    $row['file'] = implode('|', $array_files);

    if (empty($row['title'])) {
        $error[] = $lang_module['error_required_title'];
    }elseif (empty($row['alias'])) {
        $error[] = $lang_module['error_required_alias'];
    }elseif (empty($row['catid'])) {
        $error[] = $lang_module['error_required_cat'];
    }elseif (empty($row['reportyear'])) {
        $error[] = $lang_module['error_required_reportyear'];
    } elseif($alias_exit && $row['id'] == 0){
		$error[] = $lang_module['error_alias_duplicate'];
	}elseif($alias_exit && $row['id'] != 0 && $row['id'] != $alias_exit){
		$error[] = $lang_module['error_alias_duplicate'];
	}

    if (empty($error)) {
        try {
            if (empty($row['id'])) {
                $sql = 'INSERT INTO ' . NV_PREFIXLANG . '_' . $module_data . ' (title, alias, catid, description, reportyear, reporttemplate, qddate, number, pubdate, file, addtime, userid) VALUES (:title, :alias, :catid, :description, :reportyear, :reporttemplate, :qddate, :number, :pubdate, :file, ' . NV_CURRENTTIME . ', ' . $admin_info['userid'] . ')';
                $data_insert = array();
                $data_insert['title'] = $row['title'];
                $data_insert['alias'] = strtolower($row['alias']);
                $data_insert['catid'] = $row['catid'];
                $data_insert['description'] = $row['description'];
                $data_insert['reportyear'] = $row['reportyear'];
                $data_insert['reporttemplate'] = $row['reporttemplate'];
                $data_insert['qddate'] = $row['qddate'];
                $data_insert['number'] = $row['number'];
                $data_insert['pubdate'] = $row['pubdate'];
                $data_insert['file'] = $row['file'];
                $new_id = $db->insert_id($sql, 'id', $data_insert);
            } else {
                $stmt = $db->prepare('UPDATE ' . NV_PREFIXLANG . '_' . $module_data . ' SET title = :title, alias = :alias, catid = :catid, description = :description, reportyear = :reportyear, reporttemplate = :reporttemplate, qddate = :qddate, number = :number, pubdate = :pubdate, file = :file, edittime = ' . NV_CURRENTTIME . ' WHERE id=' . $row['id']);
                $stmt->bindParam(':title', $row['title'], PDO::PARAM_STR);
                $stmt->bindParam(':alias', strtolower($row['alias']), PDO::PARAM_STR);
                $stmt->bindParam(':catid', $row['catid'], PDO::PARAM_INT);
                $stmt->bindParam(':description', $row['description'], PDO::PARAM_STR);
                $stmt->bindParam(':reportyear', $row['reportyear'], PDO::PARAM_INT);
                $stmt->bindParam(':reporttemplate', $row['reporttemplate'], PDO::PARAM_STR);
                $stmt->bindParam(':qddate', $row['qddate'], PDO::PARAM_INT);
                $stmt->bindParam(':number', $row['number'], PDO::PARAM_STR);
                $stmt->bindParam(':pubdate', $row['pubdate'], PDO::PARAM_INT);
                $stmt->bindParam(':file', $row['file'], PDO::PARAM_STR, strlen($row['file']));
                if ($stmt->execute()) {
                    $new_id = $row['id'];
                }
            }

            if ($new_id > 0) {
                $nv_Cache->delMod($module_name);
                nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=main');
            }
        } catch (PDOException $e) {
            trigger_error($e->getMessage());
            die($e->getMessage());
        }
    }
} elseif ($row['id'] > 0) {
    $row = $db->query('SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . ' WHERE id=' . $row['id'])->fetch();
    if (empty($row)) {
        nv_redirect_location(NV_BASE_ADMINURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&' . NV_NAME_VARIABLE . '=' . $module_name . '&' . NV_OP_VARIABLE . '=main');
    }
    $button_submit = $lang_module['budget_update'];
} else {
    $row['id'] = 0;
    $row['title'] = '';
    $row['alias'] = '';
    $row['catid'] = 0;
    $row['description'] = '';
    $row['reportyear'] = 0;
    $row['reporttemplate'] = '';
    $row['qddate'] = NV_CURRENTTIME;
    $row['number'] = '';
    $row['pubdate'] = NV_CURRENTTIME;
    $row['file'] = '';
    $button_submit = $lang_module['budget_addnew'];
}

$row['qddate'] = !empty($row['qddate']) ? nv_date('d/m/Y', $row['qddate']) : '';
$row['pubdate'] = !empty($row['pubdate']) ? nv_date('d/m/Y', $row['pubdate']) : '';

if (!empty($row['file'])) {
    $file = explode('|', $row['file']);
} else {
    $file = [];
}

$xtpl = new XTemplate($op . '.tpl', NV_ROOTDIR . '/themes/' . $global_config['module_theme'] . '/modules/' . $module_file);
$xtpl->assign('LANG', $lang_module);
$xtpl->assign('MODULE_NAME', $module_name);
$xtpl->assign('MODULE_UPLOAD', $module_upload);
$xtpl->assign('OP', $op);
$xtpl->assign('ROW', $row);
$xtpl->assign('BUTTON_SUBMIT', $button_submit);
$xtpl->assign('CURRENT', $currentpath);

foreach ($array_cat as $value) {
    $xtpl->assign('CAT', array(
        'key' => $value['id'],
        'title' => $value['title'],
        'selected' => ($value['id'] == $row['catid']) ? ' selected="selected"' : ''
    ));
    $xtpl->parse('main.select_catid');
}

foreach($array_reportyear as $key => $year){
    $xtpl->assign('YEAR', [
        'title' => $year,
        'key' => $key,
        'selected' => $key === $row['reportyear'] ? "selected='selected'" : '',
    ]);
    $xtpl->parse('main.select_reportyear');
}

$items = 0;
if (!empty($file)) {
    foreach ($file as $file_i) {
        if (!empty($file_i) and file_exists(NV_UPLOADS_REAL_DIR . '/' . $module_upload . '/' . $file_i)) {
            $file_i = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/' . $file_i;
        }
        $data_file_i = array(
            'id' => $items,
            'value' => $file_i
        );
        $xtpl->assign('FILE', $data_file_i);
        $xtpl->parse('main.file');
        ++$items;
    }
}
$xtpl->assign('FILE_ITEMS', $items);


if (!empty($error)) {
    $xtpl->assign('ERROR', implode('<br />', $error));
    $xtpl->parse('main.error');
}

if (empty($row['id'])) {
    $xtpl->parse('main.auto_get_alias');
}

$xtpl->parse('main');
$contents = $xtpl->text('main');

$page_title = $button_submit;

include NV_ROOTDIR . '/includes/header.php';
echo nv_admin_theme($contents);
include NV_ROOTDIR . '/includes/footer.php';
