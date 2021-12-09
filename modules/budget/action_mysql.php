<?php

/**
 * @Project NUKEVIET 4.x
 * @Author Bach Dinh Cao <contact@bcbsolution.vn>
 * @Copyright (C) 2021 Bach Dinh Cao. All rights reserved
 * @License: Not free read more http://nukeviet.vn/vi/store/modules/nvtools/
 * @Createdate Wed, 01 Sep 2021 16:38:08 GMT
 */

if (!defined('NV_MAINFILE'))
    die('Stop!!!');

$sql_drop_module = array();
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data;
$sql_drop_module[] = "DROP TABLE IF EXISTS " . $db_config['prefix'] . "_" . $lang . "_" . $module_data . "_cat";

$sql_create_module = $sql_drop_module;

$sql_create_module[] = 'CREATE TABLE ' . $db_config['prefix'] . '_' . $lang . '_' . $module_data . "_cat (
  id tinyint(2) unsigned NOT NULL AUTO_INCREMENT,
  title varchar(250) NOT NULL DEFAULT '',
  alias varchar(250) NOT NULL DEFAULT '',
  note text NOT NULL COMMENT 'Ghi chú',
  weight tinyint(2) unsigned NOT NULL DEFAULT '0',
  status tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT 'Trạng thái hoạt động',
  PRIMARY KEY (id)
) ENGINE=MyISAM";

$sql_create_module[] = 'CREATE TABLE ' . $db_config['prefix'] . '_' . $lang . '_' . $module_data . "(
  id mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  title varchar(250) NOT NULL,
  alias varchar(250) NOT NULL DEFAULT '',
  catid smallint(8) unsigned NOT NULL,
  description text NOT NULL COMMENT 'Mô tả chi tiết',
  reportyear smallint(8) unsigned NOT NULL COMMENT 'Năm báo cáo',
  reporttemplate varchar(250) NOT NULL DEFAULT '' COMMENT 'Mẫu báo cáo',
  qddate int(11) unsigned NOT NULL COMMENT 'Ngày quyết định công bố',
  number varchar(100) NOT NULL,
  pubdate int(11) unsigned NOT NULL COMMENT 'Ngày công khai trên cổng',
  file text NOT NULL COMMENT 'Danh sách file',
  addtime int(11) unsigned NOT NULL,
  edittime int(11) unsigned NOT NULL,
  userid mediumint(8) unsigned NOT NULL,
  status tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (id)
) ENGINE=MyISAM";