/* YOU will need to edit this file with proper names, follow the cases(upper/lower) */
Ext.onReady(function() {
    MODx.load({ xtype: 'cmp-page-home'});
});

Cmp.page.Home = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        components: [{
            xtype: 'cmp-panel-home'
            ,renderTo: 'cmp-panel-home-div'
        }]
    });
    Cmp.page.Home.superclass.constructor.call(this,config);
};

Ext.extend(Cmp.page.Home,MODx.Component);
Ext.reg('cmp-page-home',Cmp.page.Home);