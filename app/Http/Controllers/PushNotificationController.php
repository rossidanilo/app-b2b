<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PushNotification;

class PushNotificationController extends Controller
{
     public function index()
    {


			function getDevices(){ 
			  $app_id = "dabab4ce-07f8-44ce-8f2f-8d3ef773f33d";
			  $ch = curl_init(); 
			  curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/players?app_id=" . $app_id); 
			  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 
			                                             'Authorization: Basic NDY5ZWQ4M2EtZTIxYy00YmE4LTgyNWItMGJhNTQzYjhhMGQy')); 
			  curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); 
			  curl_setopt($ch, CURLOPT_HEADER, FALSE);
			  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

			  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
			  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

			  $response = curl_exec($ch); 
			  curl_close($ch); 
			  return $response; 
			}

			$response = getDevices(); 
			$return["allresponses"] = $response; 
			$return = json_encode( $return); 
			
			$data = json_decode($return, true);

			$devices = json_decode($data['allresponses'], true);

			$users['total'] = 0;

			if ($devices['offset'] > 0) {
				
				for ($i=0; $i < $devices['offset']; $i++) { 
					
					$users['total'] += $devices[$i]['total_count'];
				}

			} else {

				$users['total'] = $devices['total_count'];

			}

        return view ('push', array('users' => $users));
    }

    public function create(Request $request)
    {

    global $title;
    global $subtitle;

    $title = $request->title;
    $subtitle = $request->subtitle;
        
        function sendMessage(){

        global $title, $subtitle;

        $content = array(
        "en" => $subtitle,
        "es" => $subtitle
        );

        $headings = array(
          "en" => $title,
        "es" => $title  
        );

    $fields = array(
        'app_id' => "dabab4ce-07f8-44ce-8f2f-8d3ef773f33d",
        'included_segments' => array('Active Users'),
        'contents' => $content,
        'headings' => $headings
    );

    $fields = json_encode($fields);
    //print("\nJSON sent:\n");
    //print($fields);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',                                              'Authorization: Basic NDY5ZWQ4M2EtZTIxYy00YmE4LTgyNWItMGJhNTQzYjhhMGQy'));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);    

    $response = curl_exec($ch);
    curl_close($ch);

    return $response;
}

        $response = sendMessage();

    /*Store Push Notification in Database*/

    $push = new PushNotification;
    $push->name = $request->name;
    $push->title = $request->title;
    $push->subtitle = $request->subtitle;
    $push->save();

    return redirect ('/admin/push');

    }

    public function view(){

			$curl = curl_init();

			curl_setopt_array($curl, array(
			  CURLOPT_URL => "https://onesignal.com/api/v1/notifications?app_id=dabab4ce-07f8-44ce-8f2f-8d3ef773f33d&limit=50&offset=0",
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => "",
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 30,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => "GET",
			  CURLOPT_HTTPHEADER => array(
			    "authorization: Basic NDY5ZWQ4M2EtZTIxYy00YmE4LTgyNWItMGJhNTQzYjhhMGQy",
			  ),
			));

			curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

			$response = curl_exec($curl);
			$err = curl_error($curl);

			curl_close($curl);

			$notifications = json_decode($response, true);

			return view ('push-view' , array('notifications' => $notifications));


    }
}
