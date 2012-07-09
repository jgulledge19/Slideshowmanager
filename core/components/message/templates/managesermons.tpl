<script>
    //set local blank image
//Ext.BLANK_IMAGE_URL = 'ext/resources/images/default/s.gif';
//define function to be executed when page loaded
Ext.onReady(function() {
    // start date calendar
    var openButtonID = 'txt_sermon_date';
    var calendarHolderID = 'ext_sermon_date';
    //define select handler
    var selectHandler = function(myDP, date) {
        //get the text field
        var field = document.getElementById('txt_sermon_date');
        //add the selected date to the field
        field.value = date.format('m/d/Y');
        //hide the date picker
        myDP.hide();
    };
    
    //create the date picker
    var myDP = new Ext.DatePicker({
        startDay: 1,
        listeners: {
            'select':selectHandler
        }
    });
    
    //render the date picker
    myDP.render(calendarHolderID);
    //hide date picker straight away
    myDP.hide();
    
    //define click handler
    var clickHandler = function() {
        //show the date picker
        myDP.show();
    };
    //add listener for button click
    Ext.EventManager.on(openButtonID, 'click', clickHandler);
});

</script>
<div id="joshua19media_wrapper">
    <h2>{$_lang.slideshowmanager.cmp_title}</h2>
    
    {* Current Album with descriptions *}
    <h3>Chapel Service/Sermon</h3>
    <p>{$_sermon.description.value}</p>
    <ul>
        <li>Allowed file types: .mp3, .flv, .wmv, .mov </li>
        <li>Max file size: 100mb</li>
    </ul>
    
    <form name="form_add" action="?" method="post" class="joshua19media" enctype="multipart/form-data">
        <fieldset>
            <legend>{if $edit_me}{$_lang.message.legend_sermon_edit}
                {else}
                {$_lang.message.legend_sermon_create}
                {/if}</legend>
            
            {* group_id create_date sermon_date title speaker description tags active *}
            
            <ul>
                <li class="half spaceRight"><label for="txt_title">{if $_frm.title.isError}<span class="spanError"><sup>{$_frm.title.errorNumber}</sup></span>
                    {/if}{$_lang.message.label_title}</label> 
                    <input name="title" type="text" id="txt_title" value="{$_frm.title.value}" />
                </li>
                <li class="half"><label for="txt_speaker">{if $_frm.speaker.isError}<span class="spanError"><sup>{$_frm.speaker.errorNumber}</sup></span>
                    {/if}{$_lang.message.label_speaker}</label> 
                    <input name="speaker" type="text" id="txt_speaker" value="{$_frm.speaker.value}" />
                </li>
                
                <li class="full clear"><label for="txt_description">
                    {if $_frm.description.isError}<span class="spanError"><sup>{$_frm.description.errorNumber}</sup></span>
                    {/if}{$_lang.message.label_description}</label> 
                    <textarea name="description" type="text" id="txt_description">{$_frm.description.value}</textarea>
                </li>
                
                
                <li class="half spaceRight"><label for="txt_tags">{if $_frm.tags.isError}<span class="spanError"><sup>{$_frm.tags.errorNumber}</sup></span>
                    {/if}{$_lang.message.label_tags}</label> 
                    <input name="tags" type="text" id="txt_tags" value="{$_frm.tags.value}" />
                </li>
                <li class="spaceRight"><label for="txt_sermon_date">{if $_frm.sermon_date.isError}<span class="spanError"><sup>{$_frm.sermon_date.errorNumber}</sup></span>
                    {/if}{$_lang.message.label_sermon_date}</label> 
                    <input name="sermon_date" type="text" id="txt_sermon_date" value="{$_frm.sermon_date.value}" />
                    <div id="ext_sermon_date"></div>
                </li>
                
                <li>
                    <label for="txt_upload_audio">{if $_frm.upload_audio.isError}<span class="spanError"><sup>{$_frm.upload_audio.errorNumber}</sup></span>
                    {/if}{$_lang.message.label_upload_audio}</label> 
                    <input name="upload_audio" type="file" />
                </li>
                <li>
                    <label for="txt_upload_video">{if $_frm.upload_video.isError}<span class="spanError"><sup>{$_frm.upload_video.errorNumber}</sup></span>
                    {/if}{$_lang.message.label_upload_video}</label> 
                    <input name="upload_video" type="file" />
                </li>
                
                {* EXample *}
                
            <li class="autoWidth">
                <p>{if $_frm.active.isError}<span class="spanError"><sup>{$_frm.active.errorNumber}</sup></span>
                        {/if}{$_lang.message.label_active}</p>
                {* Radio buttons *}
                <ul>
                    <li class="autoWidth spaceRight">
                        <input name="active" type="radio" value="Yes" id="rd_insert" class="radio" {$_frm.active.radio.Yes} /> 
                        <label for="rd_insert">Yes</label>
                    </li>
                    <li class="autoWidth spaceRight">
                        <input name="active" type="radio" value="No" id="rd_replace" class="radio" {$_frm.active.radio.No} /> 
                        <label for="rd_replace">No</label>
                    </li>
                </ul>
            </li>
            
                <li class="medium clear" style="width:120px;">
                    <div class="jgbuttons">
                        <button type="submit" class="positive" name="save_file">
                            <img src="{$_myconfig.imagesUrl}check.gif" alt="save" /> {if $edit_me}
                                {$_lang.message.button_edit}
                            {else}
                                {$_lang.message.button_add}
                            {/if} </button>
                    </div>
                </li>            
            </ul>
            
            <input name="a" type="hidden" value="{$a}"  />
            {if $edit_me}
            <input name="action" type="hidden" value="editsermon"  />
            <input name="sermon_id" type="hidden" value="{$_frm.id.value}"  />
            <input name="file_path" type="hidden" value="{$_frm.file_path.value}" />
            {else}
            <input name="action" type="hidden" value="addsermon"  />
            {/if}
            <input name="pfolder" type="hidden" value="sermon" />
            <input name="group_id" type="hidden" value="{$_group.id.value}"  />

            
        </fieldset>
    </form>

</div>
