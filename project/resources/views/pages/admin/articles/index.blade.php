@extends('layouts.navbar.admin')
@section('content')
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4>Articles</h4>
                <p class="text-muted mb-0">Manage Articles</p>
            </div>

            <a href="{{ route('articles.create') }}" class="btn btn-primary shadow-sm">
                <i class="bi bi-plus-circle"></i>
                Add new Article
            </a>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <div id="article-container">
                    <div id="loading-indicator" class="text-center py-5">
                        <div class="spinner-border text-primary" role="status"></div>
                        <p class="mt-3 text-muted">Loading...</p>
                    </div>

                    <div class="table-responsive" id="table-wrapper" style="display: none;">
                        <table class="table table-hover table-striped mb-0" id="articles-table">
                            <thead class="bg-light">
                                <tr>
                                    <th width="5%" class="text-center">Id</th>
                                    <th width="30%">Title</th>
                                    <th width="25%">Creator</th>
                                    <th width="20%">Topic</th>
                                    <th width="20%" class="text-center">Aksi</th>
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
@push('modals')

@endpush
@section('scripts')
    <script>
        $(document).ready(function () {
            function loadArticles() {
                let container = $('#article-container');
                let tbody = $('#articles-table tbody');
                let loadingIndicator = $('#loading-indicator');
                let tableWrapper = $('#table-wrapper');

                $.ajax({
                    url: `/api/admin/articles/fetch`,
                    method: 'GET',
                    success: function (response) {
                        if (response.success && response.data.length > 0) {
                            let articles = response.data;
                            let rowsHtml = '';

                            articles.forEach(article => {

                                let creatorName = article.creator.username || '-';
                                let topicName = article.topic.name || '-';

                                rowsHtml += `
                                                    <tr id="tr_${article.id}">
                                                        <td class="text-center">${article.id}</td>
                                                        <td><strong>${article.title}</strong></td>
                                                        <td>${creatorName}</td>
                                                        <td>${topicName}</td>
                                                        <td class="text-center">
                                                            <a href="/admin/articles/${article.id}/edit" class="btn btn-sm btn-info text-white">Edit</a>
                                                            <button type="button" class="btn btn-sm btn-danger text-white btn-delete" data-id="${article.id}">Delete</button>
                                                        </td>
                                                    </tr>
                                                `;
                            });

                            // 3. Masukkan rakitan baris ke dalam tbody
                            tbody.html(rowsHtml);

                            // 4. Sembunyikan loading, lalu tampilkan tabel
                            loadingIndicator.hide();
                            tableWrapper.show();

                        }
                        else {
                            container.html('<div class="alert alert-warning m-4 text-center">No article data</div>');
                        }
                    },
                    error: function (response) {

                    },
                });
            }
            loadArticles()
        })

    </script>
@endsection