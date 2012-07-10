/* make a local <select>/combo box */
Cmp.combo.FeedStatus = function(config) {
    config = config || {};
    Ext.applyIf(config,{
       //displayField: 'name'
        //,valueField: 'id'
        //,fields: ['id', 'name']
        store: ['approved','hidden','pending','auto_approved']
        //,url: Testapp.config.connectorUrl
        ,baseParams: { action: '' ,combo: true }
        //,mode: 'local'
        ,editable: false
    });
    Cmp.combo.FeedStatus.superclass.constructor.call(this,config);
};
//Ext.extend(MODx.combo.FeedStatus, MODx.combo.ComboBox);
Ext.extend(Cmp.combo.FeedStatus,MODx.combo.ComboBox);
Ext.reg('feedstatus-combo', Cmp.combo.FeedStatus);


/* YOU will need to edit this file with proper names, follow the cases(upper/lower) */
Cmp.grid.album = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        id: 'cmp-grid-album'
        ,url: Cmp.config.connectorUrl
        ,baseParams: { action: 'mgr/album/getList' }
        ,save_action: 'mgr/album/updateFromGrid'
        ,fields: ['id','title','description','file_size_limit','file_allowed','file_width','file_height','image_instructions','advanced_instructions','constrain' ]
        ,paging: true
        ,autosave: true
        ,remoteSort: true
        ,anchor: '97%'
        ,autoExpandColumn: 'description'
        ,columns: [{
            header: _('id')
            ,dataIndex: 'id'
            ,sortable: true
            ,width: 30
        },{
            header: _('slideshowmanager.album_title')
            ,dataIndex: 'title'
            ,sortable: true
            ,width: 45
            ,editor: { xtype: 'textfield' }
        },{
            header: _('slideshowmanager.album_description')
            ,dataIndex: 'description'
            ,sortable: true
            ,width: 65 
            ,editor: { xtype: 'textfield' }
        },{
            header: _('slideshowmanager.album_file_size_limit')
            ,dataIndex: 'file_size_limit'
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
            header: _('slideshowmanager.album_file_allowed')
            ,dataIndex: 'file_allowed'
            ,sortable: true
            ,width: 20
            ,editor: { xtype: 'textfield' }
        },{
            header: _('slideshowmanager.album_file_width')
            ,dataIndex: 'file_width'
            ,sortable: false
            ,width: 20
            ,editor: { xtype: 'textfield' }
        },{
            header: _('slideshowmanager.album_file_height')
            ,dataIndex: 'file_height'
            ,sortable: false
            ,width: 20
            ,editor: { xtype: 'textfield' }
        }]
        ,tbar: [{
            xtype: 'textfield'
            ,id: 'cmp-search-filter'
            ,emptyText: _('slideshowmanager.album_search')
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
        },{
            text: _('slideshowmanager.album_create')
            ,handler: { xtype: 'cmp-window-album-create' ,blankValues: true }
        }]
    });
    Cmp.grid.album.superclass.constructor.call(this,config);
};

Ext.extend(Cmp.grid.album,MODx.grid.Grid,{
    search: function(tf,nv,ov) {
        var s = this.getStore();
        s.baseParams.query = tf.getValue();
        this.getBottomToolbar().changePage(1);
        this.refresh();
    }
    ,getMenu: function() {
        var m = [{
            text: _('slideshowmanager.album_update')
            ,handler: this.updateAlbum
        },'-',{
            text: _('slideshowmanager.album_remove')
            ,handler: this.removeAlbum
        }];
        this.addContextMenuItem(m);
        
        return true;
    }
    ,updateAlbum: function(btn,e) {
        console.log('Update');
        if (!this.updateAlbumWindow) {
            this.updateAlbumWindow = MODx.load({
                xtype: 'cmp-window-album-update'
                ,record: this.menu.record
                ,listeners: {
                    'success': {fn:this.refresh,scope:this}
                }
            });
        }
        this.updateAlbumWindow.setValues(this.menu.record);
        this.updateAlbumWindow.show(e.target);
    }
    ,removeAlbum: function() {
        MODx.msg.confirm({
            title: _('slideshowmanager.album_remove')
            ,text: _('slideshowmanager.album_remove_confirm')
            ,url: this.config.url
            ,params: {
                action: 'mgr/album/remove'
                ,id: this.menu.record.id
            }
            ,listeners: {
                'success': {fn:this.refresh,scope:this}
            }
        });
    }
});
Ext.reg('cmp-grid-album',Cmp.grid.album);


