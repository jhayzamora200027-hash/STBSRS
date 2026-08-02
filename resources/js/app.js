import './bootstrap';
import '../css/app.css';

import Swal from 'sweetalert2';

window.Swal = Swal;

import $ from 'jquery';

window.$ = $;
window.jQuery = $;


$(document).on('click', '.pagination a', function (e) {

    e.preventDefault();

    let url = $(this).attr('href');

    $.ajax({
        url: url,
        type: 'GET',
        success: function (response) {

            let html = $(response).find('#ticketTableContainer').html();

            $('#ticketTableContainer').html(html);

        }
    });

});
