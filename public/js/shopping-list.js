//hides visible well and shows well with id passed in.
function changeWell(wellToShow)
{
    var visibleWell = $('#' + $('.fadeIn:visible').attr('id'));
    wellToShow = $('#'+wellToShow);
    visibleWell.addClass('fadeOut animated');
    setTimeout(function() {
        visibleWell.hide();
        visibleWell.removeClass('fadeOut animated');
        wellToShow.addClass('fadeIn animated');
        wellToShow.show();
    }, 500);
}

function hideWell(wellToHide)
{
    wellToHide = $('#'+wellToHide);
    if (wellToHide.hasClass('animated')) {
        wellToHide.removeClass('animated');
    }
    if (wellToHide.hasClass('fadeOut')) {
        wellToHide.removeClass('fadeOut');
    }
    wellToHide.addClass('fadeOut animated');
}

function refreshWell(well, url, callback)
{
    $.ajax({
        url: url,
        type: "GET",
        cache: false,
        success: function(response) {
            $('#'+well).html($('#'+well, response).html());
            callback();
        }
    });
}

function checkListItem(listItem)
{
    var listItemId = listItem.split('_');
    listItemId = listItemId[1];
    listItem = $('#'+listItem);
    var checkbox = listItem.children('input[name*="is_checked"]');
    var checkboxIcon = listItem.find('.checkbox');
    if (checkbox.val() == '0') {
        checkbox.val('1');
        checkboxIcon.removeClass('fa-square-o').addClass('fa-check-square-o');
    } else {
        checkbox.val('0');
        checkboxIcon.removeClass('fa-check-square-o').addClass('fa-square-o');
    }
    var data = "method=checkbox&listItemId="+listItemId+"&checkbox_val="+checkbox.val()+"&submit=1";
    $.ajax({
        url: '/api/',
        data: data,
        type: "POST",
        timeout: 10000, //10 seconds
        success: function(response) {
            if (response != 'Success') {
                alert('Something went wrong!');
            }
        },
        error: function(xhr, textStatus, errorThrown){
           alert('Connection lost! Unable to add new list.');
        }
    });
}