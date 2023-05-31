<?php

namespace App\Http\Controllers;
// define('STDOUT', fopen('php://stdout', 'w'));
use Illuminate\Http\Request;
use Netflie\WhatsAppCloudApi\WebHook;
use Illuminate\Support\Facades\Http;
use App\Models\Thread;
use App\Models\Message;


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

    // public function __construct($config)
    // {
    //     $this->fromPhoneNumberId = $config['113342895096982'];
    //     $this->accessToken = $config['EAANFgseGzQsBAMzSysoYDRTBId3oGTrzTcmTNJDLDaZAWIy6GjXoAiDsVREqV5mkBSKyZBNqgZCW5BP2J69rvcP8fPhuCQL63WY0cFvGCVQK6Us0AheuZBcjuFBtPEOer5kho0oGJrTZC50SgRDyCBD1VUdGzxATZA7lIF36cQHVqfkOivZBPsF5TOAsJbPJh04TWvytJAVOGqymWjyZBCZB7'];
    // }
     
//   public function sendWhatsAppTemplateMessage($recipientWaId, $namespace, $templateName, $languageCode, $textString)
//     {
//         $url = "https://api.example.com/v1/messages";

//         $data = array(
//             "to" => $recipientWaId,
//             "type" => "template",
//             "template" => array(
//                 "namespace" => $namespace,
//                 "name" => $templateName,
//                 "language" => array(
//                     "code" => $languageCode,
//                     "policy" => "deterministic"
//                 ),
//                 "components" => array(
//                     array(
//                         "type" => "body",
//                         "parameters" => array(
//                             array(
//                                 "type" => "text",
//                                 "text" => $textString
//                             )
//                         )
//                     )
//                 )
//             )
//         );

//         $dataJson = json_encode($data);

//         $ch = curl_init();

//         curl_setopt($ch, CURLOPT_URL, $url);
//         curl_setopt($ch, CURLOPT_POST, true);
//         curl_setopt($ch, CURLOPT_POSTFIELDS, $dataJson);
//         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//         curl_setopt($ch, CURLOPT_HTTPHEADER, array(
//             "Authorization: Bearer $this->accessToken",
//             "Content-Type: application/json"
//         ));

//         $response = curl_exec($ch);
//         \Log::info($response);

//         curl_close($ch);

//         // Handle the response
//         if ($response === false) {
//             echo "Error occurred: " . curl_error($ch);
//         } else {
//             echo "Response: " . $response;
//         }
//  }

