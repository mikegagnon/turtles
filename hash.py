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
print(realpath)

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
	#print(contents)
	for word in text.split(): 
		if word[0] == "#":
			companions[name].append(word)
			if word in tags:
				tags[word].push(name)
			else:
				tags[word] = [name]

def newtagpage(word, filenames):
	#tags = []
	#for fname in filenames:

	html = f"<h1>#{word}</h1><ol>"
	for fname in filenames:
		comp = companions[fname]
		#print(fname)
		indexname = os.path.dirname(fname) + "/index.html"
		#print(indexname)
		indexname = remove_prefix(indexname, realpath + "/") 
		comps = ""
		for c in comp:
			cname = hashpath + "/" + c[1:] + ".html"
			cname = remove_prefix(cname, rootpath + "/") 
			print(cname)
			comps += f"<a href='../{cname}'>{c}</a> "

		html += f"<li><a href='../main/{indexname}'>{indexname}</a> {comps}</li>"
	html += "</ol>"

	tagpagename = hashpath + "/" + word + ".html"

	f = open(tagpagename, "w")
	f.write(html)
	f.close()


	#print(html)

def sub(filename):
	f = open(filename, "r")
	text = f.read()
	f.close()
	tagpagename = hashpath + "/" + word + ".html"

	fixed_content = re.sub(r"(#([\d\w\.]+))", r"<a href='" + hashpath + r"/\2.html" + r"'>#\2</a>", text)
	f = open(filename, "w")
	f.write(fixed_content)
	f.close()
	print(fixed_content)


# 	import re
# text = '<p>Contents :</p><a href="https://w3resource.com">Python Examples</a><a href="http://github.com">Even More Examples</a>'
# urls = re.findall('http[s]?://(?:[a-zA-Z]|[0-9]|[$-_@.&+]|[!*\(\),]|(?:%[0-9a-fA-F][0-9a-fA-F]))+', text)
# print("Original string: ",text)
# print("Urls: ",urls)


filenames = glob.glob(realpath + "/**/link.txt", recursive=True)
for name in filenames: 
    #print(name) 
    process(name)

#print(tags)

for tag in tags:
	#print(tag)
	word = tag[1:]
	#print(word)
	newtagpage(word, tags[tag])

filenames = glob.glob(realpath + "/**/index.html", recursive=True)
for name in filenames: 
    #print(name) 
    sub(name)
