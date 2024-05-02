{{-- resources/views/products/create.blade.php --}}



    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Create Product') }}</div>

                    <div class="card-body">
                        <form action="{{ url('addproduct') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="file" name="images[]" id="images" class="form-control-file" multiple required>
                            <div class="form-group">
                                <label for="productname">Product Name</label>
                                <input type="text" name="productname" id="productname" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="ownerId">Owner ID</label>
                                <input type="text" name="ownerId" id="ownerId" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="location">Location</label>
                                <input type="text" name="location" id="location" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="category">Category</label>
                                <select name="category" id="category" class="form-control" required>
                                    <option value="">Select Category</option>
                                    <option value="Electronics">Electronics</option>
                                    <option value="Clothing">Clothing</option>
                                    <option value="Books">Books</option>
                                    <!-- Add more options as needed -->
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="fasilitas">Fasilitas</label>
                                <input type="text" name="fasilitas[]" class="form-control" required>
                                <button type="button" class="btn btn-primary mt-2" id="addFasilitas">Add Fasilitas</button>
                            </div>

                            <div id="fasilitasContainer">
                                <!-- Fasilitas fields added dynamically using JavaScript -->
                            </div>

                            <div class="form-group">
                                <label for="roomid">Room ID</label>
                                <input type="text" name="roomid" id="roomid" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="about">About</label>
                                <textarea name="about" id="about" class="form-control" rows="3" required></textarea>
                            </div>



                            <button type="submit" class="btn btn-primary">Create Product</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('addFasilitas').addEventListener('click', function () {
            const container = document.getElementById('fasilitasContainer');
            const input = document.createElement('input');
            input.type = 'text';
            input.name = 'fasilitas[]';
            input.className = 'form-control mt-2';
            input.required = true;
            container.appendChild(input);
        });
    </script>

