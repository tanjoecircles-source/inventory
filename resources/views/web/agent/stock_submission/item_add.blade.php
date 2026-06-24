<x-layouts.app>
<x-header-white-3column>
    @slot('back')
    <a href="{{ route('stock-submission-detail', ['app_id' => $submission->id]) }}" class="d-flex align-items-center">
        <i class="fe fe-arrow-left fs-20 text-dark"></i>
    </a>
    @endslot
    @slot('notif')
    <x-notification notifstyle="text-dark"></x-notification>
    @endslot
</x-header-white-3column>

<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-8 mx-auto">
            <div class="row pt-4">
                <div class="col-12">
                    <h4 class="font-weight-bold mb-1">Tambah Item</h4>
                    <p class="text-muted fs-13">Tambah bahan stok untuk pengajuan</p>
                    <div class="alert alert-danger p-2 mb-2">
                        <small><i class="fe fe-info"></i> Pengajuan: {{ $submission->type }} - {{ date('d M Y', strtotime($submission->date)) }}</small>
                    </div>
                </div>
            </div>

            <form id="submissionForm" action="{{ route('stock-submission-item-create', ['app_id' => $submission->id]) }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-12">
                        <div id="items-container">
                            <!-- Item rows will be added here -->
                        </div>

                        <div class="text-center my-3">
                            <button type="button" id="add-item-btn" class="btn btn-dark btn-block">
                                <i class="fe fe-plus"></i> Tambah Item
                            </button>
                        </div>

                        <div class="form-group mt-2">
                            <button type="submit" class="btn btn-primary btn-block">
                                <i class="fe fe-check"></i> Simpan
                            </button>
                        </div>
                    </div>
                </div>
            </form>

            <div class="h-100h"></div>
        </div>
    </div>
</div>

<script>
let itemCount = 0;

function addItemRow() {
    itemCount++;
    const container = document.getElementById('items-container');
    const row = document.createElement('div');
    row.className = 'card mb-3 item-row';
    row.dataset.index = itemCount;
    row.innerHTML = `
        <div class="card-body p-3">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h6 class="mb-0 font-weight-bold">Item #${itemCount}</h6>
                <button type="button" class="btn btn-sm btn-outline-danger remove-item-btn" onclick="removeItem(this)">
                    <i class="fe fe-trash-2"></i>
                </button>
            </div>
            <div class="form-group">
                <label class="small text-muted">Nama Bahan</label>
                <input type="text" name="items[${itemCount}][product_name]" class="form-control" placeholder="Masukkan nama bahan" required>
            </div>
            <div class="form-row">
                <div class="form-group col-6">
                    <label class="small text-muted">Jumlah / Kuantitas</label>
                    <input type="number" name="items[${itemCount}][quantity]" class="form-control" placeholder="Jumlah" min="1" required>
                </div>
                <div class="form-group col-6">
                    <label class="small text-muted">Satuan</label>
                    <input type="text" name="items[${itemCount}][unit]" class="form-control" placeholder="Contoh: Gr, Pcs, Pack" required>
                </div>
            </div>
        </div>
    `;
    container.appendChild(row);
}

function removeItem(btn) {
    const row = btn.closest('.item-row');
    if (document.querySelectorAll('.item-row').length > 1) {
        row.remove();
        renumberItems();
    } else {
        alert('Minimal harus ada 1 item.');
    }
}

function renumberItems() {
    const rows = document.querySelectorAll('.item-row');
    rows.forEach((row, index) => {
        const num = index + 1;
        row.querySelector('h6').textContent = `Item #${num}`;
        const inputs = row.querySelectorAll('input');
        inputs.forEach(el => {
            const name = el.getAttribute('name');
            if (name) {
                const newName = name.replace(/\[\d+\]/, `[${num}]`);
                el.setAttribute('name', newName);
            }
        });
    });
    itemCount = rows.length;
}

document.addEventListener('DOMContentLoaded', function() {
    addItemRow();
});

document.getElementById('add-item-btn').addEventListener('click', addItemRow);

document.getElementById('submissionForm').addEventListener('submit', function(e) {
    const rows = document.querySelectorAll('.item-row');
    if (rows.length === 0) {
        alert('Minimal harus ada 1 item.');
        e.preventDefault();
        return false;
    }

    let valid = true;
    rows.forEach(row => {
        const nameInput = row.querySelector('input[name*="[product_name]"]');
        const qtyInput = row.querySelector('input[name*="[quantity]"]');
        const unitInput = row.querySelector('input[name*="[unit]"]');
        if (!nameInput.value.trim() || !qtyInput.value || parseInt(qtyInput.value) < 1 || !unitInput.value.trim()) {
            valid = false;
        }
    });

    if (!valid) {
        alert('Harap lengkapi semua field item (Nama Bahan, Jumlah, dan Satuan).');
        e.preventDefault();
        return false;
    }
});
</script>

</x-layouts.app>