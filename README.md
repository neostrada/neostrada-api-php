![Neostrada](https://www.neostrada.nl/asset/nx/images/logo.png) 
=================

# Neostrada API client for PHP #

Easily connect your own system to the Neostrada API using the Neostrada API client and your [API credentials](https://www.neostrada.nl/mijn-account/api.html) to automatically register and manage domainnames.

## Installation ##
Download the [Neostrada API client](https://github.com/neostrada/neostrada-api-php/archive/master.zip) or checkout the repository and include the client in your script.

## Usage ##
Check out the Examples/Demo.php file to see how the client works.

**Please note:**
+ Every API call must be signed, the client will do this automically. The API Secret is used for this signature.
+ It is required to also include empty parameters in a request. For example, getholders has the optional 'holderids' parameter. If you wish to retrieve ALL holders, create the request and set 'holderids' to an empty string.

## License ##
[BSD (Berkeley Software Distribution) License](http://www.opensource.org/licenses/bsd-license.php).
Copyright (c) 2012, Avot Media BV

## Support ##
[www.neostrada.nl](https://www.neostrada.nl) - support@neostrada.nl