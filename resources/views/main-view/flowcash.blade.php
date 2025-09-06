@extends('template.index')

@section('container')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="d-md-flex align-items-center justify-content-between mb-4">
                    <div>
                        <h4 class="card-title">Daftar Transaksi</h4>
                        <p class="card-subtitle">
                            Kelola data transaksi keuangan
                        </p>
                    </div>
                    <div class="d-flex gap-2 mt-3 mt-md-0">
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#filterModal">
                            <i class="ti ti-filter me-2"></i> Filter
                        </button>
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="exportDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="ti ti-download me-2"></i> Export
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="exportDropdown">
                                <li><a class="dropdown-item" href="#">CSV</a></li>
                                <li><a class="dropdown-item" href="#">Excel</a></li>
                                <li><a class="dropdown-item" href="#">PDF</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Filter & Search Section -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Cari transaksi..." id="searchInput">
                            <button class="btn btn-outline-secondary" type="button" id="searchButton">
                                <i class="ti ti-search"></i>
                            </button>
                        </div>
                    </div>
                    <div class="col-md-6 mt-2 mt-md-0">
                        <div class="d-flex flex-wrap gap-2" id="activeFilters">
                            <!-- Filter aktif akan muncul di sini -->
                        </div>
                    </div>
                </div>

                <!-- Table -->
                <div class="table-responsive">
                    <table class="table table-hover" id="transactionsTable">
                        <thead>
                            <tr>
                                <th scope="col" class="sortable" data-sort="user">
                                    Pengguna <i class="ti ti-arrows-sort ms-1"></i>
                                </th>
                                <th scope="col" class="sortable" data-sort="category">
                                    Kategori <i class="ti ti-arrows-sort ms-1"></i>
                                </th>
                                <th scope="col" class="sortable" data-sort="amount">
                                    Jumlah <i class="ti ti-arrows-sort ms-1"></i>
                                </th>
                                <th scope="col" class="sortable" data-sort="description">
                                    Deskripsi <i class="ti ti-arrows-sort ms-1"></i>
                                </th>
                                <th scope="col" class="sortable" data-sort="transaction_date">
                                    Tanggal Transaksi <i class="ti ti-arrows-sort ms-1"></i>
                                </th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($flowcash as $transaction)
                            <tr>
                                <td>
                                    <div class="ms-3">
                                        <h6 class="mb-0 fw-bolder">{{ $transaction->user->name ?? 'Unknown' }}</h6>
                                        <span class="text-muted">{{ $transaction->user->email ?? '' }}</span>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark">{{ $transaction->category->name ?? 'Uncategorized' }}</span>
                                </td>
                                <td class="fw-medium">
                                    Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                                </td>
                                <td>{{ Str::limit($transaction->description, 30) }}</td>
                                <td>{{ \Carbon\Carbon::parse($transaction->transaction_date)->format('d M Y') }}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <button class="btn btn-sm btn-info view-details" data-id="{{ $transaction->id }}">
                                            <i class="ti ti-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-warning">
                                            <i class="ti ti-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger">
                                            <i class="ti ti-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div class="text-muted">
                        Menampilkan {{ $flowcash->firstItem() }} - {{ $flowcash->lastItem() }} dari {{ $flowcash->total() }} hasil
                    </div>
                    <nav>
                        {{ $flowcash->links() }}
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filter Modal -->
<div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="filterModalLabel">Filter Transaksi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="filterForm">
                    <div class="mb-3">
                        <label for="categoryFilter" class="form-label">Kategori</label>
                        <select class="form-select" id="categoryFilter">
                            <option value="">Semua Kategori</option>
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="userFilter" class="form-label">Pengguna</label>
                        <select class="form-select" id="userFilter">
                            <option value="">Semua Pengguna</option>
                            @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="amountRange" class="form-label">Jumlah Transaksi</label>
                        <div class="d-flex align-items-center gap-2">
                            <input type="number" class="form-control" id="minAmount" placeholder="Min">
                            <span>-</span>
                            <input type="number" class="form-control" id="maxAmount" placeholder="Max">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="dateRange" class="form-label">Tanggal Transaksi</label>
                        <div class="d-flex align-items-center gap-2">
                            <input type="date" class="form-control" id="startDate">
                            <span>-</span>
                            <input type="date" class="form-control" id="endDate">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="resetFilters">Reset</button>
                <button type="button" class="btn btn-primary" id="applyFilters">Terapkan Filter</button>
            </div>
        </div>
    </div>
