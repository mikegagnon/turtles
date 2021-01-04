import os
import sys
import json
rootpath = sys.argv[1]
realpath = sys.argv[1] + "/main"
hashpath = sys.argv[1] + "/hash"


final_json = {}

with open(hashpath + "/hash-agg.json") as f:
    hash_agg_json = json.load(f)
    final_json["hash_agg_json"] = hash_agg_json["word"]

# https://stackoverflow.com/questions/2212643/python-recursive-folder-read
walk_dir = realpath

print('walk_dir = ' + walk_dir)

for root, subdirs, files in os.walk(walk_dir):
    #print(root, subdirs, files)
    d = os.path.relpath(root, realpath)
    print(d)
    
    final_json[d] = {}
    hname = root + "/hashtags.json"
    print(hname)
    if os.stat(hname).st_size == 0:
        final_json[d]["hashtags"] = hash_agg_json["friendly_companions"][d]
    else:
        with open(hname, 'r') as hf:
            final_json[d]["hashtags"] = json.load(hf)
    with open(root + "/index.json", 'r') as iff:
        final_json[d]["index"] = json.load(iff)

jstr = json.dumps(final_json, indent=4, sort_keys=True)

with open(rootpath + "/agg.json", "w") as f:
    f.write(jstr)


    #continue

    #print('--\nroot = ' + root)
    #list_file_path = os.path.join(root, 'my-directory-list.txt')
    #print('list_file_path = ' + list_file_path)

    # with open(list_file_path, 'wb') as list_file:
    #     for subdir in subdirs:
    #         print('\t- subdirectory ' + subdir)

    #     for filename in files:
    #         file_path = os.path.join(root, filename)

    #         print('\t- file %s (full path: %s)' % (filename, file_path))

    #         with open(file_path, 'rb') as f:
    #             f_content = f.read()
    #             list_file.write(('The file %s contains:\n' % filename).encode('utf-8'))
    #             list_file.write(f_content)
    #             list_file.write(b'\n')