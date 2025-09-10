@extends('template.index')

@section('container')

<div class="row g-2 p-0">
    <!-- Card Informasi -->
    <div class="col-lg-3 col-md-6">
        <div class="card overflow-hidden">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="">
                        <h4 class="card-title fw-bolder mb-3">Total Wallet</h4>
                        <h3 class="fw-bolder mb-0">Rp {{ $balance }}</h3>
                    
                    </div>
                    <div class=" bg-primary-subtle rounded-circle p-2 d-flex align-items-center justify-content-center">
                        <i class="ti ti-wallet text-primary fs-7"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="card overflow-hidden">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="">
                        <h4 class="card-title fw-bolder mb-3">Total Pengeluaran</h4>
                        <h3 class="fw-bolder mb-0">Rp {{ $expenseTotal }}</h3>
                        
                    </div>
                    <div class="bg-danger-subtle rounded-circle p-2 d-flex align-items-center justify-content-center">
                        <i class="ti ti-arrow-down-right text-danger fs-7"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="card overflow-hidden">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="">
                        <h4 class="card-title fw-bolder mb-3">Total Pemasukan</h4>
                        <h3 class="fw-bolder mb-0">Rp {{ $incomeTotal }}</h3>
                        
                    </div>
                    <div class="bg-success-subtle rounded-circle p-2 d-flex align-items-center justify-content-center">
                        <i class="ti ti-arrow-up-left text-success fs-7"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="card overflow-hidden">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="">
                        <h4 class="card-title fw-bolder mb-3">Transaksi Bulan Ini</h4>
                        <h3 class="fw-bolder mb-0">{{ $thisMonthTransaction }}</h3>
                    </div>
                    <div class="bg-info-subtle rounded-circle p-2 d-flex align-items-center justify-content-center">
                        <i class="ti ti-repeat text-info fs-7"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
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
                        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addTransactionModal">
                            <i class="ti ti-plus me-2"></i> Add Transaction
                        </button>
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
                            <tr class="{{ $transaction->category->type == 'expense' ? 'table-danger' : 'table-success' }}">
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
                                        <button class="btn btn-sm btn-info view-details" data-id="{{ $transaction->id }}" data-name="{{ $transaction->user->name }}" data-category="{{ $transaction->category->name }}" data-amount="{{ $transaction->amount }}" data-desc="{{ $transaction->description }}" data-date="{{ $transaction->transaction_date }}">
                                            <i class="ti ti-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-warning" 
                                                data-id="{{ $transaction->id }}"
                                                data-user-id="{{ $transaction->user_id }}"
                                                data-wallet-id="{{ $transaction->wallet_id }}"
                                                data-category-id="{{ $transaction->category_id }}"
                                                data-type="{{ $transaction->category->type }}"
                                                data-amount="{{ $transaction->amount }}"
                                                data-date="{{ $transaction->transaction_date }}"
                                                data-desc="{{ $transaction->description }}">
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

{{-- Transaction Modal --}}
<div class="modal fade" id="addTransactionModal" tabindex="-1" aria-labelledby="addTransactionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addTransactionModalLabel">Tambah Transaksi Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addTransactionForm" method="POST"  action="{{ route('flowcash.store') }}">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="user_id" class="form-label">Pengguna <span class="text-danger">*</span></label>
                            <select class="form-select" id="user_id" name="user_id" required>
                                <option value="">Pilih Pengguna</option>
                                @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }} - {{ $user->email }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="wallet_id" class="form-label">Wallet <span class="text-danger">*</span></label>
                            <select class="form-select" id="wallet_id" name="wallet_id" required>
                                <option value="">Pilih Wallet</option>
                                @foreach($wallets as $wallet)
                                <option value="{{ $wallet->id }}">{{ $wallet->name }} - Rp {{ number_format($wallet->balance, 0, ',', '.') }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="category_id" class="form-label">Kategori</label>
                            <select class="form-select" id="category_id" name="category_id">
                                <option value="">Pilih Kategori (Opsional)</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}" data-type="{{ $category->type }}">{{ $category->name }} ({{ $category->type }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="transaction_type" class="form-label">Tipe Transaksi <span class="text-danger">*</span></label>
                            <select class="form-select" id="transaction_type"  required>
                                <option value="income">Pemasukan</option>
                                <option value="expense">Pengeluaran</option>
                                <option value="transfer">Transfer</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="amount" class="form-label">Jumlah <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control" id="amount" name="amount" min="0" step="100" placeholder="0" required>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="transaction_date" class="form-label">Tanggal Transaksi <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="transaction_date" name="transaction_date" value="{{ date('Y-m-d') }}" required>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="description" name="description" rows="3" placeholder="Tambahkan deskripsi transaksi (opsional)"></textarea>
                    </div>
                    
                    <div class="alert alert-info mt-3">
                        <i class="ti ti-info-circle me-2"></i>
                        <span id="amountInfo">Transaksi pemasukan akan menambah saldo wallet, transaksi pengeluaran akan mengurangi saldo wallet.</span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Transaksi</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Edit Transaction Modal --}}
