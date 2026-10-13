@props(['product'])

<div class="product-card">
    <div class="product-img-wrap">
        <a href="{{ route('product.show', $product->slug) }}">
            <x-image-box 
                :src="$product->foto_utama" 
                :alt="$product->nama" 
                aspect="4/3" 
                class="product-img"
            />
        </a>
    </div>

    <div class="product-body">
        @if($product->brand)
            <div class="product-brand">{{ $product->brand }}</div>
        @endif

        <h3 class="product-title">
            <a href="{{ route('product.show', $product->slug) }}" style="color: inherit; text-decoration: none;">
                {{ $product->nama }}
            </a>
        </h3>

        <div class="product-meta">
            @if($product->kapasitas_label)
                <div>Kapasitas: <strong>{{ $product->kapasitas_label }}</strong></div>
            @endif
            <div>Tipe: <strong>{{ ucfirst($product->tipe) }}</strong></div>
        </div>

        <a href="{{ $product->getWhatsappInquiryUrl() }}" 
           target="_blank" 
           rel="noopener noreferrer" 
           class="btn btn-primary product-btn-wa">
            Tanya Harga
        </a>
    </div>
</div>
