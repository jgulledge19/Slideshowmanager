<?php
/**
 * Slideshow Manager
 *
 * Copyright 2011 by Joshua Gulledge <jgulledge19@hotmail.com>
 *
 * This file is part of Slideshow Manager, a batch resource editing Extra.
 *
 * Slideshow Manager is free software; you can redistribute it and/or modify it under the
 * terms of the GNU General Public License as published by the Free Software
 * Foundation; either version 2 of the License, or (at your option) any later
 * version.
 *
 * Slideshow Manager is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * Slideshow Manager; if not, write to the Free Software Foundation, Inc., 59 Temple
 * Place, Suite 330, Boston, MA 02111-1307 USA
 *
 * @package slideshow_manager
 */
/**
 * Default English language translation
 * 
 * @package Slideshow Manager
 * @subpackage lexicon
 * @language en
 */
$_lang['slideshow_manager'] = 'Slideshow Manager';
$_lang['slideshow_manager.cmp_title'] = 'Slideshow Manager';
$_lang['slideshow_manager.album'] = 'Album';
$_lang['slideshow_manager.album_add'] = 'Add Album';
$_lang['slideshow_manager.album_edit'] = 'Edit Album';
$_lang['slideshow_manager.album_delete'] = 'Delete Album';
$_lang['slideshow_manager.cacheable'] = 'Cacheable';
$_lang['slideshow_manager.category'] = 'Category';
$_lang['slideshow_manager.desc'] = 'Manage slideshows for your website.';
$_lang['slideshow_manager.menu_desc'] = 'Manage your slideshows.';
$_lang['slideshow_manager.manage'] = 'Manage';
$_lang['slideshow_manager.slide_add'] = 'Add Slide';
$_lang['slideshow_manager.slide_edit'] = 'Edit Slide';
$_lang['slideshow_manager.slide_delete'] = 'Delete Slide';
// form elements
$_lang['slideshow_manager.button_add'] = 'Create';
$_lang['slideshow_manager.button_edit'] = 'Save';
$_lang['slideshow_manager.button_delete'] = 'Delete';
$_lang['slideshow_manager.label_file_width'] = 'width in pixels';
$_lang['slideshow_manager.label_album_icon'] = 'Choose an Icon';// not currently used
$_lang['slideshow_manager.label_file'] = 'File types allowed';
$_lang['slideshow_manager.label_file_maxsize'] = 'max file size in kb';
$_lang['slideshow_manager.label_file_width'] = 'width in pixels';
$_lang['slideshow_manager.label_file_height'] = 'height in pixels';
$_lang['slideshow_manager.label_title'] = 'Title';
$_lang['slideshow_manager.label_description'] = 'Description';
// slide only:
$_lang['slideshow_manager.legend_slide_create'] = 'Create a new slide';
$_lang['slideshow_manager.legend_slide_edit'] = 'Edit slide';
$_lang['slideshow_manager.label_url'] = 'URL - link slide to a page';
$_lang['slideshow_manager.label_upload_file'] = 'Choose an image';
$_lang['slideshow_manager.label_start_date'] = 'Start Date';
$_lang['slideshow_manager.label_end_date'] = 'End Date';
$_lang['slideshow_manager.label_sequence'] = 'Slide Sequence';
$_lang['slideshow_manager.label_notes'] = 'Notes';
$_lang['slideshow_manager.label_html'] = 'HTML';
$_lang['slideshow_manager.label_options'] = 'Options'; 
$_lang['slideshow_manager.label_slide_status'] = 'What do you want to do with this slide?';
$_lang['slideshow_manager.label_slide_status_live'] = 'Live/Active';
$_lang['slideshow_manager.label_slide_status_insert'] = 'Insert Slide'; 
$_lang['slideshow_manager.label_slide_status_replace'] = 'Replace Slide';
$_lang['slideshow_manager.label_slide_status_tbd'] = 'TBD'; 
$_lang['slideshow_manager.label_slide_status_archive'] = 'Archive';
$_lang['slideshow_manager.label_slide_status_delete'] = 'Delete';
$_lang['slideshow_manager.slide_sequence'] = 'Sequence';
// slide sort form
$_lang['slideshow_manager.legend_sort'] = 'Sort';
$_lang['slideshow_manager.label_sort_type_current'] = 'Live/Active';
$_lang['slideshow_manager.label_sort_type_future'] = 'Scheduled';
$_lang['slideshow_manager.label_sort_type_tbd'] = 'TBD';
$_lang['slideshow_manager.label_sort_type_archive'] = 'Archive';
$_lang['slideshow_manager.button_sort'] = 'Sort';