<div class="modal fade" id="editTransactionModal" tabindex="-1" aria-labelledby="editTransactionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editTransactionModalLabel">Edit Transaksi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editTransactionForm" method="POST">
                @csrf
                @method('PUT')
                
                <div class="modal-body">
                    <input type="hidden" id="edit_id" name="id">
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="edit_user_id" class="form-label">Pengguna <span class="text-danger">*</span></label>
                            <select class="form-select" id="edit_user_id" name="user_id" required>
                                <option value="">Pilih Pengguna</option>
                                @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }} - {{ $user->email }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_wallet_id" class="form-label">Wallet <span class="text-danger">*</span></label>
                            <select class="form-select" id="edit_wallet_id" name="wallet_id" required>
                                <option value="">Pilih Wallet</option>
                                @foreach($wallets as $wallet)
                                <option value="{{ $wallet->id }}">{{ $wallet->name }} - Rp {{ number_format($wallet->balance, 0, ',', '.') }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="edit_category_id" class="form-label">Kategori</label>
                            <select class="form-select" id="edit_category_id" name="category_id">
                                <option value="">Pilih Kategori (Opsional)</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}" data-type="{{ $category->type }}">{{ $category->name }} ({{ $category->type }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_transaction_type" class="form-label">Tipe Transaksi</label>
                            <select class="form-select" id="edit_transaction_type">
                                <option value="income">Pemasukan</option>
                                <option value="expense">Pengeluaran</option>
                                <option value="transfer">Transfer</option>
                            </select>
                            <input type="hidden" id="edit_type">
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="edit_amount" class="form-label">Jumlah <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control" id="edit_amount" name="amount" step="100" placeholder="0" required>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="edit_transaction_date" class="form-label">Tanggal Transaksi <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="edit_transaction_date" name="transaction_date" required>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="edit_description" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="edit_description" name="description" rows="3" placeholder="Tambahkan deskripsi transaksi (opsional)"></textarea>
                    </div>
                    
                    <div class="alert alert-info mt-3">
                        <i class="ti ti-info-circle me-2"></i>
                        <span id="edit_amountInfo">Transaksi pemasukan akan menambah saldo wallet, transaksi pengeluaran akan mengurangi saldo wallet.</span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Update Transaksi</button>
                </div>
            </form>
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
        #addTransactionModal .modal-dialog {
        max-width: 600px;
    }
    #addTransactionModal .input-group-text {
        background-color: #f8f9fa;
    }
</style>

