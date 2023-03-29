<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MailController extends Controller
{
    //
    //
    // public function NotifStorePayment($request)
    // {
    //     //dd($request);        
    //     // $moreUsers=array ('samuel.blay@amgs.africa','js2sam@outlook.com');
    //     // $moreUsers=array($request->emailMutuelle,'souscription@amgs.africa');
    //     // ->bcc($moreUsers)
    //     //->cc($moreUsers)
    //     Mail::to($request->email)
    //         ->send(new StoreReversementMail($request));

    //     if (Mail::failures()) {
    //         return response()->json(['email'=>'Echec Désolé! reessayer plus tard']);
    //     }else{
    //         return response()->json(['email' =>'Success! email bien envoyé']);
    //         }
    // }
    
    //public function NotifStoreReversement($request)
    // {
    //     //dd($request);        
    //     // $moreUsers=array ('samuel.blay@amgs.africa','js2sam@outlook.com');
    //     // $moreUsers=array($request->emailMutuelle,'souscription@amgs.africa');
    //     // ->bcc($moreUsers)
    //     //->cc($moreUsers)
    //     Mail::to($request->email)
    //         ->send(new StoreReversementMail($request));

    //     if (Mail::failures()) {
    //         return response()->json(['email'=>'Echec Désolé! reessayer plus tard']);
    //     }else{
    //         return response()->json(['email' =>'Success! email bien envoyé']);
    //         }
    // }
}
