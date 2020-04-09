<?php

namespace application\models;

/*
	#CoronavirusCroatia
	#ostanidoma
*/

use application\core\Model;
use application\helpers\Twitter;

class Social extends Model
{
   public function callTwitterRequest()
   {
        $settings = [
            'oauth_access_token' => ACCESS_TOKEN,
            'oauth_access_token_secret' => ACCESS_TOKEN_SECRET,
            'consumer_key' => API_KEY,
            'consumer_secret' => API_KEY_SECRET
        ];

        $hashtag = $this->request->get("hashtag");
        $url = 'https://api.twitter.com/1.1/search/tweets.json';
        $getfield = '?q=%23' . $hashtag;
        $requestMethod = 'GET';
        
        $twitter = new Twitter($settings);
        
        return $twitter->setGetfield($getfield)
            ->buildOauth($url, $requestMethod)
            ->performRequest();
   }
}
