<?php

/**
 * @Project NUKEVIET 4.x
 * @Author Bach Dinh Cao <contact@bcbsolution.vn>
 * @Copyright (C) 2021 Bach Dinh Cao. All rights reserved
 * @License: Not free read more http://nukeviet.vn/vi/store/modules/nvtools/
 * @Createdate Wed, 01 Sep 2021 16:38:08 GMT
 */

if (!defined('NV_MAINFILE')) die('Stop!!!');

$array_reportyear = [
    '1' => '2018',
    '2' => '2019',
    '3' => '2020',
    '4' => '2021',
    '5' => '2022'
];

$_sql = 'SELECT * FROM ' . NV_PREFIXLANG . '_' . $module_data . '_cat where status=1';
$array_cat = $nv_Cache->db($_sql, 'id', $module_name);
if (!empty($array_cat)) {
    foreach ($array_cat as $row) {
        $array_cat[$row['id']]['link'] = NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $row['alias'];
    }
}

/**
 * nv_ckns()
 *
 * @param array $array_ckns
 */
function nv_ckns($array_ckns)
{
    global $db_config, $db, $global_config, $module_name, $module_upload, $array_cat, $array_reportyear;

    $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><reports/>');

    $i =1;

    while($i<4){
        if($i == 1){
            $reports = $xml->addChild('report-dutoan');
        }elseif($i == 2){
            $reports = $xml->addChild('report-thuchien');
        }else{
            $reports = $xml->addChild('report-quyettoan');
        }

        foreach($array_ckns as $items){
            $data_file_i = [];
            $items['qddate'] = nv_date('d/m/Y', $items['qddate']);
            $items['pubdate'] = nv_date('d/m/Y', $items['pubdate']);
            $items['link'] = NV_MY_DOMAIN . nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $array_cat[$items['link']]['alias'], true);
            $items['guid'] = NV_MY_DOMAIN . nv_url_rewrite(NV_BASE_SITEURL . 'index.php?' . NV_LANG_VARIABLE . '=' . NV_LANG_DATA . '&amp;' . NV_NAME_VARIABLE . '=' . $module_name . '&amp;' . NV_OP_VARIABLE . '=' . $items['guid'] . $global_config['rewrite_exturl'],true);
            $items['reportyear'] = $array_reportyear[$items['reportyear']];

            if (!empty($items['file'])) {
                $file = explode('|', $items['file']);
            } else {
                $file = [];
            }

            if (!empty($file)) {
                foreach ($file as $file_i) {
                    if (!empty($file_i) and file_exists(NV_UPLOADS_REAL_DIR . '/' . $module_upload . '/' . $file_i)) {
                        $file_i = NV_MY_DOMAIN . NV_BASE_SITEURL . NV_UPLOADS_DIR . '/' . $module_upload . '/' . $file_i;
                    }
                    $data_file_i[] = $file_i;
                }

                $items['file'] = implode('; ', $data_file_i);
            }

            $subject = $reports->addChild('item');
            foreach($items as $key => $value){
                $tmp = $subject->addChild($key, $value);
            }
        }
        $i++;
    }
    $xml->asXML('ckns.xml');
}