<?php


namespace Service\SocialNetwork;

class VKAdapter implements ISocialNetwork
{
    public function send(string $message): void
    {
        // sending a message using the VK API
        echo "send via vk";
    }
}
