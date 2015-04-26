(function ($) {
    "use strict";
    $(document).ready(function () {
        var found = false
        $('.sidebar-menu a').each(function(){
            if(location.pathname == $(this).attr('href')){
                if($(this).closest('ul').is('.sub')){
                    $(this).parent().addClass('active');
                    $(this).closest('ul').prev().addClass('active');
                } else {
                    $(this).addClass('active');
                }
            }
        });
        /*==Left Navigation Accordion ==*/
        if ($.fn.dcAccordion) {
            $('#nav-accordion').dcAccordion({
                eventType: 'click',
                autoClose: true,
                saveState: true,
                disableLink: true,
                speed: 'slow',
                showCount: false,
                autoExpand: true,
                classExpand: 'dcjq-current-parent'
            });
        }
        /*==Slim Scroll ==*/
        if ($.fn.slimScroll) {
            $('.event-list').slimscroll({
                height: '305px',
                wheelStep: 20
            });
            $('.conversation-list').slimscroll({
                height: '360px',
                wheelStep: 35
            });
            $('.to-do-list').slimscroll({
                height: '300px',
                wheelStep: 35
            });
        }
        /*==Nice Scroll ==*/
        if ($.fn.niceScroll) {


            $(".leftside-navigation").niceScroll({
                cursorcolor: "#1FB5AD",
                cursorborder: "0px solid #fff",
                cursorborderradius: "0px",
                cursorwidth: "3px"
            });

            $(".leftside-navigation").getNiceScroll().resize();
            if ($('#sidebar').hasClass('hide-left-bar')) {
                $(".leftside-navigation").getNiceScroll().hide();
            }
            $(".leftside-navigation").getNiceScroll().show();

            $(".right-stat-bar").niceScroll({
                cursorcolor: "#1FB5AD",
                cursorborder: "0px solid #fff",
                cursorborderradius: "0px",
                cursorwidth: "3px"
            });

        }
        /*==Collapsible==*/
        $('.widget-head').click(function (e) {
            var widgetElem = $(this).children('.widget-collapse').children('i');

            $(this)
                .next('.widget-container')
                .slideToggle('slow');
            if ($(widgetElem).hasClass('ico-minus')) {
                $(widgetElem).removeClass('ico-minus');
                $(widgetElem).addClass('ico-plus');
            } else {
                $(widgetElem).removeClass('ico-plus');
                $(widgetElem).addClass('ico-minus');
            }
            e.preventDefault();
        });
        /*==Sidebar Toggle==*/
        $(".leftside-navigation .sub-menu > a").click(function () {
            var o = ($(this).offset());
            var diff = 80 - o.top;
            if (diff > 0)
                $(".leftside-navigation").scrollTo("-=" + Math.abs(diff), 500);
            else
                $(".leftside-navigation").scrollTo("+=" + Math.abs(diff), 500);
        });
        /*==Sidebar Burger==*/
        $('.sidebar-toggle-box .fa-bars').click(function (e) {

            $(".leftside-navigation").niceScroll({
                cursorcolor: "#1FB5AD",
                cursorborder: "0px solid #fff",
                cursorborderradius: "0px",
                cursorwidth: "3px"
            });

            $('#sidebar').toggleClass('hide-left-bar');
            if ($('#sidebar').hasClass('hide-left-bar')) {
                $(".leftside-navigation").getNiceScroll().hide();
            }
            $(".leftside-navigation").getNiceScroll().show();
            $('#main-content').toggleClass('merge-left');
            e.stopPropagation();
            if ($('#container').hasClass('open-right-panel')) {
                $('#container').removeClass('open-right-panel')
            }
            if ($('.right-sidebar').hasClass('open-right-bar')) {
                $('.right-sidebar').removeClass('open-right-bar')
            }

            if ($('.header').hasClass('merge-header')) {
                $('.header').removeClass('merge-header')
            }


        });

        $('.header,#main-content,#sidebar').click(function () {
            if ($('#container').hasClass('open-right-panel')) {
                $('#container').removeClass('open-right-panel')
            }
            if ($('.right-sidebar').hasClass('open-right-bar')) {
                $('.right-sidebar').removeClass('open-right-bar')
            }

            if ($('.header').hasClass('merge-header')) {
                $('.header').removeClass('merge-header')
            }


        });


        $('.panel .tools .fa').click(function () {
            var el = $(this).parents(".panel").children(".panel-body");
            if ($(this).hasClass("fa-chevron-down")) {
                $(this).removeClass("fa-chevron-down").addClass("fa-chevron-up");
                el.slideUp(200);
            } else {
                $(this).removeClass("fa-chevron-up").addClass("fa-chevron-down");
                el.slideDown(200); }
        });



        $('.panel .tools .fa-times').click(function () {
            $(this).parents(".panel").parent().remove();
        });

        // tool tips

        $('.tooltips').tooltip();

        // popovers

        $('.popovers').popover();

        // Switch
        $('.bootstrap-switch').bootstrapSwitch();

        $('.adv-table table').each(function(){
            var $table = $(this);
            var orderBy = $table.data('orderby') !== undefined ? $table.data('orderby') : 0;
            var orderWay = $table.data('orderway') !== undefined ? $table.data('orderway') : 'ASC';

            $table.dataTable({
                order: [[orderBy, orderWay.toLocaleLowerCase()]],
                aaSorting: [[orderBy, orderWay.toLocaleLowerCase()]],
                iDisplayLength: 25,
                oLanguage: {
                    "sProcessing": "Traitement en cours...",
                    "sSearch": "Rechercher&nbsp;:",
                    "sLengthMenu": "Afficher _MENU_ &eacute;l&eacute;ments",
                    "sInfo": "Affichage de l'&eacute;lement _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
                    "sInfoEmpty": "Affichage de l'&eacute;lement 0 &agrave; 0 sur 0 &eacute;l&eacute;ments",
                    "sInfoFiltered": "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
                    "sInfoPostFix": "",
                    "sLoadingRecords": "Chargement en cours...",
                    "sZeroRecords": "Aucun &eacute;l&eacute;ment &agrave; afficher",
                    "sEmptyTable": "Aucune donnée disponible dans le tableau",
                    "oPaginate": {
                        "sFirst": "Premier",
                        "sPrevious": "Pr&eacute;c&eacute;dent",
                        "sNext": "Suivant",
                        "sLast": "Dernier"
                    },
                    "oAria": {
                        "sSortAscending": ": activer pour trier la colonne par ordre croissant",
                        "sSortDescending": ": activer pour trier la colonne par ordre décroissant"
                    }
                }
            });
        });

        $('.datetime, .datetimepicker').datetimepicker({
            format: 'dd-mm-yyyy hh:ii',
            language: 'fr',
            autoclose: true,
            pickerPosition: 'top-right',
            todayHighlight: true,
            startDate: new Date()
        });

        $('.datepicker').datepicker({
            format: 'dd/mm/yyyy'
        });

        if($('#menu_list')){
            $('#menu_list').nestable().on('change', function(e){
                var list = e.length ? e : $(e.target);
                if (window.JSON) {
                    $('#menu_list').data('order', window.JSON.stringify(list.nestable('serialize')));
                    $('#save-order, #cancel-order').fadeIn();
                } else {
                    alert('Votre navigateur est trop vieux, passer à Google Chrome ;-)');
                }
            });

            $('#save-order').on('click', function(e){
                e.preventDefault();
                if (window.JSON) {
                    $('#spinner-order').fadeIn();
                    var post = {order: window.JSON.parse($('#menu_list').data('order'))};
                    $.get($('#save-order').attr('href'), post, function (data) {
                        $('#spinner-order, #save-order, #cancel-order').fadeOut();
                    });
                } else {
                    alert('Votre navigateur est trop vieux, passer à Google Chrome ;-)');
                }

                return false;
            });
        }
    });



    /*==Agence==*/
    $(document).on('ready', function(){
        var $agence = $('#sharewood_backofficebundle_actu_agence');
        var $note = $('#sharewood_backofficebundle_actu_note');
        var $type = $('#sharewood_backofficebundle_actu_type');
        var $pdfPress = $('#sharewood_backofficebundle_actu_pdfFile');

        $type.on('change', function(){
            var type = parseInt($type.val());
            // Agence
            if([1,4,5].indexOf(type)>-1){
                $agence.closest('.form-group').slideDown();
            } else {
                $agence.closest('.form-group').slideUp();
            }

            // Note
            if([5].indexOf(type)>-1){
                $note.closest('.form-group').slideDown();
                $note.attr('required', true);
            } else {
                $note.closest('.form-group').slideUp();
                $note.attr('required', false);
            }

            // PRESS
            if([2].indexOf(type)>-1){
                $pdfPress.closest('.form-group').slideDown();
                $('#apercu-pdfPressFile').slideDown();
                $pdfPress.attr('required', true);
            } else {
                $pdfPress.closest('.form-group').slideUp();
                $('#apercu-pdfPressFile').slideUp();
                $pdfPress.attr('required', false);
            }
        }).change();
    });

    $(document).on('ready', function(){
        var $table = $('.table-agence-partners');

        $('.add-partner').on('click', function(e){
            e.preventDefault();
            var $btn = $(this);
            var prototype = $btn.data('prototype');

            var index = $('tbody tr', $table).length;
            var newForm = prototype.replace(/__name__/g, index);
            $('tbody').append(newForm);
        });

        $table.on('click','.remove-partner', function(e){
            e.preventDefault();
            if(confirm('Êtes-vous sûr de vouloir supprimer ce partenaire')) {
                $(this).closest('tr').remove();
            }
        });
    });

    $('.select2').select2({
        placeholder: 'Choisissez une option'
    });

})(jQuery);