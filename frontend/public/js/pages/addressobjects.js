define(['jquery', 'mylibs'], function($, mylibs) {
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
                var name = thisrow.find(".addressobjectname");
                var ipv4address = thisrow.find(".addressobjectipv4address");
                var dnsname = thisrow.find(".addressobjectdnsname");
                var description = thisrow.find(".addressobjectdescription");
                var type = thisrow.find(".typeselection");
                // Watch out, are all arguments right?
                if ( type.select('option:selected').val() == "Select type..." ) {
                    // Error while type
                    errorfeedback(type);
                } else {
                    okfeedback(type);
                }
                if ( (name.val() == "") || (name.val() == "Name") ) {
                    // Error while name
                    errorfeedback(name);
                } else {
                    okfeedback(name);
                }
                if ( (dnsname.val() == "") || (dnsname.val() == "DNS Name") ) {
                    // Error while dnsname
                    errorfeedback(dnsname);
                } else {
                    okfeedback(dnsname);
                }
                if ( !ipnetworkvalid(ipv4address) ) {
                    // Error while ip
                    errorfeedback(ipv4address);
                } else {
                    okfeedback(ipv4address);
                }
                $('#addressobjectstable #addobjectrowbutton').show();
            });
        },
        deleteaddressobject: function() {
            $(document).once('click', '.deleteobjectrow', function() {
            	if($(this).closest('tr .id').val() == "") {
            		//make nothing and say dings
            	}
            	$(this).closest('tr').remove();
                $('#addressobjectstable #addobjectrowbutton').show();
            });
        }
    };
    function errorfeedback(objectclass) {
        objectclass.css({'background-color': '#d9534f'});
    };
    function okfeedback(objectclass) {
        objectclass.css({'background-color': '#449D44'});
    };
    function ipnetworkvalid (ipv4network) {
    // Trennen von Netz-IP und Subnetmask
        ipv4network = ipv4network.toString().split("/");
        // Netzwerk-IP
        netip = ipv4network[0];
        // Subnetmask
        mask = ipv4network[1];
        // Segmente aufteilen
        seg = netip.toString().split("\.");
        // Hostanteil
        hostanteil = 32-mask;
        // Hostanteil im letzten Segment
        hostanteilLetztesSegment = hostanteil%8;
        // Hosts im letzten Segment
        hostsLetztesSegment = Math.pow(2, hostanteilLetztesSegment);
        // Auswahl Segment
        auswahlSeg = parseInt(mask/8);
    
        if( seg[auswahlSeg]%hostsLetztesSegment == 0 )
        {
            // Alle Segmente hinter der Mask muessen Null sein
            allNull = true;
            for (var i=3; i > auswahlSeg; i--) { 
                if( seg[i] != 0 )
                {
                    allNull = false;
                }
            }
            if( allNull == true )
            {
                // Valid network
                return true;
            }
            else
            {
                // No valid network
                return false;
            }
        }
        else
        {
            // No valid network
            return false;
        }
    };
});