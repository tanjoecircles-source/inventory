<x-layouts.app>
<x-header-white-3column>
    @slot('back')
    <x-back backstyle="text-dark" urlback="{{url('tools')}}"></x-back>
    @endslot
    @slot('notif')
    <x-notification notifstyle="text-dark"></x-notification>
    @endslot
</x-header-white-3column>

<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-8 mx-auto">
            <div class="card no-border shadow-none custom-square mt-4 mb-3">
                <div class="card-body px-2 py-3">
                    <h5 class="mb-1 font-weight-bold text-primary">Generate QR Code</h5>
                    <span class="mb-1 text-muted">Buat QR Code dengan teks atau URL kustom</span>
                </div>
            </div>

            <div class="card no-border shadow-sm mb-4">
                <div class="card-body">
                    <form action="{{ url('admin/qrcode/generate') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label class="form-label">Konten QR Code (URL atau Teks)</label>
                            <input type="text" name="content" class="form-control" placeholder="Masukkan URL atau teks di sini..." value="{{ $qr_content }}" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block mt-4">
                            <i class="fe fe-refresh-cw mr-1"></i> Generate QR
                        </button>
                    </form>
                </div>
            </div>

            @if($qr_content)
            <div class="card no-border shadow-sm text-center">
                <div class="card-body py-5">
                    <h6 class="mb-4 font-weight-bold text-dark">Hasil QR Code:</h6>
                    <div class="d-inline-block p-3 bg-white border rounded shadow-sm">
                        {!! QrCode::size(250)->generate($qr_content) !!}
                    </div>
                    <p class="mt-4 text-muted fs-13">"{{ $qr_content }}"</p>
                    
                    <div class="mt-4 d-flex justify-content-center gap-2">
                        <button onclick="window.print()" class="btn btn-outline-dark btn-sm mr-2">
                            <i class="fe fe-printer mr-1"></i> Cetak
                        </button>
                        <button onclick="downloadPNG()" class="btn btn-success btn-sm">
                            <i class="fe fe-download mr-1"></i> Download PNG
                        </button>
                    </div>
                </div>
            </div>
            
            {{-- Hidden canvas for conversion --}}
            <canvas id="qr-canvas" style="display:none;"></canvas>

            <script>
                function downloadPNG() {
                    const svg = document.querySelector('.card-body svg');
                    if (!svg) {
                        alert('QR Code tidak ditemukan');
                        return;
                    }

                    const canvas = document.getElementById('qr-canvas');
                    const ctx = canvas.getContext('2d');
                    const svgData = new XMLSerializer().serializeToString(svg);
                    const img = new Image();
                    const svgBlob = new Blob([svgData], {type: 'image/svg+xml;charset=utf-8'});
                    const url = URL.createObjectURL(svgBlob);

                    img.onload = function() {
                        canvas.width = 1000; // High resolution
                        canvas.height = 1000;
                        ctx.fillStyle = "white";
                        ctx.fillRect(0, 0, canvas.width, canvas.height);
                        ctx.drawImage(img, 0, 0, 1000, 1000);
                        URL.revokeObjectURL(url);
                        
                        const pngUrl = canvas.toDataURL("image/png");
                        const downloadLink = document.createElement("a");
                        downloadLink.href = pngUrl;
                        downloadLink.download = "qrcode-" + Date.now() + ".png";
                        document.body.appendChild(downloadLink);
                        downloadLink.click();
                        document.body.removeChild(downloadLink);
                    };
                    img.src = url;
                }
            </script>
            @endif
        </div>
    </div>
</div>
</x-layouts.app>
