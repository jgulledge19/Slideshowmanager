/* make a local <select>/combo box */

Cmp.combo.SlideStatusCreate = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        store: ['Insert','Replace'/*,'future'*/,'TBD']
        ,mode: 'local'
        ,editable: false
        
    });
    Cmp.combo.SlideStatusCreate.superclass.constructor.call(this,config);
};
//Ext.extend(MODx.combo.SlideStatus, MODx.combo.ComboBox);
Ext.extend(Cmp.combo.SlideStatusCreate,MODx.combo.ComboBox);
Ext.reg('slidestatus-create-combo', Cmp.combo.SlideStatusCreate);
/* */
Cmp.combo.SlideStatus = function(config) {
    config = config || {};
    Ext.applyIf(config,{
       //displayField: 'name'
        //,valueField: 'id'
        //,fields: ['id', 'name']
        store: ['live',/*'replace','future',*/'archive','deleted','tbd']
        //,url: Testapp.config.connectorUrl
        ,baseParams: { action: '' ,combo: true }
        //,mode: 'local'
        ,editable: false
    });
    Cmp.combo.SlideStatus.superclass.constructor.call(this,config);
};
//Ext.extend(MODx.combo.SlideStatus, MODx.combo.ComboBox);
Ext.extend(Cmp.combo.SlideStatus,MODx.combo.ComboBox);
Ext.reg('slidestatus-combo', Cmp.combo.SlideStatus);


// the album filter
Cmp.combo.SlideAlbum = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        displayField: 'title'
        ,valueField: 'id'
        ,value: cmpAlbumId
        ,fields: ['id', 'title']
        //store: ['live',/*'replace','future',*/'archive','deleted','tbd']
        //,url: Testapp.config.connectorUrl
        ,url: Cmp.config.connectorUrl
        ,baseParams: { action: 'mgr/album/getList',combo: true }
        //,mode: 'local'
        ,editable: false
        ,cls: 'x-window-with-tabs'
    });
    Cmp.combo.SlideAlbum.superclass.constructor.call(this,config);
};
//Ext.extend(MODx.combo.SlideStatus, MODx.combo.ComboBox);
Ext.extend(Cmp.combo.SlideAlbum,MODx.combo.ComboBox);
Ext.reg('slideshow-combo-album', Cmp.combo.SlideAlbum);

// the slide filter
Cmp.combo.SlideFilter = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        //displayField: 'name'
        //,valueField: 'id'
        //,fields: ['id', 'name']
        value: 'current'
        ,store: ['current', 'future', 'archive', 'tbd']
        //,url: Testapp.config.connectorUrl
        ,baseParams: { action: '' ,combo: true }
        //,mode: 'local'
        ,editable: false
    });
    Cmp.combo.SlideFilter.superclass.constructor.call(this,config);
};
//Ext.extend(MODx.combo.SlideStatus, MODx.combo.ComboBox);
Ext.extend(Cmp.combo.SlideFilter,MODx.combo.ComboBox);
Ext.reg('slidestatus-combo-filter', Cmp.combo.SlideFilter);

