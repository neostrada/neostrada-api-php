<?php
/**
 * Include API library
 */
require_once dirname(__FILE__).'/../Client/Neostrada.inc.php';
/**
 * Ininitalize the Neostrada API client
 */
$API = Neostrada::GetInstance();
$API->SetAPIKey('[your_apikey]');
$API->SetAPISecret('[your_apisecret]');
/**
 * Get domains
 */
$API->prepare('domains');
$API->execute();
echo '<pre>'; print_r($API->fetch());
/**
 * Get extensions
 */
$API->prepare('extensions');
$API->execute();
print_r($API->fetch());
/**
 * Do whois
 */
$API->prepare('whois', array(
	'domain'	=> 'my-domainname',
	'extension' => 'nl'
));
$API->execute();
print_r($API->fetch());
/**
 * Add new holder
 *
 * Please note: Holders are only added if they do not exist yet. When adding an existing holder, the API will return the existing holder's ID
 */
$API->prepare('holder', array(
	'holderid'		=> 0, // Set to holder's ID to update
	'sex'			=> 'M', // M for Male, V for Female
	'firstname'		=> 'Neostrada',
	'center'		=> '',
	'lastname'		=> 'BV',
	'street'		=> 'Vocweg',
	'housenumber'	=> '49',
	'hnpostfix'		=> '',
	'zipcode'		=> '8242KA',
	'city'			=> 'Lelystad',
	'country'		=> 'nl', // 2 letter country code
	'email'			=> 'domains@neostrada.nl'
));
$API->execute();
print_r($API->fetch());
/**
 * Delete holder
 */
$API->prepare('deleteholder', array(
	'holderid'	=> 1
));
$API->execute();
print_r($API->fetch());
/**
 * Get holders (optionally filtered by holderids)
 */
$API->prepare('getholders', array(
	'holderids'	=> '1,2,3' // Comma separated list with holder's IDs
));
$API->execute();
print_r($API->fetch());
/**
 * Register domain
 */
$API->prepare('register', array(
	'domain'	=> 'neostrada',
	'extension'	=> 'nl',
	'holderid'	=> '[holderid]',
	'period'	=> 1,
	'webip'		=> '127.0.0.1', // leave this empty to use the Neostrada's default IP address
	'packageid'	=> 0 // optional package ID to add a Neostrada hosting package, contact us for the correct IDs
));
$API->execute();
print_r($API->fetch());
/**
 * Register domain with custom nameservers
 */
$API->prepare('register2', array(
	'domain'	=> 'neostrada',
	'extension'	=> 'nl',
	'holderid'	=> '[holderid]',
	'period'	=> 1,
	'packageid'	=> 0, // optional package ID to add a Neostrada hosting package, contact us for the correct IDs
	'webip'		=> '127.0.0.1',
	'ns1'		=> 'ns1.neostrada.nl',
	'ns2'		=> 'ns2.neostrada.nl',
	'ns3'		=> 'ns3.neostrada.nl'
));
$API->execute();
print_r($API->fetch());
/**
 * Transfer domain
 */
$API->prepare('transfer', array(
	'domain'	=> 'neostrada',
	'extension' => 'nl',
	'authcode'	=> 'bleEEfrff!@'
));
$API->execute();
print_r($API->fetch());
/**
 * Transfer domain with custom nameservers
 */
$API->prepare('transfer2', array(
	'domain'	=> 'neostrada',
	'extension' => 'nl',
	'authcode'	=> 'bleEEfrff!@',
	'webip'		=> '',
	'ns1'		=> 'ns1.neostrada.nl',
	'ns2'		=> 'ns2.neostrada.nl',
	'ns3'		=> 'ns3.neostrada.nl'
));
$API->execute();
print_r($API->fetch());
/**
 * Modify domain
 */
$API->prepare('modify', array(
	'domain'	=> 'neostrada',
	'extension' => 'nl',
	'holderid'	=> '[holderid]'
));
$API->execute();
print_r($API->fetch());
/**
 * Lock domain
 *
 * Please note: To unlock a domain, set lock to 0
 */
$API->prepare('lock', array(
	'domain'	=> 'neostrada',
	'extension' => 'com',
	'lock'		=> 1
));
$API->execute();
print_r($API->fetch());
/**
 * Delete domain
 *
 * Domain will be deleted and will expire on the expiration date
 */
$API->prepare('delete', array(
	'domain'	=> 'neostrada',
	'extension' => 'nl'
));
$API->execute();
print_r($API->fetch());
/**
 * Get auth token
 */
$API->prepare('gettoken', array(
	'domain'	=> 'neostrada',
	'extension' => 'nl'
));
$API->execute();
print_r($API->fetch());
/**
 * Get expiration date
 */
$API->prepare('getexpirationdate', array(
	'domain'	=> 'neostrada',
	'extension' => 'nl'
));
$API->execute();
print_r($API->fetch());
/**
 * Get domain nameservers
 */
$API->prepare('getnameserver', array(
	'domain'	=> 'neostrada',
	'extension' => 'nl'
));
$API->execute();
print_r($API->fetch());
/**
 * Set domain nameservers
 */
$API->prepare('nameserver', array(
	'domain'	=> 'neostrada',
	'extension' => 'nl',
	'ns1'		=> 'ns1.neostrada.nl',
	'ns2'		=> 'ns2.neostrada.nl',
	'ns3'		=> 'ns3.neostrada.nl' // optional
));
$API->execute();
print_r($API->fetch());
/**
 * Get dns
 *
 * Returns an item for every DNS row. The item's value is a ; separated string with the following fields: [dnsrowid];[name];[type];[content];[timetolive];[priority]
 */
$API->prepare('getdns', array(
	'domain'	=> 'neostrada',
	'extension' => 'nl'
));
$API->execute();
print_r($API->fetch());
/**
 * Set dns
 *
 * All data must be provided as an serialized arra. Every item must be a sub array with the following format: [dnsrowid] => array('name' => '', 'type' => '', 'content => '', 'ttl' => '', 'prio' => '')
 * Please note: Non existing records will not be added! You must use adddns for that.
 * Please note: The SOA record will be updated automatically
 */
$API->prepare('dns', array(
	'domain'	=> 'neostrada',
	'extension' => 'nl',
	'dnsdata'	=> serialize(array(
		1 => array(
			'name'		=> 'neostrada.nl',
			'type'		=> 'TXT',
			'content'	=> 'TEST DNS RECORD',
			'ttl'		=> 3600,
			'prio'		=> 0
		)
	))
));
$API->execute();
print_r($API->fetch());
/**
 * Add dns
 *
 * Please note: The SOA record will be updated automatically
 */
$API->prepare('adddns', array(
	'domain'	=> 'neostrada',
	'extension' => 'nl',
	'name'		=> 'neostrada.nl',
	'type'		=> 'TXT',
	'content'	=> 'TEST DNS RECORD',
	'prio'		=> 0, // E.x. 10 for first MX
	'ttl'		=> 3600
));
$API->execute();
print_r($API->fetch());
?>