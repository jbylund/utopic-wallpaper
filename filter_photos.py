#!/usr/bin/python
import json
import sys
import random

if len(sys.argv) > 1:
  random.seed(sys.argv[1])

group_photos = json.load(open('group_photos.json','r'))

from xml.sax.saxutils import escape, unescape
# escape() and unescape() takes care of &, < and >.
html_escape_table = {
  '"': "&quot;",
  "'": "&apos;"
}
html_unescape_table = {v:k for k, v in html_escape_table.items()}

def html_escape(text):
  return escape(text, html_escape_table)

def html_unescape(text):
  return unescape(text, html_unescape_table)


keys_to_save = set()
keys_to_save.add('width_o')
keys_to_save.add('height_o')
keys_to_save.add('title')
keys_to_save.add('url_m')
keys_to_save.add('url_o')
keys_to_save.add('ownername')
keys_to_save.add('owner')
keys_to_save.add('id')

owners_seen = set()
filtered_photos = list()

for photo in group_photos['photos']['photo']:
  if photo['owner'] in owners_seen:
    continue
  owners_seen.add(photo['owner'])
#  print owners_seen
  if 'height_o' not in photo:
    continue
    print json.dumps(photo)
  if int(photo.get('height_o',0)) < 1440:
    continue
  if int(photo.get('width_o',0)) < 2560:
    continue
  for key in photo.keys():
    if key not in keys_to_save:
      photo.pop(key)
  filtered_photos.append(photo)

poolid = "2535978@N21"
num_photos = 0
for photo in random.sample(filtered_photos,len(filtered_photos)):
  try:
    human_title = "{} by {}".format(
        html_escape(photo.get('title',"?").encode('ascii', 'xmlcharrefreplace').title()),
        html_escape(photo.get('ownername',"?").encode('ascii', 'xmlcharrefreplace'))
      )
    photo_page = "https://www.flickr.com/photos/{owner}/{pid}/in/pool-{poolid}".format(
        owner=photo.get('owner'),
        pid=photo.get('id'),
        poolid=poolid
      )
    print '<img border="0" src="{src}" title="{title}" alt="{title}" width="{width}" height="{height}">'.format(
        url = photo_page,
        src = photo['url_m'],
        title = human_title,
        width = photo.get('width_m',500),
        height = photo.get('height_m',375)
      )
    num_photos += 1
  except Exception as e:
    print photo
    print e
    raise
    sys.exit(1)
  if num_photos > 9:
    break
