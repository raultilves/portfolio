$(document).ready(function () {
    $('#categoriaCheck').on('click', function() {
        if ($(this).is(':checked')) {
            $('#categoriasTable').css('display', 'none');
        }
        else {
            $('#categoriasTable').css('display', 'block');
        }
    });

    $('#proyectoCheck').on('click', function() {
        if ($(this).is(':checked')) {
            $('#proyectosTable').css('display', 'none');
        }
        else {
            $('#proyectosTable').css('display', 'block');
        }
    });
});