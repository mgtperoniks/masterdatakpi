import Handsontable from 'handsontable';
import 'handsontable/dist/handsontable.full.min.css';
import Swal from 'sweetalert2';

export function initializeHeatNumberImport() {
    const container = document.getElementById('grid-container');
    const saveBtn = document.getElementById('saveBtn');

    if (!container || !saveBtn) return; // Not on the import page

    console.log("Initializing Handsontable..."); // Debug

    // Initial 30 Empty Rows
    const data = Array.from({ length: 30 }, () => ['', '', '', '', '', '', '']);

    const hot = new Handsontable(container, {
        data: data,
        rowHeaders: true,
        colHeaders: ['HEAT NUMBER', 'ITEM CODE', 'COR QTY', 'KODE PROD', 'SIZE', 'CUSTOMER', 'LINE'],
        height: '100%',
        width: '100%',
        licenseKey: 'non-commercial-and-evaluation',
        stretchH: 'last',
        colWidths: [120, 200, 60, 80, 70, 100, 80],
        columns: [
            { data: 0, placeholder: 'HN-2024-X' },      // Heat Number
            { data: 1, placeholder: '1.002.3' },        // Item Code
            { data: 2, type: 'numeric' },               // Cor Qty
            { data: 3, placeholder: 'C01' },            // Kode Produksi
            { data: 4, placeholder: '1/2"' },           // Size
            { data: 5, placeholder: 'ABC' },            // Customer
            { data: 6, placeholder: 'L-001' },          // Line
        ],
        contextMenu: true,
        autoWrapRow: true,
        autoWrapCol: true,
        minSpareRows: 5,
    });

    saveBtn.onclick = async () => {
        const tableData = hot.getData();
        const payload = [];

        // Clean and prepare data
        tableData.forEach(row => {
            if (row[0] && row[1]) {
                payload.push({
                    heat_number: row[0],
                    item_code: row[1],
                    cor_qty: row[2],
                    kode_produksi: row[3],
                    size: row[4],
                    customer: row[5],
                    line: row[6]
                });
            }
        });

        if (payload.length === 0) {
            Swal.fire({ icon: 'info', title: 'No Data', text: 'Please enter valid data.', confirmButtonColor: '#2563EB' });
            return;
        }

        const heatDateInput = document.getElementById('heatDateInput');
        const heatDate = heatDateInput ? heatDateInput.value : null;

        if (!heatDate) {
            Swal.fire({ icon: 'warning', title: 'Date Required', text: 'Select Heat Date.', confirmButtonColor: '#2563EB' });
            return;
        }

        const confirm = await Swal.fire({
            icon: 'question',
            title: 'Konfirmasi Tanggal Cor',
            text: `Apakah tanggal upload cor (${heatDate}) sudah sesuai dengan tanggal heat number?`,
            position: 'top',
            showCancelButton: true,
            confirmButtonColor: '#2563EB',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Lanjutkan',
            cancelButtonText: 'Periksa Lagi',
            reverseButtons: true
        });

        if (!confirm.isConfirmed) return;

        // Get Configuration from Data Attributes
        const configDiv = document.getElementById('import-config');
        if (!configDiv) {
            console.error('Missing configuration div #import-config');
            Swal.fire({ icon: 'error', title: 'Config Error', text: 'Page configuration missing.' });
            return;
        }
        const saveUrl = configDiv.dataset.saveUrl;
        const redirectUrl = configDiv.dataset.redirectUrl;
        const csrfTokenMeta = document.querySelector('meta[name="csrf-token"]');
        const csrfToken = csrfTokenMeta ? csrfTokenMeta.getAttribute('content') : '';

        saveBtn.disabled = true;
        saveBtn.innerHTML = '<span class="material-icons animate-spin">sync</span> Saving...';

        try {
            const response = await fetch(saveUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ heat_date: heatDate, data: payload })
            });

            if (!response.ok) {
                const errorText = await response.text();
                // console.error('Server Error:', errorText); // Optional: keep or remove
                throw new Error(`Server returned ${response.status}: ${response.statusText}`);
            }

            const result = await response.json();

            if (result.success) {
                if (result.errors && result.errors.length > 0) {
                    Swal.fire({ icon: 'warning', title: 'Partial Success', text: result.message, confirmButtonColor: '#2563EB' });
                    // Handle error log visibility...
                    document.getElementById('errorLog').style.display = 'block';
                    const errorList = document.getElementById('errorList');
                    errorList.innerHTML = '';
                    result.errors.forEach(err => {
                        const li = document.createElement('li');
                        li.textContent = err;
                        errorList.appendChild(li);
                    });
                } else {
                    Swal.fire({ icon: 'success', title: 'Success', text: result.message, confirmButtonColor: '#2563EB' })
                        .then(() => window.location.href = redirectUrl);
                }
            } else {
                throw new Error(result.message || 'Unknown error');
            }
        } catch (error) {
            console.error(error);
            Swal.fire({
                icon: 'error',
                title: 'Import Error',
                text: error.message || 'Import failed without specific error.',
                confirmButtonColor: '#2563EB'
            });
        } finally {
            saveBtn.disabled = false;
            saveBtn.innerHTML = '<span class="material-icons">cloud_upload</span> Save Records';
        }
    };
}
