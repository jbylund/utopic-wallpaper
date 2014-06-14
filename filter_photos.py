#!/usr/bin/python
import json
import sys
import random
import titlecase

subdomain = sys.argv[1].split(".")[0]
if len(sys.argv) > 2:
  random.seed(sys.argv[2])

config = json.load(open("config.json"))
if subdomain not in config:
  sys.exit(1)

group_photos = json.load(open('{}.json'.format(subdomain),'r'))

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
keys_to_save.add('url_n')
keys_to_save.add('url_h')
keys_to_save.add('url_o')
keys_to_save.add('ownername')
keys_to_save.add('owner')
keys_to_save.add('id')

owners_seen = set()
filtered_photos = list()

res_x = config[subdomain]['res_x']
res_y = config[subdomain]['res_y']

for photo in group_photos['photos']['photo']:
  if photo['owner'] in owners_seen:
    continue
  owners_seen.add(photo['owner'])
#  print owners_seen
  if 'height_o' not in photo:
    continue
  if int(photo.get('height_o',0)) < 1600:
    continue
  if int(photo.get('width_o',0)) < 2560:
    continue
  ratio = float(photo.get('width_o',0)) / float(photo.get('height_o',1))
  if ratio > float(res_x + 1) / float(res_y) or ratio < float(res_x - 1) / float(res_y): # this could be considered a little strict
    continue
  for key in photo.keys():
    if key not in keys_to_save:
      photo.pop(key)
  filtered_photos.append(photo)

poolid = config[subdomain]['group']
num_photos = 0
for photo in random.sample(filtered_photos,len(filtered_photos)):
  try:
    human_title = "{} by {}".format(
        html_escape(titlecase.titlecase(photo.get('title',"?")).encode('ascii', 'xmlcharrefreplace')),
        html_escape(photo.get('ownername',"?").encode('ascii', 'xmlcharrefreplace'))
      )
    photo_page = "https://www.flickr.com/photos/{owner}/{pid}/in/pool-{poolid}".format(
        owner=photo.get('owner'),
        pid=photo.get('id'),
        poolid=poolid
      )
    img_tag = '<img class="draggable" border="0" src="{src}" title="{title}" alt="{title}" style="max-width:320px;max-height:320px;">'.format(
        url = photo_page,
        src = photo['url_m'],
        title = human_title,
      )
    a_tag = '<a href="{src}" rel="lightbox-journey" title="{title}">{img_tag}</a>'.format(
        src = photo.get('url_h',photo.get('url_o')),
        title = human_title,
        img_tag = img_tag
      )
    print a_tag
    num_photos += 1
  except Exception as e:
    print photo
    print e
    raise
    sys.exit(1)
