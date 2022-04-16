<?php

namespace App\Jobs;

use App\Models\Products;
use App\Notifications\ProductCreateNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Notification;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessProductCreated implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $product;
    
    public function __construct(Products $product)
    {
        $this->product = $product;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $emails = config("products.email");
        if (!empty($emails)){
            foreach($emails as $email){
                Notification::route('mail' , $email)->notify(new ProductCreateNotification($this->product));
            }
        }
        
    }
}