/* YOU will need to edit this file with proper names, follow the cases(upper/lower) */
Cmp.grid.slide= function(config) {
    config = config || {};
    Ext.applyIf(config,{
        id: 'cmp-grid-slide'
        ,url: Cmp.config.connectorUrl
        ,baseParams: { 
            action: 'mgr/slide/getlist'
            ,slideshow_album_id: cmpAlbumId }
        ,save_action: 'mgr/slide/updateFromGrid'
        ,fields: ['id','slideshow_album_id', 'web_user_id', 'start_date', 'end_date', 
                'sequence', 'slide_status', 'version', 'options',/* 'resource_id', */ 'url',
                'title', 'description', 'notes','html','upload_time','file_path','image_path', 'file_size', 'file_type', 'album_description', 'album_file_width', 'album_file_height' ]
        ,paging: true
        ,autosave: true
        ,remoteSort: true
        ,anchor: '97%'
        ,autoExpandColumn: 'description'
        ,columns: [/*{
            header: _('id')
            ,dataIndex: 'id'
            ,sortable: true
            ,width: 10
        },*/{
            header: _('slideshowmanager.slide_sequence')
            ,dataIndex: 'sequence'
            ,sortable: true
            ,align: 'right'
            ,width: 20
            ,editor: { xtype: 'textfield' }
        },{
            header: _('slideshowmanager.slide_title')
            ,dataIndex: 'title'
            ,maxLength: 100
            ,sortable: true
            ,width: 45
            ,editor: { xtype: 'textfield' }
        },{
            header: _('slideshowmanager.slide_description')
            ,dataIndex: 'description'
            ,sortable: false
            ,width: 65 
            ,editor: { xtype: 'textarea' }
        },{
            header: _('slideshowmanager.slide_file_path')
            //,tpl: this.templates.thumb
            ,renderer: function(value, cell) {
                return '<img id="myImage" src="'+Cmp.config.uploadUrl+value+'" height="100" />';
            }
            ,dataIndex: 'image_path'
            ,sortable: false
            ,width: 85 
            //,editor: { xtype: 'displayfield' }
        },{
            header: _('slideshowmanager.slide_start_date')
            ,dataIndex: 'start_date'
            ,sortable: true
            ,width: 60
            //,editor: { xtype: 'textfield' }
            // http://forums.modx.com/thread/74194/extjs-tips#dis-post-411595
            // http://jacwright.com/projects/javascript/date_format/
            ,format: MODx.config.manager_date_format
            ,dateFormat: MODx.config.manager_date_format
            ,renderer : Ext.util.Format.dateRenderer(MODx.config.manager_date_format)
            ,editor: { 
                xtype: 'datefield'
                ,format: MODx.config.manager_date_format
            } // datefield
            ,xtype: 'datecolumn'
            /*
            //,name: 'post_date'
            ,hiddenName: 'post_date'
            ,anchor: '90%'
            ,dateFormat: MODx.config.manager_date_format
            ,timeFormat: MODx.config.manager_time_format
            ,dateWidth: 120
            ,timeWidth: 120*/
        },{
            header: _('slideshowmanager.slide_end_date')
            ,dataIndex: 'end_date'
            ,sortable: true
            ,width: 60
            ,format: MODx.config.manager_date_format
            ,dateFormat: MODx.config.manager_date_format
            ,renderer : Ext.util.Format.dateRenderer(MODx.config.manager_date_format)
            ,editor: { 
                xtype: 'datefield'
                ,format: MODx.config.manager_date_format
            } // datefield
            ,xtype: 'datecolumn'
        },{
            header: _('slideshowmanager.slide_status')
            ,dataIndex: 'slide_status'
            ,sortable: false
            ,width: 20
            ,editor: { xtype: 'slidestatus-combo', renderer: 'value' }// 'textfield' } 
        },{
            header: _('slideshowmanager.slide_url')
            ,dataIndex: 'url'
            ,sortable: true
            ,width: 60
            ,editor: { xtype: 'textfield' }
        },{
            //header: _('slideshowmanager.album_description')
            dataIndex: 'album_description'
            //,id: 'album_description'
            ,sortable: false
            ,width: 20
            ,hidden: true
        },{
            //header: _('slideshowmanager.album_description')
            dataIndex: 'album_file_width'
            //,id: 'album_description'
            ,sortable: false
            ,width: 20
            ,hidden: true
        },{
            //header: _('slideshowmanager.album_description')
            dataIndex: 'album_file_height'
            //,id: 'album_description'
            ,sortable: false
            ,width: 20
            ,hidden: true
        }]
        ,tbar: [{
            xtype: 'slideshow-combo-album'
            ,name: 'slideshow_album_id'
            ,id: 'slideshow-album-filter'
            //,emptyText: _('batcher.filter_by_template')
            ,width: 250
            ,allowBlank: false
            ,listeners: {
                'select': {fn:this.filterAlbums,scope:this}
            }
        },{
            xtype: 'slidestatus-combo-filter'
            ,name: 'sort_type'
            ,id: 'slideshow-status-filter'
            //,emptyText: _('batcher.filter_by_template')
            ,width: 100
            ,allowBlank: false
            ,listeners: {
                'select': {fn:this.filterSlides,scope:this}
            }
            
        },/*{
            xtype: 'textfield'
            ,id: 'cmp-slide-search-filter'
            ,emptyText: _('slideshowmanager.slide_search')
            ,listeners: {
                'change': {fn:this.search,scope:this}
                ,'render': {fn: function(cmp) {
                    new Ext.KeyMap(cmp.getEl(), {
                        key: Ext.EventObject.ENTER
                        ,fn: function() {
                            this.fireEvent('change',this);
                            this.blur();
                            return true;
                        }
                        ,scope: cmp
                    });
                },scope:this}
            }
        },*/{
            text: _('slideshowmanager.slide_create')
            ,handler: this.createSlide //{ xtype: 'cmp-window-slide-create' ,blankValues: true }
            /*,renderer: function(value, cell) {
                url = '?a='+MODx.request.a+'&action=addslide'+'&album_id='+this.menu.record.slideshow_album_id;
                return '<a href="'+url+'">' + _('slideshowmanager.slide_create') + '</a>';
            }*/
            /*,handler: this.addSlide { xtype: 'cmp-window-slide-create' ,blankValues: true }*/
        }]
    });
    Cmp.grid.slide.superclass.constructor.call(this,config);
};
var mySlideUrl = '';
var gotAlbum = 0;
var albumData = {};
var slideToday = '';
var slideEnd = '';
/**
 * @param (Date Object) myDate
 * @return (String) date  
 */