<script>
    function openEditModal(transactionId) {
        // Ambil data transaksi dari server (dalam implementasi nyata)
        // Untuk contoh, kita akan menggunakan data dari atribut data-* pada tombol
        const button = document.querySelector(`.btn-warning[data-id="${transactionId}"]`);
        console.log(transactionId);
        if (!button) return;
        
        // Isi form dengan data transaksi
        document.getElementById('edit_id').value = transactionId;
        document.getElementById('edit_user_id').value = button.getAttribute('data-user-id');
        document.getElementById('edit_wallet_id').value = button.getAttribute('data-wallet-id');
        document.getElementById('edit_category_id').value = button.getAttribute('data-category-id');
        document.getElementById('edit_transaction_type').value = button.getAttribute('data-type');
        document.getElementById('edit_type').value = button.getAttribute('data-type');
        document.getElementById('edit_amount').value = button.getAttribute('data-amount');
        document.getElementById('edit_transaction_date').value = button.getAttribute('data-date');
        document.getElementById('edit_description').value = button.getAttribute('data-desc') || '';
        
        // Update info berdasarkan tipe transaksi
        updateEditAmountInfo();
        
        // Set action form
        document.getElementById('editTransactionForm').action = `/flowcash/${transactionId}`;
        
        // Buka modal
        $('#editTransactionModal').modal('show');
    }

    // Update info untuk modal edit
    function updateEditAmountInfo() {
        const type = document.getElementById('edit_transaction_type').value;
        const amountInfo = document.getElementById('edit_amountInfo');
        
        if (type === 'income') {
            amountInfo.textContent = 'Transaksi pemasukan akan menambah saldo wallet.';
        } else if (type === 'expense') {
            amountInfo.textContent = 'Transaksi pengeluaran akan mengurangi saldo wallet.';
        } else {
            amountInfo.textContent = 'Transfer akan memindahkan saldo antar wallet.';
        }
    }
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
                const name = this.getAttribute('data-name');
                const category = this.getAttribute('data-category');
                const amount = this.getAttribute('data-amount');
                const desc = this.getAttribute('data-desc');
                const date = this.getAttribute('data-date')
                
                // Dalam implementasi nyata, ini akan mengambil data dari server
                // Untuk contoh, kita akan menggunakan data dummy
                const transactionDetails = `
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Pengguna:</strong> ${name}</p>
                            <p><strong>Kategori:</strong> ${category}</p>
                            <p><strong>Jumlah:</strong> Rp ${amount}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Tanggal:</strong> ${date}</p>
                            <p><strong>Status:</strong> <span class="badge bg-success">Selesai</span></p>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <p><strong>Deskripsi:</strong> ${desc}</p>
                        </div>
                    </div>
                `;
                
                document.getElementById('transactionDetails').innerHTML = transactionDetails;
                $('#detailModal').modal('show');
            });
        });

        // Update info berdasarkan tipe transaksi
        const transactionType = document.getElementById('transaction_type');
        const amountInfo = document.getElementById('amountInfo');
        
        function updateAmountInfo() {
            const type = transactionType.value;
            if (type === 'income') {
                amountInfo.textContent = 'Transaksi pemasukan akan menambah saldo wallet.';
            } else if (type === 'expense') {
                amountInfo.textContent = 'Transaksi pengeluaran akan mengurangi saldo wallet.';
            } else {
                amountInfo.textContent = 'Transfer akan memindahkan saldo antar wallet.';
            }
        }
        
        transactionType.addEventListener('change', updateAmountInfo);
        updateAmountInfo();
        
        // Auto-select kategori type berdasarkan tipe transaksi
        transactionType.addEventListener('change', function() {
            const type = this.value;
            const categoryOptions = document.querySelectorAll('#category_id option');
            
            categoryOptions.forEach(option => {
                if (option.value === '') return;
                
                if (type === 'transfer') {
                    // Untuk transfer, sembunyikan semua kategori biasa
                    option.style.display = 'none';
                } else {
                    // Untuk income/expense, tampilkan hanya kategori dengan type yang sesuai
                    const categoryType = option.getAttribute('data-type');
                    if (categoryType === type) {
                        option.style.display = 'block';
                    } else {
                        option.style.display = 'none';
                    }
                }
            });
            
            // Reset kategori jika tidak sesuai
            const selectedCategory = document.getElementById('category_id');
            if (type === 'transfer' && selectedCategory.value !== '') {
                selectedCategory.value = '';
            } else if (type !== 'transfer' && selectedCategory.value !== '') {
                const selectedOption = selectedCategory.options[selectedCategory.selectedIndex];
                const categoryType = selectedOption.getAttribute('data-type');
                if (categoryType !== type) {
                    selectedCategory.value = '';
                }
            }
        });
        
        // Trigger change event saat modal dibuka
        document.getElementById('addTransactionModal').addEventListener('show.bs.modal', function() {
            transactionType.dispatchEvent(new Event('change'));
        });
        
        // Validasi form
        document.getElementById('addTransactionForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Validasi sederhana
            const amount = document.getElementById('amount').value;
            if (amount <= 0) {
                alert('Jumlah transaksi harus lebih dari 0');
                return;
            }
            
            // Submit form jika valid
            this.submit();
        });
        
            // Format input amount
            document.getElementById('amount').addEventListener('input', function() {
                if (this.value < 0) this.value = 0;
            });

                document.querySelectorAll('.btn-warning').forEach(button => {
            button.addEventListener('click', function() {
                const transactionId = this.getAttribute('data-id');
                openEditModal(transactionId);
            });
        });
    
        // Validasi form edit
        document.getElementById('editTransactionForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Validasi sederhana
            const amount = document.getElementById('edit_amount').value;
            if (amount <= 0) {
                alert('Jumlah transaksi harus lebih dari 0');
                return;
            }
            
            // Submit form jika valid
            this.submit();
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