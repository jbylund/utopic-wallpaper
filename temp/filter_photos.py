#!/usr/bin/python
import json
import sys
import random
group_photos = json.load(open('group_photos.json','r'))

keys_to_save = set()
keys_to_save.add('width_o')
keys_to_save.add('height_o')
keys_to_save.add('title')
keys_to_save.add('url_m')
keys_to_save.add('url_o')
keys_to_save.add('ownername')
keys_to_save.add('owner')

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
  if int(photo.get('height_o',0)) < 1080*2:
    continue
  if int(photo.get('width_o',0)) < 1920*2:
    continue
  for key in photo.keys():
    if key not in keys_to_save:
      photo.pop(key)
  filtered_photos.append(photo)

for photo in random.sample(filtered_photos,len(filtered_photos)):
  try:
    print '<img border="0" src="{}" alt="{} by {}" width="{}" height="{}">'.format(
        photo['url_m'],
        photo['title'].encode('utf8').title(),
        photo['ownername'].encode('utf8'),
        photo.get('width_m',500),
        photo.get('height_m',375)
      )
  except Exception as e:
    print photo
    print e
    raise
    sys.exit(1)
