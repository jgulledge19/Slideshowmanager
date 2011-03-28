--------------------
Slideshow-Manager
--------------------
Version: 1.0.0 alpha
Since: March 28th, 2011
Author: Joshua Gulledge <jgulledge19@hotmail.com>
License: GNU GPLv2 (or later at your option)

Slide show manager is a custom manager page and snippet.  This manager allows you to easily schedule 
the content you would like in your slide.  You can also have many slides shows on your site
all managed from the same place.  Not all features are working in this alpha version but the snippet works.

Usage:
basic options creating a slide show
<div id="slider-wrapper">
    [[!jgSlideShow]]
</div>

Default slideshow is a JQuery slider NIVO: http://nivo.dev7studios.com/#usage

Options:
    album_id - defaults to 1
    slide_div_id - this is the ID for the slide holder defaults to slides
    skin - you can copy all of the default TPLs below and simply change the prefix 
        from "nivo_" to "myskin_" and then you only need to referance the skin to 
        make a change rather then list every one out.  Defaults to: nivo_ 
    TPLs - these are the HTML chunks
        nivo_headTpl - this has all JS and CSS 
        nivo_htmlCaption - this would be the created HTML Captions
        nivo_slideHolderTpl - basically a div that holds the slide panes
        nivo_slideLinkTpl - this is a slide pane that called on when the URL option is filled for the pane
        nivo_slidePaneTpl - this is the base slide pane and is only called when the URL is empty for the slide pane
        
    Placeholder options that can be used:
    - all:
        slide_div_id
    - for only headTpl:
        count - the total number of slides
        id - the album id
        title - the album title
        description - the album description
        file_allowed
        file_size_limit - the 
        file_width - the width of the slide show images
        file_height - the height of the slide show images
    - for remainer TPLs:
         src - the full image URL
         id - the db id
         slideshow_album_id
         web_user_id - the user the last updated this slide
         start_date - the date the slide went live
         end_date - the last date the slide will be shown 
         edit_time 
         sequence
         slide_status
         version - how many times it has been edited
         options
         url
         title
         description
         notes
         html
         upload_time - the time the image was uploaded
         file_path - just the image name
         file_size - this is not working 
         file_type 
         

Thanks for using Slideshow-Manager!
Josh Gulledge