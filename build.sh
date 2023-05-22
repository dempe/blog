#!/usr/bin/env zsh

find ./output -type f ! -name '.git' -delete
wget --directory-prefix=output/ --html-extension -k -r -l 10 -p -N -F -nH http://localhost:8000

rm -rf ./output/cdn-cgi/

# Remove ".html" extension from files
for f in $(find ./output -type f ! -name '.git'); do LC_CTYPE=C && LANG=C && mv "$f" $(echo $f | sed 's/\.html//'); done

# Rename links within files to match extensionless format
# TODO: convert this whole script to Python and go through each file above and rename each link for each file.  This will break any appearance of ".html" that is not an internal link.
#
for f in $(find ./output -type f ! -name '.git'); do LC_CTYPE=C && LANG=C && sed -i '' 's/\.html//g' "$f"; done

git add output/* 
git commit -am "Build: $(git log --oneline | head -n 1)"
git push
