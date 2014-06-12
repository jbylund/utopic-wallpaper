#!/usr/bin/python
import sys
import json

def name_to_number(iname):
  index = ord(iname[0].lower()) - ord('a') + 1
  year = index // 2 + 4
  month = 4 + 6 * (index % 2)
  return "{}.{}".format(year, str(month).rjust(2,"0"))

config = json.load(open("../config.json"))
release = sys.argv[1].split(".")[0]
if release in config:
  print "Ubuntu {} {} ({}) Wallpapers".format(release, config[release]['animal'], name_to_number(release)).title()
else:
  print "?"
