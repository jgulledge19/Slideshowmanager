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
        ,fields: ['id','title','description','file_size_limit','file_allowed','file_width','file_height' ]
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
            ,handler: this.updateFeed
        },'-',{
            text: _('slideshowmanager.album_remove')
            ,handler: this.removeFeed
        }];
        this.addContextMenuItem(m);
        
        return true;
    }
    ,updateFeed: function(btn,e) {
        console.log('Update');
        if (!this.updateFeedWindow) {
            this.updateFeedWindow = MODx.load({
                xtype: 'cmp-window-album-update'
                ,record: this.menu.record
                ,listeners: {
                    'success': {fn:this.refresh,scope:this}
                }
            });
        } else {
            this.updateFeedWindow.setValues(this.menu.record);
        }
        this.updateFeedWindow.show(e.target);
    }

    ,removeFeed: function() {
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


Cmp.window.UpdateFeed = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        title: _('slideshowmanager.album_update')
        ,url: Cmp.config.connectorUrl
        ,baseParams: {
            action: 'mgr/album/update'
        }
        ,fields: [{ 
            html: _('slideshowmanager.album_update_desc')+'<br />'
        },{
            xtype: 'hidden'
            ,name: 'id'
        },{
            xtype: 'textfield'
            ,fieldLabel: _('slideshowmanager.album_title')
            ,name: 'title'
            ,width: 300
        },{
            xtype: 'textarea'
            ,fieldLabel: _('slideshowmanager.album_description')
            ,name: 'description'
            ,width: 300
        },{
            xtype: 'textfield'
            ,fieldLabel: _('slideshowmanager.album_file_size_limit')
            ,name: 'file_size_limit'
            ,width: 100
        },{
            xtype: 'textfield'
            ,fieldLabel: _('slideshowmanager.album_file_allowed')
            ,name: 'file_allowed'
            ,width: 300
        },{
            xtype: 'textfield'
            ,fieldLabel: _('slideshowmanager.album_file_width')
            ,name: 'file_width'
            ,width: 100
        },{
            xtype: 'textfield'
            ,fieldLabel: _('slideshowmanager.album_file_height')
            ,name: 'file_height'
            ,width: 100
        }
        ]
    });
    Cmp.window.UpdateFeed.superclass.constructor.call(this,config);
};
Ext.extend(Cmp.window.UpdateFeed,MODx.Window);
Ext.reg('cmp-window-album-update',Cmp.window.UpdateFeed);

Cmp.window.CreateAlbum = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        title: _('slideshowmanager.album_create')
        ,url: Cmp.config.connectorUrl
        ,baseParams: {
            action: 'mgr/album/create'
        }
        ,fields: [
        { 
            html: _('slideshowmanager.album_create_desc')+'<br />'
        },{
            xtype: 'textfield'
            ,fieldLabel: _('slideshowmanager.album_title')
            ,name: 'title'
            ,value: ''
            ,requried: true
            ,width: 300
        },{
            xtype: 'textarea'
            ,fieldLabel: _('slideshowmanager.album_description')
            ,name: 'description'
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
    });
    Cmp.window.CreateAlbum.superclass.constructor.call(this,config);
};
Ext.extend(Cmp.window.CreateAlbum,MODx.Window);
Ext.reg('cmp-window-album-create',Cmp.window.CreateAlbum);
