#!/usr/bin/env zsh

rm -rf ./output
mkdir ./output
wget --directory-prefix=output/ --html-extension --convert-links --recursive --level=10 --page-requisites --timestamping --adjust-extension --no-host-directories http://localhost:8000

# Grab the 404 page
wget --directory-prefix=output/ --html-extension --convert-links --timestamping --adjust-extension --no-host-directories http://localhost:8000/404

# Grab the general error page
wget --directory-prefix=output/ --html-extension --convert-links --timestamping --adjust-extension --no-host-directories http://localhost:8000/error

# For some reason Laravel adds this.  It is for Cloudflare, but things get wonky if I upload this.
rm -rf ./output/cdn-cgi/

prev_commit=$(git log --oneline | head -n 1)
git add output 
git commit -am "Build: $prev_commit"
git push

aws s3 sync ./output s3://chrisdempewolf.com --delete | tee "./storage/logs/s3_sync_$(echo prev_commit | awk '{print $1}').log"
