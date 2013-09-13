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
 * @package slideshowmanager
 */
/**
 * Default English language translation
 * 
 * @package Slideshow Manager
 * @subpackage lexicon
 * @language en
 */
 
$_lang['slideshowmanager'] = 'Slideshow Manager';
$_lang['slideshowmanager.management'] = 'Slideshow Manager';
$_lang['slideshowmanager.management_desc'] = 'Manage your Slideshows';


$_lang['slideshowmanager.cmp_title'] = 'Slideshow Manager';
$_lang['slideshowmanager.album'] = 'Album';
$_lang['slideshowmanager.album_add'] = 'Add Album';
$_lang['slideshowmanager.album_edit'] = 'Edit Album';
$_lang['slideshowmanager.album_delete'] = 'Delete Album';
$_lang['slideshowmanager.cacheable'] = 'Cacheable';
$_lang['slideshowmanager.category'] = 'Category';
$_lang['slideshowmanager.desc'] = 'Manage slideshows for your website.';
$_lang['slideshowmanager.menu_desc'] = 'Manage your slideshows.';
$_lang['slideshowmanager.manage'] = 'Manage';
$_lang['slideshowmanager.slide_add'] = 'Add Slide';
$_lang['slideshowmanager.slide_edit'] = 'Edit Slide';
$_lang['slideshowmanager.slide_delete'] = 'Delete Slide';
// form elements
/*
$_lang['slideshowmanager.button_add'] = 'Create';
$_lang['slideshowmanager.button_edit'] = 'Save';
$_lang['slideshowmanager.button_delete'] = 'Delete';
$_lang['slideshowmanager.label_file_width'] = 'width in pixels';
$_lang['slideshowmanager.label_album_icon'] = 'Choose an Icon';// not currently used
$_lang['slideshowmanager.label_file'] = 'File types allowed';
$_lang['slideshowmanager.label_file_maxsize'] = 'max file size in kb';
$_lang['slideshowmanager.label_file_width'] = 'width in pixels';
$_lang['slideshowmanager.label_file_height'] = 'height in pixels';
$_lang['slideshowmanager.label_title'] = 'Title';
$_lang['slideshowmanager.label_description'] = 'Description';
*/
// slide only:
/*
$_lang['slideshowmanager.legend_slide_create'] = 'Create a new slide';
$_lang['slideshowmanager.legend_slide_edit'] = 'Edit slide';
$_lang['slideshowmanager.label_url'] = 'URL - link slide to a page';
$_lang['slideshowmanager.label_upload_file'] = 'Choose an image';
$_lang['slideshowmanager.label_start_date'] = 'Start Date';
$_lang['slideshowmanager.label_end_date'] = 'End Date';
$_lang['slideshowmanager.label_sequence'] = 'Slide Sequence';
$_lang['slideshowmanager.label_notes'] = 'Notes';
$_lang['slideshowmanager.label_html'] = 'HTML';
$_lang['slideshowmanager.label_options'] = 'Options'; 
$_lang['slideshowmanager.label_slide_status'] = 'What do you want to do with this slide?';
$_lang['slideshowmanager.label_slide_status_live'] = 'Live/Active';
$_lang['slideshowmanager.label_slide_status_insert'] = 'Insert Slide'; 
$_lang['slideshowmanager.label_slide_status_replace'] = 'Replace Slide';
$_lang['slideshowmanager.label_slide_status_tbd'] = 'TBD'; 
$_lang['slideshowmanager.label_slide_status_archive'] = 'Archive';
$_lang['slideshowmanager.label_slide_status_delete'] = 'Delete';
*/
$_lang['slideshowmanager.slide_sequence'] = 'Sequence';
// slide form tabs:
$_lang['slideshowmanager.slidetab_basic'] = 'Basic Details';
$_lang['slideshowmanager.slidetab_advanced'] = 'Advanced';
$_lang['slideshowmanager.slidetab_image'] = 'Upload Image';
$_lang['slideshowmanager.slidetab_update_image'] = 'Current Image';

// slide sort form
$_lang['slideshowmanager.legend_sort'] = 'Sort';
$_lang['slideshowmanager.label_sort_type_current'] = 'Live/Active';
$_lang['slideshowmanager.label_sort_type_future'] = 'Scheduled';
$_lang['slideshowmanager.label_sort_type_tbd'] = 'TBD';
$_lang['slideshowmanager.label_sort_type_archive'] = 'Archive';
$_lang['slideshowmanager.button_sort'] = 'Sort';

