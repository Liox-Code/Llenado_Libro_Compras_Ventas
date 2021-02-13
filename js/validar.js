$(document).ready(function() {
    $(".validar_solo_numeros").on("keypress keyup blur",function (event) {
        $(this).val($(this).val().replace(/[^\d].+/, ""));
        if ((event.which < 48 || event.which > 57)) {
            event.preventDefault();
        }
    });

    $(document).on('keypress keyup blur', '#validar_solo_numeros', function(event)  {
        if (event.which < 48 || event.which > 57) {
            event.preventDefault();
        }
    });

    $(document).on('keypress keyup blur', '#validar_solo_decimales', function(event)  {
        if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
            event.preventDefault();
        }
    });

    $(document).on('keypress keyup blur', '.dato_factura_mod', function(event)  {
        var texto_cantidad_caracteres = $(this).text().length;
        var cantidad_maxima_caracteres = $(this).attr('cantidad_maxima_caracteres');
        if (texto_cantidad_caracteres >= cantidad_maxima_caracteres) {
            event.preventDefault();
        }
    });

    $(document).on('keypress keyup blur', '.dato_Empresa_mod', function(event)  {
        var texto_cantidad_caracteres = $(this).text().length;
        var cantidad_maxima_caracteres = $(this).attr('cantidad_maxima_caracteres');
        if (texto_cantidad_caracteres >= cantidad_maxima_caracteres) {
            event.preventDefault();
        }
    });

});