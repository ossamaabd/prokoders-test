<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\offer;
use Carbon\Carbon;

class RemoveDiscount extends Command
{

    protected $signature = 'discount:remove';

  
    protected $description = 'Remove expired discounts from products';

   
    public function __construct()
    {
        parent::__construct();
    }

    
    public function handle()
    {

$offers = offer::where('date_of_end', '<=', Carbon::now())->get();

        foreach ($offers as $offer) {
            $this->removeDiscountFromProduct($offer->product_id);
        }
    }

   
    public function removeDiscountFromProduct($product_id) {
        $product = Product::find($product_id);
        $offer = offer::where('product_id', $product_id)->first();

        if ($offer) {

            
            $product->price =$product->price *100 /(100-$offer->amount_of_sale) ;
            $product->save();
            $offer->delete();
           // return response()->json(['message' => 'تم حذف الحسم بنجاح.']);
        } else {
          //  return response()->json(['message' => 'لا يوجد حسم على هذا المنتج']);
        }
    }
}