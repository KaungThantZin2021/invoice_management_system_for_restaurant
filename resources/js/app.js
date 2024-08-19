import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

// import '@coreui/coreui/dist/js/coreui.bundle.min.js';

// Import all of CoreUI's JS
import * as coreui from '@coreui/coreui'

window.coreui = coreui

import { Tooltip, Toast, Popover } from '@coreui/coreui'

// import $ from 'jquery';
// import 'datatables.net-dt';

import Swal from 'sweetalert2';
window.Swal = Swal;

import toastr from 'toastr';
window.toastr = toastr;

toastr.options = {
    "closeButton": true,
    "debug": false,
    "newestOnTop": false,
    "progressBar": true,
    "positionClass": "toast-bottom-right",
    "preventDuplicates": false,
    "onclick": null,
    "showDuration": "300",
    "hideDuration": "1000",
    "timeOut": "5000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
};

