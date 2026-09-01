import './bootstrap';
import '../css/app.css';
import 'bootstrap-icons/font/bootstrap-icons.css';

import Swal from 'sweetalert2';
import DOMPurify from 'dompurify';

window.Swal = Swal;
window.DOMPurify = DOMPurify;

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

            $('#ticketTableContainer').html(DOMPurify.sanitize(html));

        }
    });

});
