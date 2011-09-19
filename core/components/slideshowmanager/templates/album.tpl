<div id="slideshowHolder">
    <h2>{$_lang.slideshowmanager.cmp_title}</h2>
    <p><a href="{$_url.album_add}">{$_lang.slideshowmanager.album_add}</a></p>
    <h3>{$_lang.slideshowmanager.manage}</h3>
    {* loop for the avaliabe albums - I don't know how to do this in Smarty so it is in the PHP *}
    <ul id="jgSlideAlbums">
        {$_params.album_loop}
    </ul>

</div>
