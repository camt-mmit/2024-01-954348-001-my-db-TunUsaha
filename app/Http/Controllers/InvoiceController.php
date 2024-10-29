namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Product;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function createInvoice(Request $request, Product $product)
    {
        // สร้างใบแจ้งหนี้ใหม่
        $invoice = Invoice::create([
            'product_id' => $product->id,
            'user_id' => auth()->id(),
            'amount' => $product->price,
            'status' => 'pending',
        ]);

        // เปลี่ยนเส้นทางไปยังหน้าที่แสดงใบแจ้งหนี้
        return redirect()->route('invoice.show', $invoice);
    }

    public function show(Invoice $invoice)
    {
        // ตรวจสอบสิทธิ์การเข้าถึงใบแจ้งหนี้ (เฉพาะเจ้าของเท่านั้น)
        if ($invoice->user_id !== auth()->id()) {
            abort(403);
        }

        return view('invoices.show', compact('invoice'));
    }
}