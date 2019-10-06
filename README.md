# Description
Simple wrapper to use the [Implicit oAuth2 Flow](https://tools.ietf.org/html/rfc6749#section-1.3.2) with applications that requires the expose of the client secret.

# Why
GitHub oAuth2 flow does not supports [Implicit Flow](https://tools.ietf.org/html/rfc6749#section-1.3.2), and I need it to a personal project. So why not?

# How
What this project do is redirecting the requests to ``ìndex.php`` to GitHub, including the Client Secret without exposing it to the requester.

# Installation
1. Create a .client_secret file and put in it your client secret AND JUST THE CLIENT SECRET. Pay attention to spaces or line breaks, they aren't allowed.
2. Serve index.php file somewhere in the internet

# Usage
Just make the requests to the ``index.php`` file instead of the GitHub server.