function makeFullDate(myDate) {
    var mon = myDate.getMonth()+1;
    if ( mon < 10 ) {
        mon = '0' + mon;
    }
    var day = myDate.getDate();
    if ( day < 10 ) {
        day = '0' + day;
    }
    // Ext.util.Format.dateRenderer(MODx.config.manager_date_format)
    //var iso_date = Date.parseDate("2008-01-11 22:00:00", "Y-m-d H:i:s");
    return myDate.format(MODx.config.manager_date_format);
    //return myDate.getFullYear() + '-' + mon + '-' + day;
}

Ext.onReady(function(){
    // set the default date values for the create calendar
    var tmpToday = new Date();
    slideToday = makeFullDate(tmpToday);//tmpToday.getFullYear() + '-' + (tmpToday.getMonth()+1) + '-' + tmpToday.getDate();
    
    var tmpTime = Date.parse(tmpToday.toString());
    tmpTime = tmpTime*1 + 30*3600*24*1000;
    
    var tmpEnd = new Date(tmpTime);
    slideEnd = makeFullDate(tmpEnd);// tmpEnd.getFullYear() + '-' + tmpEnd.getMonth() + '-' + tmpEnd.getDate();
    
});
/**
 * set the album data so the create and update forms can use this data 
 */
function setAlbumData(albumID) {
    if ( albumID != gotAlbum ) {
        // do some ajax:
        Ext.Ajax.request({
            loadMask: true
            ,baseParams: { action: 'mgr/album/getOne' }
            ,url: Cmp.config.connectorUrl
            ,params: {action: 'mgr/album/getOne', id: albumID}
            ,success: function(resp) {
              // resp is the XmlHttpRequest object
                albumData = Ext.decode(resp.responseText).results;
                if ( albumData.image_instructions == undefined ) {
                    albumData.image_instructions = 'The maximum image width is '+ albumData.file_width +' pixels, and the maximum image height is '+ albumData.file_height +' pixels.';
                }
                if ( albumData.advanced_instructions == undefined ) {
                    albumData.advanced_instructions = 'Fill in values.';
                }
                gotAlbum = albumID;
            }
        });
    }
}
Ext.onReady(function(){
    setAlbumData(cmpAlbumId);
});

