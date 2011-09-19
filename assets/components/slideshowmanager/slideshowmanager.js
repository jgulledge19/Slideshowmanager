//set local blank image
//Ext.BLANK_IMAGE_URL = 'ext/resources/images/default/s.gif';
//define function to be executed when page loaded
Ext.onReady(function() {
    // start date calendar
    var openButtonID = 'txt_start_date';
    var calendarHolderID = 'ext_start_date';
    //define select handler
    var selectHandler = function(myDP, date) {
        //get the text field
        var field = document.getElementById('txt_start_date');
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
    
    // end date calendar
    var openButtonID2 = 'txt_end_date';
    var calendarHolderID2 = 'ext_end_date';
    //define select handler
    var selectHandler2 = function(myDP, date) {
        //get the text field
        var field = document.getElementById('txt_end_date');
        //add the selected date to the field
        field.value = date.format('m/d/Y');
        //hide the date picker
        myDP.hide();
    };
    
    //create the date picker
    var myDP2 = new Ext.DatePicker({
        startDay: 1,
        listeners: {
            'select':selectHandler2
        }
    });
    
    //render the date picker
    myDP2.render(calendarHolderID2);
    //hide date picker straight away
    myDP2.hide();
    
    //define click handler
    var clickHandler = function() {
        //show the date picker
        myDP2.show();
    };
    //add listener for button click
    Ext.EventManager.on(openButtonID2, 'click', clickHandler);
});
