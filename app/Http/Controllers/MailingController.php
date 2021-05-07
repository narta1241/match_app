<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

use SendGrid;

class MailingController extends Controller
{
    public function sendMail($address, $text, $name)
    { 
        $email = new \SendGrid\Mail\Mail();
        $mailAddress = getenv('MAIL_FROM_ADDRESS');
        $email->setFrom($mailAddress);
        $email->setSubject($name."さんからのメッセージ");
        $email->addTo($address);
        $apiKey = getenv('SENDGRID_API_KEY');
        $sendGrid = new \SendGrid($apiKey);
        $email->addContent(
            "text/plain",
            "$text"
        );
        $response = $sendGrid->send($email);
        if ($response->statusCode() == 202) {
            return back()->with(['success' => "E-mails successfully sent out!!"]);
        }
        return back()->withErrors(json_decode($response->body())->errors);
    }
    public function matchMail($address, $id)
    { 
        $email = new \SendGrid\Mail\Mail();
        $mailAddress = getenv('MAIL_FROM_ADDRESS');
        $email->setFrom($mailAddress); 
        $user = User::where('id', $id)->first();
        $email->setSubject($user->name."さんとマッチングしました");
        $email->addTo($address);
        $apiKey = getenv('SENDGRID_API_KEY');
        $sendGrid = new \SendGrid($apiKey);
        $email->addContent(
            "text/plain",
            "$user->name.さんとマッチングしました。メッセージを送ってみましょう。"
        );
        $response = $sendGrid->send($email);
        if ($response->statusCode() == 202) {
            return back()->with(['success' => "E-mails successfully sent out!!"]);
        }
        return back()->withErrors(json_decode($response->body())->errors);
    }
    public function favoriteMail($address, $name)
    {
        $email = new \SendGrid\Mail\Mail();
        $mailAddress = getenv('MAIL_FROM_ADDRESS');
        $email->setFrom($mailAddress);
        $email->setSubject($name."さんにいいねされました");
        $email->addTo($address);
        $apiKey = getenv('SENDGRID_API_KEY');
        $sendGrid = new \SendGrid($apiKey);
        $email->addContent(
            "text/plain",
            "$name.さんにいいねされました。プロフィールを確認してみましょう。"
        );
        $response = $sendGrid->send($email);
        if ($response->statusCode() == 202) {
            return back()->with(['success' => "E-mails successfully sent out!!"]);
        }
        return back()->withErrors(json_decode($response->body())->errors);
    }
    //メールアドレス変更予定地
    public function changeMail($address, $name)
    {
        $email = new \SendGrid\Mail\Mail();
        $mailAddress = getenv('MAIL_FROM_ADDRESS');
        $email->setFrom($mailAddress);
        $email->setSubject($name."さんにいいねされました");
        $email->addTo($address);
        $apiKey = getenv('SENDGRID_API_KEY');
        $sendGrid = new \SendGrid($apiKey);
        $email->addContent(
            "text/plain",
            "$name.さんにいいねされました。プロフィールを確認してみましょう。"
        );
        $response = $sendGrid->send($email);
        if ($response->statusCode() == 202) {
            return back()->with(['success' => "E-mails successfully sent out!!"]);
        }
        return back()->withErrors(json_decode($response->body())->errors);
    }
}
