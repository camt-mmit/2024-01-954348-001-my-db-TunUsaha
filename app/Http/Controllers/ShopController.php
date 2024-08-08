<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ShopController extends SearchableController
{
    protected string $title = 'Shops';
    protected int $itemsPerPage = 4;

    protected function getQuery(): Builder
    {
        return Shop::orderBy('code');
    }

    public function show(string $shop): View
    {
        $shop = $this->find($shop);
        return $this->view('shops.view', [
            'shop' => $shop,
        ]);
    }

    public function showCreateForm(): View
    {
        return $this->view('shops.create-form');
    }

    public function create(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'code' => 'required|unique:shops',
            'name' => 'required',
            'owner' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'address' => 'required',
        ]);

        Shop::create($validatedData);
        return redirect()->route('shops.list')->with('success', 'Shop created successfully.');
    }

    public function list(Request $request, string $title = 'Shops'): View
    {
        $search = $this->prepareSearch($request->query());
        $query = $this->search($search);

        $shops = $query->paginate($this->itemsPerPage)->appends($search);

        return $this->view('shops.list', [
            'search' => $search,
            'shops' => $shops,
        ], $title);
    }

    public function showEditForm(string $shop): View
    {
        $shop = $this->find($shop);
        return $this->view('shops.edit-form', [
            'shop' => $shop,
        ]);
    }

    public function update(Request $request, string $shopCode): RedirectResponse
    {
        $shop = $this->find($shopCode);

        $validatedData = $request->validate([
            'name' => 'required',
            'owner' => 'required',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'address' => 'required',
        ]);

        $shop->update($validatedData);

        return redirect()->route('shops.view', $shop->code)->with('success', 'Shop updated successfully.');
    }

    public function delete(string $shop): RedirectResponse
    {
        $shop = $this->find($shop);
        $shop->delete();
        return redirect()->route('shops.list')->with('success', 'Shop deleted successfully.');
    }

    protected function view(string $view, array $data = [], string $customTitle = null): View
    {
        $title = $customTitle ?? $this->title;
        return view($view, array_merge([
            'title' => "{$title} : " . ucfirst(last(explode('.', $view))),
        ], $data));
    }
}
