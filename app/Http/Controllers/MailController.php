<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;

class MailController
{
  public function proofOfPayment($invoice, $user)
  {
    $data = [
      'no-reply' => env('MAIL_FROM_ADDRESS'),
      'email'    => env('ADMIN_PRINCIPAL_EMAIL'),
      'user_email' => $user->email,
      'name'    => $user->name,
      'invoice'    => $invoice->invoice_number,
      'company'    => $user->contact,
    ];
    Mail::send(
      'mailpayment',
      ['data' => $data],
      function ($message) use ($data) {
        $message
          ->from($data['no-reply'])
          ->to($data['email'])->subject('Proof of payment available from - ' . $data['name']);
      }
    );
  }

  public function invoiceAvailable($invoiceNumber, $user)
  {
    $data = [
      'no-reply' => env('MAIL_FROM_ADDRESS'),
      'email'    => $user->email,
      'name'    => $user->name,
      'invoice'    => $invoiceNumber,
      'year' =>  date("Y") + 1
    ];
    Mail::send(
      'mailinvoice',
      ['data' => $data],
      function ($message) use ($data) {
        $message
          ->from($data['no-reply'])
          ->to($data['email'])->subject('Hi, '. $data['name'] .' Your invoice is available');
      }
    );
  }

  public function invoicePayed($invoiceNumber, $user)
  {
    $data = [
      'no-reply' => env('MAIL_FROM_ADDRESS'),
      'email'    => $user->email,
      'name'    => $user->name,
      'invoice'    => $invoiceNumber,
    ];
    Mail::send(
      'invoicepayed',
      ['data' => $data],
      function ($message) use ($data) {
        $message
          ->from($data['no-reply'])
          ->to($data['email'])->subject('Hi, '. $data['name'] .' your invoice has been marked as paid');
      }
    );
  }

  public function passwordReset($user)
  {
    $data = [
      'no-reply' => env('MAIL_FROM_ADDRESS'),
      'email'    => $user->email,
      'name'    => $user->name,
    ];
    Mail::send(
      'passwordreseted',
      ['data' => $data],
      function ($message) use ($data) {
        $message
          ->from($data['no-reply'])
          ->to($data['email'])->subject('Hi, '. $data['name'] .' your password has been changed');
      }
    );
  }



}
