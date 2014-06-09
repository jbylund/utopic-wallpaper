#!/usr/bin/python
from hashlib import sha1
import binascii
import hmac
import inspect
import random
import string
import sys
import time
import urllib
import urllib2
import subprocess
import pprint
import json
import urlparse

key = "bacd91c509ed4836597e3b89f1ed4d94"
secret = "06a824de2d7a4663"
global_nonce = None
timestamp = None

def escape(s):
    return urllib.quote(s, safe='~')

def get_nonce():
  global global_nonce
  if global_nonce is None:
    global_nonce = ''.join(random.choice(string.digits + string.ascii_letters) for _ in range(10))
  return global_nonce

def get_timestamp():
  global timestamp
  if timestamp is None:
    timestamp = int(time.time())
  return timestamp

def sign_request(base_string, consumer_secret="06a824de2d7a4663", token_secret=""):
  key = "{}&{}".format(consumer_secret,token_secret)
  hashed = hmac.new(key, base_string, sha1)
  signature = binascii.b2a_base64(hashed.digest())[:-1]
  return signature

def make_query_string(idict):
  return "&".join(["{key}={val}".format(key=key,val=urllib.quote_plus(str(idict[key]))) for key in sorted(idict.iterkeys())])

def build_request(url,idict):
  idict.pop('oauth_signature',None)
  idict['oauth_consumer_key'] = 'bacd91c509ed4836597e3b89f1ed4d94'
  idict['oauth_signature_method'] = 'HMAC-SHA1'
  idict['oauth_nonce'] = get_nonce()
  idict['oauth_timestamp'] = get_timestamp()
  idict['oauth_version'] = 1.0
  query_string = make_query_string(idict)
  base_string = "{method}&{url}&{params}".format(
      method="GET", 
      url=urllib.quote_plus(url), 
      params=urllib.quote_plus(query_string)
    )
  token_secret = ""
  if "oauth_token_secret" in idict:
    token_secret = idict["oauth_token_secret"]
  signature = sign_request(base_string,token_secret=token_secret)
  idict['oauth_signature'] = signature
  query_string = make_query_string(idict)
  return "{}?{}".format(url,query_string)

try:
  p_dict = dict()
  try:
    p_dict = json.load(open('flickr_auth.json','r'))
  except:
    url = "https://www.flickr.com/services/oauth/request_token"
    p_dict['oauth_callback'] = 'oob'
    signed_url = build_request(url,p_dict)
    response = urllib2.urlopen(signed_url).read()
    p_dict.update(dict(urlparse.parse_qsl(response)))
    url = "https://www.flickr.com/services/oauth/authorize"
    signed_url = build_request(url, p_dict)
    subprocess.call(["firefox",signed_url])
    print "What is the access code?"
    tmp = sys.stdin.readline()
    p_dict['oauth_verifier'] = tmp.strip()
    json.dump(p_dict,open("flickr_auth",'w'), sort_keys=True)
    p_dict.pop('oauth_callback',None)
    url = "https://www.flickr.com/services/oauth/access_token"
    signed_url = build_request(url, p_dict)
    response = urllib2.urlopen(signed_url).read()
    p_dict.update(dict(urlparse.parse_qsl(response)))
    json.dump(p_dict,open("flickr_auth",'w'), sort_keys=True)
  p_dict.pop('oauth_verifier',None)
  p_dict.pop('fullname',None)
  p_dict['format'] = "json"
  p_dict['nojsoncallback'] = 1
  p_dict['group_id'] = '2535978@N21'
  p_dict['method'] = "flickr.groups.pools.getPhotos"
  p_dict['per_page'] = 500
  url = "https://api.flickr.com/services/rest/"
  p_dict['extras'] = "description,license,date_upload,date_taken,owner_name,icon_server,original_format,last_update,geo,tags,machine_tags,o_dims,views,media,path_alias,url_m,url_o"
  signed_url = build_request(url, p_dict)
  response = urllib2.urlopen(signed_url).read()
  response_obj = json.loads(response)
  pp = pprint.PrettyPrinter(indent=4)
  json.dump(response_obj,open("group_photos.json","w"),sort_keys=True,indent=4)
except urllib2.HTTPError, e:
  print e.code
  print e.msg
  print e.headers
  print e.fp.read()

