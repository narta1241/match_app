<?php 

namespace App\Notifications; 

use Illuminate\Bus\Queueable; 
use Illuminate\Notifications\Notification; 
use Illuminate\Contracts\Queue\ShouldQueue; 
use Illuminate\Notifications\Messages\MailMessage;
use \Roerjo\LaravelNotificationsSendGridDriver\Messages\SendGridMailMessage;

class ChangeEmail extends Notification 
{ 
    use Queueable; 
    public $token; 

    //通知内容を生成する情報源を受け取る
    public function __construct($token)
    { 
        $this->token = $token;
    }
    //通知方法を選択
    public function via($notifiable)
    {
        return ['sendgrid'];
    }
    //通知方法に応じた通知内容を返すメソッドを実装する
    // public function toMail($notifiable)
    // {
    //     dd($notifiable);
    //          $mailAddress = getenv('MAIL_FROM_ADDRESS');
    // //     $apiKey = getenv('SENDGRID_API_KEY');
    // //     $sendGrid = new \SendGrid($apiKey);
    //     return (new \SendGrid\Mail\Mail())
    //         ->setSubject('メールアドレス変更') // 件名
    //         ->setFrom($mailAddress)
    //         ->addTo($this->new_email)
    //         ->addContent(
    //         "text/plain",
    //         "<a href='reset'>$this->token</a>"
    //         );
    //         // ->view('emails.changeEmail') // メールテンプレートの指定
    //         // ->action(
    //         //     'メールアドレス変更',
    //         //     url('reset', $this->token) //アクセスするURL
    // //     $response = $sendGrid->send($email);
    // //     if ($response->statusCode() == 202) {
    // //         return back()->with(['success' => "E-mails successfully sent out!!"]);
    // //     }
    // //     return back()->withErrors(json_decode($response->body())->errors);
           
    // }
    /**
 * Get the mail representation of the notification.
 *
 * @param  mixed  $notifiable
 * @return \Roerjo\LaravelNotificationsSendGridDriver\Messages\SendGridMailMessage
 */
    public function toSendGrid($notifiable)
    {
        // dd($notifiable);
        // $accountId = $notifiable->id;
        // $channel = config("channels.{$this->profile->channel}.title");
        $mailAddress = config('mail.address');
        $apiKey = config('services.sendgrid');
        
        return (new SendGridMailMessage)
            ->Subject('メールアドレス変更') // 件名
            ->From($mailAddress)
            // ->addTo($this->new_email)
            // ->action('Notification Action',  "<a href='reset'>$this->token</a>")
            ->view('emails.changeEmail') // メールテンプレートの指定
            ->action(
                'メールアドレス変更',
                url('reset', $this->token) );//アクセスするURL
            $response = $sendGrid->send($email);
            if ($response->statusCode() == 202) {
                return back()->with(['success' => "E-mails successfully sent out!!"]);
            }
            return back()->withErrors(json_decode($response->body())->errors);
            // ->error()
            // ->subject("We Need To Re-Authenticate Your {$channel} Profile")
            // ->line("The token for your {$channel} profile is no longer valid.")
            // ->action(
            //     "Authenticate {$channel}",
            //     url("accounts/{$accountId}/profiles")
            // )
            // ->line('Thank you for helping us help you!');
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}

