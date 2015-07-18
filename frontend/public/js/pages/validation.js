function ipnetworkvalid(ipv4network) {
    // Trennen von Netz-IP und Subnetmask
    ipv4network = ipv4network.val().toString().split("/");
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