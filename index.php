<?php
    /*
    Copyright (C) 2019 Nathan P. Bombana

    This program is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

    This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

    You should have received a copy of the GNU General Public License along with this program. If not, see https://www.gnu.org/licenses/.
    */

    function get_secret(){
        $file = fopen('.client_secret', 'r');
        $secret = fread($file, filesize('.client_secret'));
        fclose($file);
        return $secret;
    }

    if($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['code'] && $_POST['client_id']) {
        echo file_get_contents(
            "https://github.com/login/oauth/access_token",
            false,
            stream_context_create([
                'http' => [
                    'method' => 'POST',
                    'header'  => "Content-type: application/x-www-form-urlencoded",
                    'content' => http_build_query(array_merge($_POST, ['client_secret' => get_secret()]))
                ]
        ]));
    }
