<?php
/**
 * MyComponent transport chunks
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
 * Description: Array of chunk objects for MyComponent package
 * @package mycomponent
 * @subpackage build
 */

$chunks = array();
$x=0;
$chunks[++$x]= $modx->newObject('modChunk');
$chunks[$x]->fromArray(array(
    'id' => $x,
    'name' => 'nivo_headTpl',
    'description' => 'Contians JS & CSS for Slideshow',
    'snippet' => file_get_contents($sources['source_core'].'/elements/chunks/nivo/nivo_headTpl.html'),
    'properties' => '',
),'',true,true);
            
$chunks[++$x]= $modx->newObject('modChunk');
$chunks[$x]->fromArray(array(
    'id' => $x,
    'name' => 'nivo_htmlCaptionTpl',
    'description' => 'HTML Caption Option',
    'snippet' => file_get_contents($sources['source_core'].'/elements/chunks/nivo/nivo_htmlCaptionTpl.html'),
    'properties' => '',
),'',true,true);
            
$chunks[++$x]= $modx->newObject('modChunk');
$chunks[$x]->fromArray(array(
    'id' => $x,
    'name' => 'nivo_slideHolderTpl',
    'description' => 'The holder for the slide panes',
    'snippet' => file_get_contents($sources['source_core'].'/elements/chunks/nivo/nivo_slideHolderTpl.html'),
    'properties' => '',
),'',true,true);
            
$chunks[++$x]= $modx->newObject('modChunk');
$chunks[$x]->fromArray(array(
    'id' => $x,
    'name' => 'nivo_slideLinkTpl',
    'description' => 'A slide pane wrapped in an archor',
    'snippet' => file_get_contents($sources['source_core'].'/elements/chunks/nivo/nivo_slideLinkTpl.html'),
    'properties' => '',
),'',true,true);
            
$chunks[++$x]= $modx->newObject('modChunk');
$chunks[$x]->fromArray(array(
    'id' => $x,
    'name' => 'nivo_slidePaneTpl',
    'description' => 'The actual pane or image',
    'snippet' => file_get_contents($sources['source_core'].'/elements/chunks/nivo/nivo_slidePaneTpl.html'),
    'properties' => '',
),'',true,true);

            

return $chunks;