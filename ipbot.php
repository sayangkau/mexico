<?php

use GuzzleHttp\Client;

class IPBot
{
    private $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function getDetails(string $ip_address): array
    {
        $ip_address = trim($ip_address);
        $get_response = $this->client->get("https://ipbot-api-hh5l.vercel.app/api/ipbot?ip_address=$ip_address");
        $response = json_decode($get_response->getBody());

        if ($response->status === true) {
            $response = (string) $response->data;
            @libxml_use_internal_errors(true);
            $doc = new DOMDocument();
            $doc->loadHTML($response);
            $xpath = new DOMXPath($doc);
            $datas = $xpath->evaluate('//tr');

            $results = [];
            $results['ip_address'] = $ip_address;
            foreach ($datas as $key => $value) {
                $data = trim($value->textContent);
                if ($key == 2) {
                    $results['asn'] = trim(preg_split('/\r\n|\n|\r/', $data)[1] ?? '');
                    $results['asn'] = trim(explode('-', $results['asn'])[0]);
                }

                if ($key == 3) {
                    $results['isp_name'] = trim(preg_split('/\r\n|\n|\r/', $data)[2] ?? '');
                }

                if ($key == 7) {
                    $results['country_name'] = trim(preg_split('/\r\n|\n|\r/', $data)[1] ?? '');
                }

                if ($key == 8) {
                    $results['country_code'] = trim(preg_split('/\r\n|\n|\r/', $data)[1] ?? '');
                }

                if ($key == 9) {
                    $results['region'] = trim(preg_split('/\r\n|\n|\r/', $data)[1] ?? '');
                }

                if ($key == 10) {
                    $results['city'] = trim(preg_split('/\r\n|\n|\r/', $data)[1] ?? '');
                }

                if ((count($datas) > 27 && $key == 25) || (count($datas) <= 27 && $key == 19)) {
                    $results['vpn'] = trim(preg_split('/\r\n|\n|\r/', $data)[1] ?? '');
                    if (!$results['vpn']) {
                        $results['vpn'] = false;
                    } else if ($results['vpn'] == 'No') {
                        $results['vpn'] = false;
                    } else {
                        $results['vpn'] = true;
                    }
                }

                if ((count($datas) > 27 && $key == 26) || (count($datas) <= 27 && $key == 20)) {
                    $results['tor_exit_node'] = trim(preg_split('/\r\n|\n|\r/', $data)[1] ?? '');
                    if (!$results['tor_exit_node']) {
                        $results['tor_exit_node'] = false;
                    } else if ($results['tor_exit_node'] == 'No') {
                        $results['tor_exit_node'] = false;
                    } else {
                        $results['tor_exit_node'] = true;
                    }
                }

                if ((count($datas) > 27 && $key == 27) || (count($datas) <= 27 && $key == 21)) {
                    $results['server'] = trim(preg_split('/\r\n|\n|\r/', $data)[1] ?? '');
                    if (!$results['server']) {
                        $results['server'] = false;
                    } else if ($results['server'] == 'No') {
                        $results['server'] = false;
                    } else {
                        $results['server'] = true;
                    }
                }

                if ((count($datas) > 27 && $key == 28) || (count($datas) <= 27 && $key == 22)) {
                    $results['public_proxy'] = trim(preg_split('/\r\n|\n|\r/', $data)[1] ?? '');
                    if (!$results['public_proxy']) {
                        $results['public_proxy'] = false;
                    } else if ($results['public_proxy'] == 'No') {
                        $results['public_proxy'] = false;
                    } else {
                        $results['public_proxy'] = true;
                    }
                }

                if ((count($datas) > 27 && $key == 29) || (count($datas) <= 27 && $key == 23)) {
                    $results['web_proxy'] = trim(preg_split('/\r\n|\n|\r/', $data)[1] ?? '');
                    if (!$results['web_proxy']) {
                        $results['web_proxy'] = false;
                    } else if ($results['web_proxy'] == 'No') {
                        $results['web_proxy'] = false;
                    } else {
                        $results['web_proxy'] = true;
                    }
                }

                if ((count($datas) > 27 && $key == 30) || (count($datas) <= 27 && $key == 24)) {
                    $results['bot'] = trim(preg_split('/\r\n|\n|\r/', $data)[1] ?? '');
                    if (!$results['bot']) {
                        $results['bot'] = false;
                    } else if ($results['bot'] == 'No') {
                        $results['bot'] = false;
                    } else {
                        $results['bot'] = true;
                    }
                }
            }

            return $results;
        } else {
            return [];
        }
    }
}
