<?php
   
namespace App\Notifications;
   
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
   
class ERPNotification extends Notification
{
    use Queueable;
  
    private $product;
   
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($product)
    {
        //print_r($details);die;
        $this->product = $product;
    }
   
    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        //echo '<pre>';print_r($notifiable);die;
        return ['database'];
    }
   
    
    /*public function toMail($notifiable)
    {
        //echo $notifiable;die;
        return (new MailMessage)
                    ->greeting($this->details['greeting'])
                    ->line($this->details['body'])
                    ->action($this->details['actionText'], $this->details['actionURL'])
                    ->line($this->details['thanks']);
    }*/
  
  
    public function toDatabase($notifiable)
    {
        // echo $notifiable;die;
        return [
            'product' => $this->product
        ];
    }
}