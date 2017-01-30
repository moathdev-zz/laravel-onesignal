<?php

namespace Moathdev\OneSignal;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Contracts\Container\Container;
use Moathdev\OneSignal\Exceptions\FailedToSendNotificationException;
use Psr\Http\Message\ResponseInterface;

class OneSignal
{

    /**
     * @var Client
     */
    private $client;

    public function __construct(Client $client, Container $app)
    {
        $config = $app->make('config');

        $this->client = $client;

        $this->appId = $config->get('oneSignal.appId');

        $this->API_KEY = 'Basic ' . env('ONESIGNAL_API_KEY');

        $this->Authorization = 'Basic ' . base64_encode($config->get('oneSignal.user_auth_key'));

        $this->Url = $config->get('oneSignal.url');
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

        $res = $this->post($params, 'notifications');

        return $res->getBody()->getContents();
    }

    /**
     * @param $title - Required
     * @param $massage - Required
     * @param array $OneSignalIds - Required | array
     * @param array $data - Optional | array
     * @param  $url - Optional
     * @param  $buttons - Optional
     * @return mixed
     * @throws FailedToSendNotificationException
     */
    public function SendNotificationToSpecificUsers($title, $massage, array $OneSignalIds, array $data = null, $url = null, $buttons = null)
    {

        $params = [
            'app_id' => $this->appId,
            'include_player_ids' => $OneSignalIds,
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

        $res = $this->post($params, 'notifications');

        return $res->getBody()->getContents();
    }


    public function CancelNotification($Notification_id)
    {
        $res = $this->delete($Notification_id, 'notifications');

        return $res->getBody()->getContents();

    }


    public function ViewApps()
    {
        $res = $this->get('apps');

        return $res->getBody()->getContents();

    }

    /**
     * @param $params
     * @param $action
     * @return ResponseInterface
     * @throws FailedToSendNotificationException
     */
    public function post($params, $action)
    {
        try {
            return $this->client->post($this->Url . $action, [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => $this->API_KEY,
                ],
                'body' => json_encode($params)
            ]);
        } catch (ClientException $e) {
            throw new FailedToSendNotificationException('Failed to send notification .', 0, $e);
        }
    }

    public function delete($Notification_id, $action)
    {
        try {
            return $this->client->delete($this->Url . $action . '/' . $Notification_id . '?app_id=' . $this->appId, [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => $this->API_KEY,
                ],
            ]);
        } catch (ClientException $e) {
            throw new FailedToSendNotificationException('Failed to delete notification: ' . $Notification_id . ' .', 0, $e);
        }
    }

    public function get($action)
    {
        try {
            return $this->client->get($this->Url . $action, [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => $this->Authorization,
                ],
            ]);
        } catch (ClientException $e) {
            throw new FailedToSendNotificationException('Failed to get' . $action, 0, $e);
        }
    }


} // End Class
