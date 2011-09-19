--------------------
slideshowmanager
--------------------
Version: 1.0.0 beta2
Since: July 14th, 2011
Author: Joshua Gulledge <jgulledge19@hotmail.com>
License: GNU GPLv2 (or later at your option)

Slide show manager is a custom manager page and snippet.  This manager allows you to easily schedule 
the content you would like in your slide.  You can also have many slides shows on your site
all managed from the same place.

Install:
1. Install via the MODX Revolution packagemanagment
2. Run the [[installSlideshowManager]] snippet one time, this will create the database tables.
3. Manualy install the CMP:
    See http://rtfm.modx.com/display/revolution20/Custom+Manager+Pages+Tutorial for more help
    a. Create Namespace:  System->Namespace
        Click Create New and then fill exactly for Name: slideshowmanager 
        and for Path: {core_path}components/slideshowmanager/
    b. Create the Action
        System->Actions
        Right-click slideshowmanager from the list of namespaces and select "Create Action Here".
        Controller: controllers/index
        Namespace: yes, use the same namespace: slideshowmanager
        Check Load Headers
        Language Topics: slideshowmanager:default
        Now click save
    c. Create the Menu Object
        Right-Click "Components" and choose "Place Action Here"
        Lexicon Key: slideshowmanager
        Description: slideshowmanager.desc
        Action: slideshowmanager.desc - index
        Save (you can ignore the Icon, Parameters, Handler, and Permissions fields for now)
4. Refresh your browser and you should see Slideshow Manager under the Components menu.
5. Create an album(slideshow) before you can add any slides.


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
         

Thanks for using slideshowmanager!
Josh Gulledge