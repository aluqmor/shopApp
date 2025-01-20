<form action="{{ route('sales.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <label for="product">Product Name</label>
    <input type="text" name="product" required>
    
    <label for="category_id">Category</label>
    <select name="category_id" required>
        @foreach($categories as $category)
            <option value="{{ $category->id }}">{{ $category->name }}</option>
        @endforeach
    </select>
    
    <label for="price">Price</label>
    <input type="number" name="price" required>
    
    <label for="description">Description</label>
    <textarea name="description"></textarea>
    
    <label for="images">Images (max {{ $maxFiles }}):</label>
    <input type="file" name="images[]" multiple required>
    
    <button type="submit">Submit</button>
</form>