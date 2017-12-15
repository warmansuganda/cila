(function($) {
    $.fn.dataTable.ext.errMode = 'none';

    $.fn.myDataTable = function (options) {

        var object = $(this);

        var defaults = {
                url          : typeof object.attr('data-table-source') !== "undefined" ? object.attr('data-table-source') : null,
                ordering     : typeof object.attr('data-table-ordering') !== "undefined" ? object.attr('data-table-ordering') : true,
                filter       : false,
                lengthChange : false,
                filterData   : typeof object.attr('data-table-filter') !== "undefined" ? object.attr('data-table-filter') : false,
                columns      : null,
                columnDefs   : null,
                columnIndex  : typeof $('th.num-rows',object) !== "undefined" ? $('th.num-rows',object).index() : null,
                paging       : typeof object.attr('data-table-paging') !== "undefined" ? object.attr('data-table-paging') : 'true',
                info         : typeof object.attr('data-table-info') !== "undefined" ? object.attr('data-table-info') : 'true',
                onComplete   : function(event, rowCount) {},
                onDraw       : function(event) {},
                order        : []
        };

        var options = $.extend(defaults, options);

        var dataTable = object.DataTable( {
                bProcessing: true,
                bServerSide: true,
                ordering   : options.ordering,
                bFilter    : options.filter,
                filterData : options.filterData,
                bLengthChange: options.lengthChange,
                columnDefs: options.columnDefs,
                paging : options.paging == 'true',
                info : options.info == 'true',
                "aaSorting": [],
                order: options.order,
                ajax: {
                    url  : options.url,
                    data: function ( d ) {
                        var formData = {};
                        var serialize = $(options.filterData).serializeArray();
                        $.each(serialize, function(index, val) {
                             formData[val.name] = val.value;
                        });

                        var setting  = $.extend( {}, d, formData);

                        return setting;
                    }
                },

                columns: options.columns,

                fnInitComplete: function () {
                    $(this).find('[data-sorting = false]').attr('class', 'sorting_disabled');
                    $('[rel="tooltip"]').tooltip();
                    options.onComplete.call(object);
                },

                // drawCallback: function( settings ) {
                //     $(this).find('[data-sorting = false]').attr('class', 'sorting_disabled');
                //     $('[rel="tooltip"]').tooltip();

                //     var info  = dataTable.page.info();
                //     var rowCount = info.recordsTotal;

                //     if(options.columnIndex !== null && options.columnIndex !== -1) {
                //         if ( settings.bSorted || settings.bFiltered )
                //         {
                //             var info  = dataTable.page.info();
                //             var no    = info.start + 1;
                //             dataTable.column(options.columnIndex, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                //                 cell.innerHTML = no++;
                //             });
                //         }
                //     }
                //     options.onDraw.call(object);
                //     $(':input[type="checkbox"]', object).uniform();
                // },

            });


        return {
            reload : function(str) {
               if (typeof str !== "undefined" || str === 'false') {
                    dataTable.draw(false);
                } else {
                    dataTable.draw();
                }
            },

            reloadParam : function(cond) {
                var table = object.DataTable();
                var url   = options.url + '?'+$.param(cond);

                table.ajax.url(url).load();
            },

            filterReset : function() {
                var filter = options.filterData;
                var form   = $(filter);

                form[0].reset();
                if ($('.select2', form).length > 0) {
                    $('.select2', form).trigger("change");
                }

                this.reload();
            },

            row : function(row) {
                return dataTable.row(row);
            }
        };

    };

}(jQuery));
