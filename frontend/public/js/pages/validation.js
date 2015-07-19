function ipvalid(type, ipv4address) {
    var valid = false;
    if ( type == "network" ) {
        valid = ipnetworkvalid(ipv4address);
    } else if ( type == "host" ) {
        valid = iphostvalid(ipv4address);
    } else {
        valid = false;
    }
    return valid;
}

function ipnetworkvalid(ipv4network) {
    // Trennen von Netz-IP und Subnetmask
    ipv4network = ipv4network.split("/");
    // Netzwerk-IP
    netip = ipv4network[0];
    // Subnetmask
    mask = ipv4network[1];
    // Segmente aufteilen
    seg = netip.split("\.");
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

function iphostvalid(ipv4address) {
    return (/^(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/.test(ipv4address))
};