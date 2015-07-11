$(document).on('keyup', '#searchField input[type=text]', function(){
	searchText = $(this).val();
	if( searchText == "") {
  		$('#workingspace tbody tr').show();
	} else {
  		$('#workingspace tbody tr').hide();
  		$('#workingspace tbody tr:contains(' + searchText + ')').show();
	}
});