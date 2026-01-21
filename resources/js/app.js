import './bootstrap';

import Alpine from 'alpinejs';
import Chart from 'chart.js/auto';
import Swal from 'sweetalert2';
import Handsontable from 'handsontable';
import 'handsontable/dist/handsontable.full.min.css';

import { initializeHeatNumberImport } from './init-handsontable';

window.Alpine = Alpine;
window.Chart = Chart;
window.Swal = Swal;
// window.Handsontable = Handsontable; // Not needed globally anymore

Alpine.start();

// Initialize Handsontable if on the import page
document.addEventListener('DOMContentLoaded', () => {
    initializeHeatNumberImport();
});
