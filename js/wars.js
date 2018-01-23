/**
 * Get url params by name.
 *
 * @param name
 *   Name of the param.
 * @param url
 *   Url.
 * @returns {*}
 */
function getParameterByName(name, url) {
    if (!url) url = window.location.href;
    name = name.replace(/[\[\]]/g, "\\$&");
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, " "));
}

/**
 * Get random item from api.
 */
function getRandomItems() {
    $('#items-wrap .panel-body').html('<span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span>');
    $.ajax({
        type:'POST',
        url:'/api/show-random-apis-items',
        data:{},
        success:function(data){
            $('#items-wrap .panel-body').html(data);
        },
        error: function (error) {
            showErroModal(error.responseJSON.message);
        }
    });
}

/**
 * Show error in modal.
 *
 * @param text
 *   Text to show.
 */
function showErroModal(text) {
    var htmlAlert = '<div class="alert alert-danger">'+text+'</div>';
    $('#modal .modal-body').html(htmlAlert);
    $('#modal').modal();
}

$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    /**
     * Send request to get form for adding api.
     */
    $('#add-api').click(function (e) {
        e.preventDefault();
        $.get("/api/show-form", function(data, status){
            $('#modal .modal-body').html(data);
            $('#modal').modal();
        });
    });

    /**
     * Show enabled apis.
     */
    $('#show-apis').click(function (e) {
        e.preventDefault();
        $.get("/api/get-enabled", function(data, status){
            $('#modal .modal-body').html(data);
            $('#modal').modal();
        });
    });

    /**
     * Save enabled apis.
     */
    $('.modal-body').on('click', '#save-enabled', function (e) {
        e.preventDefault();
        var selected = [];
        $('#enabled-apis-form input:checked').each(function() {
            selected.push($(this).attr('name'));
        });

        $('#enabled-apis-form .message-wrap').html('');
        //TODO check for bad response.
        $.ajax({
            type:'PUT',
            url:'/api/save-enabled',
            data:{value:selected},
            success:function(data){
                $('#enabled-apis-form input[type="checkbox"]').each(function() {
                    var checkBoxName = $(this).attr('name');
                    var check = $.inArray(checkBoxName, data);
                    if (check >= 0) {
                        $(this).parent().find('.message-wrap').html('<span class="label label-success">Success</span>');
                    }
                });
            },
            error: function (error) {
                console.log(error);
            }
        });
    });

    /**
     * Show random items from api.
     */
    $('#show-random-apis-items').click(function (e) {
        e.preventDefault();
        getRandomItems();
    });

    /**
     * Send score for api item and show other random items.
     */
    $('#items-wrap').on('click', '.item-link', function (e) {
        e.preventDefault();
        var selectedHref = $(this).attr('href');
        var selectedItemID = getParameterByName('item_id', selectedHref);
        var selectedApiID = getParameterByName('api_id', selectedHref);
        var selectedItem = [];
            selectedItem.push({
                [selectedApiID]: selectedItemID
            });

        var otherItems = [];
        $('#items-wrap .item-link').not(this).each(function () {
           var href = $(this).attr('href');
           var otherItemId = getParameterByName('item_id', href);
           var otherApiItemId = getParameterByName('api_id', href);
            otherItems.push({
                [otherApiItemId]: otherItemId
            });
        });

        $.ajax({
            type:'POST',
            url:'/api/item/add-score',
            data:{'selectedItem':selectedItem, 'otherItems':otherItems},
            success:function(data){
                getRandomItems();
            },
            error: function (error) {
                showErroModal(error.responseJSON.message);
            }
        });
    });

});
