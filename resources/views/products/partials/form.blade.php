<div class="form-group mb-3">
    <label for="name">Name</label>
    <input type="text" name="name" id="name"
           class="form-control @error('name') is-invalid @enderror"
           value="{{ old('name', $product->name ?? '') }}">
    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="form-group mb-3">
    <label for="price">Price</label>
    <input type="number" name="price" id="price"
           class="form-control @error('price') is-invalid @enderror"
           value="{{ old('price', $product->price ?? '') }}">
    @error('price') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="form-group mb-3">
    <label for="description">Description</label>
    <textarea name="description" id="description" rows="4"
              class="form-control @error('description') is-invalid @enderror">{{ old('description', $product->description ?? '') }}</textarea>
    @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="form-group mb-3">
    <label for="image">Image</label>
    <input type="file" name="image" id="image"
           class="form-control @error('image') is-invalid @enderror">
    @if(isset($product->image) && $product->image)
        <div class="mt-2">
            <img src="{{ asset('storage/' . $product->image) }}" alt="" width="120">
        </div>
    @endif
    @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

