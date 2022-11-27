require('./bootstrap');

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

// Flowbite
import 'flowbite';

const Swal = window.Swal =  require('sweetalert2');