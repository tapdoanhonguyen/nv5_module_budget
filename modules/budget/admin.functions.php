<?php

/**
 * @Project NUKEVIET 4.x
 * @Author Bach Dinh Cao <contact@bcbsolution.vn>
 * @Copyright (C) 2021 Bach Dinh Cao. All rights reserved
 * @License: Not free read more http://nukeviet.vn/vi/store/modules/nvtools/
 * @Createdate Wed, 01 Sep 2021 16:38:08 GMT
 */

if (!defined('NV_ADMIN') or !defined('NV_MAINFILE') or !defined('NV_IS_MODADMIN'))
    die('Stop!!!');

define('NV_IS_FILE_ADMIN', true);

include_once NV_ROOTDIR . '/modules/' . $module_file . '/site.functions.php';

$allow_func = array(
    'main',
    'cat',
    'content'
);

$array_status = [
    '1' => $lang_module['status_1'],
    '2' => $lang_module['status_2']
];