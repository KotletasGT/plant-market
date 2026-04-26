<div class="d-flex align-items-center position-relative me-3">
    <a href="{{ route('cart') }}" class="d-inline-block position-relative">
        <div class="theme-wrap">
            <div class="theme-icon-wrap">
                <i class="bi-cart-fill me-1"></i>
            </div>
        </div>

        @if ($count > 0)
            <span class="cart-count-badge badge rounded-pill bg-danger text-white">
                {{ $count }}
            </span>
        @endif
    </a>
</div>
