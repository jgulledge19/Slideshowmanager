<div id="joshua19media_wrapper">
    <h2>{$_lang.slideshowmanager.cmp_title}</h2>
    {* this album_add or edit needs to change *}
    <p>{$_lang.slideshowmanager.album_add}</p>
    
    
    <form class="joshua19media" action="" method="post">
        <ul>
            <li class="full"><label for="txt_title">{if $_frm.title.isError}<span class="spanError"><sup>{$_frm.title.errorNumber}</sup></span>
                {/if}{$_lang.slideshowmanager.label_title}</label> 
                <input name="title" type="text" id="txt_title" value="{$_frm.title.value}" /></li>
                
            <li class="full"><label for="txt_description">
                {if $_frm.description.isError}<span class="spanError"><sup>{$_frm.description.errorNumber}</sup></span>
                {/if}{$_lang.slideshowmanager.label_description}</label> 
                <textarea name="description" type="text" id="txt_description">{$_frm.description.value}</textarea></li>
                
            <li class="full"><p>{$_lang.slideshowmanager.label_file}</p>
                <ul>
                    <li class="spaceRight autoWidth"><input name="file_allowed_jpg" value="jpg, jpeg" type="checkbox" id="ck_file_allowed_jpg" {$_frm.file_allowed_jpg.checked} class="radio" /> 
                        <label for="ck_file_allowed_jpg">
                            {if $_frm.file_allowed_jpg.isError}<span class="spanError"><sup>{$_frm.file_allowed_jpg.errorNumber}</sup></span>
                {/if}jpg, jpeg</label> </li>
                    <li class="spaceRight autoWidth"><input name="file_allowed_png" value="png" type="checkbox" id="ck_file_allowed_png" {$_frm.file_allowed_png.checked} class="radio" /> 
                        <label for="ck_file_allowed_png">
                            {if $_frm.file_allowed_png.isError}<span class="spanError"><sup>{$_frm.file_allowed_png.errorNumber}</sup></span>
                {/if}png</label> </li>
                    <li class="spaceRight autoWidth"><input name="file_allowed_gif" value="gif" type="checkbox" id="ck_file_allowed_gif" {$_frm.file_allowed_gif.checked} class="radio"/> 
                        <label for="ck_file_allowed_gif">
                            {if $_frm.file_allowed_gif.isError}<span class="spanError"><sup>{$_frm.file_allowed_gif.errorNumber}</sup></span>
                {/if}gif</label> </li>
                </ul>
            </li>
            <li class="spaceRight"><label for="txt_file_size_limit">{if $_frm.file_size_limit.isError}<span class="spanError"><sup>{$_frm.file_size_limit.errorNumber}</sup></span>
                {/if}{$_lang.slideshowmanager.label_file_maxsize}</label> 
                <input name="file_size_limit" type="text" id="txt_file_size_limit" value="{$_frm.file_size_limit.value}" /></li>
            
            <li class="spaceRight"><label for="txt_file_width">{if $_frm.file_width.isError}<span class="spanError"><sup>{$_frm.file_width.errorNumber}</sup></span>
                {/if}{$_lang.slideshowmanager.label_file_width}</label> 
                <input name="file_width" type="text" id="txt_file_width" value="{$_frm.file_width.value}" /></li>
                
            <li class="spaceRight"><label for="txt_file_height">{if $_frm.file_height.isError}<span class="spanError"><sup>{$_frm.file_height.errorNumber}</sup></span>
                {/if}{$_lang.slideshowmanager.label_file_height}</label> 
                <input name="file_height" type="text" id="txt_file_height" value="{$_frm.file_height.value}" /></li>
            <li class="clear"><input type="submit" value="{if $edit_me}{$_lang.slideshowmanager.button_edit}{else}{$_lang.slideshowmanager.button_add}{/if}"/></li>
            
        </ul>
        <input type="hidden" name="pfolder" value="album" />
        <input type="hidden" name="album_id" value="{$_frm.id.value}" />
    </form>

</div>