Cmp.window.updateAlbum = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        title: _('slideshowmanager.album_update')
        ,url: Cmp.config.connectorUrl
        ,baseParams: {
            action: 'mgr/album/update'
        }
        ,id: this.ident
       ,fields: [{
            /*xtype: 'modx-tabs'
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
            }*/
            xtype: 'modx-tabs'
            ,bodyStyle: { background: 'transparent' }
            ,autoHeight: true
            ,deferredRender: false
            ,items: [{
                title: _('slideshowmanager.albumtab_basic')
                ,layout: 'form'
                ,cls: 'modx-panel'
                //
                ,bodyStyle: { background: 'transparent', padding: '10px' }
                ,autoHeight: true
                ,labelWidth: 130
                ,items:[{ 
                        html: _('slideshowmanager.album_update_desc')+'<br />'
                        ,border: false
                    },{
                        xtype: 'hidden'
                        ,name: 'id'
                    },{
                        xtype: 'textfield'
                        ,fieldLabel: _('slideshowmanager.album_title')
                        ,name: 'title'
                        ,requried: true
                        ,width: 300
                    },{
                        xtype: 'textfield'
                        ,fieldLabel: _('slideshowmanager.album_file_size_limit')
                        ,name: 'file_size_limit'
                        ,requried: true
                        ,width: 100
                    },{
                        xtype: 'textfield'
                        ,fieldLabel: _('slideshowmanager.album_file_allowed')
                        ,name: 'file_allowed'
                        ,requried: true
                        ,width: 300
                    },{
                        boxLabel: 'Yes'
                        ,xtype: 'checkbox'
                        ,fieldLabel: _('slideshowmanager.album_constrain_desc')
                        ,name: 'constrain'
                        ,inputValue: 1
                        ,checked: true
                    },{
                        xtype: 'textfield'
                        ,fieldLabel: _('slideshowmanager.album_file_width')
                        ,name: 'file_width'
                        ,requried: true
                        ,width: 100
                    },{
                        xtype: 'textfield'
                        ,fieldLabel: _('slideshowmanager.album_file_height')
                        ,name: 'file_height'
                        ,requried: true
                        ,width: 100
                    }
                ]
            },{ 
                title: _('slideshowmanager.albumtab_instructions')
                ,layout: 'form'
                ,cls: 'modx-panel'
                ,items:[{
                        //id: 'album_description'
                        html: _('slideshowmanager.album_instructions_desc')
                        ,border: false
                    },{
                        xtype: 'textarea'
                        ,fieldLabel: _('slideshowmanager.album_description')
                        ,name: 'description'
                        ,value: ''
                        ,requried: true
                        ,width: 300 
                    },{
                        xtype: 'textarea'
                        ,fieldLabel: _('slideshowmanager.album_image_instructions')
                        ,name: 'image_instructions'
                        ,width: 300
                    },{
                        xtype: 'textarea'
                        ,fieldLabel: _('slideshowmanager.album_advanced_instructions')
                        ,name: 'advanced_instructions'
                        ,width: 300
                    }
                ]
            }] // end outer items/tabs
        }]// end fields
    });
    Cmp.window.updateAlbum.superclass.constructor.call(this,config);
};
Ext.extend(Cmp.window.updateAlbum,MODx.Window);
Ext.reg('cmp-window-album-update',Cmp.window.updateAlbum);

Cmp.window.CreateAlbum = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        title: _('slideshowmanager.album_create')
        ,url: Cmp.config.connectorUrl
        ,baseParams: {
            action: 'mgr/album/create'
        }
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
                title: _('slideshowmanager.albumtab_basic')
                ,layout: 'form'
                ,cls: 'modx-panel'
                ,items:[{
                    xtype: 'hidden'
                    ,name: 'id'
                    },{
                        //id: 'album_description'
                        html: _('slideshowmanager.album_create_desc')
                        ,border: false
                    },{
                        xtype: 'textfield'
                        ,fieldLabel: _('slideshowmanager.album_title')
                        ,name: 'title'
                        ,value: ''
                        ,requried: true
                        ,width: 300
                    },{
                        xtype: 'textfield'
                        ,fieldLabel: _('slideshowmanager.album_file_size_limit')
                        ,name: 'file_size_limit'
                        ,value: '150'
                        ,requried: true
                        ,width: 100
                    },{
                        xtype: 'textfield'
                        ,fieldLabel: _('slideshowmanager.album_file_allowed')
                        ,name: 'file_allowed'
                        ,value: 'jpg,jpeg,png'
                        ,requried: true
                        ,width: 300
                    },{
                        boxLabel: 'Yes'
                        ,xtype: 'checkbox'
                        ,fieldLabel: _('slideshowmanager.album_constrain_desc')
                        ,name: 'constrain'
                        ,inputValue: 1
                        ,checked: true
                    },{
                        xtype: 'textfield'
                        ,fieldLabel: _('slideshowmanager.album_file_width')
                        ,name: 'file_width'
                        ,value: '500'
                        ,requried: true
                        ,width: 100
                    },{
                        xtype: 'textfield'
                        ,fieldLabel: _('slideshowmanager.album_file_height')
                        ,name: 'file_height'
                        ,value: '300'
                        ,requried: true
                        ,width: 100
                    }
                ]
            },{ 
                title: _('slideshowmanager.albumtab_instructions')
                ,layout: 'form'
                ,cls: 'modx-panel'
                ,items:[{
                    xtype: 'hidden'
                    ,name: 'id'
                    },{
                        //id: 'album_description'
                        html: _('slideshowmanager.album_instructions_desc')
                        ,border: false
                    },{
                        xtype: 'textarea'
                        ,fieldLabel: _('slideshowmanager.album_description')
                        ,name: 'description'
                        ,value: ''
                        ,requried: true
                        ,width: 300 
                    },{
                        xtype: 'textarea'
                        ,fieldLabel: _('slideshowmanager.album_image_instructions')
                        ,name: 'image_instructions'
                        ,width: 300
                    },{
                        xtype: 'textarea'
                        ,fieldLabel: _('slideshowmanager.album_advanced_instructions')
                        ,name: 'advanced_instructions'
                        ,width: 300
                    }
                ]
            }] // end outer items/tabs
        }]// end fields
    });
    Cmp.window.CreateAlbum.superclass.constructor.call(this,config);
};
Ext.extend(Cmp.window.CreateAlbum,MODx.Window);
Ext.reg('cmp-window-album-create',Cmp.window.CreateAlbum);
