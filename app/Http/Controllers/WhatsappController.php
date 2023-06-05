<?php

namespace App\Http\Controllers;
// define('STDOUT', fopen('php://stdout', 'w'));
use Illuminate\Http\Request;
use Netflie\WhatsAppCloudApi\WebHook;
use Illuminate\Support\Facades\Http;
use App\Models\Thread;
use App\Models\Message;
use App\Models\Member;


use Netflie\WhatsAppCloudApi\WhatsAppCloudApi;
use Netflie\WhatsAppCloudApi\Message\Template\Component;
use Netflie\WhatsAppCloudApi\Message\Media\LinkID;
use Netflie\WhatsAppCloudApi\Message\OptionsList\Row;
use Netflie\WhatsAppCloudApi\Message\OptionsList\Section;
use Netflie\WhatsAppCloudApi\Message\OptionsList\Action;
use response;
use DB;


class WhatsappController extends Controller
  {

    private $fromPhoneNumberId;
    private $accessToken;

 public function help_template_message($mob,$phoneNoId) {

      $response = Http::withHeaders([
        'Authorization' => 'Bearer EAANFgseGzQsBACKyMFQRQxiQ4tjf6kHiUyjikq5WeEFy6orIyRzPf2oubtKmi55NhRJhTojeXZC3ZC9BJbqZBfE0uEmZBCFs4C9fypv9ZA0VVlZAwzm0ZBne85lWLvnzds6sDELZCj0FFW9JZCwA58rP9Ydu0xoriHNstxj5irD4CKWkMrmv2npIKK1ntqVNWxu06mZBNPPAQoj0s01dm3qlzH',
        'Content-Type' => 'application/json',
      ])
      ->post('https://graph.facebook.com/v16.0/'.$phoneNoId.'/messages', [
        'messaging_product' => 'whatsapp',
        'recipient_type' => 'individual',
        'to' => $mob,
        'type' => 'interactive',
        'interactive' => [
            'type' => 'list',
            'header' => [
                'type' => 'text',
                'text' => 'QUERY HANDLING',
            ],
            'body' => [
                'text' => 'OUR WEBSITE LINK',
            ],
            'footer' => [
                'text' => 'ADDRESS MOHALI 8 PHASE',
            ],
            'action' => [
                'button' => 'CHOOSE OPTIONS',
                'sections' => [
                    [
                        'title' => 'QUERY PRODUCT',
                        'rows' => [
                            [
                                'id' => 'help',
                                'title' => 'help!',
                                'description' => 'help',
                            ],
                           
                        ],
                 ],
                    
                ],
            ],
        ],
      ]);
}

public function template_message($mob,$phoneNoId) {

        $response = Http::withHeaders([
          'Authorization' => 'Bearer EAANFgseGzQsBAE5Sosb6ntFkwUNtprxZC0MDjhiygVNIrkobgpDYptwchank8MAZB5uEqxIyfonSP0vjcbH35jWzT1ZAUCsU2C3FYrcdKWRsqduGd5QHcIZA5KoPagU1ZBpRf4gmrgsOEtrfFTWolvEjCy6DBZC0TFLxETCJabTT3aNYZCrU3fIA00QCgMv82GVFVp9xxJOzhW2E3eFsYei',
          'Content-Type' => 'application/json',
        ])
        ->post('https://graph.facebook.com/v16.0/'.$phoneNoId.'/messages', [
          'messaging_product' => 'whatsapp',
          'recipient_type' => 'individual',
          'to' => $mob,
          'type' => 'interactive',
          'interactive' => [
              'type' => 'list',
              'header' => [
                  'type' => 'text',
                  'text' => 'MODICARE',
              ],
              'body' => [
                  'text' => 'MODICARE WEBSITE LINK',
              ],
              'footer' => [
                  'text' => 'MODICARE',
              ],
              'action' => [
                  'button' => 'CHOOSE OPTIONS',
                  'sections' => [
                      [
                          'title' => 'QUERY PRODUCT',
                          'rows' => [
                              [
                                  'id' => 'QUERY_PRODUCT',
                                  'title' => 'QUERY PRODUCT',
                                  'description' => 'MODICARE PRODUCT',
                              ],
                              [
                                  'id' => 'ABOUT_US',
                                  'title' => 'ABOUT US',
                                  'description' => 'MODICARE PRODUCT',
                              ],
                              [
                                'id' => 'PREVIOUS_QUERY',
                                'title' => 'PREVIOUS QUERY',
                                'description' => 'MODICARE PRODUCT',
                            ],
                          ],
                   ],
                      // [
                      //     'title' => 'SECTION_2_PRODUCT',
                      //     'rows' => [
                      //         [
                      //             'id' => 'SECTION_2_ROW_1_ID',
                      //             'title' => 'LAPTOP',
                      //             'description' => 'DELL,LENOVO',
                      //         ],
                      //         [
                      //             'id' => 'SECTION_2_ROW_2_ID',
                      //             'title' => 'DESKTOP',
                      //             'description' => 'NEW GENERATIONS',
                      //         ],
                      //     ],
                      // ],
                  ],
              ],
          ],
        ]);
}


public function get_user_message($data) {
  return $data['entry'][0]['changes'][0]['value']['messages'][0]['text']['body'];
  //return $data['entry'][0]['changes'][0]['value']['messages'][0]['interactive']['list_reply']['title'];


}

public function get_user_reply_message_type($data) {

  return $data['entry'][0]['changes'][0]['value']['messages'][0]['type'];

  //return $data['entry'][0]['changes'][0]['value']['messages'][0]['']['type'];
  //return $data['entry'][0]['changes'][0]['value']['messages'][0]['interactive']['type'];

}

public function get_user_reply_message($data) {

  return $data['entry'][0]['changes'][0]['value']['messages'][0]['interactive']['list_reply']['title'];

}



public function get_account_id($data) {
  return $data['entry'][0]['id'];
}

public function get_phone_no_id($data) {
  return $data['entry'][0]['changes'][0]['value']['metadata']['phone_number_id'];
}

public function get_receipient_id($data) {
  return $data['entry'][0]['changes'][0]['value']['statuses'][0]['recipient_id'];
}

public function get_status($data) {

    if (isset($data["entry"][0]["changes"][0]["value"]["statuses"][0])) {
        return $data["entry"][0]["changes"][0]["value"]["statuses"][0]["status"];
    }

}

public function preprocess($data) {
  return $data["entry"][0]["changes"][0]["value"];
}
public function get_mobile($data) {
  $data = $this->preprocess($data);
  if (isset($data["contacts"])) {
      return $data["contacts"][0]["wa_id"];
  }
}

public function get_name($data) {
  $contact = $this->preprocess($data);
  if ($contact) {
      return $contact["contacts"][0]["profile"]["name"];
  }
}

public function webhook(Request $request)
   {
      try{
           $verifyToken ='hello';
           if ($request->isMethod('GET')) {
             if ($request->query('hub.verify_token') === $verifyToken) {
                //\Log::info('inside');
                return response($request->query('hub.challenge'), 200)
                    ->header('Content-Type', 'text/plain');
            }
            // else{
            //     return 'Invalid verification token';

            // }
 
            //   $webhook = new WebHook();
            //    return $webhook->verify($_GET, $verifyToken);

       }
        $data = json_decode($request->getContent(), true);
      


      if($request->isMethod('POST')) {


        $whatsapp_cloud_api = new WhatsAppCloudApi([
          'from_phone_number_id' => '113342895096982',
          'access_token' => 'EAANFgseGzQsBAE5Sosb6ntFkwUNtprxZC0MDjhiygVNIrkobgpDYptwchank8MAZB5uEqxIyfonSP0vjcbH35jWzT1ZAUCsU2C3FYrcdKWRsqduGd5QHcIZA5KoPagU1ZBpRf4gmrgsOEtrfFTWolvEjCy6DBZC0TFLxETCJabTT3aNYZCrU3fIA00QCgMv82GVFVp9xxJOzhW2E3eFsYei',

      ]);

    if(isset($data['entry'][0]['changes']['0']['field']) == 'message'){
       $data = json_decode($request->getContent(), true);
       \Log::info($data);


       $mob = $this->get_mobile($data);
       \Log::info('Mob');
       \Log::info($mob);


      //  $status = $this->get_status($data);
      //  if(isset($status)) {

      //    \Log::info('status NEW latest');
      //    \Log::info($status);
      // }
      
      $userReplyMessage = $this->get_user_reply_message_type($data);

      if ($userReplyMessage == "text"){
          $userMessage = $this->get_user_message($data);
          \Log::info($userMessage);
      }

      elseif ($userReplyMessage == "interactive"){
       $userMessage = $this->get_user_reply_message($data);
       \Log::info($userMessage);

      }

      elseif ($userReplyMessage == "image"){
        \Log::info('images');
        \Log::info($userReplyMessage);

      }

      $get_account_id = $this->get_account_id($data);
      $get_phone_no_id = $this->get_phone_no_id($data);
      $recipient_wa_id = $this->get_mobile($data);

      if ($mob){
          $user_name = $this->get_name($data);



       if($userMessage =='QUERY PRODUCT'){

          $queryTicket = DB::table('members')->where('mobile_no','=',$mob)->where('query','=','QUERY PRODUCT')->where('status','=',2)->first();


          if(!isset($queryTicket)){

            $tick_no  = rand(10,1000000);

            $mes = 'Hi,Welcome in our business page '.$user_name. ' '.'your ticket number is' .$tick_no;
            $whatsapp_cloud_api->sendTextMessage($mob,$mes);


            

          }
        

        $member = new Member;
        $member->thread_id = '2';
        $member->agent_name = 'xyz';
        $member->mobile_no = $mob;

        $member->name = $user_name ;
        $member->query = $userMessage;
        $member->status = 2;
        $member->ticket_no = $tick_no;
        $member->message_status = 0;
        $member->save();

     }else if($userMessage=='ABOUT US'){

          $mes = 'Hi,Welcome in our business page '.$user_name.' '. 'you selected ABOUT US';
          $whatsapp_cloud_api->sendTextMessage($mob,$mes);



          // $member = new Member;
          // $member->thread_id = '2';
          // $member->agent_name = 'xyz';
          // $member->mobile_no = $mob;

          // $member->name = $user_name ;
          // $member->query = $userMessage;
          // $member->status = 2;

          // $member->message_status = 0;

          // $member->save();

        }else if($userMessage=='PREVIOUS QUERY'){

          $Membertickets = DB::table('members')
          ->where('mobile_no', '=', $mob)
          ->pluck('ticket_no')
          ->implode(",\n");

          \log::info('tickets new');
          \log::info($Membertickets);

          $mes = 'Hi,your previous tickets is '  .$Membertickets;
          $whatsapp_cloud_api->sendTextMessage($mob,$mes);

        }else if(strtolower($userMessage)=== 'help'){
          $tem = $this->template_message($mob,$get_phone_no_id);
          $whatsapp_cloud_api->sendTextMessage($mob,$tem);

        }else{
          \log::info('count count s fetchMess');
            $fetchMess = DB::table('messages')->where('from_number','=',$mob)->where('user_message','=','QUERY PRODUCT')->where('message_status','=',1)->first();

                \log::info('count count s fetchMess');
                \log::info($fetchMess);

                    if (!isset($fetchMess)){

                        $tem = $this->template_message($mob,$get_phone_no_id);
                        $whatsapp_cloud_api->sendTextMessage($mob,$tem);

                    }else{

                      $tem = $this->template_message($mob,$get_phone_no_id);
                      $whatsapp_cloud_api->sendTextMessage($mob,$tem);

                    }

            // $aboutUs = DB::table('members')->where('from_number','=',$mob)->where('user_message','=','ABOUT US')->first();
            // \log::info('about us 000');
            // \log::info($aboutUs);

            // if ($aboutUs){


            //  }

       }

  //  try {


        $thread = new Thread;
        $thread->account_id = $get_account_id;
        $thread->phone_no_id = $get_phone_no_id;
        $thread->name = $user_name;
        $thread->wa_id = $mob;

        $thread->receipient_id = $mob;
        $thread->status = 'sent' ;
        \log::info('THREAD information');
        \log::info($thread);
        $thread->save();

        $user = Thread::find($thread->id);
        $user->status = 'read';
        $user->save();

        \log::info('update status 99');
        \log::info($thread->status);

        $message = new Message;
        $message->thread_id = $thread->id;
        $message->from_number = $mob;
        $message->message_sent_user = $mes;
        $message->user_message = $userMessage;
        $message->message_type = $userReplyMessage;

        $message->message_status = '1';

        \log::info('messages for what');
        \log::info($message);
    

        $message->save();


      //   }catch (Exception $e) {
      //     echo 'Error: ' . $e->getMessage();
      // }
   }

    }
   }
 }catch (\Exception $e) {
        // Handle the exception
        \Log::error($e->getMessage());
        // Return an error response
        return response('An error occurred', 500);
    }
             //  $whatsapp_cloud_api->sendTextMessage('+919646404283', 'snakescript 009');



}





}