<?php

namespace App\Jobs;

use App\Offer;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class RemoveDiscount implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $product_id;
    protected $discount_amount;
    protected $offer_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($product_id, $discount_amount, $offer_id)
    {
        $this->product_id = $product_id;
        $this->discount_amount = $discount_amount;
        $this->offer_id = $offer_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */

public function handle()
{
$offer = Offer::find($this->offer_id);
if ($offer) {
$product_id = $this->product_id;
$discount_amount = $this->discount_amount;
if ($offer->amount_of_sale > 0) {
$offer->amount_of_sale -= $discount_amount;
$offer->save();
if ($offer->amount_of_sale <= 0) {
$offer->delete();
$offer->product->removeDiscountFromProduct($product_id, $discount_amount);
}
} else {
$offer->delete();
$offer->product->removeDiscountFromProduct($product_id, $discount_amount);
}
}
 } }