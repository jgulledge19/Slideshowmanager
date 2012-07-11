<?php

$s_path = $modx->getOption('core_path').'components/slideshowmanager/model/';
$modx->addPackage('slideshowmanager', $s_path);

$manager = $modx->getManager();
$modx->setLogLevel(modX::LOG_LEVEL_ERROR);

$modx->exec("ALTER TABLE {$modx->getTableName('jgSlideshowAlbum')}
    ADD COLUMN `constrain` TINYINT DEFAULT '1' NOT NULL AFTER `file_size_limit`,
    ADD COLUMN `image_instructions` MEDIUMTEXT NULL AFTER `description`,
    ADD COLUMN `advanced_instructions` MEDIUMTEXT NULL AFTER `image_instructions`");
