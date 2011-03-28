<div id="joshua19media_wrapper">
    <h2>{$_lang.slideshow_manager.cmp_title}</h2>
    
    {* Current Album with descriptions *}
    <h3>{$_album.title.value}</h3>
    <p>{$_album.description.value}</p>
    <ul>
        <li>Allowed file types: {$_album.file_allowed.value}</li>
        <li>Max file size: {$_album.file_size_limit.value}kb</li>
        <li>Width: {$_album.file_width.value}px Height: {$_album.file_height.value}px</li>
    </ul>
    
    {* this is upload for a new file *}
    {if $edit_me && !empty($_frm.file_path.value)}
    <img src="{$_myconfig.uploadUrl}{$_frm.file_path.value}" alt="{$_frm.title.value}" /> 
    {/if}
    <form name="form_add" action="?" method="post" class="joshua19media" enctype="multipart/form-data">
        <fieldset>
            <legend>{if $edit_me}{$_lang.slideshow_manager.legend_slide_edit}
                {else}
                {$_lang.slideshow_manager.legend_slide_create}
                {/if}</legend>
            <ul>
                <li class="half spaceRight"><label for="txt_title">{if $_frm.title.isError}<span class="spanError"><sup>{$_frm.title.errorNumber}</sup></span>
                    {/if}{$_lang.slideshow_manager.label_title}</label> 
                    <input name="title" type="text" id="txt_title" value="{$_frm.title.value}" />
                </li>
                <li class="half"><label for="txt_url">{if $_frm.url.isError}<span class="spanError"><sup>{$_frm.url.errorNumber}</sup></span>
                    {/if}{$_lang.slideshow_manager.label_url}</label> 
                    <input name="url" type="text" id="txt_url" value="{$_frm.url.value}" />
                </li>
                
                <li class="spaceRight"><label for="txt_start_date">{if $_frm.start_date.isError}<span class="spanError"><sup>{$_frm.start_date.errorNumber}</sup></span>
                    {/if}{$_lang.slideshow_manager.label_start_date}</label> 
                    <input name="start_date" type="text" id="txt_start_date" value="{$_frm.start_date.value}" />
                </li>
                <li class="spaceRight"><label for="txt_end_date">{if $_frm.end_date.isError}<span class="spanError"><sup>{$_frm.end_date.errorNumber}</sup></span>
                    {/if}{$_lang.slideshow_manager.label_end_date}</label> 
                    <input name="end_date" type="text" id="txt_end_date" value="{$_frm.end_date.value}" />
                </li>
                <li>
                    <label for="txt_upload_file">{if $_frm.upload_file.isError}<span class="spanError"><sup>{$_frm.upload_file.errorNumber}</sup></span>
                    {/if}{$_lang.slideshow_manager.label_upload_file}</label> 
                    <input name="upload_file" type="file" accept="image/jpeg" />
                </li>
                
                
                <li class="clear small spaceRight"><label for="txt_sequence">{if $_frm.sequence.isError}<span class="spanError"><sup>{$_frm.sequence.errorNumber}</sup></span>
                    {/if}{$_lang.slideshow_manager.label_sequence}</label> 
                    <input name="sequence" type="text" id="txt_sequence" value="{$_frm.sequence.value}" />
                </li>
                {* EXample *}
                
            <li class="autoWidth">
                <p>{if $_frm.slide_status.isError}<span class="spanError"><sup>{$_frm.slide_status.errorNumber}</sup></span>
                        {/if}{$_lang.slideshow_manager.label_slide_status}</p>
                {* Radio buttons *}
                <ul>
                {if $edit_me}
                    {* existing slide *}
                    <li class="autoWidth spaceRight">
                        <input name="slide_status" type="radio" value="live" id="rd_live" class="radio" {$_frm.slide_status.radio.live} /> 
                        <label for="rd_live">{$_lang.slideshow_manager.label_slide_status_live}</label>
                    </li>
                    <li class="autoWidth spaceRight">
                        <input name="slide_status" type="radio" value="delete" id="rd_archive" class="radio" {$_frm.slide_status.radio.archive} /> 
                        <label for="rd_archive">{$_lang.slideshow_manager.label_slide_status_archive}</label>
                    </li>
                    <li class="autoWidth spaceRight">
                        <input name="slide_status" type="radio" value="delete" id="rd_delete" class="radio" {$_frm.slide_status.radio.delete} /> 
                        <label for="rd_delete">{$_lang.slideshow_manager.label_slide_status_delete}</label>
                    </li>
                {else}
                    {* new slide *}
                    <li class="autoWidth spaceRight">
                        <input name="slide_status" type="radio" value="insert" id="rd_insert" class="radio" {$_frm.slide_status.radio.insert} /> 
                        <label for="rd_insert">{$_lang.slideshow_manager.label_slide_status_insert}</label>
                    </li>
                    <li class="autoWidth spaceRight">
                        <input name="slide_status" type="radio" value="replace" id="rd_replace" class="radio" {$_frm.slide_status.radio.replace} /> 
                        <label for="rd_replace">{$_lang.slideshow_manager.label_slide_status_replace}</label>
                    </li>
                {/if}
                    <li class="autoWidth">
                        <input name="slide_status" type="radio" value="tbd" id="rd_tbd" class="radio" {$_frm.slide_status.radio.tbd} /> 
                        <label for="rd_tbd">{$_lang.slideshow_manager.label_slide_status_tbd}</label>
                    </li>
                </ul>
            </li>
                <li class="medium spaceRight clear"><label for="txt_description">
                    {if $_frm.description.isError}<span class="spanError"><sup>{$_frm.description.errorNumber}</sup></span>
                    {/if}{$_lang.slideshow_manager.label_description}</label> 
                    <textarea name="description" type="text" id="txt_description">{$_frm.description.value}</textarea>
                </li>
                <li><label for="txt_notes">
                    {if $_frm.notes.isError}<span class="spanError"><sup>{$_frm.notes.errorNumber}</sup></span>
                    {/if}{$_lang.slideshow_manager.label_notes}</label> 
                    <textarea name="notes" type="text" id="txt_notes">{$_frm.notes.value}</textarea>
                </li>
                
                <li class="medium spaceRight"><label for="txt_html">
                    {if $_frm.html.isError}<span class="spanError"><sup>{$_frm.html.errorNumber}</sup></span>
                    {/if}{$_lang.slideshow_manager.label_html}</label> 
                    <textarea name="html" type="text" id="txt_html">{$_frm.html.value}</textarea>
                </li>
                <li><label for="txt_options">
                    {if $_frm.options.isError}<span class="spanError"><sup>{$_frm.options.errorNumber}</sup></span>
                    {/if}{$_lang.slideshow_manager.label_options}</label> 
                    <textarea name="options" type="text" id="txt_options">{$_frm.options.value}</textarea>
                </li>
                
                <li class="medium clear" style="width:120px;">
                    <div class="jgbuttons">
                        <button type="submit" class="positive" name="save_file">
                            <img src="{$_myconfig.imagesUrl}check.gif" alt="save" /> {if $edit_me}
                                {$_lang.slideshow_manager.button_edit}
                            {else}
                                {$_lang.slideshow_manager.button_add}
                            {/if} </button>
                    </div>
                </li>            
            </ul>
            
            <input name="a" type="hidden" value="{$a}"  />
            {if $edit_me}
            <input name="action" type="hidden" value="editslide"  />
            <input name="slide_id" type="hidden" value="{$_frm.id.value}"  />
            {else}
            <input name="action" type="hidden" value="addslide"  />
            {/if}
            <input name="pfolder" type="hidden" value="slide" />
            <input name="album_id" type="hidden" value="{$_album.id.value}"  />

            
        </fieldset>
    </form>

</div>
