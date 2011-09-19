/* YOU will need to edit this file with proper names, follow the cases(upper/lower) */
Cmp.panel.Home = function(config) {
    config = config || {};
    Ext.apply(config,{
        border: false
        ,baseCls: 'modx-formpanel'
        ,items: [{
            html: '<h2>'+_('slideshowmanager.management')+'</h2>'
            ,border: false
            ,cls: 'modx-page-header'
        },{
            xtype: 'modx-tabs'
            ,bodyStyle: 'padding: 10px'
            ,defaults: { border: false ,autoHeight: true }
            ,border: true
            ,items: [{
                title: _('slideshowmanager.slide')
                ,defaults: { autoHeight: true }
                ,items: [{
                    html: '<p>'+_('slideshowmanager.slide_management_desc')+'</p><br />'
                    ,border: false
                },{
                    xtype: 'cmp-grid-slide'
                    ,preventRender: true
                }]
            },{
                title: _('slideshowmanager.album')
                ,defaults: { autoHeight: true }
                ,items: [{
                    html: '<p>'+_('slideshowmanager.album_management_desc')+'</p><br />'
                    ,border: false
                },{
                    xtype: 'cmp-grid-album'
                    ,preventRender: true
                }]
            }]
        }]
    });
    Cmp.panel.Home.superclass.constructor.call(this,config);
};

Ext.extend(Cmp.panel.Home,MODx.Panel);
Ext.reg('cmp-panel-home',Cmp.panel.Home);
