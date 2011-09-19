<div id="joshua19media_wrapper">
    <h2>{$_lang.slideshowmanager.cmp_title}</h2>
    
    {* Current Album with descriptions *}
    <h3>{$_album.title.value}</h3>
    <p>{$_album.description.value}</p>
    <ul>
        <li>Allowed file types: {$_album.file_allowed.value}</li>
        <li>Max file size: {$_album.file_size_limit.value}kb</li>
        <li>Width: {$_album.file_width.value}px Height: {$_album.file_height.value}px</li>
    </ul>
    <p><a href="{$_url.slide_add}">{$_lang.slideshowmanager.slide_add}</a></p>
    
    {* Have a sort function Current list, Scheduled List, Archive (TBD?) *}
    
    <form name="toolbar" action="?" method="get" class="joshua19media" >
        <input name="a" type="hidden" value="{$a}"  />
        <input name="action" type="hidden" value="slides" />
        <input name="album_id" type="hidden" value="{$_album.id.value}" />
        
        <fieldset>
            <legend>{$_lang.slideshowmanager.legend_sort}</legend>
            <ul>
                <li class="autoWidth">
                    <input name="sort_type" type="radio" value="current" id="rd_current" {$_frmSort.sort_type.radio.current} class="radio" /> 
                    <label for="rd_current">{$_lang.slideshowmanager.label_sort_type_current}</label>
                </li>
                <li class="autoWidth spaceRight">
                    <input name="sort_type" type="radio" value="future" id="rd_future" {$_frmSort.sort_type.radio.future} class="radio" /> 
                    <label for="rd_future">{$_lang.slideshowmanager.label_sort_type_future}</label>
                </li>
                <li class="autoWidth spaceRight">
                    <input name="sort_type" type="radio" value="tbd" id="rd_tbd" {$_frmSort.sort_type.radio.tbd} class="radio" /> 
                    <label for="rd_tbd">{$_lang.slideshowmanager.label_sort_type_tbd}</label>
                </li>
                <li class="autoWidth spaceRight">
                    <input name="sort_type" type="radio" value="archive" id="rd_archive" {$_frmSort.sort_type.radio.archive} class="radio" /> 
                    <label for="rd_archive">{$_lang.slideshowmanager.label_sort_type_archive}</label>
                </li>
                <li class="autoWidth">
                    <div class="jgbuttons">
                        <button type="submit"> {$_lang.slideshowmanager.button_sort} </button>
                    </div>
                </li>
            </ul>
        </fieldset>
    </form>

    {* now the list of slides - only form element is sequence *}
    
    
    {* Current list - loop *}
    {* loop for the avaliabe albums - I don't know how to do this in Smarty so it is in the PHP *}
    <form class="joshua19media" action="" method="post">
        <ol id="jgSlides">
            {$_params.slide_loop}
        </ol>
        
        <input name="a" type="hidden" value="{$a}"  />
        <input name="action" type="hidden" value="slides" />
        <input name="album_id" type="hidden" value="{$_album.id.value}" />
        <input name="pfolder" type="hidden" value="slide" />
        <input name="sort_type" type="hidden" value="{$_frmSort.sort_type.value}" />
    </form>
        
</div>
