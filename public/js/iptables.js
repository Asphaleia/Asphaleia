// Open iptable configuration windows
$(document).on('click', '.iptable-rule-edit button', function(){
  // Split the value to chain id and rule id
  value = $(this).attr("value");
  value = value.split("+");
  chainid = value[0];
  ruleid = value[1];
  $("#changingspace").load("changingspace.php?show=changeiptablerule&iptableid=" + ruleid + "&type=" + chainid);
});

// Create new iptable rule
$(document).on('click', '.newiptablerule', function(){
     $("#changingspace").load("changingspace.php?show=changeiptablerule&iptableid=New&type=" + $(this).val());
});

// Display right comment chars
$(document).on('keyup', '#add-iptable-rule-comment-textarea', function(){
    character = 200;
    if($(this).val().length > character){
        $(this).val($(this).val().substr(0, character));
    }
    $("#comment-chars").text($(this).val().length + "/200");
});

// Show or hide the right content
$(document).on('click', '#changeiptablerule div .panel-heading', function(){
    $("#changeiptablerule .panel-body").hide();
    $("#add-iptable-rule-last-overview .panel-body").show();
    $(this).next(".panel-body").show();
});

// Hide the iptables views that are not needed
$(document).on('click', '#add-iptable-rule-chain label', function(){
    temp = $(this).text().lastIndexOf('Type: ');
    type = $(this).text().substring((temp+6));
    // Show all
    $('#add-iptable-rule-input').show();
    $('#add-iptable-rule-output').show();
    $('#add-iptable-rule-source').show();
    $('#add-iptable-rule-destination').show();
    // Hide what is not needed
    if( type == "input") {
        $('#add-iptable-rule-output').hide();
        $('#add-iptable-rule-destination').hide();
    }
    if( type == "output") {
        $('#add-iptable-rule-input').hide();
        $('#add-iptable-rule-source').hide();
    }
});

