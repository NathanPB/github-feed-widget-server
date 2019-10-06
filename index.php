<?php
    /*
    Copyright (C) 2019 Nathan P. Bombana

    This program is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

    This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

    You should have received a copy of the GNU General Public License along with this program. If not, see https://www.gnu.org/licenses/.
    */

    function get_env(){
        $file = fopen('.env', 'r');
        $secret = fread($file, filesize('.env'));
        fclose($file);

        $env_array = [];
        foreach (explode("\n", $secret) as $line) {
            $kv = explode('=', $line);
            $env_array[$kv[0]] = $kv[1];
        }

        return $env_array;
    }

    $env = get_env();
    $url = $env['URL'];
    $client_secret = $env['CLIENT_SECRET'];
    $method = empty($env['METHOD']) ? 'POST' : strtoupper($env['METHOD']);
    $required_params = empty($env['REQUIRED_PARAMS']) ? [] : explode(', ', $env['REQUIRED_PARAMS']);
    $client_secret_param = empty($env['CLIENT_SECRET_PARAM']) ? 'client_secret' : $env['CLIENT_SECRET_PARAM'];

    if(!empty($client_secret) || !empty($url)) {
        if($_SERVER['REQUEST_METHOD'] === $method) {
            $containedParams = array_intersect($required_params, array_keys($method === 'POST' ? $_POST : $_GET));
            if(count($containedParams) === count($required_params)) {
                if($method === 'GET') {
                    $url .= "?$client_secret_param=$client_secret";
                    foreach($_GET as $k=>$v) {
                        $url .= "&$k=>$v";
                    }
                    echo file_get_contents($url);
                } else {
                    echo file_get_contents(
                        $url,
                        false,
                        stream_context_create([
                            'http' => [
                                'method' => $method,
                                'header'  => "Content-type: application/x-www-form-urlencoded",
                                'content' => http_build_query(array_merge($_POST, [$client_secret_param => $client_secret]))
                            ]
                        ]));
                }
            } else {
                header("HTTP/1.0 422 Unprocessable Entity");
                die();
            }
        } else {
            header("HTTP/1.0 405 Method Not Allowed");
            die();
        }
    } else {
        header("HTTP/1.0 500 Internal Server Error");
        die();
    }