Ext.extend(Cmp.grid.slide,MODx.grid.Grid,{
    search: function(tf,nv,ov) {
        var s = this.getStore();
        s.baseParams.query = tf.getValue();
        this.getBottomToolbar().changePage(1);
        this.refresh();
    }
    ,getMenu: function() {
        var m = [{
            text: _('slideshowmanager.slide_update')
            ,handler: this.updateSlide
        },'-',{
            text: _('slideshowmanager.slide_remove')
            ,handler: this.removeSlide
        }];
        this.addContextMenuItem(m);
        
        return true;
    }
    ,filterAlbums: function(cb,nv,ov) {
        cmpAlbumId = cb.getValue();
        this.getStore().setBaseParam('slideshow_album_id',cmpAlbumId);
        this.getBottomToolbar().changePage(1);
        // load album data:
        setAlbumData(cmpAlbumId);
        this.refresh();
    }
    ,filterSlides: function(cb,nv,ov) {
        this.getStore().setBaseParam('sort_type',cb.getValue());
        this.getBottomToolbar().changePage(1);
        this.refresh();
    }
    /*,addSlide: function(btn,e) {
        location.href = '?a='+MODx.request.a+'&action=editslide'+'&album_id='+cmpAlbumId;//+this.menu.record.slideshow_album_id;
    }*/
    ,updateSlide: function(btn,e) {
        mySlideUrl = Cmp.config.uploadUrl+this.menu.record.image_path;
        //setAlbumData(cmpAlbumId);
        
        if (!this.updateSlideWindow) {
            this.updateSlideWindow = MODx.load({
                xtype: 'cmp-window-slide-update'
                ,record: this.menu.record
                ,listeners: {
                    'success': {fn:this.refresh,scope:this}
                }
            });
        }
        //console.log(this.menu.record);
        this.menu.record.upload_file = '';
        this.updateSlideWindow.setValues(this.menu.record);
        
        this.updateSlideWindow.show(e.target);
        
        var ImagePath = Ext.select('#currentImagePath');
        ImagePath.set({
            src: mySlideUrl
        });
        //console.log(albumData);
        Ext.fly('albumUpdateDescription').dom.innerHTML = albumData.description;
        Ext.fly('albumUpdateImageInstructions').dom.innerHTML = albumData.image_instructions;
        Ext.fly('albumUpdateAdvancedInstructions').dom.innerHTML = albumData.advanced_instructions;
    }
    ,createSlide: function(btn,e) {
        if (!this.createSlideWindow) {
            this.createSlideWindow = MODx.load({
                xtype: 'cmp-window-slide-create'
                //,record: this.menu.record
                ,listeners: {
                    'success': {fn:this.refresh,scope:this}
                }
            });
        }
        var defaultData = {
            start_date: slideToday
            ,end_date: slideEnd
            ,slide_status: 'Insert'
            ,sequence: '1'
            ,album_id: cmpAlbumId
        };
        //console.log(defaultData);
        this.createSlideWindow.setValues(defaultData);
        
        this.createSlideWindow.show(e.target);
        Ext.fly('albumCreateDescription').dom.innerHTML = albumData.description;
        Ext.fly('albumCreateImageInstructions').dom.innerHTML = albumData.image_instructions;
        // Advanced instructions:
        // albumCreateImageInstructions
        Ext.fly('albumCreateAdvancedInstructions').dom.innerHTML = albumData.advanced_instructions;
        
    }
    ,removeSlide: function() {
        MODx.msg.confirm({
            title: _('slideshowmanager.slide_remove')
            ,text: _('slideshowmanager.slide_remove_confirm')
            ,url: this.config.url
            ,params: {
                action: 'mgr/slide/remove'
                ,id: this.menu.record.id
            }
            ,listeners: {
                'success': {fn:this.refresh,scope:this}
            }
        });
    }
});
Ext.reg('cmp-grid-slide',Cmp.grid.slide);

