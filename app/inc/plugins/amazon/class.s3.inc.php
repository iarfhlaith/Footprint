<?php

/**

 *  Amazon S3 REST API Implementation
 *
 *  This a generic PHP class that can hook-in to Amazon's S3 Simple Storage Service
 * 
 *  Contributions and/or donations are welcome.
 *
 *  Author: Geoffrey P. Gaudreault
 *  http://www.neurofuzzy.net
 *  
 *  This code is free, provided AS-IS with no warranty expressed or implied.  Use at your own risk.
 *  If you find errors or bugs in this code, please contact me at interested@zanpo.com
 *  If you enhance this code in any way, please send me an update.  Thank you!
 *
 *  Version: 0.31a
 *  Last Updated: 9/09/2006 
 * 
 *	NOTE: ENTER YOUR API ID AND SECRET KEY BELOW!!!
 *
 */ 

class s3 {

	// US Buckets:
	// http://s3.amazonaws.com/bucket and http://s3.amazonaws.com/bucket/key
	//
	// EU Buckets: 
	// http://bucket.s3.amazonaws.com and http://bucket.s3.amazonaws.com/key

	// The API access point URL
	var $S3_URL = "http://s3.amazonaws.com/";

	// list of valid actions (validation not implemented yet)
	var $verbs = array("GET"=>1, "DELETE"=>1, "PUT"=>1);

	// set to true to echo debug info
	var $_debug = false;

	// Your API key ID
	var $keyId = AWS_KEY;

	// Your API Secret Key
	var $secretKey = AWS_SEC;

	// Default action
	var $_verb = "GET";

	// Default ACL
	var $_acl = "private";

	// Default content type
	var $_contentType = "image/jpeg";

	// Default response content type
	var $_responseContentType = "text/xml";

	// Bucket object name prefix
	var $prefix = "";

	// Bucket list marker (useful for pagination)
	var $marker = "";

	// Number of keys to retrieve in a list
	var $max_keys = "";

	// List delimiter
	var $delimiter = "";

	// Your default bucket name
	var $bucketname = "footprint";

	// Your current object name
	var $objectname = "temp";

   /**
	* Constructor: Amazon S3 REST API implementation
	*/
	function s3($options = NULL)
	{
		if(!defined('DATE_RFC822_S3'))
		{
			define('DATE_RFC822_S3', 'D, d M Y H:i:s T');
		}

		$this->httpDate = gmdate(DATE_RFC822_S3);

		$available_options = array("acl", "contentType");

		if (is_array($options))
		{
			foreach ($options as $key => $value)
			{
				$this->debug_text("Option: $key");

				if (in_array($key, $available_options) )
				{
					$this->debug_text("Valid Config options: $key");

					$property = '_'.$key;

					$this->$property = $value;

					$this->debug_text("Setting $property to $value");
				}
				else
				{
					$this->debug_text("ERROR: Config option: $key is not a valid option");
				}
			}
		}

		$this->hasher = new Crypt_HMAC($this->secretKey, "sha1");
	}

   /**
	* Method: setBucketName
	* Sets the name of the default bucket
	*/
	function setBucketName ($bucket) 
	{
		$this->bucketname = $bucket;
	}

   /**
	* Method: getBucketName
	* Gets the name of the default bucket
	*/
	function getBucketName ()
	{
		return $this->bucketname;
	}

   /**
	* Method: setBucketName
	* Sets the name of the default bucket
	*/
	function setObjectName ($object)
	{
		$this->objectname = $object;
	}

   /**
	* Method: getObjectName
	* Gets the name of the current object
	*/
	function getObjectName ()
	{
		return $this->objectname;
	}

   /**
	* Method: setContentType
	* Sets the content type of the object
	*/
	function setContentType ($ct)
	{
		$this->_contentType = $ct;
	}

   /**
	* Method: getContentType
	* Gets the content type of the object
	*/
	function getContentType () 
	{
		return $this->_contentType;
	}

