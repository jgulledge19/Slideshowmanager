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
            ,width: 20
            //,editor: { xtype: 'textfield' }
            // http://forums.modx.com/thread/74194/extjs-tips#dis-post-411595
            // http://jacwright.com/projects/javascript/date_format/
            ,renderer : Ext.util.Format.dateRenderer('Y-m-d')
            ,editor: { xtype: 'datefield' }
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
            ,width: 20
            ,renderer : Ext.util.Format.dateRenderer('Y-m-d')
            ,editor: { xtype: 'datefield' }
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
var album_description = '';
var album_file_width = '';
var album_file_height = '';

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
    /*,addSlide: function(btn,e) {
        location.href = '?a='+MODx.request.a+'&action=editslide'+'&album_id='+cmpAlbumId;//+this.menu.record.slideshow_album_id;
    }*/
    ,updateSlide: function(btn,e) {
        album_description = this.menu.record.album_description;
        album_file_width = this.menu.record.album_file_width;
        album_file_height = this.menu.record.album_file_height;
        mySlideUrl = Cmp.config.uploadUrl+this.menu.record.image_path;
        
        if (!this.updateSlideWindow) {
            this.updateSlideWindow = MODx.load({
            	xtype: 'cmp-window-slide-update'
                ,record: this.menu.record
                ,listeners: {
                    'success': {fn:this.refresh,scope:this}
                }
            });
            this.updateSlideWindow.setValues(this.menu.record);
        } else {
            this.updateSlideWindow.setValues(this.menu.record);
        }
        this.updateSlideWindow.show(e.target);
        
        var ImagePath = Ext.select('#currentImagePath');
        ImagePath.set({
        	src: mySlideUrl
        });
        
		Ext.fly('album_description').dom.innerHTML = album_description;
		Ext.fly('album_file_limits').dom.innerHTML = 'The maximum image width is '+ album_file_width +' pixels, and the maximum image height is '+ album_file_height +' pixels.';
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
        this.createSlideWindow.show(e.target);
		
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
	                title: 'Fields'
	                ,layout: 'form'
	                ,cls: 'modx-panel'
	                ,items:[{
			            xtype: 'hidden'
			            ,name: 'id'
			        },{
			        	//id: 'album_description'
	        	        html: '<p id="album_description"></p><br />'
	                    ,border: false
	                },{
			            xtype: 'textfield'
			            ,fieldLabel: _('slideshowmanager.slide_title')
			            ,name: 'title'
			            ,width: 300
			        },/*{
			            xtype: 'textfield'
			            //,inputType: 'file'
			            ,fieldLabel: _('slideshowmanager.label_url')
			            ,name: 'url'
			            ,width: 300
			            //,accept:'image/jpeg'
			        },*/{
			            xtype: 'datefield'
			            ,fieldLabel: _('slideshowmanager.slide_start_date')
			            ,name: 'start_date'
			            ,width: 110
			            ,format: 'Y-m-d'
			            ,altFormats: 'Y-m-d'
			        },{
			            xtype: 'datefield'
			            ,fieldLabel: _('slideshowmanager.slide_end_date')
			            ,name: 'end_date'
			            ,width: 110
			            ,format: 'Y-m-d'
			            ,altFormats: 'Y-m-d'
			        },{
			            xtype: 'textfield'
			            ,fieldLabel: _('slideshowmanager.slide_sequence')
			            ,name: 'sequence'
			            ,width: 100
			        },{
			            xtype: 'slidestatus-combo'
			            ,fieldLabel: _('slideshowmanager.slide_status')
			            //,boxLabel: _('slideshowmanager.label_slide_status_insert')
			            //,inputValue: 'live'
			            ,renderer: 'value'
			            ,name: 'slide_status'
			            ,width: 100
			        },{
			            xtype: 'textarea'
			            ,fieldLabel: _('slideshowmanager.slide_description')
			            ,name: 'description'
			            ,width: 300
			     	}]
			     },{
			     	title: _('slideshowmanager.slide_update_image')
	                ,border: false
	                ,defaults: { autoHeight: true } 
	                ,items: [{
			        	//id: 'album_description'
	        	        html: '<p id="album_file_limits"></p><br />'
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
	                },{
	                	boxLabel: 'Yes'
	                	,xtype: 'checkbox'
	                	,fieldLabel: 'Would you like to force the image to fit the maximum width and height?'
	                	,name: 'yes_constrain'
	                }]
	              },{
			     	title: 'Webdeveloper'
	                ,border: false
	                ,autoHeight: true
	                ,items:[{
	        	        html: _('slideshowmanager.slide_update_desc')+'<br />'
	                    ,border: false
	                },{
			            xtype: 'textarea'
			            ,fieldLabel: _('slideshowmanager.slide_notes')
			            ,name: 'notes'
			            ,width: 300
			        },{
			            xtype: 'textarea'
			            ,fieldLabel: _('slideshowmanager.slide_html')
			            ,name: 'html'
			            ,width: 300
			        },{
			            xtype: 'textarea'
			            ,fieldLabel: _('slideshowmanager.slide_options')
			            ,name: 'options'
			            ,width: 300
			        }]
	        	}]
		 	}]
        
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
	                title: 'Fields'
	                ,cls: 'modx-panel'
	                ,border: false
	                ,defaults: { autoHeight: true }
	                ,items:[{
			            xtype: 'hidden'
			            ,name: 'id'
			        },{
	        	        html: '<p></p><br />'
	                    ,border: false
	                },{
			            xtype: 'textfield'
			            ,fieldLabel: _('slideshowmanager.slide_title')
			            ,name: 'title'
			            ,width: 300
			        },/*{
			            xtype: 'textfield'
			            ,inputType: 'file'
			            ,fieldLabel: _('slideshowmanager.label_url')
			            ,name: 'url'
			            ,width: 300
			            ,accept:'image/jpeg'
			        },*/{
			            xtype: 'datefield'
			            ,fieldLabel: _('slideshowmanager.slide_start_date')
			            ,name: 'start_date'
			            ,width: 100
			        },{
			            xtype: 'datefield'
			            ,fieldLabel: _('slideshowmanager.slide_end_date')
			            ,name: 'end_date'
			            ,width: 100
			        },{
			            xtype: 'textfield'
			            ,fieldLabel: _('slideshowmanager.slide_sequence')
			            ,name: 'sequence'
			            ,width: 100
			        },{
			            xtype: 'slidestatus-combo'
			            ,fieldLabel: _('slideshowmanager.slide_status')
			            //,boxLabel: _('slideshowmanager.label_slide_status_insert')
			            //,inputValue: 'live'
			            ,renderer: 'value'
			            ,name: 'slide_status'
			            ,width: 100
			        }/*,{
			            xtype: 'radio'
			            ,boxLabel: _('slideshowmanager.label_slide_status_replace')
			            ,inputValue: 'replace'
			            ,name: 'slide_status'
			            ,width: 100
			        },{
			            xtype: 'radio'
			            ,boxLabel: _('slideshowmanager.label_slide_status_tbd')
			            ,inputValue: 'tbd'
			            ,name: 'slide_status'
			            ,width: 100
			        }*/,{
			            xtype: 'textarea'
			            ,fieldLabel: _('slideshowmanager.slide_description')
			            ,name: 'description'
			            ,width: 300
			     	}]
			     },{
			     	title: _('slideshowmanager.slide_create_image')
	                ,border: false
	                ,defaults: { autoHeight: true } 
	                ,items: [{
			        	//id: 'album_description'
	        	        html: '<p></p><br />'
	                    ,border: false
	                },{
	                	xtype: 'textfield'
	                	,inputType: 'file'
	                	,fieldLabel: _('slideshowmanager.slide_upload_new_image')
	                	,name: 'upload_file'
	                	,accept: 'image/jpg'
	                },{
	                	boxLabel: 'Yes'
	                	,xtype: 'checkbox'
	                	,fieldLabel: 'Would you like to force the image to fit the maximum width and height?'
	                	,name: 'yes_constrain'
	                }]
	             },{
			     	title: 'Webdeveloper'
	                ,border: false
	                ,autoHeight: true
	                ,items:[{
			            xtype: 'hidden'
			            ,name: 'id'
			        },{
	        	        html: _('slideshowmanager.slide_update_desc')+'<br />'
	                    ,border: false
	                },{
			            xtype: 'textarea'
			            ,fieldLabel: _('slideshowmanager.slide_notes')
			            ,name: 'notes'
			            ,width: 300
			        },{
			            xtype: 'textarea'
			            ,fieldLabel: _('slideshowmanager.slide_html')
			            ,name: 'html'
			            ,width: 300
			        },{
			            xtype: 'textarea'
			            ,fieldLabel: _('slideshowmanager.slide_options')
			            ,name: 'options'
			            ,width: 300
			        }]
	        	}]
		 	}]
        /*,fields: [{
        	xtype: 'modx-tabs'
            ,bodyStyle: 'padding: 10px'
            ,border: true
            ,defaults: { border: false ,autoHeight: true }
            ,items: [{
	                title: 'Fields'
	                ,layout: 'form'
	                ,cls: 'modx-panel'
	                ,border: false
	                ,defaults: { autoHeight: true }
	                ,items:[{
			            xtype: 'hidden'
			            ,name: 'id'
			        },{
	        	        html: _('slideshowmanager.slide_update_desc')+'<br />'
	                    ,border: false
	                },{
			            xtype: 'textfield'
			            ,fieldLabel: _('slideshowmanager.slide_title')
			            ,name: 'title'
			            ,width: 300
			        },{
			            xtype: 'textfield'
			            ,inputType: 'file'
			            ,fieldLabel: _('slideshowmanager.label_url')
			            ,name: 'url'
			            ,width: 300
			            ,accept:'image/jpeg'
			        },{
			            xtype: 'textfield'
			            ,fieldLabel: _('slideshowmanager.slide_start_date')
			            ,name: 'start_date'
			            ,width: 100
			        },{
			            xtype: 'textfield'
			            ,fieldLabel: _('slideshowmanager.slide_end_date')
			            ,name: 'end_date'
			            ,width: 100
			        },{
			            xtype: 'textfield'
			            ,fieldLabel: _('slideshowmanager.slide_sequence')
			            ,name: 'sequence'
			            ,width: 100
			        },{
			            xtype: 'radio'
			            ,fieldLabel: _('slideshowmanager.slide_status')
			            ,boxLabel: _('slideshowmanager.label_slide_status_insert')
			            ,inputValue: 'insert'
			            ,name: 'slide_status'
			            ,width: 100
			        },{
			            xtype: 'radio'
			            ,boxLabel: _('slideshowmanager.label_slide_status_replace')
			            ,inputValue: 'replace'
			            ,name: 'slide_status'
			            ,width: 100
			        },{
			            xtype: 'radio'
			            ,boxLabel: _('slideshowmanager.label_slide_status_tbd')
			            ,inputValue: 'tbd'
			            ,name: 'slide_status'
			            ,width: 100
			        },{
			            xtype: 'textfield'
			            ,fieldLabel: _('slideshowmanager.slide_description')
			            ,name: 'description'
			            ,width: 100
			     	}]
			     },{
			     	title: 'Webdeveloper'
	                ,layout: 'form'
	                ,border: false
	                ,defaults: { autoHeight: true }
	                ,items:[{
			            xtype: 'hidden'
			            ,name: 'id'
			        },{
	        	        html: _('slideshowmanager.slide_update_desc')+'<br />'
	                    ,border: false
	                },{
			            xtype: 'textarea'
			            ,fieldLabel: _('slideshowmanager.slide_notes')
			            ,name: 'title'
			            ,width: 300
			        },{
			            xtype: 'textarea'
			            ,fieldLabel: _('slideshowmanager.slide_html')
			            ,name: 'title'
			            ,width: 300
			        },{
			            xtype: 'textarea'
			            ,fieldLabel: _('slideshowmanager.slide_options')
			            ,name: 'title'
			            ,width: 300
			        }]
	        	}]
		 	}]*/
    });
    Cmp.window.CreateSlide.superclass.constructor.call(this,config);
};
Ext.extend(Cmp.window.CreateSlide,MODx.Window);
Ext.reg('cmp-window-slide-create',Cmp.window.CreateSlide);
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