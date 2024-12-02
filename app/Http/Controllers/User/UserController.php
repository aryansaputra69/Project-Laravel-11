<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('pages.user.index', compact('products'));
    }

    public function fs()
    {
        $products = Product::where('discount', '>', 0)->get(); // Get products with discounts

        return view('pages.user.fs', compact('products'));
    }

    public function detail_product($id)
    {
        $product = Product::findOrFail($id);
        return view('pages.user.detail', compact('product'));
    }

    public function purchase($productId, $userId)
    {
        $product = Product::findOrFail($productId);
        $user = User::findOrFail($userId);

        if ($user->point >= $product->price) {
            $totalPoints = $user->point - $product->price;
            $user->update([
                'point' => $totalPoints,
            ]);

            Alert::success('Berhasil!', 'Produk berhasil dibeli!');
            return redirect()->back();
        } else {
            Alert::error('Gagal!', 'Point anda tidak cukup!');
            return redirect()->back();
        }
    }
}