   /**
	* Method: getResponseContentType
	* Gets the content type of the response
	*/
	function getResponseContentType () 
	{
		return $this->_responseContentType;
	}

   /**
	* Method: setAcl
	* sets the acces control policy for the current object
	*/
	function setAcl ($acl)
	{
		$this->_acl = $acl;
	}

   /**
	* Method: getAcl
	* gets the acces control policy for the current object
	*/
	function getAcl ()
	{
		return $this->_acl;
	}	

   /**
	* Method: sendRequest
	* Sends the request to S3
	* 
	* Parameters:
	* resource 		- The name of the resource to act upon
	* verb 			- The action to apply to the resource (GET, PUT, DELETE, HEAD)
	* objectdata 	- the source data (body) of the resource (only applies to objects)
	* acl 			- the access control policy for the resource
	* contentType 	- the contentType of the resource (only applies to objects)
	* metadata 		- any metadata you want to save in the header of the object
	*/
	function sendRequest ($resource, $verb = NULL, $objectdata = NULL, $acl = NULL, $contentType = NULL, $metadata = NULL)
	{
		if ($verb == NULL)
		{
			$verb = $this->verb;
		}

		if ($acl == NULL)
		{
			$aclstring = "";
		}
		else
		{
			$aclstring = "x-amz-acl:$acl\n";
		}

		$contenttypestring = "";

		if ($contentType != NULL && ($verb == "PUT") && ($objectdata != NULL) && ($objectdata != ""))
		{
			$contenttypestring = "$contentType";
		}

		// update date / time on each request
		$this->httpDate = gmdate(DATE_RFC822_S3);

		$httpDate = $this->httpDate;

		$paramstring = "";

		$delim = "?";

		if (strlen($this->prefix))
		{
			$paramstring .= $delim."prefix=".urlencode($this->prefix);
			$delim = "&";
		}

		if (strlen($this->marker))
		{
			$paramstring .= $delim."marker=".urlencode($this->marker);
			$delim = "&";
		}

		if (strlen($this->max_keys))
		{
			$paramstring .= $delim."max-keys=".$this->max_keys;

			$delim = "&";
		}
		
		if (strlen($this->delimiter))
		{
			$paramstring .= $delim."delimiter=".urlencode($this->delimiter);

			$delim = "&";
		}
		
		$this->debug_text("HTTP Request sent to: " . $this->S3_URL . $resource . $paramstring);

		$req = new HTTP_Request($this->S3_URL . $resource . $paramstring);

		$req->setMethod($verb);

		if (($objectdata != NULL) && ($objectdata != ""))
		{
			$contentMd5 = $this->hex2b64(md5($objectdata));

			$req->addHeader("CONTENT-MD5", $contentMd5);

			$this->debug_text("MD5 HASH OF DATA: " . $contentMd5);

			$contentmd5string = $contentMd5;
		}
		else
		{
			$contentmd5string = "";
		}

		if (strlen($contenttypestring))
		{
			$this->debug_text("Setting content type to $contentType");

			$req->addHeader("CONTENT-TYPE", $contentType);
		}

		$req->addHeader("DATE", $httpDate);

		if (strlen($aclstring))
		{
			$this->debug_text("Setting acl string to $acl");

			$req->addHeader("x-amz-acl", $acl);
		}

		$metadatastring = "";

		if (is_array($metadata))
		{
			ksort($metadata);

			$this->debug_text("Metadata found.");

			foreach ($metadata as $key => $value)
			{
				$metadatastring .= "x-amz-meta-".$key.":".trim($value)."\n";

				$req->addHeader("x-amz-meta-".$key, trim($value));

				$this->debug_text("Setting x-amz-meta-$key to '$value'");
			}
		}

		if (($objectdata != NULL) && ($objectdata != ""))
		{
			# $req->setBody($objectdata);
			$req->addRawPostData($objectdata);
		}

		/*
		if ( strlen( $contenttypestring ) )
		{
			//$contenttypestring = $contenttypestring.",application/x-www-form-urlencoded";
		}
		else if ( $verb == "PUT" )
		{
			//$contenttypestring = "application/x-www-form-urlencoded";
		}
		*/
			
		$stringToSign = "$verb\n$contentmd5string\n$contenttypestring\n$httpDate\n$aclstring$metadatastring/$resource";
		
		/*
		echo('--------------------------------------<br>');
		echo('verb:  '.$verb.'<br>');
		echo('md5:   '.$contentmd5string.'<br>');
		echo('type:  '.$contenttypestring.'<br>');
		echo('date:  '.$httpDate.'<br>');
		echo('acl:   '.$aclstring.'<br>');
		echo('meta:  '.$metadatastring.'<br>');
		echo('thing: '.$resource.'<br>');
		echo('<br>--------------------------------------');
		*/
		
		$this->debug_text("Signing String: ".var_export($stringToSign,true));

		$signature = $this->hex2b64($this->hasher->hash($stringToSign));

		$this->debug_text("Signature: $signature");
		
		$req->addHeader("Authorization", "AWS " . $this->keyId . ":" . $signature);

		$req->sendRequest();		

		$this->_responseContentType = $req->getResponseHeader("content-type");

		if (strlen($req->getResponseBody()))
		{
			$this->debug_text($req->getResponseBody());
			return $req->getResponseBody();
		}
		else 
		{
			$this->debug_text($req->getResponseHeader());

			return $req->getResponseHeader();
		}
	}

