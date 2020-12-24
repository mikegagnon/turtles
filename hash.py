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
relhashpath = "../hash"

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
	f.close()
	for word in text.split(): 
		if word[0] == "#":
			companions[name].append(word)
			if word in tags:
				tags[word].append(name)
			else:
				tags[word] = [name]
	#print(companions)

# extract hashtags from link.txt, return as set, thesetags
# todo rm this comment: thesetags[hashtag] = array of filenames containing that hashtag
def gettags(name):
	thesetags = set([])
	f = open(name)
	text = f.read().replace('\n', ' ')
	f.close()
	for word in text.split(): 
		if word[0] == "#":
			thesetags.add(word[1:])
	return thesetags

def newtagpage(word, filenames):
    #tags = []
    #for fname in filenames:

    filenames = sorted(list(set(filenames)))

    html = f"<h1>#{word}</h1><ol>"
    for fname in filenames:
    	comp = companions[fname]
    	indexname = os.path.dirname(fname) + "/index.html"
    	indexname = remove_prefix(indexname, realpath + "/") 
    	comps = ""
    	for c in comp:
    		cname = relhashpath + "/" + c[1:] + ".html"
    		cname = remove_prefix(cname, rootpath + "/") 
    		comps += f"<a href='../{cname}'>{c}</a> "

    	html += f"<li><a style='font-size: 200%' href='../main/{indexname}'>{indexname}</a> {comps}</li>"
    html += "</ol>"

    tagpagename = hashpath + "/" + word + ".html"
    f = open(tagpagename, "w")
    f.write(html)
    f.close()

def hlink(rhashpath, tag):
    print(rhashpath)
    return f'<a href="{rhashpath}/{tag}.html">#{tag}</a> '

def sub(filename, thesetags):
    f = open(filename, "r")
    text = f.read()
    f.close()
    #tagpagename = hashpath + "/" + word + ".html"

    thesetags = [t[1:] for t in thesetags]

    #cruft fixed_content = re.sub(r"(#([0-9A-Za-z\-]+))", r"<a href='" + hashpath + r"/\2.html'>#\2</a>", text)
    addtags = " ".join([hlink(relhashpath, t) for t in sorted(list(thesetags))])
    print(addtags)
    fixed_content = re.sub("#hashtags.*foohash", "#hashtags " + addtags + "</div><span id='foohash", text)


    #fixed_content = text
    #print(fixed_content)
    #print(filename)
    f = open(filename, "w")
    f.write(fixed_content)
    f.close()

# Returns list of hashtags, recursively collected from this path and all subdirs
def propagate(path):
	linktxtfilename = path + "/link.txt"
	thesetags = gettags(linktxtfilename)

	# dirs = list of dir paths inside path
	dirs = [ os.path.join(path, name) for name in os.listdir(path) if os.path.isdir(os.path.join(path, name))]
	for dirpath in dirs:
		if "/." not in dirpath:
			subtags = propagate(dirpath)
			thesetags = thesetags | subtags

	#print(dirs)
	#print(path)
	#print(thesetags)
	#print()

	aggtags = " ".join(["#" + t for t in sorted(list(thesetags))])
	#print(path)
	outfname = path + "/robolink.txt"
	#print(outfname)
	f = open(outfname, "w")
	f.write(aggtags)
	f.close()

	return thesetags

# main

# First, propagate the hashtags up the hierarchy, withink the link.txt files
propagate(realpath)

# Then, process each link file
filenames = glob.glob(realpath + "/**/robolink.txt", recursive=True)
for name in filenames: 
	print(name)
	process(name)

# Generate a new hash page for each tag
for tag in tags:
	word = tag[1:]
	newtagpage(word, tags[tag])

# Search and replace each .html file to hyperlink each hashtag
filenames = glob.glob(realpath + "/**/index.html", recursive=True)
print(companions)
for name in filenames:
    rname = os.path.dirname(name) + "/robolink.txt"
    print(rname)
    if rname in companions:
        thesetags = companions[rname]
        print("x", thesetags)
    else:
        thesetags = []
    sub(name, thesetags)