// album form tabs
$_lang['slideshowmanager.albumtab_basic'] = 'Basic Details';
$_lang['slideshowmanager.albumtab_instructions'] = 'Desription/Instructions';
$_lang['slideshowmanager.album_instructions_desc'] = 'Fill in a basic description';
$_lang['slideshowmanager.album_image_instructions'] = 'Fill in instructions for how you want the uploaded images to look or the desired size.';
$_lang['slideshowmanager.album_advanced_instructions'] = 'Fill in instructions for the Advanced tab for the slides if you are using these options.';

// new 7/11/11 - for ExtJs
$_lang['slideshowmanager.album'] = 'Album';
$_lang['slideshowmanager.album_management_desc'] = 'Manage your Albums(Slideshows).  You can have many Albums and each album has many slides.  
You can limit what file types can be uploaded and the size and dimensions the slide image must be.';
$_lang['slideshowmanager.album_search'] = 'Search Albums';
$_lang['slideshowmanager.album_create'] = 'Create an Album';
$_lang['slideshowmanager.album_create_desc'] =
$_lang['slideshowmanager.album_update_desc'] =  'Size limit is in kb, width and height are pixels and Allowed is a comma separated list of file extensions.';
$_lang['slideshowmanager.album_remove'] = 'Remove Album';
$_lang['slideshowmanager.album_remove_confirm'] = 'Are you sure you wish to remove(delete) this Album?';
$_lang['slideshowmanager.album_update'] = 'Update Album';
$_lang['slideshowmanager.album_title'] = 'Title';
$_lang['slideshowmanager.album_description'] = 'Description';
$_lang['slideshowmanager.album_file_size_limit'] = 'Size Limit';
$_lang['slideshowmanager.album_file_allowed'] = 'Allowed';
$_lang['slideshowmanager.album_constrain'] = 'Constrain';
$_lang['slideshowmanager.album_constrain_desc'] = 'Would you like to force(constrain) the image to fit within the width and height?';
$_lang['slideshowmanager.album_file_width'] = 'Width';
$_lang['slideshowmanager.album_file_height'] = 'Height';

// error msgs:
$_lang['slideshowmanager.album_err_required'] = 'Required';
$_lang['slideshowmanager.album_err_save'] = 'Error saving album';
$_lang['slideshowmanager.album_err_notset'] = 'ID not set';
$_lang['slideshowmanager.album_err_notfound'] = 'Not Found';


$_lang['slideshowmanager.slide'] = 'Slides';
$_lang['slideshowmanager.slide_management_desc'] = 'Manage your Slides for the current Album(Slideshow). ';
$_lang['slideshowmanager.slide_search'] = 'Search Slides';
$_lang['slideshowmanager.slide_create'] = 'Create a Slide';
$_lang['slideshowmanager.slide_create_desc'] =  'Size limit is in kb, width and height are pixels and Allowed is a comma separated list of file extensions.';
$_lang['slideshowmanager.slide_update_desc'] =  'Size limit is in kb, width and height are pixels and Allowed is a comma separated list of file extensions.';
$_lang['slideshowmanager.slide_remove'] = 'Remove Slide';
$_lang['slideshowmanager.slide_remove_confirm'] = 'Are you sure you wish to remove(delete) this Slide?';
$_lang['slideshowmanager.slide_update'] = 'Update Slide';
$_lang['slideshowmanager.slide_title'] = 'Title';
$_lang['slideshowmanager.slide_description'] = 'Description';
$_lang['slideshowmanager.slide_html'] = 'HTML';
$_lang['slideshowmanager.slide_notes'] = 'Notes';
$_lang['slideshowmanager.slide_options'] = 'Options';
$_lang['slideshowmanager.slide_version'] = 'Version';
$_lang['slideshowmanager.slide_start_date'] = 'Start Date';
$_lang['slideshowmanager.slide_end_date'] = 'End Date';
$_lang['slideshowmanager.slide_sequence'] = 'Sequence';
$_lang['slideshowmanager.slide_status'] = 'Status';
$_lang['slideshowmanager.slide_upload_time'] = 'Upload time';
$_lang['slideshowmanager.slide_file_path'] = 'Image';
$_lang['slideshowmanager.slide_upload_new_image'] = 'Upload a New Image';
$_lang['slideshowmanager.slide_file_size'] = 'File size';
$_lang['slideshowmanager.slide_file_type'] = 'File ext';
$_lang['slideshowmanager.slide_url'] = 'Url';
// error msgs:
$_lang['slideshowmanager.slide_err_required'] = 'Required';
$_lang['slideshowmanager.slide_err_end_date'] = 'The end date must be greater or equal to the start date.';
$_lang['slideshowmanager.slide_err_save'] = 'Error saving slide';
$_lang['slideshowmanager.slide_err_notset'] = 'ID not set';
$_lang['slideshowmanager.slide_err_notfound'] = 'Not Found';

