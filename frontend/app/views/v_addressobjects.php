<div class="container">
    <ol class="breadcrumb">
        <li class="active">Objects</li>
    </ol>

    <table id="addressobjectstable" class = "table table-striped searchabletable">
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
            <!-- Hidden table row for cloning and adding content -->
            <tr hidden id="addaddressobject">
                <td hidden class="id"><input class="addressobjectid" type="text" name="value"></td>
                <td class="col-md-2"><input class="addressobjectname" type="text" name="value" placeholder="Name"></td>
                <td class="col-md-2"><input class="addressobjectipv4address" type="text" name="value" placeholder="IPv4 address"></td>
                <!-- <td class="col-md-2 type"></td>-->
                <td class="col-md-2"><input class="addressobjectdnsname" type="text" name="value" placeholder="DNS Name"></td>
                <td class="col-md-4"><input class="addressobjectdescription" type="text" name="value" placeholder="Description"></td>
                <td class="col-md-1">
                    <select class="typeselection">
                        <option class="default">Select type...</option>
                        <option value="hostv4">IPv4 Host</option>
                        <option value="networkv4">IPv4 Network</option>
                    </select>
                </td>
                <td class="col-md-1"><a href="#" class="deleteobjectrow"><span class="glyphicon glyphicon-trash glyphicon-20" aria-hidden="true"></span></a></td>
                <td class="col-md-1"><a href="#" class="saveobjectrow"><span class="glyphicon glyphicon-save glyphicon-20" aria-hidden="true"></span></a></td>
            </tr>
        <?php if (is_array($data)) { ?>
            <?php for ($i=0; $i < count($data); $i++) { ?>
                <tr>
                    <td hidden class="id"><?php echo $data[$i]->getId(); ?></td>
                    <td class="col-md-2"><?php echo $data[$i]->getName(); ?></td>
                    <td class="col-md-2"><?php echo $data[$i]->getIpv4address(); ?></td>
                    <!-- <td class="col-md-2 type"><?php //echo $data[$i]->getIpv6address; ?></td>-->
                    <td class="col-md-2"><?php echo $data[$i]->getDnsname(); ?></td>
                    <td class="col-md-4"><?php echo $data[$i]->getDescription(); ?></td>
                    <td class="col-md-1"><?php echo $data[$i]->getType(); ?></td>
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
        require(['pages/addressobjects'],function(methods) {
            methods.addaddressobject();
            methods.saveaddressobject();
            methods.deleteaddressobject();
        });
    });
</script>