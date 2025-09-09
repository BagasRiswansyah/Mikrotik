<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $query = Item::query();

        // Search functionality
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$search}%")
                    ->orWhere('category', 'like', "%{$search}%");
            });
        }

        // Filter by category
        if ($request->has('category') && $request->category != '') {
            $query->where('category', $request->category);
        }

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $items = $query->orderBy('name')->paginate(10);
        $categories = Item::distinct()->pluck('category');

        return view('items.index', compact('items', 'categories'));
    }

    public function create()
    {
        return view('items.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|unique:items,code|max:255',
            'quantity' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'category' => 'required|string|max:255',
            'purchase_date' => 'nullable|date',
        ]);

        $item = Item::create($request->all());
        $item->updateStatus();

        return redirect()->route('items.index')
            ->with('success', 'Item berhasil ditambahkan.');
    }

    public function show(Item $item)
    {
        return view('items.show', compact('item'));
    }

    public function edit(Item $item)
    {
        return view('items.edit', compact('item'));
    }

    public function update(Request $request, Item $item)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255|unique:items,code,' . $item->id,
            'quantity' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'category' => 'required|string|max:255',
            'purchase_date' => 'nullable|date',
        ]);

        $item->update($request->all());
        $item->updateStatus();

        return redirect()->route('items.index')
            ->with('success', 'Item berhasil diupdate.');
    }

    public function destroy(Item $item)
    {
        $item->delete();

        return redirect()->route('items.index')
            ->with('success', 'Item berhasil dihapus.');
    }

    public function dashboard()
    {
        $totalItems = Item::count();
        $totalValue = Item::sum(DB::raw('quantity * price'));
        $lowStockItems = Item::where('status', 'low_stock')->count();
        $outOfStockItems = Item::where('status', 'out_of_stock')->count();

        $recentItems = Item::orderBy('created_at', 'desc')->take(5)->get();

        return view('dashboard', compact(
            'totalItems',
            'totalValue',
            'lowStockItems',
            'outOfStockItems',
            'recentItems'
        ));
    }
}