/*
$_lang['slideshow_manager.action_err_ns'] = 'Please specify an action.';
$_lang['slideshow_manager.and_others'] = 'And [[+count]] others...';
$_lang['slideshow_manager.bulk_actions'] = 'Bulk Actions';
$_lang['slideshow_manager.category_err_ns'] = 'Category not specified.';
$_lang['slideshow_manager.category_err_nf'] = 'Category not found with ID [[+id]]';
$_lang['slideshow_manager.change_authors'] = 'Change Authors';
$_lang['slideshow_manager.change_category'] = 'Change Category';
$_lang['slideshow_manager.change_dates'] = 'Change Dates';
$_lang['slideshow_manager.change_default_tv_values'] = 'Change Default TV Values';
$_lang['slideshow_manager.change_tv_values'] = 'Change TV Values';
$_lang['slideshow_manager.change_parent'] = 'Change Parent';
$_lang['slideshow_manager.change_template'] = 'Change Template';
$_lang['slideshow_manager.createdby'] = 'Created By';
$_lang['slideshow_manager.createdon'] = 'Created On';
$_lang['slideshow_manager.deleted'] = 'Deleted';
$_lang['slideshow_manager.editedby'] = 'Edited By';
$_lang['slideshow_manager.editedon'] = 'Edited On';
$_lang['slideshow_manager.filter_by_template'] = 'Filter by Template';
$_lang['slideshow_manager.hidemenu'] = 'Hidden from Menus';
$_lang['slideshow_manager.intro_msg'] = 'Perform batch actions on Resources here.';
$_lang['slideshow_manager.parent'] = 'Parent';
$_lang['slideshow_manager.parent_err_nf'] = 'Parent not found.';
$_lang['slideshow_manager.parent_err_ns'] = 'Parent not specified.';
$_lang['slideshow_manager.pub_date'] = 'Publish Date';
$_lang['slideshow_manager.published'] = 'Published';
$_lang['slideshow_manager.publishedby'] = 'Published By';
$_lang['slideshow_manager.resources'] = 'Resources';
$_lang['slideshow_manager.resources_affect'] = 'This will affect the following Resources:';
$_lang['slideshow_manager.resources_err_ns'] = 'Please select some Resources to perform that action on.';
$_lang['slideshow_manager.richtext'] = 'Richtext Enabled';
$_lang['slideshow_manager.searchable'] = 'Searchable';
$_lang['slideshow_manager.template'] = 'Template';
$_lang['slideshow_manager.template_err_nf'] = 'Template not found.';
$_lang['slideshow_manager.template_err_ns'] = 'Template not specified.';
$_lang['slideshow_manager.template.tvdefaults.intro_msg'] = 'Set the default values of any Template Variables for this Template. Check which TVs you would like to change.';
$_lang['slideshow_manager.template.tvs.intro_msg'] = 'Sets the values for all Resource Template Variable values for this Template. Check which TVs you would like to change.';
$_lang['slideshow_manager.templates'] = 'Templates';
$_lang['slideshow_manager.templates_err_ns'] = 'Please select some Templates to perform that action on.';
$_lang['slideshow_manager.templates.intro_msg'] = 'Perform batch actions on Templates here.';
$_lang['slideshow_manager.tvs'] = 'Template Variables';
$_lang['slideshow_manager.tvs_err_ns'] = 'No Template Variables specified!';
$_lang['slideshow_manager.toggle'] = 'Toggle';
$_lang['slideshow_manager.uncacheable'] = 'Uncacheable';
$_lang['slideshow_manager.undeleted'] = 'Not Deleted';
$_lang['slideshow_manager.unhidemenu'] = 'Shown in Menus';
$_lang['slideshow_manager.unpub_date'] = 'Unpublish Date';
$_lang['slideshow_manager.unpublished'] = 'Unpublished';
$_lang['slideshow_manager.unrichtext'] = 'Richtext Disabled';
$_lang['slideshow_manager.unsearchable'] = 'Unsearchable';
$_lang['slideshow_manager.user_err_nf'] = 'User not found.';
*/