Cmp.window.UpdateSlide = function(config) {
    config = config || {};
   // alert(ImagePath.File);
    Ext.applyIf(config,{
        title: _('slideshowmanager.legend_slide_edit')
        ,url: Cmp.config.connectorUrl
        ,baseParams: {
            action: 'mgr/slide/update'
        }
        ,cls: 'x-window-with-tabs'
        ,width: 750
        //,modal: true
        ,fileUpload:true
        ,fields: [{
            xtype: 'modx-tabs'
            ,bodyStyle: 'padding: 10px'
            ,border: true
            ,fileUpload:true
            ,deferredRender: false
            ,forceLayout: true
            ,defaults: {
                autoHeight: true
                ,layout: 'form'
                ,deferredRender: false
                ,forceLayout: true
            }
            ,items: [{
                title: _('slideshowmanager.slidetab_basic')
                ,layout: 'form'
                ,cls: 'modx-panel'
                ,items:[{
                    xtype: 'hidden'
                    ,name: 'id'
                },{
                    //id: 'album_description'
                    html: '<p id="albumUpdateDescription"></p><br />'
                    ,border: false
                },{
                    xtype: 'textfield'
                    ,fieldLabel: _('slideshowmanager.slide_title')
                    ,name: 'title'
                    ,maxLength: 100
                    ,width: 400
                },{
                    xtype: 'textarea'
                    ,fieldLabel: _('slideshowmanager.slide_description')
                    ,name: 'description'
                    ,width: 400
                },{
                    xtype: 'textfield'
                    ,fieldLabel: _('slideshowmanager.slide_url')
                    ,maxLength: 255
                    ,name: 'url'
                    ,width: 400
                },{
                    xtype: 'datefield'
                    ,fieldLabel: _('slideshowmanager.slide_start_date')
                    ,name: 'start_date'
                    ,width: 150
                    //,renderer : Ext.util.Format.dateRenderer(MODx.config.manager_date_format)
                    ,format: MODx.config.manager_date_format
                    //,altFormats: MODx.config.manager_date_format
                },{
                    xtype: 'datefield'
                    ,fieldLabel: _('slideshowmanager.slide_end_date')
                    ,name: 'end_date'
                    ,width: 150
                    //,renderer : Ext.util.Format.dateRenderer(MODx.config.manager_date_format)
                    ,format: MODx.config.manager_date_format
                    //,altFormats: MODx.config.manager_date_format
                },{
                    xtype: 'textfield'
                    ,fieldLabel: _('slideshowmanager.slide_sequence')
                    ,name: 'sequence'
                    ,width: 150
                },{
                    xtype: 'slidestatus-combo'
                    ,fieldLabel: _('slideshowmanager.slide_status')
                    //,boxLabel: _('slideshowmanager.label_slide_status_insert')
                    //,inputValue: 'live'
                    ,renderer: 'value'
                    ,name: 'slide_status'
                    ,width: 300
                }]
             },{
                title: _('slideshowmanager.slidetab_update_image')
                ,border: false
                ,defaults: { autoHeight: true } 
                ,items: [{
                    //id: 'album_description'
                    html: '<p id="albumUpdateImageInstructions">'+_('slideshowmanager.slide_update_desc')+'</p><br />'
                    ,border: false
                },{
                    html: '<img id="currentImagePath" src="'+ mySlideUrl +'" width="400" />'
                    ,fieldLabel: _('slideshowmanager.slide_upload_current_image')
                    ,name: 'image_path'
                },{
                    xtype: 'textfield'
                    ,inputType: 'file'
                    ,fieldLabel: _('slideshowmanager.slide_upload_new_image')
                    ,name: 'upload_file'
                    ,accept: 'image/jpg'
                }/*/{
                    xtype: 'fileuploadfield'
                    ,id: 'upload_file'
                    ,emptyText: 'Select a document to upload...'
                    ,fieldLabel: 'File'
                    ,buttonText: 'Browse'
                    ,accept: 'image/jpg'
                }*/]
              },{
                title: _('slideshowmanager.slidetab_advanced')
                ,border: false
                ,autoHeight: true
                ,items:[{
                    html: '<p id="albumUpdateAdvancedInstructions">' + _('slideshowmanager.slide_update_desc')+'</p><br />'
                    ,border: false
                },{
                    xtype: 'textarea'
                    ,fieldLabel: _('slideshowmanager.slide_notes')
                    ,name: 'notes'
                    ,width: 400
                },{
                    xtype: 'textarea'
                    ,fieldLabel: _('slideshowmanager.slide_html')
                    ,name: 'html'
                    ,width: 400
                },{
                    xtype: 'textarea'
                    ,fieldLabel: _('slideshowmanager.slide_options')
                    ,name: 'options'
                    ,width: 400
                }]
            }]
        }]
       // ,cls: 'x-window-with-tabs' 
    });
    Cmp.window.UpdateSlide.superclass.constructor.call(this,config);
};
Ext.extend(Cmp.window.UpdateSlide,MODx.Window);
Ext.reg('cmp-window-slide-update',Cmp.window.UpdateSlide);