   /**
	* Method: getBuckets
	* Returns a list of all buckets
	*/
	function getBuckets ()
	{
		return $this->sendRequest("","GET");
	}

   /**
	* Method: getBucket
	* Gets a list of all objects in the default bucket
	*/
	function getBucket ($bucketname = NULL)
	{
		if ($bucketname == NULL)
		{
			return $this->sendRequest($this->bucketname, "GET");
		} 
		else
		{
			return $this->sendRequest($bucketname, "GET");
		}
	}
	
   /**
	* Method: getObjects
	* Gets a list of all objects in the specified bucket
	* 
	* Parameters:
	* prefix - (optional) Limits the response to keys which begin with the indicated prefix. You can use prefixes to separate a bucket into different sets of keys in a way similar to how a file system uses folders.
	* marker - (optional) Indicates where in the bucket to begin listing. The list will only include keys that occur lexicographically after marker. This is convenient for pagination: To get the next page of results use the last key of the current page as the marker.
	* max-keys - (optional) The maximum number of keys you'd like to see in the response body. The server may return fewer than this many keys, but will not return more.
	*/
	function getObjects ($bucketname, $prefix = NULL, $marker = NULL, $max_keys = NULL, $delimiter = NULL)
	{
		if ($prefix != NULL)
		{
			$this->prefix = $prefix;
		} 
		else
		{
			$this->prefix = "";
		}

		if ($marker != NULL)
		{
			$this->marker = $marker;
		}
		else
		{
			$this->marker = "";
		}

		if ($max_keys != NULL)
		{
			$this->max_keys = $max_keys;
		}
		else
		{
			$this->max_keys = "";
		}

		if ($delimiter != NULL)
		{
			$this->delimiter = $delimiter;
		}
		else
		{
			$this->delimiter = "";
		}

		if ($bucketname != NULL)
		{
			return $this->sendRequest($bucketname,"GET");
		}
		else
		{
			return false;
		}
	}

   /**
	* Method: getObjectInfo
	* Get header information about the object. The HEAD operation is used to retrieve information about a specific object, 
	* without actually fetching the object itself
	* 
	* Parameters:
	* objectname - The name of the object to get information about
	* bucketname - (optional) the name of the bucket containing the object.  If none is supplied, the default bucket is used
	*/
	function getObjectInfo ($objectname, $bucketname = NULL)
	{
		if ($bucketname == NULL)
		{
			$bucketname = $this->bucketname;
		}

		return $this->sendRequest($bucketname."/".$objectname,"HEAD");
	}

