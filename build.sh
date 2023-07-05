#!/usr/bin/env zsh

rm -rf ./output
mkdir ./output
wget --directory-prefix=output/ --html-extension -k -r -l 10 -p -N -F -nH http://localhost:8000
cp -R ./public/assets/js ./output/assets/js

# For some reason Laravel adds this.  It is for Cloudflare, but things get wonky if I upload this.
rm -rf ./output/cdn-cgi/

git add output 
git commit -am "Build: $(git log --oneline | head -n 1)"
git push

# Following is obsolete, since Cloudflare automagically makes all paths extensionless
# Remove ".html" extension from files
# for f in $(find ./output -type f ! -name '.git'); do LC_CTYPE=C && LANG=C && mv "$f" $(echo $f | sed 's/\.html//'); done

# Rename links within files to match extensionless format
# TODO: convert this whole script to Python and go through each file above and rename each link for each file.  This will break any appearance of ".html" that is not an internal link.
#
# for f in $(find ./output -type f ! -name '.git'); do LC_CTYPE=C && LANG=C && sed -i '' 's/\.html//g' "$f"; done