/*
$_lang['slideshowmanager.action_err_ns'] = 'Please specify an action.';
$_lang['slideshowmanager.and_others'] = 'And [[+count]] others...';
$_lang['slideshowmanager.bulk_actions'] = 'Bulk Actions';
$_lang['slideshowmanager.category_err_ns'] = 'Category not specified.';
$_lang['slideshowmanager.category_err_nf'] = 'Category not found with ID [[+id]]';
$_lang['slideshowmanager.change_authors'] = 'Change Authors';
$_lang['slideshowmanager.change_category'] = 'Change Category';
$_lang['slideshowmanager.change_dates'] = 'Change Dates';
$_lang['slideshowmanager.change_default_tv_values'] = 'Change Default TV Values';
$_lang['slideshowmanager.change_tv_values'] = 'Change TV Values';
$_lang['slideshowmanager.change_parent'] = 'Change Parent';
$_lang['slideshowmanager.change_template'] = 'Change Template';
$_lang['slideshowmanager.createdby'] = 'Created By';
$_lang['slideshowmanager.createdon'] = 'Created On';
$_lang['slideshowmanager.deleted'] = 'Deleted';
$_lang['slideshowmanager.editedby'] = 'Edited By';
$_lang['slideshowmanager.editedon'] = 'Edited On';
$_lang['slideshowmanager.filter_by_template'] = 'Filter by Template';
$_lang['slideshowmanager.hidemenu'] = 'Hidden from Menus';
$_lang['slideshowmanager.intro_msg'] = 'Perform batch actions on Resources here.';
$_lang['slideshowmanager.parent'] = 'Parent';
$_lang['slideshowmanager.parent_err_nf'] = 'Parent not found.';
$_lang['slideshowmanager.parent_err_ns'] = 'Parent not specified.';
$_lang['slideshowmanager.pub_date'] = 'Publish Date';
$_lang['slideshowmanager.published'] = 'Published';
$_lang['slideshowmanager.publishedby'] = 'Published By';
$_lang['slideshowmanager.resources'] = 'Resources';
$_lang['slideshowmanager.resources_affect'] = 'This will affect the following Resources:';
$_lang['slideshowmanager.resources_err_ns'] = 'Please select some Resources to perform that action on.';
$_lang['slideshowmanager.richtext'] = 'Richtext Enabled';
$_lang['slideshowmanager.searchable'] = 'Searchable';
$_lang['slideshowmanager.template'] = 'Template';
$_lang['slideshowmanager.template_err_nf'] = 'Template not found.';
$_lang['slideshowmanager.template_err_ns'] = 'Template not specified.';
$_lang['slideshowmanager.template.tvdefaults.intro_msg'] = 'Set the default values of any Template Variables for this Template. Check which TVs you would like to change.';
$_lang['slideshowmanager.template.tvs.intro_msg'] = 'Sets the values for all Resource Template Variable values for this Template. Check which TVs you would like to change.';
$_lang['slideshowmanager.templates'] = 'Templates';
$_lang['slideshowmanager.templates_err_ns'] = 'Please select some Templates to perform that action on.';
$_lang['slideshowmanager.templates.intro_msg'] = 'Perform batch actions on Templates here.';
$_lang['slideshowmanager.tvs'] = 'Template Variables';
$_lang['slideshowmanager.tvs_err_ns'] = 'No Template Variables specified!';
$_lang['slideshowmanager.toggle'] = 'Toggle';
$_lang['slideshowmanager.uncacheable'] = 'Uncacheable';
$_lang['slideshowmanager.undeleted'] = 'Not Deleted';
$_lang['slideshowmanager.unhidemenu'] = 'Shown in Menus';
$_lang['slideshowmanager.unpub_date'] = 'Unpublish Date';
$_lang['slideshowmanager.unpublished'] = 'Unpublished';
$_lang['slideshowmanager.unrichtext'] = 'Richtext Disabled';
$_lang['slideshowmanager.unsearchable'] = 'Unsearchable';
$_lang['slideshowmanager.user_err_nf'] = 'User not found.';
*/
