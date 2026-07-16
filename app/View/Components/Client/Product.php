<?php

namespace App\View\Components\Client;

use Illuminate\View\Component;
use App\Models\Product as ProductModel;

class Product extends Component
{
    public ProductModel $product;
    public ?string $badge;

    /**
     * Create a new component instance.
     */
    public function __construct(ProductModel $product, ?string $badge = null)
    {
        $this->product = $product;
        $this->badge = $badge;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('components.client.product');
    }
}
