<div class="modal-content" style="border-radius:0px;height:100% !important">
    <div class="modal-body">
        <form id="search-form" name="search-form" action="{{url('product-search-result')}}" method="POST" enctype="multipart/form-data" data-parsley-validate="">
            @csrf
            <div class="">
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text pl-1 pr-2 bg-white border-0">
                                <i class="fe fe-search fs-20 font-weight-semibold text-dark"></i>
                            </div><!-- input-group-text -->
                        </div><!-- input-group-prepend -->
                        <input id="search-input" class="form-control border-0 px-2" name="keyword" placeholder="Masukkan Kata Kunci Pencarian" type="text" autocomplete="off" style="background:#f5f5f5">
                        <button aria-label="Close" class="close px-1" data-dismiss="modal" type="button"><span aria-hidden="true"><i class="fe fe-x" style="line-height:36px"></i></span></button>
                    </div>
                </div>
            </div>
            
            <div id="search-history-container">
                <h5 class="mt-4 mb-3">Terakhir dicari</h5>
                <div id="history-list">
                    <!-- History items will be injected here -->
                    <p class="text-muted fs-13 italic">Belum ada riwayat pencarian</p>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function() {
        const historyKey = 'product_search_history';
        const maxHistory = 10;
        
        // Function to load and render history
        function renderHistory() {
            const history = JSON.parse(localStorage.getItem(historyKey)) || [];
            const container = $('#history-list');
            
            if (history.length > 0) {
                container.empty();
                history.forEach(function(item) {
                    const html = `
                        <a href="#" class="d-flex py-2 border-top history-item" data-keyword="${item}">
                            <i class="fe fe-search text-muted fs-16 mr-2"></i>
                            <h6 class="mb-1 text-muted">${item}</h6>
                        </a>
                    `;
                    container.append(html);
                });
            }
        }

        // Initial render
        renderHistory();

        // Handle history item click
        $(document).off('click', '.history-item').on('click', '.history-item', function(e) {
            e.preventDefault();
            const keyword = $(this).data('keyword');
            $('#search-input').val(keyword);
            $('#search-form').submit();
        });

        // Handle form submit to save history
        $('#search-form').on('submit', function() {
            const keyword = $('#search-input').val().trim();
            if (keyword) {
                let history = JSON.parse(localStorage.getItem(historyKey)) || [];
                
                // Remove if already exists (to move to top)
                history = history.filter(item => item.toLowerCase() !== keyword.toLowerCase());
                
                // Add to beginning
                history.unshift(keyword);
                
                // Limit to maxHistory
                if (history.length > maxHistory) {
                    history = history.slice(0, maxHistory);
                }
                
                localStorage.setItem(historyKey, JSON.stringify(history));
            }
        });

        // Focus input when modal opens (if applicable)
        setTimeout(function() {
            $('#search-input').focus();
        }, 500);
    });
</script>