public function template_message($mob,$phoneNoId) {

        $response = Http::withHeaders([
          'Authorization' => 'Bearer EAANFgseGzQsBAEGRQQoaZBZCRZAjzdgQnqFqqpBKYRBMpPoShif6acJanOtDZCgOsb6lmSItV3JB5r1CWEkSARx10NZBI3aOXk0nkwZCUyQY5rdZAG35msyCIgLTO7ZAShU8knVU9TP7oaOXea3ZA1G71Po0BZBkMs0umKcJt5JmDAe5XvpKf8a9PwtMgJZBZBXGQG4nWC9u1QUCzMUHMLlMhkYh',
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
                                  'id' => 'QUERY_PRODUCT',
                                  'title' => 'QUERY PRODUCT',
                                  'description' => 'query handling here!',
                              ],
                              [
                                  'id' => 'ABOUT_US',
                                  'title' => 'ABOUT US',
                                  'description' => 'LINK ABOUT US PAGE',
                              ],
                              [
                                'id' => 'PREVIOUS_QUERY',
                                'title' => 'PREVIOUS QUERY',
                                'description' => 'PREVIOUS QUERY',
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

  if (isset($data['entry'][0]['changes'][0]['value']['statuses'])) {
    return $data['entry'][0]['changes'][0]['value']['statuses'][0]['status'];
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
          'access_token' => 'EAANFgseGzQsBAEGRQQoaZBZCRZAjzdgQnqFqqpBKYRBMpPoShif6acJanOtDZCgOsb6lmSItV3JB5r1CWEkSARx10NZBI3aOXk0nkwZCUyQY5rdZAG35msyCIgLTO7ZAShU8knVU9TP7oaOXea3ZA1G71Po0BZBkMs0umKcJt5JmDAe5XvpKf8a9PwtMgJZBZBXGQG4nWC9u1QUCzMUHMLlMhkYh',

      ]);
      // if(isset($data['entry'][0]['changes']['0']['field']) =='messages') {

    // if($data['entry'][0]['changes'][0]['value']['statuses'][0]['status']!= 'delivered') {
      // if($data['entry'][0]['changes'][0]['value']['statuses'][0]['status']!= 'read') {
    //     if($data['entry'][0]['changes'][0]['value']['statuses'][0]['status']!= 'sent') {



    if(isset($data['entry'][0]['changes']['0']['field']) == 'message'){
       $data = json_decode($request->getContent(), true);
      \Log::info($data);


       $mob = $this->get_mobile($data);
      
       \Log::info($mob);

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


      $get_status = $this->get_status($data);
      \Log::info('status 124');
      \Log::info($get_status);

      $recipient_wa_id = $this->get_mobile($data);


      if ($mob){

        $user_name = $this->get_name($data);

        if($userMessage=='PREVIOUS QUERY'){
          $mes = 'Hi,Welcome in our business page '.$user_name. ' '.'you selected CLOTH';
          $tem = $this->template_message($mob,$get_phone_no_id);
          $whatsapp_cloud_api->sendTextMessage($mob,$mes);

        }else if($userMessage=='SHOE'){
          $mes = 'Hi,Welcome in our business page '.$user_name.' '. 'you selected SHOE';
          $tem = $this->template_message($mob,$get_phone_no_id);
          $whatsapp_cloud_api->sendTextMessage($mob,$mes);

        }else if($userMessage=='LAPTOP'){
          $mes = 'Hi,Welcome in our business page '.$user_name. ' '.'you selected LAPTOP';
          $tem = $this->template_message($mob,$get_phone_no_id);
          $whatsapp_cloud_api->sendTextMessage($mob,$mes);

        }else if($userMessage=='DESKTOP'){
          $mes = 'Hi,Welcome in our business page '.$user_name. ' '.'you selected DESKTOP';
          $tem = $this->template_message($mob,$get_phone_no_id);
          $whatsapp_cloud_api->sendTextMessage($mob,$mes);

        }
        else{
          $tem = $this->template_message($mob,$get_phone_no_id);
          $whatsapp_cloud_api->sendTextMessage($mob,$tem);
        }


       try {


        $thread = new Thread;
        $thread->account_id = $get_account_id;
        $thread->phone_no_id = $get_phone_no_id;
        $thread->name = $user_name;
        $thread->wa_id = $mob;

        $thread->receipient_id = $mob;
        $thread->status = $get_status;

        $thread->save();


        $message = new Message;
        $message->thread_id = $thread->id;
        $message->from_number = $mob;
        $message->message_sent_user = $mes;
        $message->user_message = $userMessage;
        \log::info('messages for what');
        \log::info($message);
    

        $message->save();

        }catch (Exception $e) {
          echo 'Error: ' . $e->getMessage();
      }
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



//   private function create_button($button) {
//       return array(
//           "type" => "list",
//           "header" => array("type" => "text", "text" => $button["header"]),
//           "body" => array("text" => $button["body"]),
//           "footer" => array("text" => $button["footer"]),
//           "action" => $button["action"]
//       );
//   }

//   public function send_button($button, $recipient_id) {
//       $data = array(
//           "messaging_product" => "whatsapp",
//           "to" => $recipient_id,
//           "type" => "interactive",
//           "interactive" => $this->create_button($button)
//       );
//       $curl = curl_init($this->url);
//       curl_setopt($curl, CURLOPT_HTTPHEADER, $this->headers);
//       curl_setopt($curl, CURLOPT_POST, true);
//       curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
//       curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
//       $response = curl_exec($curl);
//       curl_close($curl);
//       return json_decode($response, true);
//   }

//   public function send_reply_button($button, $recipient_id) {
//       $data = array(
//           "messaging_product" => "whatsapp",
//           "recipient_type" => "individual",
//           "to" => $recipient_id,
//           "type" => "interactive",
//           "interactive" => $button
//       );
//       $curl = curl_init($this->url);
//       curl_setopt($curl, CURLOPT_HTTPHEADER, $this->headers);
//       curl_setopt($curl, CURLOPT_POST, true);
//       curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
//       curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
//       $response = curl_exec($curl);
//       curl_close($curl);
//       return json_decode($response, true);
//   }





//  public function send_template($template, $recipient_id, $lang = "en_US") {

//         $data = array(
//             "messaging_product" => "whatsapp",
//             "to" => $recipient_id,
//             "type" => "template",
//             "template" => array("name" => $template, "language" => array("code" => $lang))
//         );
//         $curl = curl_init($this->url);
//         curl_setopt($curl, CURLOPT_HTTPHEADER, $this->headers);
//         curl_setopt($curl, CURLOPT_POST, true);
//         curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
//         curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
//         $response = curl_exec($curl);
//         curl_close($curl);
//         return json_decode($response, true);


//  }




// public function webhookMSG(){

//     $whatsapp_cloud_api = new WhatsAppCloudApi([
//         'from_phone_number_id' => '113342895096982',
//         'access_token' => 'EAANFgseGzQsBAPaS25jKlZAtQrefOsIfbB3L4IT5Q1BGrVbwyYJ7Ua2xh8HuQfIDfZC7YzOIydDN6uJc6S2ZATvkUsJmdDcAN2v0K26QZAoHE5BojMkANiaOrAwxQgHZAfxC03hmsCLCxKduZBXIMy5JyMwydKMRaQdqV5hh9rG41YvjAhHFVGE1jZCsZBwJA5InhVa59fxnJeM0LFZBYpJKu',
//     ]);

//    return  $whatsapp_cloud_api->sendTextMessage('+919646404283', 'Hey there! I\'m using WhatsApp Cloud API. Visit https://www.netflie.es');

// }








}