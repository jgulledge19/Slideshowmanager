<?php

/**
 * MyComponent resolver script - runs on install.
 *
 * Copyright 2011 Your Name <you@yourdomain.com>
 * @author Your Name <you@yourdomain.com>
 * 1/1/11
 *
 * MyComponent is free software; you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by the Free
 * Software Foundation; either version 2 of the License, or (at your option) any
 * later version.
 *
 * MyComponent is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * MyComponent; if not, write to the Free Software Foundation, Inc., 59 Temple
 * Place, Suite 330, Boston, MA 02111-1307 USA
 *
 * @package mycomponent
 */
/**
 * Description: Resolver script for MyComponent package
 * @package mycomponent
 * @subpackage build
 */

/* Example Resolver script */

/* The $modx object is not available here. In its place we
 * use $object->xpdo
 */

if ($object->xpdo) {
    $modx =& $object->xpdo;
    // add package
    $s_path = $modx->getOption('core_path').'components/slideshowmanager/model/';
    $modx->addPackage('slideshowmanager', $s_path);
    
    switch ($options[xPDOTransport::PACKAGE_ACTION]) {
        case xPDOTransport::ACTION_INSTALL:
        case xPDOTransport::ACTION_UPGRADE:
            
            //$modx->log(xPDO::LOG_LEVEL_INFO,'Package Path: '.$s_path);
            $manager = $modx->getManager();
            $modx->setLogLevel(modX::LOG_LEVEL_ERROR);
            $manager->createObjectContainer('jgSlideshowAlbum');
            $manager->createObjectContainer('jgSlideshowSlide');
            $modx->setLogLevel(modX::LOG_LEVEL_INFO);
            break;
    }
    switch ($options[xPDOTransport::PACKAGE_ACTION]) {
        case xPDOTransport::ACTION_INSTALL:
            // create a default slideshow:
            $c = $modx->newQuery('jgSlideshowAlbum');
            $c->limit(1, 0);
            $count = $modx->getCount('jgSlideshowAlbum',$c);
            if ( $count == 0 ) {
                $album = $modx->newObject('jgSlideshowAlbum');
                $album->fromArray(array(
                    'title' => 'My Slideshow', 
                    'description' => 'This is the default slideshow',
                    'file_allowed' => 'jpg, jpeg|png|',
                    'file_size_limit' => '300',
                    'file_width' => '600',
                    'file_height' => '400',
                    'icon_path' => '',
                    'image_instructions' => 'Set the width to 600px and the height to 400px for the image upload'
                    ));
                if ($album->save() == false) {
                    $modx->log(xPDO::LOG_LEVEL_ERROR,'ERROR adding default data to table: jgSlideshowAlbum ');
                } else {
                    /*
                    $modx->log(xPDO::LOG_LEVEL_INFO,'Added default data to table: jgSlideshowAlbum ');
                    // add default pictures? maybe later
                    $album_id = $album->get('id');
                    
                    $time = date('Y-m-d g:h:s');
                    $end_date = date('Y-m-d g:h:s', time()+24*3600*30*24);// about 2 years out
                    
                    $slide = $modx->newObject('jgSlideshowSlide');
                    $slide->fromArray(array(
                        'slideshow_album_id' => $album_id,
                        'web_user_id' => '',
                        'start_date' => $time,
                        'end_date' => $end_date,
                        'edit_time' => $time,
                        'sequence' => '1',
                        'slide_status' => 'live',
                        'version' => '1',
                        'options' => '',
                        'url' => '[[~1]]',
                        'title' => 'Slide 1',
                        'description' => 'MODX Revolution Bend it any way you want.',
                        'notes' => 'Test Notes',
                        'html' => '',
                        'upload_time' => $time,
                        'file_path' => 'test_1.jpg',
                        'file_size' => '45',
                        'file_type' => 'jpg',
                    )); 
                    if ($slide->save() == false) {
                        $modx->log(xPDO::LOG_LEVEL_INFO, 'Added example slide 1 to the default My Slideshow album');
                    }
                    
                    $slide2 = $modx->newObject('jgSlideshowSlide');
                    $slide2->fromArray(array(
                        'slideshow_album_id' => $album_id,
                        'web_user_id' => '',
                        'start_date' => $time,
                        'end_date' => $end_date,
                        'edit_time' => $time,
                        'sequence' => '2',
                        'slide_status' => 'live',
                        'version' => '1',
                        'options' => '',
                        'url' => '[[~1]]',
                        'title' => 'Slide 2',
                        'description' => 'MODX Revolution Bend it any way you want.',
                        'notes' => 'Test Notes',
                        'html' => '',
                        'upload_time' => $time,
                        'file_path' => 'test_2.jpg',
                        'file_size' => '45',
                        'file_type' => 'jpg',
                    ));
                    if ($slide2->save() == false) {
                        $modx->log(xPDO::LOG_LEVEL_INFO, 'Added example slide 2 to the default My Slideshow album');
                    }
                    $slide3 = $modx->newObject('jgSlideshowSlide');
                    $slide3->fromArray(array(
                        'slideshow_album_id' => $album_id,
                        'web_user_id' => '',
                        'start_date' => $time,
                        'end_date' => $end_date,
                        'edit_time' => $time,
                        'sequence' => '3',
                        'slide_status' => 'live',
                        'version' => '1',
                        'options' => '',
                        'url' => '[[~1]]',
                        'title' => 'Slide 3',
                        'description' => 'MODX Revolution Bend it any way you want.',
                        'notes' => 'Test Notes',
                        'html' => '',
                        'upload_time' => $time,
                        'file_path' => 'test_3.jpg',
                        'file_size' => '45',
                        'file_type' => 'jpg',
                    ));
                    if ($slide3->save() == false) {
                        $modx->log(xPDO::LOG_LEVEL_INFO, 'Added example slide 3 to the default My Slideshow album');
                    }
                    */
                }
                
            }
            break;
        case xPDOTransport::ACTION_UPGRADE:
            // version 1.1 added: 
            $modx->exec("ALTER TABLE {$modx->getTableName('jgSlideshowAlbum')}
                ADD COLUMN `constrain` TINYINT DEFAULT '1' NOT NULL AFTER `file_size_limit`,
                ADD COLUMN `image_instructions` MEDIUMTEXT NULL AFTER `description`,
                ADD COLUMN `advanced_instructions` MEDIUMTEXT NULL AFTER `image_instructions`");
            // added 1.1.2:
            // ALTER TABLE `modx`.`modx_slideshow_slide` ADD INDEX `Search` (`slideshow_album_id`, `start_date`, `end_date`, `slide_status`);
            $modx->exec("ALTER TABLE {$modx->getTableName('jgSlideshowSlide')}
                ADD INDEX `Album` (`slideshow_album_id`),
                ADD INDEX `Search` (`slideshow_album_id`, `start_date`, `end_date`, `slide_status`);
            ");
            break;
    }
}
$modx->log(xPDO::LOG_LEVEL_INFO,'Tables resolver actions completed');

return true;
