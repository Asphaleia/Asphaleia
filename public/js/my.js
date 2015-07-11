// Delete items
$(document).on('click', '#objects li span', function() {
    $( this ).closest('li').remove();
});
// Drag and drop function
$(document).on('blur', '#addressobjectssearch', function() {
    $( "#addressobjects li" ).draggable({
        cursor: "move",
        appendTo: "body",
        helper: "clone"
    });
    $( "#addressobjects-space ul" ).droppable({
      activeClass: "ui-state-default",
      hoverClass: "ui-state-hover",
      accept: ":not(.ui-sortable-helper)",
      drop: function( event, ui ) {
        $( this ).find( ".placeholder" ).remove();
        // Look for same object
        if( $('#objects').find('li[value="' + ui.draggable.val() + '"]').length == "0" )
        {
            span = " <a href='#'><span class='glyphicon glyphicon-remove' aria-hidden='true'></span></a>";
            $( "<li class='list-group-item'></li>" ).text( ui.draggable.text() ).val( ui.draggable.val() ).appendTo( this ).append(span);
        }
      }
    }).sortable({
      items: "li:not(.placeholder)",
      sort: function() {
        $( this ).removeClass( "ui-state-default" );
      }
    });
});
// Display right comment chars
$(document).on('keyup', '#comment', function(){
    character = 200;
    if($(this).val().length > character){
        $(this).val($(this).val().substr(0, character));
    }
    $("#comment-chars").text($(this).val().length + "/200");
});
// Save the object
$(document).on('click', '#addingspace #save', function(){
    // Delete the default member
    $( '#addingspace #objects' ).find( ".placeholder" ).remove();
        // Get id
        id = $( this ).val();
        if( id == "" )
        {
            id = null;
        }
        // Get data
        var data = {
            id: id,
            name: getName(),
            description: getDescription(),
            member: { }
        };
        // Add member
        i = 0;
        $('#addingspace #objects li').each(function(){
            data['member'][i++] = $(this).val();
        });
    // If no name is inserted
    if( $( '#addingspace' ).find(".danger").length == 0 ) {
        // Send ajax
        $.ajax({
            type:    'post',
            cache:   false,
            url:     window.location,
            data:    data,
            success: function(result){
                window.close();
            }
        });
    }
});
// Get name
function getName() {
    name = $("#addingspace #name input").val().length;
    if( name < 1 ) {
        $("#addingspace #name span").addClass("danger");
    } else {
        $("#addingspace #name span").removeClass("danger");
    }
    return $("#addingspace #name input").val();
};
// Get description
function getDescription() {
    return $("#addingspace #comment").val();
};
// Search address objects
$(document).on('keyup', '#addressobjectssearch', function() {
    // Search string read
    search = $( '#addressobjectssearch input' ).val();
    // Clear search
    $( '#searchResults ul .list-group-item' ).remove();
    // Search and print results
    $.getJSON('/asphaleia/public/search/objects/' + search, function(data) {
        obj = jQuery.parseJSON(data);
        for (var i = 0; i < obj.length; i++)
        {
            $( '#searchResults ul' ).append('<li class="list-group-item" value="' + obj[i]['id'] + '">' + obj[i]['name'] + '</li>');
        };
    });
});
// CLose button
$(document).on('click', '#closebutton', function() {
    window.close();
});