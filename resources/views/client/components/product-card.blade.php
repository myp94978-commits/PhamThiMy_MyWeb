{{-- Component Hiển Thị Sản Phẩm --}}
<div class="col-md-6 col-lg-3">
    <div class="card product-card h-100 shadow-sm hover-shadow">
        <div class="product-image-wrapper position-relative overflow-hidden">
            @php
                $imagePath = $product->primary_image ?? null;
                $imageUrl = null;

                if (!empty($imagePath)) {
                    if (Str::startsWith($imagePath, ['http://', 'https://'])) {
                        $imageUrl = $imagePath;
                    } elseif (file_exists(public_path('images/' . $imagePath))) {
                        $imageUrl = asset('images/' . $imagePath);
                    } elseif (file_exists(storage_path('app/public/' . $imagePath))) {
                        $imageUrl = asset('storage/' . $imagePath);
                    }
                }

                if (empty($imageUrl)) {
                    $slugBase = 'images/' . Str::slug($product->name, '-');
                    foreach (['jpg', 'png', 'webp'] as $ext) {
                        $slugImagePath = "$slugBase.$ext";
                        if (file_exists(public_path($slugImagePath))) {
                            $imageUrl = asset($slugImagePath);
                            break;
                        }
                    }
                }

                if (empty($imageUrl)) {
                    $imageUrl = asset('images/default.png');
                }
            @endphp

            <img src="{{ $imageUrl }}" 
                 class="card-img-top product-image" alt="{{ $product->name }}"
                 style="height: 250px; object-fit: cover;">
            
            {{-- Badge Discount --}}
            @if(isset($product->discount) && $product->discount > 0)
                <span class="badge bg-danger position-absolute top-0 end-0 m-2 px-2 py-1">
                    -{{ $product->discount }}%
                </span>
            @endif
            
            {{-- Badge Status --}}
            @if(isset($badge))
                <span class="badge bg-info position-absolute top-0 start-0 m-2 px-2 py-1">
                    {{ $badge }}
                </span>
            @endif
        </div>
        
        <div class="card-body d-flex flex-column">
            {{-- Category & Brand --}}
            <small class="text-muted d-block mb-2">
                {{ $product->category?->name ?? 'N/A' }} 
                @if($product->brand)
                    | {{ $product->brand?->name }}
                @endif
            </small>
            
            {{-- Product Name --}}
            <h5 class="card-title text-truncate mb-2" title="{{ $product->name }}">
                {{ $product->name }}
            </h5>
            
            {{-- Rating --}}
            <div class="mb-2">
                <small>
                    @php
                        $rating = $product->rating ?? 0;
                        $fullStars = floor($rating);
                        $halfStar = ($rating - $fullStars) >= 0.5 ? 1 : 0;
                    @endphp
                    
                    @for($i = 0; $i < 5; $i++)
                        @if($i < $fullStars)
                            <i class="bi bi-star-fill text-warning"></i>
                        @elseif($i == $fullStars && $halfStar)
                            <i class="bi bi-star-half text-warning"></i>
                        @else
                            <i class="bi bi-star text-warning"></i>
                        @endif
                    @endfor
                    <span class="ms-1">({{ round($rating, 1) }})</span>
                </small>
            </div>
            
            {{-- Price --}}
            <div class="mb-3">
                @if(isset($product->original_price) && $product->original_price > $product->price)
                    <h6 class="text-primary fw-bold mb-1">
                        {{ number_format($product->price, 0, ',', '.') }}₫
                    </h6>
                    <small class="text-muted text-decoration-line-through">
                        {{ number_format($product->original_price, 0, ',', '.') }}₫
                    </small>
                @else
                    <h6 class="text-primary fw-bold">
                        {{ number_format($product->price, 0, ',', '.') }}₫
                    </h6>
                @endif
            </div>
            
            {{-- Actions - Flex Grow to Bottom --}}
            <div class="btn-group w-100 mt-auto" role="group">
                <a href="{{ route('product.show', $product->slug) }}" 
                   class="btn btn-outline-primary btn-sm flex-fill"
                   title="Xem chi tiết">
                    <i class="bi bi-eye"></i> <span class="d-none d-md-inline">Xem</span>
                </a>
                <button class="btn btn-outline-success btn-sm flex-fill add-to-cart" 
                        data-product-id="{{ $product->id }}" 
                        data-product-name="{{ $product->name }}"
                        data-product-price="{{ $product->price }}"
                        data-product-image="{{ $imageUrl }}"
                        title="Thêm vào giỏ">
                    <i class="bi bi-cart-plus"></i> <span class="d-none d-md-inline">Thêm</span>
                </button>
            </div>
        </div>
    </div>
</div>
