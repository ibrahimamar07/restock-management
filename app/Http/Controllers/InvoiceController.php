<?php
// app/Http/Controllers/InvoiceController.php
// Nathaniel Lado Hadi Winata - 5026231019
// ibrahim amar alfanani 5026231195

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Cart;
use App\Models\Payment;
use App\Models\UserPaymentType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    /**
     * Get current user ID
     */
    private function getUserId()
    {
        return Auth::id();
    }

    /**
     * Display list of invoices (Incoming & Outgoing)
     */
    public function index()
    {
        $userId = $this->getUserId();

        // Incoming Invoices - Invoice yang diterima user sebagai store owner (harus bayar)
        $incomingInvoices = Invoice::with(['cart.store', 'restocker'])
            ->where('idStoreOwner', $userId)
            ->orderBy('created_at', 'desc')
            ->get();

        // Outgoing Invoices - Invoice yang dibuat user sebagai restocker (nunggu dibayar)
        $outgoingInvoices = Invoice::with(['cart.store', 'storeOwner'])
            ->where('idRestocker', $userId)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('managemystore.invoiceview.viewinvoice', compact('incomingInvoices', 'outgoingInvoices'));
    }

    /**
     * Show specific invoice detail
     * @param Invoice $invoice
     */
    public function show(Invoice $invoice)
    {
        // Authorization check menggunakan Policy
        $this->authorize('view', $invoice);

        // Load relationships
        $invoice->load([
            'cart.cartItems.item',
            'cart.store',
            'restocker',
            'storeOwner',
            'payments.userPaymentType.paymentType'
        ]);

        // Determine if current user is the payer (store owner)
        $isPayer = ($invoice->idStoreOwner == $this->getUserId());

        return view('managemystore.invoiceview.viewinvoicedetail', compact('invoice', 'isPayer'));
    }

    /**
     * Show form to create invoice from cart
     * @param Cart $cart
     */
    public function createInvoiceView(Cart $cart)
    {
        // Only the user who created the cart (restocker) can create invoice
        if ($cart->idUser != $this->getUserId()) {
            abort(403, 'Unauthorized access.');
        }

        // Cart must have status 'converted_to_invoice' and not have invoice yet
        if ($cart->status !== 'converted_to_invoice' || $cart->invoice) {
            abort(403, 'This cart cannot be converted to invoice.');
        }

        // Load cart items with items
        $cart->load(['cartItems.item', 'store.user']);

        return view('managemystore.invoiceview.createinvoice', compact('cart'));
    }

    /**
     * Store new invoice from cart
     * @param Request $request
     * @param Cart $cart
     */
    public function createInvoice(Request $request, Cart $cart)
    {
        // Validate ownership
        if ($cart->idUser != $this->getUserId()) {
            abort(403, 'Unauthorized access.');
        }

        // Validate cart status
        if ($cart->status !== 'converted_to_invoice' || $cart->invoice) {
            return redirect()->back()->with('error', 'This cart cannot be converted to invoice.');
        }

        try {
            DB::beginTransaction();

            // Calculate total amount from cart items
            $totalAmount = $cart->cartItems->sum('subTotal');

            // Create invoice
            $invoice = Invoice::create([
                'idCart' => $cart->idCart,
                'idRestocker' => $this->getUserId(),
                'idStoreOwner' => $cart->store->idUser,
                'invoiceDate' => now(),
                'totalAmount' => $totalAmount,
                'status' => 'unpaid',
            ]);

            DB::commit();

            return redirect()->route('invoices.show', $invoice->idInvoice)
                ->with('success', 'Invoice created successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to create invoice: ' . $e->getMessage());
        }
    }

    /**
     * Show payment form for invoice
     * @param Invoice $invoice
     */
    public function payInvoiceView(Invoice $invoice)
    {
        // Authorization menggunakan Policy
        $this->authorize('pay', $invoice);

        // Load relationships
        $invoice->load(['cart.cartItems.item', 'cart.store', 'restocker']);

        // Get user payment methods
        $paymentMethods = UserPaymentType::with('paymentType')
            ->where('idUser', $this->getUserId())
            ->get();

        return view('managemystore.invoiceview.payinvoice', compact('invoice', 'paymentMethods'));
    }

    /**
     * Process payment for invoice
     * @param Request $request
     * @param Invoice $invoice
     */
    public function processPayment(Request $request, Invoice $invoice)
    {
        // Authorization menggunakan Policy
        $this->authorize('pay', $invoice);

        // Validate request
        $request->validate([
            'idUserPaymentType' => 'required|exists:user_payment_types,idUserPaymentType',
        ]);

        // Verify payment method belongs to user
        $userPaymentType = UserPaymentType::where('idUserPaymentType', $request->idUserPaymentType)
            ->where('idUser', $this->getUserId())
            ->first();

        if (!$userPaymentType) {
            return redirect()->back()->with('error', 'Invalid payment method.');
        }

        try {
            DB::beginTransaction();

            // Create payment record
            $payment = Payment::create([
                'idInvoice' => $invoice->idInvoice,
                'idUserPaymentType' => $request->idUserPaymentType,
                'amount' => $invoice->totalAmount,
                'paymentDate' => now(),
                'status' => 'comfirmed',
            ]);

            // Update invoice status
            $invoice->update([
                'status' => 'paid',
            ]);

            DB::commit();

            return redirect()->route('invoices.paymentConfirmation', $invoice->idInvoice)
                ->with('success', 'Payment successful!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Payment failed: ' . $e->getMessage());
        }
    }

    /**
     * Show payment confirmation page
     * @param Invoice $invoice
     */
    public function paymentConfirmation(Invoice $invoice)
    {
        // Authorization menggunakan Policy
        $this->authorize('view', $invoice);

        // Load relationships
        $invoice->load([
            'cart.cartItems.item',
            'payments.userPaymentType.paymentType',
            'restocker',
            'storeOwner'
        ]);

        return view('managemystore.invoiceview.paymentconfirmation', compact('invoice'));
    }

    /**
     * Cancel invoice (only if unpaid)
     * @param Invoice $invoice
     */
    public function cancelInvoice(Invoice $invoice)
    {
        // Authorization menggunakan Policy
        $this->authorize('cancel', $invoice);

        try {
            $invoice->update(['status' => 'cancelled']);

            return redirect()->route('invoices.index')
                ->with('success', 'Invoice cancelled successfully.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to cancel invoice: ' . $e->getMessage());
        }
    }
}