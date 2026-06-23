@extends('layouts.navbar.admin')

@section('content')
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4>Konsultasi Online</h4>
                <p class="text-muted mb-0">Daftar konsultasi pasien Anda</p>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <div id="consultation-container">
                    <div id="loading-indicator" class="text-center py-5">
                        <div class="spinner-border text-primary" role="status"></div>
                        <p class="mt-3 text-muted">Loading...</p>
                    </div>

                    <div class="table-responsive" id="table-wrapper" style="display: none;">
                        <table class="table table-hover table-striped mb-0" id="consultations-table">
                            <thead class="bg-light">
                                <tr>
                                    <th width="5%" class="text-center">Id</th>
                                    <th width="25%">Pasien</th>
                                    <th width="20%">Mulai</th>
                                    <th width="20%">Selesai</th>
                                    <th width="15%" class="text-center">Status</th>
                                    <th width="15%" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        function loadConsultations() {
            let loadingIndicator = $('#loading-indicator');
            let tableWrapper     = $('#table-wrapper');
            let tbody            = $('#consultations-table tbody');
            let container        = $('#consultation-container');

            $.ajax({
                url: '/api/consultations/fetch',
                method: 'GET',
                success: function (response) {
                    if (response.success && response.data.length > 0) {
                        let rows = '';

                        response.data.forEach(function (c) {
                            let statusBadge = c.is_active
                                ? '<span class="badge bg-success">Aktif</span>'
                                : '<span class="badge bg-secondary">Selesai</span>';

                            rows += `
                                <tr id="tr_${c.id}">
                                    <td class="text-center">${c.id}</td>
                                    <td><strong>${c.patient}</strong></td>
                                    <td>${c.start_time ?? '-'}</td>
                                    <td>${c.end_time ?? '-'}</td>
                                    <td class="text-center">${statusBadge}</td>
                                    <td class="text-center">
                                        <a href="${c.chat_url}" class="btn btn-sm btn-primary text-white">
                                            <i class="bi bi-chat-dots"></i> Buka Chat
                                        </a>
                                    </td>
                                </tr>`;
                        });

                        tbody.html(rows);
                        loadingIndicator.hide();
                        tableWrapper.show();
                    } else {
                        container.html('<div class="alert alert-warning m-4 text-center">Belum ada data konsultasi.</div>');
                    }
                },
                error: function () {
                    container.html('<div class="alert alert-danger m-4 text-center">Gagal memuat data konsultasi.</div>');
                }
            });
        }

        loadConsultations();
    });
</script>
@endsection
