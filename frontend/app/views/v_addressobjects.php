<div class="container">
    <ol class="breadcrumb">
        <li class="active">Objects</li>
    </ol>

    <table id="objectstable" class = "table table-striped searchabletable">
        <thead>
            <tr>
                <th hidden></th>
                <th class="col-md-2">Name</th>
                <th class="col-md-2">IPv4</th>
                <!-- <th class="col-md-4">IPv6</th> -->
                <th class="col-md-2">DNS</th>
                <th class="col-md-4">Description</th>
                <th class="col-md-1">Type</th>
                <th class="col-md-1"><a href="#" id="addobjectrowbutton"><span class="glyphicon glyphicon-plus glyphicon-20" aria-hidden="true"></span></a></th>
                <th class="col-md-1"></th>
            </tr>
        </thead>

        <tbody id="addobjectstbody">
        <?php if (is_array($data)) { ?>
            <?php for ($i=0; $i < count($data); $i++) { ?>
                <tr>
                    <td hidden class="id"><?php echo $data[$i]->getId(); ?></td>
                    <td class="col-md-2 addressobjectname"><?php echo $data[$i]->getName(); ?></td>
                    <td class="col-md-2 addressobjectipv4address"><?php echo $data[$i]->getIpv4address(); ?></td>
                    <!-- <td class="col-md-2 type"><?php //echo $data[$i]->getIpv6address; ?></td>-->
                    <td class="col-md-2 addressobjectdnsname"><?php echo $data[$i]->getDnsname(); ?></td>
                    <td class="col-md-4 addressobjectdescription"><?php echo $data[$i]->getDescription(); ?></td>
                    <td class="col-md-1 addressobjecttype"><?php echo $data[$i]->getType(); ?></td>
                    <td class="col-md-1"><a href="#" class="deleteobjectrow"><span class="glyphicon glyphicon-trash glyphicon-20" aria-hidden="true"></span></a></td>
                    <td class="col-md-1"></td>
                </tr>
            <?php } ?>
        <?php } ?>
        </tbody>
    </table>
</div>

<script>
    require(['common'],function() {
        require(['pages/objecttable'],function(methods) {
            methods.add_event_handler_addobjectrowbutton();
            methods.add_event_handler_typeselection();
            methods.add_event_handler_saveobjectrow();
            methods.add_event_handler_objectvalue();
            methods.add_event_handler_objectname();
            methods.add_event_handler_deleteobjectrow();
        });
    });
</script>