define(['jquery', 'mylibs', 'pages/validation'], function($, mylibs) {
    var Methods;
    return Methods = {
        // Creates a new table row for a new element
        addaddressobject: function() {
            $(document).once('click', '#addobjectrowbutton', function() {
                $('#addressobjectstable #addobjectrowbutton').hide();
                var clone = $('#addressobjectstable #addaddressobject').clone();
                clone.addClass("new");
                clone.removeAttr('id');
                $('#addressobjectstable #addaddressobject').after(clone);
                $('#addressobjectstable .new').show();
           });
        },
        // Save the object row
        saveaddressobject: function() {
            $(document).once('click', '.saveobjectrow', function() {
                // Get the row
                var thisrow = $(this).closest('tr');
                // Vars for adding objects
                var id = thisrow.find(".id");
                var name = thisrow.find(".addressobjectname");
                var ipv4address = thisrow.find(".addressobjectipv4address");
                var dnsname = thisrow.find(".addressobjectdnsname");
                var description = thisrow.find(".addressobjectdescription");
                var type = thisrow.find(".typeselection");
                // ajax asker
                var btype = false;
                var bname = false;
                var bdnsname = false;
                var bipv4address = false;
                // type selected
                if ( type.select('option:selected').val() == "Select type..." ) {
                    // Error type
                    errorfeedback(type);
                } else {
                    okfeedback(type);
                    btype = true;
                }
                // name given
                if ( (name.val() == "") || (name.val() == "Name") ) {
                    // Error name
                    errorfeedback(name);
                } else {
                    okfeedback(name);
                    bname = true;
                }
                // dnsname needed
                if ( type.select('option:selected').val() != "network" ) {
                    // dnsname given
                    if ( (dnsname.val() == "") || (dnsname.val() == "DNS Name") ) {
                        // Error dnsname
                        errorfeedback(dnsname);   
                    } else {
                        okfeedback(dnsname);
                        bdnsname = true;
                    }
                } else {
                    bdnsname = true;
                }
                // check ipv4 address
                if ( !ipvalid(type.select('option:selected').val(), ipv4address.val()) ) {
                    // Error ip
                    errorfeedback(ipv4address);
                } else {
                    okfeedback(ipv4address);
                    bipv4address = true;
                }
                // Ajax will be send here
                if ( btype && bname && bdnsname && bipv4address ) {
                    // Data for the ajax
                    var data = {
                        id: id.text(),
                        name: name.val(),
                        ipv4address: ipv4address.val(),
                        dnsname: dnsname.val(),
                        description: description.val(),
                        type: type.val()
                    };
                    $.ajax({
                        type:   'post',
                        cache:  false,
                        url:    "/asphaleia/addressobjects/update",
                        data:   data,
                        success: function(result){
                            // replace input fields with values
                            id.text(result);
                            name.replaceWith(data['name']);
                            ipv4address.replaceWith(data['ipv4address']);
                            dnsname.replaceWith(data['dnsname']);
                            description.replaceWith(data['description']);
                            type.replaceWith(data['type']);
                            // Hide the save button
                            thisrow.find('.saveobjectrow').hide();
                            // show the new line button
                            $('#addressobjectstable #addobjectrowbutton').show();
                        }
                    });
                }
            });
        },
        // Delete the object
        deleteaddressobject: function() {
            $(document).once('click', '.deleteobjectrow', function() {
                var row = $(this).closest('tr');
                var id = row.find('.id').html();
                var data = { id: id };
                // If it is a new host or network delete only the row
            	if( id == "") {
            		row.remove();
                    $('#addressobjectstable #addobjectrowbutton').show();
            	} else {
                    // make the ajax and delete the object
                    $.ajax({
                        type:   'post',
                        cache:  false,
                        url:    "/asphaleia/addressobjects/delete",
                        data:   data,
                        success: function(result){
                            row.remove();
                        }
                    });
                }
            });
        },
        // Update on type change
        typechange: function() {
            $(document).once('change', '.typeselection', function() {
                var thisrow = $(this).closest('tr');
                var type = thisrow.find(".typeselection");
                // If type is network
                if ( type.select('option:selected').val() == "network" ) {
                    // set dnsname val to ""
                    thisrow.find('.addressobjectdnsname').val("");
                    // disable dns input field
                    thisrow.find('.addressobjectdnsname').prop( "disabled", true );
                    // clear dns color
                    neutralfeedback(thisrow.find('.addressobjectdnsname'));
                    // clear ipv4 address color
                    neutralfeedback(thisrow.find('.addressobjectipv4address'));
                } else {
                    // give errorfeedback for dnsname
                    errorfeedback(thisrow.find('.addressobjectdnsname'));
                    // enable dns input field
                    thisrow.find('.addressobjectdnsname').prop( "disabled", false );
                }
            })
        }
    };
    function errorfeedback(objectclass) {
        objectclass.css({'background-color': '#d9534f'});
    };
    function okfeedback(objectclass) {
        objectclass.css({'background-color': '#449D44'});
    };
    function neutralfeedback(objectclass) {
        objectclass.css({'background-color': ''});
    }
});