<?php


namespace Service\SocialNetwork;


class FacebookAdapter implements ISocialNetwork
{
    public function send(string $message): void {
        // sending a message using the Facebook API
        echo "send via fb";
    }
}