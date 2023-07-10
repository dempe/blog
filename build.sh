#!/usr/bin/env zsh

prev_commit=$(git log --oneline | head -n 1)
prev_commit_hash="$(echo $prev_commit | awk '{print $1}')"
log_file="./storage/logs/build_$prev_commit_hash.log"

echo "Commit = $prev_commit"
echo "Logging to $log_file"

rm -rf ./output
mkdir ./output
wget --directory-prefix=output/ --html-extension --convert-links --recursive --level=10 --page-requisites --timestamping --adjust-extension --no-host-directories http://localhost:8000 | tee -a "$log_file"

# Grab the 404 page
wget --directory-prefix=output/ --html-extension --convert-links --timestamping --adjust-extension --no-host-directories http://localhost:8000/404 | tee -a "$log_file"

# Grab the general error page
wget --directory-prefix=output/ --html-extension --convert-links --timestamping --adjust-extension --no-host-directories http://localhost:8000/error | tee -a "$log_file"

# For some reason Laravel adds this.  It is for Cloudflare, but things get wonky if I upload this.
rm -rf ./output/cdn-cgi/

git add output | tee -a "$log_file"
git commit -am "Build: $prev_commit" | tee -a "$log_file"
git push | tee -a "$log_file"

aws s3 sync ./output s3://chrisdempewolf.com --delete | tee -a "$log_file"
