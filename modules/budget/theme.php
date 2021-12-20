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

/**
 * nv_theme_budget_main()
 * 
 * @param mixed $array_data
 * @param mixed $array_search
 * @param mixed $generate_page
 * @return
 */
function nv_theme_budget_main($array_data, $array_ckns, $array_search, $generate_page)
{
    global $global_config, $module_name, $module_file, $module_upload, $module_config, $module_info, $lang_module, $lang_global, $op, $array_cat, $array_reportyear;

    $xtpl = new XTemplate($op . '.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_info['module_theme']);
    $xtpl->assign('LANG', $lang_module);
    $xtpl->assign('MODULE_NAME', $module_name);
    $xtpl->assign('MODULE_UPLOAD', $module_upload);
    $xtpl->assign('OP', $op);
    $xtpl->assign('ARRAY_SEARCH', $array_search);

    $stt = 1;

    if (!empty($array_data)) {
        foreach ($array_data as $items) {
            //$items['stt'] = $stt++;
            $items['reportyear'] = $array_reportyear[$items['reportyear']];
            $items['qddate'] = nv_date('d/m/Y', $items['qddate']);

            $items['link'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $array_cat[$items['catid']]['alias'] . '/' . $items['alias'] . $global_config['rewrite_exturl'];

            if (!empty($items['file'])) {
                $file = explode('|', $items['file']);
            } else {
                $file = [];
            }

            $xtpl->assign('DATA', $items);
            $xtpl->assign('EXPORT', NV_MY_DOMAIN . '/ckns.xml');

            if (!empty($file)) {
                foreach ($file as $file_i) {
                    $file_title = basename($file_i);

                    if (!empty($file_i) and file_exists(NV_UPLOADS_REAL_DIR . '/' . $module_upload . '/' . $file_i)) {
                        $file_i = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/' . $file_i;
                    }
                    $data_file_i = [
                        'link' => $file_i,
                        'title' => $file_title
                    ];
                    $xtpl->assign('FILE', $data_file_i);
                    $xtpl->parse('main.loop.file');
                }
            }

            $xtpl->parse('main.loop');
        }
    }

    if (!empty($array_ckns)) {
        nv_ckns($array_ckns);
    }

    foreach ($array_cat as $value) {
        $xtpl->assign('CAT', [
            'key' => $value['id'],
            'title' => $value['title'],
            'selected' => ($value['id'] == $array_search['cat']) ? ' selected="selected"' : ''
        ]);
        $xtpl->parse('main.select_cat');
    }

    foreach ($array_reportyear as $key => $value) {
        $xtpl->assign('REPORTYEAR', [
            'key' => $key,
            'title' => $value,
            'selected' => ($key == $array_search['year']) ? "selected='selected'" : ''
        ]);
        $xtpl->parse('main.reportyear_search');
    }
    if (!empty($generate_page)) {
        $xtpl->assign('NV_GENERATE_PAGE', $generate_page);
        $xtpl->parse('main.generate_page');
    }

    $xtpl->parse('main');
    return $xtpl->text('main');
}

/**
 * nv_theme_budget_viewcat()
 * 
 * @param mixed $array_data
 * @param mixed $array_search
 * @param mixed $generate_page
 * @return
 */
function nv_theme_budget_viewcat($array_data, $array_op, $array_search, $generate_page)
{
    global $global_config, $module_name, $module_file, $module_upload, $module_config, $module_info, $lang_module, $lang_global, $op, $array_cat, $array_reportyear;

    $xtpl = new XTemplate($op . '.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_info['module_theme']);
    $xtpl->assign('LANG', $lang_module);
    $xtpl->assign('MODULE_NAME', $module_name);
    $xtpl->assign('MODULE_UPLOAD', $module_upload);
    $xtpl->assign('OP', $array_op);
    $xtpl->assign('ARRAY_SEARCH', $array_search);

    $stt = 1;

    if (!empty($array_data)) {
        foreach ($array_data as $items) {
            $items['stt'] = $stt++;
            $items['reportyear'] = $array_reportyear[$items['reportyear']];
            $items['qddate'] = nv_date('d/m/Y', $items['qddate']);

            $items['link'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $array_cat[$items['catid']]['alias'] . '/' . $items['alias'] . $global_config['rewrite_exturl'];

            if (!empty($items['file'])) {
                $file = explode('|', $items['file']);
            } else {
                $file = [];
            }

            $xtpl->assign('DATA', $items);
            $xtpl->assign('EXPORT', NV_MY_DOMAIN . '/ckns.xml');

            if (!empty($file)) {
                foreach ($file as $file_i) {
                    $file_title = basename($file_i);

                    if (!empty($file_i) and file_exists(NV_UPLOADS_REAL_DIR . '/' . $module_upload . '/' . $file_i)) {
                        $file_i = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/' . $file_i;
                    }
                    $data_file_i = [
                        'link' => $file_i,
                        'title' => $file_title
                    ];
                    $xtpl->assign('FILE', $data_file_i);
                    $xtpl->parse('main.loop.file');
                }
            }

            $xtpl->parse('main.loop');
        }
    }

    foreach ($array_cat as $value) {
        $xtpl->assign('CAT', [
            'key' => $value['id'],
            'title' => $value['title'],
            'selected' => ($value['id'] == $array_search['cat']) ? ' selected="selected"' : ''
        ]);
        $xtpl->parse('main.select_cat');
    }

    foreach ($array_reportyear as $key => $value) {
        $xtpl->assign('REPORTYEAR', [
            'key' => $key,
            'title' => $value,
            'selected' => ($key == $array_search['year']) ? "selected='selected'" : ''
        ]);
        $xtpl->parse('main.reportyear_search');
    }

    if (!empty($generate_page)) {
        $xtpl->assign('NV_GENERATE_PAGE', $generate_page);
        $xtpl->parse('main.generate_page');
    }

    $xtpl->parse('main');
    return $xtpl->text('main');
}


/**
 * nv_theme_budget_detail()
 * 
 * @param mixed $data_content
 * @param mixed $num
 * @return
 */
function nv_theme_budget_detail($data_content,$array_search,$related_new_array, $related_array)
{
    global $global_config, $module_name, $module_file, $module_upload, $module_config, $module_info, $lang_module, $lang_global, $op, $array_cat, $array_reportyear;

    $xtpl = new XTemplate($op . '.tpl', NV_ROOTDIR . '/themes/' . $module_info['template'] . '/modules/' . $module_file);
    $xtpl->assign('MODULE_NAME', $module_name);
    $xtpl->assign('LANG', $lang_module);
    $xtpl->assign('EXPORT', NV_MY_DOMAIN . '/ckns.xml');

    $data_content['reportyear'] = $array_reportyear[$data_content['reportyear']];
    $data_content['qddate'] = nv_date('d/m/Y', $data_content['qddate']);
    $data_content['pubdate'] = nv_date('d/m/Y', $data_content['pubdate']);

    if (!empty($data_content['file'])) {
        $file = explode('|', $data_content['file']);
    } else {
        $file = [];
    }

    $xtpl->assign('DATA', $data_content);

    if (!empty($file)) {
        foreach ($file as $file_i) {
            $file_title = basename($file_i);

            if (!empty($file_i) and file_exists(NV_UPLOADS_REAL_DIR . '/' . $module_upload . '/' . $file_i)) {
                $file_i = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/' . $file_i;
            }
            $data_file_i = [
                'link' => $file_i,
                'title' => $file_title
            ];
            $xtpl->assign('FILE', $data_file_i);
            $xtpl->parse('main.file');
        }
    }

    foreach ($array_cat as $value) {
        $xtpl->assign('CAT', [
            'key' => $value['id'],
            'title' => $value['title'],
            'selected' => ($value['id'] == $array_search['cat']) ? ' selected="selected"' : ''
        ]);
        $xtpl->parse('main.select_cat');
    }

    foreach ($array_reportyear as $key => $value) {
        $xtpl->assign('REPORTYEAR', [
            'key' => $key,
            'title' => $value,
            'selected' => ($key == $array_search['year']) ? "selected='selected'" : ''
        ]);
        $xtpl->parse('main.reportyear_search');
    }
	if (!empty($related_new_array) or !empty($related_array) or !empty($topic_array)) {
        if (!empty($related_new_array)) {
            foreach ($related_new_array as $key => $related_new_array_i) {
				if (!empty($related_new_array_i['file'])) {
					$file = explode('|', $related_new_array_i['file']);
				} else {
					$file = [];
				}
				if (!empty($file)) {
					foreach ($file as $file_i) {
						$file_title = basename($file_i);

						if (!empty($file_i) and file_exists(NV_UPLOADS_REAL_DIR . '/' . $module_upload . '/' . $file_i)) {
							$file_i = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/' . $file_i;
						}
						$data_file_i = [
							'link' => $file_i,
							'title' => $file_title
						];
						$xtpl->assign('FILE', $data_file_i);
						$xtpl->parse('main.others.related_new.loop.file');
					}
				}
                $related_new_array_i['time'] = nv_date('d/m/Y', $related_new_array_i['time']);
				$related_new_array_i['qddate'] = nv_date('d/m/Y', $related_new_array_i['qddate']);
                $xtpl->assign('RELATED_NEW', $related_new_array_i);


                $xtpl->parse('main.others.related_new.loop');
            }
            unset($key);
            $xtpl->parse('main.others.related_new');
        }

        if (!empty($related_array)) {
            foreach ($related_array as $related_array_i) {
				if (!empty($related_array_i['file'])) {
					$file = explode('|', $related_array_i['file']);
				} else {
					$file = [];
				}
				if (!empty($file)) {
					foreach ($file as $file_i) {
						$file_title = basename($file_i);

						if (!empty($file_i) and file_exists(NV_UPLOADS_REAL_DIR . '/' . $module_upload . '/' . $file_i)) {
							$file_i = NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/' . $file_i;
						}
						$data_file_i = [
							'link' => $file_i,
							'title' => $file_title
						];
						$xtpl->assign('FILE', $data_file_i);
						$xtpl->parse('main.others.related.loop.file');
					}
				}
				$related_array_i['qddate'] = nv_date('d/m/Y', $related_array_i['qddate']);
                $related_array_i['time'] = nv_date('d/m/Y', $related_array_i['time']);
                $xtpl->assign('RELATED', $related_array_i);


                $xtpl->parse('main.others.related.loop');
            }
            $xtpl->parse('main.others.related');
        }
        $xtpl->parse('main.others');
    }
	
    $xtpl->parse('main');
    return $xtpl->text('main');
}