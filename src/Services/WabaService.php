<?php

namespace Sdkconsultoria\WhatsappCloudApi\Services;

use Illuminate\Support\Facades\Http;

class WabaService extends FacebookService
{
    public function getScript()
    {
        return "
        <script>
        window.fbAsyncInit = function () {
            // JavaScript SDK configuration and setup
            FB.init({
              appId:    '".config('facebook.app_id')."', // Facebook App ID
              cookie:   true, // enable cookies
              xfbml:    true, // parse social plugins on this page
              version:  '".config('facebook.api_version')."' //Graph API version
            });
          };

          // Load the JavaScript SDK asynchronously
          (function (d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = \"https://connect.facebook.net/en_US/sdk.js\";
            fjs.parentNode.insertBefore(js, fjs);
          }(document, 'script', 'facebook-jssdk'));

          // Facebook Login with JavaScript SDK
          function launchWhatsAppSignup() {
            // Launch Facebook login
            FB.login(function (response) {
              if (response.authResponse) {
                const accessToken = response.authResponse.accessToken;
                //Use this token to call the debug_token API and get the shared WABA's ID
              } else {
                console.log('User cancelled login or did not fully authorize.');
              }
            }, {
              scope: 'business_management,whatsapp_business_management',
              extras: {
                feature: 'whatsapp_embedded_signup',
                setup: {

                }
              }
            });
          }
        </script>
        ";
    }

    public function getButtonToRegisterWaba()
    {
        return <<<HTML
        <button onclick="launchWhatsAppSignup()" style="background-color: #1877f2; border: 0; border-radius: 4px; color: #fff; cursor: pointer; font-family: Helvetica, Arial, sans-serif; font-size: 16px; font-weight: bold; height: 40px; padding: 0 24px;">Login with Facebook</button>
        HTML;
    }
}
