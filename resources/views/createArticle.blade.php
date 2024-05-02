<!-- resources/views/articles/create.blade.php -->

    <div class="container flex justify-center">
        <div class="row justify-center ">
            <div class="col-md-8">
                <div class="card" style="background-color: #f8f9fa;">
                    <div class="card-header" style="background-color: #007bff; color: white;">
                        <h1 class="mb-0">Create New Article</h1>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('articles.store') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="ab_name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="ab_name" name="ab_name" required>
                            </div>

                            <div class="mb-3">
                                <label for="ab_description" class="form-label">Description</label>
                                <textarea class="form-control" id="ab_description" name="ab_description" rows="3" required></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="ab_price" class="form-label">Price</label>
                                <input type="number" class="form-control" id="ab_price" name="ab_price" required>
                            </div>

                            <div class="mb-3">
                                <label for="ab_image" class="form-label">Image URL</label>
                                <input type="text" class="form-control" id="ab_image" name="ab_image" required>
                            </div>

                            <button type="submit" class="btn btn-primary">Create Article</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