Cmp.window.CreateSlide = function(config) {
    config = config || {};
    
    Ext.applyIf(config,{
        title: _('slideshowmanager.slide_create')
        ,url: Cmp.config.connectorUrl
        ,baseParams: {
            action: 'mgr/slide/create'
        }
        ,cls: 'x-window-with-tabs'
        ,width: 750
        ,fileUpload:true
        ,fields: [{
            xtype: 'modx-tabs'
            ,bodyStyle: 'padding: 10px'
            ,border: true
            ,deferredRender: false
            ,forceLayout: true
            ,defaults: {
                border: false
                ,autoHeight: true
                ,layout: 'form'
                ,deferredRender: false
                ,forceLayout: true
            }
            ,items: [{
                    title: _('slideshowmanager.slidetab_basic')
                    ,cls: 'modx-panel'
                    ,border: false
                    ,defaults: { autoHeight: true }
                    ,items:[{
                        xtype: 'hidden'
                        ,name: 'album_id'
                    },{
                        html: '<p id="albumCreateDescription"></p><br />'
                        ,border: false
                    },{
                        xtype: 'textfield'
                        ,fieldLabel: _('slideshowmanager.slide_title')
                        ,maxLength: 100
                        ,name: 'title'
                        ,width: 400
                    },{
                        xtype: 'textarea'
                        ,fieldLabel: _('slideshowmanager.slide_description')
                        ,name: 'description'
                        ,width: 400
                    },{
                        xtype: 'textfield'
                        ,fieldLabel: _('slideshowmanager.slide_url')
                        ,maxLength: 255
                        ,name: 'url'
                        ,width: 400
                    },{
                        xtype: 'datefield'
                        ,fieldLabel: _('slideshowmanager.slide_start_date')
                        ,name: 'start_date'
                        ,inputValue: slideToday
                    ,renderer : Ext.util.Format.dateRenderer(MODx.config.manager_date_format)
                    ,format: MODx.config.manager_date_format
                    //,altFormats: MODx.config.manager_date_format
                    
                    ,editor: { xtype: 'datefield' } // datefield
                    //,xtype: 'datecolumn'
                    
                        ,width: 150
                    },{
                        xtype: 'datefield'
                        ,fieldLabel: _('slideshowmanager.slide_end_date')
                        ,name: 'end_date'
                        ,inputValue: slideEnd
                    ,renderer : Ext.util.Format.dateRenderer(MODx.config.manager_date_format)
                    ,format: MODx.config.manager_date_format
                    //,altFormats: MODx.config.manager_date_format
                        ,width: 150
                    },{
                        xtype: 'textfield'
                        ,fieldLabel: _('slideshowmanager.slide_sequence')
                        ,name: 'sequence'
                        ,width: 150
                    },{
                        xtype: 'slidestatus-create-combo'
                        ,fieldLabel: _('slideshowmanager.slide_status')
                        //,boxLabel: _('slideshowmanager.label_slide_status_insert')
                        ,inputValue: 'insert'
                        ,renderer: 'value'
                        ,name: 'slide_status'
                        ,width: 300
                    }]
                 },{
                    title: _('slideshowmanager.slidetab_image')
                    ,border: false
                    ,defaults: { autoHeight: true } 
                    ,items: [{
                        //id: 'album_description'
                        html: '<p id="albumCreateImageInstructions">'+_('slideshowmanager.slide_update_desc')+'</p><br />'
                        ,border: false
                    },{
                        xtype: 'textfield'
                        ,inputType: 'file'
                        ,fieldLabel: _('slideshowmanager.slide_upload_new_image')
                        ,name: 'upload_file'
                        ,accept: 'image/jpg'
                    }]
                 },{
                    title: _('slideshowmanager.slidetab_advanced')
                    ,border: false
                    ,autoHeight: true
                    ,items:[{
                        html: '<p id="albumCreateAdvancedInstructions">'+_('slideshowmanager.slide_update_desc')+'</p><br />'
                        ,border: false
                    },{
                        xtype: 'textarea'
                        ,fieldLabel: _('slideshowmanager.slide_notes')
                        ,name: 'notes'
                        ,width: 400
                    },{
                        xtype: 'textarea'
                        ,fieldLabel: _('slideshowmanager.slide_html')
                        ,name: 'html'
                        ,width: 400
                    },{
                        xtype: 'textarea'
                        ,fieldLabel: _('slideshowmanager.slide_options')
                        ,name: 'options'
                        ,width: 400
                    }]
                }]
            }]
    });
    Cmp.window.CreateSlide.superclass.constructor.call(this,config);
};
Ext.extend(Cmp.window.CreateSlide,MODx.Window);
Ext.reg('cmp-window-slide-create',Cmp.window.CreateSlide);
