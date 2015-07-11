$(document).on('keyup', '.livesearch input', function(){
    searchText = $(this).val();
    resultContainer = $(this).next(".searchResults");
    resultContainer.show();
    if( resultContainer.text() != "") {
        resultContainer.text("");
        url = "";
        if( $(this).hasClass('hosts') ) {
            url = "handler/searchHosts.php";
        }
        if ( $(this).hasClass('services') ) {
            url = "handler/searchServices.php";
        }
        $.ajax({url: url + "?searchText=" + searchText, success: function(resultText){
            resultContainer.append(resultText);
        }})
    }
});

$('.livesearch .searchResults').blur(function() {
    $('.livesearch .searchResults').hide();
});

$(document).on('click', '.searchResults a', function(){
    text = $(this).text();
    id = $(this).attr('id');
    $(this).parent().parent().parent().parent().find('.selectedItems ul').first().append('<li class="list-group-item selectedElement" value="' + id +'">' + text + ' <a href="#" class="deleteItem"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a></li>');
    $(this).parent().parent().find('.searchResults').hide();
});

$(document).on('click', '.selectedItems ul li a', function(){
    $(this).parent().remove();
});