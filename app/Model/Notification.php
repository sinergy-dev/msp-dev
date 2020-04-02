<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use FCM;

class Notification extends Model
{

	public static function toSingleDevice($token=null,$title=null,$body=null,$icon,$click_action){
			$optionBuilder = new OptionsBuilder();
			$optionBuilder->setTimeToLive(60*20);

			$notificationBuilder = new PayloadNotificationBuilder($title);
			$notificationBuilder->setBody($body)
							    ->setSound('default')
							    ->setBadge(1)
							    ->setIcon($icon)
							    ->setClickAction($click_action);

			$dataBuilder = new PayloadDataBuilder();
			$option = $optionBuilder->build();
			$notification = $notificationBuilder->build();
			$data = $dataBuilder->build();
			$token = $token;
			$downstreamResponse = FCM::sendTo($token, $option, $notification, $data);

			$downstreamResponse->numberSuccess();
			$downstreamResponse->numberFailure();
			$downstreamResponse->numberModification();
			$downstreamResponse->tokensToDelete();
			$downstreamResponse->tokensToModify();
			$downstreamResponse->tokensToRetry();
			$downstreamResponse->tokensWithError();
	}

	public static function toMultiDevice($model,$token=null,$title=null,$body=null,$icon,$click_action){
		
			$optionBuilder = new OptionsBuilder();
			$optionBuilder->setTimeToLive(60*20);

			$notificationBuilder = new PayloadNotificationBuilder($title);
			$notificationBuilder->setBody($body)
							    ->setSound('default')
							    ->setBadge(1)
							    ->setIcon($icon)
							    ->setClickAction($click_action);

			$dataBuilder = new PayloadDataBuilder();

			$option = $optionBuilder->build();
			$notification = $notificationBuilder->build();
			$data = $dataBuilder->build();
			$tokens = $model->pluck('device_token')->toArray();

			$downstreamResponse = FCM::sendTo($tokens, $option, $notification, $data);

			$downstreamResponse->numberSuccess();
			$downstreamResponse->numberFailure();
			$downstreamResponse->numberModification();
			$downstreamResponse->tokensToDelete();
			$downstreamResponse->tokensToModify();
			$downstreamResponse->tokensToRetry();
			$downstreamResponse->tokensWithError();

	}

	public static function numberAlert(){
		
	}
    //
    
}
