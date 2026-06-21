@extends('layouts.navbar.admin')
@section('content')
    <div class="container mt-4 mb-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4><i class="bi bi-file-earmark-text text-primary"></i> Article Detail</h4>
                <p class="text-muted mb-0">Melihat detail informasi artikel medis.</p>
            </div>
            <a href="/admin/articles" class="btn btn-outline-secondary btn-sm shadow-sm">
                <i class="bi bi-arrow-left"></i> Back to List
            </a>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body p-4">

                <h5 class="mb-3 text-primary font-weight-bold"><i class="bi bi-info-circle"></i> 1. Article Information</h5>
                <hr class="mt-0 mb-3">

                <div class="row">
                    <div class="col-md-12 form-group mb-3">
                        <label for="title" class="font-weight-bold">Article Title</label>
                        <input type="text" class="form-control bg-light" id="title" readonly placeholder="Memuat judul...">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 form-group mb-3">
                        <label for="creator" class="font-weight-bold">Creator / Author</label>
                        <input type="text" class="form-control bg-light" id="creator" readonly
                            placeholder="Memuat penulis...">
                    </div>

                    <div class="col-md-6 form-group mb-3">
                        <label for="article_topic_id" class="font-weight-bold">Article Topic</label>
                        <input type="text" class="form-control bg-light" id="article_topic_id" readonly
                            placeholder="Memuat topik...">
                    </div>
                </div>

                <h5 class="mt-4 mb-3 text-primary font-weight-bold"><i class="bi bi-card-text"></i> 2. Article Content</h5>
                <hr class="mt-0 mb-3">

                <div class="row">
                    <div class="col-md-12 form-group mb-4">
                        <label for="content" class="font-weight-bold">Main Content</label>
                        <textarea class="form-control bg-light" id="content" rows="10" readonly
                            placeholder="Memuat isi artikel..."></textarea>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 form-group mb-3">
                        <label class="font-weight-bold">Article Image</label>

                        <div class="mt-2 mb-3">
                            <img id="image-preview" src="" alt="Preview Artikel" class="img-thumbnail"
                                style="max-height: 350px; display: none;">
                            <span id="image-fallback" class="text-muted fst-italic">Memuat gambar...</span>
                        </div>

                        <input type="text" class="form-control bg-light" id="image-path" readonly
                            placeholder="Memuat path gambar...">
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function () {
            let pathSegments = window.location.pathname.split('/');
            let article_id = pathSegments[pathSegments.length - 2];

            function loadArticleDetail() {
                let title = $('#title');
                let creator = $('#creator');
                let article_topic_id = $('#article_topic_id');
                let content = $('#content');
                let image = $('#image-preview')
                let image_fallback = $('#image-fallback');
                let image_path = $('#image-path');

                $.ajax({
                    url: `/api/articles/${article_id}/detail`,
                    method: 'GET',
                    success: function (response) {
                        if (response.success) {
                            let articleData = response.article;
                                                              
                            title.val(articleData.title);
                            creator.val(articleData.creator);
                                                        
                            let topicName = articleData.topic ? articleData.topic.name : articleData.article_topic_id;
                            article_topic_id.val(topicName);
                            
                            content.val(articleData.content);
                            image_path.val(articleData.image);

                            // image from url/storage
                            let imageUrl = articleData.image;
                            if (imageUrl && !imageUrl.startsWith('http')) {
                                imageUrl = '/storage/' + imageUrl;
                            }
                            
                            //show image & hide fallback text
                            image.attr('src', imageUrl).show();
                            image_fallback.hide();
                        }
                    },
                    error: function () {

                    }
                })
            }
            loadArticleDetail()
        })
    </script>
@endsection