   /**
	* Method: getObject
	* Gets an object from S3
	* 
	* Parameters:
	* objectname - the name of the object to get
	* bucketname - (optional) the name of the bucket containing the object.  If none is supplied, the default bucket is used
	*/
	function getObject ($objectname, $bucketname = NULL)
	{
		if ($bucketname == NULL)
		{
			$bucketname = $this->bucketname;
		}

		return $this->sendRequest($bucketname."/".$objectname,"GET");
	}

   /**
	* Method: putBucket
	* Creates a new bucket in S3
	*
	* Parameters:
	* bucketname - the name of the bucket.  It must be unique.  No other S3 users may have this bucket name
	*/
	function putBucket ($bucketname)
	{
		return $this->sendRequest($bucketname,"PUT");
	}

   /**
	* Method: putObject
	* Puts an object into S3
	* 
	* Parameters:
	* objectname 	- the name of the object to put
	* objectdata 	- the source data (body) of the resource (only applies to objects)
	* bucketname 	- (optional) the name of the bucket containing the object.  If none is supplied, the default bucket is used
	* acl 			- the access control policy for the resource
	* contentType 	- the contentType of the resource (only applies to objects)
	* metadata 		- any metadata you want to save in the header of the object
	*/
	function putObject ($objectname, $objectdata, $bucketname = NULL, $acl = NULL, $contentType = NULL, $metadata = NULL)
	{
		if ($bucketname == NULL)
		{
			$bucketname = $this->bucketname;
		}

		if ($acl == NULL || $acl == "")
		{
			$acl = $this->_acl;
		}

		if ($contentType == NULL || $contentType == "")
		{
			$contentType = $this->_contentType;
		}

		if ($objectdata != NULL)
		{
			return $this->sendRequest($bucketname."/".$objectname, "PUT", $objectdata, $acl, $contentType, $metadata);
		}
		else
		{
			return false;
		}
	}

   /**
	* Method: deleteBucket
	* Deletes bucket in S3.  The bucket name will fall into the public domain.
	*/
	function deleteBucket ($bucketname)
	{
		return $this->sendRequest($bucketname, "DELETE");
	}

   /**
	* Method: deleteObject
	* Deletes an object from S3
	* 
	* Parameters:
	* objectname - the name of the object to delete
	* bucketname - (optional) the name of the bucket containing the object.  If none is supplied, the default bucket is used
	*/
	function deleteObject ($objectname, $bucketname = NULL)
	{
		if ($bucketname == NULL)
		{
			$bucketname = $this->bucketname;
		}		
		
		return $this->sendRequest($bucketname."/".$objectname, "DELETE");
	}

   /**
	* Method: hex2b64
	* Utility function for constructing signatures
	*/
	function hex2b64($str)
	{
		$raw = '';

		for ($i=0; $i < strlen($str); $i+=2)
		{
			$raw .= chr(hexdec(substr($str, $i, 2)));
		}

		return base64_encode($raw);
	}
	
   /**
    * Method: Create Query String Authentication Query String
	* Utility Function for constructing signatures
	*
	* Author: Iarfhlaith Kelly
	*  Email: ik at webstrong dot net
	*   Date: 29JAN08
	*
	* @param: string	- $bucket	- The name of the S3 bucket
	* @param: string	- $key		- The name of the key within the bucket
	* @param: timestamp	- $expires	- The number of seconds the querystring will be valid
	*
	*/
	function qStrAuthentication($bucket, $key, $expires)
	{
		$expires      = time() + $expires;
		$stringToSign = "GET\n\n\n$expires\n/$bucket/$key";
		
		$sg = urlencode($this->hex2b64($this->hasher->hash($stringToSign)));
		$qs = 'AWSAccessKeyId='.AWS_KEY.'&Expires='.$expires.'&Signature='.$sg;
		
		return($qs);
	}
	
   /**
	* Method: debug_text
	* Echoes debug information to the browser.  Set this->debug to false for production use
	*/
	function debug_text($text)
	{
		if ($this->_debug)
		{
			echo '<pre>';
			print_r($text);
			echo '</re>';
			print( "\n" );
		}
		return(true);
	}
}
?>