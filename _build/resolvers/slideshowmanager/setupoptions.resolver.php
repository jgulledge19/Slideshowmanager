<?php
/**
 * ChurchEvents
 *
 * Copyright 2010-11 by Josh Gulledge <jgulledge19@hotmail.com>
 *
 * This file is part of Quip, a simple commenting component for MODx Revolution.
 *
 * Quip is free software; you can redistribute it and/or modify it under the
 * terms of the GNU General Public License as published by the Free Software
 * Foundation; either version 2 of the License, or (at your option) any later
 * version.
 *
 * Quip is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * Quip; if not, write to the Free Software Foundation, Inc., 59 Temple Place,
 * Suite 330, Boston, MA 02111-1307 USA
 *
 * @package churchevents
 */
/**
 * Resolves setup-options settings by setting email options.
 *
 * @package churchevents
 * @subpackage build
 */
$success= false;
switch ($options[xPDOTransport::PACKAGE_ACTION]) {
    case xPDOTransport::ACTION_INSTALL:
        if ( isset($options['createSample']) && $options['createSample'] ) {
            $modx->log(xPDO::LOG_LEVEL_INFO,'Loading sample data ');
            $modx =& $object->xpdo;
            // add package
            $s_path = $modx->getOption('core_path').'components/slideshowmanager/model/';
            $modx->addPackage('slideshowmanager', $s_path);
            // create a default slideshow:
            $c = $modx->newQuery('jgSlideshowAlbum');
            $c->limit(1,0);
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
                    $modx->log(xPDO::LOG_LEVEL_INFO,'Added default data to table: jgSlideshowAlbum ');
                }
            } else {
                $album = $modx->getObject('jgSlideshowAlbum', $c );
            }
            // add default pictures
            $now = date('Y-m-d 00:00:00');
            $end = date('Y-m-d 00:00:00', (time()+3*52*7*24*3600));// 3 years out
            $panes = array(
                    array(
                        'start_date' => $now,
                        'edit_time' => $now,
                        'end_date' => $end,
                        'sequence' => 1,
                        'title' => 'Slide 1',
                        'description' => 'MODX Revolution Bend it any way you want.',
                        'notes' => 'Notes...',
                        'html' => '',//'HTML',
                        'upload_time' => $now,
                        'file_path' => 'test_1.jpg',
                        'file_type' => 'jpg',
                        'url' => 'http://modx.com',
                        'slide_status' => 'live'
                    ),
                    array(
                        'start_date' => $now,
                        'edit_time' => $now,
                        'end_date' => $end,
                        'sequence' => 2,
                        'title' => 'Slide 2',
                        'description' => 'My slide 2... ',
                        'notes' => 'Notes...',
                        'html' => '<p>Checkout the <a href="http://forums.modx.com/">MODX forums</a></p>',
                        'upload_time' => $now,
                        'file_path' => 'test_2.jpg',
                        'file_type' => 'jpg',
                        'url' => 'http://modx.com',
                        'slide_status' => 'live'
                    ),
                    array(
                        'start_date' => $now,
                        'edit_time' => $now,
                        'end_date' => $end,
                        'sequence' => 3,
                        'title' => 'Slide 3',
                        'description' => 'Have you read the docs yet?',
                        'notes' => 'Notes...',
                        'html' => '',//'HTML',
                        'upload_time' => $now,
                        'file_path' => 'test_3.jpg',
                        'file_type' => 'jpg',
                        'url' => 'http://modx.com',
                        'slide_status' => 'live'
                    ),
                );
            foreach ( $panes as $pane ) {
                $slide = $modx->newObject('jgSlideshowSlide');
                $pane['slideshow_album_id'] = $album->get('id'); 
                $slide->fromArray($pane);
                /* save */
                if ($slide->save() == false) {
                    $modx->log(xPDO::LOG_LEVEL_ERROR,'ERROR adding default slide data to table: jgSlideshowSlide ');
                } else {
                    $modx->log(xPDO::LOG_LEVEL_INFO, 'Added default slide to table: jgSlideshowSlide ');
                }
            }
        }
        $success= true;
        break;
    case xPDOTransport::ACTION_UPGRADE:
        $success= true;
        break;
    case xPDOTransport::ACTION_UNINSTALL:
        $success= true;
        break;
}
return $success;