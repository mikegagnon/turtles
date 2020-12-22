# python 3
#
# Convert all hashtags to links

import os
import glob
import sys
import re
rootpath = sys.argv[1]
realpath = sys.argv[1] + "/main"
hashpath = sys.argv[1] + "/hash"

# tags[hashtag] = array of filenames containing that hashtag
tags = {}

# companions[filename] = array of hashtags in that file
companions = {}

# https://stackoverflow.com/questions/16891340/remove-a-prefix-from-a-string
def remove_prefix(text, prefix):
    if text.startswith(prefix):
        return text[len(prefix):]
    return text  # or whatever


def process(name):
	companions[name] = []
	f = open(name)
	text = f.read().replace('\n', ' ')
	for word in text.split(): 
		if word[0] == "#":
			companions[name].append(word)
			if word in tags:
				tags[word].append(name)
			else:
				tags[word] = [name]

def newtagpage(word, filenames):
	#tags = []
	#for fname in filenames:

	html = f"<h1>#{word}</h1><ol>"
	for fname in filenames:
		comp = companions[fname]
		indexname = os.path.dirname(fname) + "/index.html"
		indexname = remove_prefix(indexname, realpath + "/") 
		comps = ""
		for c in comp:
			cname = hashpath + "/" + c[1:] + ".html"
			cname = remove_prefix(cname, rootpath + "/") 
			comps += f"<a href='../{cname}'>{c}</a> "

		html += f"<li><a href='../main/{indexname}'>{indexname}</a> {comps}</li>"
	html += "</ol>"

	tagpagename = hashpath + "/" + word + ".html"

	f = open(tagpagename, "w")
	f.write(html)
	f.close()

def sub(filename):
	f = open(filename, "r")
	text = f.read()
	f.close()
	tagpagename = hashpath + "/" + word + ".html"

	fixed_content = re.sub(r"(#([\d\w\.]+))", r"<a href='" + hashpath + r"/\2.html" + r"'>#\2</a>", text)
	f = open(filename, "w")
	f.write(fixed_content)
	f.close()


filenames = glob.glob(realpath + "/**/link.txt", recursive=True)
for name in filenames: 
    process(name)

for tag in tags:
	word = tag[1:]
	newtagpage(word, tags[tag])

filenames = glob.glob(realpath + "/**/index.html", recursive=True)
for name in filenames: 
    sub(name)
