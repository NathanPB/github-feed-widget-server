# Description
Simple wrapper to use the [Implicit oAuth2 Flow](https://tools.ietf.org/html/rfc6749#section-1.3.2) with applications that requires the expose of the client secret.

# Why
GitHub oAuth2 flow does not supports [Implicit Flow](https://tools.ietf.org/html/rfc6749#section-1.3.2), and I need it to a personal project. So why not?

# How
What this project do is redirecting the requests to ``ìndex.php`` to GitHub, including the Client Secret without exposing it to the requester.

# Installation
1. Create a ``.env`` file and fill with [the settings](#Settings)
2. Serve ``index.php`` file somewhere in the internet

# Settings

Each parameters must go in one line, in the format key=value, with no trailing between the key, the ``=`` and the value.
The parameter order is not important.

| Parameter               | Description                                             | Required | Default     |
|-------------------------|---------------------------------------------------------|----------|-------------|
| ``URL``                 | The URL to redirect                                     | True     |             |
| ``METHOD``              | The request method. Supports only ``GET`` and ``POST``  | False    | ``POST``    |
| ``CLIENT_SECRET``       | The client secret   | True     |             |
| ``CLIENT_SECRET_PARAM`` | The name of the param to send the client secret | False | ``client_secret`` |
| ``REQUIRED_PARAMS``     | The required parameters of the request, separated by ``, `` (comma and space) | False | |

E.g:
```
CLIENT_SECRET=d0g315g0d
URL=https://github.com/login/oauth/access_token
REQUIRED_PARAMS=code, client_id
```

# Usage
Just make the requests to the ``index.php`` file instead of the oAuth2 server.
