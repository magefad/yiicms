/**
 * @author Fadeev Ruslan
 * Date: 02.11.12
 * Time: 12:32
 */
(function($) {
    $.fn.treeAble = function(id, action, treeTableOptions, draggableOptions, callback) {
        var treeTableDefaults = {initialState: 'expanded'};
        var draggableDefaults = {
            helper          : 'clone',
            opacity         : '.75',
            refreshPositions: true, // Performance?
            revert          : 'invalid',
            revertDuration  : 300,
            scroll          : true
        };

        var table = $(this);
        $('.items', table).treeTable($.extend(treeTableDefaults, treeTableOptions));

        var drugs = $('.items tr.initialized', table);
        drugs.draggable($.extend(draggableDefaults, draggableOptions));
        drugs.droppable({
            accept    : '.initialized',
            drop      : function(e, ui) {
                // Call jQuery treeTable plugin to move the branch
                $(ui.draggable).appendBranchTo(this);
                $(this).refresh();
                var type = 'child';
                var to = $(this).attr('id');
                var moved = $(ui.draggable).attr('id');
                if ( action ) {
                    if ( $(this).hasClass('before') ) {
                        type = 'before';
                        to = $(this).attr('id').replace('before-', '');
                    } else if ( $(this).hasClass('after') ) {
                        type = 'after';
                        to = $(this).attr('id').replace('after-', '');
                    }
                    // Run an Ajax request to save the new weights
                    $.post(action, {
                        type : type, //default moveNode type is "Child"
                        to   : to,
                        moved: moved
                    }).error(function(data) {
                            alert('Error ' + data.status + ': ' + data.responseText);
                        }).complete(function() {
                            $.fn.yiiGridView.update(id);
                        });
                }
                if ( $.isFunction(callback) ) {
                    callback(type, to, moved);
                }
            },
            hoverClass: 'accept',
            over      : function(e, ui) {
                // Make the droppable branch expand when a draggable node is moved over it.
                if ( this.id !== $(ui.draggable.parents('tr')[0]).id && !$(this).is('.expanded') ) {
                    $(this).expand();
                }
                if ( $(this).hasClass('before') || $(this).hasClass('after') ) {
                    $(this).children().find('div').toggleClass('accept', 150);
                }
            },
            out       : function() {
                if ( $(this).hasClass('before') || $(this).hasClass('after') ) {
                    $(this).children().find('div').toggleClass('accept', 100);
                }
            },
            activate  : function(e, ui) {
                $('.after, .before').not($(ui.draggable).prev()).not($(ui.draggable).next()).css('display', 'table-row');
            },
            deactivate: function() {
                $('.after, .before').css('display', 'none');
            }
        });
        // Make visible that a row is clicked
        $('.items tbody tr', table).mousedown(function() {
            $('tr.selected').removeClass('selected'); // Deselect currently selected rows
            $(this).addClass('selected');
        });
    };
})(jQuery);