</div>

<!-- Detail Modal -->
<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailModalLabel">Detail Transaksi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="transactionDetails">
                <!-- Detail transaksi akan dimuat di sini -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<style>
    .sortable {
        cursor: pointer;
        user-select: none;
    }
    .sortable.active {
        color: #5d87ff;
    }
    .sortable.active .ti-arrows-sort:before {
        content: "\ea6e";
    }
    .sortable.active.desc .ti-arrows-sort:before {
        content: "\ea66";
    }
    #activeFilters .badge {
        font-size: 0.8rem;
        padding: 0.35rem 0.65rem;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Variables untuk menyimpan state
        let currentSort = {
            column: 'transaction_date',
            direction: 'desc'
        };
        
        // Fungsi untuk mengurutkan tabel
        function sortTable(column, direction) {
            const rows = Array.from(document.querySelectorAll('#transactionsTable tbody tr'));
            
            rows.sort((a, b) => {
                let aValue = a.querySelector(`td:nth-child(${getColumnIndex(column)})`).textContent.trim();
                let bValue = b.querySelector(`td:nth-child(${getColumnIndex(column)})`).textContent.trim();
                
                // Handle khusus untuk kolom amount (angka)
                if (column === 'amount') {
                    aValue = parseInt(aValue.replace(/[^\d]/g, ''));
                    bValue = parseInt(bValue.replace(/[^\d]/g, ''));
                }
                
                // Handle khusus untuk kolom tanggal
                if (column === 'transaction_date') {
                    aValue = new Date(aValue);
                    bValue = new Date(bValue);
                }
                
                if (direction === 'asc') {
                    return aValue > bValue ? 1 : -1;
                } else {
                    return aValue < bValue ? 1 : -1;
                }
            });
            
            // Hapus baris yang ada
            const tbody = document.querySelector('#transactionsTable tbody');
            while (tbody.firstChild) {
                tbody.removeChild(tbody.firstChild);
            }
            
            // Tambahkan baris yang sudah diurutkan
            rows.forEach(row => tbody.appendChild(row));
            
            // Update indicator sort
            document.querySelectorAll('.sortable').forEach(header => {
                header.classList.remove('active', 'asc', 'desc');
            });
            
            const activeHeader = document.querySelector(`.sortable[data-sort="${column}"]`);
            activeHeader.classList.add('active', direction);
        }
        
        function getColumnIndex(columnName) {
            const headers = document.querySelectorAll('#transactionsTable thead th');
            for (let i = 0; i < headers.length; i++) {
                if (headers[i].getAttribute('data-sort') === columnName) {
                    return i + 1;
                }
            }
            return 1;
        }
        
        // Event listener untuk header kolom
        document.querySelectorAll('.sortable').forEach(header => {
            header.addEventListener('click', function() {
                const column = this.getAttribute('data-sort');
                
                if (currentSort.column === column) {
                    currentSort.direction = currentSort.direction === 'asc' ? 'desc' : 'asc';
                } else {
                    currentSort.column = column;
                    currentSort.direction = 'asc';
                }
                
                sortTable(currentSort.column, currentSort.direction);
            });
        });
        
        // Fungsi pencarian
        document.getElementById('searchButton').addEventListener('click', function() {
            performSearch();
        });
        
        document.getElementById('searchInput').addEventListener('keyup', function(e) {
            if (e.key === 'Enter') {
                performSearch();
            }
        });
        
        function performSearch() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const rows = document.querySelectorAll('#transactionsTable tbody tr');
            
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchTerm) ? '' : 'none';
            });
            
            // Tambahkan filter aktif
            updateActiveFilters('search', `Pencarian: ${searchTerm}`);
        }
        
        // Fungsi filter
        document.getElementById('applyFilters').addEventListener('click', function() {
            const category = document.getElementById('categoryFilter').value;
            const user = document.getElementById('userFilter').value;
            const minAmount = document.getElementById('minAmount').value;
            const maxAmount = document.getElementById('maxAmount').value;
            const startDate = document.getElementById('startDate').value;
            const endDate = document.getElementById('endDate').value;
            
            applyFilters(category, user, minAmount, maxAmount, startDate, endDate);
            $('#filterModal').modal('hide');
        });
        
        document.getElementById('resetFilters').addEventListener('click', function() {
            document.getElementById('filterForm').reset();
            clearFilters();
            $('#filterModal').modal('hide');
        });
        
        function applyFilters(category, user, minAmount, maxAmount, startDate, endDate) {
            const rows = document.querySelectorAll('#transactionsTable tbody tr');
            
            rows.forEach(row => {
                let showRow = true;
                
                // Filter kategori
                if (category && row.querySelector('td:nth-child(2)').textContent !== category) {
                    showRow = false;
                }
                
                // Filter user
                if (user) {
                    const userId = row.querySelector('td:first-child').getAttribute('data-user-id');
                    if (userId !== user) {
                        showRow = false;
                    }
                }
                
                // Filter amount
                const amount = parseInt(row.querySelector('td:nth-child(3)').textContent.replace(/[^\d]/g, ''));
                if (minAmount && amount < parseInt(minAmount)) {
                    showRow = false;
                }
                if (maxAmount && amount > parseInt(maxAmount)) {
                    showRow = false;
                }
                
                // Filter tanggal
                const dateText = row.querySelector('td:nth-child(5)').textContent;
                const date = new Date(dateText);
                
                if (startDate) {
                    const filterStartDate = new Date(startDate);
                    if (date < filterStartDate) {
                        showRow = false;
                    }
                }
                
                if (endDate) {
                    const filterEndDate = new Date(endDate);
                    if (date > filterEndDate) {
                        showRow = false;
                    }
                }
                
                row.style.display = showRow ? '' : 'none';
            });
            
            // Update filter aktif
            updateActiveFilters('filters', 'Filter diterapkan');
        }
        
        function clearFilters() {
            const rows = document.querySelectorAll('#transactionsTable tbody tr');
            rows.forEach(row => {
                row.style.display = '';
            });
            
            document.getElementById('activeFilters').innerHTML = '';
        }
        
        function updateActiveFilters(type, text) {
            const filterId = `${type}-${Date.now()}`;
            const badge = document.createElement('span');
            badge.className = 'badge bg-info text-dark';
            badge.innerHTML = `${text} <span class="ms-1 cursor-pointer" onclick="removeFilter('${filterId}')">&times;</span>`;
            badge.id = filterId;
            
            document.getElementById('activeFilters').appendChild(badge);
        }
        
        // Fungsi untuk melihat detail transaksi
        document.querySelectorAll('.view-details').forEach(button => {
            button.addEventListener('click', function() {
                const transactionId = this.getAttribute('data-id');
                
                // Dalam implementasi nyata, ini akan mengambil data dari server
                // Untuk contoh, kita akan menggunakan data dummy
                const transactionDetails = `
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Pengguna:</strong> John Doe</p>
                            <p><strong>Kategori:</strong> Belanja</p>
                            <p><strong>Jumlah:</strong> Rp 500.000</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Tanggal:</strong> 15 Sep 2023</p>
                            <p><strong>Status:</strong> <span class="badge bg-success">Selesai</span></p>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <p><strong>Deskripsi:</strong> Pembelian kebutuhan bulanan di supermarket</p>
                        </div>
                    </div>
                `;
                
                document.getElementById('transactionDetails').innerHTML = transactionDetails;
                $('#detailModal').modal('show');
            });
        });
        
        // Inisialisasi pengurutan default
        sortTable('transaction_date', 'desc');
    });
    
    // Fungsi global untuk menghapus filter
    function removeFilter(id) {
        const filterElement = document.getElementById(id);
        if (filterElement) {
            filterElement.remove();
        }
    }
</script>
@endsection