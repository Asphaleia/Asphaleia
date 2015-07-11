/*
* Objects menu
*/
// Open object configuration windows
$(document).on('click', '.objectbutton', function(){
	temp = $(this).attr("value");
	temp = temp.split("+");
	type = temp[0];
	id = temp[1];
    $("#changingspace").load("changingspace.php?show=object&type=" + type + "&id=" + id);
});
// Save the changes
$(document).on('click', '#saveobject', function(){
  // Get the object id
  // it although can be "New"
  id = $(this).attr('value');
  console.log(id);
  type = $('#add-object-type').html();
  name = $('#add-object-name input[type=text]').val();
  ipv4address = $('#add-object-ipv4address input[type=text]').val();
  ipv6address = $('#add-object-ipv6address input[type=text]').val();
  dnsname = $('#add-object-dnsname input[type=text]').val();
  description = $('#add-object-description textarea').val();
  // Required objects
  if( name == '' ) {
  	$('#add-object-name .panel-body').addClass('danger');
  } else {
  	$('#add-object-name .panel-body').removeClass('danger');
  }
  if( (ipv4address == '') && (ipv6address == '') ) {
  	$('#add-object-ipv4address .panel-body').addClass('danger');
  	$('#add-object-ipv6address .panel-body').addClass('danger');
  } else {
  	$('#add-object-ipv4address .panel-body').removeClass('danger');
  	$('#add-object-ipv6address .panel-body').removeClass('danger');
  }
  // Here comes the data array
  var data = {
  			type: type,
			name: name,
			ipv4address: ipv4address,
			ipv6address: ipv6address,
			dnsname: dnsname,
			description: description
          };
  // Looking for missing arguments and make ajax if nothing misses
  if( $('#changingspace').find('.danger').length == 0 ) {
    $.ajax({
      type:    'post',
      cache:   false,
      url:     "handler/writeObject.php?id=" + id,
      data:    data,
      beforeSend: function(){
        $('#saveobject').addClass('disabled');
        $('#saveobject').text('Changing...');
      },
      error: function(){
        $('#saveobject').removeClass('disabled');
        $('#saveobject').removeClass('btn-default');
        $('#saveobject').addClass('btn-danger');
        $('#saveobject').text('Try again');
      },
      success: function(result){
        $("#changingspace").load("changingspace.php?show=nothing");
      }
    })
  } else {
    // What to do if there is an error
  }
});

$(document).on('click', '.newobject li a', function(){
	id = "New";
	type = $(this).text().toLowerCase();
    $("#changingspace").load("changingspace.php?show=object&type=" + type + "&id=" + id);
});

$(document).on('click', '#closechangemenu', function(event) {
  $("#changingspace").load("changingspace.php?show=nothing");
});