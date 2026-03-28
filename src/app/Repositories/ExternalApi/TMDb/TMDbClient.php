<?php

namespace App\Repositories\ExternalApi\TMDb;

use App\Repositories\ExternalApi\Interface\MovieClientInterface;
use CodeIgniter\Config\Services;
use RuntimeException;

class TMDbClient implements MovieClientInterface
{
    private string $token;
    private int $timeout;

    public function __construct() {
        $this->token = $this->getApiToken();
        $this->timeout = $this->getTimeout();
    }

    public function get(string $url, array $query = []): array
    {
        /**
         * GETリクエスト実行
         *
         * @param  string $url
         * @return array
         */
        $timeout = $this->timeout;
        $headers = [
            'accept' => 'application/json',
            'Authorization' => "Bearer {$this->token}"
        ];

        $client = Services::curlrequest([
            'http_errors' => true
        ]);

        $res = $client->request('GET', $url, compact('timeout', 'headers', 'query'));

        return json_decode($res->getBody());
    }

    /**
     * APIトークンの取得
     *
     * @return string
     */
    private function getApiToken(): string
    {
        $token = config('TMDb')->APIToken;
        if(empty($token)) {
            throw new RuntimeException('APIトークンが見つかりません');
        }

        return $token;
    }

    /**
     * タイムアウト時間の設定を取得
     *
     * @return int
     */
    private function getTimeout(): int
    {
        $timeout = config('TMDb')->timeout;

        return $timeout ?? 5;
    }
}