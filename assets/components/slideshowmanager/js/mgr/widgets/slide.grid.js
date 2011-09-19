/* make a local <select>/combo box */
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
            action: 'mgr/slide/getList'
            ,slideshow_album_id: cmpAlbumId }
        ,save_action: 'mgr/slide/updateFromGrid'
        ,fields: ['id','slideshow_album_id', 'web_user_id', 'start_date', 'end_date', 
                'sequence', 'slide_status', 'version', 'options',/* 'resource_id', */ 'url',
                'title', 'description', 'notes','html','upload_time','file_path','image_path', 'file_size', 'file_type' ]
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
                return '<img src="'+Cmp.config.uploadUrl+value+'" height="100" />';
            }
            ,dataIndex: 'image_path'
            ,sortable: false
            ,width: 65 
            //,editor: { xtype: 'displayfield' }
        },{
            header: _('slideshowmanager.slide_start_date')
            ,dataIndex: 'start_date'
            ,sortable: true
            ,width: 20
            ,editor: { xtype: 'textfield' }/*
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
            ,width: 20
            ,editor: { xtype: 'textfield' }
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
            /*,renderer: function(value, cell) {
                url = '?a='+MODx.request.a+'&action=addslide'+'&album_id='+this.menu.record.slideshow_album_id;
                return '<a href="'+url+'">' + _('slideshowmanager.slide_create') + '</a>';
            }*/
            ,handler: this.addSlide /*{ xtype: 'cmp-window-slide-create' ,blankValues: true }*/
        }]
    });
    Cmp.grid.slide.superclass.constructor.call(this,config);
};

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
        this.refresh();
    }
    ,filterSlides: function(cb,nv,ov) {
        this.getStore().setBaseParam('sort_type',cb.getValue());
        this.getBottomToolbar().changePage(1);
        this.refresh();
    }
    ,addSlide: function(btn,e) {
        location.href = '?a='+MODx.request.a+'&action=editslide'+'&album_id='+cmpAlbumId;//+this.menu.record.slideshow_album_id;
    }
    ,updateSlide: function(btn,e) {
        
        if (!this.menu.record || !this.menu.record.id  || !this.menu.record.slideshow_album_id) {
            return false;
        }
        location.href = '?a='+MODx.request.a+'&action=editslide'+'&album_id='+this.menu.record.slideshow_album_id+
            '&slide_id='+this.menu.record.id;
        /*
        if (!this.updateSlideWindow) {
            this.updateSlideWindow = MODx.load({
                xtype: 'cmp-window-slide-update'
                ,record: this.menu.record
                ,listeners: {
                    'success': {fn:this.refresh,scope:this}
                }
            });
        } else {
            this.updateSlideWindow.setValues(this.menu.record);
        }
        this.updateSlideWindow.show(e.target);
        */
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

/*
Cmp.window.UpdateSlide = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        title: _('slideshowmanager.slide_update')
        ,url: Cmp.config.connectorUrl
        ,baseParams: {
            action: 'mgr/slide/update'
        }
        ,fields: [{ 
            html: _('slideshowmanager.slide_update_desc')+'<br />'
        },{
            xtype: 'hidden'
            ,name: 'id'
        },{
            xtype: 'textfield'
            ,fieldLabel: _('slideshowmanager.slide_title')
            ,name: 'title'
            ,width: 300
        },{
            xtype: 'textarea'
            ,fieldLabel: _('slideshowmanager.slide_description')
            ,name: 'description'
            ,width: 300
        },{
            xtype: 'textfield'
            ,fieldLabel: _('slideshowmanager.slide_file_size_limit')
            ,name: 'file_size_limit'
            ,width: 100
        },{
            xtype: 'textfield'
            ,fieldLabel: _('slideshowmanager.slide_file_allowed')
            ,name: 'file_allowed'
            ,width: 300
        },{
            xtype: 'textfield'
            ,fieldLabel: _('slideshowmanager.slide_file_width')
            ,name: 'file_width'
            ,width: 100
        },{
            xtype: 'textfield'
            ,fieldLabel: _('slideshowmanager.slide_file_height')
            ,name: 'file_height'
            ,width: 100
        }
        ]
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
        ,height: 300
        ,width: 600
        ,fileUpload: true
        ,fields: [{
            xtype: 'hidden'
            ,name: 'slideshow_album_id'
            /*'id','slideshow_album_id', 'web_user_id', 'start_date', 'end_date', 
                'sequence', 'slide_status', 'version', 'options', 'url',
                'title', 'description', 'notes','html','upload_time','file_path', 'file_size', 'file_type' ] * /
        }
        ,{ 
            html: _('slideshowmanager.slide_create_desc')+'<br />'
            // how can I make this dynamic text?
        },{
            xtype: 'textfield'
            ,inputType: 'file'
            ,fieldLabel: _('gallery.file')
            ,name: 'file'
            //,id: 'gal-'+this.ident+'-file'
        },{
            xtype: 'textfield'
            ,fieldLabel: _('slideshowmanager.slide_title')
            ,name: 'title'
            ,value: ''
            ,requried: true
            ,width: 300
        },{
            xtype: 'textarea'
            ,fieldLabel: _('slideshowmanager.slide_description')
            ,name: 'description'
            ,value: ''
            ,requried: true
            ,width: 300 
        },{
            xtype: 'textfield'
            ,fieldLabel: _('slideshowmanager.slide_notes')
            ,name: 'file_size_limit'
            ,value: '150'
            ,requried: true
            ,width: 100
        },{
            xtype: 'textfield'
            ,fieldLabel: _('slideshowmanager.slide_html')
            ,name: 'file_allowed'
            ,value: 'jpg,jpeg,png'
            ,requried: true
            ,width: 300
        },{
            xtype: 'textfield'
            ,fieldLabel: _('slideshowmanager.slide_file_width')
            ,name: 'file_width'
            ,value: '500'
            ,requried: true
            ,width: 100
        },{
            xtype: 'textfield'
            ,fieldLabel: _('slideshowmanager.slide_file_height')
            ,name: 'file_height'
            ,value: '300'
            ,requried: true
            ,width: 100
        }
        ]
    });
    Cmp.window.CreateSlide.superclass.constructor.call(this,config);
};
Ext.extend(Cmp.window.CreateSlide,MODx.Window);
Ext.reg('cmp-window-slide-create',Cmp.window.CreateSlide);
* /

Cmp.window.CreateSlide = function(config) {
    if (!this.menu.record || !this.menu.record.id  || !this.menu.record.slideshow_album_id) {
        return false;
    }
    location.href = '?a='+MODx.request.a+'&action=editslide'+'&album_id='+this.menu.record.slideshow_album_id+
            '&slide_id='+this.menu.record.id;
          
    Cmp.window.CreateSlide.superclass.constructor.call(this,config);
};  
Ext.extend(Cmp.window.CreateSlide,MODx.Window);
Ext.reg('cmp-window-slide-create',Cmp.window.CreateSlide);

*/