// Save the rules
$(document).on('click', '#iptableschange-save', function(){
  // Get the rule id
  // it although can be "New"
  id = $(this).attr('value');
  // Get the chain id
  chainid = $('#changeiptablerule #add-iptable-rule-chain input[type=radio]:checked').val();
  temp = $('#add-iptable-rule-chain input[type=radio]:checked').parent().text().lastIndexOf('Type: ');
  type = $('#add-iptable-rule-chain input[type=radio]:checked').parent().text().substring((temp+6));
  // Look if the chain id really is seleced
  if( typeof chainid == 'undefined' ) {
    $('#add-iptable-rule-chain').removeClass('panel-default');
    $('#add-iptable-rule-chain').addClass('panel-danger');
  } else {
    $('#add-iptable-rule-chain').removeClass('panel-danger');
    $('#add-iptable-rule-chain').addClass('panel-success');
  }
  // Get the interface id
  inputinterface = $('#add-iptable-rule-input input[type=radio]:checked').val();
  // Is an interface selected
  if( (typeof inputinterface == 'undefined') && (type != "output") ) {
    $('#add-iptable-rule-input').removeClass('panel-default');
    $('#add-iptable-rule-input').addClass('panel-danger');
  } else {
    $('#add-iptable-rule-input').removeClass('panel-danger');
    $('#add-iptable-rule-input').addClass('panel-success');
  }
  // Get the interface id
  outputinterface = $('#add-iptable-rule-output input[type=radio]:checked').val();
  // Is an interface selected
  if( (typeof outputinterface == 'undefined') && (type != "input") ) {
    $('#add-iptable-rule-output').removeClass('panel-default');
    $('#add-iptable-rule-output').addClass('panel-danger');
  } else {
    $('#add-iptable-rule-output').removeClass('panel-danger');
    $('#add-iptable-rule-output').addClass('panel-success');
  }
  // Get the target
  target = $('#add-iptable-rule-target input[type=radio]:checked').val();
  // Is a target selected
  if( typeof target == 'undefined' ) {
    $('#add-iptable-rule-target').removeClass('panel-default');
    $('#add-iptable-rule-target').addClass('panel-danger');
  } else {
    $('#add-iptable-rule-target').removeClass('panel-danger');
    $('#add-iptable-rule-target').addClass('panel-success');
  }
  // Get the comment textarea, no comment is allowed
  comment = $('#add-iptable-rule-comment textarea').val();
  // Default the active is false
  active = $('#add-iptable-rule-last-overview input[type=checkbox]').is(":checked");
  // Watching for the priority
  priority = $('#add-iptable-rule-last-overview input[type=text]').val();
  // When there is no priority or a no numeric var ...
  if( (priority == "") || (isNaN(priority)) ) {
    // take the highest available
    $.ajax({
      url: "handler/getMaxPriority.php?chainid=" + chainid,
      async: false,
      success: function(result){
        gottenResult = result.split("Priority: ");
        priority = gottenResult[1];
        $('#add-iptable-rule-last-overview input[type=text]').val(priority);
      }
    })
  }
  priority = $('#add-iptable-rule-last-overview input[type=text]').val();
  // Here comes the data array
  var data = {
                chainid:  chainid,
                inputinterfaceid:  inputinterface,
                outputinterfaceid: outputinterface,
                sourceid: {
                        hosts: { },
                        groups: { },
                      },
                destinationid: {
                        hosts: { },
                        groups: { },
                      },
                serviceid: {
                        hosts: { },
                        groups: { },
                      },
                target: target,
                comment: comment,
                active: active,
                priority: priority
          };
  // There is now need to select the objects and groups into the array
  // And if there is nothing to select, print an error
  sourceHost = 0;
  sourceGroup = 0;
  $('#add-iptable-rule-source .selectedItems ul .selectedElement').each(function(){
    if( $(this).text().indexOf("Group:") > -1) {
      data['sourceid']['groups'][sourceGroup] = $(this).val();
      sourceGroup++;
    } else {
      data['sourceid']['hosts'][sourceHost] = $(this).val();
      sourceHost++;
    }
  });
  // Here comes the error
  if( ((sourceHost+sourceGroup) == 0) && (type != "output") ) {
    $('#add-iptable-rule-source').removeClass('panel-default');
    $('#add-iptable-rule-source').addClass('panel-danger');
  } else {
    $('#add-iptable-rule-source').removeClass('panel-danger');
    $('#add-iptable-rule-source').addClass('panel-success');
  }
  destinationHost = 0;
  destinationGroup = 0;
  $('#add-iptable-rule-destination .selectedItems ul .selectedElement').each(function(){
    if( $(this).text().indexOf("Group:") > -1) {
      data['destinationid']['groups'][destinationGroup] = $(this).val();
      destinationGroup++;
    } else {
      data['destinationid']['hosts'][destinationHost] = $(this).val();
      destinationHost++;
    }
  });
  // One more error
  if( ((destinationHost+destinationGroup) == 0) && (type != "input")  ) {
    $('#add-iptable-rule-destination').removeClass('panel-default');
    $('#add-iptable-rule-destination').addClass('panel-danger');
  } else {
    $('#add-iptable-rule-destination').removeClass('panel-danger');
    $('#add-iptable-rule-destination').addClass('panel-success');
  }
  serviceHost = 0;
  serviceGroup = 0;
  $('#add-iptable-rule-service .selectedItems ul .selectedElement').each(function(){
    if( $(this).text().indexOf("Group:") > -1) {
      data['serviceid']['groups'][serviceGroup] = $(this).val();
      serviceGroup++;
    } else {
      data['serviceid']['hosts'][serviceHost] = $(this).val();
      serviceHost++;
    }
  });
  // Last time error
  if( (serviceHost+serviceGroup) == 0 ) {
    $('#add-iptable-rule-service').removeClass('panel-default');
    $('#add-iptable-rule-service').addClass('panel-danger');
  } else {
    $('#add-iptable-rule-service').removeClass('panel-danger');
    $('#add-iptable-rule-service').addClass('panel-success');
  }
  // Looking for missing arguments and make ajax if nothing misses
  if( $('#changeiptablerule').find('.panel-danger').length == 0 ) {
    $.ajax({
        type:    'post',
        cache:   false,
        url:     "handler/writeIptable.php?id=" + id,
        data:    data,
        beforeSend: function(){
          $('#iptableschange-save').addClass('disabled');
          $('#iptableschange-save').text('Changing...');
        },
        error: function(){
          $('#iptableschange-save').removeClass('disabled');
          $('#iptableschange-save').removeClass('btn-default');
          $('#iptableschange-save').addClass('btn-danger');
          $('#iptableschange-save').text('Try again');
        },
        success: function(result){
          $("#changingspace").load("changingspace.php?show=nothing");
    }}
    )
  } else {
    // What to do if there is an error
  }
});