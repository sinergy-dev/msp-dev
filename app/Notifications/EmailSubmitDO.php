<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

use DB;

class EmailSubmitDO extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {

        $lastlead = DB::table('sales_lead_register')
                        ->select('lead_id')
                        ->where('result', 'OPEN')
                        ->orderBy('created_at', 'desc')
                        ->first();

        $lastdo = DB::table('inventory_delivery_msp')
                        ->join('tb_do_msp', 'tb_do_msp.no', '=', 'inventory_delivery_msp.no_do')
                        ->select('tb_do_msp.no_do')
                        ->orderBy('inventory_delivery_msp.updated_at', 'desc')
                        ->first();


        return (new MailMessage)
                    ->line('Delivery Order :'.$lastdo->no_do)
                    ->line('There is a new delivery order is created in the application. To access the Application please click the following button.')
                    ->action('New Delivery Order', url('/inventory/do/msp'))
                    ->line('Thank you for using our application!');

    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
