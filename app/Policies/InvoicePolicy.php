<?php
//ibrahim amar alfanani 5026231195
namespace App\Policies;

use App\Models\Invoice;
use App\Models\User;

class InvoicePolicy
{
    /**
     * Determine if the user can view the invoice.
     */
    public function view(User $user, Invoice $invoice): bool
    {
        // User can view if they are either the restocker or the store owner
        return $invoice->idRestocker === $user->idUser 
            || $invoice->idStoreOwner === $user->idUser;
    }

    /**
     * Determine if the user can pay the invoice.
     */
    public function pay(User $user, Invoice $invoice): bool
    {
        // Only store owner can pay
        return $invoice->idStoreOwner === $user->idUser 
            && $invoice->status === 'unpaid';
    }

    /**
     * Determine if the user can cancel the invoice.
     */
    public function cancel(User $user, Invoice $invoice): bool
    {
        // Both restocker and store owner can cancel if unpaid
        return ($invoice->idRestocker === $user->idUser 
                || $invoice->idStoreOwner === $user->idUser)
            && $invoice->status === 'unpaid';
    }
}