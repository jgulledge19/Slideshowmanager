var Cmp = function(config) {
    config = config || {};
    Cmp.superclass.constructor.call(this,config);
};
Ext.extend(Cmp,Ext.Component,{
    page:{},window:{},grid:{},tree:{},panel:{},combo:{},config: {}
});

Ext.reg('cmp',Cmp);

Cmp = new Cmp();