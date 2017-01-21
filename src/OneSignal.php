<?php

namespace Moathdev\OneSignal;


use GuzzleHttp\Client;

class  OneSignal
{

    /**
     * @var Client
     */
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
        $this->appId = env('ONESIGNAL_APP_ID');
        $this->Authorization = 'Basic ' . env('ONESIGNAL_AUTHORIZATION');
        $this->Url = env('ONESIGNAL_API_URL','https://onesignal.com/api/v1/');
    }


    /**
     * @param $title - Required
     * @param $massage - Required
     * @param $data - Optional | array
     * @param  $url - Optional
     * @param  $buttons - Optional
     * @return mixed
     * @throws FailedToSendNotificationException
     */
    public function SendNotificationToAll($title, $massage, array $data = null, $url = null, $buttons = null)
    {

        $params = [
            'app_id' => $this->appId,
            'included_segments' => ['All'],
            'headings' => [
                'en' => $title
            ],
            'contents' => [
                'en' => $massage
            ],
        ];

        if (isset($data)) {
            $params['data'] = $data;
        }

        if (isset($url)) {
            $params['url'] = $url;
        }

        if (isset($button)) {
            $params['buttons'] = $buttons;
        }

        try {

            $res = $this->client->post($this->Url.'notifications', [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => $this->Authorization,
                ],
                'body' => json_encode($params)
            ]);
        } catch (FailedToSendNotificationException $e) {

            throw new FailedToSendNotificationException('Failed to send notification .', 0, $e);

        }

        return $res;
    }


} // End Class
