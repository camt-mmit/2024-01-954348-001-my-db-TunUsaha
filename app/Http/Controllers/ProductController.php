<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Shop;
use Illuminate\Contracts\View\View as ViewView;
use Psr\Http\Message\ServerRequestInterface;

class ProductController extends SearchableController
{
    protected string $title = 'Products';
    protected int $itemsPerPage = 5;

    protected function getQuery(): Builder
    {
        return Product::orderBy('code');
    }

    protected function getSearchType(): string
    {
        return 'products';
    }

    protected function getItemsPerPage(): int
    {
        return $this->itemsPerPage;
    }

    protected function getListViewName(): string
    {
        return 'products.list';
    }

    public function show(string $productCode): View
    {
        $product = $this->find($productCode);
        return $this->view('products.view', [
            'product' => $product,
        ]);
    }

    public function showCreateForm(): View
    {
        return $this->view('products.create-form');
    }

    public function create(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'code' => 'required|unique:products',
            'name' => 'required',
            'price' => 'required|numeric|min:0',
            'description' => 'required',
        ]);

        Product::create($validatedData);
        return redirect()->route('products.list')->with('success', 'Product created successfully.');
    }

    public function list(Request $request): View
    {
        $search = $this->prepareSearch($request->query());
        $query = $this->search($search)->withCount('shops');
        $products = $query->paginate($this->getItemsPerPage())->appends($search);
        return $this->view($this->getListViewName(), [
            'search' => $search,
            'products' => $products,
        ]);
    }

    public function showShops(Request $request, ShopController $shopController, $productCode)
    {
        $product = Product::where('code', $productCode)->firstOrFail();
        $search = $shopController->prepareSearch($request->query());
        $query = $shopController->filter($product->shops(), $search);

        return view('products.view-shops', [
            'title' => "{$this->title} {$product->code} : Shop",
            'product' => $product,
            'search' => $search,
            'shops' => $query->paginate(5),
        ]);
    }

    // เพิ่มเมธอด showAddShopsForm ตามที่โจทย์ระบุ
    public function showAddShopsForm(
        ServerRequestInterface $request,
        ShopController $shopController,
        string $productCode
    ): View {
        // หา Product จากรหัสที่ให้มา
        $product = $this->find($productCode);

        // Query สำหรับค้นหา Shops ที่ไม่มี Product นี้
        $query = Shop::orderBy('code')
            ->whereDoesntHave('products', function (Builder $innerQuery) use ($product) {
                return $innerQuery->where('code', $product->code);
            });

        // เพิ่มการค้นหาและกรองข้อมูล
        $search = $shopController->prepareSearch($request->getQueryParams());
        $query = $shopController->filter($query, $search);

        // ส่งข้อมูลไปยัง view
        return view('products.add-shops-form', [
            'title' => "{$this->title} {$product->code} : Add Shops",
            'search' => $search,
            'product' => $product,
            'shops' => $query->paginate(5),
        ]);
    }

    public function showEditForm(string $productCode): View
    {
        $product = $this->find($productCode);
        return $this->view('products.edit-form', [
            'product' => $product,
        ]);
    }

    public function update(Request $request, string $productCode): RedirectResponse
    {
        $product = $this->find($productCode);
        $validatedData = $request->validate([
            'name' => 'required',
            'price' => 'required|numeric|min:0',
            'description' => 'required',
        ]);

        $product->update($validatedData);
        return redirect()->route('products.view', $product->code)->with('success', 'Product updated successfully.');
    }

    public function delete(string $productCode): RedirectResponse
    {
        $product = $this->find($productCode);
        $product->delete();
        return redirect()->route('products.list')->with('success', 'Product deleted successfully.');
    }

    protected function view(string $view, array $data = [], string $customTitle = null): View
    {
        $title = $customTitle ?? $this->title;
        if ($view == 'products.list') {
            return view($view, array_merge([
                'title' => $title,
            ], $data));
        } else {
            return view($view, array_merge([
                'title' => "{$title} : " . ucfirst(last(explode('.', $view))),
            ], $data));
        }
    }

    function addShop(ServerRequestInterface $request, string $productCode): RedirectResponse {
        $product = $this->find($productCode);
        $data = $request->getParsedBody();
        // To make sure that no duplicate shop.
        $shop = Shop::whereDoesntHave('products', function(Builder $innerQuery) use ($product) {
        return $innerQuery->where('code', $product->code);
        })->where('code', $data['shop'])->firstOrFail();
        $product->shops()->attach($shop);
        return redirect()->back();
        }

        function removeShop(
            string $productCode,
            string $shopCode
            ): RedirectResponse {
            $product = $this->find($productCode);
            $shop = $product->shops()
            ->where('code', $shopCode)
            ->firstOrFail()
            ;
            $product->shops()->detach($shop);
            return redirect()->back();
            }
}
