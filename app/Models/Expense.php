<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;


    protected $guarded = ['id'];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($payment) {
            $payment->fiscalyear_id = fiscalyear()->id;
            $payment->organization_id = organization()->id;
            $payment->expense_by = auth()->id();
        });

        static::created(function ($expense) {
            if ($expense->bank_id) {
                $expense->bank->decrement('balance', $expense->amount);
            }

        });

        static::updating(function ($expense) {

            if (
                !$expense->isDirty('amount') &&
                !$expense->isDirty('bank_id')
            ) {
                return;
            }

            $oldBankId = $expense->getOriginal('bank_id');
            $oldAmount = $expense->getOriginal('amount');

            if ($oldBankId) {
                \App\Models\Bank::where('id', $oldBankId)
                    ->increment('balance', $oldAmount);
            }
        });

        // AFTER UPDATE → deduct new bank
        static::updated(function ($expense) {
            if ($expense->bank_id) {
                $expense->bank()->decrement('balance', $expense->amount);
            }
        });

        static::deleting(function ($expense) {

            if ($expense->bank_id) {
                $expense->bank()->increment('balance', $expense->amount);
            }
        });

    }

    protected static function rules()
    {
        return [
            'payment_mode_id' => 'required',
            'bank_id' => 'required',
            'expense_category_id' => 'required',
            'title' => 'required',
            'payment_date' => 'required',
            'amount' => 'required',
            'description' => 'nullable',
        ];
    }

    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }

    public function paymentMode()
    {
        return $this->belongsTo(PaymentMode::class);
    }

    public function expenseHead()
    {
        return $this->belongsTo(ExpenseCategory::class,'expense_category_id');
    }

    public function expenseBy()
    {
        return $this->belongsTo(User::class, 'expense_by');
    }
}
